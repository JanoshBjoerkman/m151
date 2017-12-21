<?php
namespace M151\Controller;

use M151\Http\Request;
use M151\Application;
use M151\Model\AccountModel;
use M151\Model\EventModel;
use M151\Model\CourseModel;
use M151\Model\CourseDayModel;
use M151\Model\ClassModel;
use M151\View\ManageView;

class ManageController extends Controller
{
    // entry point for /manage
    public function manage(Request $request)
    {    
        $this->session->refresh();
        if($this->session->isLoggedIn() && $this->session->isAdmin())
        {
            $this->view = new ManageView();
            $account = new AccountModel(Application::getInstance()->getDBconnection());
            $email = $account->get_email_by_id($_SESSION['Account_ID']);

            $content = array(
                'Account_Email' => $email,
                'href_overview' => $this->getHref("manage?edit=overview"),
                'href_events' => $this->getHref("manage?edit=events"),
                'href_kurse' => $this->getHref("manage?edit=courses"),
                'href_benutzer' => $this->getHref("manage?edit=users"),
                'href_einstellungen' => $this->getHref("manage/settings"),
                'href_logout' => $this->getHref("logout")
            );

            if(empty($request->getParam('edit')))
            {
                $content = array_merge($content, $this->prepareOverviewContent());
            }
            else
            {
                switch($request->getParam('edit'))
                {
                    case 'overview':
                        $content = array_merge($content, $this->prepareOverviewContent());
                        break;
                    case 'events':
                        $content = array_merge($content, $this->prepareEventsContent());
                        break;
                    case 'courses':
                        $content = array_merge($content, $this->prepareCoursesContent());
                        break;
                    case 'users': 
                        $content = array_merge($content, $this->prepareUsersContent());
                        break;
                    default:
                        $content = array_merge($content, $this->prepareOverviewContent());
                }            
            }
            $this->view->show_manage($content);
        }
        else
        {
            // user is not admin
            $this->redirect_to("home");
        }
    }

    // general overview
    private function prepareOverviewContent()
    {
        $event = new EventModel(Application::getInstance()->getDBconnection());
        $next_event = $event->select_all("Event_start ASC");

        if(empty($next_event))
        {
            // no events
            $eventlink = $this->getHref("manage?edit=events");
            $body_content = $this->view->getOverviewContent_no_event($eventlink);
        }
        else
        {
            $course = new CourseModel(Application::getInstance()->getDBconnection());
            $numberOfCourses = count($course->get_courses_by_event_id($next_event[0]['ID']));
            $body_content = $this->view->getOverviewContent_has_event($next_event, $numberOfCourses);
        }

        return array(
            'tab_title' => 'Übersicht',
            'li_class_overview' => 'active',
            'li_class_events' => '',
            'li_class_kurse' => '',
            'li_class_benutzer' => '',
            'body_content' => $body_content
        );
    }

    // events overview
    private function prepareEventsContent()
    {
        $event = new EventModel(Application::getInstance()->getDBconnection());
        $allEvents = $event->select_all("Event_start ASC");
        if(empty($allEvents))
        {
            $body_content = $this->view->getEventsContent_no_events();
        }
        else
        {
            $body_content = $this->view->getEventsContent_has_events($allEvents);
        }

        return array(
            'tab_title' => 'Events',
            'li_class_overview' => '',
            'li_class_events' => 'active',
            'li_class_kurse' => '',
            'li_class_benutzer' => '',
            'body_content' => $body_content
        );
    }

    // coruses overview
    private function prepareCoursesContent()
    {
        $event = new EventModel(Application::getInstance()->getDBconnection());
        $events = $event->select_all("Titel ASC");
        $class = new ClassModel(Application::getInstance()->getDBconnection());
        $allClasses = $class->select_all();
        $body_content = "";
        if(empty($events) || empty($allClasses))
        {
            // user shouldn't be able to create courses if there isn't any event
            $body_content = "Bitte erstellen Sie zuerst einen Event und stellen Sie sicher, dass alle Klassen in der Datenbank definiert sind.";
        }
        else
        {
            $course = new CourseModel(Application::getInstance()->getDBconnection());
            $allCourses = $course->select_all("Name ASC, Event_ID ASC");
            $this->view = new ManageView();
            $body_content = $this->view->getCoursesContent($events, $allClasses, $allCourses);
        }
        return array(
            'tab_title' => 'Kurse',
            'li_class_overview' => '',
            'li_class_events' => '',
            'li_class_kurse' => 'active',
            'li_class_benutzer' => '',
            'body_content' => $body_content
        );
    }

    // users overview
    private function prepareUsersContent()
    {
        return array(
            'tab_title' => 'Benutzer',
            'li_class_overview' => '',
            'li_class_events' => '',
            'li_class_kurse' => '',
            'li_class_benutzer' => 'active',
            'body_content' => ''
        );
    }

    // settigns
    public function settings()
    {

    }

    // event functions
    public function create_new_event()
    {
        $this->session->refresh();
        if($this->allNewEventFieldsValid() && $this->adminAndLoggedInCheck())
        {
            $data = array(
                'Titel' => $this->escapeInput($_POST['Titel']),
                'Event_start' => date("Y-m-d H:i:s", strtotime($this->escapeInput($_POST['event_start']))),
                'Event_ende' => date("Y-m-d H:i:s", strtotime($this->escapeInput($_POST['event_ende']))),
                'Phase_1' => date("Y-m-d H:i:s", strtotime($this->escapeInput($_POST['phase1']))),
                'Phase_2' => date("Y-m-d H:i:s", strtotime($this->escapeInput($_POST['phase2']))),
                'Anmeldeschluss' => date("Y-m-d H:i:s", strtotime($this->escapeInput($_POST['anmeldeschluss']))),
                'visible' => isset($_POST['visible']) ? '1' : '0'
            );
            try
            {
                $event = new EventModel(Application::getInstance()->getDBconnection());
                $result = $event->new_event($data);
                if($result)
                {
                    $this->redirect_to("manage?edit=events");
                }
                else
                {
                    $this->view->show_error_message(
                        "Fehler",
                        "Leider ist etwas schiefgelaufen...",
                        "Fehler:",
                        "Bitte wenden Sie sich an den Administrator"
                    );
                }
            }
            catch(\Exception $e)
            {
                $this->view->show_error_message(
                    "Fehler",
                    "Leider ist etwas schiefgelaufen...",
                    "Fehler:",
                    "{$e->getMessage()}"
                );
            }                       
        }
        else
        {
            $this->view->show_error_message(
                "Eingabefehler",
                "Sie haben nicht alle Felder korrekt ausgefüllt",
                "Eingabefehler",
                "Der Vorgang wurde abgebrochen"
            );
        }
    }

    private function allNewEventFieldsValid()
    {
        // check if fields are set
        $valid = (isset($_POST['event_start']) && !empty($_POST['event_start']) &&
                    isset($_POST['event_ende']) && !empty($_POST['event_ende']) &&
                    isset($_POST['Titel']) && !empty($_POST['Titel']) &&
                    isset($_POST['phase1']) && !empty($_POST['phase1']) &&
                    isset($_POST['phase2']) && !empty($_POST['phase2']) &&
                    isset($_POST['anmeldeschluss']) && !empty($_POST['anmeldeschluss']));
        // check if fields are valid
        $valid &= (strtotime($_POST['event_start']) < strtotime($_POST['event_ende']));
        $valid &= (strtotime($_POST['phase1']) < strtotime($_POST['phase2']));
        $valid &= (strtotime($_POST['anmeldeschluss']) < strtotime($_POST['event_start']));
        $current_datetime = date("Y-m-d H:i:s");
        $valid &= ($current_datetime < strtotime($_POST['event_start']));
        $valid &= ($current_datetime < strtotime($_POST['event_ende']));
        $valid &= ($current_datetime < strtotime($_POST['phase1']));
        $valid &= ($current_datetime < strtotime($_POST['phase2']));
        $valid &= ($current_datetime < strtotime($_POST['anmeldeschluss']));
        return $valid;
    }

    public function delete_event()
    {
        $this->session->refresh();
        if($this->adminAndLoggedInCheck())
        {
            // has to be admin to delete
            $event = new EventModel(Application::getInstance()->getDBconnection());
            $where = array(
                'ID' => $_POST['ID']
            );
            if($event->delete($where))
            {
                echo "TRUE";
            }
            else
            {
                echo "FALSE";
            }
        }
    }

    public function refresh_events_table()
    {
        $this->session->refresh();
        if($this->adminAndLoggedInCheck())
        {
            $this->view = new ManageView();
            $event = new EventModel(Application::getInstance()->getDBconnection());
            $allEvents = $event->select_all();
            echo $this->view->getEventsTableRows($allEvents);
        }
    }

    public function change_event_visibility()
    {
        $this->session->refresh();
        if($this->adminAndLoggedInCheck())
        {
            try
            {
                $event = new EventModel(Application::getInstance()->getDBconnection());
                $result = $event->update(array(
                    'visible' => $_POST['visible'] == "true" ? 1 : 0
                ), array(
                    'ID' => $_POST['ID']
                ));
                if($result)
                {
                    echo "success";
                }
                else
                {
                    echo "ERROR: something went wrong";
                }
            }
            catch(\Exception $e)
            {
                echo "ERROR: unable to change event visibility";
            }
        }
    }

    // course functions
    public function create_new_course()
    {
        $this->session->refresh();
        if($this->adminAndLoggedInCheck())
        {
            if($this->validateNewcourse())
            {
                try
                {
                    // get current event ID
                    $event = new EventModel(Application::getInstance()->getDBconnection());
                    $query = array(
                        'Titel' => $_POST['events_dropdown']
                    );
                    $result = $event->select($query, TRUE);

                    // prepare data for table "Kurs"
                    $Event_ID = $result[0]['ID'];
                    $Teilnehmer_min = !empty($_POST['teilnehmer_min']) ? $_POST['teilnehmer_min'] : NULL;
                    $Teilnehmer_max = !empty($_POST['teilnehmer_max']) ? $_POST['teilnehmer_max'] : NULL;
                    $Preis_Mitglieder_rp = $_POST['preis_mitglieder'] * 100;
                    $Preis_Nichtmitglieder_rp = $_POST['preis_nichtmitglieder'] * 100;
                    $Besonderes = !empty($_POST['besonderes']) ? $_POST['besonderes'] : NULL;
                    
                    $data = array(
                        'Name' => $_POST['name'],
                        'Beschreibung' => $_POST['beschreibung'],
                        'Treffpunkt' => $_POST['treffpunkt'],
                        'Teilnehmer_min' => $Teilnehmer_min,
                        'Teilnehmer_max' => $Teilnehmer_max,
                        'Preis_Mitglieder_rp' => $Preis_Mitglieder_rp,
                        'Preis_Nichtmitglieder_rp' => $Preis_Nichtmitglieder_rp,
                        'Besonderes' => $Besonderes,
                        'Leitung' => $_POST['leitung'],
                        'Event_ID' => $Event_ID,
                    );
                    $course = new CourseModel(Application::getInstance()->getDBconnection());
                    $course->insert($data);

                    // prepare and insert data for table "Kurstag"
                    $Course_ID = $course->getLastInsertedID();
                    $new_course_day_set = true;
                    $current_course = 1;
                    $class = new ClassModel(Application::getInstance()->getDBconnection());
                    $class_container = $class->select_all();
                    while($new_course_day_set)
                    {
                        $class_min_ID = NULL;
                        $class_max_ID = NULL;
                        if(!empty($_POST['course_day_class_min-'."{$current_course}"]))
                        {
                            $class_min_ID = $this->getIDFromClassContainer($class_container, $this->escapeInput($_POST['course_day_class_min-'."{$current_course}"]));
                        }
                        if(!empty($_POST['course_day_class_max-'."{$current_course}"]))
                        {
                            $class_max_ID = $this->getIDFromClassContainer($class_container, $this->escapeInput($_POST['course_day_class_max-'."{$current_course}"]));
                        }
                        $data = array(
                            'Datum_Begin' => date("Y-m-d H:i:s", strtotime($this->escapeInput($_POST['course_day_begin-'."{$current_course}"]))),
                            'Datum_Ende' => date("Y-m-d H:i:s", strtotime($this->escapeInput($_POST['course_day_end-'."{$current_course}"]))),
                            'Klasse_min' => $class_min_ID,
                            'Klasse_max' => $class_max_ID,
                            'Kurs_ID' => $Course_ID,
                        );
                        $course_day = new CourseDayModel(Application::getInstance()->getDBconnection());
                        $course_day->new_course_day($data);
                        $current_course++;
                        $new_course_day_set = isset($_POST['course_day_begin-'."{$current_course}"]);
                    }
                }
                catch(\Exception $e)
                {
                    throw new \Exception("ERROR");
                }
                $this->redirect_to("manage?edit=courses");
            }
            else
            {
                $this->view->show_error_message(
                    "Eingabefehler",
                    "Sie haben nicht alle Felder korrekt ausgefüllt",
                    "Eingabefehler",
                    "Der Vorgang wurde abgebrochen"
                );
            }
        }
        else
        {
            $this->redirect_to("home");
        }
    }

    private function getIDFromClassContainer($container, $classdescription)
    {
        $results = array_column($container, 'ID', 'Klassenbezeichnung');
        return isset($results[$classdescription]) ? $results[$classdescription] : NULL;
    }

    private function validateNewcourse()
    {
        // course days must be in the corresponding event range
        $event = new EventModel(Application::getInstance()->getDBconnection());
        $query = array(
            'Titel' => $_POST['events_dropdown']
        );
        $result = $event->select($query, TRUE);
        $correspondingEvent = $result[0];

        // all required fields set?
        $validInput = (isset($_POST['events_dropdown']) && !empty($_POST['events_dropdown']));
        $validInput &= (isset($_POST['name']) && !empty($_POST['name']));
        $validInput &= (isset($_POST['beschreibung']) && !empty($_POST['beschreibung']));
        $validInput &= (isset($_POST['treffpunkt']) && !empty($_POST['treffpunkt']));
        // all fields valid?
        if(!empty($_POST['teilnehmer_min']) && !empty($_POST['teilnehmer_max']))
        {
            // teilnehmer_min must be lower or equal than teilnehmer_max
            $validInput &= ($_POST['teilnehmer_min'] <= $_POST['teilnehmer_max']);
        }
        $validInput &= (isset($_POST['preis_mitglieder']) && !empty($_POST['preis_mitglieder']));
        $validInput &= (isset($_POST['preis_nichtmitglieder']) && !empty($_POST['preis_nichtmitglieder']));
        // non-member has to pay more
        $validInput &= ($_POST['preis_mitglieder'] <= $_POST['preis_nichtmitglieder']);
        $new_course_day_set = true;
        $current_course = 1;
        while($new_course_day_set)
        {
            $validInput &= (strtotime($_POST['course_day_begin-'."{$current_course}"]) < strtotime($_POST['course_day_end-'."{$current_course}"]));
            $validInput &= (strtotime($correspondingEvent['Event_start']) <= strtotime($_POST['course_day_begin-'."{$current_course}"]));
            $validInput &= (strtotime($_POST['course_day_end-'."{$current_course}"]) <= strtotime($correspondingEvent['Event_ende']));
            $current_course++;
            $new_course_day_set = isset($_POST['course_day_begin-'."{$current_course}"]);
        }
        return $validInput;
    }

    public function add_course_day()
    {
        $this->session->refresh();
        if($this->adminAndLoggedInCheck())
        {
            $next_course_day_id = $_POST['next_course_day_id'];
            $class = new ClassModel(Application::getInstance()->getDBconnection());
            $allClasses = $class->select_all();
            $this->view = new ManageView();
            echo $this->view->getCourseDay($allClasses, $next_course_day_id);
        }
    }

    public function delete_course()
    {
        $this->session->refresh();
        if($this->adminAndLoggedInCheck())
        {
            if(!empty($_POST['ID']))
            {
                try
                {
                    $where = array(
                        'ID' => $_POST['ID']
                    );
                    $course = new CourseModel(Application::getInstance()->getDBconnection());
                    if($course->delete($where))
                    {
                        echo "TRUE";
                    }
                    else
                    {
                        echo "FALSE";
                    }
                }
                catch(\Exception $e)
                {
                    echo "ERROR";
                }
            }
        }
        else
        {
            echo "ERROR";
        }
    }

    public function refresh_courses_table()
    {
        $this->session->refresh();
        if($this->adminAndLoggedInCheck())
        {
            $this->view = new ManageView();
            $course = new CourseModel(Application::getInstance()->getDBconnection());
            $allCourses = $course->select_all("Name ASC, Event_ID ASC");
            echo $this->view->getCoursesTableRows($allCourses);
        }
        else
        {
            echo "ERROR";
        }   
    }

    public function show_course_info()
    {
        $this->session->refresh();
        if($this->adminAndLoggedInCheck())
        {
            // get data from current course
            $currentCourse_ID = $_POST['ID'];
            $course = new CourseModel(Application::getInstance()->getDBconnection());
            $currentCourse = $course->select(array(
                'ID' => $currentCourse_ID
            ), TRUE);
            if(!empty($currentCourse))
            {
                // get corresponding event data
                $event = new EventModel(Application::getInstance()->getDBconnection());
                $correspondingEvent = $event->select(array(
                    'ID' => $currentCourse[0]['Event_ID']
                ), TRUE);
                // get all classes
                $class = new ClassModel(Application::getInstance()->getDBconnection());
                $class_container = $class->select_all();
                // get all coursedays for this course
                $courseday = new CourseDayModel(Application::getInstance()->getDBconnection());
                $courseDays = $courseday->select(array(
                    'Kurs_ID' => $currentCourse_ID
                ), TRUE);
                // replace class (min/max) ID with text from all classes-container
                foreach($courseDays as $key => &$data)
                {
                    $data['Klasse_min'] = $this->getClassDescriptionFromClassContainer($class_container, $data['Klasse_min']);
                    $data['Klasse_max'] = $this->getClassDescriptionFromClassContainer($class_container, $data['Klasse_max']);
                }
                // generate output with the modified data
                $this->view = new ManageView();
                echo $this->view->getCourseInfo($currentCourse, $courseDays, $correspondingEvent);
            }
            else
            {
                // this should never occur, just for safety
                echo "ERROR: no course with ID ".$_POST['ID']." found. Please contact the developer.";
            }
        }
        else
        {
            // the user which requested the course info isn't admin or logged in
            echo "ERROR";
        }
    }

    private function getClassDescriptionFromClassContainer($container, $classID)
    {
        // generate array from multidimensional array
        // structure is like this: key -> ID, value -> classdescription
        $results = array_column($container, 'Klassenbezeichnung', 'ID');
        return isset($results[$classID]) ? $results[$classID] : NULL;
    }
}
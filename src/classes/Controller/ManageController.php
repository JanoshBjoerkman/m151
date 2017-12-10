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

    private function prepareOverviewContent()
    {
        $year = date("Y");
        $event = new EventModel(Application::getInstance()->getDBconnection());
        $thisYearsEvent = $event->get_event_by_year(date("{$year}"));

        if(empty($thisYearsEvent))
        {
            // no event this year
            $eventlink = $this->getHref("manage?edit=events");
            $body_content = $this->view->getOverviewContent_no_event($eventlink);
        }
        else
        {
            $course = new CourseModel(Application::getInstance()->getDBconnection());
            $numberOfCourses = count($course->get_courses_by_event_id($thisYearsEvent[0]['ID']));
            $body_content = $this->view->getOverviewContent_has_event($thisYearsEvent, $numberOfCourses);
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

    private function prepareEventsContent()
    {
        $event = new EventModel(Application::getInstance()->getDBconnection());
        $thisYearsEvent = $event->get_event_by_year(date("Y"));
        $allEvents = $event->select_all();
        if(empty($thisYearsEvent) && empty($allEvents))
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
            $this->view = new ManageView();
            $body_content = $this->view->getCourses_no_courses($events, $allClasses);
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

    public function settings()
    {

    }

    public function create_new_event()
    {
        $this->session->refresh();
        if($this->allNewEventFieldsSet() && $this->adminAndLoggedInCheck())
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
                        "{$e->getMessage()}"
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
                "Sie haben nicht alle Felder ausgefüllt",
                "Eingabefehler",
                "Der Vorgang wurde abgebrochen"
            );
        }
    }

    private function allNewEventFieldsSet()
    {
        if(isset($_POST['event_start']) && 
                isset($_POST['event_ende']) &&
                isset($_POST['Titel']) &&
                isset($_POST['phase1']) &&
                isset($_POST['phase2']) &&
                isset($_POST['anmeldeschluss']))
        {
            return true;
        }
        else
        {
            return false;
        }
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
                    while($new_course_day_set)
                    {
                        $class = new ClassModel(Application::getInstance()->getDBconnection());
                        $class_min_ID = NULL;
                        $class_max_ID = NULL;
                        if(!empty($_POST['course_day_class_min-'."{$current_course}"]))
                        {
                            $class_min_ID = $class->getClassID($this->escapeInput($_POST['course_day_class_min-'."{$current_course}"]));
                        }
                        if(!empty($_POST['course_day_class_max-'."{$current_course}"]))
                        {
                            $class_max_ID = $class->getClassID($this->escapeInput($_POST['course_day_class_max-'."{$current_course}"]));
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
                catch(\PDOException $e)
                {

                }
                catch(\Exception $e)
                {

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

    private function validateNewcourse()
    {
        $validInput = (isset($_POST['events_dropdown']) && !empty($_POST['events_dropdown']));
        $validInput &= (isset($_POST['name']) && !empty($_POST['name']));
        $validInput &= (isset($_POST['beschreibung']) && !empty($_POST['beschreibung']));
        $validInput &= (isset($_POST['treffpunkt']) && !empty($_POST['treffpunkt']));
        if(!empty($_POST['teilnehmer_min']) && !empty($_POST['teilnehmer_max']))
        {
            $validInput &= ($_POST['teilnehmer_min'] <= $_POST['teilnehmer_max']);
        }
        $validInput &= (isset($_POST['preis_mitglieder']) && !empty($_POST['preis_mitglieder']));
        $validInput &= (isset($_POST['preis_nichtmitglieder']) && !empty($_POST['preis_nichtmitglieder']));
        $validInput &= ($_POST['preis_mitglieder'] <= $_POST['preis_nichtmitglieder']);
        $new_course_day_set = true;
        $current_course = 1;
        while($new_course_day_set)
        {
            $validInput &= (strtotime($_POST['course_day_begin-'."{$current_course}"]) < strtotime($_POST['course_day_end-'."{$current_course}"]));
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
}
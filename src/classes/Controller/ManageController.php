<?php
namespace M151\Controller;

use M151\Http\Request;
use M151\Application;
use M151\Model\AccountModel;
use M151\Model\EventModel;
use M151\Model\CourseModel;
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
        /*$course = new CourseModel(Application::getInstance()->getDBconnection());
        $allCourses = $course->select_all();*/
        $this->view = new ManageView();
        $body_content = $this->view->getCourses_no_courses($events);
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

    public function new_event()
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
            $this->view->smarty->show_error_message(
                "Eingabefehler",
                "Sie haben nicht alle Felder ausgefüllt",
                "Eingabefehler",
                "Der Vorgangwurde abgebrochen"
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
        $this->view = new ManageView();
        $event = new EventModel(Application::getInstance()->getDBconnection());
        $allEvents = $event->select_all();
        echo $this->view->getEventsTableRows($allEvents);
    }

    public function new_course()
    {
        
    }

    public function add_course_day()
    {
        $this->session->refresh();
        $next_course_day_id = $_POST['next_course_day_id'];
        $class = new ClassModel(Application::getInstance()->getDBconnection());
        $allClasses = $class->select_all();
        $this->view = new ManageView();
        echo $this->view->getCourseDay($allClasses, $next_course_day_id);
    }
}
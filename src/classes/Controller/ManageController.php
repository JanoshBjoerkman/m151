<?php
namespace M151\Controller;

use M151\Http\Request;
use M151\Application;
use M151\Model\AccountModel;
use M151\Model\EventModel;
use M151\Model\KursModel;

class ManageController extends Controller
{
    public function manage(Request $request)
    {
        $this->session->refresh();
        if($this->session->isLoggedIn() && $this->session->isAdmin())
        {
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
                $content = array_merge($content, $this->getOverviewContent());
            }
            else
            {
                switch($request->getParam('edit'))
                {
                    case 'overview':
                        $content = array_merge($content, $this->getOverviewContent());
                        break;
                    case 'events':
                        $content = array_merge($content, $this->getEventsContent());
                        break;
                    case 'courses':
                        $content = array_merge($content, $this->getCoursesContent());
                        break;
                    case 'users': 
                        $content = array_merge($content, $this->getUsersContent());
                        break;
                }            
            }

            $this->view->smarty->assign($content);
            $this->view->smarty->display('manage_overview.html');
        }
        else
        {
            // user is not admin
            $this->redirect_to("home");
        }
    }

    protected function getOverviewContent()
    {
        $body_content = "";

        $event = new EventModel(Application::getInstance()->getDBconnection());
        $year = date("Y");
        $thisYearsEvent = $event->get_event_by_year(date("{$year}"));
        if(empty($thisYearsEvent))
        {
            // no event this year
            $eventlink = $this->getHref("manage?edit=events");
            $body_content = "<div class='row'>
                                <div class='col-xs-3 col-sm-3 col-md-4 col-lg-4'></div>
                                <div class='col-xs-6 col-sm-6 col-md-4 col-lg-4'>
                                    <h4>kein eingetragener Event für {$year}</h4>
                                    <a class='btn btn-large btn-block btn-primary' href='{$eventlink}' role='button'>Event erstellen</a>
                                </div>
                            </div>";
        }
        else
        {
            // get this years event title and count courses
            $title = $thisYearsEvent[0]['Titel'];
            $course = new KursModel(Application::getInstance()->getDBconnection());
            $numberOfCourses = count($course->get_courses_by_event_id($thisYearsEvent[0]['ID']));
            $visible = ($thisYearsEvent[0]['visible'] == '1') ? 'ja' : 'nein'; 
            $body_content = "<div class='row'>
                                <div class='col-xs-12 col-sm-12 col-md-12 col-lg-12'>
                                    <div class='page-header'>
                                        <h1>{$title}</h1>
                                    </div>
                                    <p>#Kurse: {$numberOfCourses}</p>
                                    <p>für Benutzer sichtbar: {$visible}</p>
                                </div>
                            </div>";
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

    protected function getEventsContent()
    {
        $event = new EventModel(Application::getInstance()->getDBconnection());
        $thisYearsEvent = $event->get_event_by_year(date("Y"));
        if(empty($thisYearsEvent))
        {
            $body_content = "<div class='row'>
                                <div class='col-xs-1 col-sm-1 col-md-3 col-lg-3'></div>
                                <div class='col-xs-10 col-sm-10 col-md-6 col-lg-6'>
                                    <form action='manage/new_event' method='POST' class='form-horizontal' role='form'>
                                        <div class='form-group'>
                                            <legend>neuer Event</legend>
                                        </div>
                                        <div class='form-group'>
                                            <label for='Titel' class='col-sm-2 control-label'>Titel:</label>
                                            <div class='col-sm-10'>
                                                <input type='text' name='Titel' id='Titel' class='form-control' pattern='[À-žA-Za-z0-9\s]+' required='required'>
                                            </div>
                                        </div>
                                        <div class='form-group'>
                                            <label for='event_start' class='col-sm-2 control-label'>Start:</label>
                                            <div class='col-sm-10'>
                                                <input type='datetime-local' name='event_start' id='event_start' class='form-control' placeholder='TT.MM.YYYY, HH:MM' required='required'>
                                            </div>
                                        </div>
                                        <div class='form-group'>
                                            <label for='event_ende' class='col-sm-2 control-label'>Ende:</label>
                                            <div class='col-sm-10'>
                                                <input type='datetime-local' name='event_ende' id='event_ende' class='form-control' placeholder='TT.MM.YYYY, HH:MM' required='required'>
                                            </div>
                                        </div>
                                        <div class='form-group'>
                                            <label for='phase1' class='col-sm-2 control-label'>Phase 1:</label>
                                            <div class='col-sm-10'>
                                                <input type='datetime-local' name='phase1' id='phase1' class='form-control' placeholder='TT.MM.YYYY, HH:MM' required='required'>
                                            </div>
                                        </div>
                                        <div class='form-group'>
                                            <label for='phase2' class='col-sm-2 control-label'>Phase 2:</label>
                                            <div class='col-sm-10'>
                                                <input type='datetime-local' name='phase2' id='phase2' class='form-control' placeholder='TT.MM.YYYY, HH:MM' required='required'>
                                            </div>
                                        </div>
                                        <div class='form-group'>
                                            <label for='anmeldeschluss' class='col-sm-3 control-label'>Anmeldeschluss:</label>
                                            <div class='col-sm-9'>
                                                <input type='datetime-local' name='anmeldeschluss' id='anmeldeschluss' class='form-control' placeholder='TT.MM.YYYY, HH:MM' required='required'>
                                            </div>
                                        </div>
                                        <div class='checkbox'>
                                            <label>
                                                <input name='visible' type='checkbox' title='für den Benutzer bereits sichtbar?'>
                                                sichtbar
                                            </label>
                                        </div>
                                        <div class='form-group'>
                                            <div class='col-sm-10 col-sm-offset-2'>
                                                <button type='submit' class='btn btn-primary'>erstellen</button>
                                            </div>
                                        </div>
                                    </form>
                                </div>
                            </div>";
        }
        else
        {
            $body_content = "";
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

    protected function getCoursesContent()
    {
        return array(
            'tab_title' => 'Kurse',
            'li_class_overview' => '',
            'li_class_events' => '',
            'li_class_kurse' => 'active',
            'li_class_benutzer' => '',
            'body_content' => ''
        );
    }

    protected function getUsersContent()
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
        if($this->allNewEventFieldsSet())
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
                $event->new_event($data);
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
}
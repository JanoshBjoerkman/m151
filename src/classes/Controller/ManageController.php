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
        $activeEvent = $event->get_active_event();
        if(empty($activeEvent))
        {
            // no active event
            $eventlink = $this->getHref("manage?edit=events");
            $body_content = "<div class='row'>
                                <div class='col-xs-3 col-sm-3 col-md-4 col-lg-4'></div>
                                <div class='col-xs-6 col-sm-6 col-md-4 col-lg-4'>
                                    <h4>kein aktiver Event</h4>
                                    <a class='btn btn-large btn-block btn-primary' href='{$eventlink}' role='button'>Event erstellen</a>
                                </div>
                            </div>";
        }
        else
        {
            // get active event title and count courses
            $title = $activeEvent[0]['Titel'];
            $course = new KursModel(Application::getInstance()->getDBconnection());
            $numberOfCourses = count($kurs->get_courses_by_active_event($activeEvent[0]['ID']));
            $body_content = "<div class='row'>
                                <div class='col-xs-12 col-sm-12 col-md-12 col-lg-12'>
                                    <div class='page-header'>
                                        <h1>{$title}</h1>
                                    </div>
                                    <p>#Kurse: {$numberOfCourses}</p>
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
        return array(
            'tab_title' => 'Events',
            'li_class_overview' => '',
            'li_class_events' => 'active',
            'li_class_kurse' => '',
            'li_class_benutzer' => '',
            'body_content' => ''
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
}
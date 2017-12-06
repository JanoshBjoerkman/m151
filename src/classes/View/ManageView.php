<?php
namespace M151\View;

class ManageView extends View
{
    public $templateDir;

    public function __construct()
    {
        parent::__construct("manage/");
    }

    public function show_manage($content)
    {
        $this->view->assign($content);
        $this->view->display('manage.html');
    }

    public function getOverviewContent_no_event($eventlink)
    {
        $no_event = array(
            'year' => date("Y"),
            'eventlink' => $eventlink
        );
        $this->view->assign($no_event);
        return $this->view->fetch($this->templateDir."overview_no_event.html");
    }

    public function getOverviewContent_has_event($thisYearsEvent, $numberOfCourses)
    {
        // get this years event title and count courses
        $title = $thisYearsEvent[0]['Titel'];
        $visible = ($thisYearsEvent[0]['visible'] == '1') ? 'ja' : 'nein';
        $event_overview = array(
            'title' => $title,
            'visible' => $visible,
            'numberOfCourses' => $numberOfCourses
        );
        $this->view->assign($event_overview);
        return $this->view->fetch($this->templateDir."overview_has_event.html");;
    }

    public function getCreateNewEventTable()
    {
        return $this->view->fetch($this->templateDir."events_new_event.html");
    }

    public function getEventsContent_no_events()
    {
        $body_content = $this->getCreateNewEventTable();
        return $body_content;
    }

    public function getEventsContent_has_events($allEvents)
    {
        $table_rows = $this->getEventsTableRows($allEvents);
        $this->view->assign('table_rows', $table_rows);
        $body_content = $this->view->fetch($this->templateDir."events_table.html");
        $body_content .= $this->getCreateNewEventTable();
        return $body_content;
    }

    public function getEventsTableRows($allEvents)
    {
        $table_rows = "";
        foreach($allEvents as $eventKey => $eventData)
        {
            $visible = ($eventData['visible'] == '1') ? 'ja' : 'nein';
            $row = array(
                'ID' => $eventData['ID'],
                'titel' => $eventData['Titel'],
                'start' => date("d.m.Y H:i", strtotime($eventData['Event_start'])),
                'ende' => date("d.m.Y H:i", strtotime($eventData['Event_ende'])),
                'phase1' => date("d.m.Y H:i", strtotime($eventData['Phase_1'])),
                'phase2' => date("d.m.Y H:i", strtotime($eventData['Phase_2'])),
                'anmeldeschluss' => date("d.m.Y H:i", strtotime($eventData['Anmeldeschluss'])),
                'visible' => $visible
            );           
            $this->view->assign($row);
            $table_rows .= $this->view->fetch($this->templateDir."events_table_row.html");
        }
        return $table_rows;
    }

    public function getCourses_no_courses($events)
    {
        $events_dropdown = $this->getEventsDropdown($events);
        $content = array(
            'events_dropdown' => $events_dropdown
        );
        $this->view->assign($content);
        return $this->view->fetch($this->templateDir."courses_new_course.html");
    }

    public function getEventsDropdown($events)
    {
        $events_dropdown_items = "";
        foreach($events as $key => $data)
        {
            $event_title = $data['Titel'];
            $event_id = $data['ID'];
            $this->view->assign(
                array(
                    'event_title' => $event_title,
                    'event_id' => $event_id
                )
            );
            $events_dropdown_items .= $this->view->fetch($this->templateDir."courses_events_dropdown_item.html");
        }
        $this->view->assign('events_dropdown_items', $events_dropdown_items);
        return $this->view->fetch($this->templateDir.'courses_events_dropdown.html');
    }
}
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

    // overview
    public function getOverviewContent_no_event($eventlink)
    {
        $no_event = array(
            'eventlink' => $eventlink
        );
        $this->view->assign($no_event);
        return $this->view->fetch($this->templateDir."overview_no_event.html");
    }

    public function getOverviewContent_has_event($event, $numberOfCourses)
    {
        // get this years event title and count courses
        $title = $event[0]['Titel'];
        $visible = ($event[0]['visible'] == '1') ? 'ja' : 'nein';
        $event_overview = array(
            'title' => $title,
            'visible' => $visible,
            'numberOfCourses' => $numberOfCourses
        );
        $this->view->assign($event_overview);
        return $this->view->fetch($this->templateDir."overview_has_event.html");;
    }

    // events
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

    public function getCreateNewEventTable()
    {
        return $this->view->fetch($this->templateDir."events_new_event.html");
    }

    public function getEventsTableRows($allEvents)
    {
        $table_rows = "";
        foreach($allEvents as $eventKey => $eventData)
        {
            $visible = ($eventData['visible'] == '1') ? 'checked' : '';
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

    // courses
    public function getCoursesContent($events, $classes, $allCourses)
    {
        // content for: all courses
        $content = array(
            'table_rows' => $this->getCoursesTableRows($allCourses),
            'modal_content' => ""
        );
        $this->view->assign($content);
        $body_content = $this->view->fetch($this->templateDir."courses_table.html");
        // content for: create new course
        $events_dropdown = $this->getEventsDropdown($events);
        $course_day = $this->getCourseDay($classes, 1);
        $this->view->assign(
            array(
            'events_dropdown' => $events_dropdown,
            'course_day' => $course_day
        ));
        $body_content .= $this->view->fetch($this->templateDir."courses_new_course.html");
        return $body_content;
    }

    public function getCoursesTableRows($allCourses)
    {
        $rows = "";
        foreach($allCourses as $key => $course_data)
        {
            $content = array(
                'name' => $course_data['Name'],
                'ID' => $course_data['ID']
            );
            $this->view->assign($content);
            $rows .= $this->view->fetch($this->templateDir."courses_table_row.html");
        }
        return $rows;
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
                    'option_title' => $event_title,
                    'option_id' => $event_id
                )
            );
            $events_dropdown_items .= $this->view->fetch($this->templateDir."dropdown_item.html");
        }
        $dropdown_id = 'events_dropdown';
        $this->view->assign(
            array(
                'dropdown_title' => 'Event:',
                'select_id' => $dropdown_id,
                'select_name' => $dropdown_id,
                'dropdown_items' => $events_dropdown_items
        ));
        return $this->view->fetch($this->templateDir.'dropdown.html');
    }

    public function getCourseDay($classes, $id)
    {
        // generate class select-dropdown items
        $class_dropdown_items = "";
        foreach($classes as $key => $data)
        {
            $class = $data['Klassenbezeichnung'];
            $ID = $data['ID'];
            $this->view->assign(
                array(
                    'option_id' => $ID,
                    'option_title' => $class
            ));
            $class_dropdown_items .= $this->view->fetch($this->templateDir."dropdown_item.html");
        }
        
        // generate min class dropdown
        $dropdown_id = 'course_day_class_min';
        $this->view->assign(
            array(
                'dropdown_title' => 'ab:',
                'select_id' => $dropdown_id,
                'select_name' => $dropdown_id."-{$id}",
                'dropdown_items' => $class_dropdown_items
        ));
        $class_min_dropdown = $this->view->fetch($this->templateDir.'dropdown.html');

        // generate max class dropdown
        $dropdown_id = 'course_day_class_max';
        $this->view->assign(
            array(
                'dropdown_title' => 'bis:',
                'select_id' => $dropdown_id,
                'select_name' => $dropdown_id."-{$id}",
                'dropdown_items' => $class_dropdown_items
        ));
        $class_max_dropdown = $this->view->fetch($this->templateDir.'dropdown.html');

        // generate html code for new course day
        $this->view->assign(array(
            'course_day_panel_id' => $id,
            'input_id' => $id,
            'class_min_dropdown' => $class_min_dropdown,
            'class_max_dropdown' => $class_max_dropdown,
        ));
        return $this->view->fetch($this->templateDir."courses_course_day.html");
    }

    public function getCourseInfo($course, $courseDays, $event)
    {
        $courseday_panels = "";
        $index = 1;
        foreach($courseDays as $key => $data)
        {
            $courseday_panels .= $this->getCourseDayInfoTable($index, $data);
            $index++;
        }
        $this->view->assign(array(
            'Name' => $course[0]['Name'],
            'Beschreibung' => $course[0]['Beschreibung'],
            'Treffpunkt' => $course[0]['Treffpunkt'],
            'Teilnehmer_min' => $course[0]['Teilnehmer_min'],
            'Teilnehmer_max' => $course[0]['Teilnehmer_max'],
            'Preis_mitglieder' => number_format($course[0]['Preis_Mitglieder_rp'] / 100, 2),
            'Preis_nichtmitglieder' => number_format($course[0]['Preis_Nichtmitglieder_rp'] / 100, 2),
            'Besonderes' => ($course[0]['Besonderes'] != "") ? $course[0]['Besonderes'] : "-",
            'Leitung' => $course[0]['Leitung'],
            'Event' => $event[0]['Titel'],
            'courseday_panels' => $courseday_panels
        ));
        return $this->view->fetch($this->templateDir."courses_course_info_modal.html");
    }
    
    public function getCourseDayInfoTable($index, $courseDay)
    {
        $class_text = "";
        // create class text based on class min/max
        if(empty($courseDay['Klasse_min']) || empty($courseDay['Klasse_min']))
        {
            // should never occur...
            $class_text = "ERROR. No min/max class found in course day. Please contact the admin.";
        }
        else
        {
            // check if min or max is set to "no restriction"
            if($courseDay['Klasse_min'] == "-" || $courseDay['Klasse_max'] == "-")
            {
                if($courseDay['Klasse_min'] == "-" && $courseDay['Klasse_max'] == "-")
                {
                    // no class restrictions
                    $class_text = "alle";
                }
                else
                {
                    // check which class has restriction
                    $class_text = ($courseDay['Klasse_min'] == "-") ? "bis {$courseDay['Klasse_max']}" : "ab {$courseDay['Klasse_min']}";
                }
            }
            else
            {
                // min and max aren't set to no restriction
                if($courseDay['Klasse_min'] == $courseDay['Klasse_max'])
                {
                    $class_text = "nur {$courseDay['Klasse_min']}";
                }
                else
                {
                    // normal class restrictions -> set normal class text
                    $class_text = "ab {$courseDay['Klasse_min']} - bis {$courseDay['Klasse_max']}";
                }
            }
        }
        // format date and put data in row
        $begin = date("d.m.Y H:i", strtotime($courseDay['Datum_Begin']));
        $end = date("d.m.Y H:i", strtotime($courseDay['Datum_Ende']));
        $courseday_row  = "<tr>
                                <th>Begin</th>
                                <td>{$begin}</td>
                            </tr>
                            <tr>
                                <th>Ende</th>
                                <td>{$end}</td>
                            </tr>";
        $this->view->assign(array(
           'index' => $index,
           'class_text' => $class_text,
            'courseday_row' => $courseday_row
        ));
        return $this->view->fetch($this->templateDir."courses_course_info_modal_course_day_panel.html");
    }
}
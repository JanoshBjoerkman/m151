<?php
namespace M151\View;

class ManageView extends View
{
    public function show_manage($content)
    {
        $this->view->assign($content);
        $this->view->display('manage.html');
    }

    public function getOverviewContent_no_event($eventlink)
    {
        $body_content = "";
        $year = date("Y");

        $body_content = "<div class='row'>
                            <div class='col-xs-3 col-sm-3 col-md-4 col-lg-4'></div>
                            <div class='col-xs-6 col-sm-6 col-md-4 col-lg-4'>
                                <h4>kein eingetragener Event für {$year}</h4>
                                <a class='btn btn-large btn-block btn-primary' href='{$eventlink}' role='button'>Event erstellen</a>
                            </div>
                        </div>";
        return $body_content;
    }

    public function getOverviewContent_has_event($thisYearsEvent, $numberOfCourses)
    {
        // get this years event title and count courses
        $title = $thisYearsEvent[0]['Titel'];
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
        return $body_content;
    }

    private function getCreateNewEventTable()
    {
        return "<div class='row'>
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

    public function getEventsContent_no_events()
    {
        $body_content = $this->getCreateNewEventTable();
        return $body_content;
    }

    public function getEventsContent_has_events($allEvents, $deleteLink)
    {
        $row = " <div class='row'>
                    <div class='col-xs-12 col-sm-12 col-md-12 col-lg-12'>
                        <div class='table-responsive'>
                            <table class='table table-hover'>
                                <thead>
                                    <tr>
                                        <th>Titel</th>
                                        <th>Start</th>
                                        <th>Ende</th>
                                        <th>Phase 1</th>
                                        <th>Phase 2</th>
                                        <th>Anmeldeschluss</th>
                                        <th>sichtbar</th>
                                        <th>löschen</th>
                                    </tr>
                                </thead>
                                <tbody>";
        $table_body = "";
        foreach($allEvents as $eventKey => $eventData)
        {
            $ID = $eventData['ID'];
            $start = date("d.m.Y H:i", strtotime($eventData['Event_start']));
            $ende = date("d.m.Y H:i", strtotime($eventData['Event_ende']));
            $phase1 = date("d.m.Y H:i", strtotime($eventData['Phase_1']));
            $phase2 = date("d.m.Y H:i", strtotime($eventData['Phase_2']));
            $anmeldeschluss = date("d.m.Y H:i", strtotime($eventData['Anmeldeschluss']));
            $visible = ($eventData['visible'] == '1') ? 'ja' : 'nein'; 
            $table_body .= "<tr>
                                <td>{$eventData['Titel']}</td>
                                <td>{$start}</td>
                                <td>{$ende}</td>
                                <td>{$phase1}</td>
                                <td>{$phase2}</td>
                                <td>{$anmeldeschluss}</td>
                                <td>{$visible}</td>
                                <td>
                                    <button type='button' class='btn btn-danger' onclick='delete_event({$ID})'>
                                        <i class='fa fa-trash-o' aria-hidden='true'></i>
                                    </button>
                                </td>
                            </tr>";
        }
        $createNewEvent = $this->getCreateNewEventTable();
        $row_close = "</tbody>
                    </table>
                </div>
            </div>
            {$createNewEvent}
        </div>";
        $body_content = "{$row}{$table_body}{$row_close}";
        return $body_content;
    }
}
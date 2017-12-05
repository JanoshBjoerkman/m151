<?php

namespace M151\Model;

class EventModel extends Model
{
    public function tablename()
    {
        return 'Event';
    }

    public function get_active_event()
    {
        $data = array(
            'visible' => '1'
        );
        return $this->select($data, TRUE);
    }

    public function get_event_by_year($date)
    {
        //$where = "DATE_FORMAT(Event_start, '%Y') = DATE_FORMAT({$date}, '%Y')";
        $where = "YEAR(Event_start) = {$date}";
        $query = "SELECT * FROM {$this->tablename()} WHERE {$where}";
        $STH = $this->DBH->prepare($query);
        $result = $STH->execute();
        if($result)
        {
            // emtpy array means no rows with specified filter found
            return $STH->fetchAll(\PDO::FETCH_ASSOC);
        }
    }

    public function new_event($data)
    {
        return $this->insert($data);
    }
}
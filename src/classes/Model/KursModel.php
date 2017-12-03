<?php

namespace M151\Model;

class KursModel extends Model
{
    public function tablename()
    {
        return 'Kurs';
    }

    public function get_courses_by_event_id($Event_ID)
    {
        $data = array(
            'Event_ID' => $Event_ID
        );
        return $this->select($data, TRUE);
    }
}
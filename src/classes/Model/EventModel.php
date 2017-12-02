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
            'active' => '1'
        );
        return $this->select($data, TRUE);
    }
}
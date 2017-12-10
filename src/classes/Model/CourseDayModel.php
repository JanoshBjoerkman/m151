<?php

namespace M151\Model;

class CourseDayModel extends Model
{
    public function tablename()
    {
        return 'Kurstag';
    }

    public function new_course_day($data)
    {
        return $this->insert($data);
    }
}
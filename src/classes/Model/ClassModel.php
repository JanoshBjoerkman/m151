<?php

namespace M151\Model;

class ClassModel extends Model
{
    public function tablename()
    {
        return 'Klasse';
    }

    public function getClassID($class_description)
    {
        $query = array(
            'Klassenbezeichnung' => $class_description
        );
        $result = $this->select($query, TRUE);
        if(!empty($result))
        {
            return $result[0]['ID'];
        }
        return NULL;
    }
}
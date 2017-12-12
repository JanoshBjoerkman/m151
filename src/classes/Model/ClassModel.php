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
        $result = $this->select(array(
            'Klassenbezeichnung' => $class_description
        ), TRUE);
        if(!empty($result))
        {
            return $result[0]['ID'];
        }
        return NULL;
    }

    public function getClassDescriptionByID($ID)
    {
        $result = $this->select(array(
            'ID' => $ID
        ), TRUE);
        if(!empty($result))
        {
            return $result;
        }
        return NULL;
    }
}
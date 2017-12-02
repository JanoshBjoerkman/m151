<?php

namespace M151\Model;

class AccountModel extends Model
{
    public function tablename()
    {
        return 'Account';
    }

    public function get_account_by_email($email)
    {
        $data = array(
            'Email' => $email
        );
        return $this->select($data, FALSE);        
    }

    public function create_new_account($dataDictionary)
    {
        $this->insert($dataDictionary);
    }

    public function get_email_by_id($ID)
    {
        $data = array(
            'ID' => $ID,
        );
        $result = $this->select($data, TRUE);
        if(!empty($result))
        {
            return $result[0]['Email'];
        }
        else
        {
            return "ERROR";
        }
    }
}
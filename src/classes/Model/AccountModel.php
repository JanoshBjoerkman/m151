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
        return $this->select($data);        
    }

    public function create_new_account($dataDictionary)
    {
        $this->insert($dataDictionary);
    }
}
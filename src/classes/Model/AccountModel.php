<?php

namespace M151\Model;

class AccountModel extends Model
{
    public function tablename()
    {
        return 'Account';
    }

    public function getUser($email)
    {
        $data = array(
            'Email' => 'janosh.b@bluewin.ch',
            'Passwort' => password_hash('Admin1234', PASSWORD_DEFAULT),
            'Rechnungsadresse' => 'Geddhostreez 420',
            'Ort' => 'Pfyn',
            'PLZ' => 8505,
        );
        $this->insert($data);
        $stmt = $this->DBH->prepare("SELECT * FROM Account ");
        $stmt->bindParam(":mail", $email);
        $result = $stmt->execute();
        if($result)
        {
            $bla = $stmt->fetch(\PDO::FETCH_ASSOC);
            var_dump($bla);
        }
        else
        {
            return false;
        }
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
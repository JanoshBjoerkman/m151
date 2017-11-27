<?php
namespace M151\Model;

class AccountModel extends Model
{
    protected function tablename()
    {
        return 'Account';
    }

    public function getUser($email)
    {
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
}
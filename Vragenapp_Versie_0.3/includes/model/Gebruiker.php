<?php

class Gebruiker
{
    /**
     *
     * @param type $userId user id
     */
    public function setUserid($userId)
    {
        if (is_int(intval($userId))) {
            $this->userId = $userId;
        }
    }

    /**
     *
     * @return int de database id van deze user
     */
    public function getUserid()
    {
        return $this->userId;
    }

}

?>
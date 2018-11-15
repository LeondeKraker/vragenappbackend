<?php

class Antwoord
{

    /**
     *
     * @param type $vraag vraag
     */
    public function setAntwoordId($antwoordId)
    {
        if (is_int(intval($antwoordId))) {
            $this->antwoordId = $antwoordId;
        }
    }

    /**
     *
     * @param type $vraag vraag
     */
    public function setAntwoord($antwoord)
    {
        if (is_int(intval($antwoord))) {
            $this->antwoord = $antwoord;
        }
    }

    /**
     *
     * @return int de database id van deze vraag
     */
    public function getAntwoordId()
    {
        return $this->antwoordId;
    }

    /**
     *
     * @return int de database id van deze vraag
     */
    public function getAntwoord()
    {
        return $this->antwoord;
    }
}

?>
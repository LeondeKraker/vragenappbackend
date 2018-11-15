<?php
class Resultaten extends Gebruiker
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
    public function getResultaten()
    {
        /*
        niet werkende query met vraag:
        SELECT opleiding.opleiding, user.uu_id, antwoord.antwoord, vraag.vraag
        FROM user 
        INNER JOIN user_antwoord 
        ON user.uu_id = user_antwoord.uu_id 
        INNER JOIN antwoord 
        ON antwoord.antwoord_id = user_antwoord.antwoord_id
        INNER JOIN user_opleiding
        ON user.uu_id = user_opleiding.uu_id
        INNER JOIN opleiding
        ON user_opleiding.opleiding_id = opleiding.opleiding_id
        INNER JOIN vraag
        ON vraag.vraag_id = opleiding_vraag.vraag_id
        INNER JOIN opleiding_vraag
        ON opleiding_vraag.vraag_id

        //werkende query zonder vraag:

        SELECT opleiding.opleiding, user.uu_id, antwoord.antwoord
        FROM user 
        INNER JOIN user_antwoord 
        ON user.uu_id = user_antwoord.uu_id 
        INNER JOIN antwoord 
        ON antwoord.antwoord_id = user_antwoord.antwoord_id
        INNER JOIN user_opleiding
        ON user.uu_id = user_opleiding.uu_id
        INNER JOIN opleiding
        ON user_opleiding.opleiding_id = opleiding.opleiding_id



        */


        global $wpdb;
        $return_array = array();
        $result_array = $wpdb->get_results("SELECT vraag.vraag, vraag.verstuur_tijd, opleiding.opleiding, vraag.vraag_id, vraag.vraag_soort
        FROM vraag 
        INNER JOIN opleiding_vraag 
        ON vraag.vraag_id = opleiding_vraag.vraag_id 
        INNER JOIN opleiding 
        ON opleiding.opleiding_id = opleiding_vraag.opleiding_id", ARRAY_A);
        // For all database results:
        foreach ($result_array as $idx => $array) {
            // New opleiding object
            $vraag = new Vraag();
            // Set all info
            $vraag->setVraag($array['vraag']);
            $vraag->setVerstuurTijd($array['verstuur_tijd']);
            $vraag->setOpleiding($array['opleiding']);
            $vraag->setVraagId($array['vraag_id']);
            $vraag->setVraagSoort($array['vraag_soort']);
            // Add new object to return array.
            $return_array[] = $vraag;
        }
        return $return_array;
    }
}
}
?>
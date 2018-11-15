<?php
require_once VRAGEN_PLUGIN_MODEL_DIR . "/Opleiding.php";

class Vraag extends Opleiding
{
    /**
     *
     * @param type $vraagId id van de vraag
     */
    public function setVraagId($vraagId)
    {
        if (is_int(intval($vraagId))) {
            $this->vraagId = $vraagId;
        }
    }

    /**
     *
     * @param type $vraag vraag
     */
    public function setVraag($vraag)
    {
        if (is_int(intval($vraag))) {
            $this->vraag = $vraag;
        }
    }

    /**
     *
     * @param type $vraagSoort vraagSoort soort vraag
     */
    public function setVraagSoort($vraagSoort)
    {
        if (is_int(intval($vraagSoort))) {
            $this->vraagSoort = $vraagSoort;
        }
    }

    /**
     *
     * @param type $verstuurTijd verstuurTijd van een vraag
     */
    public function setVerstuurTijd($verstuurTijd)
    {
        if (is_int(intval($verstuurTijd))) {
            $this->verstuurTijd = $verstuurTijd;
        }
    }

    /**
     *
     * @param type $vraag vraag
     */
    public function setOpleiding($opleiding)
    {
        if (is_int(intval($opleiding))) {
            $this->opleiding = $opleiding;
        }
    }

    /**
     *
     * @return int de database id van deze vraag
     */
    public function getVraagId()
    {
        return $this->vraagId;
    }

    /**
     *
     * @return string de vraag
     */
    public function getVraag()
    {
        return $this->vraag;
    }

    /**
     *
     * @return string de soort vraag
     */
    public function getVraagSoort()
    {
        return $this->vraagSoort;
    }
    /**
     *
     * @return string verstuur tijd van de vraag
     */
    public function getVerstuurTijd()
    {
        return $this->verstuurTijd;
    }

    /**
     *
     * @return string opleiding waar vraag naar verstuurd moet worden
     */
    public function getOpleiding()
    {
        return $this->opleiding;
    }

    /**
     * getPostValues :
     * Filter input and retrieve POST input params
     *
     * @return array containing known POST input fields
     */
    public function getPostValues()
    {
    // Define the check for params
        $post_check_array = array(
            // submit action
            'toevoegen' => array('filter' => FILTER_SANITIZE_STRING),
            // question
            'vraag' => array('filter' => FILTER_SANITIZE_STRING),
            // question type (open or closed)
            'vraag_id' => array('filter' => FILTER_SANITIZE_STRING),
            // question type (open or closed)
            'vraagSoort' => array('filter' => FILTER_SANITIZE_STRING),
            // question send time
            'verstuurTijd' => array('filter' => FILTER_SANITIZE_STRING)
        );
    // Get filtered input:
        $inputs = filter_input_array(INPUT_POST, $post_check_array);
    // RTS
        return $inputs;
    }

    /**
     *
     * @global type $wpdb The Wordpress database class
     * @param type $input_array containing insert data
     * @return boolean TRUE on succes OR FALSE
     */
    public function voegVraagToe($input_array)
    {
        try {
            if (!isset($input_array['vraag']) ||
                !isset($input_array['verstuurTijd']) || !isset($input_array['vraagSoort'])) {
                // Mandatory fields are missing
                throw new Exception(__("Missing mandatory fields"));
            }
            if ((strlen($input_array['vraag']) < 1) || (strlen($input_array['verstuurTijd']) < 1) || (strlen($input_array['vraagSoort']) < 1)) {
                // Mandatory fields are empty
                throw new Exception(__("Empty mandatory fields"));
            }
            global $wpdb;
            $opleiding_id = $_POST['opleidingKiezen'];

            // Insert query
            $wpdb->query($wpdb->prepare(
                "INSERT INTO `vraag` (`vraag`, `verstuur_tijd`, `vraag_soort`)" .
                    " VALUES ('%s', '%s','%s');",
                $input_array['vraag'],
                $input_array['verstuurTijd'],
                $input_array['vraagSoort']
            ));
            // variabele met laatst toegevoegde auto_increment ID
            $laatste_id = $wpdb->insert_id;
            // Insert query
            $wpdb->query($wpdb->prepare(
                "INSERT INTO `opleiding_vraag` (`vraag_id`, `opleiding_id`)" .
                    " VALUES ('%s', '%s');",
                $laatste_id,
                $opleiding_id
            ));

            // Error ? It's in there:
            if (!empty($wpdb->last_error)) {
                $this->last_error = $wpdb->last_error;
                return false;
            }
        } catch (Exception $exc) {
            echo '<pre>' . $exc->getTraceAsString() . '</pre>';
        }
        return true;
    }

    public function getAlleVragen()
    {
        global $wpdb;
        $return_array = array();
        $result_array = $wpdb->get_results("SELECT `vraag_id` FROM `opleiding_vraag` ORDER BY `vraag_id`", ARRAY_A);
        // For all database results:
        foreach ($result_array as $idx => $array) {
            // New opleiding object
            $vraag = new Vraag();
            // Set all info
            $vraag->setVraagId($array['vraag_id']);
            // Add new object to return array.
            $return_array[] = $vraag;
        }
        return $return_array;
    }
}
?>
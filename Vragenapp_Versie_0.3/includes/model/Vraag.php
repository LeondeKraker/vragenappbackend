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
            'bijwerken' => array('filter' => FILTER_SANITIZE_STRING),
            'verwijderen' => array('filter' => FILTER_SANITIZE_STRING),
            // question
            'vraag' => array('filter' => FILTER_SANITIZE_STRING),
            // question type (open or closed)
            'vraagId' => array('filter' => FILTER_SANITIZE_INT),
            // question type (open or closed)
            'vraagSoort' => array('filter' => FILTER_SANITIZE_STRING),
            // Education
            'opleiding' => array('filter' => FILTER_SANITIZE_STRING),
            // question send time
            'verstuurTijd' => array('filter' => FILTER_SANITIZE_STRING)
        );
    // Get filtered input:
        $inputs = filter_input_array(INPUT_POST, $post_check_array);
    // RTS
        return $inputs;
    }

    /**
     * getGetValues :
     * Filter input and retrieve GET input params
     *
     * @return array containing known GET input fields
     */
    public function getGetValues()
    {
        // Define the check for params
        $get_check_array = array(
            // Action
            'action' => array('filter' => FILTER_SANITIZE_STRING),
            // Id of current row
            'vraagId' => array('filter' => FILTER_VALIDATE_INT)
        );
        // Get filtered input:
        $inputs = filter_input_array(INPUT_GET, $get_check_array);
        // RTS
        return $inputs;
    }

    /**
     * Check the action and perform action on :
     * - delete
     * - update
     * @param type $get_array all get vars en values
     * @return string the action provided by the $_GET array.
     */
    public function handleGetAction($get_array)
    {
        $action = '';

        switch ($get_array['action']) {
            case 'bijwerken':
                // Indicate current action is update if id provided
                if (!is_null($get_array['vraagId'])) {
                    $action = $get_array['action'];
                }
                break;

            case 'verwijderen':
                // Delete current id if provided
                if (!is_null($get_array['vraagId'])) {
                    $this->verwijderVraag($get_array);
                }
                $action = 'verwijderen';
                break;
            default:
                // Oops
                break;
        }
        return $action;
    }

    /**
     * The function takes the input data array and changes the
     * indexes to the column names
     * In case of update or insert action
     *
     * @param type $input_data_array data array(id, name, descpription)
     * @param type $action update | insert
     * @return type array with collumn index and values OR FALSE
     */
    private function getTableDataArray($input_data_array, $action = '')
    {

        // Get the Table Column Names.
        $keys = $this->getTableColumnNames($this->getTableName());
   
        // Get data array with table collumns
        // NULL if collumns and data does not match in count
        //
        // Note: The order of the fields shall be the same for both!
        $table_data = array_combine($keys, $input_data_array);

        switch ($action) {
            case 'bijwerken': // Intended fall-through
            case 'toevoegen':
                // Remove the index -> is primary key and can
                // therefore not be changed!
                if (!empty($table_data)) {
                    unset($table_data['vraag_id']);
                }
                break;
        // Remove
        }
        return $table_data;
    }

    /**
     * Get the column names of the specified table
     * @global type $wpdb
     * @param type $table
     * @return type
     */
    private function getTableColumnNames($table)
    {
        global $wpdb;
        try {
            $result_array = $wpdb->get_results("SELECT `COLUMN_NAME` " .
                " FROM INFORMATION_SCHEMA.COLUMNS" .
                " WHERE `TABLE_SCHEMA`='" . DB_NAME .
                "' AND TABLE_NAME = '" . $this->getTableName() . "'", ARRAY_A);
            $keys = array();
            foreach ($result_array as $idx => $row) {
                $keys[$idx] = $row['COLUMN_NAME'];
            }
            return $keys;
        } catch (Exception $exc) {
            echo $exc->getTraceAsString();
            $this->last_error = $exc->getMessage();
            return false;
        }
    }

    /**
     *
     * @global type $wpdb
     * @return type string table name with wordpress (and app prefix)
     */
    private function getTableName()
    {
        global $wpdb;
        return $table = "vraag";
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

    public function werkVraagBij($input_array)
    {
        try {
            $array_fields = array('vraagId', 'vraag', 'verstuurTijd', 'opleiding', 'vraagSoort');
            $table_fields = array('vraagId', 'vraag', 'verstuurTijd', 'opleiding', 'vraagSoort');
            $data_array = array();
            // Check fields
            foreach ($array_fields as $field) {
           
            // Check fields
                if (!isset($input_array[$field])) {
                    throw new Exception(__("$field is mandatory for update."));
                }
            // Add data_array (without hash idx) 
            // (input_array is POST data -> Could have more fields)
                $data_array[] = $input_array[$field];
            }
            global $wpdb;
           
            // Update query
            //*
            $wpdb->query($wpdb->prepare(
                "UPDATE " . $this->getTableName() .
                    " SET `vraag` = '%s', `vraag_soort` = '%s', `verstuur_tijd` = '%s' " .
                    "WHERE
           `vraag`.`vraag_id` =%d;",
                $input_array['vraag'],
                $input_array['vraagSoort'],
                $input_array['verstuurTijd'],
                $input_array['vraagId']
            ));

            $wpdb->query($wpdb->prepare(
                "UPDATE  opleiding_vraag
                     SET `opleiding_id` = '%s' " .
                    "WHERE
           `opleiding_vraag`.`vraag_id` =%d;",
                $input_array['opleiding'],
                $input_array['vraagId']
            ));
            /*/
           
            // Replace form field id index by table field id name
           
            $wpdb->update($this->getTableName(),
            $this->getTableDataArray($data_array),
            array( 'id_event_category' => $input_array['id']), // Where
            array( '%s', '%s' ), // Data format
            array( '%d' )); // Where format
            //*/

        } catch (Exception $exc) {
           
            // @todo: Fix error handlin
            echo $exc->getTraceAsString();
            $this->last_error = $exc->getMessage();
            return false;
        }
        return true;
    }


    /**
     *
     * @global type $wpdb The Wordpress database class
     * @param type $input_array containing delete id
     * @return boolean TRUE on succes OR FALSE
     */
    public function verwijderVraag($input_array)
    {
        try {
            // Check input id
            if (!isset($input_array['vraagId']))
                throw new Exception(__("Missing mandatory fields"));
            global $wpdb;
            // Delete query
            $wpdb->delete(
                $this->getTableName(),
                array('vraag_id' => $input_array['vraagId']),
                array('%d')
            ); // Where format
            //*/
   
            // Error ? It's in there:
            if (!empty($wpdb->last_error)) {

                throw new Exception($wpdb->last_error);
            }


        } catch (Exception $exc) {
            echo '<pre>';
            $this->last_error = $exc->getMessage();
            echo $exc->getTraceAsString();
            echo $exc->getMessage();
            echo '</pre>';
        }
        return true;
    }

    public function getAlleVragen()
    {
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
/*
     *vraag_id + vraag en opleiding_id + opleiding
    SELECT vraag.vraag_id, vraag.vraag, opleiding.opleiding_id, opleiding.opleiding FROM vraag 
    INNER JOIN opleiding_vraag ON vraag.vraag_id = opleiding_vraag.vraag_id INNER JOIN opleiding ON opleiding.opleiding_id = opleiding_vraag.opleiding_id
     */
}
?>
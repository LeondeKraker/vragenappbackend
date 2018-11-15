<?php

class AlarmEvents
{

    public function setId($id)
    {
        if (is_int(intval($id))) {
            $this->id = $id;
        }
    }

    public function setDate($date)
    {
        if (is_string($date)) {
            $this->date = trim($date);
        }
    }

    public function setSeverity($severity)
    {
        if (is_string($severity)) {
            $this->severity = trim($severity);
        }
    }

    public function setState($state)
    {
        if (is_string($state)) {
            $this->state = trim($state);
        }
    }

    public function setObject($object)
    {
        if (is_string($object)) {
            $this->object = trim($object);
        }
    }

    public function setMessage($message)
    {
        if (is_string($message)) {
            $this->message = trim($message);
        }
    }

    public function setAlarmPushed($alarm_pushed)
    {
        if (is_string($alarm_pushed)) {
            $this->alarm_pushed = trim($alarm_pushed);
        }
    }

    public function setAlarmNoticed($alarm_noticed)
    {
        if (is_string($alarm_noticed)) {
            $this->alarm_noticed = trim($alarm_noticed);
        }
    }
    public function setAlarmOrigin($alarm_origin)
    {
        if (is_string($alarm_origin)) {
            $this->alarm_origin = trim($alarm_origin);
        }
    }
// @return int The db id of this event
    public function getId()
    {
        return $this->id;
    }

// @return string The help text of the description
    public function getDate()
    {
        return $this->date;
    }

    public function getSeverity()
    {
        return $this->severity;
    }

    public function getState()
    {
        return $this->state;
    }

    public function getObject()
    {
        return $this->object;
    }

    public function getMessage()
    {
        return $this->message;
    }

    public function getAlarmPushed()
    {
        return $this->alarm_pushed;
    }

    public function getAlarmNoticed()
    {
        return $this->alarm_noticed;
    }
    public function getAlarmOrigin()
    {
        return $this->alarm_origin;
    }
    public function getPostValues()
    {

// Define the check for params
        $post_check_array = array(
// submit action
            'add' => array('filter' => FILTER_SANITIZE_STRING),
            'update' => array('filter' => FILTER_SANITIZE_STRING),
            // List all update form fields !!!
// event type name.
            'datum' => array('filter' => FILTER_SANITIZE_STRING),
            'prioriteit' => array('filter' => FILTER_SANITIZE_STRING),
            'username' => array('filter' => FILTER_SANITIZE_STRING),
            'user' => array('filter' => FILTER_SANITIZE_STRING),
            'password' => array('filter' => FILTER_SANITIZE_STRING),
            // Help text
            'status' => array('filter' => FILTER_SANITIZE_STRING),
            // Id of current row
            'alarm_id' => array('filter' => FILTER_VALIDATE_INT),
            'alarm_noticed' => array('filter' => FILTER_VALIDATE_INT),
            'alarm_origin' => array('filter' => FILTER_SANITIZE_STRING)
        );
// Get filtered input:
        $inputs = filter_input_array(INPUT_POST, $post_check_array);
// RTS
        return $inputs;
    }

    public function login($input_array)
    {
        if (isset($_POST['login'])) {
            global $wpdb;

            $username = $input_array['username'];
            $password = $input_array['password'];

            $creds = array();
            $creds['user_login'] = $username;
            $creds['user_password'] = $password;
            $creds['remember'] = true;

            $user = wp_signon($creds, false);

            wp_set_current_user($user);

            if (is_user_logged_in()) {
                echo $username;
            } else {
                echo "error";
            }
        }
    }

// @return type
    public function getAllAlarms()
    {
		// Includes for making CMD recognise get_results()
        include_once('C:\wamp64\www\events\wp-includes\wp-db.php');
        include_once('C:\wamp64\www\events\wp-config.php');

        global $wpdb;
        $return_array = array();

        $result_array = $wpdb->get_results("SELECT * FROM `" . $wpdb->prefix . "dnwg_alarms` WHERE `alarm_state` = '0' OR `alarm_state` = '1' ORDER BY `alarm_creation` DESC ", ARRAY_A);

        // For all database results:
        foreach ($result_array as $idx => $array) {
            // New object
            $cat = new AlarmEvents();
            // Set all info
            $cat->setId($array['alarm_id']);
            $cat->setDate($array['alarm_creation']);
            $cat->setSeverity($array['alarm_severity']);
            $cat->setState($array['alarm_state']);
            $cat->setObject($array['alarm_object']);
            $cat->setMessage($array['alarm_message']);
            $cat->setAlarmPushed($array['alarm_pushed']);
            $cat->setAlarmNoticed($array['alarm_noticed']);
            $cat->setAlarmOrigin($array['alarm_origin']);

            // Add new object to return array.
            $return_array[] = $cat;
        }
        return $return_array;
    }

    public function getNetxmsAlarms()
    {
		// Includes for making CMD recognise get_results()
        include_once('C:\wamp64\www\events\wp-includes\wp-db.php');
        include_once('C:\wamp64\www\events\wp-config.php');

        global $wpdb;
        $return_array = array();

        $result_array = $wpdb->get_results("SELECT * FROM `" . $wpdb->prefix . "dnwg_alarms` WHERE `alarm_state` = '0' AND `alarm_origin` = 'Netxms' ORDER BY `alarm_creation` DESC ", ARRAY_A);

        // For all database results:
        foreach ($result_array as $idx => $array) {
            // New object
            $cat = new AlarmEvents();
            // Set all info
            $cat->setId($array['alarm_id']);
            $cat->setDate($array['alarm_creation']);
            $cat->setSeverity($array['alarm_severity']);
            $cat->setState($array['alarm_state']);
            $cat->setObject($array['alarm_object']);
            $cat->setMessage($array['alarm_message']);
            $cat->setAlarmPushed($array['alarm_pushed']);
            $cat->setAlarmNoticed($array['alarm_noticed']);
            $cat->setAlarmOrigin($array['alarm_origin']);

            // Add new object to return array.
            $return_array[] = $cat;
        }
        return $return_array;
    }

    public function get800xaAlarms()
    {
		// Includes for making CMD recognise get_results()
        include_once('C:\wamp64\www\events\wp-includes\wp-db.php');
        include_once('C:\wamp64\www\events\wp-config.php');

        global $wpdb;
        $return_array = array();

        $result_array = $wpdb->get_results("SELECT * FROM `" . $wpdb->prefix . "dnwg_alarms` WHERE `alarm_state` = '0' AND `alarm_origin` = '800xA' ORDER BY `alarm_creation` DESC ", ARRAY_A);

        // For all database results:
        foreach ($result_array as $idx => $array) {
            // New object
            $cat = new AlarmEvents();
            // Set all info
            $cat->setId($array['alarm_id']);
            $cat->setDate($array['alarm_creation']);
            $cat->setSeverity($array['alarm_severity']);
            $cat->setState($array['alarm_state']);
            $cat->setObject($array['alarm_object']);
            $cat->setMessage($array['alarm_message']);
            $cat->setAlarmPushed($array['alarm_pushed']);
            $cat->setAlarmNoticed($array['alarm_noticed']);
            $cat->setAlarmOrigin($array['alarm_origin']);

            // Add new object to return array.
            $return_array[] = $cat;
        }
        return $return_array;
    }

// @global type $wpdb
// @return type string table name with wordpress (and app prefix)

    private function getTableName()
    {

        global $wpdb;
        return $table = $wpdb->prefix . "dnwg_alarms";
    }

    /**
     *
     * @global type $wpdb Wordpress database
     * @param type $input_array post_array
     * @return boolean TRUE on Succes else FALSE
     * @throws Exception
     */
    public function update_alarm_noticed($input_array)
    {

        try {
            $array_fields = array('alarm_id');
            $table_fields = array('alarm_noticed');
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
            $wpdb->query("UPDATE `" . $wpdb->prefix . "dnwg_alarms` SET `alarm_noticed` = '1' WHERE `alarm_id` = " . $input_array["alarm_id"] . "");
        } catch (Exception $exc) {

            // Error handling
            echo $exc->getTraceAsString();
            $this->last_error = $exc->getMessage();
            return false;
        }
        return true;
    }
	
	// Function to delete alarms from alarm view
    public function delete_alarm($input_array)
    {

        try {
            $array_fields = array('alarm_id');
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

            // Delete query
            $wpdb->query("DELETE FROM `" . $wpdb->prefix . "dnwg_alarms` WHERE `alarm_id` = " . $input_array["alarm_id"] . "");

        } catch (Exception $exc) {

            // Error handling
            echo $exc->getTraceAsString();
            $this->last_error = $exc->getMessage();
            return false;
        }
        return true;
    }
	
	 // Function for calling push notification function and updating alarm_pushed to 1 in the database
    public function update_alarm_pushed()
    {
        try {
            $alarm_events = new AlarmEvents();
            $alarms_to_push = $alarm_events->getAllAlarms();
            // For each array do the following
            foreach ($alarms_to_push as $alarms_to_push2 => $array) {
                // Variable with alarm_object
                $array_object = $array->object;
                // Variable with alarm_seveirty
                $array_severity = $array->severity;
				// Variable with alarm_origin
                $array_origin = $array->alarm_origin;
                // If alarm_pushed is 0 do the following
                if ($array->alarm_pushed == 0) {

                    global $wpdb;
                    // Update query
                    $wpdb->query("UPDATE `" . $wpdb->prefix . "dnwg_alarms` SET `alarm_pushed` = '1' WHERE `alarm_id` = " . $array->id . "");

                    // Call send_push_notification function with params
                    $alarm_events->send_push_notification($array_object, $array_severity, $array_origin);
                }
            }
        } catch (Exception $exc) {

            // Error handling
            echo $exc->getTraceAsString();
            $this->last_error = $exc->getMessage();
            return false;
        }
        return true;
    }
	
    // Function for sending push notification
    public function send_push_notification($array_object, $array_severity, $array_origin)
    {
        // Firebase's API access key
        define('API_ACCESS_KEY', 'AAAAGXtlDLw:APA91bHUj_pChKSg4U0EoMeKANnFopshPrPlTNX2SbeGl1uJVd59uFXonY65v1E9WS6RQFETekqb-DVVZ8HDNZnTVEH8atJSZ8ZgQn_R_lkhxWlLxTm19EfyBIPNJXEb3UghJZ5vX2o3');
        //Push notification title en body
        if ($array_severity == 4) {
            $msg = array(
                'title' => $array_object,
                'body' => "Status: Critical",
                'vibrate' => 1,
                'sound' => 'default'
            );
        } else if ($array_severity == 3) {
            $msg = array(
                'title' => $array_object,
                'body' => "Status: Major",
                'vibrate' => 1,
                'sound' => 'default'
            );
        } else if ($array_severity == 2) {
            $msg = array(
                'title' => $array_object,
                'body' => "Status: Minor",
                'vibrate' => 1,
                'sound' => 'default'
            );
        } else if ($array_severity == 1) {
            $msg = array(
                'title' => $array_object,
                'body' => "Status: Warning",
                'vibrate' => 1,
                'sound' => 'default'
            );
        }
        // Topic to send push notification to
        if ($array_origin === 'Netxms') {
            $fields = array(
                'condition' => "'admin' in topics || 'gebruiker2' in topics",
                'notification' => $msg
            );
        } else if ($array_origin === "800xA") {
            $fields = array(
                'condition' => "'admin' in topics || 'gebruiker3' in topics",
                'notification' => $msg
            );
        }

        // Header to prepare push notification
        $headers = array(
            'Authorization: key=' . API_ACCESS_KEY,
            'Content-Type: application/json'
        );

        // Send push notification
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, 'https://fcm.googleapis.com/fcm/send');
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($fields));
        $result = curl_exec($ch);
        curl_close($ch);
    }
}
?>
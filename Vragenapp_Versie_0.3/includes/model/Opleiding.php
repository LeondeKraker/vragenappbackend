<?php

class Opleiding
{
    /**
     *
     * @param type $opleidingId id van de opleiding
     */
    public function setOpleidingId($opleidingId)
    {
        if (is_int(intval($opleidingId))) {
            $this->opleidingId = $opleidingId;
        }
    }

    /**
     *
     * @param type $opleiding opleiding
     */
    public function setOpleiding($opleiding)
    {
        if (is_int(intval($opleiding))) {
            $this->opleiding = $opleiding;
        }
    }

    /**
     *
     * @return int de database id van deze opleiding
     */
    public function getOpleidingId()
    {
        return $this->opleidingId;
    }

    /**
     *
     * @return string de opleiding
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
            // education ID
            'opleidingId' => array('filter' => FILTER_SANITIZE_STRING),
            // education
            'opleiding' => array('filter' => FILTER_SANITIZE_STRING),
        );
    // Get filtered input:
        $inputs = filter_input_array(INPUT_POST, $post_check_array);
    // RTS
        return $inputs;
    }


    /**
     *
     * @return type
     */
    public function getAlleOpleidingen()
    {
        global $wpdb;
        $return_array = array();
        $result_array = $wpdb->get_results("SELECT `opleiding`, `opleiding_id` FROM `opleiding` ORDER BY `opleiding_id`", ARRAY_A);
        // For all database results:
        foreach ($result_array as $idx => $array) {
            // New opleiding object
            $opl = new Opleiding();
            // Set all info
            $opl->setOpleidingId($array['opleiding_id']);
            $opl->setOpleiding($array['opleiding']);
            // Add new object to return array.
            $return_array[] = $opl;
        }
        return $return_array;
    }
}
?>
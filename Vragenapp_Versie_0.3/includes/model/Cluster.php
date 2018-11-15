<?php
class Cluster
{
    /**
     *
     * @param type $clusterId id van de cluster
     */
    public function setClusterId($clusterId)
    {
        if (is_int(intval($clusterId))) {
            $this->clusterId = $clusterId;
        }
    }

    /**
     *
     * @param type $cluster cluster
     */
    public function setCluster($cluster)
    {
        if (is_int(intval($cluster))) {
            $this->cluster = $cluster;
        }
    }

    /**
     *
     * @return int de database id van deze cluster
     */
    public function getClusterId()
    {
        return $this->clusterId;
    }

    /**
     *
     * @return string de cluster
     */
    public function getCluster()
    {
        return $this->cluster;
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
            // education
            'cluster' => array('filter' => FILTER_SANITIZE_STRING),
        );
    // Get filtered input:
        $inputs = filter_input_array(INPUT_POST, $post_check_array);
    // RTS
        return $inputs;
    }
}
?>
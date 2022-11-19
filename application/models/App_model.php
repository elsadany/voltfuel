<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class App_model extends MY_Model {

    public function __construct() {
        parent::__construct();

        $this->current_session = $this->setting_model->getCurrentSession();
        $this->current_session_name = $this->setting_model->getCurrentSessionName();
        $this->start_month = $this->setting_model->getStartMonth();
    }

    /**
     * This funtion takes id as a parameter and will fetch the record.
     * If id is not provided, then it will fetch all the records form the table.
     * @param int $id
     * @return mixed
     */
    public function getoutlets() {
        $this->db->select('*')->from('outlets');
        $this->db->order_by('id');
        $query = $this->db->get();
        return $query->result_array();

    }

    public function getstations(){
        $lat=37.386337;
        $lng=-122.085823;
        $imageurl = site_url('uploads/outlets/images/');
        $this->db->select("outlets.id, outlets.outlet_name, outlets.lat, outlets.lng, outlets.operation_mode, outlets.operation_time, outlets.weekdays,
                            outlets.support, outlets.address, outlets.city, CONCAT('$imageurl',outlets.id,'/',outlets.image1) as image1, CONCAT('$imageurl',outlets.id,'/',outlets.image2) as image2, CONCAT('$imageurl',outlets.id,'/',outlets.image3) as image3, CONCAT('$imageurl',outlets.id,'/',outlets.image4) as image4,
                            stations.is_online, stations.is_active, stations.batteries, stations.avl_batteries,        
                            (6371*acos(cos(radians($lat))*cos(radians(outlets.lat))*cos(radians(outlets.lng)-radians($lng))+sin(radians($lat))*sin(radians(outlets.lng)))) AS distance1");
        $this->db->join("outlets", "stations.outlet_id = outlets.id");
        $this->db->where("outlets.is_active", 'yes');
        $query = $this->db->get("stations");
        return $query->result_array();
    }

    public function insertapplogs($response){

        $message = "API CALL RESPONSE".json_encode($response);
        //echo $message;
        $action = "Insert";
        $record_id = time();
        $this->log($message, $record_id, $action);

    }

    public function apiattemptlog($data){

        $message = "API CALL ATTEMPT".json_encode($data);
        //echo $message;
        $action = "API CALL Attempt";
        $record_id = time();
        $this->log($message, $record_id, $action);

    }

    public function addinstallation($data){
        $this->log("Device Installation Attempt with Data: ".json_encode($data), time(), 'Test Attempt');
        if($this->db->insert('installs', $data)){
            $insert_id = $this->db->insert_id();
            $message   = INSERT_RECORD_CONSTANT . " On installs id " . $insert_id.' Data: '.json_encode($data);
            $action    = "Insert";
            $record_id = $insert_id;
            $this->log($message, $record_id, $action);
            return $insert_id;
        }else{
            return null;
        }

        
    }

    public function getsubscriber($mobileno){

        return $this->db->get_where('subscribers', array('mobileno'=>$mobileno))->row();
    
    }

    public function addsubscriber($data){
        if($this->db->insert('subscribers', $data)){
            $insert_id = $this->db->insert_id();
            $message   = INSERT_RECORD_CONSTANT . " On subscribers id " . $insert_id.' Data: '.json_encode($data);
            $action    = "Insert";
            $record_id = $insert_id;
            $this->log($message, $record_id, $action);
            return $insert_id;
        }else{
            $error = $this->db->error();
            return $error;
        }

    }

    public function updatesubscriber($data, $subscriberid){
        if(isset($subscriberid)){
            $this->db->where('mobileno', $data["mobileno"]);
            $status = $this->db->update('subscribers', $data);
            $message   = UPDATE_RECORD_CONSTANT . " On subscribers id " . $data["mobileno"].' Data: '.json_encode($data);
            $action    = "Update";
            $record_id = $data["mobileno"];
            $this->log($message, $record_id, $action);
            //return true;
            return true;
        }else{
            return false;
        }
    }

    public function subscribetoplan($mobileno, $plan_id){
        $planid = array();
        $planid = $this->db->select('active_plan')->from('subscribers')->where('mobileno',$mobileno)->get()->row('active_plan');
        if(isset($planid)){
            $planid = json_decode($planid,true);
            if (!in_array($plan_id,$planid)){
                array_push($planid, $plan_id);
            }
        }else{
            $planid = array();
            array_push($planid, $plan_id);
        }
        $data = array(
            'active_plan' => json_encode($planid,true)
        );
        $this->db->where('mobileno', $mobileno);
        $this->db->update('subscribers', $data);
        $message   = UPDATE_RECORD_CONSTANT . " On subscribers id " . $mobileno.' Data: '.json_encode($data);
        $action    = "Update";
        $record_id = $mobileno;
        $this->log($message, $record_id, $action);
        return true;
    }

    public function unsubscribeplan($mobileno, $plan_id){
        $planid = array();
        $planid = $this->db->select('active_plan')->from('subscribers')->where('mobileno',$mobileno)->get()->row('active_plan');
        // $planid == null ? $planid = array() : $planid;
        if (isset($planid) || ($planid != null)){
            $planid = json_decode($planid,true);
            if (in_array($plan_id,$planid)){
                if (($key = array_search($plan_id, $planid )) !== false) {
                    unset($planid[$key]);
                }

                $data = array(
                    'active_plan' => json_encode($planid,true)
                );
                $this->db->where('mobileno', $mobileno);
                $this->db->update('subscribers', $data);
                $message   = UPDATE_RECORD_CONSTANT . " On subscribers id " . $mobileno.' Data: '.json_encode($data);
                $action    = "Update";
                $record_id = $mobileno;
                $this->log($message, $record_id, $action);
            }
            return true;
        }
            return false;

    }

    public function issubscriberexists($mobileno,$email){
        $this->db->select('mobileno');
        $this->db->where('mobileno',$mobileno);
        $query = $this->db->get("subscribers");

        $this->db->select('email');
        $this->db->where('email',$email);
        $query2 = $this->db->get("subscribers");
        if (($query->num_rows() == 1) || ($query2->num_rows() == 1)){
            return true;
        }else{
            return false;
        }
    }

    public function isdeviceexists($deviceid){
        $this->db->select('device_id');
        $this->db->where('device_id',$deviceid);
        $query = $this->db->get("installs");
        if ($query->num_rows() == 1){
            return true;
        }else{
            return false;
        }
    }

    public function getpricingcategories(){
        return $this->db->get_where('pricing_categories')->result();
    }

    public function getpricingplans(){
        return $this->db->get_where('pricing_plans')->result();
    }

    public function getactiveplans($mobileno){
        return $this->db->get_where('subscribers', array('mobileno'=>$mobileno))->row('active_plan');
    }

    public function getplanamount($plan_id){
        return $this->db->get_where('pricing_plans', array('id'=>$plan_id))->row('max_charges');
    }

    public function getsubscriberid($mobileno){
        return $this->db->get_where('subscribers', array('mobileno'=>$mobileno))->row('id');
    }

    public function getorders($subscriber_id){
        return $this->db->get_where('vw_orders', array('subscriber_id'=>$subscriber_id))->result();
    }

    public function createorder(){

    }

    public function savecard($data){
        if($this->db->insert('cards', $data)){
            $insert_id = $this->db->insert_id();
            $message   = INSERT_RECORD_CONSTANT . " On cards id " . $insert_id.' Data: '.json_encode($data);
            $action    = "Insert";
            $record_id = $insert_id;
            $this->log($message, $record_id, $action);
            return $insert_id;
        }else{
            $error = $this->db->error();
            return $error;
        }

    }

    public function getcards($subscriber_id){
        return $this->db->get_where('cards', array('subscriber_id'=>$subscriber_id))->result();
    }

    public function getActiveCard($subscriber_id){
        return $this->db->select('*')->from('cards')->where(array('subscriber_id'=>$subscriber_id, 'is_active'=>1))->limit(1)->get()->row_array();
    }



    public function getreferralsources(){

        return $this->db->get_where('reference')->result_array();
  

    }
}           
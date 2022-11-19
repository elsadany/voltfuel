<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Stations_model extends MY_Model {

    public function __construct() {
        parent::__construct();
    }

    /**
     * This funtion takes id as a parameter and will fetch the record.
     * If id is not provided, then it will fetch all the records form the table.
     * @param int $id
     * @return mixed
     */
    public function get($id = null) {
        $this->db->select()->from('stations');
        if ($id != null) {
            $this->db->where('stations.id', $id);
        } else {
            $this->db->order_by('stations.id');
        }
        $query = $this->db->get();
        if ($id != null) {
            return $query->row_array();
        } else {
            return $query->result_array();
        }
    }

    public function getstationlist() {

       $this->datatables
            ->select('outlets.outlet_name,stations.station_id')
            ->searchable('outlets.outlet_name')
            ->orderable('outlets.outlet_name')
            ->join('outlets', 'outlets.id = stations.outlet_id')
            ->from('stations');
            return $this->datatables->generate('json');
    }

    /**
     * This function will delete the record based on the id
     * @param $id
     */
    public function remove($id) {
        $this->db->trans_start(); # Starting Transaction
        $this->db->trans_strict(false); # See Note 01. If you wish can remove as well
        //=======================Code Start===========================
        $this->db->where('id', $id);
        $this->db->delete('outlets');
        $this->db->where('book_id', $id);
        $this->db->delete('book_issues');
        $message = DELETE_RECORD_CONSTANT . " On outlets id " . $id;
        $action = "Delete";
        $record_id = $id;
        $this->log($message, $record_id, $action);
        //======================Code End==============================
        $this->db->trans_complete(); # Completing transaction
        /* Optional */
        if ($this->db->trans_status() === false) {
            # Something went wrong.
            $this->db->trans_rollback();
            return false;
        } else {
            //return $return_value;
        }
    }

    /**
     * This function will take the post data passed from the controller
     * If id is present, then it will do an update
     * else an insert. One function doing both add and edit.
     * @param $data
     */
    public function addstation($data) {
        $this->db->trans_start(); # Starting Transaction
        $this->db->trans_strict(false); # See Note 01. If you wish can remove as well
        //=======================Code Start===========================
        if (isset($data['id'])) {
            $this->db->where('id', $data['id']);
            $this->db->update('stations', $data);
            $message = UPDATE_RECORD_CONSTANT . " On stations id " . $data['id'];
            $action = "Update";
            $record_id = $data['id'];
            $this->log($message, $record_id, $action);
            //======================Code End==============================

            $this->db->trans_complete(); # Completing transaction
            /* Optional */

            if ($this->db->trans_status() === false) {
                # Something went wrong.
                $this->db->trans_rollback();
                return false;
            } else {
                //return $return_value;
            }
        } else {
            $this->db->insert('stations', $data);
            $insert_id = $this->db->insert_id();
            $message = INSERT_RECORD_CONSTANT . " On stations id " . $insert_id;
            $action = "Insert";
            $record_id = $insert_id;
            $this->log($message, $record_id, $action);
            //======================Code End==============================

            $this->db->trans_complete(); # Completing transaction
            /* Optional */

            if ($this->db->trans_status() === false) {
                # Something went wrong.
                $this->db->trans_rollback();
                return false;
            } else {
                //return $return_value;
            }
            return $insert_id;
        }
    }

    public function liststations($filter) {
        $this->db->select('stations.*, outlets.outlet_name')->from('stations');
        $this->db->join('outlets', 'outlets.id = stations.outlet_id');
        $this->db->order_by("id", "desc");
        
        if($filter == "yes"){
            $this->db->where('is_online', $filter);
        }
        if($filter == "no"){
            $this->db->where('is_online', $filter);
        }

        $liststations= $this->db->get();
        return $liststations->result_array();

        // $this->db->select()->from('stations');
        // $this->db->order_by("id", "desc");
        // $liststations= $this->db->get();
        // return $liststations->result_array();
    }

    public function getstations(){
        $this->db->select('stations.*, outlets.outlet_name')->from('stations');
        $this->db->join('outlets', 'outlets.id = stations.outlet_id');
        $this->db->order_by('outlets.outlet_name');
        $query = $this->db->get();
        return $query->result_array();
    }

    public function getstationdetails($id)
    {
        $this->db->select('stations.*, outlets.outlet_name')->from('stations');
        $this->db->join('outlets', 'outlets.id = stations.outlet_id');
        $this->db->where('id',$id);
        $this->db->order_by('outlets.outlet_name');
        $query = $this->db->get();
        return $query->result_array();
    }

    public function updatestationstatus($data){
        $this->db->trans_start(); # Starting Transaction
        $this->db->trans_strict(false); # See Note 01. If you wish can remove as well
        $this->db->where('station_id', $data['station_id']);
        $this->db->update('stations', $data);
        $this->db->trans_complete(); # Completing transaction
        /* Optional */

        if ($this->db->trans_status() === false) {
            # Something went wrong.
            $this->db->trans_rollback();
            return false;
        } else {
            //return $return_value;
        }
        return true;
        //print_r($data);
    }

    public function getdeviceid($qrcode){
        $this->db->select('station_id', 'is_online')->from('stations');
        $this->db->where('qr_code',$qrcode);
        $query =  $this->db->get()->row('station_id');
        return $query;

    }

    public function updateavailablebatteries($deviceid,$batteries){
        $data['avl_batteries'] = $batteries;
        $data['station_id'] = $deviceid;
        $this->db->where('station_id', $data['station_id']);
        $this->db->update('stations', $data);
    }

    public function makestationactive($id){
        $is_active='yes';
        $this->db->set('is_active',$is_active);
        $this->db->where('id',$id);
        $this->db->update('stations');
        return $this->db->affected_rows();
    }   

    public function makestationinactive($id){
        $is_active='no';
        $this->db->set('is_active',$is_active);
        $this->db->where('id',$id);
        $this->db->update('stations');
        return $this->db->affected_rows();
    } 

    public function checkuploadimage($id,$data_doc){
        $this->db->set('station_image',$data_doc);
        $this->db->where('id',$id);
        $this->db->update('stations');
        return $this->db->affected_rows();
    }

}
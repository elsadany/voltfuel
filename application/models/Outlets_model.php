<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Outlets_model extends MY_Model {

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
        $this->db->select()->from('outlets');
        if ($id != null) {
            $this->db->where('outlets.id', $id);
        } else {
            $this->db->order_by('outlets.id');
        }
        $query = $this->db->get();
        if ($id != null) {
            return $query->row_array();
        } else {
            return $query->result_array();
        }
    }

    public function getoutletlist() {

       $this->datatables
            ->select('outlets.*,IFNULL(total_issue, "0") as `total_issue` ')
            ->searchable('outlet_name')
            ->orderable('outlet_name')
            ->join(" (SELECT COUNT(*) as `total_outlets`)")
            ->from('outlets');
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
    public function addoutlet($data) {
        $this->db->trans_start(); # Starting Transaction
        $this->db->trans_strict(false); # See Note 01. If you wish can remove as well
        //=======================Code Start===========================
        if (isset($data['id'])) {
            $this->db->where('id', $data['id']);
            $this->db->update('outlets', $data);
            $message = UPDATE_RECORD_CONSTANT . " On outlets id " . $data['id'];
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
            $this->db->insert('outlets', $data);
            $insert_id = $this->db->insert_id();
            $message = INSERT_RECORD_CONSTANT . " On outlets id " . $insert_id;
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

    public function listoutlets() {
        $this->db->select()->from('outlets');
        $this->db->order_by("id", "desc");
        $listoutlets= $this->db->get();
        return $listoutlets->result_array();
    }

    public function makeoutletactive($id){
        $is_active='yes';
        $this->db->set('is_active',$is_active);
        $this->db->where('id',$id);
        $this->db->update('outlets');
        return $this->db->affected_rows();
    }   

    public function makeoutletinactive($id){
        $is_active='no';
        $this->db->set('is_active',$is_active);
        $this->db->where('id',$id);
        $this->db->update('outlets');
        return $this->db->affected_rows();
    }   

    public function filterlistoutlets($filter)
    {
        $this->db->select('*')->from('outlets');
        $this->db->order_by("id", "desc");
        
        if($filter == "yes"){
            $this->db->where('is_active', $filter);
        }
        if($filter == "no"){
            $this->db->where('is_active', $filter);
        }

        $listoutlets= $this->db->get();
        return $listoutlets->result_array();
    }

    public function getoutletid($deviceid){
        return $this->db->select('outlet_id')->from('stations')->where('station_id',$deviceid)->get()->row('outlet_id');
    }
}

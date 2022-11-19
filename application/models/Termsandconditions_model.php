<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Termsandconditions_model extends MY_Model {

    public function __construct() {
        parent::__construct();
    }

    public function addtermsandconditions($data) {
        $this->db->trans_start(); # Starting Transaction
        $this->db->trans_strict(false); # See Note 01. If you wish can remove as well
        //=======================Code Start===========================
        if (isset($data['id'])) {
            $this->db->where('id', $data['id']);
            $this->db->update('termsandconditions', $data);
            $message = UPDATE_RECORD_CONSTANT . " On Termsandconditions id " . $data['id'];
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
            $this->db->insert('termsandconditions', $data);
            $insert_id = $this->db->insert_id();
            $message = INSERT_RECORD_CONSTANT . " On Termsandconditions id " . $insert_id;
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

    public function termsandconditionslist() {
        $this->db->select('*')->from('termsandconditions');
        $this->db->order_by("id", "desc");
        return $this->db->get()->result_array();
    }

    public function get($id)
    {
        $this->db->select('*')->from('termsandconditions');
        $this->db->where('id',$id);
        return $this->db->get()->row_array();
    }

    public function deletetermsandconditions($id)
    {
        $this->db->where('id',$id);
        $this->db->delete('termsandconditions');
        return $this->db->affected_rows();  
    }

}

?>
<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Pricings_model extends MY_Model {

    public function __construct() {
        parent::__construct();

        $this->current_session = $this->setting_model->getCurrentSession();
        $this->current_session_name = $this->setting_model->getCurrentSessionName();
        $this->start_month = $this->setting_model->getStartMonth();
    }

    public function getcategories($id = null) {
        $this->db->select()->from('pricing_categories');
        if ($id != null) {
            $this->db->where('id', $id);
        } else {
            $this->db->order_by('id');
        }
        $query = $this->db->get();
        if ($id != null) {
            return $query->row_array();
        } else {
            return $query->result_array();
        }
    }

    public function getplansbycategory($categoryid = null) {
        $this->db->select()->from('pricing_plans');
        if ($categoryid != null) {
            $this->db->where('plan_categoryid', $categoryid);
        } else {
            $this->db->order_by('id');
        }
        $query = $this->db->get();
        return $query->result_array();

    }

    public function getplans($id = null) {
        $this->db->select('pp.id,pp.plan_name,pp.plan_type,pp.plan_amount,pp.plan_categoryid,pp.plan_description,pp.is_active,pp.payment_mode_id,pp.max_rental_period,pp.max_charges,pp.no_of_swaps,pp.validity_months,pp.penalty_amount,pc.category')->from('pricing_plans pp');
        $this->db->join('pricing_categories pc','pc.id = pp.plan_categoryid');
        if ($id != null) {
            $this->db->where('pp.id', $id);
        } else {
            $this->db->order_by('pp.id');
        }
        $query = $this->db->get();
        if ($id != null) {
            return $query->row_array();
        } else {
            return $query->result_array();
        }
    }    


    public function getplandetails($id = null)
    {
        $this->db->select('pp.id,pp.plan_name,pp.plan_type,pp.plan_amount,pp.plan_categoryid,pp.plan_description,pp.is_active,pp.payment_mode_id,pp.max_rental_period,pp.max_charges,pp.no_of_swaps,pp.validity_months,pp.penalty_amount,pc.category')->from('pricing_plans pp');
        $this->db->join('pricing_categories PC','PC.id = PP.plan_categoryid');
        if ($id != null) {
            $this->db->where('pp.id', $id);
        } else {
            $this->db->order_by('pp.id');
        }
        $query = $this->db->get();
        if ($id != null) {
            return $query->row_array();
        } else {
            return $query->result_array();
        }

    }

    public function addcategory($data) {
        $this->db->trans_start(); # Starting Transaction
        $this->db->trans_strict(false); # See Note 01. If you wish can remove as well
        //=======================Code Start===========================
        if (isset($data['id'])) {
            $this->db->where('id', $data['id']);
            $this->db->update('pricing_categories', $data);
            $message = UPDATE_RECORD_CONSTANT . " On pricing_categories id " . $data['id'];
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
            $this->db->insert('pricing_categories', $data);
            $insert_id = $this->db->insert_id();
            $message = INSERT_RECORD_CONSTANT . " On pricing_categories id " . $insert_id;
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

    public function addplan($data) {
        $this->db->trans_start(); # Starting Transaction
        $this->db->trans_strict(false); # See Note 01. If you wish can remove as well
        //=======================Code Start===========================
        if (isset($data['id'])) {
            $this->db->where('id', $data['id']);
            $this->db->update('pricing_plans', $data);
            $message = UPDATE_RECORD_CONSTANT . " On pricing_plans id " . $data['id'];
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
            $this->db->insert('pricing_plans', $data);
            $insert_id = $this->db->insert_id();
            $message = INSERT_RECORD_CONSTANT . " On pricing_plans id " . $insert_id;
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

    public function deleteplan($planid){
       return $this->db->where('id',$planid)->delete('pricing_plans');
    }

    public function makepricingactive($id){
        $is_active='yes';
        $this->db->set('is_active',$is_active);
        $this->db->where('id',$id);
        $this->db->update('pricing_categories');
        return $this->db->affected_rows();
    }   

    public function makepricinginactive($id){
        $is_active='no';
        $this->db->set('is_active',$is_active);
        $this->db->where('id',$id);
        $this->db->update('pricing_categories');
        return $this->db->affected_rows();
    } 
}
?>
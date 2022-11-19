<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Orders_model extends MY_Model {

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
        $this->db->select()->from('vw_orders');
        if ($id != null) {
            $this->db->where('vw_orders.id', $id);
        } else {
            $this->db->order_by('vw_orders.id');
        }
        $query = $this->db->get();
        if ($id != null) {
            return $query->row_array();
        } else {
            return $query->result_array();
        }
    }

  

    public function listorders($filter) {
        $this->db->select()->from('vw_orders');
        $this->db->order_by("id", "desc");
        
        if($filter == "completed"){
            $this->db->where('order_status', $filter);
        }
        if($filter == "pending"){
            $this->db->where('order_status', $filter);
        }
        $listorders= $this->db->get();
        return $listorders->result_array();
    }

    public function getorderdetails($orderid)
    {
        $this->db->select('od.order_id,od.issued_at,od.order_status,date(od.issued_at) as issued_date,TIME_FORMAT(od.issued_at,"%h:%i%p") as issued_time,ot.outlet_name as issuedoutlet,ot.lat as issuedlat,ot.lng as issuedlng,od.returned_at,date(od.returned_at) as returned_date, TIME_FORMAT(od.returned_at,"%h:%i%p") as returned_time,os.outlet_name as returnedoutlet,os.lat as returnedlat,os.lng as returnedlng,od.total_amount,pp.plan_name,pp.plan_type,pp.plan_amount')->from('orders od');
        // $this->db->join('subscribers sub','sub.id=od.subscriber_id');
        $this->db->join('stations st','st.id=od.issued_outlet','left');
        $this->db->join('stations sr','sr.id=od.returned_outlet','left');
        $this->db->join('outlets ot','ot.id=st.outlet_id','left');
        $this->db->join('outlets os','os.id=sr.outlet_id','left');
        $this->db->join('pricing_plans pp','pp.id=od.plan_id','left');
        $this->db->where('od.order_id',$orderid);
        return $this->db->get()->row_array();
     }


     public function getpendingorderdetails($orderid)
     {
         $this->db->select('od.order_id,od.issued_at,od.order_status,date(NOW()) as cur_date,TIME_FORMAT(NOW(),"%h:%i%p") as cur_time,date(od.issued_at) as issued_date,TIME_FORMAT(od.issued_at,"%h:%i%p") as issued_time,ot.outlet_name as issuedoutlet,ot.lat as issuedlat,ot.lng as issuedlng,od.returned_at,date(od.returned_at) as returned_date, TIME_FORMAT(od.returned_at,"%h:%i%p") as returned_time,os.outlet_name as returnedoutlet,os.lat as returnedlat,os.lng as returnedlng,od.total_amount,pp.plan_name,pp.plan_type,pp.plan_amount,(TIMESTAMPDIFF(MINUTE, od.issued_at, NOW()) * pp.plan_amount) as total')->from('orders od');
         $this->db->join('stations st','st.id=od.issued_outlet','left');
         $this->db->join('stations sr','sr.id=od.returned_outlet','left');
         $this->db->join('outlets ot','ot.id=st.outlet_id','left');
         $this->db->join('outlets os','os.id=sr.outlet_id','left');
         $this->db->join('pricing_plans pp','pp.id=od.plan_id','left');
         $this->db->where('od.order_id',$orderid);
         return $this->db->get()->row_array();
      }

      public function createorder($data){
        $this->db->insert('orders', $data);
        $insert_id = $this->db->insert_id();
        $message = INSERT_RECORD_CONSTANT . " On Orders id " . $insert_id;
        $action = "Insert";
        $record_id = $insert_id;
        $this->log($message, $record_id, $action);
        return $insert_id;
    }

    public function returnorder($data,$orderid){
        $this->db->where('order_id',$orderid);
        $this->db->update('orders', $data);
        $message = UPDATE_RECORD_CONSTANT . " On Return Orders id " . $orderid;
        $action = "Battery Return";
        $record_id =$orderid;
        $this->log($message, $record_id, $action);
        return true;
    }

    public function getOrderDetailsFromBattery($battery){
        return $this->db->select()->from('orders')->where(array('battery_id'=>$battery,'order_status'=>'Pending'))->get()->row_array();
    }
     
}

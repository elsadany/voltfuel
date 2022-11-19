<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Dashboard_model extends MY_Model {

    public function __construct() {
        parent::__construct();
    }

    public function getliststations() {
        $this->db->select('stations.*, outlets.outlet_name,outlets.lat,outlets.lng,outlets.is_active')->from('stations');
        $this->db->join('outlets', 'outlets.id = stations.outlet_id');
        $this->db->order_by("id", "desc");
        $liststations= $this->db->get();
        return $liststations->result_array();

        // $this->db->select()->from('stations');
        // $this->db->order_by("id", "desc");
        // $liststations= $this->db->get();
        // return $liststations->result_array();
    }

    public function getnostations()
    {
        return $this->db->select('count(*) as count')->from('stations')->get()->row('count');
    }
    public function getactivestations()
    {
        return $this->db->select('count(is_active) as count')->from('stations')->where('is_active','yes')->get()->row('count');
    }

    public function getnooutlets()
    {
        return $this->db->select('count(*) as count')->from('outlets')->get()->row('count');
    }
    public function getactiveoutlets()
    {
        return $this->db->select('count(is_active) as count')->from('outlets')->where('is_active','yes')->get()->row('count');
    }

    public function getonlinestations()
    {
        return $this->db->select('count(is_online) as count')->from('stations')->where('is_online','yes')->get()->row('count');
    }

    public function getnobatteries()
    {
        return $this->db->select('sum(batteries) as count')->from('stations')->get()->row('count');
    }

     public function getavaliablebatteries()
    {
        return $this->db->select('sum(avl_batteries) as count')->from('stations')->get()->row('count');
    }
    
    public function gettodaycollections()
    {
         $this->db->select('IFNULL(sum(total_amount),0) as count')->from('orders');
         $this->db->where('order_status','Completed');
         $this->db->where('issued_at',date('Y-m-d'));
         return $this->db->get()->row('count');
    }

    public function gettotalincome()
    {
        $this->db->select('year(issued_at) as year,month(issued_at) as month, monthname(issued_at) as monthname, sum(total_amount) as total')->from('orders');
        $this->db->group_by('year(issued_at)','month(issued_at)');
        $this->db->order_by('year(issued_at)','month(issued_at)');
        return $this->db->get()->result_array();
    }

    public function getmonthlycollections($date){
        // $this->db->select('date(issued_at) as date,sum(total_amount) as total')->from('orders');
        // $this->db->where('date(issued_at) >=', $startdate);
        // $this->db->where('date(issued_at) <=', $enddate);
        // $this->db->group_by('date(issued_at)');
        // $this->db->order_by('date(issued_at) ASC');
        // return $this->db->get()->result_array();
        // $data['date'] = date('Y-m-d', strtotime($date));
        // $data['collections'] = $this->db->select('IFNULL(sum(total_amount),0) as total,date(issued_at) as date')->from('orders')->where('date(issued_at)',$date)->group_by('date(issued_at)')->order_by('date(issued_at)')->get()->row('total');
        // return $data;
        $data['date'] = date('Y-m-d', strtotime($date));
        $data['collections'] = $this->db->select('IFNULL(sum(total_amount),0) as total,date(issued_at) as date')->from('orders')->where('date(issued_at)',$date)->get()->row('total');
        return $data;
    }

    // public function getissuedbatteries($startdate,$enddate)
    // {
    //     $this->db->select('year(issued_at) as year,month(issued_at) as month, monthname(issued_at) as monthname,date(issued_at) as date, count(issued_outlet) as issued')->from('orders');
    //     $this->db->where('date(issued_at) >=', $startdate);
    //     $this->db->where('date(issued_at) <=', $enddate);
    //     $this->db->group_by('date(issued_at)');
    //     $this->db->order_by('date(issued_at) ASC');
    //     return $this->db->get()->result_array();
    // }

    // public function getreturnedbatteries($startdate,$enddate)
    // {
    //     $this->db->select('year(returned_at) as year,month(returned_at) as month, monthname(returned_at) as monthname,date(returned_at) as date, count(returned_outlet) as returned')->from('orders');
    //     $this->db->where('date(returned_at) >=', $startdate);
    //     $this->db->where('date(returned_at) <=', $enddate);
    //     $this->db->where('date(returned_at) !=', 'NULL');
    //     $this->db->group_by('date(returned_at)');
    //     $this->db->order_by('date(returned_at) ASC');
    //     return $this->db->get()->result_array();
    // }

    public function getissuedreturn($date){
        $data['date'] = date('Y-m-d', strtotime($date));
        $data['issued']  = $this->db->select('count(*) as counts')->from('orders')->where('date(issued_at)',$date)->get()->row('counts');
        $data['returned']  = $this->db->select('count(*) as counts')->from('orders')->where('date(returned_at)',$date)->get()->row('counts');
        //$data['issued'] = $this->db->query("SELECT count(*) as counts FROM orders where date(issued_at)=$date")->num_rows();
        //$data['returned'] = $this->db->query("SELECT count(*) as counts FROM orders where date(returned_at)=$date")->row('counts');
        return $data;
    }

    public function getmonthlysubscribers($date)
    {
        // $this->db->select('date(created_at) as date,count(created_at) as total')->from('subscribers');
        // $this->db->where('date(created_at) >=', $startdate);
        // $this->db->where('date(created_at) <=', $enddate);
        // // $this->db->group_by('date(created_at)');
        // // $this->db->order_by('date(created_at) ASC');
        // return $this->db->get()->result_array();
        $data['date'] = date('Y-m-d', strtotime($date));
        $data['subscribers'] = $this->db->select('count(created_at) as count')->from('subscribers')->where('date(created_at)',$date)->get()->row('count');
        return $data;
    }

    public function getosplatform()
    {
        return $this->db->select('os_platform as label,count(os_platform) as value')->from('installs')->group_by('os_platform')->order_by('os_platform')->get()->result_array();
    }

    public function getmobilemake()
    {
        return $this->db->select('mobile_make as label,count(mobile_make) as value')->from('installs')->group_by('mobile_make')->order_by('mobile_make')->get()->result_array();
    }

}

?>

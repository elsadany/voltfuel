<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Test extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->library('Enc_lib');

    }

    public function index(){
        echo "Test";
    }

	public function dcrypt()
	{
        //$string = "$2y$10\$GbALQ4ffU7tzYUdNx26gk.ozrMSRsLCDXPEy6lnTGm8Qlm7zUr37C";
        $string = "WlRTaDk0elI4MGFsWlNSeTc3ejBxQT09";
		$password = $this->enc_lib->dycrypt($string);
        echo "Password: ".$password;
	}

    public function encrypt($string){
        $password = $this->enc_lib->encrypt($string);
        echo "Password: ".$password;
    }

    public function hashpass($password){
        $password = $this->enc_lib->passHashEnc($password);
        echo "Password: ".$password;
    }

    public function get(){
        $url = "http://sensemeters.com/vfadmin/app/getplanamount?apikey=apikey&planid=5";

        $curl = curl_init($url);
        curl_setopt($curl, CURLOPT_URL, $url);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
    
        //for debug only!
        curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, false);
        curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);
    
        $resp = curl_exec($curl);
        curl_close($curl);
        $resp = json_decode($resp,true);
        echo $resp['msg'];
    }

    public function gettotalincome()
    {   
        $this->db->select('year(issued_at),monthname(issued_at),sum(total_amount)')->from('orders');
        $this->db->group_by('year(issued_at)','month(issued_at)');
        $this->db->order_by('year(issued_at)','month(issued_at)');
        $data=$this->db->get()->row_array();
         //$data = $this->db->select('sum(total_amount) as total_income,year(issued_at) as Year')->from('orders')->get()->row_array();
         print_r($data);
    }
    public function gettodaycollections()
    {
         $this->db->select('IFNULL(sum(total_amount),0) as count')->from('orders');
         $this->db->where('order_status','Completed');
         $this->db->where('issued_at',date('Y-m-d'));
        echo  $this->db->get()->row('count');
    }

    public function getmonthlycollections($date){
        // $this->db->select('date(issued_at) as date,sum(total_amount) as total')->from('orders');
        // $this->db->where('date(issued_at) >=', $startdate);
        // $this->db->where('date(issued_at) <=', $enddate);
        // $this->db->group_by('date(issued_at)');
        // $this->db->order_by('date(issued_at) ASC');
        // return $this->db->get()->result_array();
        $data['date'] = date('Y-m-d', strtotime($date));
        $data['collections'] = $this->db->select('IFNULL(sum(total_amount),0) as total,date(issued_at) as date')->from('orders')->where('date(issued_at)',$date)->group_by('date(issued_at)')->order_by('date(issued_at)')->get()->row('total');
        print_r($data);
    }

    public function getsubscribers(){
        return $this->db->query("select count(od.subscriber_id) as active_rent, count(os.subscriber_id) as total_rent,IFNULL(os.total_amount,0) as total_amount,sub.* from subscribers sub left join orders od on od.subscriber_id = sub.id and od.order_status='Pending' left join orders os on os.subscriber_id = sub.id and os.order_status='Completed' group by sub.id")->result_array();
    }



}
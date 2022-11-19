<?php

if (!defined('BASEPATH')) {
    exit('No direct script access allowed');
} 

class Orders extends Admin_Controller
{

    public function __construct()
    {
        parent::__construct();
        $this->load->model("orders_model");
        $this->load->model("encryption_model");
        $this->load->library('encoding_lib');


    }



    public function index(){

        $this->session->set_userdata('top_menu', 'Orders');
        //$this->session->set_userdata('sub_menu', 'exam/index'
        
        $data['title'] = 'VoltaFuel Admin - Manage Orders';
        $data['title_list'] = 'Orders List';
        $data['listview'] = '';
        $data['gridview'] = 'active';

        $this->load->view('layout/header', $data);
        $this->load->view('orders/orders_head', $data);
        $this->load->view('orders/orders', $data);
        //$this->load->view('orders/orders_modals', $data);
        $this->load->view('layout/footer', $data);
        $this->load->view('orders/orders_scripts', $data);
        $this->load->view('layout/footer-bottom', $data);

    }


    
    public function view($orderid,$status=null){
        $orderid =  $this->enc_lib->dycrypt($orderid);
        $status  =  $this->enc_lib->dycrypt($status);
        if($status =='Pending')
        {
            $this->session->set_userdata('top_menu', 'Orders');

            $data['title'] = 'VoltaFuel Admin - View Orders';
            $data['orderid']=$orderid;
            $data['orderdetails'] = $this->orders_model->getpendingorderdetails($orderid);
            //print_r($data);
            $this->load->view('layout/header', $data);
            $this->load->view('orders/orders_pending_view',$data);
            $this->load->view('layout/footer', $data);
            // $this->load->view('orders/orders_scripts', $data);
            $this->load->view('layout/footer-bottom', $data);
        }
        else
        {
            $this->session->set_userdata('top_menu', 'Orders');

            $data['title'] = 'VoltaFuel Admin - View Orders';
            $data['orderid']=$orderid;
            $data['orderdetails'] = $this->orders_model->getorderdetails($orderid);
            //print_r($data);
            $this->load->view('layout/header', $data);
            $this->load->view('orders/orders_view',$data);
            $this->load->view('layout/footer', $data);
            $this->load->view('orders/orders_scripts', $data);
            $this->load->view('layout/footer-bottom', $data);
        }

    }

    public function print($orderid)
    {
        $this->session->set_userdata('top_menu', 'Orders');

        $data['title'] = 'VoltaFuel Admin - View Orders';
        //$orderid = $this->input->post('orderid');
        $orderid =  $this->enc_lib->dycrypt($orderid);
        $data['orderdetails'] = $this->orders_model->getorderdetails($orderid);
        $this->load->view('orders/orders_print',$data);

    }

    public function pending_order_print($orderid)
    {
        $this->session->set_userdata('top_menu', 'Orders');

        $data['title'] = 'VoltaFuel Admin - View Orders';
        //$orderid = $this->input->post('orderid');
        $orderid =  $this->enc_lib->dycrypt($orderid);
        $data['orderdetails'] = $this->orders_model->getpendingorderdetails($orderid);
        $this->load->view('orders/orders_pending_print',$data);
    }

    public function getorders(){
        $filter = $this->input->post('orderstatus');
        $listorders        = $this->orders_model->listorders($filter);
        $data['listoutlets'] = $listorders;
        $html="";
        if (isset($listorders)){
            $html .= "<table class='table table-striped custom-table datatable'>";
            $html .= "<thead>
                        <tr>
                        <th>S.No</th>
                        <th>Order ID</th>
                        <th>Battery  ID</th>
                        <th>Subscriber ID</th>
                        <th>Total Amount</th>
                        <th>Tariff</th>
                        <th>Plan Type</th>
                        <th>Order Status</th>
                        <th>Issued Outlet Name</th>
                        <th>Issued At</th>
                        <th>Return Outlet Name</th>
                        <th>Return At</th>
                        </tr>
                      </thead>";
            $html .= "<tbody>";
            $i=1;
            foreach($listorders as $order){
                $html .= "<tr>";
                $html .= "<td>".$i."</td>";
                $html .= "<td><a href='".base_url()."admin/orders/view/" .$this->enc_lib->encrypt($order['order_id'])."/" .$this->enc_lib->encrypt($order['order_status'])."' class='text-primary'>".$order['order_id']."</a></td>";
                $html .= "<td>".$order['battery_id']."</td>";
                $html .= "<td>".$order['subscriber_id']."</td>";
                $html .= "<td>".$order['total_amount']."</td>";
                $html .= "<td>".$order['tariff']."</td>";
                $html .= "<td>".$order['order_status']."</td>";
                $html .= "<td>".$order['plantype']."</td>";
                $html .= "<td>".$order['issuedoutlet_name']."</td>";
                $html .= "<td>".$order['issued_at']."</td>";
                $html .= "<td>".$order['returnedoutlet_name']."</td>";
                $html .= "<td>".$order['returned_at']."</td>";
                $html .= "</tr>";
                $i++;
            }

            $html .= "</tbody>";

        }else{
            $html = "<div id = 'msg' class='error_message'>No Records Found</div>";
        }     
        echo $html;

    }

}


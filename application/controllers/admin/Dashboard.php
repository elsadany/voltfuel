<?php

if (!defined('BASEPATH')) {
    exit('No direct script access allowed');
} 

class Dashboard extends Admin_Controller
{

    public function __construct()
    {
        parent::__construct();
        $this->load->model("outlets_model");
        $this->load->model("encryption_model");
        $this->load->model('filetype_model');
        $this->load->library('encoding_lib');
        $this->load->model("dashboard_model");

    }



    public function index(){

        if (!$this->rbac->hasPrivilege('dashboard', 'can_view')) {
            access_denied();
        }

        $this->session->set_userdata('top_menu', 'Dashboard');
        //$this->session->set_userdata('sub_menu', 'exam/index'
        $data['title']      = 'Dashboard';
        $listoutlets         = $this->outlets_model->listoutlets();
        $data['listoutlets'] = $listoutlets;
        $data['getnostations']=$this->dashboard_model->getnostations();
        $data['getnooutlets']=$this->dashboard_model->getnooutlets();
        $data['getactivestations']=$this->dashboard_model->getactivestations();
        $data['getactiveoutlets']=$this->dashboard_model->getactiveoutlets();
        $data['getonlinestations']=$this->dashboard_model->getonlinestations();
        $data['getnobatteries']=$this->dashboard_model->getnobatteries();
        $data['getavaliablebatteries']=$this->dashboard_model->getavaliablebatteries();
        $data['gettodaycollections']=$this->dashboard_model->gettodaycollections();
        // $annualincome = $this->dashboard_model->gettotalincome();
        // $year = date('Y');
        // $totalincome = array();
        // foreach($annualincome as $annualincome){
        //     for($i=1;$i<=12;$i++){
        //         if($annualincome['year']==$year){
        //            if($annualincome['month'] == $i){
        //                 $i < 10 ? $i='0'.$i : $i;
        //                $data1['month'] = date($i.'-Y');
        //                $data1['total'] = $annualincome['total'];
        //                array_push($totalincome, $data1);
        //            }else{
        //                $i < 10 ? $i='0'.$i : $i;
        //                $data1['month'] = date($i.'-Y');
        //                $data1['total'] = 0.000;
        //                array_push($totalincome, $data1);
        //            }
        //        }
   
        //    }
        // }
        // $data['totalincome'] = json_encode($totalincome);
        // $startdate = date('Y-m-01');
        // $enddate = date("Y-m-t", strtotime($startdate));
        
        // $monthlycollection = array();
        // for($i=$startdate;$i<=$enddate;$i++)
        // {
        //     array_push($monthlycollection, $this->dashboard_model->getmonthlycollections($i));

        // }        
        // $data['monthlycollections']= json_encode($monthlycollection);
        // $issuereturn = array();
        // for($i=$startdate;$i<=$enddate;$i++)
        // {
        //     array_push($issuereturn, $this->dashboard_model->getissuedreturn($i));
        // }
        // $data['issuedreturned']=json_encode($issuereturn);

        // $subscriber =array();
        // for($i=$startdate;$i<=$enddate;$i++)
        // {
        //     array_push($subscriber, $this->dashboard_model->getmonthlysubscribers($i));
        // }
        // $data['subscribers']=json_encode($subscriber);
        //$data['osplatform']=json_encode($this->dashboard_model->getosplatform());
        //$data['mobilemake']=json_encode($this->dashboard_model->getmobilemake());
        // $subscribers = $this->dashboard_model->getmonthlysubscribers($startdate,$enddate);
        // echo "<pre>"; print_r($subscribers); echo "</pre>";
        // $subscriber = array();
        // for($subscribers as $subscribers)
        // {
        //     for($i=$startdate;$i<=$enddate;$i++)
        //     {
        //         //echo "<br>".$i;
        //         if($subscribers['date']==$i)
        //         {
        //             echo "available";
        //             $data1['date']=$i;
        //             $data1['total']=$subscribers['total'];
        //             // echo $data1['total']."<br>";
        //             array_push($subscriber, $data1);
        //         }
        //         else
        //         {
        //             //echo "notavailable";
        //             $data1['date']=$i;
        //             $data1['total']=0.00;
        //             array_push($subscriber, $data1);
        //         }
        //     }
        // }

        //  $data['subscribers']=json_encode($subscriber);
        // // $data['totaloutcome']=$this->dashboard_model->gettotaloutcome();
        // // $data['totalsales']=$this->dashboard_model->gettotalsales();
        // // $data['totalrevenue']=$this->dashboard_model->gettotalrevenue();
        $this->load->view('layout/header', $data);
        $this->load->view('dashboard/dashboard', $data);
        $this->load->view('layout/footer', $data);
        $this->load->view('dashboard/dashboard-scripts', $data);
        $this->load->view('layout/footer-bottom', $data);
     }

    public function getstations(){

        $liststations       = $this->dashboard_model->getliststations();
        echo json_encode($liststations);
    }

    public function gettotalrevenue()
    {
        $annualincome = $this->dashboard_model->gettotalincome();
        $year = date('Y');
        $totalincome = array();
        foreach($annualincome as $annualincome){
            for($i=1;$i<=12;$i++){
                if($annualincome['year']==$year){
                   if($annualincome['month'] == $i){
                        $i < 10 ? $i='0'.$i : $i;
                       $data1['month'] = date($i.'-Y');
                       $data1['total'] = $annualincome['total'];
                       array_push($totalincome, $data1);
                   }else{
                       $i < 10 ? $i='0'.$i : $i;
                       $data1['month'] = date($i.'-Y');
                       $data1['total'] = 0.000;
                       array_push($totalincome, $data1);
                   }
               }
   
           }
        }
        echo json_encode($totalincome);
    }

    public function getsalesoverview()
    {
        $startdate = date('Y-m-01');
        $enddate = date("Y-m-t", strtotime($startdate));
        $monthlycollection = array();
        for($i=$startdate;$i<=$enddate;$i++)
        {
            array_push($monthlycollection, $this->dashboard_model->getmonthlycollections($i));

        }        
        echo json_encode($monthlycollection);
    }

    public function getissuedreturnedbatteries()
    {
        $startdate = date('Y-m-01');
        $enddate = date("Y-m-t", strtotime($startdate));
        $issuereturn = array();
        for($i=$startdate;$i<=$enddate;$i++)
        {
            array_push($issuereturn, $this->dashboard_model->getissuedreturn($i));
        }
        echo json_encode($issuereturn);
    }

    public function getsubscribers()
    {
        $startdate = date('Y-m-01');
        $enddate = date("Y-m-t", strtotime($startdate));
        $subscriber =array();
        for($i=$startdate;$i<=$enddate;$i++)
        {
            array_push($subscriber, $this->dashboard_model->getmonthlysubscribers($i));
        }
        echo json_encode($subscriber);
    }

    public function getosplatform()
    {
        $osplatform=$this->dashboard_model->getosplatform();
        echo json_encode($osplatform);
    }

    public function getmobilemake()
    {
        $mobilemake=$this->dashboard_model->getmobilemake();
        echo json_encode($mobilemake);
    }

}
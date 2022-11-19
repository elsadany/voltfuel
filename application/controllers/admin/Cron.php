<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Cron extends CI_Controller 
{

    public function __construct()
    {
        parent::__construct();
        error_reporting(0);
    }
    
    public function checkdevices(){
        if($this->input->is_cli_request()==false){
            $this->kickout();
        }else{
            $this->db->select('station_id')->from('stations');
            $query = $this->db->get()->result_array();
            foreach($query as $value){
                $device_id = $value['station_id'];
                $data = file_get_contents("https://admin.voltafuel.site:6001/middle/v1-1/heart?equipment_sn=".$device_id);
                $data = json_decode ($data,true);

                if ($data['msg'] == "OK"){
                $last_login = $data['body']['heart_stamp'];
                $current_time = time();
                //echo 'Equipment: '.$last_login;
                //echo 'Current: '.$current_time;
                if (($last_login - time()) <= 5){
                    $data['status'] = "Online";
                }else{
                    $timezone = "Asia/Kolkata";
                    $dt = new DateTime();
                    $dt->setTimestamp($last_login);
                    $dt->setTimezone(new DateTimeZone($timezone));
                    $datetime = $dt->format('d-M-Y H:i:s');
                    $data['status'] = "Offline";
                    $data['last_seen']  = $datetime;
                }
                }else{
                    $data['status'] = 'Error';
                }
                echo json_encode($data).PHP_EOL;

            }
        }
        
    }

    public function kickout(){
        echo "OPERATION NOT PERMITTED IN THIS MODE";
    }
}
?>
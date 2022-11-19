<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Payment_model extends MY_Model {

    public function __construct() {
        parent::__construct();

        $this->current_session = $this->setting_model->getCurrentSession();
        $this->current_session_name = $this->setting_model->getCurrentSessionName();
        $this->start_month = $this->setting_model->getStartMonth();
    }

}
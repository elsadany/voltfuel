<?php

if (!defined('BASEPATH')) {
    exit('No direct script access allowed');
}

class Subscribers_model extends MY_Model
{

    public function __construct()
    {
        parent::__construct();
        $this->current_session = $this->setting_model->getCurrentSession();
        $this->current_date    = $this->setting_model->getDateYmd();
    }


    public function getAppsubscribers()
    {
        $this->db->select('classes.id AS `class_id`,subscriber_session.id as subscriber_session_id,subscribers.id,classes.class,sections.id AS `section_id`,sections.section,subscribers.id,subscribers.admission_no , subscribers.roll_no,subscribers.admission_date,subscribers.firstname,  subscribers.middlename,subscribers.lastname,subscribers.image,    subscribers.mobileno, subscribers.email ,subscribers.state ,   subscribers.city , subscribers.pincode ,     subscribers.religion,     subscribers.dob ,subscribers.current_address,    subscribers.permanent_address,IFNULL(subscribers.category_id, 0) as `category_id`,IFNULL(categories.category, "") as `category`,subscribers.adhar_no,subscribers.samagra_id,subscribers.bank_account_no,subscribers.bank_name, subscribers.ifsc_code , subscribers.guardian_name , subscribers.app_key ,subscribers.guardian_relation,subscribers.guardian_phone,subscribers.guardian_address,subscribers.is_active ,subscribers.created_at ,subscribers.updated_at,subscribers.father_name,subscribers.rte,subscribers.gender,users.id as `user_tbl_id`,users.username,users.password as `user_tbl_password`,users.is_active as `user_tbl_active`')->from('subscribers');
        $this->db->join('subscriber_session', 'subscriber_session.subscriber_id = subscribers.id');
        $this->db->join('classes', 'subscriber_session.class_id = classes.id');
        $this->db->join('sections', 'sections.id = subscriber_session.section_id');
        $this->db->join('categories', 'subscribers.category_id = categories.id', 'left');
        $this->db->join('users', 'users.user_id = subscribers.id', 'left');
        $this->db->where('subscriber_session.session_id', $this->current_session);
        $this->db->where('subscribers.is_active', 'yes');
        $this->db->where('subscribers.app_key !=', "");
        $this->db->where('users.role', 'subscriber');

        $this->db->order_by('subscribers.id');

        $query = $this->db->get();
        return $query->result();
    }

    public function getRecentRecord($id = null)
    {
        $this->db->select('classes.id AS `class_id`,classes.class,sections.id AS `section_id`,sections.section,subscribers.id,subscribers.admission_no , subscribers.roll_no,subscribers.admission_date,subscribers.firstname, subscribers.middlename, subscribers.lastname,subscribers.image,    subscribers.mobileno, subscribers.email ,subscribers.state ,   subscribers.city , subscribers.pincode ,     subscribers.religion,     subscribers.dob ,subscribers.current_address,    subscribers.permanent_address,subscribers.category_id,    subscribers.adhar_no,subscribers.samagra_id,subscribers.bank_account_no,subscribers.bank_name, subscribers.ifsc_code , subscribers.guardian_name , subscribers.guardian_relation,subscribers.guardian_phone,subscribers.guardian_address,subscribers.is_active ,subscribers.created_at ,subscribers.updated_at,subscribers.father_name,subscribers.father_phone,subscribers.father_occupation,subscribers.mother_name,subscribers.mother_phone,subscribers.mother_occupation,subscribers.guardian_occupation,subscribers.gender,subscribers.guardian_is')->from('subscribers');
        $this->db->join('subscriber_session', 'subscriber_session.subscriber_id = subscribers.id');
        $this->db->join('classes', 'subscriber_session.class_id = classes.id');
        $this->db->join('sections', 'sections.id = subscriber_session.section_id');
        $this->db->where('subscriber_session.session_id', $this->current_session);
        if ($id != null) {
            $this->db->where('subscribers.id', $id);
        } else {

        }
        $this->db->order_by('subscribers.id', 'desc');
        $this->db->limit(5);
        $query = $this->db->get();
        if ($id != null) {
            return $query->row_array();
        } else {
            return $query->result_array();
        }
    }


    public function getBysubscriberSession($subscriber_session_id)
    {
        $this->db->select('subscriber_session.transport_fees,subscribers.app_key,subscribers.vehroute_id,vehicle_routes.route_id,vehicle_routes.vehicle_id,transport_route.route_title,vehicles.vehicle_no,hostel_rooms.room_no,vehicles.driver_name,vehicles.driver_contact,hostel.id as `hostel_id`,hostel.hostel_name,room_types.id as `room_type_id`,room_types.room_type ,subscribers.hostel_room_id,subscriber_session.id as `subscriber_session_id`,subscriber_session.fees_discount,classes.id AS `class_id`,classes.class,sections.id AS `section_id`,sections.section,class_sections.id as `class_section_id`,subscribers.id,subscribers.admission_no , subscribers.roll_no,subscribers.admission_date,subscribers.firstname,subscribers.middlename,  subscribers.lastname,subscribers.image,    subscribers.mobileno, subscribers.email ,subscribers.state ,   subscribers.city , subscribers.pincode , subscribers.note, subscribers.religion, subscribers.cast, school_houses.house_name,   subscribers.dob ,subscribers.current_address, subscribers.previous_school,
            subscribers.guardian_is,subscribers.parent_id,
            subscribers.permanent_address,subscribers.category_id,subscribers.adhar_no,subscribers.samagra_id,subscribers.bank_account_no,subscribers.bank_name, subscribers.ifsc_code , subscribers.guardian_name , subscribers.father_pic ,subscribers.height ,subscribers.weight,subscribers.measurement_date, subscribers.mother_pic , subscribers.guardian_pic , subscribers.guardian_relation,subscribers.guardian_phone,subscribers.guardian_address,subscribers.is_active ,subscribers.created_at ,subscribers.updated_at,subscribers.father_name,subscribers.father_phone,subscribers.blood_group,subscribers.school_house_id,subscribers.father_occupation,subscribers.mother_name,subscribers.mother_phone,subscribers.mother_occupation,subscribers.guardian_occupation,subscribers.gender,subscribers.guardian_is,subscribers.rte,subscribers.guardian_email, users.username,users.password,subscribers.dis_reason,subscribers.dis_note,subscribers.app_key,subscribers.parent_app_key')->from('subscribers');
        $this->db->join('subscriber_session', 'subscriber_session.subscriber_id = subscribers.id');
        $this->db->join('classes', 'subscriber_session.class_id = classes.id');
        $this->db->join('sections', 'sections.id = subscriber_session.section_id');
        $this->db->join('class_sections', 'class_sections.class_id = classes.id and class_sections.section_id = sections.id');

        $this->db->join('hostel_rooms', 'hostel_rooms.id = subscribers.hostel_room_id', 'left');
        $this->db->join('hostel', 'hostel.id = hostel_rooms.hostel_id', 'left');
        $this->db->join('room_types', 'room_types.id = hostel_rooms.room_type_id', 'left');
        $this->db->join('vehicle_routes', 'vehicle_routes.id = subscribers.vehroute_id', 'left');
        $this->db->join('transport_route', 'vehicle_routes.route_id = transport_route.id', 'left');
        $this->db->join('vehicles', 'vehicles.id = vehicle_routes.vehicle_id', 'left');
        $this->db->join('school_houses', 'school_houses.id = subscribers.school_house_id', 'left');
        $this->db->join('users', 'users.user_id = subscribers.id', 'left');

        $this->db->where('subscriber_session.session_id', $this->current_session);
        $this->db->where('users.role', 'subscriber');

        $this->db->where('subscriber_session.id', $subscriber_session_id);

        $query = $this->db->get();

        return $query->row_array();
    }

    public function get($id = null)
    {
        $this->db->select('*')->from('subscribers');
        $this->db->join('subscriber_devices', 'subscribers.id = subscriber_devices.subscriber_id');
        $this->db->join('installs', 'installs.device_id = subscriber_devices.device_id');
        $this->db->join('users', 'users.user_id = subscribers.id', 'left');
        $this->db->where('users.role', 'subscriber');
        if ($id != null) {
            $this->db->where('subscribers.id', $id);
        } else {
            $this->db->where('subscribers.is_active', 'yes');
            $this->db->order_by('subscribers.id', 'desc');
        }
        $query = $this->db->get();
        if ($id != null) {
            return $query->row_array();
        } else {
            return $query->result_array();
        }
    }

    public function getsubscribers(){

        // $this->db->select('*')->from('subscribers');
        // $query = $this->db->get();
        // return $query->result_array();
        return $this->db->query("select count(od.subscriber_id) as active_rent, count(os.subscriber_id) as total_rent,IFNULL(os.total_amount,0) as total_amount,sub.* from subscribers sub left join orders od on od.subscriber_id = sub.id and od.order_status='Pending' left join orders os on os.subscriber_id = sub.id and os.order_status='Completed' group by sub.id")->result_array();
    }

    public function makesubscriberactive($id){
        $is_active='yes';
        $this->db->set('is_active',$is_active);
        $this->db->where('id',$id);
        $this->db->update('subscribers');
        return $this->db->affected_rows();
    }   

    public function makesubscriberinactive($id){
        $is_active='no';
        $this->db->set('is_active',$is_active);
        $this->db->where('id',$id);
        $this->db->update('subscribers');
        return $this->db->affected_rows();
    }  

    public function getinstallations(){
        $this->db->select('*')->from('installs');
        $query = $this->db->get();
        return $query->result_array();
   
    }

    public function findByInstallation($installation_no = null)
    {

    }



    public function search_subscriber($id)
    {
        $this->db->select('classes.id AS `class_id`,classes.class,sections.id AS `section_id`,sections.section,subscribers.id,subscribers.admission_no , subscribers.roll_no,subscribers.admission_date,subscribers.firstname,subscribers.middlename,  subscribers.lastname,subscribers.image,    subscribers.mobileno, subscribers.email ,subscribers.state ,   subscribers.city , subscribers.pincode ,     subscribers.religion,     subscribers.dob ,subscribers.current_address,    subscribers.permanent_address,subscribers.category_id,    subscribers.adhar_no,subscribers.samagra_id,subscribers.bank_account_no,subscribers.bank_name, subscribers.ifsc_code , subscribers.guardian_name , subscribers.guardian_relation,subscribers.guardian_phone,subscribers.guardian_address,subscribers.is_active ,subscribers.created_at ,subscribers.updated_at,subscribers.father_name,subscribers.father_phone,subscribers.father_occupation,subscribers.mother_name,subscribers.mother_phone,subscribers.mother_occupation,subscribers.guardian_occupation')->from('subscribers');
        $this->db->join('subscriber_session', 'subscriber_session.subscriber_id = subscribers.id');
        $this->db->join('classes', 'subscriber_session.class_id = classes.id');
        $this->db->join('sections', 'sections.id = subscriber_session.section_id');
        $this->db->where('subscriber_session.session_id', $this->current_session);
        if ($id != null) {
            $this->db->where('subscribers.id', $id);
        } else {
            $this->db->order_by('subscribers.id');
        }
        $query = $this->db->get();
        if ($id != null) {
            return $query->row_array();
        } else {
            return $query->result_array();
        }
    }

    public function getsubscriberdoc($id)
    {
        $this->db->select()->from('subscriber_doc');
        $this->db->where('subscriber_id', $id);
        $query = $this->db->get();
        return $query->result_array();
    }

    public function getDatatableByClassSection($class_id = null, $section_id = null)
    {
        $this->datatables
            ->select('classes.id as `class_id`,subscriber_session.id as subscriber_session_id,subscribers.id,classes.class,sections.id as `section_id`,sections.section,subscribers.id,subscribers.admission_no , subscribers.roll_no,subscribers.admission_date,subscribers.firstname,subscribers.middlename,  subscribers.lastname,subscribers.image,    subscribers.mobileno, subscribers.email ,subscribers.state ,   subscribers.city , subscribers.pincode ,     subscribers.religion,     subscribers.dob ,subscribers.current_address,    subscribers.permanent_address,IFNULL(subscribers.category_id, 0) as `category_id`,IFNULL(categories.category, "") as `category`,subscribers.adhar_no,subscribers.samagra_id,subscribers.bank_account_no,subscribers.bank_name, subscribers.ifsc_code , subscribers.guardian_name , subscribers.guardian_relation,subscribers.guardian_phone,subscribers.guardian_address,subscribers.is_active ,subscribers.created_at ,subscribers.updated_at,subscribers.father_name,subscribers.app_key,subscribers.parent_app_key,subscribers.rte,subscribers.gender')
            ->searchable('class_id,section_id,admission_no,subscribers.firstname,subscribers.middlename,  subscribers.lastname,subscribers.father_name,subscribers.dob,subscribers.guardian_phone')
            ->orderable('class_id,section_id,admission_no,subscribers.firstname,subscribers.father_name,subscribers.dob,subscribers.guardian_phone')
            ->join('subscriber_session', 'subscriber_session.subscriber_id = subscribers.id')
            ->join('classes', 'subscriber_session.class_id = classes.id')
            ->join('sections', 'sections.id = subscriber_session.section_id')
            ->join('categories', 'subscribers.category_id = categories.id', 'left')
            ->where('subscriber_session.session_id', $this->current_session)
            ->where('subscribers.is_active', "yes")
            ->sort('subscribers.admission_no', 'asc');
        if ($class_id != null) {
            $this->datatables->where('subscriber_session.class_id', $class_id);
        }
        if ($section_id != null) {
            $this->datatables->where('subscriber_session.section_id', $section_id);
        }
        //     ->order_by('subscribers.admission_no', 'asc')

        $this->datatables->from('subscribers');
        return $this->datatables->generate('json');
    }

    public function getDatatableByFullTextSearch($searchterm)
    {
        $this->datatables->select('`classes`.`id` as `class_id`,`subscribers`.`id`,`subscriber_session`.`id` as `subscriber_session_id`,`classes`.`class`,sections.id as `section_id`,sections.section,subscribers.id,subscribers.admission_no, subscribers.roll_no,subscribers.admission_date,subscribers.firstname,subscribers.middlename,  subscribers.lastname,subscribers.image,    subscribers.mobileno, subscribers.email ,subscribers.state ,   subscribers.city , subscribers.pincode ,     subscribers.religion,     subscribers.dob ,subscribers.current_address,    subscribers.permanent_address,IFNULL(subscribers.category_id, 0) as `category_id`,IFNULL(categories.category, "") as `category`,      subscribers.adhar_no,subscribers.samagra_id,subscribers.bank_account_no,subscribers.bank_name, subscribers.ifsc_code ,subscribers.father_name , subscribers.guardian_name , subscribers.guardian_relation,subscribers.guardian_phone,subscribers.guardian_address,subscribers.is_active ,subscribers.created_at ,subscribers.updated_at,subscribers.gender,subscribers.rte,subscriber_session.session_id');
        $this->datatables->join('subscriber_session', 'subscriber_session.subscriber_id = subscribers.id');
        $this->datatables->join('classes', 'subscriber_session.class_id = classes.id');
        $this->datatables->join('sections', 'sections.id = subscriber_session.section_id');
        $this->datatables->join('categories', 'subscribers.category_id = categories.id', 'left');
        $this->datatables->join('school_houses', 'subscribers.school_house_id = school_houses.id', 'left');
        $this->datatables->group_start();
        $this->datatables->or_like_string('subscribers.firstname,subscribers.middlename,subscribers.lastname,school_houses.house_name,subscribers.guardian_name,subscribers.adhar_no,subscribers.samagra_id,subscribers.roll_no,subscribers.admission_no,subscribers.mobileno,subscribers.email,subscribers.religion,subscribers.cast,subscribers.gender,subscribers.current_address,subscribers.permanent_address,subscribers.blood_group,subscribers.bank_name,subscribers.ifsc_code,subscribers.father_name,subscribers.father_phone,subscribers.father_occupation,subscribers.mother_name,subscribers.mother_phone,subscribers.mother_occupation,subscribers.guardian_name,subscribers.guardian_relation,subscribers.guardian_phone,subscribers.guardian_occupation,subscribers.guardian_address,subscribers.guardian_email,subscribers.previous_school,subscribers.note', $searchterm); 
        $this->datatables->group_end();
        $this->datatables->where('subscriber_session.session_id', $this->current_session);
        $this->datatables->where('subscribers.is_active', 'yes');
        $this->datatables->sort('subscribers.admission_no', 'asc');
        $this->datatables->searchable('class_id,section_id,admission_no,subscribers.firstname,subscribers.middlename,  subscribers.lastname,subscribers.father_name,subscribers.dob,subscribers.guardian_phone');
        $this->datatables->orderable('class_id,section_id,admission_no,subscribers.firstname,subscribers.father_name,subscribers.dob,subscribers.guardian_phone');
        $this->datatables->from('subscribers');
        return $this->datatables->generate('json');
    }

    public function searchByClassSection($class_id = null, $section_id = null)
    {

        $i = 1;

        $custom_fields   = $this->customfield_model->get_custom_fields('subscribers', 1);
        $field_var_array = array();
        if (!empty($custom_fields)) {
            foreach ($custom_fields as $custom_fields_key => $custom_fields_value) {
                $tb_counter = "table_custom_" . $i;
                array_push($field_var_array, 'table_custom_' . $i . '.field_value as ' . $custom_fields_value->name);
                $this->db->join('custom_field_values as ' . $tb_counter, 'subscribers.id = ' . $tb_counter . '.belong_table_id AND ' . $tb_counter . '.custom_field_id = ' . $custom_fields_value->id, 'left');
                $i++;
            }
        }

        $field_variable = implode(',', $field_var_array);

        $this->db->select('classes.id AS `class_id`,subscriber_session.id as subscriber_session_id,subscribers.id,classes.class,sections.id AS `section_id`,sections.section,subscribers.id,subscribers.admission_no , subscribers.roll_no,subscribers.admission_date,subscribers.firstname,subscribers.middlename,  subscribers.lastname,subscribers.image,    subscribers.mobileno, subscribers.email ,subscribers.state ,   subscribers.city , subscribers.pincode ,     subscribers.religion,     subscribers.dob ,subscribers.current_address,    subscribers.permanent_address,IFNULL(subscribers.category_id, 0) as `category_id`,IFNULL(categories.category, "") as `category`,subscribers.adhar_no,subscribers.samagra_id,subscribers.bank_account_no,subscribers.bank_name, subscribers.ifsc_code , subscribers.guardian_name , subscribers.guardian_relation,subscribers.guardian_phone,subscribers.guardian_address,subscribers.is_active ,subscribers.created_at ,subscribers.updated_at,subscribers.father_name,subscribers.app_key,subscribers.parent_app_key,subscribers.rte,subscribers.gender,' . $field_variable)->from('subscribers');
        $this->db->join('subscriber_session', 'subscriber_session.subscriber_id = subscribers.id');
        $this->db->join('classes', 'subscriber_session.class_id = classes.id');
        $this->db->join('sections', 'sections.id = subscriber_session.section_id');
        $this->db->join('categories', 'subscribers.category_id = categories.id', 'left');
        $this->db->where('subscriber_session.session_id', $this->current_session);
        $this->db->where('subscribers.is_active', "yes");
        if ($class_id != null) {
            $this->db->where('subscriber_session.class_id', $class_id);
        }
        if ($section_id != null) {
            $this->db->where('subscriber_session.section_id', $section_id);
        }
        $this->db->order_by('subscribers.admission_no', 'asc');

        $query = $this->db->get();

        return $query->result_array();
    }

    

    public function searchByClassSectionWithoutCurrent($class_id = null, $section_id = null, $subscriber_id = null)
    {
        $this->db->select('classes.id AS `class_id`,subscriber_session.id as subscriber_session_id,subscribers.id,classes.class,sections.id AS `section_id`,sections.section,subscribers.id,subscribers.admission_no , subscribers.roll_no,subscribers.admission_date,subscribers.firstname,subscribers.middlename,  subscribers.lastname,subscribers.image,    subscribers.mobileno, subscribers.email ,subscribers.state ,   subscribers.city , subscribers.pincode ,     subscribers.religion,     subscribers.dob ,subscribers.current_address,    subscribers.permanent_address,IFNULL(subscribers.category_id, 0) as `category_id`,IFNULL(categories.category, "") as `category`,subscribers.adhar_no,subscribers.samagra_id,subscribers.bank_account_no,subscribers.bank_name, subscribers.ifsc_code , subscribers.guardian_name , subscribers.guardian_relation,subscribers.guardian_phone,subscribers.guardian_address,subscribers.is_active ,subscribers.created_at ,subscribers.updated_at,subscribers.father_name,subscribers.rte,subscribers.gender')->from('subscribers');
        $this->db->join('subscriber_session', 'subscriber_session.subscriber_id = subscribers.id');
        $this->db->join('classes', 'subscriber_session.class_id = classes.id');
        $this->db->join('sections', 'sections.id = subscriber_session.section_id');
        $this->db->join('categories', 'subscribers.category_id = categories.id', 'left');
        $this->db->where('subscriber_session.session_id', $this->current_session);
        $this->db->where('subscribers.is_active', "yes");
        $this->db->where('subscribers.id !=', $subscriber_id);
        if ($class_id != null) {
            $this->db->where('subscriber_session.class_id', $class_id);
        }
        if ($section_id != null) {
            $this->db->where('subscriber_session.section_id', $section_id);
        }
        $this->db->order_by('subscribers.id');

        $query = $this->db->get();

        return $query->result_array();
    }

   

    public function searchdatatableByClassSectionCategoryGenderRte($class_id = null, $section_id = null
        , $category = null, $gender = null, $rte = null) {
       
        if ($class_id != null) {
            $this->datatables->where('subscriber_session.class_id', $class_id);
        }
        if ($section_id != null) {
            $this->datatables->where('subscriber_session.section_id', $section_id);
        }
        if ($category != null) {
            $this->datatables->where('subscribers.category_id', $category);
        }
        if ($gender != null) {
            $this->datatables->where('subscribers.gender', $gender);
        }
        if ($rte != null) {
            $this->datatables->where('subscribers.rte', $rte);
        }
      
         $this->datatables->select('classes.id AS `class_id`,subscriber_session.id as subscriber_session_id,subscribers.id,classes.class,sections.id AS `section_id`,sections.section,subscribers.id,subscribers.admission_no , subscribers.roll_no,subscribers.admission_date,subscribers.firstname,subscribers.middlename,  subscribers.lastname,subscribers.image,    subscribers.mobileno, subscribers.email ,subscribers.state ,   subscribers.city , subscribers.pincode ,     subscribers.religion,     subscribers.dob ,subscribers.current_address,    subscribers.permanent_address,subscribers.category_id, categories.category,   subscribers.adhar_no,subscribers.samagra_id,subscribers.bank_account_no,subscribers.bank_name, subscribers.ifsc_code , subscribers.guardian_name , subscribers.guardian_relation,subscribers.guardian_phone,subscribers.guardian_address,subscribers.is_active ,subscribers.created_at ,subscribers.updated_at,subscribers.father_name,subscribers.rte,subscribers.gender')
        
        ->searchable('sections.section,subscribers.admission_no,subscribers.firstname,subscribers.father_name,subscribers.dob,subscribers.gender,categories.category,subscribers.mobileno,subscribers.samagra_id,subscribers.adhar_no,subscribers.rte')
        ->orderable('sections.section,subscribers.admission_no,subscribers.firstname,subscribers.father_name,subscribers.dob,subscribers.gender,categories.category,subscribers.mobileno,subscribers.samagra_id,subscribers.adhar_no,subscribers.rte')
        ->join('subscriber_session', 'subscriber_session.subscriber_id = subscribers.id')
        ->join('classes', 'subscriber_session.class_id = classes.id')
        ->join('sections', 'sections.id = subscriber_session.section_id')
        ->join('categories', 'subscribers.category_id = categories.id', 'left')
        ->where('subscriber_session.session_id', $this->current_session)
        ->where('subscribers.is_active', 'yes')
        ->sort('subscribers.id')
        ->from('subscribers');
        return $this->datatables->generate('json');
    }

 


    public function searchFullText($searchterm, $carray = null)
    {
        $userdata = $this->customlib->getUserData();
        $staff_id = $userdata['id'];

        $i             = 1;
        $custom_fields = $this->customfield_model->get_custom_fields('subscribers', 1);

        $field_var_array = array();
        $field_var_array_name =array();
        if (!empty($custom_fields)) {
            foreach ($custom_fields as $custom_fields_key => $custom_fields_value) {
                $tb_counter = "table_custom_" . $i;
                array_push($field_var_array, 'table_custom_' . $i . '.field_value as ' . $custom_fields_value->name);
                $this->db->join('custom_field_values as ' . $tb_counter, 'subscribers.id = ' . $tb_counter . '.belong_table_id AND ' . $tb_counter . '.custom_field_id = ' . $custom_fields_value->id, 'left');
                array_push($field_var_array_name,'table_custom_' . $i . '.field_value');
                $i++;
               
            }
        }
        $field_variable = (empty($field_var_array))? "": ",".implode(',', $field_var_array);
        $field_name = (empty($field_var_array_name))? "": ",".implode(',', $field_var_array_name);


        if (($userdata["role_id"] == 2) && ($userdata["class_teacher"] == "yes")) {
            if (!empty($carray)) {

                $this->db->where_in("subscriber_session.class_id", $carray);
                $sections = $this->teacher_model->get_teacherrestricted_modeallsections($staff_id);
                foreach ($sections as $key => $value) {
                    $sections_id[] = $value['section_id'];
                }
                $this->db->where_in("subscriber_session.section_id", $sections_id);
            } else {
                $this->db->where_in("subscriber_session.class_id", "");
            }
        }

        $this->datatables->select('classes.id AS `class_id`,subscribers.id,subscriber_session.id as subscriber_session_id,classes.class,sections.id AS `section_id`,sections.section,subscribers.id,subscribers.admission_no , subscribers.roll_no,subscribers.admission_date,subscribers.firstname,subscribers.middlename,  subscribers.lastname,subscribers.image,    subscribers.mobileno, subscribers.email ,subscribers.state ,   subscribers.city , subscribers.pincode ,     subscribers.religion,     DATE(subscribers.dob) as dob ,subscribers.current_address,    subscribers.permanent_address,IFNULL(subscribers.category_id, 0) as `category_id`,IFNULL(categories.category, "") as `category`,      subscribers.adhar_no,subscribers.samagra_id,subscribers.bank_account_no,subscribers.bank_name, subscribers.ifsc_code ,subscribers.father_name , subscribers.guardian_name , subscribers.guardian_relation,subscribers.guardian_phone,subscribers.guardian_address,subscribers.is_active ,subscribers.created_at ,subscribers.updated_at,subscribers.gender,subscribers.rte,subscriber_session.session_id' . $field_variable);
        $this->datatables->join('subscriber_session', 'subscriber_session.subscriber_id = subscribers.id');
        $this->datatables->join('classes', 'subscriber_session.class_id = classes.id');
        $this->datatables->join('sections', 'sections.id = subscriber_session.section_id');
        $this->datatables->join('categories', 'subscribers.category_id = categories.id', 'left');
        $this->datatables->join('school_houses', 'subscribers.school_house_id = school_houses.id', 'left');
        $this->datatables->group_start();
        $this->datatables->or_like_string('subscribers.firstname,subscribers.middlename,subscribers.lastname,school_houses.house_name,subscribers.guardian_name,subscribers.adhar_no,subscribers.samagra_id,subscribers.roll_no,subscribers.admission_no,subscribers.mobileno,subscribers.email,subscribers.religion,subscribers.cast,subscribers.gender,subscribers.current_address,subscribers.permanent_address,subscribers.blood_group,subscribers.bank_name,subscribers.ifsc_code,subscribers.father_name,subscribers.father_phone,subscribers.father_occupation,subscribers.mother_name,subscribers.mother_phone,subscribers.mother_occupation,subscribers.guardian_name,subscribers.guardian_relation,subscribers.guardian_phone,subscribers.guardian_occupation,subscribers.guardian_address,subscribers.guardian_email,subscribers.previous_school,subscribers.note', $searchterm); 
        $this->datatables->group_end();
        $this->datatables->where('subscriber_session.session_id', $this->current_session);
        $this->datatables->where('subscribers.is_active', 'yes');
        $this->datatables->searchable('subscribers.admission_no,subscribers.firstname,subscribers.middlename,subscribers.lastname,classes.class,subscribers.father_name,subscribers.dob,subscribers.gender,categories.category,subscribers.mobileno'. $field_variable);
        $this->datatables->orderable('subscribers.admission_no,subscribers.firstname,classes.class,subscribers.father_name,dob,subscribers.gender,categories.category,subscribers.mobileno'.$field_name);
        $this->datatables->sort('subscribers.id');
        $this->datatables->from('subscribers');
        return $this->datatables->generate('json');
       
    }

    public function searchusersbyFullText($searchterm, $carray = null)
    {
        $userdata = $this->customlib->getUserData();
        $staff_id = $userdata['id'];

        $i             = 1;
        $custom_fields = $this->customfield_model->get_custom_fields('subscribers', 1);

        $field_var_array = array();
        if (!empty($custom_fields)) {
            foreach ($custom_fields as $custom_fields_key => $custom_fields_value) {
                $tb_counter = "table_custom_" . $i;
                array_push($field_var_array, 'table_custom_' . $i . '.field_value as ' . $custom_fields_value->name);
                $this->db->join('custom_field_values as ' . $tb_counter, 'subscribers.id = ' . $tb_counter . '.belong_table_id AND ' . $tb_counter . '.custom_field_id = ' . $custom_fields_value->id, 'left');
                $i++;
            }
        }

        $field_variable = implode(',', $field_var_array);

        if (($userdata["role_id"] == 2) && ($userdata["class_teacher"] == "yes")) {
            if (!empty($carray)) {

                $this->db->where_in("subscriber_session.class_id", $carray);
                $sections = $this->teacher_model->get_teacherrestricted_modeallsections($staff_id);
                foreach ($sections as $key => $value) {
                    $sections_id[] = $value['section_id'];
                }
                $this->db->where_in("subscriber_session.section_id", $sections_id);
            } else {
                $this->db->where_in("subscriber_session.class_id", "");
            }
        }

        $this->db->select('classes.id AS `class_id`,subscribers.id,subscriber_session.id as subscriber_session_id,classes.class,sections.id AS `section_id`,sections.section,subscribers.id,subscribers.admission_no , subscribers.roll_no,subscribers.admission_date,subscribers.firstname,subscribers.middlename,  subscribers.lastname,subscribers.image,    subscribers.mobileno, subscribers.email ,subscribers.state ,   subscribers.city , subscribers.pincode ,     subscribers.religion,     subscribers.dob ,subscribers.current_address,    subscribers.permanent_address,IFNULL(subscribers.category_id, 0) as `category_id`,IFNULL(categories.category, "") as `category`,      subscribers.adhar_no,subscribers.samagra_id,subscribers.bank_account_no,subscribers.bank_name, subscribers.ifsc_code ,subscribers.father_name , subscribers.guardian_name , subscribers.guardian_relation,subscribers.guardian_phone,subscribers.guardian_address,subscribers.is_active ,subscribers.created_at ,subscribers.updated_at,subscribers.gender,subscribers.rte,subscriber_session.session_id,' . $field_variable)->from('subscribers');
        $this->db->join('subscriber_session', 'subscriber_session.subscriber_id = subscribers.id');
        $this->db->join('classes', 'subscriber_session.class_id = classes.id');
        $this->db->join('sections', 'sections.id = subscriber_session.section_id');
        $this->db->join('categories', 'subscribers.category_id = categories.id', 'left');
        $this->db->join('school_houses', 'subscribers.school_house_id = school_houses.id', 'left');
        $this->db->where('subscriber_session.session_id', $this->current_session);
        $this->db->where('subscribers.is_active', 'yes');
        $this->db->group_start();

        $this->db->like('subscribers.firstname', $searchterm);
        $this->db->or_like('subscribers.middlename', $searchterm);
        $this->db->or_like('subscribers.lastname', $searchterm);
        $this->db->or_like('school_houses.house_name', $searchterm);
        $this->db->or_like('subscribers.guardian_name', $searchterm);
        $this->db->or_like('subscribers.adhar_no', $searchterm);
        $this->db->or_like('subscribers.samagra_id', $searchterm);
        $this->db->or_like('subscribers.roll_no', $searchterm);
        $this->db->or_like('subscribers.admission_no', $searchterm);
        $this->db->or_like('subscribers.mobileno', $searchterm);
        $this->db->or_like('subscribers.email', $searchterm);
        $this->db->or_like('subscribers.religion', $searchterm);
        $this->db->or_like('subscribers.cast', $searchterm);
        $this->db->or_like('subscribers.gender', $searchterm);
        $this->db->or_like('subscribers.current_address', $searchterm);
        $this->db->or_like('subscribers.permanent_address', $searchterm);
        $this->db->or_like('subscribers.blood_group', $searchterm);
        $this->db->or_like('subscribers.bank_name', $searchterm);
        $this->db->or_like('subscribers.ifsc_code', $searchterm);
        $this->db->or_like('subscribers.father_name', $searchterm);
        $this->db->or_like('subscribers.father_phone', $searchterm);
        $this->db->or_like('subscribers.father_occupation', $searchterm);
        $this->db->or_like('subscribers.mother_name', $searchterm);
        $this->db->or_like('subscribers.mother_phone', $searchterm);
        $this->db->or_like('subscribers.mother_occupation', $searchterm);
        $this->db->or_like('subscribers.guardian_name', $searchterm);
        $this->db->or_like('subscribers.guardian_relation', $searchterm);
        $this->db->or_like('subscribers.guardian_phone', $searchterm);
        $this->db->or_like('subscribers.guardian_occupation', $searchterm);
        $this->db->or_like('subscribers.guardian_address', $searchterm);
        $this->db->or_like('subscribers.guardian_email', $searchterm);
        $this->db->or_like('subscribers.previous_school', $searchterm);
        $this->db->or_like('subscribers.note', $searchterm);
        $this->db->group_end();
        $this->db->order_by('subscribers.id');
        $query = $this->db->get();
        return $query->result_array();
    }
    public function admission_report($searchterm, $carray = null, $condition = null)
    {
        $userdata = $this->customlib->getUserData();

        $i               = 1;
        $custom_fields   = $this->customfield_model->get_custom_fields('subscribers', 1);
        $field_var_array = array();
        if (!empty($custom_fields)) {
            foreach ($custom_fields as $custom_fields_key => $custom_fields_value) {
                $tb_counter = "table_custom_" . $i;
                array_push($field_var_array, 'table_custom_' . $i . '.field_value as ' . $custom_fields_value->name);
                $this->db->join('custom_field_values as ' . $tb_counter, 'subscribers.id = ' . $tb_counter . '.belong_table_id AND ' . $tb_counter . '.custom_field_id = ' . $custom_fields_value->id, 'left');
                $i++;
            }
        }

        $field_variable = implode(',', $field_var_array);
        if (($userdata["role_id"] == 2) && ($userdata["class_teacher"] == "yes")) {
            if (!empty($carray)) {

                $this->db->where_in("subscriber_session.class_id", $carray);
            } else {

            }
        }

        if ($condition != null) {

            $this->datatables->where($condition);
        }

      
        /*----------------------------------------*/
        $this->datatables->select('classes.id AS `class_id`,subscribers.id,classes.class,sections.id AS `section_id`,sections.section,subscribers.id,subscribers.admission_no , subscribers.roll_no,subscribers.admission_date,subscribers.firstname,subscribers.middlename,  subscribers.lastname,subscribers.image,    subscribers.mobileno, subscribers.email ,subscribers.state ,   subscribers.city , subscribers.pincode ,     subscribers.religion,     subscribers.dob ,subscribers.current_address,    subscribers.permanent_address,IFNULL(subscribers.category_id, 0) as `category_id`,IFNULL(categories.category, "") as `category`,      subscribers.adhar_no,subscribers.samagra_id,subscribers.bank_account_no,subscribers.bank_name, subscribers.ifsc_code ,subscribers.father_name , subscribers.guardian_name , subscribers.guardian_relation,subscribers.guardian_phone,subscribers.guardian_address,subscribers.is_active ,subscribers.created_at ,subscribers.updated_at,subscribers.gender,subscribers.rte,subscriber_session.session_id,' . $field_variable);
         $this->datatables->searchable('admission_no,subscribers.firstname,classes.class,subscribers.father_name,subscribers.dob,subscribers.admission_date,subscribers.gender,categories.category');
         $this->datatables->orderable('admission_no,subscribers.firstname,classes.class,subscribers.father_name,subscribers.dob,subscribers.admission_date,subscribers.gender,categories.category');
       $this->datatables->join('subscriber_session', 'subscriber_session.subscriber_id = subscribers.id');
        $this->datatables->join('classes', 'subscriber_session.class_id = classes.id');
        $this->datatables->join('sections', 'sections.id = subscriber_session.section_id');
        $this->datatables->join('categories', 'subscribers.category_id = categories.id', 'left');
        $this->datatables->where('subscriber_session.session_id', $this->current_session);
        $this->datatables->where('subscribers.is_active', 'yes');

        $this->datatables->group_start();
        $this->datatables->or_like_string('subscribers.firstname,subscribers.lastname,subscribers.guardian_name,subscribers.adhar_no,subscribers.samagra_id,subscribers.roll_no,subscribers.admission_no', $searchterm); 
        $this->datatables->group_end();
        
        $this->datatables->sort('subscribers.id');
        $this->datatables->from('subscribers');
        return $this->datatables->generate('json');
      
    }

    public function subscriber_ratio()
    {

        $i               = 1;
        $custom_fields   = $this->customfield_model->get_custom_fields('subscribers', 1);
        $field_var_array = array();
        if (!empty($custom_fields)) {
            foreach ($custom_fields as $custom_fields_key => $custom_fields_value) {
                $tb_counter = "table_custom_" . $i;
                array_push($field_var_array, 'table_custom_' . $i . '.field_value as ' . $custom_fields_value->name);
                $this->db->join('custom_field_values as ' . $tb_counter, 'subscribers.id = ' . $tb_counter . '.belong_table_id AND ' . $tb_counter . '.custom_field_id = ' . $custom_fields_value->id, 'left');
                $i++;
            }
        }

        $field_variable = implode(',', $field_var_array);

        $this->db->select(' count(*) as total_subscriber, SUM(CASE WHEN `gender` = "Male" THEN 1 ELSE 0 END) AS "male",SUM(CASE WHEN `gender` = "Female" THEN 1 ELSE 0 END) AS "female", classes.class,sections.section, classes.id as class_id, sections.id as section_id')->from('subscribers');
        $this->db->join('subscriber_session', 'subscriber_session.subscriber_id = subscribers.id');
        $this->db->join('classes', 'subscriber_session.class_id = classes.id');
        $this->db->join('sections', 'sections.id = subscriber_session.section_id');
        $this->db->join('categories', 'subscribers.category_id = categories.id', 'left');
        $this->db->join('class_sections', 'class_sections.class_id = classes.id and class_sections.section_id=sections.id', 'inner');
        $this->db->where('subscriber_session.session_id', $this->current_session);
        $this->db->where('subscribers.is_active', 'yes');
        $this->db->group_by('class_sections.id');
        $this->db->order_by('subscribers.id');
        $query = $this->db->get();
        return $query->result_array();
    }

 
 
     
    public function getsubscriberListBYsubscribersessionID($array)
    {
        $array = implode(',', $array);
        $sql   = ' SELECT subscribers.* FROM subscribers INNER join (SELECT * FROM `subscriber_session` WHERE `subscriber_session`.`id` IN (' . $array . ')) as subscriber_session on subscribers.id=subscriber_session.subscriber_id';
        $query = $this->db->query($sql);
        return $query->result();
    }

    public function remove($id)
    {
        $this->db->trans_start();

        $sql   = "SELECT * FROM `users` WHERE childs LIKE '%," . $id . ",%' OR childs LIKE '" . $id . ",%' OR childs LIKE '%," . $id . "' OR childs = " . $id;
        $query = $this->db->query($sql);

        if ($query->num_rows() > 0) {
            $result      = $query->row();
            $array_slice = explode(',', $result->childs);
            if (count($array_slice) > 1) {
                $arr    = array_diff($array_slice, array($id));
                $update = implode(",", $arr);
                $data   = array('childs' => $update);

                $this->db->where('id', $result->id);
                $this->db->update('users', $data);
            } else {
                $this->db->where('id', $result->id);
                $this->db->delete('users');
            }
        }

        $this->db->where('id', $id);
        $this->db->delete('subscribers');

        $this->db->where('subscriber_id', $id);
        $this->db->delete('subscriber_session');

        $this->db->where('user_id', $id);
        $this->db->where('role', 'subscriber');
        $this->db->delete('users');
        $this->db->trans_complete();

        if ($this->db->trans_status() === false) {
            return false;
        } else {
            return true;
        }
    }

    public function doc_delete($id)
    {
        $this->db->where('id', $id);
        $this->db->delete('subscriber_doc');
    }

    public function add($data, $data_setting = array())
    {

        if (isset($data['id'])) {
            $this->db->where('id', $data['id']);
            $this->db->update('subscribers', $data);
            $message   = UPDATE_RECORD_CONSTANT . " On subscribers id " . $data['id'];
            $action    = "Update";
            $record_id = $insert_id = $data['id'];
            $this->log($message, $record_id, $action);
        } else {
            if (!empty($data_setting)) {

                if ($data_setting['adm_auto_insert']) {
                    if ($data_setting['adm_update_status'] == 0) {
                        $data_setting['adm_update_status'] = 1;
                        $this->setting_model->add($data_setting);
                    }
                }
                $this->db->insert('subscribers', $data);
                $insert_id = $this->db->insert_id();
                $message   = INSERT_RECORD_CONSTANT . " On subscribers id " . $insert_id;
                $action    = "Insert";
                $record_id = $insert_id;
                $this->log($message, $record_id, $action);

                return $insert_id;
            }
        }
    }


    public function add_subscriber_session($data)
    {
        $this->db->trans_start(); # Starting Transaction
        $this->db->trans_strict(false); # See Note 01. If you wish can remove as well
        //=======================Code Start===========================
        $this->db->where('session_id', $data['session_id']);
        $this->db->where('subscriber_id', $data['subscriber_id']);
        $q = $this->db->get('subscriber_session');
        if ($q->num_rows() > 0) {
            $rec = $q->row_array();
            $this->db->where('id', $rec['id']);
            $this->db->update('subscriber_session', $data);
            $message   = UPDATE_RECORD_CONSTANT . " On  subscriber session id " . $rec['id'];
            $action    = "Update";
            $record_id = $rec['id'];
            $this->log($message, $record_id, $action);
        } else {
            $this->db->insert('subscriber_session', $data);
            $id        = $this->db->insert_id();
            $message   = INSERT_RECORD_CONSTANT . " On  subscriber session id " . $id;
            $action    = "Insert";
            $record_id = $id;
            $this->log($message, $record_id, $action);
        }
        //======================Code End==============================

        $this->db->trans_complete(); # Completing transaction
        /* Optional */

        if ($this->db->trans_status() === false) {
            # Something went wrong.
            $this->db->trans_rollback();
            return false;
        } else {
            return true;
        }
    }


    public function adddoc($data)
    {
        $this->db->insert('subscriber_doc', $data);
        return $this->db->insert_id();
    }


    public function searchCurrentSessionsubscribers()
    {
        $this->db->select('classes.id AS `class_id`,subscriber_session.id as subscriber_session_id,subscribers.id,classes.class,sections.id AS `section_id`,sections.section,subscribers.id,subscribers.admission_no , subscribers.roll_no,subscribers.admission_date,subscribers.firstname,subscribers.middlename,  subscribers.lastname,subscribers.image,    subscribers.mobileno, subscribers.email ,subscribers.state ,   subscribers.city , subscribers.pincode ,     subscribers.religion,     subscribers.dob ,subscribers.current_address,    subscribers.permanent_address,IFNULL(subscribers.category_id, 0) as `category_id`,IFNULL(categories.category, "") as `category`,subscribers.adhar_no,subscribers.samagra_id,subscribers.bank_account_no,subscribers.bank_name, subscribers.ifsc_code , subscribers.guardian_name , subscribers.guardian_relation,subscribers.guardian_phone,subscribers.guardian_address,subscribers.is_active ,subscribers.created_at ,subscribers.updated_at,subscribers.father_name,subscribers.rte,subscribers.gender')->from('subscribers');
        $this->db->join('subscriber_session', 'subscriber_session.subscriber_id = subscribers.id');
        $this->db->join('classes', 'subscriber_session.class_id = classes.id');
        $this->db->join('sections', 'sections.id = subscriber_session.section_id');
        $this->db->join('categories', 'subscribers.category_id = categories.id', 'left');
        $this->db->where('subscriber_session.session_id', $this->current_session);

        $this->db->order_by('subscribers.firstname', 'asc');

        $query = $this->db->get();
        return $query->result_array();
    }

    public function searchLibrarysubscriber($class_id = null, $section_id = null)
    {
        $this->db->select('classes.id AS `class_id`,subscriber_session.id as subscriber_session_id,subscribers.id,classes.class,sections.id AS `section_id`,
           IFNULL(libarary_members.id,0) as `libarary_member_id`,
           IFNULL(libarary_members.library_card_no,0) as `library_card_no`,sections.section,subscribers.id,subscribers.admission_no , subscribers.roll_no,subscribers.admission_date,subscribers.firstname, subscribers.middlename, subscribers.lastname,subscribers.image,    subscribers.mobileno, subscribers.email ,subscribers.state ,   subscribers.city , subscribers.pincode ,     subscribers.religion,     subscribers.dob ,subscribers.current_address,    subscribers.permanent_address,IFNULL(subscribers.category_id, 0) as `category_id`,IFNULL(categories.category, "") as `category`,subscribers.adhar_no,subscribers.samagra_id,subscribers.bank_account_no,subscribers.bank_name, subscribers.ifsc_code , subscribers.guardian_name , subscribers.guardian_relation,subscribers.guardian_phone,subscribers.guardian_address,subscribers.is_active ,subscribers.created_at ,subscribers.updated_at,subscribers.father_name,subscribers.rte,subscribers.gender')->from('subscribers');
        $this->db->join('subscriber_session', 'subscriber_session.subscriber_id = subscribers.id');
        $this->db->join('classes', 'subscriber_session.class_id = classes.id');
        $this->db->join('sections', 'sections.id = subscriber_session.section_id');
        $this->db->join('categories', 'subscribers.category_id = categories.id', 'left');
        $this->db->join('libarary_members', 'libarary_members.member_id = subscribers.id and libarary_members.member_type = "subscriber"', 'left');

        $this->db->where('subscriber_session.session_id', $this->current_session);
        $this->db->where('subscribers.is_active', 'yes');
        if ($class_id != null) {
            $this->db->where('subscriber_session.class_id', $class_id);
        }
        if ($section_id != null) {
            $this->db->where('subscriber_session.section_id', $section_id);
        }
        $this->db->order_by('subscribers.id');

        $query = $this->db->get();
        return $query->result_array();
    }

    public function searchNameLike($searchterm)
    {
        $this->db->select('classes.id AS `class_id`,subscribers.id,classes.class,sections.id AS `section_id`,sections.section,subscribers.id,subscribers.admission_no , subscribers.roll_no,subscribers.admission_date,subscribers.firstname,subscribers.middlename,  subscribers.lastname,subscribers.image,    subscribers.mobileno, subscribers.email ,subscribers.state ,   subscribers.city , subscribers.pincode ,subscribers.religion,     subscribers.dob ,subscribers.current_address,    subscribers.permanent_address,IFNULL(subscribers.category_id, 0) as `category_id`,IFNULL(categories.category, "") as `category`,      subscribers.adhar_no,subscribers.samagra_id,subscribers.bank_account_no,subscribers.bank_name, subscribers.ifsc_code ,subscribers.father_name , subscribers.guardian_name , subscribers.guardian_relation,subscribers.guardian_email,subscribers.guardian_phone,subscribers.guardian_address,subscribers.is_active ,subscribers.created_at ,subscribers.updated_at,subscribers.gender,subscribers.rte,subscribers.app_key,subscribers.parent_app_key,subscriber_session.session_id')->from('subscribers');
        $this->db->join('subscriber_session', 'subscriber_session.subscriber_id = subscribers.id');
        $this->db->join('classes', 'subscriber_session.class_id = classes.id');
        $this->db->join('sections', 'sections.id = subscriber_session.section_id');
        $this->db->join('categories', 'subscribers.category_id = categories.id', 'left');
        $this->db->where('subscriber_session.session_id', $this->current_session);
        $this->db->where('subscribers.is_active', 'yes');
        $this->db->group_start();
        $this->db->like('subscribers.firstname', $searchterm);
        $this->db->or_like('subscribers.lastname', $searchterm);
        $this->db->group_end();
        $this->db->order_by('subscribers.id');

        $query = $this->db->get();
        return $query->result_array();
    }

    public function searchGuardianNameLike($searchterm)
    {
        $this->db->select('classes.id AS `class_id`,subscribers.id,classes.class,sections.id AS `section_id`,sections.section,subscribers.id,subscribers.admission_no , subscribers.roll_no,subscribers.admission_date,subscribers.firstname,subscribers.middlename,  subscribers.lastname,subscribers.image,    subscribers.mobileno, subscribers.email ,subscribers.state ,   subscribers.city , subscribers.pincode ,     subscribers.religion,     subscribers.dob ,subscribers.current_address,    subscribers.permanent_address,IFNULL(subscribers.category_id, 0) as `category_id`,IFNULL(categories.category, "") as `category`,subscribers.adhar_no,subscribers.samagra_id,subscribers.bank_account_no,subscribers.bank_name, subscribers.ifsc_code ,subscribers.father_name , subscribers.guardian_name , subscribers.guardian_relation,subscribers.guardian_phone,subscribers.guardian_address,subscribers.is_active ,subscribers.created_at ,subscribers.updated_at,subscribers.gender,subscribers.guardian_email,subscribers.rte,subscriber_session.session_id,subscribers.app_key,subscribers.parent_app_key')->from('subscribers');
        $this->db->join('subscriber_session', 'subscriber_session.subscriber_id = subscribers.id');
        $this->db->join('classes', 'subscriber_session.class_id = classes.id');
        $this->db->join('sections', 'sections.id = subscriber_session.section_id');
        $this->db->join('categories', 'subscribers.category_id = categories.id', 'left');
        $this->db->where('subscriber_session.session_id', $this->current_session);
        $this->db->where('subscribers.is_active', 'yes');
        $this->db->group_start();
        $this->db->like('subscribers.guardian_name', $searchterm);

        $this->db->group_end();
        $this->db->order_by('subscribers.id');

        $query = $this->db->get();
        return $query->result_array();
    }

    public function searchByClassSectionWithSession($class_id = null, $section_id = null, $session_id = null)
    {
        $this->db->select('classes.id AS `class_id`,subscriber_session.id as subscriber_session_id,subscribers.id,classes.class,sections.id AS `section_id`,sections.section,subscribers.id,subscribers.admission_no , subscribers.roll_no,subscribers.admission_date,subscribers.firstname,subscribers.middlename,  subscribers.lastname,subscribers.image,    subscribers.mobileno, subscribers.email ,subscribers.state ,   subscribers.city , subscribers.pincode ,     subscribers.religion,     subscribers.dob ,subscribers.current_address,    subscribers.permanent_address,IFNULL(subscribers.category_id, 0) as `category_id`,IFNULL(categories.category, "") as `category`,subscribers.adhar_no,subscribers.samagra_id,subscribers.bank_account_no,subscribers.bank_name, subscribers.ifsc_code , subscribers.guardian_name , subscribers.guardian_relation,subscribers.guardian_phone,subscribers.guardian_address,subscribers.is_active ,subscribers.created_at ,subscribers.updated_at,subscribers.father_name,subscribers.rte,subscribers.gender')->from('subscribers');
        $this->db->join('subscriber_session', 'subscriber_session.subscriber_id = subscribers.id');
        $this->db->join('classes', 'subscriber_session.class_id = classes.id');
        $this->db->join('sections', 'sections.id = subscriber_session.section_id');
        $this->db->join('categories', 'subscribers.category_id = categories.id', 'left');
        $this->db->where('subscriber_session.session_id', $this->current_session);
        $this->db->where('subscribers.is_active', 'yes');
        if ($class_id != null) {
            $this->db->where('subscriber_session.class_id', $class_id);
        }
        if ($section_id != null) {
            $this->db->where('subscriber_session.section_id', $section_id);
        }
        $this->db->order_by('subscribers.id');

        $query = $this->db->get();
        return $query->result_array();
    }

       public function searchNonPromotedsubscribers($class_id = null, $section_id = null, $promoted_session_id = null,$promoted_class_id = null, $promoted_section_id = null)
    {
        $sql="SELECT promoted_subscribers.id as `promoted_subscriber_id`,`classes`.`id` AS `class_id`, `subscriber_session`.`id` as `subscriber_session_id`, `subscribers`.`id`, `classes`.`class`, `sections`.`id` AS `section_id`, `sections`.`section`, `subscribers`.`id`, `subscribers`.`admission_no`, `subscribers`.`roll_no`, `subscribers`.`admission_date`, `subscribers`.`firstname`, `subscribers`.`middlename`, `subscribers`.`lastname`, `subscribers`.`image`, `subscribers`.`mobileno`, `subscribers`.`email`, `subscribers`.`state`, `subscribers`.`city`, `subscribers`.`pincode`, `subscribers`.`religion`, `subscribers`.`dob`, `subscribers`.`current_address`, `subscribers`.`permanent_address`, IFNULL(subscribers.category_id, 0) as `category_id`, IFNULL(categories.category, '') as `category`, `subscribers`.`adhar_no`, `subscribers`.`samagra_id`, `subscribers`.`bank_account_no`, `subscribers`.`bank_name`, `subscribers`.`ifsc_code`, `subscribers`.`guardian_name`, `subscribers`.`guardian_relation`, `subscribers`.`guardian_phone`, `subscribers`.`guardian_address`, `subscribers`.`is_active`, `subscribers`.`created_at`, `subscribers`.`updated_at`, `subscribers`.`father_name`, `subscribers`.`rte`, `subscribers`.`gender` FROM `subscribers` JOIN `subscriber_session` ON `subscriber_session`.`subscriber_id` = `subscribers`.`id` JOIN `classes` ON `subscriber_session`.`class_id` = `classes`.`id` JOIN `sections` ON `sections`.`id` = `subscriber_session`.`section_id` LEFT JOIN `categories` ON `subscribers`.`category_id` = `categories`.`id` LEFT join (select * from subscriber_session WHERE session_id=".$promoted_session_id." and class_id=".$promoted_class_id." and section_id=".$promoted_section_id.") as promoted_subscribers on promoted_subscribers.subscriber_id=subscribers.id WHERE `subscriber_session`.`session_id` = ".$this->current_session." AND `subscribers`.`is_active` = 'yes' AND `subscriber_session`.`class_id` = ".$class_id." AND `subscriber_session`.`section_id` = ".$section_id." and promoted_subscribers.id IS NULL ORDER BY `subscribers`.`id`";
               $query = $this->db->query($sql);
              return $query->result_array();
    }

    public function getPreviousSessionsubscriber($previous_session_id, $class_id, $section_id)
    {
        $sql = "SELECT subscriber_session.subscriber_id as subscriber_id, subscriber_session.id as current_subscriber_session_id, subscriber_session.class_id as current_session_class_id ,previous_session.id as previous_subscriber_session_id,subscribers.firstname,subscribers.middlename,subscribers.lastname,subscribers.admission_no,subscribers.roll_no,subscribers.father_name,subscribers.admission_date FROM `subscriber_session` left JOIN (SELECT * FROM `subscriber_session` where session_id=$previous_session_id) as previous_session on subscriber_session.subscriber_id=previous_session.subscriber_id INNER join subscribers on subscribers.id =subscriber_session.subscriber_id where subscriber_session.session_id=$this->current_session and subscriber_session.class_id=$class_id and subscriber_session.section_id=$section_id and subscribers.is_active='yes' ORDER BY subscribers.firstname ASC";

        $query = $this->db->query($sql);
        return $query->result();
    }

    public function subscriberGuardianDetails($carray)
    {
        $userdata = $this->customlib->getUserData();

        $this->db->SELECT("subscribers.admission_no,subscribers.firstname,subscribers.middlename,subscribers.mobileno,subscribers.father_phone,subscribers.mother_phone,subscribers.lastname,subscribers.father_name,subscribers.mother_name,subscribers.guardian_name,subscribers.guardian_relation,subscribers.guardian_phone,subscribers.id,classes.class,sections.section");
        $this->db->join("subscriber_session", "subscriber_session.subscriber_id = subscribers.id");
        $this->db->join("classes", "subscriber_session.class_id = classes.id");
        $this->db->join("sections", "subscriber_session.section_id = sections.id");
        $this->db->where("subscribers.is_active", "yes");
        $this->db->where('subscriber_session.session_id', $this->current_session);
        if (($userdata["role_id"] == 2) && ($userdata["class_teacher"] == "yes")) {

            if (!empty($carray)) {

                $this->db->where_in("subscriber_session.class_id", $carray);
            } else {
                $this->db->where_in("subscriber_session.class_id", "");
            }
        }
        $query = $this->db->get("subscribers");

        return $query->result_array();
    }

    public function searchGuardianDetails($class_id, $section_id)
    {

        $this->db->SELECT("subscribers.admission_no,subscribers.firstname,subscribers.middlename,subscribers.lastname,subscribers.mobileno,subscribers.father_phone,subscribers.mother_phone,subscribers.father_name,subscribers.mother_name,subscribers.guardian_name,subscribers.guardian_relation,subscribers.guardian_phone,subscribers.id,classes.class,sections.section");
        $this->db->join("subscriber_session", "subscriber_session.subscriber_id = subscribers.id");
        $this->db->join("classes", "subscriber_session.class_id = classes.id");
        $this->db->join("sections", "subscriber_session.section_id = sections.id");
        $this->db->where("subscribers.is_active", "yes");
        $this->db->where('subscriber_session.session_id', $this->current_session);
        $this->db->where(array('subscriber_session.class_id' => $class_id, 'subscriber_session.section_id' => $section_id));
        $query = $this->db->get("subscribers");

        return $query->result_array();
    }

    public function subscriberAdmissionDetails($carray = null)
    {

        $userdata = $this->customlib->getUserData();
        if (($userdata["role_id"] == 2) && ($userdata["class_teacher"] == "yes")) {

            if (!empty($carray)) {

                $this->db->where_in("subscriber_session.class_id", $carray);
            } else {
                $this->db->where_in("subscriber_session.class_id", "");
            }
        }
        $query = $this->db->SELECT("subscribers.firstname,subscribers.middlename,subscribers.lastname,subscribers.is_active, subscribers.mobileno, subscribers.id as sid ,subscribers.admission_no, subscribers.admission_date, subscribers.guardian_name, subscribers.guardian_relation, subscribers.guardian_phone, classes.class, sessions.id, sections.section")->join("subscriber_session", "subscribers.id = subscriber_session.subscriber_id")->join("classes", "subscriber_session.class_id = classes.id")->join("sections", "subscriber_session.section_id = sections.id")->join("sessions", "subscriber_session.session_id = sessions.id")->group_by("subscribers.id")->get("subscribers");

        return $query->result_array();
    }

    public function subscriberSessionDetails($id)
    {

        $query = $this->db->query("SELECT min(sessions.session) as start , max(sessions.session) as end, min(classes.class) as startclass, max(classes.class) as endclass from sessions join subscriber_session on (sessions.id = subscriber_session.session_id) join classes on (classes.id = subscriber_session.class_id) where subscriber_session.subscriber_id = " . $id);

        return $query->row_array();
    }

    

    public function searchdatatablebyAdmissionDetails($class_id, $year)
    {

        if (!empty($year)) {

            $data = array('year(admission_date)' => $year, 'subscriber_session.class_id' => $class_id);
        } else {
            $data = array('subscriber_session.class_id' => $class_id);
        }

       $this->datatables->select('subscribers.firstname,subscribers.middlename,subscribers.lastname,subscribers.is_active, subscribers.mobileno, subscribers.id as sid ,subscribers.admission_no, subscribers.admission_date, subscribers.guardian_name, subscribers.guardian_relation, subscribers.guardian_phone, classes.class, sessions.id, sections.section')
        ->searchable('subscribers.admission_no,subscribers.firstname,subscribers.admission_date,subscribers.mobileno,subscribers.guardian_name,subscribers.guardian_phone')
        ->join('subscriber_session', 'subscribers.id = subscriber_session.subscriber_id')
        ->join('classes', 'subscriber_session.class_id = classes.id')
        ->join('sections', 'subscriber_session.section_id = sections.id')
        ->join('sessions', 'subscriber_session.session_id = sessions.id')
        ->where($data)
        ->group_by('subscribers.id')
        ->orderable('subscribers.admission_no,subscribers.firstname,subscribers.admission_date," "," "," ",subscribers.mobileno,subscribers.guardian_name,subscribers.guardian_phone')           
        ->sort('subscribers.id')
        ->from('subscribers');
        return $this->datatables->generate('json');
    }

    public function admissionYear()
    {

        $query = $this->db->SELECT("distinct(year(admission_date)) as year")->where_not_in('admission_date', array('0000-00-00', '1970-01-01'))->get("subscribers");

        return $query->result_array();
    }

    public function getsubscriberSession($id)
    {

        $query = $this->db->query("SELECT  max(sessions.id) as subscriber_session_id, max(sessions.session) as session from sessions join subscriber_session on (sessions.id = subscriber_session.session_id)  where subscriber_session.subscriber_id = " . $id);

        return $query->row_array();
    }

    public function valid_subscriber_roll()
    {
        $roll_no    = $this->input->post('roll_no');
        $subscriber_id = $this->input->post('subscriberid');
        $class      = $this->input->post('class_id');

        if ($roll_no != "") {

            if (!isset($subscriber_id)) {
                $subscriber_id = 0;
            }

            if ($this->check_rollno_exists($roll_no, $subscriber_id, $class)) {
                $this->form_validation->set_message('check_exists', 'Roll Number should be unique at Class level');
                return false;
            } else {
                return true;
            }
        }
        return true;
    }

    public function check_rollno_exists($roll_no, $subscriber_id, $class)
    {

        if ($subscriber_id != 0) {
            $data  = array('subscribers.id != ' => $subscriber_id, 'subscriber_session.class_id' => $class, 'subscribers.roll_no' => $roll_no);
            $query = $this->db->where($data)->join("subscriber_session", "subscribers.id = subscriber_session.subscriber_id")->get('subscribers');
            if ($query->num_rows() > 0) {
                return true;
            } else {
                return false;
            }
        } else {

            $this->db->where(array('class_id' => $class, 'roll_no' => $roll_no));
            $query = $this->db->join("subscriber_session", "subscribers.id = subscriber_session.subscriber_id")->get('subscribers');
            // echo $this->db->last_query();die;
            if ($query->num_rows() > 0) {
                return true;
            } else {
                return false;
            }
        }
    }

    public function gethouselist()
    {

        $query = $this->db->where("is_active", "yes")->get("school_houses");

        return $query->result_array();
    }

    public function disablesubscriber($id, $data)
    {

        $this->db->where("id", $id)->update("subscribers", $data);
    }

    public function getdisablesubscriber()
    {

        $this->db->select('classes.id AS `class_id`,subscribers.id,classes.class,sections.id AS `section_id`,sections.section,subscribers.id,subscribers.admission_no , subscribers.roll_no,subscribers.admission_date,subscribers.firstname,subscribers.middlename, subscribers.lastname,subscribers.image,    subscribers.mobileno, subscribers.email ,subscribers.state ,   subscribers.city , subscribers.pincode ,     subscribers.religion,     subscribers.dob ,subscribers.current_address,    subscribers.permanent_address,IFNULL(subscribers.category_id, 0) as `category_id`,IFNULL(categories.category, "") as `category`,      subscribers.adhar_no,subscribers.samagra_id,subscribers.bank_account_no,subscribers.bank_name, subscribers.ifsc_code ,subscribers.father_name , subscribers.guardian_name , subscribers.guardian_relation,subscribers.guardian_phone,subscribers.guardian_address,subscribers.is_active ,subscribers.created_at ,subscribers.updated_at,subscribers.gender,subscribers.rte,subscriber_session.session_id,dis_reason,dis_note')->from('subscribers');
        $this->db->join('subscriber_session', 'subscriber_session.subscriber_id = subscribers.id');
        $this->db->join('classes', 'subscriber_session.class_id = classes.id');
        $this->db->join('sections', 'sections.id = subscriber_session.section_id');
        $this->db->join('categories', 'subscribers.category_id = categories.id', 'left');
        $this->db->where('subscriber_session.session_id', $this->current_session);
        $this->db->where('subscribers.is_active', 'no');
        $this->db->order_by('subscribers.id');
        $query = $this->db->get();
        return $query->result_array();
    }

    public function disablesubscriberByClassSection($class, $section)
    {

        $this->db->select('classes.id AS `class_id`,subscriber_session.id as subscriber_session_id,subscribers.id,classes.class,sections.id AS `section_id`,sections.section,subscribers.id,subscribers.admission_no , subscribers.roll_no,subscribers.admission_date,subscribers.firstname,subscribers.middlename,  subscribers.lastname,subscribers.image,    subscribers.mobileno, subscribers.email ,subscribers.state ,   subscribers.city , subscribers.pincode ,     subscribers.religion,     subscribers.dob ,subscribers.current_address,    subscribers.permanent_address,IFNULL(subscribers.category_id, 0) as `category_id`,IFNULL(categories.category, "") as `category`,subscribers.adhar_no,subscribers.samagra_id,subscribers.bank_account_no,subscribers.bank_name, subscribers.ifsc_code , subscribers.guardian_name , subscribers.guardian_relation,subscribers.guardian_phone,subscribers.guardian_address,subscribers.is_active ,subscribers.created_at ,subscribers.updated_at,subscribers.father_name,subscribers.rte,subscribers.gender,dis_reason,dis_note')->from('subscribers');
        $this->db->join('subscriber_session', 'subscriber_session.subscriber_id = subscribers.id');
        $this->db->join('classes', 'subscriber_session.class_id = classes.id');
        $this->db->join('sections', 'sections.id = subscriber_session.section_id');
        $this->db->join('categories', 'subscribers.category_id = categories.id', 'left');
        $this->db->where('subscriber_session.session_id', $this->current_session);
        $this->db->where('subscribers.is_active', "no");
        if ($class != null) {
            $this->db->where('subscriber_session.class_id', $class);
        }
        if ($section != null) {
            $this->db->where('subscriber_session.section_id', $section);
        }
        $this->db->order_by('subscribers.id');

        $query = $this->db->get();
        return $query->result_array();
    }





    public function check_adm_exists($admission_no)
    {

        $this->db->where(array('admission_no' => $admission_no));
        $query = $this->db->get('subscribers');
        if ($query->num_rows() > 0) {
            return true;
        } else {
            return false;
        }
    }

    public function lastRecord()
    {
        $last_row = $this->db->select('*')->order_by('id', "desc")->limit(1)->get('subscribers')->row();
        return $last_row;
    }





    public function subscriber_profile($condition)
    {

        $this->db->select('subscriber_session.transport_fees,subscribers.vehroute_id,vehicle_routes.route_id,vehicle_routes.vehicle_id,transport_route.route_title,vehicles.vehicle_no,hostel_rooms.room_no,vehicles.driver_name,vehicles.driver_contact,hostel.id as `hostel_id`,hostel.hostel_name,room_types.id as `room_type_id`,room_types.room_type ,subscribers.hostel_room_id,subscriber_session.id as `subscriber_session_id`,subscriber_session.fees_discount,classes.id AS `class_id`,classes.class,sections.id AS `section_id`,sections.section,subscribers.id,subscribers.admission_no , subscribers.roll_no,subscribers.admission_date,subscribers.firstname,subscribers.middlename,  subscribers.lastname,subscribers.image,    subscribers.mobileno, subscribers.email ,subscribers.state ,   subscribers.city , subscribers.pincode , subscribers.note, subscribers.religion, subscribers.cast, school_houses.house_name,   subscribers.dob ,subscribers.current_address, subscribers.previous_school,
            subscribers.guardian_is,subscribers.parent_id,
            subscribers.permanent_address,subscribers.category_id,subscribers.adhar_no,subscribers.samagra_id,subscribers.bank_account_no,subscribers.bank_name, subscribers.ifsc_code , subscribers.guardian_name , subscribers.father_pic ,subscribers.height ,subscribers.weight,subscribers.measurement_date, subscribers.mother_pic , subscribers.guardian_pic , subscribers.guardian_relation,subscribers.guardian_phone,subscribers.guardian_address,subscribers.is_active ,subscribers.created_at ,subscribers.updated_at,subscribers.father_name,subscribers.father_phone,subscribers.blood_group,subscribers.school_house_id,subscribers.father_occupation,subscribers.mother_name,subscribers.mother_phone,subscribers.mother_occupation,subscribers.guardian_occupation,subscribers.gender,subscribers.guardian_is,subscribers.rte,subscribers.guardian_email, users.username,users.password,subscribers.dis_reason,subscribers.dis_note,category')->from('subscribers');
        $this->db->join('subscriber_session', 'subscriber_session.subscriber_id = subscribers.id');
        $this->db->join('classes', 'subscriber_session.class_id = classes.id');
        $this->db->join('sections', 'sections.id = subscriber_session.section_id');
        $this->db->join('hostel_rooms', 'hostel_rooms.id = subscribers.hostel_room_id', 'left');
        $this->db->join('hostel', 'hostel.id = hostel_rooms.hostel_id', 'left');
        $this->db->join('room_types', 'room_types.id = hostel_rooms.room_type_id', 'left');
        $this->db->join('vehicle_routes', 'vehicle_routes.id = subscribers.vehroute_id', 'left');
        $this->db->join('transport_route', 'vehicle_routes.route_id = transport_route.id', 'left');
        $this->db->join('vehicles', 'vehicles.id = vehicle_routes.vehicle_id', 'left');
        $this->db->join('school_houses', 'school_houses.id = subscribers.school_house_id', 'left');
        $this->db->join('users', 'users.user_id = subscribers.id', 'left');
        $this->db->join('categories', 'categories.id = subscribers.category_id', 'left');
        $this->db->where('subscriber_session.session_id', $this->current_session);
        $this->db->where('users.role', 'subscriber');
        $this->db->where('subscribers.is_active', 'yes');
        if ($condition != '') {
            $this->db->where($condition);
        }

        $this->db->order_by('subscribers.id', 'desc');
        $query = $this->db->get();
        return $query->result_array();
    }




    //===========
    public function check_subscriber_email_exists($str)
    {
        $email = $this->security->xss_clean($str);
        if ($email != "") {
            $id = $this->input->post('subscriber_id');
            if (!isset($id)) {
                $id = 0;
            }

            if ($this->check_data_exists($email, $id)) {
                $this->form_validation->set_message('check_subscriber_email_exists', $this->lang->line('record_already_exists'));
                return false;
            } else {
                return true;
            }
        }
        return true;
    }

    public function check_data_exists($email, $id)
    {
        $this->db->where('email', $email);
        $this->db->where('id !=', $id);

        $query = $this->db->get('subscribers');
        if ($query->num_rows() > 0) {
            return true;
        } else {
            return false;
        }
    }


    //===========

}

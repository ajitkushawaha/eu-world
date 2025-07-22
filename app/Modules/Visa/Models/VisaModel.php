<?php

namespace App\Modules\Visa\Models;

use CodeIgniter\Model;

class VisaModel extends Model
{
    protected $table = 'visa_booking_list';
    protected $primarykey = 'id';
    protected $protectFields = false;
    
    
    
    public function visa_booking_list($web_partner_id, $userId, $userType, $bookingType = "all", $source = null)
    {
        $tomorrow_timestamp = strtotime(date('Y-m-d'));
        $tomorrow_timestamp = date("Y-m-d", $tomorrow_timestamp);
        $from_date = strtotime(date('Y-m-d', strtotime($tomorrow_timestamp)) . '00:00'); 
        $to_date = strtotime(date('Y-m-d', strtotime(date('Y-m-d'))) . '23:59'); 
        $array = ['visa_booking_list.created >=' => $from_date, 'visa_booking_list.created <=' => $to_date]; 
        $builder =  $this->select('visa_booking_list.id,visa_booking_list.web_partner_id,visa_booking_list.date_of_journey,visa_booking_list.payment_mode,visa_booking_list.tts_search_token,visa_booking_list.booking_source,visa_booking_list.booking_ref_number,visa_booking_list.visa_country,visa_booking_list.assign_user,visa_booking_list.webpartner_assign_user,visa_booking_list.update_ticket_by,visa_booking_list.visa_type, visa_booking_list.payment_status,visa_booking_list.booking_status,visa_booking_list.total_price,visa_booking_list.created,visa_booking_list.is_manual,
            agent.company_name,agent.company_id,CONCAT(agent_users.first_name," ",agent_users.last_name) as staff_name,CONCAT(admin_users.first_name," ",admin_users.last_name) as assign_user_name,visa_booking_list.wl_agent_id,visa_booking_list.wl_customer_id')
            ->join("agent_users", "agent_users.id=visa_booking_list.wl_agent_staff_id", 'left')  
            ->join('agent', "visa_booking_list.wl_agent_id = agent.id", 'left')  
            ->join('admin_users', "admin_users.id = visa_booking_list.webpartner_assign_user", 'left')->where("visa_booking_list.web_partner_id", $web_partner_id);

        if ($source != "dashboard") {
            $builder->where($array);
        }

        if ($bookingType == "Processing") {
            $builder->where(["visa_booking_list.booking_status" => "Processing"]);
            if ($source != "dashboard") {
                $builder->where($array);
            }
        }
        if ($bookingType == "Cancelled") {
            $builder->where(["visa_booking_list.booking_status" => "Cancelled"])->orWhere(["visa_booking_list.booking_status" => "PartialCancelled"]);
        }
        return $builder->groupBy("visa_booking_list.id")->orderBy("visa_booking_list.id", "DESC")->paginate(30);
            
    }


    function search_data($data, $web_partner_id, $userId, $userType, $bookingType = "all", $source = null)
    {
        $arrayValue = array("booking_ref_number" => "booking_ref_number", "first_name" => "visa_booking_travelers.first_name", "last_name" => "visa_booking_travelers.last_name", "web_partner_fare_break_up" => "visa_booking_list.web_partner_fare_break_up", "booking_status" => "visa_booking_list.booking_status", "payment_status" => "visa_booking_list.payment_status");
        $bookinSource = ["B2B" => "Wl_b2b", "B2C" => "Wl_b2c"];
        $builder = $this->select('visa_booking_list.*,agent.company_name,agent.company_id,CONCAT(agent_users.first_name," ",agent_users.last_name) as staff_name,CONCAT(admin_users.first_name," ",admin_users.last_name) as assign_user_name')
            ->join("agent_users", "agent_users.id=visa_booking_list.wl_agent_staff_id", 'left')
            ->join('admin_users', "admin_users.id = visa_booking_list.webpartner_assign_user", 'left')
            ->join('agent', "visa_booking_list.wl_agent_id = agent.id", 'left');
            $builder->join('visa_booking_travelers', "visa_booking_travelers.visa_booking_id = visa_booking_list.id", 'left');
        
            $builder->where("visa_booking_list.web_partner_id", $web_partner_id);
        if (isset($data['from_date']) && isset($data['to_date']) && $data['from_date'] != "" && $data['to_date'] != "") {
            $from_date = strtotime(date('Y-m-d', strtotime($data['from_date'])) . ' 00:00');
            $to_date = strtotime(date('Y-m-d', strtotime($data['to_date'])) . ' 23:59');
            $Datearray = ['visa_booking_list.created >=' => $from_date, 'visa_booking_list.created <=' => $to_date];
        }

        if (isset($data['value']) && $data['value']) {
            $Datearray = [];
        }
        $array = [];
        if (isset($data['booking_source']) && $data['booking_source'] != "") {
            $array['visa_booking_list.booking_source'] = $bookinSource[$data['booking_source']];
        }
        if (isset($data['tts_web_partner_info']) && $data['tts_web_partner_info'] != "") {
            $array['visa_booking_list.wl_agent_id'] = $data['tts_web_partner_info'];
        }
        if ($bookingType == "Processing") {
            $array['visa_booking_list.booking_status'] = "Processing";
        }
        if ($bookingType == "Cancelled") {
            $array['visa_booking_list.booking_status'] = "Cancelled";
        }
        if (!empty($array)) {
            $builder->where($array);
        }

        if (!empty($Datearray)) {
            $builder->where($Datearray);
        }
        if (isset($arrayValue[trim($data['key'])])) {
            $builder->like($arrayValue[trim($data['key'])], trim($data['value']));
        }
        return $builder->groupBy("visa_booking_list.id")->orderBy("visa_booking_list.id", "DESC")->paginate(30);
    }

    
      



    public function Visa_booking_detail($web_partner_id, $booking_refrence_number, $userId, $userType)
    {

        $builder = $this->db->table('visa_booking_list');
        $builder->select("visa_booking_list.*,CONCAT(agent_users.first_name,' ',agent_users.last_name) as staff_name,CONCAT(admin_users.first_name,' ',admin_users.last_name) as assign_user_name")
           ->join("agent_users", "agent_users.agent_id=visa_booking_list.wl_agent_id", 'left')
            ->join("admin_users", "admin_users.id=visa_booking_list.agent_staff_id", 'left');
        $builder->where(['visa_booking_list.booking_ref_number' => $booking_refrence_number, 'visa_booking_list.web_partner_id' => $web_partner_id]);
        $builder->join('visa_booking_travelers', "visa_booking_travelers.visa_booking_id = visa_booking_list.id");
        $builder->groupBy('visa_booking_list.id');
        $query = $builder->get()->getRowArray();
        if ($query) {
            if ($query['booking_source'] == "Wl_b2b") {
                $builder = $this->db->table('agent_account_log');
                $builder->select("agent_account_log.id,agent_account_log.acc_ref_number,agent_account_log.invoice_number,agent_account_log.debit,agent_account_log.credit,agent_account_log.service,agent_account_log.balance,agent_account_log.remark,agent_account_log.service_log,agent_account_log.transaction_id,agent_account_log.payment_mode,agent_account_log.transaction_type,agent_account_log.extra_param,agent_account_log.action_type,agent_account_log.created");
                $builder->where(['agent_account_log.web_partner_id' => $web_partner_id, "agent_account_log.service" => "visa"]);
                $builder->where('find_in_set("'.$query['id'].'", agent_account_log.booking_ref_no) <> 0');
                $query['paymentInfo'] = $builder->get()->getResultArray();
                $agentBuilder = $this->db->table('agent');
                $agentBuilder->select("agent.company_name,agent_users.login_email,agent_users.mobile_no,agent_users.first_name,agent_users.last_name,agent.company_id");
                $agentBuilder->join("agent_users", "agent.id = agent_users.agent_id");
                $agentBuilder->where(['agent.web_partner_id' => $query['web_partner_id'], "agent.id" => $query['wl_agent_id']]);
                $query['AgentInfo'] = $agentBuilder->get()->getRowArray();
            }
            if ($query['booking_source'] == "Wl_b2c") {
                $builder = $this->db->table('customer_account_log');
                $builder->select("customer_account_log.id,customer_account_log.acc_ref_number,customer_account_log.invoice_number,customer_account_log.debit,customer_account_log.credit,customer_account_log.service,customer_account_log.balance,customer_account_log.remark,customer_account_log.service_log,customer_account_log.transaction_id,customer_account_log.extra_param,customer_account_log.payment_mode,customer_account_log.transaction_type,customer_account_log.action_type,customer_account_log.created");
                $builder->where(['customer_account_log.web_partner_id' => $web_partner_id, "customer_account_log.service" => "visa"]);
                $builder->where('find_in_set("'.$query['id'].'", customer_account_log.booking_ref_no) <> 0');
                $query['paymentInfo'] = $builder->get()->getResultArray();
                $agentBuilder = $this->db->table('customer');
                $agentBuilder->select("customer.customer_id,customer.email_id,customer.mobile_no,customer.first_name,customer.last_name");
                $agentBuilder->where(['customer.web_partner_id' => $query['web_partner_id'], "customer.id" => $query['wl_customer_id']]);
                $query['CustomerInfo'] = $agentBuilder->get()->getRowArray();
            }


            $builder = $this->db->table('visa_booking_travelers');
            $builder->select("visa_booking_travelers.*,CONCAT(visa_booking_travelers.dial_code,' ',visa_booking_travelers.mobile_number) as PHONE_NO,CONCAT(visa_booking_travelers.title,' ',visa_booking_travelers.first_name,' ',visa_booking_travelers.last_name) as NAME");
            $builder->where(['visa_booking_travelers.visa_booking_id' => $query['id']]);
             
    
            $query['travellers'] = $builder->get()->getResultArray();

        }
        return $query;
    }




    public function amendment_list($web_partner_id, $booking_reference_number,$booking_source)
    {
        if($booking_source == "Wl_b2b"){
            $result =   $this->db->table('visa_amendment')->select("visa_amendment.*,CONCAT(agent_users.first_name,' ',agent_users.last_name) as staff_name")
            ->join("agent_users","agent_users.agent_id=visa_amendment.wl_agent_id",'left')->where('primary_user',1)
            ->where(["visa_amendment.web_partner_id"=>$web_partner_id,"visa_amendment.booking_ref_no"=>$booking_reference_number])
            ->get()->getResultArray();
        }else if($booking_source == "Wl_b2c"){
            $result =   $this->db->table('visa_amendment')->select("visa_amendment.*,CONCAT(customer.first_name,' ',customer.last_name) as staff_name")
            ->join("customer","customer.id=visa_amendment.wl_customer_id",'left')
            ->where(["visa_amendment.web_partner_id"=>$web_partner_id,"visa_amendment.booking_ref_no"=>$booking_reference_number])
            ->get()->getResultArray();
        }else{
            $result = array();
        }
        return $result;
       
    }


    function getDataArray($tableName, $where, $singalRecord = 1, $whereApply = 1, $selectedColumnValue = null)
    {
        $builder = $this->db->table($tableName);

        if ($selectedColumnValue != null) {
            $builder->select($selectedColumnValue);
        }
        if ($whereApply) {
            $builder->where($where);
        }
        if ($singalRecord) {
            return $builder->get()->getRowArray();
        } else {
            return $builder->get()->getResultArray();
        }
    }
 
    function updateUserData($tableName,$whereCondition,$updateData)
    {
       return $this->db->table($tableName)->where($whereCondition)->update($updateData);
    }


     
   
    



































    function getBookingDetailData($ref,$web_partner_id)
    {
        $builder = $this->db->table('visa_booking_list');
        $builder->select("visa_booking_list.id, visa_booking_list.visa_country,visa_booking_list.visa_type,visa_booking_list.no_of_travellers,visa_booking_list.processing_time,visa_booking_list.booking_ref_number,visa_booking_list.payment_status,visa_booking_list.confirmation_no,visa_booking_list.conveniencefee,
        visa_booking_list.booking_status,visa_booking_list.created,visa_booking_list.total_price,visa_booking_list.super_admin_fare_break_up,visa_booking_list.tts_search_token,visa_booking_list.booking_channel,visa_booking_list.date_of_journey,visa_booking_list.webpartner_assign_user,visa_booking_list.web_partner_id,visa_booking_list.web_partner_fare_break_up,visa_booking_list.booking_source,CONCAT(agent_users.first_name,' ',agent_users.last_name) as staff_name,CONCAT(admin_users.first_name,' ',admin_users.last_name) as assign_user_name");
        $builder->where(['visa_booking_list.booking_ref_number' => $ref, 'visa_booking_list.web_partner_id' => $web_partner_id])
            ->join("admin_users", "admin_users.id=visa_booking_list.webpartner_assign_user", 'left')
            ->join("agent_users", "agent_users.id=visa_booking_list.wl_agent_staff_id", 'left');



        $builder->groupBy('visa_booking_list.id');
        $query = $builder->get()->getRowArray();
        if ($query) {

            $builder = $this->db->table('visa_booking_list');
            $builder->select("visa_booking_travelers.email_id,visa_booking_travelers.mobile_number,visa_booking_travelers.title,visa_booking_travelers.first_name,visa_booking_travelers.last_name,
       visa_booking_travelers.gendar,visa_booking_travelers.dob,visa_booking_travelers.lead_pax,visa_booking_travelers.document");
            $builder->where(['visa_booking_list.id' => $query['id']]);
            $builder->join('visa_booking_travelers', "visa_booking_travelers.visa_booking_id = visa_booking_list.id");
            $query['travellers'] = $builder->get()->getResultArray();

            if($query['booking_source'] == "Wl_b2c"){
                $builder = $this->db->table('visa_booking_list');
                $builder->select("customer_account_log.*")
                    ->join("customer_account_log", "customer_account_log.booking_ref_no=visa_booking_list.id");
                $builder->where(['visa_booking_list.booking_ref_number' => $ref, 'customer_account_log.service'=>'visa']);
                $query['paymentInfo'] = $builder->get()->getResultArray();
               
    
            }else{
                $builder = $this->db->table('visa_booking_list');
                $builder->select("agent_account_log.*")
                    ->join("agent_account_log", "agent_account_log.booking_ref_no=visa_booking_list.id");
                $builder->where(['visa_booking_list.booking_ref_number' => $ref, 'agent_account_log.service'=>'visa']);
                $query['paymentInfo'] = $builder->get()->getResultArray();
    
            } 

            $query['email'] ='';
            $query['mobile_no'] ='';
        }
        return $query;
    }

 

   
 
    function getBulkData($tableName, $whereClause, $gettingColumn)
    {
        $builder = $this->db->table($tableName);
        $builder->select($gettingColumn);
        $builder->orderBy("id", "DESC");
        return $builder->where($whereClause)->get()->getResultArray();
    }

   



    

















    
    
    function admin_gst_state_code()
    {
        $builder = $this->db->table('super_admin_website_setting');
        $builder->select('gst_state_code');
        return $builder->get()->getRowArray();
    }
    public function offers_list()
    {
        return $this->db->table('super_admin_offers')->select('id,title,description,service,url,image')
            ->where('status','active')->where('service','visa')->limit(9)->orderBy('id', 'DESC')->get()->getResultArray();
    }
    function insertData($tableName, $insertData)
    {
        $this->db->table($tableName)->insert($insertData);
        return $this->db->insertID();
    }


    function get_dial_code()
    {
        return $this->db->table('countries')->select('phonecode,name')->get()->getResultArray();
    }


    function insertBatchData($tableName, $insertData)
    {
        $this->db->table($tableName)->insertBatch($insertData);
    }

    function verify_tts_search_token($array_condition)
    {
        $db = \Config\Database::connect('api');
        $builder = $db->table('tts_visa_log');
        $builder->select('*');
        $builder->where($array_condition);
        $builder->orderBy("id", "desc");
        return $builder->get()->getRowArray();
    }

    function get_booking_detail_search_token($web_partner_id, $tts_search_token)
    {
        $builder = $this->db->table('visa_booking_list')->select('visa_booking_list.super_admin_fare_break_up');
        $builder->where("visa_booking_list.tts_search_token", $tts_search_token);
        $builder->where("visa_booking_list.web_partner_id", $web_partner_id);
        $result = $builder->countAllResults();
        if ($result == 0) {
            return 1;
        } else {
            return 0;
        }
    }

    function getData($tableName, $whereClause, $gettingColumn)
    {
        $builder = $this->db->table($tableName);
        $builder->select($gettingColumn);
        $builder->orderBy("id", "DESC");
        return $builder->where($whereClause)->get()->getRowArray();
    }

    function get_list_by_table_name($table, $field, $where)
    {
        $builder = $this->db->table($table);
        $builder->select($field);
        if (!empty($where)) {
            $builder->where($where);
        }
        return $builder->get()->getRowArray();
    }



    function getBookingConfirmationData($bookingid, $web_partner_id)
    {

        $builder = $this->db->table('visa_booking_list');
        $builder->select("visa_booking_list.id, visa_booking_list.visa_country,visa_booking_list.visa_type,visa_booking_list.no_of_travellers,visa_booking_list.processing_time,visa_booking_list.booking_ref_number,visa_booking_list.payment_status,visa_booking_list.documentType,visa_booking_list.tts_search_token,visa_booking_list.date_of_journey,visa_booking_list.visa_detail,visa_booking_list.visa_document,
        visa_booking_list.booking_status,visa_booking_list.created,visa_booking_list.total_price,visa_booking_list.web_partner_fare_break_up,visa_booking_list.agent_fare_break_up,visa_booking_list.coupon_info,visa_booking_list.booking_source,visa_booking_list.customer_fare_break_up");
        $builder->where(['visa_booking_list.id' => $bookingid, 'visa_booking_list.web_partner_id' => $web_partner_id]);

        $builder->groupBy('visa_booking_list.id');
        $query = $builder->get()->getRowArray();

        //get all travellers
        $builder = $this->db->table('visa_booking_list');
        $builder->select("visa_booking_travelers.email_id,visa_booking_travelers.mobile_number,visa_booking_travelers.title,visa_booking_travelers.first_name,visa_booking_travelers.last_name,
       visa_booking_travelers.gendar,visa_booking_travelers.dob,visa_booking_travelers.document");
        $builder->where(['visa_booking_list.id' => $bookingid, 'visa_booking_list.web_partner_id' => $web_partner_id]);
        $builder->join('visa_booking_travelers', "visa_booking_travelers.visa_booking_id = visa_booking_list.id");

        $query['travellers'] = $builder->get()->getResultArray();

        return $query;
    }

   


    
 











    public function search_data_sales_report($web_partner,$data,$page){


        $builder =  $this->select('visa_booking_list.id,visa_booking_list.web_partner_id,visa_booking_list.date_of_journey,visa_booking_list.payment_mode,visa_booking_list.tts_search_token,visa_booking_list.booking_ref_number,visa_booking_list.visa_country,visa_booking_list.assign_user,visa_booking_list.update_ticket_by,visa_booking_list.visa_type,
        visa_booking_list.payment_status,visa_booking_list.booking_status,visa_booking_list.total_price,visa_booking_list.created,visa_booking_list.is_manual,visa_booking_list.web_partner_fare_break_up,
        web_partner.company_name,web_partner.company_id,CONCAT(admin_users.first_name," ",admin_users.last_name) as staff_name,CONCAT(super_admin_users.first_name," ",super_admin_users.last_name) as assign_user_name')
            ->where("visa_booking_list.web_partner_id", $web_partner)->join("admin_users", "admin_users.id=visa_booking_list.agent_staff_id", 'left')
            ->join('web_partner', "visa_booking_list.web_partner_id = web_partner.id", 'left')
            ->join('super_admin_users', "super_admin_users.id = visa_booking_list.assign_user", 'left');




        if (isset($data['from_date']) && isset($data['to_date']) && $data['from_date'] != "" && $data['to_date'] != "") {
            $from_date = strtotime(date('Y-m-d', strtotime($data['from_date'])) . ' 00:00');
            $to_date = strtotime(date('Y-m-d', strtotime($data['to_date'])) . ' 23:59');
            $Datearray = ['visa_booking_list.created >=' => $from_date, 'visa_booking_list.created <=' => $to_date];
        }

        if (isset($data['value']) && $data['value']) {
            $Datearray = [];
        }
        $array =[];

        if (isset($data['tts_web_partner_info']) && $data['tts_web_partner_info'] != "") {
            $array['visa_booking_list.web_partner_id'] = $data['tts_web_partner_info'];
        }

        if (!empty($array)) {
            $builder->where($array);
        }

        if (!empty($Datearray)) {
            $builder->where($Datearray);
        }
        if (isset($arrayValue[trim($data['key'])])) {
            $builder->like($arrayValue[trim($data['key'])], trim($data['value']));
        }
        $builder->where('visa_booking_list.payment_status','Successful');
        $builder->whereNotIn("visa_booking_list.booking_status", ['Failed','Processing']);
        return  $builder->groupBy("visa_booking_list.id")->orderBy("visa_booking_list.id", "DESC")->paginate($page);
    }

    public function data_sales_report($web_partner,$page){
        $tomorrow_timestamp = strtotime(date('Y-m-d'));
        $tomorrow_timestamp = date("Y-m-d", $tomorrow_timestamp);
        $from_date = strtotime(date('Y-m-d', strtotime($tomorrow_timestamp)) . '00:00');

        $to_date = strtotime(date('Y-m-d', strtotime(date('Y-m-d'))) . '23:59');

        $array = ['visa_booking_list.created >=' => $from_date, 'visa_booking_list.created <=' => $to_date];

        $builder =  $this->select('visa_booking_list.id,visa_booking_list.web_partner_id,visa_booking_list.date_of_journey,visa_booking_list.payment_mode,visa_booking_list.tts_search_token,visa_booking_list.booking_ref_number,visa_booking_list.visa_country,visa_booking_list.assign_user,visa_booking_list.update_ticket_by,visa_booking_list.visa_type,
        visa_booking_list.payment_status,visa_booking_list.booking_status,visa_booking_list.total_price,visa_booking_list.created,visa_booking_list.is_manual,visa_booking_list.web_partner_fare_break_up,
        web_partner.company_name,web_partner.company_id,CONCAT(admin_users.first_name," ",admin_users.last_name) as staff_name,CONCAT(super_admin_users.first_name," ",super_admin_users.last_name) as assign_user_name')
            ->where("visa_booking_list.web_partner_id", $web_partner)->join("admin_users", "admin_users.id=visa_booking_list.agent_staff_id", 'left')
            ->join('web_partner', "visa_booking_list.web_partner_id = web_partner.id", 'left')
            ->join('super_admin_users', "super_admin_users.id = visa_booking_list.assign_user", 'left')->where($array);




        $builder->where('visa_booking_list.payment_status','Successful');
        $builder->whereNotIn("visa_booking_list.booking_status", ['Failed','Processing']);
        return  $builder->groupBy("visa_booking_list.id")->orderBy("visa_booking_list.id", "DESC")->paginate($page);
    }




    function getBookingWithVariableFieldNameData($bookingid, $web_partner_id, $fieldName)
    {

        $builder = $this->db->table("visa_booking_list");
        $builder->select($fieldName);
        $builder->where(['visa_booking_list.id' => $bookingid, 'visa_booking_list.web_partner_id' => $web_partner_id]);
        $query = $builder->get()->getRowArray();
        return $query;
    }


    function getBookingWithBookingRefNumberWithVariableFieldNameData($bookingRefNumber, $web_partner_id, $fieldName)
    {

        $builder = $this->db->table("visa_booking_list");
        $builder->select($fieldName);
        $builder->where(['visa_booking_list.booking_ref_number' => $bookingRefNumber, 'visa_booking_list.web_partner_id' => $web_partner_id]);
        $query = $builder->get()->getRowArray();
        return $query;
    }


    function super_admin_booking_pre_fix_code()
    {
        $builder = $this->db->table('super_admin_website_setting');
        $builder->select('visa_pre_fix');
        return $builder->get()->getRowArray();
    }
   

}



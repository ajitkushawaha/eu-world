<?php

namespace App\Modules\Visa\Models;

use CodeIgniter\Model;

class AmendmentModel extends Model
{
    protected $table = 'visa_amendment';
    protected $primarykey = 'id';
    protected $protectFields = false;



    public function amendment_list($web_partner_id, $userId, $userType, $bookingType = "all", $source = null)
    {
        $tomorrow_timestamp = strtotime(date('Y-m-d'));
        $tomorrow_timestamp = date("Y-m-d", $tomorrow_timestamp);
        $from_date = strtotime(date('Y-m-d', strtotime($tomorrow_timestamp)) . '00:00');
        $to_date = strtotime(date('Y-m-d', strtotime(date('Y-m-d'))) . '23:59');
        $array = ['visa_amendment.created >=' => $from_date, 'visa_amendment.created <=' => $to_date];
        $builder = $this->select('visa_amendment.*,visa_booking_list.id as Booking_id,visa_booking_list.visa_country,visa_booking_list.visa_type,visa_booking_list.booking_ref_number,visa_booking_list.payment_status,
        visa_booking_list.booking_status,visa_booking_list.created as booking_created,visa_booking_list.total_price,visa_booking_list.web_partner_fare_break_up,visa_booking_list.date_of_journey,
        visa_booking_list.booking_source,customer.customer_id,customer.email_id as customeremailid,
       agent.company_name,agent.company_id,CONCAT(agent_users.first_name," ",agent_users.last_name) as staff_name,CONCAT(customer.first_name," ",customer.last_name) as customer_name,CONCAT(admin_users.first_name," ",admin_users.last_name) as admin_staff_name')
            ->join("admin_users", "admin_users.id=visa_amendment.agent_staff_id", 'left')
            ->join('agent', "visa_amendment.wl_agent_id = agent.id", 'left')
            ->join("agent_users", "agent_users.id=visa_amendment.wl_agent_staff_id", 'left')
            ->join("visa_booking_list", "visa_booking_list.id=visa_amendment.booking_ref_no", 'left')
            ->join("customer", "customer.id=visa_amendment.wl_customer_id", 'left')
            ->where("visa_amendment.web_partner_id", $web_partner_id);



        if ($source != "dashboard") {
            $builder->where($array);
        }

        if ($bookingType == "approved") {
            $builder->where(["visa_amendment.amendment_status" => "approved"]);
            if ($source != "dashboard") {
                $builder->where($array);
            }
        }
        if ($bookingType == "requested") {
            $builder->where(["visa_amendment.amendment_status" => "requested"]);
        }

        if ($bookingType == "rejected") {
            $builder->where(["visa_amendment.amendment_status" => "rejected"]);
        }
        if ($bookingType == "processing") {
            $builder->where(["visa_amendment.amendment_status" => "processing"]);
        }


        return $builder->groupBy("visa_amendment.id")->orderBy("visa_amendment.id", "DESC")->paginate(30);
    }




    function search_data($data, $web_partner_id, $userId, $userType, $bookingType = "all", $source = null)
    {
        $arrayValue = array('booking_ref_number' => 'visa_booking_list.booking_ref_number', 'amendment_status' => 'visa_amendment.amendment_status', 'id' => 'visa_amendment.id', 'amendment_type' => 'visa_amendment.amendment_type', "booking_status" => "visa_booking_list.booking_status");
        $bookinSource = ["B2B" => "Wl_b2b", "B2C" => "Wl_b2c"];
        $builder = $this->select('visa_amendment.*,visa_booking_list.id as Booking_id,visa_booking_list.visa_country,visa_booking_list.visa_type,visa_booking_list.booking_ref_number,visa_booking_list.payment_status,
         visa_booking_list.booking_status,visa_booking_list.created as booking_created,visa_booking_list.total_price,visa_booking_list.web_partner_fare_break_up,visa_booking_list.date_of_journey,
         visa_booking_list.booking_source,customer.customer_id,customer.email_id as customeremailid,
        agent.company_name,agent.company_id,CONCAT(agent_users.first_name," ",agent_users.last_name) as staff_name,CONCAT(customer.first_name," ",customer.last_name) as customer_name,CONCAT(admin_users.first_name," ",admin_users.last_name) as admin_staff_name')
        ->join("admin_users", "admin_users.id=visa_amendment.agent_staff_id", 'left')
            ->join('agent', "visa_amendment.wl_agent_id = agent.id", 'left')
            ->join("agent_users", "agent_users.id=visa_amendment.wl_agent_staff_id", 'left')
            ->join("visa_booking_list", "visa_booking_list.id=visa_amendment.booking_ref_no", 'left')
            ->join("customer", "customer.id=visa_amendment.wl_customer_id", 'left');



        $builder->where("visa_amendment.web_partner_id", $web_partner_id);

        if (isset($data['from_date']) && isset($data['to_date']) && $data['from_date'] != "" && $data['to_date'] != "") {
            $from_date = strtotime(date('Y-m-d', strtotime($data['from_date'])) . ' 00:00');
            $to_date = strtotime(date('Y-m-d', strtotime($data['to_date'])) . ' 23:59');
            $Datearray = ['visa_amendment.created >=' => $from_date, 'visa_amendment.created <=' => $to_date];
        }

        if (isset($data['value']) && $data['value']) {
            $Datearray = [];
        }
        $array = [];
        if (isset($data['booking_source']) && $data['booking_source'] != "") {
            $array['visa_booking_list.booking_source'] = $bookinSource[$data['booking_source']];
        }
        if (isset($data['tts_web_partner_info']) && $data['tts_web_partner_info'] != "") {
            $array['visa_amendment.wl_agent_id'] = $data['tts_web_partner_info'];
        }
        if ($bookingType == "requested") {
            $array['visa_amendment.amendment_status'] = "requested";
        }
        if ($bookingType == "approved") {
            $array['visa_amendment.amendment_status'] = "approved";
        }
        if ($bookingType == "rejected") {
            $array['visa_amendment.amendment_status'] = "rejected";
        }
        if ($bookingType == "processing") {
            $array['visa_amendment.amendment_status'] = "processing";
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
        return $builder->groupBy("visa_amendment.id")->orderBy("visa_amendment.id", "DESC")->paginate(30);
    }





    public function amendment_detail($web_partner_id, $amendment_id)
    {
        $builder = $this->db->table('visa_amendment');
        $builder = $this->select('visa_amendment.*,visa_booking_list.id as Booking_id, visa_booking_list.booking_source,visa_booking_list.visa_country,visa_booking_list.visa_type,visa_booking_list.booking_ref_number,visa_booking_list.payment_status,visa_booking_list.no_of_travellers,
        visa_booking_list.booking_status,visa_booking_list.created as booking_created,visa_booking_list.total_price,visa_booking_list.web_partner_fare_break_up,visa_booking_list.date_of_journey, 
        agent.company_name,agent.company_id,CONCAT(admin_users.first_name," ",admin_users.last_name) as admin_staff_name,visa_booking_list.super_admin_fare_break_up,visa_booking_list.amendment_charges,visa_booking_list.booking_channel,
        customer.customer_id,customer.email_id as customeremailid, agent.company_name,agent.company_id,CONCAT(agent_users.first_name," ",agent_users.last_name) as staff_name,CONCAT(customer.first_name," ",customer.last_name) as customer_name,CONCAT(admin_users.first_name," ",admin_users.last_name) as staff_name,')
            ->where(['visa_amendment.id' => $amendment_id, 'visa_amendment.web_partner_id' => $web_partner_id])
            ->join('agent', "visa_amendment.wl_agent_id = agent.id", 'left')
            ->join("agent_users", "agent_users.id=visa_amendment.wl_agent_staff_id", 'left')
            ->join("visa_booking_list", "visa_booking_list.id=visa_amendment.booking_ref_no", 'left')
            ->join("customer", "customer.id=visa_amendment.wl_customer_id", 'left')
            ->join("admin_users", "admin_users.id=visa_amendment.agent_staff_id", 'left');

        $query = $builder->get()->getRowArray();

        if ($query) {
            if ($query['booking_source'] == "Wl_b2b") {
                $builder = $this->db->table('agent_account_log');
                $builder->select("agent_account_log.id,agent_account_log.acc_ref_number,agent_account_log.invoice_number,agent_account_log.debit,agent_account_log.credit,agent_account_log.service,agent_account_log.balance,agent_account_log.remark,agent_account_log.service_log,agent_account_log.transaction_id,agent_account_log.payment_mode,agent_account_log.transaction_type,agent_account_log.extra_param,agent_account_log.action_type,agent_account_log.created");
                $builder->where(['agent_account_log.web_partner_id' => $web_partner_id, "agent_account_log.service" => "visa"]);
                $builder->where('find_in_set("' . $query['id'] . '", agent_account_log.booking_ref_no) <> 0');
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
                $builder->where('find_in_set("' . $query['id'] . '", customer_account_log.booking_ref_no) <> 0');
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


    function visa_amendment_detail_by_id($amendment_id, $web_partner_id)
    {
        return $this->select("*")->where(["id" => $amendment_id, "amendment_status" => "approved", "web_partner_id" => $web_partner_id])->get()->getRowArray();
    }

    function agent_user_gst_state_code($tableName, $user_id, $web_partner_id)
    {
        $builder = $this->db->table($tableName);
        $builder->where("id", $user_id);
        $builder->where('web_partner_id', $web_partner_id);
        $builder->select('gst_state_code');
        return $builder->get()->getRowArray();
    }




    public function refund_list($web_partner_id, $userId, $userType, $bookingType = "all", $source = null)
    {

        $tomorrow_timestamp = strtotime(date('Y-m-d'));
        $tomorrow_timestamp = date("Y-m-d", $tomorrow_timestamp);
        $from_date = strtotime(date('Y-m-d', strtotime($tomorrow_timestamp)) . '00:00');

        $to_date = strtotime(date('Y-m-d', strtotime(date('Y-m-d'))) . '23:59');

        $array = ['visa_amendment.created >=' => $from_date, 'visa_amendment.created <=' => $to_date];


        $builder =  $this->select('visa_amendment.*,visa_booking_list.id as Booking_id,visa_booking_list.visa_country,visa_booking_list.booking_source,visa_booking_list.visa_type,visa_booking_list.booking_ref_number,visa_booking_list.payment_status,
        visa_booking_list.booking_status,visa_booking_list.created as booking_created,visa_booking_list.total_price,visa_booking_list.web_partner_fare_break_up,visa_booking_list.date_of_journey,agent.company_name,agent.company_id,customer.customer_id,customer.email_id as customeremailid,
       CONCAT(admin_users.first_name," ",admin_users.last_name) as admin_staff_name,CONCAT(agent_users.first_name," ",agent_users.last_name) as staff_name')
            ->join("admin_users", "admin_users.id=visa_amendment.agent_staff_id", 'left')
            ->join("visa_booking_list", "visa_booking_list.id=visa_amendment.booking_ref_no", 'left')
            ->join('agent', "visa_amendment.wl_agent_id = agent.id", 'left')
            ->join("agent_users", "agent_users.id=visa_amendment.wl_agent_staff_id", 'left')
            ->join("customer", "customer.id=visa_amendment.wl_customer_id", 'left')
            ->where("visa_amendment.web_partner_id", $web_partner_id);
            /* ->where("visa_amendment.refund_status <>", NULL); */

        if ($source != "dashboard") {
            $builder->where($array);
        }

        if ($bookingType == "Open") {
            $builder->where(["visa_amendment.refund_status" => "Open"]);
            if ($source != "dashboard") {
                $builder->where($array);
            }
        }
        if ($bookingType == "Processing") {
            $builder->where(["visa_amendment.refund_status" => "Processing"]);
        }

        if ($bookingType == "Close") {
            $builder->where(["visa_amendment.refund_status" => "Close"]);
        }

        return $builder->groupBy("visa_amendment.id")->orderBy("visa_amendment.id", "DESC")->paginate(30);
    }





    function search_refund_list($data, $web_partner_id, $userId, $userType, $bookingType = "all", $source = null)
    {
        $arrayValue = array("booking_ref_number" => "visa_booking_list.booking_ref_number", "booking_status" => "visa_booking_list.booking_status", "amendment_status" => "visa_amendment.amendment_status", "amendment_id" => "visa_amendment.id");
        $bookinSource = ["B2B" => "Wl_b2b", "B2C" => "Wl_b2c"];
        $array['visa_amendment.web_partner_id'] = $web_partner_id;
        $arrayValue = array("booking_ref_number" => "booking_ref_number", "id" => "visa_amendment.id", "refund_status" => "visa_amendment.refund_status");
        $builder =  $this->select('visa_amendment.*,visa_booking_list.id as Booking_id,visa_booking_list.visa_country, visa_booking_list.booking_source,visa_booking_list.visa_type,visa_booking_list.booking_ref_number,visa_booking_list.payment_status,
        visa_booking_list.booking_status,visa_booking_list.created as booking_created,visa_booking_list.total_price,visa_booking_list.web_partner_fare_break_up,visa_booking_list.date_of_journey,
        customer.customer_id,customer.email_id as customeremailid, agent.company_name,agent.company_id,CONCAT(admin_users.first_name," ",admin_users.last_name) as admin_staff_name,CONCAT(agent_users.first_name," ",agent_users.last_name) as staff_name,CONCAT(customer.first_name," ",customer.last_name) as customer_name')
            ->join("admin_users", "admin_users.id=visa_amendment.agent_staff_id", 'left')
            ->join("visa_booking_list", "visa_booking_list.id=visa_amendment.booking_ref_no", 'left')
            ->join('agent', "visa_amendment.wl_agent_id = agent.id", 'left')
            ->join("agent_users", "agent_users.id=visa_amendment.wl_agent_staff_id", 'left')
            ->join("customer", "customer.id=visa_amendment.wl_customer_id", 'left');
        $builder->where("visa_amendment.web_partner_id", $web_partner_id);
       /*  ->where("visa_amendment.refund_status <>", NULL); */

        if (isset($data['from_date']) && isset($data['to_date']) && $data['from_date'] != "" && $data['to_date'] != "") {
            $from_date = strtotime(date('Y-m-d', strtotime($data['from_date'])) . ' 00:00');
            $to_date = strtotime(date('Y-m-d', strtotime($data['to_date'])) . ' 23:59');
            $Datearray = ['visa_amendment.created >=' => $from_date, 'visa_amendment.created <=' => $to_date];
        }

        if (isset($data['value']) && $data['value']) {
            $Datearray = [];
        }
        $array = [];
        if (isset($data['booking_source']) && $data['booking_source'] != "") {
            $array['activities_booking_list.booking_source'] = $bookinSource[$data['booking_source']];
        }

        if (isset($data['tts_web_partner_info']) && $data['tts_web_partner_info'] != "") {
            $array['activities_booking_list.wl_agent_id'] = $data['tts_web_partner_info'];
        }

        if ($bookingType == "Open") {
            $array['visa_amendment.refund_status'] = "Open";
        }
        if ($bookingType == "Processing") {
            $array['visa_amendment.refund_status'] = "Processing";
        }
        if ($bookingType == "Close") {
            $array['visa_amendment.refund_status'] = "Close";
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
        return $builder->groupBy("visa_amendment.id")->orderBy("visa_amendment.id", "DESC")->paginate(30);
    }








    function updateData($updateData, $Where)
    {
        return $this->select("*")->where($Where)->set($updateData)->update();
    }

    public function agent_user_available_balance($tableName, $key, $user_id, $web_partner_id)
    {
        return $this->db->table($tableName)->select('balance')->where($key, $user_id)->where('web_partner_id', $web_partner_id)->orderBy('id', 'DESC')->limit(1)->get()->getRowArray();
    }
}

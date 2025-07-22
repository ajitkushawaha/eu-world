<?php

namespace App\Modules\Customer\Models;

use CodeIgniter\Model;

class CustomerTravelersModel extends Model
{
    protected $table = 'visa_travelers_detail';
    protected $primarykey = 'id';
    protected $protectFields = false;



    public function customer_travelers_list($web_partner_id, $wl_customer_id)
    {
        return $this->select('*')->where("wl_customer_id", $wl_customer_id)->where('web_partner_id', $web_partner_id)->paginate(40);
    }
    function search_data($web_partner_id, $data, $wl_customer_id)
    {
        if ($data['from_date'] && $data['to_date']) {
            $from_date = strtotime(date('Y-m-d', strtotime($data['from_date'])) . '00:00');
            $to_date = strtotime(date('Y-m-d', strtotime($data['to_date'])) . '23:59');
            if ($data['key'] == 'date-range') {
                $array = ['visa_travelers_detail.created >=' => $from_date, 'visa_travelers_detail.created <=' => $to_date];
                return  $this->select('visa_travelers_detail.*')->where('visa_travelers_detail.web_partner_id', $web_partner_id)->where('visa_travelers_detail.wl_customer_id', $wl_customer_id)->where($array)->paginate(40);
            } else {
                $array = ['visa_travelers_detail.created >=' => $from_date, 'visa_travelers_detail.created <=' => $to_date];
                return  $this->select('visa_travelers_detail.*')->where('visa_travelers_detail.web_partner_id', $web_partner_id)->where('visa_travelers_detail.wl_customer_id', $wl_customer_id)->where($array)->like(trim($data['key']), trim($data['value']))->paginate(40);
            }
        } else {
            return  $this->select('visa_travelers_detail.*')->where('visa_travelers_detail.web_partner_id', $web_partner_id)->where('visa_travelers_detail.wl_customer_id', $wl_customer_id)->like(trim($data['key']), trim($data['value']))->paginate(40);
        }
    }

    public function customer_travelers_details($id, $wl_customer_id, $web_partner_id)
    {
        return $this->select('visa_travelers_detail.*,customer.customer_id as wl_customer_id,customer.email_id as customeremail,customer.mobile_no as customer_no,customer.first_name as customerfirstname,customer.last_name as customerlastname ')
            ->join('customer', 'customer.id = visa_travelers_detail.wl_customer_id')
            ->where('visa_travelers_detail.id', $id)->where('visa_travelers_detail.web_partner_id', $web_partner_id)->where('visa_travelers_detail.wl_customer_id', $wl_customer_id)->get()->getRowArray();
    }


    public function remove_travelers_list($ids, $web_partner_id)
    {
        return  $this->select('*')->where('web_partner_id', $web_partner_id)->where("id", $ids)->delete();
    }
}

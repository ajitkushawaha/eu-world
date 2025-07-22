<?php

namespace App\Modules\Distributors\Models;

use CodeIgniter\Model;

class DistributorsAccountLogModel extends Model
{
    protected $table = 'distributor_account_log';
    protected $primarykey = 'id';
    protected $protectFields = false;


    public function account_logs($supplier_id, $web_partner_id, $searchdata = array())
    {
        $db = \Config\Database::connect();
        $subquery = $db->table('distributors')->select('id,company_name,pan_name,pan_number');
        $subquery = $subquery->getCompiledSelect();
        $tomorrow_timestamp = strtotime(date('Y-m-d'));
        $tomorrow_timestamp = date("Y-m-d", $tomorrow_timestamp);
        $from_date = strtotime(date('Y-m-d', strtotime($tomorrow_timestamp)) . '00:00');

        $to_date = strtotime(date('Y-m-d', strtotime(date('Y-m-d'))) . '23:59');

        $array = ['distributor_account_log.created >=' => $from_date, 'distributor_account_log.created <=' => $to_date];
        if ((isset($searchdata['from_date']) && $searchdata['from_date'] != "") && (isset($searchdata['to_date']) && $searchdata['to_date'] != "")) {
            $from_date = strtotime(date('Y-m-d', strtotime($searchdata['from_date'])) . '00:00');
            $to_date = strtotime(date('Y-m-d', strtotime($searchdata['to_date'])) . '23:59');
            $array = ['distributor_account_log.created >=' => $from_date, 'distributor_account_log.created <=' => $to_date];
        }
        if (isset($searchdata['search-text']) && $searchdata['key-value'] != "") {
            $supplier_id = $searchdata['key-value'];
        }

        if (isset($searchdata['key']) && $searchdata['key'] != '') {


            if ($searchdata['key'] == 'service') {
                $array['distributor_account_log.service'] = $searchdata['value'];
            }

            if ($searchdata['key'] == 'credit') {
                $array['distributor_account_log.transaction_type'] = 'credit';
                $array['distributor_account_log.credit'] = $searchdata['value'];
            }
            if ($searchdata['key'] == 'balance') {
                $array['distributor_account_log.balance'] = 'balance';
            }

            if ($searchdata['key'] == 'debit') {
                $array['distributor_account_log.transaction_type'] = 'debit';
                $array['distributor_account_log.debit'] = $searchdata['value'];
            }
        }
        $array['distributor_account_log.web_partner_id'] = $web_partner_id;
        $array['distributor_account_log.distributor_id'] = $supplier_id;
        return $this->select('distributor_account_log.*,distributors.company_name,distributors.pan_name,distributors.pan_number,CONCAT(admin_users.first_name," ",admin_users.last_name) as web_partner_staff_name')
            ->join('admin_users', 'admin_users.id = distributor_account_log.user_id', 'Left')
            ->join("($subquery) distributors", 'distributors.id = distributor_account_log.distributor_id', 'Left')->where($array)
            ->orderBy("distributor_account_log.id", "DESC")->paginate(40);
    }

    public function available_balance($supplier_id, $web_partner_id)
    {
        return $this->select('balance')->where(['distributor_id' => $supplier_id, "web_partner_id" => $web_partner_id])->orderBy('id', 'DESC')->limit(1)->get()->getRowArray();
    }

    public function view_remark_detail($id, $web_partner_id)
    {
        $array['distributor_account_log.web_partner_id'] = $web_partner_id;
        $array['distributor_account_log.id'] = $id;
        return $this->select('distributor_account_log.distributor_id,distributor_account_log.id,distributor_account_log.transaction_type,distributor_account_log.web_partner_id,distributor_account_log.remark,distributor_account_log.extra_param,distributor_account_log.payment_mode,distributor_account_log.transaction_id,distributor_account_log.service_log,distributor_account_log.action_type,
               CONCAT(admin_users.first_name," ",admin_users.last_name) as web_partner_staff_name')
            ->join('admin_users', 'admin_users.id = distributor_account_log.user_id', 'Left')
            ->where($array)->get()->getRowArray();
    }
    public function servicesId($servicename, $booking_ref_number, $web_partner_id)
    {
        $tableName = $servicename . "_booking_list";
        return $this->db->table($tableName)->select('id')->where("booking_ref_number", $booking_ref_number)->where('web_partner_id', $web_partner_id)->get()->getRowArray();
    }
}

<?php

namespace App\Modules\Distributors\Models;

use CodeIgniter\Model;
use CodeIgniter\Database\BaseBuilder;

class DistributorsModel extends Model
{
    protected $table = 'distributors';
    protected $primarykey = 'id';
    protected $protectFields = false;

    public function distributors_list($web_partner_id)
    {
        $db = \Config\Database::connect();
        $builder = $db->table('distributor_account_log');
        $builder->whereIn('id', function (BaseBuilder $builder) {
            return $builder->select('MAX(id)', false)->from('distributor_account_log')->orderBy('id', 'DESC')->groupBy('distributor_id');
        });
        $subquery = $builder->getCompiledSelect();

        $distributor_users_subquery = $db->table('distributor_users')->select('id,distributor_id,login_email,mobile_isd,mobile_no')->where('primary_user', 1);
        $distributor_users_subquery = $distributor_users_subquery->getCompiledSelect();

        $Execute_Query = $this->select('distributors.id,distributors.company_id,distributors.company_name,distributors.pan_name,distributors.pan_number,distributor_account_log.balance,distributor_users.login_email,distributor_users.mobile_isd,distributor_users.mobile_no,distributor_users.distributor_id,distributors.state, distributors.city,distributors.country,distributors.pan_card,distributors.status,distributors.created,distributors.modified,distributor_class.class_name')
            ->join('distributor_class', 'distributor_class.id = distributors.distributor_class_id', 'left')
            ->join("($distributor_users_subquery) distributor_users", 'distributor_users.distributor_id = distributors.id', 'left')
            ->join("($subquery) distributor_account_log", 'distributor_account_log.distributor_id = distributors.id', 'left')
            ->orderBy('distributors.id', 'DESC')->where('distributors.web_partner_id', $web_partner_id)
            ->paginate(40);

        return $Execute_Query;
    }

    function search_data($data, $web_partner_id)
    {
        $db = \Config\Database::connect();
        $builder = $db->table('distributor_account_log');
        $builder->whereIn('id', function (BaseBuilder $builder) {
            return $builder->select('MAX(id)', false)->from('distributor_account_log')->orderBy('id', 'DESC')->groupBy('distributor_id');
        });
        $subquery = $builder->getCompiledSelect();

        $distributor_users_subquery = $db->table('distributor_users')->select('id,distributor_id,first_name,login_email,mobile_isd,mobile_no')->where('primary_user', 1);
        $distributor_users_subquery = $distributor_users_subquery->getCompiledSelect();

        $dataWhere = ['first_name' => 'distributor_users.first_name', 'login_email' => 'distributor_users.login_email', 'mobile_number' => 'distributor_users.mobile_no', 'class_name' => 'distributor_class.class_name', 'company_name' => 'distributors.company_name', 'status' => 'distributors.status'];

        $Execute_Query = $this->select('distributors.id,distributors.company_id,distributors.company_name,distributors.pan_name,distributors.pan_number,distributor_account_log.balance,distributor_users.login_email,distributor_users.mobile_isd,distributor_users.mobile_no,distributor_users.distributor_id,distributors.state, distributors.city,distributors.country,distributors.pan_card,distributors.status,distributors.created,distributors.modified,distributor_class.class_name')
            ->join('distributor_class', 'distributor_class.id = distributors.distributor_class_id', 'left')
            ->join("($distributor_users_subquery) distributor_users", 'distributor_users.distributor_id = distributors.id', 'left')
            ->join("($subquery) distributor_account_log", 'distributor_account_log.distributor_id = distributors.id', 'left')
            ->orderBy('distributors.id', 'DESC')->where('distributors.web_partner_id', $web_partner_id);

        if ($data['from_date'] && $data['to_date']) {
            $from_date = strtotime(date('Y-m-d', strtotime($data['from_date'])) . '00:00');
            $to_date = strtotime(date('Y-m-d', strtotime($data['to_date'])) . '23:59');
            if ($data['key'] == 'date-range') {
                $array = ['distributors.created >=' => $from_date, 'distributors.created <=' => $to_date];
                return $Execute_Query->where($array)->paginate(40);
            } else {
                $array = ['distributors.created >=' => $from_date, 'distributors.created <=' => $to_date];
                return $Execute_Query->where($array)->like($dataWhere[trim($data['key'])], trim($data['value']))->paginate(40);
            }
        } else {
            return $Execute_Query->like($dataWhere[trim($data['key'])], trim($data['value']))->paginate(40);
        }
    }



    function checkRegisterDistributors($email, $web_partner_id, $distributor_id = null)
    {
        $builder = $this->db->table("distributors")->select("distributors.id as distributor_id")
            ->join('distributor_users', 'distributor_users.distributor_id = distributors.id')
            ->where(["login_email" => $email, "distributors.web_partner_id" => $web_partner_id, "primary_user" => 1]);
        if ($distributor_id != null) {
            $builder->where(["distributors.id!=" => $distributor_id]);
        }
        return $builder->get()->getNumRows();
    }


    public function Get_distributors_list_details($web_partner_id, $id)
    {
        return $this->select('*')->where(["web_partner_id" => $web_partner_id, "id" => $id])->get()->getRowArray();
    }

    public function delete_image($id, $web_partner_id)
    {
        return $this->select('pan_card,aadhar_scan_copy,gst_scan_copy')->where(["id" => $id, "web_partner_id" => $web_partner_id])->get()->getRowArray();
    }
   

    public function remove_distributors($ids, $web_partner_id)
    {
        return $this->select('*')->where(["id" => $ids, "web_partner_id" => $web_partner_id])->delete();
    }

    public function distributors_status_change($ids, $data, $web_partner_id)
    {
        return $this->select('*')->where('id', $ids)->where(["web_partner_id" => $web_partner_id])->set($data)->update();
    }

    public function distributor_details_page($id, $web_partner_id)
    {
        $db = \Config\Database::connect();
        $distributor_users_subquery = $db->table('distributor_users')->select('id,distributor_id,login_email,mobile_isd,mobile_no,title,first_name,last_name')->where('primary_user', 1);
        $distributor_users_subquery = $distributor_users_subquery->getCompiledSelect();
        return $this->select('distributors.*,distributor_class.class_name,distributor_users.*')
            ->join("($distributor_users_subquery) distributor_users", 'distributor_users.distributor_id = distributors.id', 'left')
            ->join('distributor_class', 'distributor_class.id = distributors.distributor_class_id', 'left')
            ->where(['distributors.id' => $id, "distributors.web_partner_id" => $web_partner_id])->get()->getRowArray();
    }




    public function distributors_export($web_partner_id, $data)
    {
        if ($data['from_date'] && $data['to_date']) {
            $from_date = strtotime(date('Y-m-d', strtotime($data['from_date'])) . '00:00');
            $to_date = strtotime(date('Y-m-d', strtotime($data['to_date'])) . '23:59');
            $array = ['distributors.created >=' => $from_date, 'distributors.created <=' => $to_date];

            $db = \Config\Database::connect();
            $builder = $db->table('distributor_account_log');
            $builder->whereIn('id', function (BaseBuilder $builder) {
                return $builder->select('MAX(id)', false)->from('distributor_account_log')->orderBy('id', 'DESC')->groupBy('distributor_id');
            });
            $subquery = $builder->getCompiledSelect();
            return $this->select('distributors.*,distributor_users.*,distributor_class.class_name,distributor_account_log.balance')
                ->join('distributor_class', 'distributor_class.id = distributors.distributor_class_id')
                ->join('distributor_users', 'distributor_users.distributor_id = distributors.id')
                ->join("($subquery) distributor_account_log", 'distributor_account_log.distributor_id = distributors.id')
                ->orderBy('distributors.id', 'DESC')
                ->where('distributors.web_partner_id', $web_partner_id)->where($array)
                ->get()->getResultArray();
        } else {
            $db = \Config\Database::connect();
            $builder = $db->table('distributor_account_log');
            $builder->whereIn('id', function (BaseBuilder $builder) {
                return $builder->select('MAX(id)', false)->from('distributor_account_log')->orderBy('id', 'DESC')->groupBy('distributor_id');
            });
            $subquery = $builder->getCompiledSelect();
            return $this->select('distributors.*,distributor_users.*,distributor_class.class_name,distributor_account_log.balance')
                ->join('distributor_class', 'distributor_class.id = distributors.distributor_class_id')
                ->join('distributor_users', 'distributor_users.distributor_id = distributors.id')
                ->join("($subquery) distributor_account_log", 'distributor_account_log.distributor_id = distributors.id')
                ->orderBy('distributors.id', 'DESC')
                ->where('distributors.web_partner_id', $web_partner_id)
                ->get()->getResultArray();
        }
    }
}

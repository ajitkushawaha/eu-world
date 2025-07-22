<?php

namespace App\Modules\Distributors\Models;

use CodeIgniter\Model;
use CodeIgniter\Database\BaseBuilder;

class DistributorsUsersModel extends Model
{
    protected $table = 'distributor_users';
    protected $primarykey = 'id';
    protected $protectFields = false;


    public function Get_distributor_users_details($id, $web_partner_id)
    {
        return $this->select('id,first_name,last_name,title,login_email,mobile_isd,distributor_id,mobile_no,whatsapp_no,street,city,state,country,pin_code')
            ->where('primary_user', 1)
            ->where('distributor_id', $id)->where('web_partner_id', $web_partner_id)->get()->getRowArray();
    }

    public function remove_distributor_users($supplier_id, $web_partner_id)
    {
        return $this->select('*')->where('distributor_id', $supplier_id)->where(["web_partner_id" => $web_partner_id])->delete();
    }
    public function distributors_users_change($ids, $data, $web_partner_id)
    {
        $ids = explode(",", $ids);
        return $this->select('*')->whereIn('distributor_id', $ids)->where(["web_partner_id" => $web_partner_id])->set($data)->update();
    }
}

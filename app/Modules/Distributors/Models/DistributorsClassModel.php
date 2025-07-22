<?php

namespace App\Modules\Distributors\Models;

use CodeIgniter\Model;

class DistributorsClassModel extends Model
{
    protected $table = 'distributor_class';
    protected $primarykey = 'id';
    protected $protectFields = false;


    public function distributor_class_list($web_partner_id)
    {
        return $this->select('*')->where('web_partner_id', $web_partner_id)->orderBy("id", "DESC")->paginate(40);
    }

    public function distributor_class_list_select($web_partner_id)
    {
        return $this->select('class_name,id')->where('web_partner_id', $web_partner_id)->get()->getResultArray();
    }
    public function update_distributor_class($data, $web_partner_id, $id)
    {
        return $this->select('*')->where(array('web_partner_id' => $web_partner_id, 'id' => $id))->set($data)->update();
    }
}

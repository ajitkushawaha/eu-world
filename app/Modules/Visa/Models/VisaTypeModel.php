<?php

namespace App\Modules\Visa\Models;

use CodeIgniter\Model;

class VisaTypeModel extends Model
{

    protected $table = 'visa_type';
    protected $primarykey = 'id';
    protected $protectFields = false;

    function get_type_list($country_id, $web_partner_id)
    {
        $builder =  $this->db->table('visa_detail')->select('visa_type.visa_title as VisaTitle , visa_type.id as VisaTypeId')
            ->join('visa_type', 'visa_type.id = visa_detail.visa_list_id', 'Left');
        $builder->where("visa_detail.visa_country_id", $country_id);
        $builder->where("visa_detail.status", "active");
        $builder->orderBy('visa_detail.id', "desc");
        $builder->groupStart()->where(["visa_detail.web_partner_id" => $web_partner_id])->orWhere(["visa_detail.web_partner_id" => NULL])->groupEnd();
        return  $builder->get()->getResultArray();
    }

    public function visa_type($web_partner_id)
    {
        return  $this->select('id,visa_title,visa_title_slug,image,created,modified')->where(['web_partner_id' => $web_partner_id])->orderBy("id", "DESC")->paginate(40);
    }

    public function visa_type_details($id, $web_partner_id)
    {
        return  $this->select('id,visa_title,visa_title_slug,image')->where(['web_partner_id' => $web_partner_id])->where("id", $id)->get()->getRowArray();
    }




    public function visa_type_select($web_partner_id)
    {
        return  $this->select('id,visa_title')->where(['web_partner_id' => $web_partner_id])->get()->getResultArray();
    }

    public function delete_image($id, $web_partner_id)
    {
        return  $this->select('image')->where("id", $id)->where(['web_partner_id' => $web_partner_id])->get()->getRowArray();
    }

    public function remove_visa_type($id, $web_partner_id)
    {
        return  $this->select('*')->whereIn("id", $id)->where(['web_partner_id' => $web_partner_id])->delete();
    }

    public function status_change($ids, $data, $web_partner_id)
    {
        $ids = explode(",", $ids);
        return $this->select('*')->whereIn('id', $ids)->where(['web_partner_id' => $web_partner_id])->set($data)->update();
    }


    public function CheckUniqueSlug($value, $web_partner_id)
    {
        return $this->db->table("visa_type")->select('*')->where(['visa_title_slug' => $value, 'web_partner_id' => $web_partner_id])->get()->getResultArray();
    }


    function search_data($data, $web_partner_id)
    {
        if ($data['from_date'] && $data['to_date']) {
            $from_date = strtotime(date('Y-m-d', strtotime($data['from_date'])) . '00:00');
            $to_date = strtotime(date('Y-m-d', strtotime($data['to_date'])) . '23:59');
            if ($data['key'] == 'date-range') {
                $array = ['created >=' => $from_date, 'created <=' => $to_date];
                return $this->select('*')->orderBy('id', 'DESC')->where(["web_partner_id" => $web_partner_id])->where($array)->paginate(10);
            } else {
                $array = ['created >=' => $from_date, 'created <=' => $to_date];
                return $this->select('*')->orderBy('id', 'DESC')->where(["web_partner_id" => $web_partner_id])->where($array)->like(trim($data['key']), trim($data['value']))->paginate(40);
            }
        } else {
            return $this->select('*')->where(["web_partner_id" => $web_partner_id])->orderBy('id', 'DESC')->like(trim($data['key']), trim($data['value']))->paginate(10);
        }
    }
}

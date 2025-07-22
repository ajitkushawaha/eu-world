<?php

namespace App\Modules\Visa\Models;

use CodeIgniter\Model;

class FAQModel extends Model
{
    protected $table = 'faq_list';
    protected $primarykey = 'id';
    protected $protectFields = false;

    public function faq_list($web_partner_id, $visa_detail_id)
    {
        return $this->select('*')->where(["web_partner_id" => $web_partner_id])->where(["visa_detail_id" => $visa_detail_id])->orderBy("id", "DESC")->paginate(40);
    }
    public function remove_faq_list($ids, $web_partner_id)
    {
        return $this->select('*')->where(["web_partner_id" => $web_partner_id])->where(["visa_detail_id" => $visa_detail_id])->where("id", $ids)->delete();
    }

    public function status_change($ids, $web_partner_id, $data)
    {
        $ids = explode(",", $ids);
        return $this->select('*')->whereIn('id', $ids)->where(["web_partner_id" => $web_partner_id])->set($data)->update();
    }

    public function faq_list_details($id, $web_partner_id,)
    {
        return  $this->select('*')->where("id", $id)->where(["web_partner_id" => $web_partner_id])->get()->getRowArray();
    }


    function search_data($data, $web_partner_id, $visa_detail_id)
    {

        if ($data['from_date'] && $data['to_date']) {
            $from_date = strtotime(date('Y-m-d', strtotime($data['from_date'])) . '00:00');
            $to_date = strtotime(date('Y-m-d', strtotime($data['to_date'])) . '23:59');
            if ($data['key'] == 'date-range') {
                $array = ['created >=' => $from_date, 'created <=' => $to_date];
                return  $this->select('*')->where(["web_partner_id" => $web_partner_id])->where(["visa_detail_id" => $visa_detail_id])->orderBy('id', 'DESC')->where($array)->paginate(40);
            } else {
                $array = ['created >=' => $from_date, 'created <=' => $to_date];
                return  $this->select('*')->where(["web_partner_id" => $web_partner_id])->where(["visa_detail_id" => $visa_detail_id])->orderBy('id', 'DESC')->where($array)->like(trim($data['key']), trim($data['value']))->paginate(40);
            }
        } else {
            return  $this->select('*')->where(["web_partner_id" => $web_partner_id])->where(["visa_detail_id" => $visa_detail_id])->orderBy('id', 'DESC')->like(trim($data['key']), trim($data['value']))->paginate(40);
        }
    }

    public function visa_country_list($web_partner_id)
    {
        return $this->db->table('visa_country_list')
            ->select('country_code as CountryId, country_name as CountryName')
            ->where(['web_partner_id' => $web_partner_id])
            ->orderBy('id', 'DESC')->get()->getResultArray();
    }
}

<?php

namespace App\Modules\Visa\Models;

use CodeIgniter\Model;

class VisaQueryModel extends Model
{
    protected $table = 'visa_query';
    protected $primarykey = 'id';
    protected $protectFields = false;

    public function visa_query_list($web_partner_id)
    {
        return $this->select('*')->where("web_partner_id", $web_partner_id)->orderBy("id", "DESC")->paginate(40);
    }
    function search_data($web_partner_id, $data)
    {
        if ($data['from_date'] && $data['to_date']) {
            $from_date = strtotime(date('Y-m-d', strtotime($data['from_date'])) . '00:00');
            $to_date = strtotime(date('Y-m-d', strtotime($data['to_date'])) . '23:59');
            if ($data['key'] == 'date-range') {
                $array = ['visa_query.created >=' => $from_date, 'visa_query.created <=' => $to_date];
                return $this->select('visa_query.*')->where('visa_query.web_partner_id', $web_partner_id)->where($array)->paginate(40);
            } else {
                $array = ['visa_query.created >=' => $from_date, 'visa_query.created <=' => $to_date];
                return $this->select('visa_query.*')->where('visa_query.web_partner_id', $web_partner_id)->where($array)->like(trim($data['key']), trim($data['value']))->paginate(40);
            }
        } else {
            return $this->select('visa_query.*')->where('visa_query.web_partner_id', $web_partner_id)
                ->like(trim($data['key']), trim($data['value']))->paginate(40);
        }
    }
    public function visa_query_list_delete($id, $web_partner_id)
    {
        return $this->select('*')->whereIn("id", $id)->where(["web_partner_id" => $web_partner_id])->delete();
    }



}

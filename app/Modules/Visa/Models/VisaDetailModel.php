<?php

namespace App\Modules\Visa\Models;

use CodeIgniter\Model;

class VisaDetailModel extends Model
{
    protected $table = 'visa_detail';
    protected $primarykey = 'id';
    protected $protectFields = false;


    public function visa_details_list($web_partner_id)
    {
        return  $this->select('visa_detail.id,visa_detail.visa_detail,visa_detail.adult_price,visa_detail.child_price,visa_detail.processing_time_D/W,visa_detail.processing_time_value,visa_detail.processing_time,visa_detail.status,visa_detail.created,visa_detail.modified,visa_type.visa_title,visa_country_list.country_name')
            ->join('visa_type', 'visa_type.id = visa_detail.visa_list_id', 'Left')
            ->join('visa_country_list', 'visa_country_list.id = visa_detail.visa_country_id', 'Left')
            ->where(['visa_detail.web_partner_id' => $web_partner_id])
            ->where(['visa_type.web_partner_id' => $web_partner_id])
            ->where(['visa_country_list.web_partner_id' => $web_partner_id])
            ->orderBy("visa_country_list.id", "DESC")->paginate(40);
    }

    public function visa_details($id, $web_partner_id)
    {
        return  $this->select('id,adult_price,child_price,hot_listed,entry_type,stay_period,validity,e_visa,category,visa_schedule_time,company_schedule_time,important_information,inclusions,plan_disclaimer,stay_period,validity,processing_time_D/W,processing_time_value,processing_time,status,processing_time,visa_detail,visa_document,visa_list_id,documentType,visa_country_id,meta_title,meta_keyword,meta_description,meta_robots')->where(['web_partner_id' => $web_partner_id])->where("id", $id)->get()->getRowArray();
    }

    public function remove_visa_details($id, $web_partner_id)
    {

        return  $this->select('*')->whereIn("id", $id)->where(['web_partner_id' => $web_partner_id])->delete();
    }

    public function status_change($ids, $data, $web_partner_id)
    {
        $ids = explode(",", $ids);
        return $this->select('*')->whereIn('id', $ids)->where(['web_partner_id' => $web_partner_id])->set($data)->update();
    }

    function search_data($data, $web_partner_id)
    {

        if ($data['from_date'] && $data['to_date']) {
            $from_date = strtotime(date('Y-m-d', strtotime($data['from_date'])) . '00:00');
            $to_date = strtotime(date('Y-m-d', strtotime($data['to_date'])) . '23:59');
            $where = ['visa_title' => 'visa_type.visa_title', 'country_name' => 'visa_country_list.country_name'];
            if ($data['key'] == 'date-range') {
                $array = ['visa_detail.created >=' => $from_date, 'visa_detail.created <=' => $to_date];

                return  $this->select('visa_detail.id,visa_detail.visa_detail,visa_detail.adult_price,visa_detail.child_price,visa_detail.processing_time_D/W,visa_detail.processing_time_value,visa_detail.processing_time,visa_detail.status,visa_detail.created,visa_detail.modified,visa_type.visa_title,visa_country_list.country_name')
                    ->join('visa_type', 'visa_type.id = visa_detail.visa_list_id', 'Left')
                    ->join('visa_country_list', 'visa_country_list.id = visa_detail.visa_country_id', 'Left')
                    ->where(['visa_detail.web_partner_id' => $web_partner_id])
                    ->where(['visa_type.web_partner_id' => $web_partner_id])
                    ->where(['visa_country_list.web_partner_id' => $web_partner_id])
                    ->where($array)
                    ->orderBy("visa_country_list.id", "DESC")->paginate(40);
            } else {
                $array = ['visa_detail.created >=' => $from_date, 'visa_detail.created <=' => $to_date];

                return  $this->select('visa_detail.id,visa_detail.visa_detail,visa_detail.adult_price,visa_detail.child_price,visa_detail.processing_time_D/W,visa_detail.processing_time_value,visa_detail.processing_time,visa_detail.status,visa_detail.created,visa_detail.modified,visa_type.visa_title,visa_country_list.country_name')
                    ->join('visa_type', 'visa_type.id = visa_detail.visa_list_id', 'Left')
                    ->join('visa_country_list', 'visa_country_list.id = visa_detail.visa_country_id', 'Left')
                    ->where(['visa_detail.web_partner_id' => $web_partner_id])
                    ->where(['visa_type.web_partner_id' => $web_partner_id])
                    ->where(['visa_country_list.web_partner_id' => $web_partner_id])
                    ->where($array)->like($where[trim($data['key'])], trim($data['value']))
                    ->orderBy("visa_country_list.id", "DESC")->paginate(40);
            }
        } else {
            $where = ['visa_title' => 'visa_type.visa_title', 'country_name' => 'visa_country_list.country_name'];
            return  $this->select('visa_detail.id,visa_detail.visa_detail,visa_detail.adult_price,visa_detail.child_price,visa_detail.processing_time_D/W,visa_detail.processing_time_value,visa_detail.processing_time,visa_detail.status,visa_detail.created,visa_detail.modified,visa_type.visa_title,visa_country_list.country_name')
                ->join('visa_type', 'visa_type.id = visa_detail.visa_list_id', 'Left')
                ->join('visa_country_list', 'visa_country_list.id = visa_detail.visa_country_id', 'Left')
                ->where(['visa_detail.web_partner_id' => $web_partner_id])
                ->where(['visa_type.web_partner_id' => $web_partner_id])
                ->where(['visa_country_list.web_partner_id' => $web_partner_id])
                ->like($where[trim($data['key'])], trim($data['value']))
                ->orderBy("visa_country_list.id", "DESC")->paginate(40);
        }
    }


    public function get_visa_unique_details($web_partner_id, $visa_country_id, $visa_list_id)
    {
        return $this->select('id, adult_price,child_price,hot_listed,entry_type,stay_period,validity,e_visa,category,visa_schedule_time,company_schedule_time,important_information,inclusions,processing_time_D/W,processing_time_value, processing_time, status, visa_detail, visa_document, visa_list_id, documentType, visa_country_id')
            ->where('web_partner_id', $web_partner_id)
            ->where('visa_list_id', $visa_list_id)
            ->where('visa_country_id', $visa_country_id)
            ->get()->getRowArray();
    }
}

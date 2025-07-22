<?php

namespace App\Modules\Visa\Models;

use CodeIgniter\Model;

class VisaDiscountModel extends Model
{
    protected $table = 'web_partner_visa_discount';
    protected $primarykey = 'id';
    protected $protectFields = false;

 

    public function visa_discount_list($web_partner_id)
    {
        return $this->table('web_partner_visa_discount')
        ->select('web_partner_visa_discount.*, visa_country_list.country_name')
        ->join('visa_country_list', 'web_partner_visa_discount.visa_country_id = visa_country_list.id', 'left')
        ->where('web_partner_visa_discount.web_partner_id', $web_partner_id)
        ->orderBy('visa_country_list.id', 'DESC')
        ->paginate(40);
    }

    public function visa_discount_details($id,$web_partner_id)
    {
        return  $this->select('web_partner_visa_discount.*')->where("id",$id)->where('web_partner_id',$web_partner_id)->get()->getRowArray();
    }

    public function visa_type_list($web_partner_id)
    {
        return  $this->db->table("visa_type")->select('id,visa_title')->where('web_partner_id',$web_partner_id)->orderBy("id","DESC")->get()->getResultArray();
    }


    public function remove_discount($id,$web_partner_id)
    {
        return  $this->select('*')->whereIn("id",$id)->where('web_partner_id',$web_partner_id)->delete();
    }

    public function status_change($ids, $data,$web_partner_id)
    {
        $ids= explode(",", $ids);
        return $this->select('*')->whereIn('id', $ids)->where('web_partner_id',$web_partner_id)->set($data)->update();
    }

   

    function search_data($data,$web_partner_id)
    {
        if ($data['from_date'] && $data['to_date']) {
            $from_date = strtotime(date('Y-m-d', strtotime($data['from_date'])) . '00:00');
            $to_date = strtotime(date('Y-m-d', strtotime($data['to_date'])) . '23:59');
            $where = ['visa_type_id'=>'visa_type.visa_title','discount_for'=>'web_partner_visa_discount.discount_for','visa_country_id'=>'visa_country_list.country_name','discount_type'=>'web_partner_visa_discount.discount_type'];
            if ($data['key'] == 'date-range') {
                $array = ['web_partner_visa_discount.created >=' => $from_date, 'web_partner_visa_discount.created <=' => $to_date];
                return $this->table('web_partner_visa_discount')
                ->select('web_partner_visa_discount.*, visa_country_list.country_name')
                ->join('visa_country_list', 'web_partner_visa_discount.visa_country_id = visa_country_list.id', 'left')
                ->join('visa_type', 'web_partner_visa_discount.visa_type_id = visa_type.id', 'left')
                ->where('web_partner_visa_discount.web_partner_id', $web_partner_id)->where($array)
                ->orderBy('visa_country_list.id', 'DESC')
                ->paginate(40);
            } else {
                $array = ['web_partner_visa_discount.created >=' => $from_date, 'web_partner_visa_discount.created <=' => $to_date];
                return $this->table('web_partner_visa_discount')
                ->select('web_partner_visa_discount.*, visa_country_list.country_name')
                ->join('visa_country_list', 'web_partner_visa_discount.visa_country_id = visa_country_list.id', 'left')
                ->join('visa_type', 'web_partner_visa_discount.visa_type_id = visa_type.id', 'left')
                ->where('web_partner_visa_discount.web_partner_id', $web_partner_id)->where($array)->like($where[trim($data['key'])], trim($data['value']))
                ->orderBy('visa_country_list.id', 'DESC')
                ->paginate(40);
            }
        } else { 
            $where = ['visa_type_id'=>'visa_type.visa_title','discount_for'=>'web_partner_visa_discount.discount_for','visa_country_id'=>'visa_country_list.country_name','discount_type'=>'web_partner_visa_discount.discount_type'];
            return $this->table('web_partner_visa_discount')
            ->select('web_partner_visa_discount.*, visa_country_list.country_name')
            ->join('visa_country_list', 'web_partner_visa_discount.visa_country_id = visa_country_list.id', 'left')
            ->join('visa_type', 'web_partner_visa_discount.visa_type_id = visa_type.id', 'left')
            ->where('web_partner_visa_discount.web_partner_id', $web_partner_id)->like($where[trim($data['key'])], trim($data['value']))
            ->orderBy('visa_country_list.id', 'DESC')
            ->paginate(40); 

          
        }
    }




    // function search_data($data,$web_partner_id)
    // {
    //     if ($data['from_date'] && $data['to_date']) {
    //         $from_date = strtotime(date('Y-m-d', strtotime($data['from_date'])) . '00:00');
    //         $to_date = strtotime(date('Y-m-d', strtotime($data['to_date'])) . '23:59');
    //         if ($data['key'] == 'date-range') {
    //             $array = ['created >=' => $from_date, 'created <=' => $to_date];

    //             return  $this->select('web_partner_visa_discount.*')
    //                 ->where('web_partner_id',$web_partner_id)
    //                 ->where($array)
    //                 ->orderBy("id","DESC")->paginate(40);
    //         } else {
    //             $array = ['created >=' => $from_date, 'created <=' => $to_date];

    //             return  $this->select('web_partner_visa_discount.*')
    //                 ->where('web_partner_id',$web_partner_id)
    //                 ->where($array)->like(trim($data['key']), trim($data['value']))
    //                 ->orderBy("id","DESC")->paginate(40);
    //         }
    //     } else {

    //         return  $this->select('web_partner_visa_discount.*')
    //             ->where('web_partner_id',$web_partner_id)
    //             ->like(trim($data['key']), trim($data['value']))
    //             ->orderBy("id","DESC")->paginate(40);
    //     }
    // }
}
<?php

namespace App\Modules\Logs\Models;

use CodeIgniter\Model;

class SmsLogsModel extends Model
{
    protected $table = 'logs_sms';
    protected $primarykey = 'id';
    protected $protectFields = false;

    function search_data($web_partner_id,$data)
    {
        if($data['from_date'] && $data['to_date'])
        {
            $from_date=strtotime(date('Y-m-d',strtotime($data['from_date'])).'00:00');
            $to_date=strtotime(date('Y-m-d',strtotime($data['to_date'])).'23:59');
            if($data['key']=='date-range')
            {
                $array=['created >='=> $from_date,'created <='=> $to_date];
                return  $this->select('*')->orderBy('id', 'DESC')->where('web_partner_id',$web_partner_id)->where($array)->paginate(10);
            } else {
                $array=['created >='=> $from_date,'created <='=> $to_date];
                return  $this->select('*')->orderBy('id', 'DESC')->where('web_partner_id',$web_partner_id)->where($array)->like(trim($data['key']),trim($data['value']))->paginate(40);
            }
        } else {
            return  $this->select('*')->orderBy('id', 'DESC')->where('web_partner_id',$web_partner_id)->like(trim($data['key']),trim($data['value']))->paginate(10);
        }
    }

    public function smslogs_list($web_partner_id)
    {
        return  $this->select('id,to_sms,message,sms_type,status,role,created,modified_time')->orderBy('id', 'DESC')->where("web_partner_id",$web_partner_id)->paginate(40);
    }

    public function sms_logs_details($web_partner_id,$id)
    {
        return  $this->select('*')->where('web_partner_id',$web_partner_id)->where("id",$id)->get()->getRowArray();
    }

    public function remove_sms_logs($web_partner_id,$id)
    {

        return  $this->select('*')->where("web_partner_id",$web_partner_id)->whereIn("id",$id)->delete();

    }
}



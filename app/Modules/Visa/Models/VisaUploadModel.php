<?php 
namespace App\Modules\Visa\Models;
use CodeIgniter\Model;

class VisaUploadModel extends Model
{

    public function get_offline_supplier($web_partner_id)
    {
        return  $this->db->table('offline_provider')->select('id,supplier_name')->where(['web_partner_id'=>$web_partner_id,'visa_service'=>'active','status'=>'active'])->get()->getResultArray();
    }
}
 
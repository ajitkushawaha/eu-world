<?php

namespace App\Modules\Visa\Models;

use CodeIgniter\Model;

class DocumentTypeModel extends Model
{
    protected $table = 'website_common_data';
    protected $primarykey = 'id';
    protected $protectFields = false;

    function insertData($tableName, $insertData)
    {
        $this->db->table($tableName)->insert($insertData);
        return $this->db->insertID();
    } 

    public function remove_document_type($id,$web_partner_id)
    {
        return  $this->select('*')->whereIn("id",$id)->where(['web_partner_id'=>$web_partner_id])->delete();
    }


    public function document_details_list($web_partner_id)
    {
        return $this->select('*')->where(['web_partner_id'=>$web_partner_id,'service'=>'Visa','supplier_id'=>''])->orderBy("website_common_data.id", "DESC")->paginate(40);
    }

}
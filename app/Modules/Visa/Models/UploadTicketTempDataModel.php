<?php

namespace App\Modules\Visa\Models;

use CodeIgniter\Model;

class UploadTicketTempDataModel extends Model
{
    protected $table = '';
    protected $primarykey = '';
    protected $protectFields = false;

    function insertData($tableName, $data)
    {
        $this->db->table($tableName)->insert($data);
        return $this->db->insertID();
    }

    function getData($tableName, $where, $singalRecord = 1, $whereApply  =  1, $selectedColumnValue  = null)
    {
        $builder   = $this->db->table($tableName);
        if($selectedColumnValue != null)
        {
            $builder->select($selectedColumnValue);
        }

        if($whereApply)
        {
            $builder->where($where);
        }
        
        if($singalRecord)
        {
            $Returndata = $builder->get()->getRowArray();
            return $Returndata;
        }else{
            $Returndata = $builder->get()->getResultArray();
            return $Returndata;
        } 
    }

    function updateData($tableName,$whereClause,$data)
    {
        $this->db->table($tableName)
            ->where($whereClause)
            ->update($data);
        return $this->db->insertID();
    }

   

    function insertBatchData($tableName, $insertData)
    {
        $this->db->table($tableName)->insertBatch($insertData);
    }

    function finallyupdateData($tableName,$whereClause,$data)
    {
        return $this->db->table($tableName)
            ->where($whereClause)
            ->update($data);
        
    }

}

<?php



namespace App\Modules\Visa\Models;



use CodeIgniter\Model;



class WebPartnerVisaMarkupModel extends Model

{

    protected $table = 'web_partner_visa_markup';

    protected $primarykey = 'id';

    protected $protectFields = false;







    function getVisamarkup($web_partner_id){

    
        $builder = $this->db->table('web_partner_visa_markup');

        $builder->select('max_limit,markup_type,value,display_markup');

        $builder->where('web_partner_id', $web_partner_id);

        $builder->where('status', 'active');

       return $result = $builder->get()->getResultArray();

    }

}






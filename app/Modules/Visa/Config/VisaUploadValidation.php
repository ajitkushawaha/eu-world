<?php
namespace Modules\Visa\Config;

class VisaUploadValidation
{
    public $status = [ 
        'status' => [
            'label' => ' Status',
            'rules' => 'trim|required',
            'errors' => [
                'required' => 'Please select  status'
            ],
        ],
    ];

    public $visa_upload_validation = [
        'bussiness_type' => [
            'label' => 'Bussiness Type',
            'rules' => 'trim|required',
            'errors' => [
                'required' => 'Please select bussiness type'
            ],
        ],
        'agent_info' => [
            'label' => 'agent info',
            'rules' => 'trim|required',
            'errors' => [
                'required' => 'Please select agent info'
            ],
        ],
        'customer_info' => [
            'label' => 'customer info',
            'rules' => 'trim|required',
            'errors' => [
                'required' => 'Please select customer info'
            ],
        ],
        'visa_type' => [
            'label' => 'visa type',
            'rules' => 'trim|required',
            'errors' => [
                'required' => 'Please select visa type'
            ],
        ],
        'travel_date' => [
            'label' => 'travel date',
            'rules' => 'trim|required',
            'errors' => [
                'required' => 'Please select travel date'
            ],
        ],
       
        'basefare' => [
            'label' => 'basefare',
            'rules' => 'trim|required',
            'errors' => [
                'required' => 'Please select basefare'
            ],
        ],
        
        'tax' => [
            'label' => 'tax',
            'rules' => 'trim|required',
            'errors' => [
                'required' => 'Please enter tax'
            ],
        ],

        'destinations' => [
            'label' => 'destinations',
            'rules' => 'trim|required',
            'errors' => [
                'required' => 'Please enter destinations'

            ],
        ],
        'mark_per_pax' => [
            'label' => 'mark per pax',
            'rules' => 'trim|required',
            'errors' => [
                'required' => 'Please enter mark per pax'

            ],
        ],
        'discount' => [
            'label' => 'discount',
            'rules' => 'trim|required',
            'errors' => [
                'required' => 'Please enter discount'
            ],
        ],
 
        'markup_type' => [
            'label' => 'markup type',
            'rules' => 'trim|required',
            'errors' => [
                'required' => 'Please select markup type'
            ],
        ],
    ];


    public function pax_validation($data)
    {  
        $booking_validation = [];
        foreach ($data['pax_details'] as $key=> $requestParameter) {   

            $booking_validation["pax_details.$key.title"] = [
                'label' => 'title',
                'rules' => 'trim|required|in_list[Mr,Ms,Mrs,Miss,Master]',
                'errors' => [
                    'required' => 'Please select title'
                ],
            ];
            $booking_validation["pax_details.$key.first_name"] = [
                'label' => 'first name',
                'rules' => 'trim|required',
                'errors' => [
                    'required' => 'Please enter first name'
                ],
            ];

            $booking_validation["pax_details.$key.last_name"] = [
                'label' => 'last name',
                'rules' => 'trim|required',
                'errors' => [
                    'required' => 'Please enter last name'
                ],
            ]; 
            $booking_validation["pax_details.$key.dob"] = [ 
                'label' => 'Date of Birth',
                'rules' => 'trim|required|valid_date[d M Y]',
                'errors' => [
                    'required' => 'Please enter your date of birth',
                    'valid_date' => 'Please enter a valid date in the format dd M yyyy (e.g., 07 Jan 2023)',
                ], 
            ]; 
            $booking_validation["pax_details.$key.gender"] = [
                'label' => 'gender',
                'rules' => 'trim|required|in_list[Male,Female,Other]',
                'errors' => [
                    'required' => 'Please select gender'
                ],
            ];   
           
            if(isset($data['pax_details'][$key]['document']) && !empty($data['pax_details'][$key]['document'])){
                foreach ($data['pax_details'][$key]['document'] as $key2 => $value) {  
                    $booking_validation["pax_details.$key.$key2"] = [
                        'label' => str_replace('_',' ',ucwords($key2)),
                        'rules' => "uploaded[pax_details.$key.$key2]|max_size[pax_details.$key.$key2,512]|mime_in[pax_details.$key.$key2,image/jpg,image/jpeg,image/png]",
                        'errors' => [
                            'max_size' => 'Image size should not be more than 512kb',
                            'mime_in'=>'Please upload valid image. allowed image types are jpg, jpeg, png'
                        ], 
                    ];
                    
                }
            }

        } 
       

        $booking_validation['email'] = [
            'label' => 'email',
            'rules' => 'trim|required|valid_email',
            'errors' => [
                'required' => 'Please enter  email',
                'valid_email' => 'Please enter valid email'
            ],
        ];
        $booking_validation['mobile_number'] = [
            'label' => 'mobile number',
            'rules' => 'trim|required|numeric|min_length[7]|max_length[15]',
            'errors' => [
                'numeric' => 'Please enter valid mobile number',
                'required' => 'Please enter mobile number'
            ],
        ];
        $booking_validation['dial_code'] = [
            'label' => 'dial code',
            'rules' => 'trim|required|numeric',
            'errors' => [
                'numeric' => 'Please select dial code'
            ],
        ]; 

        return $booking_validation;
    }

    
}

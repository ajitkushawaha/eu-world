<?php

namespace Modules\Visa\Config;

class Validation
{


    public function pax_validation($data)
    {
        $booking_validation = [];
        foreach ($data['pax'] as $key => $requestParameter) {


            $booking_validation["pax.$key.Title"] = [
                'label' => 'title',
                'rules' => 'trim|required|in_list[Mr,Ms,Mrs,Miss,Master]',
                'errors' => [
                    'required' => 'Please enter title'
                ],
            ];
            $booking_validation["pax.$key.FirstName"] = [
                'label' => 'first name',
                'rules' => 'trim|required',
                'errors' => [
                    'required' => 'Please enter first name'
                ],
            ];

            $booking_validation["pax.$key.LastName"] = [
                'label' => 'last name',
                'rules' => 'trim|required',
                'errors' => [
                    'required' => 'Please enter last name'
                ],
            ];

            $booking_validation["pax.$key.DOB"] = [
                'label' => 'DOB',
                'rules' => 'trim|required',
                'errors' => [
                    'required' => 'Please enter dob'
                ],
            ];


            $booking_validation["pax.$key.Gender"] = [
                'label' => 'Gender',
                'rules' => 'trim|required|in_list[male,female]',
                'errors' => [
                    'required' => 'Please enter gender'
                ],
            ];
            foreach ($data['requireDoc'] as $key2 => $value) {
                if ($data[$value] == 1) {
                    $booking_validation["pax.$key.$value"] = [
                        'label' => str_replace('_', ' ', ucwords($value)),
                        'rules' => "uploaded[pax.$key.$value]|max_size[pax.$key.$value,512]|mime_in[pax.$key.$value,image/jpg,image/jpeg,image/png]",
                        'errors' => [
                            'max_size' => 'Image size should not be more than 512kb',
                            'mime_in' => 'Please upload valid image. allowed image types are jpg, jpeg, png'
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
        if ($data['add_gst_detail'] == 'true') {
            $booking_validation['gst.email'] = [
                'label' => 'email',
                'rules' => 'trim|required|valid_email',
                'errors' => [
                    'required' => 'Please enter email',
                    'valid_email' => 'Please enter valid email'
                ],
            ];
            $booking_validation['gst.name'] = [
                'label' => 'company name',
                'rules' => 'trim|required',
                'errors' => [
                    'required' => 'Please enter company name'
                ],
            ];

            $booking_validation['gst.phone'] = [
                'label' => 'mobile number',
                'rules' => 'trim|required|numeric|min_length[7]|max_length[15]',
                'errors' => [
                    'required' => 'Please enter mobile number'
                ],
            ];

            $booking_validation['gst.address'] = [
                'label' => 'address',
                'rules' => 'trim|required',
                'errors' => [
                    'required' => 'Please enter address'
                ],
            ];

            $booking_validation['gst.number'] = [
                'label' => 'gst number',
                'rules' => 'trim|required|regex_match[/^[0-9]{2}[A-Z]{5}[0-9]{4}[A-Z]{1}[1-9A-Z]{1}Z[0-9A-Z]{1}$/]',
                'errors' => [
                    'required' => 'Please enter gst number'
                ],
            ];
        }
        return $booking_validation;
    }



    public $booking_validation = [
        'Traveller.*.DOB' => [
            'label' => 'DOB',
            'rules' => 'trim|required',
            'errors' => [
                'required' => 'Please enter dob'
            ],
        ],

        'Traveller.*.Gender' => [
            'label' => 'Gender',
            'rules' => 'trim|required|in_list[male,female]',
            'errors' => [
                'required' => 'Please enter gender'
            ],
        ],

        'Traveller.*.PassportNo' => [
            'label' => 'passport no',
            'rules' => 'trim|required|regex_match[/^[A-PR-WYa-pr-wy][1-9]\\d\\s?\\d{4}[1-9]$/]',
            'errors' => [
                'required' => 'Please enter passport no'
            ],
        ],
        'Traveller.*.PassportExpiryDate' => [
            'label' => 'passport expiry date',
            'rules' => 'trim|required',
            'errors' => [
                'required' => 'Please enter passport expiry date'
            ],
        ],
    ];


    public $amendment_status = [

        'status' => [
            'label' => 'Status',
            'rules' => 'trim|required',
            'errors' => [
                'required' => 'Please select status'
            ],
        ],
        'admin_remark' => [
            'label' => 'remark',
            'rules' => 'trim|required',
            'errors' => [
                'required' => 'Please enter remark'
            ],
        ],

    ];


    public $amendment_refund_validation = [

        'amendment_id' => [
            'label' => 'AmendmentId',
            'rules' => 'trim|required',
            'errors' => [
                'required' => 'Please enter AmendmentId'
            ],
        ],
        'charge' => [
            'label' => 'charge',
            'rules' => 'trim|required|numeric|greater_than_equal_to[0]',
            'errors' => [
                'required' => 'Please enter charge',
                'numeric' => 'Please enter valid charge',
                'greater_than_equal_to' => 'Please enter valid charge'
            ],
        ],
        'service_charge' => [
            'label' => 'service charge',
            'rules' => 'trim|required|numeric|greater_than_equal_to[0]',
            'errors' => [
                'required' => 'Please enter service charge',
                'numeric' => 'Please enter service valid charge',
                'greater_than_equal_to' => 'Please enter service valid charge'
            ],
        ],
        'service_charge_gst' => [
            'label' => 'service charge gst',
            'rules' => 'trim|required|numeric|greater_than_equal_to[0]',
            'errors' => [
                'required' => 'Please enter service charge gst',
                'numeric' => 'Please enter service valid charge gst',
                'greater_than_equal_to' => 'Please enter service valid charge gst'
            ],
        ],


    ];




    public $refund_close_status = [

        'status' => [
            'label' => 'Status',
            'rules' => 'trim|required',
            'errors' => [
                'required' => 'Please select status'
            ],
        ],
        'account_remark' => [
            'label' => 'remark',
            'rules' => 'trim|required',
            'errors' => [
                'required' => 'Please enter remark'
            ],
        ],

    ];

    public $visa_details = [
        'adult_price' => [
            'label' => 'Adult Price',
            'rules' => 'trim|required|numeric',
            'errors' => [
                'required' => 'Please enter Adult Price'

            ],
        ],
        'visa_list_id' => [
            'label' => 'visa',
            'rules' => 'trim|required',
            'errors' => [
                'required' => 'Please select visa'

            ],
        ],
        'visa_country_id' => [
            'label' => 'Country',
            'rules' => 'trim|required',
            'errors' => [
                'required' => 'Please select Country.'

            ],
        ],
        'passport_require ' => [
            'label' => 'passport require ',
            'rules' => 'trim',
        ],


        'visa_detail' => [
            'label' => 'visa detail',
            'rules' => 'trim|required',
            'errors' => [
                'required' => 'Please Enter Visa Detail'

            ],
        ],
        'plan_disclaimer' => [
            'label' => 'Plal Disclaimer',
            'rules' => 'trim|required',
            'errors' => [
                'required' => 'Please Enter Plal Disclaimer'

            ],
        ],

        'visa_document' => [
            'label' => 'visa document',
            'rules' => 'trim|required',
            'errors' => [
                'required' => 'Please enter visa document'

            ],
        ],

        'processing_time' => [
            'label' => 'Processing Time Quode',
            'rules' => 'trim|required|max_length[100]',
            'errors' => [
                'required' => 'Please enter Processing Time Quode'

            ],
        ],
        'processing_time_D/W' => [
            'label' => 'Processing Time Days/Weeks',
            'rules' => 'trim|required|max_length[100]',
            'errors' => [
                'required' => 'Please select Processing Time Days/Weeks'

            ],
        ],
        'processing_time_value' => [
            'label' => 'Processing Time Value',
            'rules' => 'trim|required|max_length[100]',
            'errors' => [
                'required' => 'Please enter Processing Time Value'

            ],
        ],
        'status' => [
            'label' => ' Status',
            'rules' => 'trim|required',
            'errors' => [
                'required' => 'Please select  status'
            ],
        ],
        'stay_period' => [
            'label' => 'Stay Period',
            'rules' => 'trim|required',
            'errors' => [
                'required' => 'Please enter Stay Period'

            ],
        ],
        'validity' => [
            'label' => 'Validity',
            'rules' => 'trim|required',
            'errors' => [
                'required' => 'Please enter Validity'

            ],
        ],
        'e_visa' => [
            'label' => 'E-Visa ',
            'rules' => 'required',
            'errors' => [
                'required' => 'Please select E-Visa'

            ],
        ],
        'category' => [
            'label' => 'Category ',
            'rules' => 'required',
            'errors' => [
                'required' => 'Please select Category '

            ],
        ],
        'visa_schedule_time' => [
            'label' => 'Visa Schedule Time',
            'rules' => 'required|numeric',
            'errors' => [
                'required' => 'Please enter Visa Schedule Time',
                'numeric' => 'Visa Schedule Time must be a number',
            ],
        ],
        'company_schedule_time' => [
            'label' => 'Company Schedule Time',
            'rules' => 'required|numeric',
            'errors' => [
                'required' => 'Please enter Company Schedule Time',
                'numeric' => 'Company Schedule Time must be a number', 
            ],
        ],
        'inclusions.*' => [
            'label' => 'Inclusions',
            'rules' => 'trim|required',
            'errors' => [
                'required' => 'Please enter Inclusions'

            ],
        ],
        'important_information.*' => [
            'label' => 'Important Information',
            'rules' => 'trim|required',
            'errors' => [
                'required' => 'Please enter Important Information'

            ],
        ],

    ];

    public $visa_type = [
        'visa_title' => [
            'label' => 'title ',
            'rules' => 'trim|required|max_length[80]',
            'errors' => [
                'required' => 'Please enter title'

            ],
        ],

        'visa_title_slug' => [
            'label' => 'slug',
            'rules' => 'trim|required|max_length[90]',
            'errors' => [
                'required' => 'Please enter slug'

            ],
        ],
        'image' => [
            'label' => 'Image',
            'rules' => 'uploaded[image]|max_size[image,1024]|mime_in[image,image/jpg,image/jpeg,image/png]',
            'errors' => [
                'max_size' => 'Image size should not be more than 1024kb',
                'mime_in' => 'Please upload valid image. allowed image types are jpg, jpeg, png'
            ],

        ],
    ];

    public $status = [

        'status' => [
            'label' => ' Status',
            'rules' => 'trim|required',
            'errors' => [
                'required' => 'Please select  status'
            ],
        ],
    ];

    public $document_type = [
        'document_name' => [
            'label' => 'Document Name ',
            'rules' => 'trim|required|max_length[80]',
            'errors' => [
                'required' => 'Please enter Document Name'

            ],
        ],
    ];
    public $search_validation = [
        'country_id' => [
            'label' => 'country',
            'rules' => 'trim|required',
            'errors' => [
                'required' => 'Please select  country'
            ],
        ],
        'visa_type_id' => [
            'label' => 'visa type',
            'rules' => 'trim|required',
            'errors' => [
                'required' => 'Please select visa type'
            ],
        ],

        'travellers' => [
            'label' => 'travellers',
            'rules' => 'trim|required|numeric',
            'errors' => [
                'required' => 'Please select travellers'
            ],
        ],

        'travel_date' => [
            'label' => 'travel date',
            'rules' => 'trim|required',
            'errors' => [
                'required' => 'Please select travel date'
            ],
        ],
    ];

    public $EmailTicketValidation = [
        "email" => [
            'label' => 'email',
            'rules' => 'trim|required|valid_email',
            'errors' => [
                'required' => 'Please enter  email',
                'valid_email' => 'Please enter valid email'
            ],
        ]
    ];

    public $raiseAmendment = [
        "amendment_type" => ['rules' => 'trim|required|in_list[cancellation,full_refund,cancellation_quotation,correction]', 'errors' => [
            'required' => 'Please select Amendment Type'
        ],],
        "remark" => ['rules' => 'required', 'errors' => [
            'required' => 'Please enter Remark'
        ]],
        "booking_ref_number" => ['rules' => 'required'],
    ];



    public $visa_country_validation = [
        'country_name' => [
            'label' => 'country name',
            'rules' => 'trim|required',
            'errors' => [
                'required' => 'Please select country name'

            ],
        ],

        'processing_time' => [
            'label' => 'processing time',
            'rules' => 'trim|required|max_length[20]',
            'errors' => [
                'required' => 'Please enter processing time'

            ],
        ],

        'starting_price' => [
            'label' => 'starting price',
            'rules' => 'trim|required|numeric',
            'errors' => [
                'required' => 'Please enter starting price'

            ],
        ],


        'status' => [
            'label' => ' Status',
            'rules' => 'trim|required',
            'errors' => [
                'required' => 'Please select  status'
            ],
        ],

        'country_image' => [
            'label' => 'Image',
            'rules' => 'uploaded[country_image]|max_size[country_image,1024]|mime_in[country_image,image/jpg,image/jpeg,image/png]',
            'errors' => [
                'max_size' => 'Image size should not be more than 1024kb',
                'mime_in' => 'Please upload valid image. allowed image types are jpg, jpeg, png'
            ],

        ],
    ];


    public $visa_markup_validation = [

        'agent_class.*' => [
            'label' => 'agent class ',
            'rules' => 'trim|required',
            'errors' => [
                'required' => 'Please select agent class'

            ],
        ],
        'markup_for' => [
            'label' => 'markup for ',
            'rules' => 'trim|required',
            'errors' => [
                'required' => 'Please select markup for'

            ],
        ],
        'visa_country_id' => [
            'label' => 'country ',
            'rules' => 'trim|required',
            'errors' => [
                'required' => 'Please select country'

            ],
        ],

        'visa_type_id.*' => [
            'label' => 'visa type id',
            'rules' => 'trim|required',
            'errors' => [
                'required' => 'Please select visa type'

            ],
        ],
        'value' => [
            'label' => 'value',
            'rules' => 'trim|required|numeric',
            'errors' => [
                'required' => 'Please enter value'
            ],
        ],

        'max_limit' => [
            'label' => 'max limit',
            'rules' => 'trim|permit_empty|numeric',
        ],

        'display_markup' => [
            'label' => ' display markup',
            'rules' => 'trim|required',
            'errors' => [
                'required' => 'Please select  display markup'
            ],
        ],

        'markup_type' => [
            'label' => 'markup type',
            'rules' => 'trim|required',
            'errors' => [
                'required' => 'Please select markup type'
            ],
        ],

        'status' => [
            'label' => ' Status',
            'rules' => 'trim|required',
            'errors' => [
                'required' => 'Please select  status'
            ],
        ],
    ];

    public function voucher_update_validation($data)
    {
        $booking_validation["confirmation_number"] = [
            'label' => 'Confirmation Number',
            'rules' => 'trim|required',
            'errors' => [
                'required' => 'Please enter confirmation number'
            ],
        ];
        $booking_validation["supplier"] = [
            'label' => 'Supplier',
            'rules' => 'trim|required',
            'errors' => [
                'required' => 'Please enter Supplier'
            ],
        ];
        $booking_validation["booking_status"] = [
            'label' => 'Booking Status',
            'rules' => 'trim|required',
            'errors' => [
                'required' => 'Please select booking status',
            ],
        ];
        return $booking_validation;
    }

    public $visa_discount_validation = [

        'visa_country_id' => [
            'label' => 'country ',
            'rules' => 'trim|required',
            'errors' => [
                'required' => 'Please select country'

            ],
        ],
        'agent_class.*' => [
            'label' => 'agent class ',
            'rules' => 'trim|required',
            'errors' => [
                'required' => 'Please select agent class'

            ],
        ],
        'discount_for' => [
            'label' => 'discount for ',
            'rules' => 'trim|required',
            'errors' => [
                'required' => 'Please select discount for'

            ],
        ],
        'visa_type_id.*' => [
            'label' => 'visa type id',
            'rules' => 'trim|required',
            'errors' => [
                'required' => 'Please select visa type'

            ],
        ],

        'value' => [
            'label' => 'value',
            'rules' => 'trim|required|numeric',
            'errors' => [
                'required' => 'Please enter value'
            ],
        ],

        'max_limit' => [
            'label' => 'max limit',
            'rules' => 'trim|permit_empty|numeric',
        ],

        'discount_type' => [
            'label' => 'discount type',
            'rules' => 'trim|required',
            'errors' => [
                'required' => 'Please select discount type'
            ],
        ],

        'status' => [
            'label' => ' Status',
            'rules' => 'trim|required',
            'errors' => [
                'required' => 'Please select  status'
            ],
        ],
    ];

    public $faq_validation = [

        'title' => [
            'label' => 'title',
            'rules' => 'trim|required|max_length[150]',
            'errors' => [
                'required' => 'Please enter faq  Title'

            ],
        ],
        'status' => [
            'label' => 'Status',
            'rules' => 'trim|required',
            'errors' => [
                'required' => 'Please select status'
            ],
        ],
    ];
}

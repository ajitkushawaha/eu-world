<?php

namespace Modules\Coupon\Config;

class Validation
{

    public $flight_discount_markup_validation = [

        'airline_code' => [
            'label' => 'airline code',
            'rules' => 'trim|required|max_length[50]',
            'errors' => [
                'required' => 'Please enter airline code'
            ],
        ],

        'from_airport_code' => [
            'label' => 'from airport',
            'rules' => 'trim|required|max_length[250]',
            'errors' => [
                'required' => 'Please enter from airport'
            ],
        ],

        'to_airport_code' => [
            'label' => 'to airport',
            'rules' => 'trim|required|max_length[250]',
            'errors' => [
                'required' => 'Please enter to airport'
            ],
        ],

        'max_limit' => [
            'label' => 'Max Limit',
            'rules' => 'trim|numeric',
            'errors' => [
                'numeric' => 'Please enter numeric value'
            ],
        ],

        'is_domestic.*' => [
            'label' => 'flight type',
            'rules' => 'trim|required|exact_length[1]',
            'errors' => [
                'required' => 'Please select flight type'
            ],
        ],

        'journey_type.*' => [
            'label' => 'journey type',
            'rules' => 'trim|required|max_length[20]',
            'errors' => [
                'required' => 'Please select journey type'
            ],
        ],

        'travel_date_from' => [
            'label' => 'from date',
            'rules' => 'trim|required|max_length[25]',
            'errors' => [
                'required' => 'Please select from date'
            ],
        ],

        'travel_date_to' => [
            'label' => 'to date',
            'rules' => 'trim|required|max_length[25]',
            'errors' => [
                'required' => 'Please select to date'
            ],
        ],

        'valid_from' => [
            'label' => 'Valid From',
            'rules' => 'trim|required|max_length[25]',
            'errors' => [
                'required' => 'Please select from date'
            ],
        ],

        'valid_to' => [
            'label' => 'Valid To',
            'rules' => 'trim|required|max_length[25]',
            'errors' => [
                'required' => 'Please select to date'
            ],
        ],



        'cabin_class.*' => [
            'label' => 'cabin class',
            'rules' => 'trim|required|max_length[20]',
            'errors' => [
                'required' => 'Please select cabin class'
            ],
        ],


        'coupon_type' => [
            'label' => 'Coupon Type',
            'rules' => 'trim|required',
            'errors' => [
                'required' => 'Please select value'
            ],
        ],

        'value' => [
            'label' => 'value',
            'rules' => 'trim|required|numeric',
            'errors' => [
                'required' => 'Please enter value'
            ],
        ],

        'code' => [
            'label' => 'code',
            'rules' => 'trim|required',
            'errors' => [
                'required' => 'Please enter Code'
            ],
        ],

        'use_limit' => [
            'label' => 'Use Limit',
            'rules' => 'trim|required|numeric',
            'errors' => [
                'required' => 'Please enter value'
            ],
        ],

        'status' => [
            'label' => 'status',
            'rules' => 'trim|required',
            'errors' => [
                'required' => 'Please select status'
            ],
        ],
        'coupon_visible' => [
            'label' => 'Coupon Visible',
            'rules' => 'trim|required',
            'errors' => [
                'required' => 'Please select value'
            ],
        ],
    ];

    public $status = [

        'status' => [
            'label' => 'status',
            'rules' => 'trim|required',
            'errors' => [
                'required' => 'Please select status'
            ],
        ],
    ];

    public $hotel_coupon_validation = [

        'max_limit' => [
            'label' => 'Max Limit',
            'rules' => 'trim|numeric',
            'errors' => [
                'numeric' => 'Please enter numeric value'
            ],
        ],


        'region_type.*' => [
            'label' => 'Region type',
            'rules' => 'trim|required|max_length[20]',
            'errors' => [
                'required' => 'Please select Region type'
            ],
        ],

        'star_rating.*' => [
            'label' => 'Star Rating',
            'rules' => 'trim|required|max_length[20]',
            'errors' => [
                'required' => 'Please select Star rating'
            ],
        ],

        'check_in_date_from' => [
            'label' => 'check in date',
            'rules' => 'trim|required|max_length[25]',
            'errors' => [
                'required' => 'Please select from date'
            ],
        ],

        'check_out_date_to' => [
            'label' => 'check out date',
            'rules' => 'trim|required|max_length[25]',
            'errors' => [
                'required' => 'Please select to date'
            ],
        ],

        'code' => [
            'label' => 'code',
            'rules' => 'trim|required',
            'errors' => [
                'required' => 'Please enter Code'
            ],
        ],

        'valid_from' => [
            'label' => 'Valid From',
            'rules' => 'trim|required|max_length[25]',
            'errors' => [
                'required' => 'Please select from date'
            ],
        ],

        'valid_to' => [
            'label' => 'Valid To',
            'rules' => 'trim|required|max_length[25]',
            'errors' => [
                'required' => 'Please select to date'
            ],
        ],


        'coupon_type' => [
            'label' => 'Coupon Type',
            'rules' => 'trim|required',
            'errors' => [
                'required' => 'Please select value'
            ],
        ],

        'value' => [
            'label' => 'value',
            'rules' => 'trim|required|numeric',
            'errors' => [
                'required' => 'Please enter value'
            ],
        ],

        'use_limit' => [
            'label' => 'Use Limit',
            'rules' => 'trim|required|numeric',
            'errors' => [
                'required' => 'Please enter value'
            ],
        ],

        'status' => [
            'label' => 'status',
            'rules' => 'trim|required',
            'errors' => [
                'required' => 'Please select status'
            ],
        ],
        'coupon_visible' => [
            'label' => 'Coupon Visible',
            'rules' => 'trim|required',
            'errors' => [
                'required' => 'Please select value'
            ],
        ],
    ];

    public $bus_coupon_validation = [

        'max_limit' => [
            'label' => 'Max Limit',
            'rules' => 'trim|numeric',
            'errors' => [
                'numeric' => 'Please enter numeric value'
            ],
        ],

        'travel_date_from' => [
            'label' => 'travel date from',
            'rules' => 'trim|required|max_length[25]',
            'errors' => [
                'required' => 'Please select from date'
            ],
        ],

        'travel_date_to' => [
            'label' => 'travel date to',
            'rules' => 'trim|required|max_length[25]',
            'errors' => [
                'required' => 'Please select to date'
            ],
        ],

        'valid_from' => [
            'label' => 'Valid From',
            'rules' => 'trim|required|max_length[25]',
            'errors' => [
                'required' => 'Please select from date'
            ],
        ],

        'valid_to' => [
            'label' => 'Valid To',
            'rules' => 'trim|required|max_length[25]',
            'errors' => [
                'required' => 'Please select to date'
            ],
        ],


        'coupon_type' => [
            'label' => 'Coupon Type',
            'rules' => 'trim|required',
            'errors' => [
                'required' => 'Please select value'
            ],
        ],

        'code' => [
            'label' => 'code',
            'rules' => 'trim|required',
            'errors' => [
                'required' => 'Please enter Code'
            ],
        ],

        'value' => [
            'label' => 'value',
            'rules' => 'trim|required|numeric',
            'errors' => [
                'required' => 'Please enter value'
            ],
        ],

        'use_limit' => [
            'label' => 'Use Limit',
            'rules' => 'trim|required|numeric',
            'errors' => [
                'required' => 'Please enter value'
            ],
        ],

        'status' => [
            'label' => 'status',
            'rules' => 'trim|required',
            'errors' => [
                'required' => 'Please select status'
            ],
        ],
        'coupon_visible' => [
            'label' => 'Coupon Visible',
            'rules' => 'trim|required',
            'errors' => [
                'required' => 'Please select value'
            ],
        ],
    ];


    public $holiday_coupon_validation = [


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

        'status' => [
            'label' => ' Status',
            'rules' => 'trim|required',
            'errors' => [
                'required' => 'Please select  status'
            ],
        ],

        'theme_name.*' => [
            'label' => 'theme',
            'rules' => 'trim|required',
            'errors' => [
                'required' => 'Please select  theme'
            ],
        ],

        'destination_name.*' => [
            'label' => 'destination',
            'rules' => 'trim|required',
            'errors' => [
                'required' => 'Please select  destination'
            ],
        ],
        'holiday_package.*' => [
            'label' => 'holiday package',
            'rules' => 'trim|required',
            'errors' => [
                'required' => 'Please select  holiday package'
            ],
        ],
        'code' => [
            'label' => 'code',
            'rules' => 'trim|required',
            'errors' => [
                'required' => 'Please select  code'
            ],
        ],
        'use_limit' => [
            'label' => 'Use limit',
            'rules' => 'trim|required',
            'errors' => [
                'required' => 'Please select  Use limit'
            ],
        ],
        'coupon_desc' => [
            'label' => 'Coupon Desc',
            'rules' => 'trim|required',
            'errors' => [
                'required' => 'Please select  Coupon Desc'
            ],
        ],
        'coupon_visible' => [
            'label' => 'Coupon Visible',
            'rules' => 'trim|required',
            'errors' => [
                'required' => 'Please select  Coupon Visible'
            ],
        ],
    ];



    public $tourguide_coupon_validation = [


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

        'status' => [
            'label' => ' Status',
            'rules' => 'trim|required',
            'errors' => [
                'required' => 'Please select  status'
            ],
        ],


        'code' => [
            'label' => 'code',
            'rules' => 'trim|required',
            'errors' => [
                'required' => 'Please select  code'
            ],
        ],
        'use_limit' => [
            'label' => 'Use limit',
            'rules' => 'trim|required',
            'errors' => [
                'required' => 'Please select  Use limit'
            ],
        ],
        'coupon_desc' => [
            'label' => 'Coupon Desc',
            'rules' => 'trim|required',
            'errors' => [
                'required' => 'Please select  Coupon Desc'
            ],
        ],
        'coupon_visible' => [
            'label' => 'Coupon Visible',
            'rules' => 'trim|required',
            'errors' => [
                'required' => 'Please select  Coupon Visible'
            ],
        ],
    ];




    public $activities_coupon_validation = [


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

        'status' => [
            'label' => ' Status',
            'rules' => 'trim|required',
            'errors' => [
                'required' => 'Please select  status'
            ],
        ],


        'code' => [
            'label' => 'code',
            'rules' => 'trim|required',
            'errors' => [
                'required' => 'Please select  code'
            ],
        ],
        'use_limit' => [
            'label' => 'Use limit',
            'rules' => 'trim|required',
            'errors' => [
                'required' => 'Please select  Use limit'
            ],
        ],
        'coupon_desc' => [
            'label' => 'Coupon Desc',
            'rules' => 'trim|required',
            'errors' => [
                'required' => 'Please select  Coupon Desc'
            ],
        ],
        'coupon_visible' => [
            'label' => 'Coupon Visible',
            'rules' => 'trim|required',
            'errors' => [
                'required' => 'Please select  Coupon Visible'
            ],
        ],
    ];



    public $visa_coupon_validation = [


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

        'status' => [
            'label' => ' Status',
            'rules' => 'trim|required',
            'errors' => [
                'required' => 'Please select  status'
            ],
        ],


        'code' => [
            'label' => 'code',
            'rules' => 'trim|required',
            'errors' => [
                'required' => 'Please select  code'
            ],
        ],
        'use_limit' => [
            'label' => 'Use limit',
            'rules' => 'trim|required',
            'errors' => [
                'required' => 'Please select  Use limit'
            ],
        ],
        'coupon_desc' => [
            'label' => 'Coupon Desc',
            'rules' => 'trim|required',
            'errors' => [
                'required' => 'Please select  Coupon Desc'
            ],
        ],
        'coupon_visible' => [
            'label' => 'Coupon Visible',
            'rules' => 'trim|required',
            'errors' => [
                'required' => 'Please select  Coupon Visible'
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

    ];


    public $car_coupon_validation = [

        'max_limit' => [
            'label' => 'Max Limit',
            'rules' => 'trim|numeric',
            'errors' => [
                'numeric' => 'Please enter numeric value'
            ],
        ],

        'travel_date_from' => [
            'label' => 'travel date from',
            'rules' => 'trim|required|max_length[25]',
            'errors' => [
                'required' => 'Please select from date'
            ],
        ],

        'travel_date_to' => [
            'label' => 'travel date to',
            'rules' => 'trim|required|max_length[25]',
            'errors' => [
                'required' => 'Please select to date'
            ],
        ],

        'valid_from' => [
            'label' => 'Valid From',
            'rules' => 'trim|required|max_length[25]',
            'errors' => [
                'required' => 'Please select from date'
            ],
        ],

        'valid_to' => [
            'label' => 'Valid To',
            'rules' => 'trim|required|max_length[25]',
            'errors' => [
                'required' => 'Please select to date'
            ],
        ],


        'coupon_type' => [
            'label' => 'Coupon Type',
            'rules' => 'trim|required',
            'errors' => [
                'required' => 'Please select value'
            ],
        ],

        'code' => [
            'label' => 'code',
            'rules' => 'trim|required',
            'errors' => [
                'required' => 'Please enter Code'
            ],
        ],

        'value' => [
            'label' => 'value',
            'rules' => 'trim|required|numeric',
            'errors' => [
                'required' => 'Please enter value'
            ],
        ],

        'use_limit' => [
            'label' => 'Use Limit',
            'rules' => 'trim|required|numeric',
            'errors' => [
                'required' => 'Please enter value'
            ],
        ],

        'status' => [
            'label' => 'status',
            'rules' => 'trim|required',
            'errors' => [
                'required' => 'Please select status'
            ],
        ],
        'coupon_visible' => [
            'label' => 'Coupon Visible',
            'rules' => 'trim|required',
            'errors' => [
                'required' => 'Please select value'
            ],
        ],
    ];



    public $cruise_coupon_validation = [

        'departure_port_id' => [
            'label' => 'Cruise Departure Port',
            'rules' => 'trim|required',
            'errors' => [
                'required' => 'Please select Cruise Departure Port'
            ],
        ],

        'cruise_line_id' => [
            'label' => 'Cruise Line',
            'rules' => 'trim|required',
            'errors' => [
                'required' => 'Please select Cruise Line'
            ],
        ],

        'cruise_ship_id' => [
            'label' => 'Cruise Ship',
            'rules' => 'trim|required',
            'errors' => [
                'required' => 'Please select Cruise Ship'
            ],
        ],

        'cabin_id' => [
            'label' => 'Cruise Cabin',
            'rules' => 'trim|required',
            'errors' => [
                'required' => 'Please select Cruise Cabin'
            ],
        ],

        'travel_from' => [
            'label' => 'travel date from',
            'rules' => 'trim|required|max_length[25]',
            'errors' => [
                'required' => 'Please select from date'
            ],
        ],

        'max_limit' => [
            'label' => 'Max Limit',
            'rules' => 'trim|numeric',
            'errors' => [
                'numeric' => 'Please enter numeric value'
            ],
        ],

        'travel_from' => [
            'label' => 'travel date from',
            'rules' => 'trim|required|max_length[25]',
            'errors' => [
                'required' => 'Please select from date'
            ],
        ],

        'travel_date' => [
            'label' => 'travel date to',
            'rules' => 'trim|required|max_length[25]',
            'errors' => [
                'required' => 'Please select to date'
            ],
        ],

        'valid_from' => [
            'label' => 'Valid From',
            'rules' => 'trim|required|max_length[25]',
            'errors' => [
                'required' => 'Please select from date'
            ],
        ],

        'valid_to' => [
            'label' => 'Valid To',
            'rules' => 'trim|required|max_length[25]',
            'errors' => [
                'required' => 'Please select to date'
            ],
        ],


        'coupon_type' => [
            'label' => 'Coupon Type',
            'rules' => 'trim|required',
            'errors' => [
                'required' => 'Please select value'
            ],
        ],

        'code' => [
            'label' => 'code',
            'rules' => 'trim|required',
            'errors' => [
                'required' => 'Please enter Code'
            ],
        ],

        'value' => [
            'label' => 'value',
            'rules' => 'trim|required|numeric',
            'errors' => [
                'required' => 'Please enter value'
            ],
        ],

        'use_limit' => [
            'label' => 'Use Limit',
            'rules' => 'trim|required|numeric',
            'errors' => [
                'required' => 'Please enter value'
            ],
        ],

        'status' => [
            'label' => 'status',
            'rules' => 'trim|required',
            'errors' => [
                'required' => 'Please select status'
            ],
        ],
        'coupon_visible' => [
            'label' => 'Coupon Visible',
            'rules' => 'trim|required',
            'errors' => [
                'required' => 'Please select value'
            ],
        ],
    ];
}

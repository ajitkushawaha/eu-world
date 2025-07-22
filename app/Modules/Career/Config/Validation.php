<?php
namespace Modules\Career\Config;


class Validation
{
    public $career_validation = [
        'job_title' => [
            'label' => 'job title',
            'rules' => 'trim|required',
            'errors' => [
                'required' => 'Please enter  Job Title'

            ],
        ],

        'category_id' => [
            'label' => 'category Id',
            'rules' => 'trim|required',
            'errors' => [
                'required' => 'Please enter Category'

            ],
        ],


        'slug_url' => [
            'label' => 'slug url',
            'rules' => 'trim|required',
            'errors' => [
                'required' => 'Please enter slug url'

            ],
        ],


        'status' => [
            'label' => 'status',
            'rules' => 'trim|required',
            'errors' => [
                'required' => 'Please select  status'

            ],
        ],

        'short_description' => [
            'label' => 'short description',
            'rules' => 'trim|required',
            'errors' => [
                'required' => 'Please enter short description'
            ],
        ],


    ];
    public $career_categories_validation = [

        'job_category' => [
            'label' => 'job Category',
            'rules' => 'trim|required',
            'errors' => [
                'required' => 'Please enter  Job Category'

            ],
        ],

        'status' => [
            'label' => 'status',
            'rules' => 'trim|required',
            'errors' => [
                'required' => 'Please select  status'

            ],
        ],

    ];

    public $career_status = [

        'status' => [
            'label' => 'Career Status',
            'rules' => 'trim|required',
            'errors' => [
                'required' => 'Please select career status'
            ],
        ],
    ];

}


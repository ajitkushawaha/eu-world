<?php

namespace Modules\Pages\Config;

class Validation
{
    public $pages_validation = [
        'title' => [
            'label' => 'title',
            'rules' => 'trim|required|max_length[150]',
            'errors' => [
                'required' => 'Please enter page  title'

            ],
        ],
        'slug_url' => [
            'label' => 'slug',
            'rules' => 'trim|required|max_length[150]',
            'errors' => [
                'required' => 'Please enter page slug'

            ],
        ],
        'content' => [
            'label' => 'content',
            'rules' => 'trim|required',
            'errors' => [
                'required' => 'Please enter page content'
            ],
        ],
        'status' => [
            'label' => 'Status',
            'rules' => 'trim|required',
            'errors' => [
                'required' => 'Please select status'
            ],
        ],
        'meta_robots' => [
            'label' => 'Meta Robots',
            'rules' => 'trim|required|max_length[60]',
            'errors' => [
                'required' => 'Please select meta robots'
            ],
        ],
        'meta_title' => [
            'label' => 'Meta Title',
            'rules' => 'trim|required|max_length[60]',
            'errors' => [
                'required' => 'Please enter meta title'
            ],
        ],
        'meta_keyword' => [
            'label' => 'Meta Keyword',
            'rules' => 'trim|required|max_length[160]',
            'errors' => [
                'required' => 'Please enter meta keyword'
            ],
        ],
        'meta_description' => [
            'label' => 'Meta Description',
            'rules' => 'trim|required|max_length[160]',
            'errors' => [
                'required' => 'Please enter meta description'
            ],
        ],
        'banner_image' => [
            'label' => 'Banner Image',
            'rules' => 'uploaded[banner_image]|max_size[banner_image,1024]|mime_in[banner_image,image/jpg,image/jpeg,image/png]',
            'errors' => [
                'max_size' => 'Image size should not be more than 1024kb',
                'mime_in' => 'Please upload valid image. allowed image types are jpg, jpeg, png'
            ],

        ]
    ];


    public $page_status = [
        'status' => [
            'label' => 'Status',
            'rules' => 'trim|required',
            'errors' => [
                'required' => 'Please select status'
            ],
        ]
    ];

    public function menu_name_validation($data)
    {
        $validation = [];
        foreach ($data['menu_name'] as $key => $request) {
            $validation["menu_name.$key"] = [
                'label' => 'Label',
                'rules' => 'trim|max_length[80]',
                'errors' => [
                    'required' => 'Please enter Label'
                ],
            ];
        }
        return $validation;
    }
}

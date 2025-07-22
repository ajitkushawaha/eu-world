<?php
namespace Modules\ConvenienceFee\Config;


class Validation
{
    public $convenience_fee_validation = [
        'convenience_fee_for' => [
            'label' => 'Convenience Fee For',
            'rules' => 'trim|required|in_list[B2B,B2C]',
        ],

        'payment_gateway' => [
            'label' => 'payment gateway',
            'rules' => 'trim|required',
            'errors' => [
                'required' => 'Please enter payment gateway'
            ],
        ],

        'service.*' => [
            'label' => 'service',
            'rules' => 'trim|required',
            'errors' => [
                'required' => 'Please enter service'

            ],
        ],

        'agent_class_id.*' => [
            'label' => 'Agent Class',
            'rules' => 'trim',
            'errors' => [
                'required' => 'Please select Agent Class'

            ],
        ],

        'min_amount' => [
            'label' => 'value',
            'rules' => 'trim|required|numeric',
            'errors' => [
                'required' => 'Please enter value'
            ],
        ],

        'max_amount' => [
            'label' => 'value',
            'rules' => 'trim|required|numeric',
            'errors' => [
                'required' => 'Please enter value'
            ],
        ],

        /* 'credit_card_value' => [
            'label' => 'credit card type',
            'rules' => 'trim|required|numeric',
            'errors' => [
                'required' => 'Please enter credit card value'
            ],
        ],

        'credit_card_type' => [
            'label' => 'credit card type',
            'rules' => 'trim|required',
            'errors' => [
                'required' => 'Please select credit card type'
            ],
        ],

        'rupay_credit_card_value' => [
            'label' => 'value',
            'rules' => 'trim|required|numeric',
            'errors' => [
                'required' => 'Please enter value'
            ],
        ],
      
        'rupay_credit_card_type' => [
            'label' => 'type',
            'rules' => 'trim|required',
            'errors' => [
                'required' => 'Please enter type'
            ],
        ],

        'visa_credit_card_value' => [
            'label' => 'value',
            'rules' => 'trim|required|numeric',
            'errors' => [
                'required' => 'Please enter value'
            ],
        ],

        'visa_credit_card_type' => [
            'label' => 'type',
            'rules' => 'trim|required',
            'errors' => [
                'required' => 'Please enter type'
            ],
        ],

        'mastercard_credit_card_value' => [
            'label' => 'value',
            'rules' => 'trim|required|numeric',
            'errors' => [
                'required' => 'Please enter value'
            ],
        ],

        'mastercard_credit_card_type' => [
            'label' => 'type',
            'rules' => 'trim|required',
            'errors' => [
                'required' => 'Please enter type'
            ],
        ],

        'american_express_credit_card_value' => [
            'label' => 'value',
            'rules' => 'trim|required|numeric',
            'errors' => [
                'required' => 'Please enter value'
            ],
        ],

        'american_express_credit_card_type' => [
            'label' => 'type',
            'rules' => 'trim|required',
            'errors' => [
                'required' => 'Please enter type'
            ],
        ],
 
        'debit_card_value' => [
            'label' => 'debit card type',
            'rules' => 'trim|required|numeric',
            'errors' => [
                'required' => 'Please enter debit card value'
            ],
        ],

        'debit_card_type' => [
            'label' => 'type',
            'rules' => 'trim|required',
            'errors' => [
                'required' => 'Please select debit card type'
            ],
        ],

        'net_banking_value' => [
            'label' => 'value',
            'rules' => 'trim|required|numeric',
            'errors' => [
                'required' => 'Please enter value'
            ],
        ],

        'net_banking_type' => [
            'label' => 'type',
            'rules' => 'trim|required',
            'errors' => [
                'required' => 'Please enter type'
            ],
        ],

        'upi_value' => [
            'label' => 'value',
            'rules' => 'trim|required|numeric',
            'errors' => [
                'required' => 'Please enter value'
            ],
        ],

        'upi_type' => [
            'label' => 'type',
            'rules' => 'trim|required',
            'errors' => [
                'required' => 'Please enter type'
            ],
        ],

        'mobile_wallet_value' => [
            'label' => 'value',
            'rules' => 'trim|required|numeric',
            'errors' => [
                'required' => 'Please enter value'
            ],
        ],

        'mobile_wallet_type' => [
            'label' => 'type',
            'rules' => 'trim|required',
            'errors' => [
                'required' => 'Please enter type'
            ],
        ],

        'cash_card_value' => [
            'label' => 'value',
            'rules' => 'trim|required|numeric',
            'errors' => [
                'required' => 'Please enter value'
            ],
        ],

        'cash_card_type' => [
            'label' => 'type',
            'rules' => 'trim|required',
            'errors' => [
                'required' => 'Please enter type'
            ],
        ],
 */
    ];



}


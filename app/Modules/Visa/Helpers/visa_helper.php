<?php

/**
 * ----------------------------------------------
 *  API Request (Return Json Format)
 * ---------------------------------------------
 */
function visa_Request($data, $url, $service)
{
    $request_json = json_encode($data);

    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_ENCODING, 'gzip');
    curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 20);
    curl_setopt($ch, CURLOPT_TIMEOUT, 60);
    curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'POST');
    curl_setopt($ch, CURLOPT_POSTFIELDS, $request_json);
    curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/json', 'Username:' . credential['Username'] . '', 'Password:' . credential['Password'] . '', 'Btype:' . credential['Btype'] . ''));
    $response = curl_exec($ch);

    curl_close($ch);

    return json_decode($response, true);
}

function GetRequest($url)
{

    $ch = curl_init($url);
    curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "GET");
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_MAXREDIRS, 10);
    curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
    curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/json', 'Username:' . credential['Username'] . '', 'Password:' . credential['Password'] . '', 'Btype:' . credential['Btype'] . ''));
    $response = curl_exec($ch);
    curl_close($ch);
    return json_decode($response, true);
}



function RequestWithoutAuth($data, $url)
{
    $request_json = json_encode($data);
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_ENCODING, 'gzip');
    curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 20);
    curl_setopt($ch, CURLOPT_TIMEOUT, 60);
    curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'POST');
    curl_setopt($ch, CURLOPT_POSTFIELDS, $request_json);
    $response = curl_exec($ch);
    // pr($response);
    // die;
    curl_close($ch);
    return json_decode($response, true);
}


function get_visa_fare($markUpData, $PriceData, $notravellers)
{

    $Tax = 0;
    $ServiceCharges = 0;
    $markup_value = 0;
    $markUpData = current($markUpData);
    if ($markUpData) {
        if ($markUpData['markup_type'] == 'percent') {
            /*   markup apply for Embassy Fees */
            $markup_value = round_value(($PriceData['BasePrice'] * abs($markUpData['value'])) / 100);
            /*   markup check max limit  */
            if ($markUpData['max_limit']) {
                if (round_value($markUpData['max_limit']) <= $markup_value) {
                    $markup_value = round_value(abs($markUpData['max_limit'])) * $notravellers;
                }
            }
        } elseif ($markUpData['markup_type'] == 'fixed') {

            $markup_value = round_value($markUpData['value']) * $notravellers;
        }
    }
    $PriceData['WebPMarkUp'] = array(
        'value' => $markup_value,
        'DisplayFormat' => $markUpData['display_markup']
    );
    return $PriceData;
}

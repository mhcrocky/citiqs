<?php

if (!defined('BASEPATH')) exit('No direct script access allowed');


function getAccessToken($url, $post = FALSE)
{
    // print_r($post);
    $ch = curl_init($url);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
    if ($post) {
        curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($post));
    }
    $headers[] = ': ';
    $headers[] = 'Accept: */*';
    $headers[] = 'Content-Type: application/x-www-form-urlencoded';
    $headers[] = 'Authorization: Basic ' . base64_encode(VISMA_client_id . ':' . VISMA_secret);
    curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
    $response = curl_exec($ch);

    return json_decode($response);
}

function apiRequest($endpoint, $access_token, $refresh_token, $user_ID, $request_body)
{
    $ch = curl_init();

    curl_setopt($ch, CURLOPT_URL, $endpoint);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    curl_setopt($ch, CURLOPT_POSTFIELDS, $request_body);
    curl_setopt($ch, CURLOPT_POST, 1);

    $headers = array();
    $headers[] = 'Content-Type: application/json';
    $headers[] = 'Authorization: Bearer ' . $access_token;
    curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);

    $result = curl_exec($ch);

    if (is_string($result)) {
        $result = json_decode($result);
        if (isset($result->ErrorCode) && $result->ErrorCode == '4005') {
            $token  = refresh_token($endpoint, $refresh_token, $user_ID,"",'post');
            apiRequest($endpoint, $token->access_token, $token->refresh_token, $user_ID, $request_body);
            return ['success' => true, 'result' => $result];
        }
    }

    $info = curl_getinfo($ch);

    if ($info['http_code'] == 200 || $info['http_code'] == 201) {
        return ['success' => true, 'result' => $result];
    } else {
        if (is_string($result)) {
            $result = json_decode($result);
        }
        return ['success' => false, 'message' => $result];
    }
}


function apiRequestGet($endpoint, $access_token, $refresh_token, $user_ID, $id = "")
{

    $ch = curl_init();
    if (!empty($id)) {
        curl_setopt($ch, CURLOPT_URL, $endpoint . '/' . $id);
    } else {
        curl_setopt($ch, CURLOPT_URL, $endpoint);
    }
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'GET');

    // echo $access_token;
    $headers = array();
    $headers[] = 'Authorization: Bearer ' . $access_token;
    curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);

    $result = curl_exec($ch);
    $result = json_decode($result);
    // print_r($result);
    // exit;
    if (isset($result->ErrorCode) && $result->ErrorCode == '4005') {
        refresh_token($endpoint, $refresh_token, $user_ID, $id, 'get');
        return ['success' => false, 'message' => $result];
    }
    $info = curl_getinfo($ch);
    if ($info['http_code'] == 200) {
        return ['success' => true, 'result' => $result];
    }
}

function update_token($refresh_token, $user_ID)
{
    $data = array(
        'grant_type' => 'refresh_token',
        'refresh_token' => $refresh_token,
        // 'redirect_uri' => base_url() . 'vismaappConnect',
    );
    // echo get_api_endpoint('api_token_endpoint',VISMA_STATUS);
    $token = getAccessToken(get_api_endpoint('api_token_endpoint', VISMA_SANDBOX_DEBUG_MODE), $data);
    $CI = &get_instance();
    $CI->load->database();
    $CI->db->set('visma_access_token', $token->access_token);
    $CI->db->set('visma_refresh_token', $token->refresh_token);
    $CI->db->where('user_ID', $user_ID);
    if (!empty($token->access_token) && !empty($token->refresh_token)) {
        $CI->db->update('tbl_export_setting');
        return $token;
    } else {
        return false;
    }
}

function refresh_token($endpoint, $refresh_token, $user_ID, $id = "", $method = '')
{
    $data = array(
        'grant_type' => 'refresh_token',
        'refresh_token' => $refresh_token,
        // 'redirect_uri' => base_url() . 'vismaappConnect',
    );
    // echo get_api_endpoint('api_token_endpoint',VISMA_STATUS);
    $token = getAccessToken(get_api_endpoint('api_token_endpoint', VISMA_SANDBOX_DEBUG_MODE), $data);
    // print_r($token);
    // exit;
    $CI = &get_instance();
    $CI->load->database();
    $CI->db->set('visma_access_token', $token->access_token);
    $CI->db->set('visma_refresh_token', $token->refresh_token);
    $CI->db->where('user_ID', $user_ID);
    if (!empty($token->access_token) && !empty($token->refresh_token)) {
        $CI->db->update('tbl_export_setting');
    }
    if ($method == 'get') {
        // echo $endpoint;
        // echo $token->access_token;
        // echo $token->refresh_token;
        // echo $user_ID;
        // // echo $id;
        // exit;
        apiRequestGet($endpoint, $token->access_token, $token->refresh_token, $user_ID, $id);
    } else {
        return $token;
    }
}

function get_api_endpoint($url_key, $sandbox = 0, $api_name = "")
{
    // echo $sandbox;exit;
    $array = [];
    if ($sandbox == TRUE) {
        $array['api_endpoint'] = 'https://eaccountingapi-sandbox.test.vismaonline.com/' . $api_name;
        $array['api_token_endpoint'] = 'https://identity-sandbox.test.vismaonline.com/connect/token';
        $array['api_authorize_endpoint'] = 'https://identity-sandbox.test.vismaonline.com/connect/authorize';
    } else {
        $array['api_endpoint'] = 'https://eaccountingapi.vismaonline.com/' . $api_name;
        $array['api_token_endpoint'] = 'https://identity.vismaonline.com/connect/token';
        $array['api_authorize_endpoint'] = 'https://identity.vismaonline.com/connect/authorize';
    }
    return $array[$url_key];
}

function apiPut($endpoint, $access_token, $refresh_token, $user_ID, $request_body)
{
    $curl = curl_init();
    if (!empty($id)) {
        $endpoint = $endpoint . '/' . $id;
    }
    curl_setopt_array($curl, array(
        CURLOPT_URL => "$endpoint",
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_ENCODING => "",
        CURLOPT_MAXREDIRS => 10,
        CURLOPT_TIMEOUT => 0,
        CURLOPT_FOLLOWLOCATION => true,
        CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
        CURLOPT_CUSTOMREQUEST => "PUT",
        CURLOPT_POSTFIELDS => "$request_body",
        CURLOPT_HTTPHEADER => array(
            'Authorization: Bearer ' . $access_token,
            "Content-Type: application/json"
        ),
    ));

    $result = curl_exec($curl);
    if (is_string($result)) {
        $result = json_decode($result);
        if (isset($result->ErrorCode) && $result->ErrorCode == '4005') {
            $token  = refresh_token($endpoint, $refresh_token, $user_ID, $id = "", 'post');
            apiPut($endpoint, $token->access_token, $token->refresh_token, $user_ID, $request_body);
            return ['success' => true, 'result' => $result];
        }
    }

    $info = curl_getinfo($curl);

    if ($info['http_code'] == 200 || $info['http_code'] == 201) {
        return ['success' => true, 'result' => $result];
    } else {
        if (is_string($result)) {
            $result = json_decode($result);
        }
        return ['success' => false, 'message' => $result];
    }
    curl_close($curl);
}

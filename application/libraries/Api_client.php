<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Api_client {
    private $ci;
    private $api_url;

    public function __construct() {
        $this->ci =& get_instance();
        $this->api_url = 'http://localhost:8080/api/'; // Sesuaikan dengan URL API Anda
    }

    public function request($method, $endpoint, $data = null) {
        $url = $this->api_url . $endpoint;

        $curl = curl_init();

        switch ($method) {
            case "POST":
                curl_setopt($curl, CURLOPT_POST, 1);
                if ($data)
                    curl_setopt($curl, CURLOPT_POSTFIELDS, json_encode($data));
                break;
            case "PUT":
                curl_setopt($curl, CURLOPT_CUSTOMREQUEST, "PUT");
                if ($data)
                    curl_setopt($curl, CURLOPT_POSTFIELDS, json_encode($data));
                break;
            case "DELETE":
                curl_setopt($curl, CURLOPT_CUSTOMREQUEST, "DELETE");
                break;
            default:
                if ($data)
                    $url = sprintf("%s?%s", $url, http_build_query($data));
        }

        curl_setopt($curl, CURLOPT_URL, $url);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($curl, CURLOPT_HTTPHEADER, array(
            'Content-Type: application/json',
            'Accept: application/json'
        ));

        $result = curl_exec($curl);
        $httpCode = curl_getinfo($curl, CURLINFO_HTTP_CODE);
        
        log_message('debug', 'API Response: ' . $result);
        log_message('debug', 'HTTP Code: ' . $httpCode);
        
        if ($result === false) {
            $error = curl_error($curl);
            curl_close($curl);
            log_message('error', 'cURL Error: ' . $error);
            throw new Exception("cURL Error: " . $error);
        }
        
        curl_close($curl);
    
        if ($httpCode >= 400) {
            log_message('error', 'HTTP Error: ' . $httpCode . ' - Response: ' . $result);
            throw new Exception("HTTP Error: " . $httpCode);
        }

        return json_decode($result);
    }
}
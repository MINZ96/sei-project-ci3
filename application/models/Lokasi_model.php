<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Lokasi_model extends CI_Model {

    public function __construct() {
        parent::__construct();
        $this->load->library('api_client');
    }

    public function get_all_lokasi() {
        return $this->api_client->request('GET', 'lokasi');
    }

    public function create_lokasi($data) {
        return $this->api_client->request('POST', 'lokasi', $data);
    }

    public function update_lokasi($id, $data) {
        return $this->api_client->request('PUT', 'lokasi/' . $id, $data);
    }

    public function delete_lokasi($id) {
        return $this->api_client->request('DELETE', 'lokasi/' . $id);
    }

    public function get_lokasi($id) {
        return $this->api_client->request('GET', 'lokasi/' . $id);
    }
}
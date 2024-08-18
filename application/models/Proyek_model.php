<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Proyek_model extends CI_Model {

    public function __construct() {
        parent::__construct();
        $this->load->library('api_client');
    }

    public function get_all_proyek() {
        return $this->api_client->request('GET', 'proyek');
    }

    public function create_proyek($data) {
        return $this->api_client->request('POST', 'proyek', $data);
    }

    public function update_proyek($id, $data) {
        log_message('debug', 'Sending update data to API: ' . print_r($data, true));
        $response = $this->api_client->request('PUT', "proyek/{$id}", $data);
        log_message('debug', 'API Response: ' . print_r($response, true));
        if ($response === false || (isset($response->error) && $response->error)) {
            log_message('error', 'API Error: ' . print_r($response, true));
            return false;
        }
        return $response;
    }

    public function delete_proyek($id) {
        return $this->api_client->request('DELETE', 'proyek/' . $id);
    }

    // public function get_proyek($id) {
    //     return $this->api_client->request('GET', 'proyek/' . $id);
    // }
    public function get_proyek($id) {
        $response = $this->api_client->request('GET', 'proyek/' . $id);
        log_message('debug', 'API Response for proyek/' . $id . ': ' . print_r($response, true));
        if ($response && isset($response->id)) {
            // Pastikan semua properti yang diperlukan ada
            $proyek = new stdClass();
            $proyek->id = $response->id;
            $proyek->nama_proyek = $response->namaProyek;
            $proyek->client = $response->client;
            $proyek->tgl_mulai = $response->tglMulai;
            $proyek->tgl_selesai = $response->tglSelesai;
            $proyek->pimpinan_proyek = $response->pimpinanProyek;
            $proyek->keterangan = $response->keterangan;
            $proyek->lokasi = isset($response->lokasi) ? $response->lokasi : [];
            return $proyek;
        }
        return null;
    }

    // public function add_lokasi_to_proyek($proyek_id, $lokasi_id) {
    //     return $this->api_client->request('POST', 'proyek/' . $proyek_id . '/lokasi/' . $lokasi_id);
    // }
    public function add_lokasi_to_proyek($proyek_id, $lokasi_id) {
        $response = $this->api_client->request('POST', "proyek/{$proyek_id}/lokasi/{$lokasi_id}");
        if ($response === false || (isset($response->error) && $response->error)) {
            log_message('error', 'API Error: ' . print_r($response, true));
            return false;
        }
        return $response;
    }

    public function delete_lokasi_from_proyek($proyek_id, $lokasi_id) {
        $response = $this->api_client->request('DELETE', "proyek/{$proyek_id}/lokasi/{$lokasi_id}");
        if ($response === false || (isset($response->error) && $response->error)) {
            log_message('error', 'API Error: ' . print_r($response, true));
            return false;
        }
        return $response;
    }
}
<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Dashboard extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->model(['Lokasi_model', 'Proyek_model']);
        $this->load->library('form_validation');
        $this->load->helper('my_form');
        
    }

    public function index() {
        $data['proyek_list'] = $this->Proyek_model->get_all_proyek();
        $data['lokasi_list'] = $this->Lokasi_model->get_all_lokasi();
        $this->load->view('dashboard', $data);
    }

    public function add_lokasi() {
        $this->form_validation->set_rules('nama_lokasi', 'Nama Lokasi', 'required|trim');
        $this->form_validation->set_rules('negara', 'Negara', 'required|trim');
        $this->form_validation->set_rules('provinsi', 'Provinsi', 'required|trim');
        $this->form_validation->set_rules('kota', 'Kota', 'required|trim');

        if ($this->form_validation->run() == FALSE) {
            $this->load->view('add_lokasi');
        } else {
            $data = array(
                'namaLokasi' => $this->input->post('nama_lokasi'),
                'negara' => $this->input->post('negara'),
                'provinsi' => $this->input->post('provinsi'),
                'kota' => $this->input->post('kota')
            );
            $response = $this->Lokasi_model->create_lokasi($data);
            if ($response && isset($response->id)) {
                $this->session->set_flashdata('success', 'Lokasi berhasil ditambahkan');
                redirect('dashboard');
            } else {
                $this->session->set_flashdata('error', 'Gagal menambahkan lokasi');
                redirect('dashboard/add_lokasi');
            }
        }
    }

    public function add_proyek() {
        $this->form_validation->set_rules('nama_proyek', 'Nama Proyek', 'required|trim');
        $this->form_validation->set_rules('client', 'Client', 'required|trim');
        $this->form_validation->set_rules('tgl_mulai', 'Tanggal Mulai', 'required');
        $this->form_validation->set_rules('tgl_selesai', 'Tanggal Selesai', 'required');
        $this->form_validation->set_rules('pimpinan_proyek', 'Pimpinan Proyek', 'required|trim');
        $this->form_validation->set_rules('lokasi[]', 'Lokasi', 'required');

        if ($this->form_validation->run() == FALSE) {
            $data['lokasi_list'] = $this->Lokasi_model->get_all_lokasi();
            $this->load->view('add_proyek', $data);
        } else {
            $data = array(
                'namaProyek' => $this->input->post('nama_proyek'),
                'client' => $this->input->post('client'),
                'tglMulai' => $this->input->post('tgl_mulai'),
                'tglSelesai' => $this->input->post('tgl_selesai'),
                'pimpinanProyek' => $this->input->post('pimpinan_proyek'),
                'keterangan' => $this->input->post('keterangan')
            );
            $response = $this->Proyek_model->create_proyek($data);
            if ($response && isset($response->id)) {
                $proyek_id = $response->id;
                $lokasi_ids = $this->input->post('lokasi');
                foreach ($lokasi_ids as $lokasi_id) {
                    $this->Proyek_model->add_lokasi_to_proyek($proyek_id, $lokasi_id);
                }
                $this->session->set_flashdata('success', 'Proyek berhasil ditambahkan');
                redirect('dashboard');
            } else {
                $this->session->set_flashdata('error', 'Gagal menambahkan proyek');
                redirect('dashboard/add_proyek');
            }
        }
    }

    public function edit_lokasi($id) {
        $this->load->helper('form');
        $this->form_validation->set_rules('nama_lokasi', 'Nama Lokasi', 'required|trim');
        $this->form_validation->set_rules('negara', 'Negara', 'required|trim');
        $this->form_validation->set_rules('provinsi', 'Provinsi', 'required|trim');
        $this->form_validation->set_rules('kota', 'Kota', 'required|trim');

        if ($this->form_validation->run() == FALSE) {
            $data['lokasi'] = $this->Lokasi_model->get_lokasi($id);
            $this->load->view('edit_lokasi', $data);
        } else {
            $data = array(
                'namaLokasi' => $this->input->post('nama_lokasi'),
                'negara' => $this->input->post('negara'),
                'provinsi' => $this->input->post('provinsi'),
                'kota' => $this->input->post('kota')
            );
            $this->Lokasi_model->update_lokasi($id, $data);
            redirect('dashboard');
        }
    }

    public function edit_proyek($id) {
        try {
            $data['proyek'] = $this->Proyek_model->get_proyek($id);
            $data['lokasi_list'] = $this->Lokasi_model->get_all_lokasi();
            
            if (!$data['proyek']) {
                show_error('Proyek tidak ditemukan', 404);
                return;
            }
    
            $this->form_validation->set_rules('nama_proyek', 'Nama Proyek', 'required|trim');
            $this->form_validation->set_rules('client', 'Client', 'required|trim');
            $this->form_validation->set_rules('tgl_mulai', 'Tanggal Mulai', 'required');
            $this->form_validation->set_rules('tgl_selesai', 'Tanggal Selesai', 'required');
            $this->form_validation->set_rules('pimpinan_proyek', 'Pimpinan Proyek', 'required|trim');
            $this->form_validation->set_rules('lokasi[]', 'Lokasi', 'required');
    
            if ($this->form_validation->run() == FALSE) {
                $this->load->view('edit_proyek', $data);
            } else {
                $update_data = array(
                    'namaProyek' => $this->input->post('nama_proyek'),
                    'client' => $this->input->post('client'),
                    'tglMulai' => $this->input->post('tgl_mulai'),
                    'tglSelesai' => $this->input->post('tgl_selesai'),
                    'pimpinanProyek' => $this->input->post('pimpinan_proyek'),
                    'keterangan' => $this->input->post('keterangan')
                );
                $result = $this->Proyek_model->update_proyek($id, $update_data);
            
                if ($result === false) {
                    throw new Exception("Gagal mengupdate proyek");
                }
                $lokasi_ids = $this->input->post('lokasi');
                if (is_array($lokasi_ids)) {
                    foreach ($proyek->lokasi as $old_lokasi) {
                        $this->Proyek_model->delete_lokasi_from_proyek($id, $old_lokasi->id);
                    }
                    foreach ($lokasi_ids as $lokasi_id) {
                        $result = $this->Proyek_model->add_lokasi_to_proyek($id, $lokasi_id);
                    if ($result === false) {
                        throw new Exception("Gagal menambahkan lokasi ke proyek");
                    }
                }
            }
            
            $this->session->set_flashdata('success', 'Proyek berhasil diupdate');
            redirect('dashboard');
                
            }
        } catch (Exception $e) {
            // log_message('error', 'Error saat mengambil atau memproses data proyek: ' . $e->getMessage());
            // $this->output->set_status_header(500);
            // $data['heading'] = "An Error Was Encountered";
            // $data['message'] = "Terjadi kesalahan saat mengambil atau memproses data. Silakan coba lagi nanti. Error: " . $e->getMessage();
            // $this->load->view('errors/html/error_general', $data);
            log_message('error', 'Error saat mengupdate proyek: ' . $e->getMessage());
            $this->session->set_flashdata('error', 'Terjadi kesalahan saat mengupdate proyek. Silakan coba lagi nanti.');
            redirect('dashboard/edit_proyek/' . $id);
        }
    }

    public function update_proyek($id, $data) {
        $response = $this->api_client->request('PUT', "proyek/{$id}", $data);
        if ($response === false || (isset($response->error) && $response->error)) {
            log_message('error', 'API Error: ' . print_r($response, true));
            return false;
        }
        return $response;
    }

    public function delete_lokasi($id) {
        $this->Lokasi_model->delete_lokasi($id);
        redirect('dashboard');
    }

    public function delete_proyek($id) {
        $this->Proyek_model->delete_proyek($id);
        redirect('dashboard');
    }


    private function _clean_input($data) {
        if (is_array($data)) {
            foreach ($data as $key => $value) {
                $data[$key] = $this->_clean_input($value);
            }
        } else {
            $data = $this->security->xss_clean($data);
        }
        return $data;
    }
}
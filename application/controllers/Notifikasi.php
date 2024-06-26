<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Notifikasi extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        // Load model yang diperlukan, misal UserModel
        $this->load->model('UserModel');
        $this->load->model('PeranModel');
        $this->load->model('NotifModel');
        $this->load->helper('date');
    }

    public function kirimNotifKGB()
    {
        $data['peran'] = $this->PeranModel->get_peran();
        // Mengurutkan pengguna berdasarkan nama_pengguna secara ascending
        $this->db->order_by('nama_pengguna', 'ASC');
        $data['pengguna'] = $this->UserModel->get_all_user();

        $this->form_validation->set_rules('nama_pengguna', 'Nama', 'required|trim');
        $this->form_validation->set_rules('pesan', 'Pesan', 'required|trim');

        if ($this->form_validation->run() === FALSE) {
            $this->load->view('templates/header');
            $this->load->view('templates/sidebar');
            $this->load->view('templates/topbar');
            $this->load->view('notifikasi/kirim_notif_kgb', $data);
            $this->load->view('templates/footer');
        } else {
            $nama_pengguna = $this->input->post('nama_pengguna');

            $user = $this->UserModel->get_user($nama_pengguna);

            $notifikasi_data = array(
                'pengguna_id' => $user->id,
                'dikirim_ke' => $user->nama,
                'dikirim_oleh' => 'Admin',
                'pesan' => $this->input->post('pesan')
            );

            $this->db->insert('notifikasi_kgb', $notifikasi_data);

            $this->session->set_flashdata('message', '<div class="alert alert-success" role="alert">Notifikasi berhasil dikirim.</div>');
            redirect('notifikasi/kirimnotifkgb');
        }
    }

    public function pesannotif()
    {
        $session_peranId = $this->session->userdata('peranId');

        $data['peran'] = $this->PeranModel->get_peran();
        // Mengurutkan pengguna berdasarkan nama_pengguna secara ascending
        $this->db->order_by('nama_pengguna', 'ASC');
        $data['pengguna'] = $this->UserModel->get_all_user();


        // buat nangkep data notifikasi
        $session_pengguna_id = $this->session->userdata('penggunaId');
        $data['notifikasi'] = $this->NotifModel->get_notif($session_pengguna_id);

        $this->form_validation->set_rules('nama_pengguna', 'Nama', 'required|trim');
        $this->form_validation->set_rules('pesan', 'Pesan', 'required|trim');

        if ($this->form_validation->run() === FALSE) {
            $this->load->view('templates/header');
            // Cek nilai peranId dan load sidebar yang sesuai
            if ($session_peranId == 1) {
                $this->load->view('templates/sidebar');
                $this->load->view('templates/topbar');
            } elseif ($session_peranId == 3) {
                $this->load->view('templates/sidebar_pegawai');
                $this->load->view('templates/topbar_pegawai', $data);
            }
            $this->load->view('notifikasi/pesan_notif', $data);
            $this->load->view('templates/footer');
        } else {
            $nama_pengguna = $this->input->post('nama_pengguna');

            $user = $this->UserModel->get_user($nama_pengguna);

            $notifikasi_data = array(
                'pengguna_id' => $user->id,
                'dikirim_ke' => $user->nama,
                'dikirim_oleh' => 'Admin',
                'pesan' => $this->input->post('pesan')
            );

            $this->db->insert('notifikasi_kgb', $notifikasi_data);

            $this->session->set_flashdata('message', '<div class="alert alert-success" role="alert">Notifikasi berhasil dikirim.</div>');
            redirect('notifikasi/kirimnotifkgb');
        }
    }

    public function markNotificationsAsRead()
    {
        $session_pengguna_id = $this->session->userdata('pengguna_id');
        $this->load->model('Notifikasi_model');
        $this->Notifikasi_model->markNotificationsAsRead($session_pengguna_id);
        echo json_encode(['status' => 'success']);
    }
}

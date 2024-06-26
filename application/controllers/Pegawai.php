<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Pegawai extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        // Load model yang diperlukan, misal UserModel
        $this->load->model('UserModel');
        $this->load->model('PeranModel');
        $this->load->model('RKGBModel');
        $this->load->model('NotifModel');
        $this->load->helper('date');
    }

    public function index()
    {
        $session_pengguna_id = $this->session->userdata('penggunaId');
        $data['notifikasi'] = $this->NotifModel->get_notif($session_pengguna_id);
        $this->load->view('templates/header');
        $this->load->view('templates/sidebar_pegawai');
        $this->load->view('templates/topbar_pegawai', $data);
        $this->load->view('pegawai/index');
        $this->load->view('templates/footer');
    }

    public function profil()
    {
        $session_pengguna_id = $this->session->userdata('penggunaId');
        $data['notifikasi'] = $this->NotifModel->get_notif($session_pengguna_id);

        $this->load->view('templates/header');
        $this->load->view('templates/sidebar_pegawai');
        $this->load->view('templates/topbar_pegawai', $data);
        $this->load->view('pegawai/profil');
        $this->load->view('templates/footer');
    }

    public function edit()
    {
        $session_pengguna_id = $this->session->userdata('penggunaId');
        $data['notifikasi'] = $this->NotifModel->get_notif($session_pengguna_id);
        $this->load->view('templates/header');
        $this->load->view('templates/sidebar_pegawai');
        $this->load->view('templates/topbar_pegawai', $data);
        $this->load->view('pegawai/edit');
        $this->load->view('templates/footer');
    }

    public function riwayatkgb()
    {
        $session_pengguna_id = $this->session->userdata('penggunaId');
        $data['riwayat_kgb'] = $this->RKGBModel->get_riwayat_kgb($session_pengguna_id);
        $data['notifikasi'] = $this->NotifModel->get_notif($session_pengguna_id);

        $this->form_validation->set_rules('golongan_ruang', 'Gol. Ruang', 'required|trim');
        // $this->form_validation->set_rules('gaji_tahun', 'Gaji Tahun', 'required|trim');
        // $this->form_validation->set_rules('masa_kerja_tahun', 'Masa Kerja Tahun', 'required|trim');
        // $this->form_validation->set_rules('gaji', 'Gaji', 'required|trim');
        // $this->form_validation->set_rules('kgb_nomor_sk', 'KGB Nomor SK', 'required|trim');
        // $this->form_validation->set_rules('kgb_tmt', 'KGB TMT', 'required|trim');
        // $this->form_validation->set_rules('tanggal_yad_kgb', 'Tanggal YAD KGB', 'required|trim');
        // $this->form_validation->set_rules('tahun_kgb', 'Tahun KGB', 'required|trim');
        // $this->form_validation->set_rules('bulan_kgb', 'Bulan KGB', 'required|trim');
        // $this->form_validation->set_rules('kgb_tanggal_surat', 'KGB Tanggal Surat', 'required|trim');
        // $this->form_validation->set_rules('nomor_sk_terakhir', 'No. SK Terakhir', 'required|trim');
        // $this->form_validation->set_rules('file_sk_berkala', 'File SK Berkala', 'required|trim');
        $this->form_validation->set_rules('file_sk_berkala', 'File SK Berkala', 'callback_file_check');

        if ($this->form_validation->run() == false) {
            $this->load->view('templates/header');
            $this->load->view('templates/sidebar_pegawai');
            $this->load->view('templates/topbar_pegawai', $data);
            $this->load->view('pegawai/riwayat_kgb', $data);
            $this->load->view('templates/footer');
        } else {
            $data = [
                'penggunaId' => $session_pengguna_id,
                'golongan_ruang' => $this->input->post('golongan_ruang'),
                'gaji_tahun' => $this->input->post('gaji_tahun'),
                'masa_kerja_tahun' => $this->input->post('masa_kerja_tahun'),
                'gaji' => $this->input->post('gaji'),
                'kgb_nomor_sk' => $this->input->post('kgb_nomor_sk'),
                'kgb_tmt' => $this->input->post('kgb_tmt'),
                'tanggal_yad_kgb' => $this->input->post('tanggal_yad_kgb'),
                'tahun_kgb' => $this->input->post('tahun_kgb'),
                'bulan_kgb' => $this->input->post('bulan_kgb'),
                'kgb_tanggal_surat' => $this->input->post('kgb_tanggal_surat'),
                'nomor_sk_terakhir' => $this->input->post('nomor_sk_terakhir'),
            ];


            // Handle file upload
            $upload_file = $_FILES['file_sk_berkala']['name'];
            if ($upload_file) {
                $config['allowed_types'] = 'pdf';
                $config['max_size']     = '10000';
                $config['upload_path'] = './assets/berkas';

                $this->load->library('upload', $config);

                if ($this->upload->do_upload('file_sk_berkala')) {
                    $uploaded_file_data = $this->upload->data(); // Mendapatkan informasi lengkap tentang berkas yang diunggah
                    $new_image = $uploaded_file_data['file_name'];
                    $data['file_sk_berkala'] = $new_image;

                    // Insert file information into 'berkas' table
                    $berkas_data = [
                        'nama_berkas' => $new_image,
                        'jenis_berkas' => 'File SK Berkala',
                        'ukuran_berkas' => $uploaded_file_data['file_size'], // Ukuran berkas dalam byte
                        'path_berkas' => $uploaded_file_data['file_path'], // Menggunakan lokasi penyimpanan dari informasi yang diunggah
                        'penggunaId' => $session_pengguna_id // Jika diperlukan, sesuaikan dengan ID pengguna
                    ];

                    $this->db->insert('berkas', $berkas_data);
                } else {
                    $this->session->set_flashdata('message', '<div class="alert alert-danger" role="alert">' . $this->upload->display_errors() . '</div>');
                    redirect('pegawai/riwayatkgb');
                }
            }

            $this->db->insert('riwayat_kgb', $data);


            $this->session->set_flashdata('message', '<div class="alert alert-success" role="alert">Berhasil menyimpan data.</div>');
            redirect('pegawai/riwayatkgb');
        }
    }


    // Fungsi callback untuk memeriksa file upload
    public function file_check()
    {
        if (empty($_FILES['file_sk_berkala']['name'])) {
            $this->form_validation->set_message('file_check', 'File SK Berkala wajib diisi.');
            return false;
        }
        return true;
    }
}

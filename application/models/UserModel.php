<?php
defined('BASEPATH') or exit('No direct script access allowed');

class UserModel extends CI_Model
{

    public function get_user($nama_pengguna)
    {
        // Query ke database untuk mencari user berdasarkan nama pengguna dan kata sandi
        $this->db->select('pengguna.*, peran.nama_peran');
        $this->db->from('pengguna');
        $this->db->join('peran', 'pengguna.peranId = peran.id', 'left');
        $this->db->where('pengguna.nama_pengguna', $nama_pengguna);
        $query = $this->db->get();

        // Jika ditemukan satu baris hasil query, kembalikan data user
        if ($query->num_rows() == 1) {
            return $query->row();
        } else {
            // Jika tidak ditemukan, kembalikan null
            return null;
        }
    }

    public function edit_user($nama_pengguna, $update_data)
    {
        // Cari pengguna berdasarkan nama_pengguna
        $this->db->where('nama_pengguna', $nama_pengguna);

        // Lakukan pembaruan data
        $this->db->update('pengguna', $update_data);

        // Mengembalikan hasil pembaruan
        return $this->db->affected_rows();
    }

    public function get_all_user()
    {
        $this->db->select('pengguna.*, peran.nama_peran');
        $this->db->from('pengguna');
        $this->db->join('peran', 'pengguna.peranId = peran.id', 'left');
        $query = $this->db->get();
        return $query->result_array();
    }

    public function get_all_pegawai()
    {
        $this->db->select('pengguna.*, pengguna.email as pengguna_email, peran.nama_peran, biodata.*');
        $this->db->from('pengguna');
        $this->db->join('peran', 'pengguna.peranId = peran.id', 'left');
        $this->db->join('biodata', 'pengguna.id = biodata.penggunaId', 'left');
        $this->db->where('pengguna.peranId', 3);
        $query = $this->db->get();
        return $query->result_array();
    }

    public function add_user($data)
    {
        $this->db->insert('pengguna', $data);
    }

    public function update_password($nama_pengguna, $hash_sandi_baru)
    {
        $this->db->set('kata_sandi', $hash_sandi_baru);
        $this->db->where('nama_pengguna', $nama_pengguna);
        return $this->db->update('pengguna'); // Nama tabel pengguna
    }
}

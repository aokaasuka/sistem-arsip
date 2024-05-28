<?php
defined('BASEPATH') or exit('No direct script access allowed');

class UserModel extends CI_Model
{

    public function get_user($nama_pengguna, $kata_sandi)
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
}
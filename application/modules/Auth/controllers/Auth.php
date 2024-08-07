<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Auth extends CI_Controller
{

	function __construct()
	{
		parent::__construct();
	}

	public function index()
	{
		$data['username'] = '';
		// $this->load->view('login_new', $data);
		redirect('/');
	}

	public function prosesLogin()
	{
		$user = $this->input->post('username');
		$pass = md5($this->input->post('password'));

		$que = "select * from ms_user where blokir='N' and username='$user' and password='$pass'";
		$hasil = $this->db->query($que)->row();
		if (isset($hasil)) {
			$datetime = date('Y-m-d H:i:s');
			$this->db->query("update ms_user set last_login='$datetime' where id=" . $hasil->id);
			$this->db->query("insert ms_user_history(fk_user_id,ipaddress,time_act) values(" . $hasil->id . ",'" . $this->input->ip_address() . "','" . $datetime . "') ");

			$data['id'] = $hasil->id;
			$data['username'] = $hasil->username;
			$data['password'] = $hasil->password;
			$data['nama_lengkap'] = $hasil->nama_lengkap;
			$data['fk_level_id'] = 99;
			$data['fk_cabang_id'] = $hasil->fk_cabang_id;
			$data['kode_pj'] = $hasil->kode_pj;

			$data['nama_cabang'] = null;
			if ($hasil->fk_level_id != 1) {
				$cbg = $this->db->query("SELECT nama_cabang FROM ms_cabang WHERE id=$hasil->fk_cabang_id")->row();
				$data['nama_cabang'] = $cbg->nama_cabang;
			}

			$this->session->set_userdata($data);

			redirect('Home');
		} else {
			$data['username'] = $user;
			$this->session->set_flashdata('error', 'username atau password anda salah.');
			$this->load->view('login_new', $data);
		}
	}

	function logout()
	{
		$this->session->sess_destroy();
		redirect('Auth');
	}
}

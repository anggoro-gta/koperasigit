<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Login extends CI_Controller
{

	function __construct()
	{
		parent::__construct();
	}

	public function index()
	{
		$data['username'] = '';
		$this->load->view('login_new', $data);
	}

	public function prosesLogin()
	{
		$user = $this->input->post('username');
		$pass = md5($this->input->post('password'));

		$this->db->select('*')->from('ms_cb_user_anggota')->where(array('blokir' => 'N', 'username' => $user, 'password' => $pass));
		$hasil = $this->db->get()->row();

		if (isset($hasil)) {
			$datetime = date('Y-m-d H:i:s');
			$this->db->query("update ms_cb_user_anggota set last_login='$datetime' where id=" . $hasil->id);
			$this->db->query("insert ms_cb_user_anggota_history(fk_cb_user_anggota_id,ipaddress,time_act) values(" . $hasil->id . ",'" . $this->input->ip_address() . "','" . $datetime . "') ");

			$data['id'] = $hasil->id;
			$data['username'] = $hasil->username;
			$data['password'] = $hasil->password;
			$data['nama'] = $hasil->nama;
			$data['alamat'] = $hasil->alamat;
			$data['nik'] = $hasil->nik;
			$data['nip'] = $hasil->nip;
			$data['nomor_hp'] = $hasil->nomor_hp;
			$data['tempat_lahir'] = $hasil->tempat_lahir;
			$data['tanngal_lahir'] = $hasil->tanngal_lahir;
			$data['jenis_kelamin'] = $hasil->jenis_kelamin;
			$data['fk_id_skpd'] = $hasil->fk_id_skpd;
			$data['fk_id_status_pekerjaan'] = $hasil->fk_id_status_pekerjaan;
			$data['tanggal_mulai_aktif'] = $hasil->tanggal_mulai_aktif;
			$data['status_keaktifan'] = $hasil->status_keaktifan;
			$data['keterangan'] = $hasil->keterangan;
			// $data['fk_cabang_id'] = $hasil->fk_cabang_id;
			// $data['kode_pj'] = $hasil->kode_pj;

			// $data['nama_cabang'] = null;
			// if($hasil->fk_level_id!=1){
			// 	$cbg = $this->db->query("SELECT nama_cabang FROM ms_cabang WHERE id=$hasil->fk_cabang_id")->row();
			// 	$data['nama_cabang'] = $cbg->nama_cabang;
			// }

			$this->session->set_userdata($data);

			redirect('Homeanggota/updatedataanggota');
		} else {
			$data['username'] = $user;
			$this->session->set_flashdata('error', 'username atau password anda salah.');
			$this->load->view('login_new', $data);
		}
	}

	function logout()
	{
		$this->session->sess_destroy();
		redirect('Login');
	}
}

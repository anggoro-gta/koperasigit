<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Auth extends MX_Controller {

	function __construct(){
		parent::__construct();

	}

	public function index(){ die(' controller dewe');
		$data['company'] = $this->db->query('SELECT nama FROM ms_company')->row();
		$this->load->view('login',$data);
	}

	public function prosesLogin(){
		$user = $this->input->post('username');
		$pass = md5($this->input->post('password'));

		$que = "select * from users where blokir='N' and username='$user' and password='$pass' ";
		$hasil = $this->db->query($que)->row();
		if(isset($hasil)){
			$datetime = date('Y-m-d H:i:s');
			$this->db->query("update users set last_login='$datetime' where id=".$hasil->id);
			$this->db->query("insert users_history(fk_users_id,ipaddress,time_act) values(".$hasil->id.",'".$this->input->ip_address()."','".$datetime."') ");

			$data['id'] = $hasil->id;
			$data['username'] = $hasil->username;
			$data['password'] = $hasil->password;
			$data['level'] = $hasil->level;
			$data['kode_pj'] = $hasil->kode_pj;

			$this->session->set_userdata($data);

			redirect('home');
		}else{
			$this->session->set_flashdata('error', 'username atau password anda salah.');
            redirect('auth');
		}
	}

	function logout(){
        $this->session->sess_destroy();
        redirect('auth');
    }
}

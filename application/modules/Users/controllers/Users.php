<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Users extends CI_Controller {

	function __construct(){
		parent::__construct();
		$this->load->library('datatables');
		$this->load->model('MUser');
		$this->load->model('MMsLevel');
		$this->load->model('MMsCabang');
	}
	
	public function index(){
		$data['user'] = 'active';
		$data['act_add'] = base_url().'Users/create';
		$this->template->load('Home/template','Users/list',$data);
	}

	public function getDatatables(){
		header('Content-Type: application/json');
        
        $this->datatables->select('ms_user.id,username,nama_lengkap,nama_cabang,ms_level.nama,blokir,last_login,kode_pj');
        $this->datatables->from("ms_user");
        $this->datatables->join('ms_level','ms_level.id=ms_user.fk_level_id','inner'); 
        $this->datatables->join('ms_cabang','ms_cabang.id=ms_user.fk_cabang_id','left'); 
		// $this->datatables->where('level !=',2);
        $this->db->order_by('id','asc');
        $this->datatables->add_column('action', '<div class="btn-group">'.anchor(site_url('Users/update/$1'),'<i title="edit" class="glyphicon glyphicon-edit icon-white"></i>','class="btn btn-xs btn-success"').anchor(site_url('Users/delete/$1'),'<i title="hapus" class="glyphicon glyphicon-trash icon-white"></i>','class="btn btn-xs btn-danger" onclick="javasciprt: return confirm(\'Apakah anda yakin?\')"').'</div>', 'id');

        echo $this->datatables->generate();
	}

	public function create(){
		$data = array(
			'action' => base_url().'Users/save',
			'button' => 'Simpan',
			'username' => set_value('username'),
			'password' => set_value('password','123456'),
			'nama_lengkap' => set_value('nama_lengkap'),
			'fk_level_id' => set_value('fk_level_id'),
			'fk_cabang_id' => set_value('fk_cabang_id'),
			'kode_pj' => set_value('kode_pj'),
			'blokir' => set_value('blokir'),
			'id' => set_value('id'),
		);
		$data['user'] = 'active';
		$data['arrLevel'] = $this->MMsLevel->get();
		$data['arrCabang'] = $this->MMsCabang->get();
		$this->template->load('Home/template','Users/form',$data);
	}

	public function update($id){
		$usr = $this->MUser->get(array('id'=>$id));
		$usr = $usr[0];

		$data = array(
			'action' => base_url().'Users/save',
			'button' => 'Update',
			'username' => set_value('username',$usr['username']),
			'nama_lengkap' => set_value('nama_lengkap',$usr['nama_lengkap']),
			'fk_level_id' => set_value('fk_level_id',$usr['fk_level_id']),
			'fk_cabang_id' => set_value('fk_cabang_id',$usr['fk_cabang_id']),
			'kode_pj' => set_value('kode_pj',$usr['kode_pj']),
			'blokir' => set_value('blokir',$usr['blokir']),
			'id' => set_value('id',$usr['id']),
		);
		$data['user'] = 'active';
		$data['arrLevel'] = $this->MMsLevel->get();
		$data['arrCabang'] = $this->MMsCabang->get();
		$this->template->load('Home/template','Users/form',$data);
	}

	public function save(){
		if($this->session->fk_level_id==1){
			$id = $this->input->post('id');
			$data['username'] = $this->input->post('username');
			$data['nama_lengkap'] = $this->input->post('nama_lengkap');
			$data['fk_level_id'] = $this->input->post('fk_level_id');
				$cbgId = $this->input->post('fk_cabang_id');
			if($cbgId){
				$data['fk_cabang_id'] = $cbgId;				
			}else{
				$data['fk_cabang_id'] = NULL;
			}

			$data['kode_pj'] = $this->input->post('kode_pj');
			$data['blokir'] = $this->input->post('blokir');
			$data['user_act'] = $this->session->id;
			$data['time_act'] = date('Y-m-d H:i:s');	

			if(empty($id)){
				$data['password'] = md5($this->input->post('password'));
				$this->MUser->insert($data);
				$this->session->set_flashdata('success', 'Data Berhasil disimpan.');
			
			}else{
				$reset_password = $this->input->post('reset_password');
				if($reset_password){
					$data['password'] = md5('123456');
				}
				$this->MUser->update($id,$data);
				$this->session->set_flashdata('success', 'Data Berhasil diupdate.');
			}
		}else{
			$this->session->set_flashdata('error', 'Anda tidak mempunyai hak untuk proses update.');
		}
        redirect('Users');
	}

	public function delete($id){  
		$usr = $this->MUser->get(array('id'=>$id)); 
		if(!empty($usr[0]['last_login'])){
			$this->session->set_flashdata('error', 'Data hanya bisa diupdate');
		}
		else{
	        $result = $this->MUser->delete($id);
			if($result){
	        	$this->session->set_flashdata('success', 'Data berhasil dihapus.');
	        }else{
	        	$this->session->set_flashdata('error', 'Data hanya bisa diupdate');
	        }
	    }

        redirect('Users');
	}

	public function ubahPswd(){
		$data = array(
			'pswdLama' => set_value('pswdLama'),
			'pswdBaru' => set_value('pswdBaru'),
			'ulangiPswdBaru' => set_value('ulangiPswdBaru'),
		);
		if(isset($_POST['pswdBaru'])){
			$pswdLama = $this->input->post('pswdLama');
			$pswdBaru = $this->input->post('pswdBaru');
			$ulangiPswdBaru = $this->input->post('ulangiPswdBaru');
			
			if(md5($pswdLama) != $this->session->password){
				$this->session->set_flashdata('error', 'Password Lama tidak sesuai.');
				$error = true;
			}else if($pswdBaru != $ulangiPswdBaru){
				$this->session->set_flashdata('error', 'Ulangi Password Baru harus sama dengan Password baru.');
				$error = true;
			}else{
				$dataUpdate['password'] = md5($pswdBaru);
				$dataUpdate['user_act'] = $this->session->id;
				$dataUpdate['time_act'] = date('Y-m-d H:i:s');
				$this->MUser->update($this->session->id,$dataUpdate);
				$error = false;
				$this->session->set_flashdata('success', 'Password Berhasil diubah, silahkan logout dan login kembali dengan password yg baru.');
			}

			if($error){
				$data = array(
					'pswdLama' => set_value('pswdLama',$pswdLama),
					'pswdBaru' => set_value('pswdBaru',$pswdBaru),
					'ulangiPswdBaru' => set_value('ulangiPswdBaru',$ulangiPswdBaru),
				);
			}else{
				$data['pswdLama']='';
				$data['pswdBaru']='';
				$data['ulangiPswdBaru']='';
			}
		}

		$this->template->load('Home/template','Users/formUbahPswd',$data);
	}
}

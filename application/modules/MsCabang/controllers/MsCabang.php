<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class MsCabang extends CI_Controller {

	function __construct(){
		parent::__construct();
		$this->load->library('datatables');
		$this->load->model('MMsCabang');
	}

	public function index(){
		$data=null;
		$data['MsCabang'] = 'active';
		$data['act_add'] = base_url().'MsCabang/create';
		$this->template->load('Home/template','MsCabang/list',$data);
	}

	public function getDatatables(){
		header('Content-Type: application/json');
        
        // if($this->session->level!=1){
        // 	$this->datatables->where('id',$this->session->fk_cabang_id);
        // }

        $this->datatables->select('id,nama_cabang,no_tlp,alamat,status');
        $this->datatables->select("(CASE status	WHEN 1 THEN	'Aktif' ELSE 'Tidak Aktif' END) statusnya");
        $this->datatables->from("ms_cabang");
        $this->db->order_by('nama_cabang','asc');
        $this->datatables->add_column('action', '<div class="btn-group">'.anchor(site_url('MsCabang/update/$1'),'<i title="edit" class="glyphicon glyphicon-edit icon-white"></i>','class="btn btn-xs btn-success"').anchor(site_url('MsCabang/delete/$1'),'<i title="hapus" class="glyphicon glyphicon-trash icon-white"></i>','class="btn btn-xs btn-danger" onclick="javasciprt: return confirm(\'Apakah anda yakin?\')"').'</div>', 'id');

        echo $this->datatables->generate();
	}

	public function create(){
		$data = array(
			'action' => base_url().'MsCabang/save',
			'button' => 'Simpan',
			'nama_cabang' => set_value('nama_cabang'),
			'no_tlp' => set_value('no_tlp'),
			'alamat' => set_value('alamat'),
			'status' => set_value('status','1'),
			'id' => set_value('id'),
		);

		$data['MsCabang'] = 'active';
		$this->template->load('Home/template','MsCabang/form',$data);
	}

	public function update($id){
		$kat = $this->db->query("SELECT * FROM ms_cabang WHERE id=$id")->row();

		$data = array(
			'action' => base_url().'MsCabang/save',
			'button' => 'Update',
			'nama_cabang' => set_value('nama_cabang',$kat->nama_cabang),
			'no_tlp' => set_value('no_tlp',$kat->no_tlp),
			'alamat' => set_value('alamat',$kat->alamat),
			'status' => set_value('status',$kat->status),
			'id' => set_value('id',$kat->id),
		);
		$data['MsCabang'] = 'active';
		$this->template->load('Home/template','MsCabang/form',$data);
	}

	public function save(){
		$id = $this->input->post('id');
		$data['nama_cabang'] = $this->input->post('nama_cabang');
		$data['no_tlp'] = $this->input->post('no_tlp');
		$data['alamat'] = $this->input->post('alamat');
		$data['status'] = $this->input->post('status');
		
		$data['user_act'] = $this->session->id;
		$data['time_act'] = date('Y-m-d H:i:s');

		if(empty($id)){
			$this->MMsCabang->insert($data);

			$this->session->set_flashdata('success', 'Data Berhasil disimpan.');
		
		}else{
			$this->MMsCabang->update($id,$data);
			$this->session->set_flashdata('success', 'Data Berhasil diupdate.');
		}
		
        redirect('MsCabang');
	}

	public function delete($id){       
		if($this->session->level==1){
	        $result = $this->MMsCabang->delete($id);
			if($result){
	        	$this->session->set_flashdata('success', 'Data berhasil dihapus.');
	        }else{
	        	$this->session->set_flashdata('error', 'Data hanya bisa diupdate');
	        }
	    }else{
	    	$this->session->set_flashdata('error', 'Data hanya bisa diupdate');
	    }

        redirect('MsCabang');
	}
}

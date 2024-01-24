<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class MsPaket extends CI_Controller {

	function __construct(){
		parent::__construct();
		$this->load->library('datatables');
		$this->load->model('MMsPaket');
	}

	public function index(){
		$data=null;
		$data['MsPaket'] = 'active';
		$data['act_add'] = base_url().'MsPaket/create';
		$this->template->load('Home/template','MsPaket/list',$data);
	}

	public function getDatatables(){
		header('Content-Type: application/json');
        
        // if($this->session->level!=1){
        // 	$this->datatables->where('id',$this->session->fk_cabang_id);
        // }

        $this->datatables->select('id,nama_paket');
        $this->datatables->select("FORMAT(nominal,0) AS nominal", FALSE);
        $this->datatables->select("FORMAT(fee_terapis,0) AS fee_terapis", FALSE);
        $this->datatables->from("ms_paket");
        // $this->db->order_by('nama_cabang','asc');
        $this->datatables->add_column('action', '<div class="btn-group">'.anchor(site_url('MsPaket/update/$1'),'<i title="edit" class="glyphicon glyphicon-edit icon-white"></i>','class="btn btn-xs btn-success"').anchor(site_url('MsPaket/delete/$1'),'<i title="hapus" class="glyphicon glyphicon-trash icon-white"></i>','class="btn btn-xs btn-danger" onclick="javasciprt: return confirm(\'Apakah anda yakin?\')"').'</div>', 'id');

        echo $this->datatables->generate();
	}

	public function create(){
		$data = array(
			'action' => base_url().'MsPaket/save',
			'button' => 'Simpan',
			'nama_paket' => set_value('nama_paket'),
			'nominal' => set_value('nominal'),
			'fee_terapis' => set_value('fee_terapis'),
			'status' => set_value('status','1'),
			'id' => set_value('id'),
		);

		$data['MsPaket'] = 'active';
		$this->template->load('Home/template','MsPaket/form',$data);
	}

	public function update($id){
		$kat = $this->db->query("SELECT * FROM ms_paket WHERE id=$id")->row();

		$data = array(
			'action' => base_url().'MsPaket/save',
			'button' => 'Update',
			'nama_paket' => set_value('nama_paket',$kat->nama_paket),
			'nominal' => set_value('nominal',$kat->nominal),
			'fee_terapis' => set_value('fee_terapis',$kat->fee_terapis),
			'id' => set_value('id',$kat->id),
		);
		$data['MsPaket'] = 'active';
		$this->template->load('Home/template','MsPaket/form',$data);
	}

	public function save(){
		$id = $this->input->post('id');
		$data['nama_paket'] = $this->input->post('nama_paket');
		$data['nominal'] = str_replace(',', '', $this->input->post('nominal'));
		$data['fee_terapis'] = str_replace(',', '', $this->input->post('fee_terapis'));

		if(empty($id)){
			$this->MMsPaket->insert($data);

			$this->session->set_flashdata('success', 'Data Berhasil disimpan.');
		
		}else{
			$this->MMsPaket->update($id,$data);
			$this->session->set_flashdata('success', 'Data Berhasil diupdate.');
		}
		
        redirect('MsPaket');
	}

	public function delete($id){       
		if($this->session->level==1){
	        $result = $this->MMsPaket->delete($id);
			if($result){
	        	$this->session->set_flashdata('success', 'Data berhasil dihapus.');
	        }else{
	        	$this->session->set_flashdata('error', 'Data hanya bisa diupdate');
	        }
	    }else{
	    	$this->session->set_flashdata('error', 'Data hanya bisa diupdate');
	    }

        redirect('MsPaket');
	}
}

<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Penerimaan extends CI_Controller {
	protected $table;
	
	function __construct(){
		parent::__construct();
		$this->load->library('datatables');
		$this->load->model('MMsKategori');
		$this->table = 'ms_cb_kategori_penerimaan';
	}

	public function index(){
		$data=null;
		$data['MsKategoriPenerimaan'] = 'active';
		$data['act_add'] = base_url().'MsKategori/Penerimaan/create';
		$this->template->load('Homeadmin/templateadmin','MsKategori/penerimaan/list',$data);
	}

	public function getDatatables(){
		header('Content-Type: application/json');
		
        $this->datatables->select('id,nama_kategori_penerimaan');
        $this->datatables->from("ms_cb_kategori_penerimaan");
        $this->db->order_by('id','asc');
        $this->datatables->add_column('action', '<div class="btn-group">'.anchor(site_url('MsKategori/Penerimaan/update/$1'),'<i title="edit" class="glyphicon glyphicon-edit icon-white"></i>','class="btn btn-xs btn-success"').anchor(site_url('MsKategori/Penerimaan/delete/$1'),'<i title="hapus" class="glyphicon glyphicon-trash icon-white"></i>','class="btn btn-xs btn-danger" onclick="javasciprt: return confirm(\'Apakah anda yakin?\')"').'</div>', 'id');

        echo $this->datatables->generate();
	}

	public function create(){
		$data = array(
			'action'                   => base_url().'MsKategori/Penerimaan/save',
			'button'                   => 'Simpan',
			'nama_kategori_penerimaan' => set_value('nama_kategori_penerimaan'),
			'id'                       => set_value('id'),
		);

		$data['MsKategoriPenerimaan'] = 'active';
		$this->template->load('Homeadmin/templateadmin','MsKategori/penerimaan/form',$data);
	}

	public function update($id){
		$kat = $this->db->query("SELECT * FROM ms_cb_kategori_penerimaan WHERE id=$id")->row();

		$data = array(
			'action'                   => base_url().'MsKategori/Penerimaan/save',
			'button'                   => 'Update',
			'nama_kategori_penerimaan' => set_value('nama_kategori_penerimaan',$kat->nama_kategori_penerimaan),
			'id'                       => set_value('id',$kat->id),
		);
		$data['MsKategoriPenerimaan'] = 'active';
		$this->template->load('Homeadmin/templateadmin','MsKategori/penerimaan/form',$data);
	}

	public function save(){
		$id = $this->input->post('id');
		$data['nama_kategori_penerimaan'] = $this->input->post('nama_kategori_penerimaan');

		if(empty($id)){
			$this->MMsKategori->insert($this->table, $data);

			$this->session->set_flashdata('success', 'Data Berhasil disimpan.');
		
		}else{
			$this->MMsKategori->update($this->table, $id, $data);
			$this->session->set_flashdata('success', 'Data Berhasil diupdate.');
		}
		
        redirect('MsKategori/Penerimaan');
	}

	public function delete($id){   
		$result = $this->MMsKategori->delete($this->table, $id);
		if($result){
			$this->session->set_flashdata('success', 'Data berhasil dihapus.');
		}else{
			$this->session->set_flashdata('error', 'Data hanya bisa diupdate');
		}

        redirect('MsKategori/Penerimaan');
	}
}
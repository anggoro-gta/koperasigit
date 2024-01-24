<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class MsTerapis extends CI_Controller {

	function __construct(){
		parent::__construct();
		$this->load->library('datatables');
		$this->load->model('MMsTerapis');
		$this->load->model('MMsCabang');
	}

	public function index(){
		$data=null;
		$data['MsTerapis'] = 'active';
		$data['arrcabang'] = $this->MMsCabang->get();
		$this->template->load('Home/template','MsTerapis/list',$data);
	}

	public function getListDetail(){
		$data['act_add'] = base_url().'MsTerapis/create';
		$data['fk_cabang_id'] = $this->input->post('fk_cabang_id');

		$this->load->view('MsTerapis/listDetail',$data);
	}

	public function getDatatables(){
		header('Content-Type: application/json');

		$fk_cabang_id = $this->input->post('fk_cabang_id');
        
        if(!empty($fk_cabang_id)){
			$this->datatables->where('fk_cabang_id',$fk_cabang_id);
		}  

        $this->datatables->select('ms_terapis.id,nama_lengkap,nama_panggilan,ms_terapis.alamat,no_hp,fee_persen,nama_cabang, count(t_pos_detail.id) jml_terapis');       
        $this->datatables->select("(CASE ms_terapis.status	WHEN 1 THEN	'Aktif' ELSE 'Tidak Aktif' END) statusnya");     
        $this->datatables->select("DATE_FORMAT(tgl_gabung,'%d/%m/%Y') AS tgl_gabung", FALSE);
        $this->datatables->from("ms_terapis");
        $this->datatables->join('ms_cabang','ms_cabang.id=ms_terapis.fk_cabang_id','inner');        
        $this->datatables->join('t_pos_detail','t_pos_detail.fk_terapis_id=ms_terapis.id','left');    
        $this->db->group_by('ms_terapis.id');    
        // $this->db->order_by('nama','asc');
        $this->datatables->add_column('action', '<div class="btn-group">'.anchor(site_url('MsTerapis/update/$1'),'<i title="edit" class="glyphicon glyphicon-edit icon-white"></i>','class="btn btn-xs btn-success"').anchor(site_url('MsTerapis/delete/$1'),'<i title="hapus" class="glyphicon glyphicon-trash icon-white"></i>','class="btn btn-xs btn-danger" onclick="javasciprt: return confirm(\'Apakah anda yakin?\')"').'</div>', 'id');

        echo $this->datatables->generate();
	}

	public function create(){
		$data = array(
			'action' => base_url().'MsTerapis/save',
			'button' => 'Simpan',
			'fk_cabang_id' => set_value('fk_cabang_id'),
			'nama_lengkap' => set_value('nama_lengkap'),
			'nama_panggilan' => set_value('nama_panggilan'),
			'alamat' => set_value('alamat'),
			'no_hp' => set_value('no_hp'),
			'tgl_gabung' => set_value('tgl_gabung'),
			'fee_persen' => set_value('fee_persen'),
			'status' => set_value('status','1'),
			'id' => set_value('id'),
		);

		$data['MsTerapis'] = 'active';
		$data['arrcabang'] = $this->MMsCabang->get(array('status'=>1));
		$this->template->load('Home/template','MsTerapis/form',$data);
	}

	public function update($id){
		$kat = $this->db->query("SELECT * FROM ms_terapis WHERE id=$id")->row();

		$data = array(
			'action' => base_url().'MsTerapis/save',
			'button' => 'Update',
			'fk_cabang_id' => set_value('fk_cabang_id',$kat->fk_cabang_id),
			'nama_lengkap' => set_value('nama_lengkap',$kat->nama_lengkap),
			'nama_panggilan' => set_value('nama_panggilan',$kat->nama_panggilan),
			'alamat' => set_value('alamat',$kat->alamat),
			'no_hp' => set_value('no_hp',$kat->no_hp),
			'tgl_gabung' => set_value('tgl_gabung',$this->help->ReverseTgl($kat->tgl_gabung)),
			'fee_persen' => set_value('fee_persen',$kat->fee_persen),
			'status' => set_value('status',$kat->status),
			'id' => set_value('id',$kat->id),
		);
		$data['MsTerapis'] = 'active';
		$data['arrcabang'] = $this->MMsCabang->get();
		$this->template->load('Home/template','MsTerapis/form',$data);
	}

	public function save(){
		$id = $this->input->post('id');
		$data['fk_cabang_id'] = $this->input->post('fk_cabang_id');
		$data['nama_lengkap'] = $this->input->post('nama_lengkap');
		$data['nama_panggilan'] = $this->input->post('nama_panggilan');
		$data['alamat'] = $this->input->post('alamat');
		$data['no_hp'] = $this->input->post('no_hp');
		$data['tgl_gabung'] = $this->help->ReverseTgl($this->input->post('tgl_gabung'));
		$data['fee_persen'] = $this->input->post('fee_persen');
		$data['status'] = $this->input->post('status');
		$data['user_act'] = $this->session->id;
		$data['time_act'] = date('Y-m-d H:i:s');

		$page_pos = $this->input->post('page_pos');

		if(empty($id)){
			$this->MMsTerapis->insert($data);

			$this->session->set_flashdata('success', 'Data Berhasil disimpan.');
		
		}else{
			$this->MMsTerapis->update($id,$data);
			$this->session->set_flashdata('success', 'Data Berhasil diupdate.');
		}
	
       	redirect('MsTerapis');
	}

	public function delete($id){       
		if($this->session->fk_level_id==1){
	        $result = $this->MMsTerapis->delete($id);
			if($result){
	        	$this->session->set_flashdata('success', 'Data berhasil dihapus.');
	        }else{
	        	$this->session->set_flashdata('error', 'Data hanya bisa diupdate');
	        }
	    }else{
	    	$this->session->set_flashdata('error', 'Data hanya bisa diupdate');
	    }

        redirect('MsTerapis');
	}
}

<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Total extends CI_Controller
{

	function __construct()
	{
		parent::__construct();
		$this->load->library('datatables');
		$this->load->model('MHome');
		$this->load->model('MMscbUseranggota');
		$this->load->model('MSHU');
	}

	public function index()
	{
		$this->MHome->ceklogin();
		$data = null;
		$data['Total'] = 'active';
		$this->template->load('Homeadmin/templateadmin', 'SHU/total/list', $data);
	}

	public function getListDetail()
	{
		$this->MHome->ceklogin();
		$data['act_add'] = base_url() . 'SHU/Total/create';

		$this->load->view('SHU/total/listDetail', $data);
	}

	public function getDatatables()
	{
		$this->MHome->ceklogin();
		header('Content-Type: application/json');

		$this->datatables->select("id, tahun, FORMAT(nominal,0) nominal");
		$this->datatables->from("t_cb_temp_shu_total");

		echo $this->datatables->generate();
	}

	public function create()
	{
		$this->MHome->ceklogin();

		$data = [
			'action'   => site_url('SHU/Total/save'),
			'button'   => 'Simpan',
			'id'       => '',
			'tahun'    => '',
			'nominal'  => '',
			'act_back' => site_url('SHU/Total'),
			'Total'    => 'active'
		];

		$this->template->load('Homeadmin/templateadmin', 'SHU/total/form', $data);
	}

	public function edit($id)
	{
		$this->MHome->ceklogin();

		$row = $this->db->get_where('t_cb_temp_shu_total', ['id' => (int)$id])->row_array();
		if (!$row) {
			redirect('SHU/Total');
			return;
		}

		$data = [
			'action'   => site_url('SHU/Total/save'),
			'button'   => 'Update',
			'id'       => (int)$row['id'],
			'tahun'    => (int)$row['tahun'],
			'nominal'  => (float)$row['nominal'],
			'act_back' => site_url('SHU/Total'),
			'Total'    => 'active',
			'arrTahun' => $this->db->query("SELECT tahun from t_cb_temp_shu_total ORDER BY tahun DESC")->result_array()
		];

		$this->template->load('Homeadmin/templateadmin', 'SHU/total/form', $data);
	}

	public function save()
	{
		try {
			$id      = $this->input->post('id');
			$tahun   = $this->input->post('tahun');
			$nominal = $this->input->post('nominal');
			
			$user_id = ($this->session->id ?? 0); // sesuaikan key session
			
			$data['tahun']    = $tahun;
			$data['nominal']  = str_replace(',', '', $nominal);
			$data['user_act'] = $user_id;
			$data['time_act'] = date('Y-m-d H:i:s');

			if(empty($id)){
				
				$this->MSHU->insert($data);

				$this->session->set_flashdata('success', 'Data Berhasil disimpan.');
			
			}else{
				$this->MSHU->update($id,$data);
				$this->session->set_flashdata('success', 'Data Berhasil diupdate.');
			}
		} catch (\Throwable $th) {
			$this->session->set_flashdata('error', $th->getMessage());
		}
		
        redirect('SHU/Total');
	}

	public function ajax_detail()
	{
		if (!$this->input->is_ajax_request()) show_404();

		$tahun   = (int)$this->input->post('tahun');		

		$row = $this->db->get_where('t_cb_temp_shu_total', ['tahun' => (int)$tahun])->row_array();

		$data = [];

		if($row){
			$data = [
				'id' => $row['id'],
				'tahun' => $row['tahun'],
				'nominal' => $row['nominal']
			];
		}
		
		echo json_encode(['status'=>true, 'message'=>'success', 'result' => $data]);
	}

	public function ajax_delete($id)
	{
		if (!$this->input->is_ajax_request()) show_404();

		$id = (int)$id;
		if ($id <= 0) {
			echo json_encode(['ok'=>false,'message'=>'ID tidak valid']);
			return;
		}

		$row = $this->db->get_where('t_cb_temp_shu_total', ['id' => $id])->row_array(); // ganti nama tabel jika beda
		if (!$row) {
			echo json_encode(['ok'=>false,'message'=>'Data tidak ditemukan']);
			return;
		}

		$this->db->trans_begin();
		$this->db->delete('t_cb_temp_shu_total', ['id' => $id]);

		if ($this->db->trans_status() === false) {
			$this->db->trans_rollback();
			echo json_encode(['ok'=>false,'message'=>'Gagal menghapus data']);
			return;
		}
		$this->db->trans_commit();

		echo json_encode(['ok'=>true,'message'=>'Berhasil dihapus']);
	}

}
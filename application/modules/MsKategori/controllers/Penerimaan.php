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

	public function index()
	{
		$data = null;
		$data['MsKategoriPenerimaan'] = 'active';
		$data['act_add'] = base_url().'MsKategori/Penerimaan/create';

		$data['list_tahun_migrasi'] = $this->db
			->select('tahun')
			->from($this->table)
			->group_by('tahun')
			->order_by('tahun', 'ASC')
			->get()
			->result();

		$this->template->load('Homeadmin/templateadmin','MsKategori/penerimaan/list',$data);
	}

	public function getDatatables(){
		header('Content-Type: application/json');

		$tahun = $this->input->post('tahun', true);
		
        $this->datatables->select('id,nama_kategori_penerimaan,tahun');
        $this->datatables->from("ms_cb_kategori_penerimaan");
		if (!empty($tahun)) {
			$this->datatables->where('tahun', $tahun);
		}
        $this->db->order_by('id','asc');
        $this->datatables->add_column('action', '<div class="btn-group">'.anchor(site_url('MsKategori/Penerimaan/update/$1'),'<i title="edit" class="glyphicon glyphicon-edit icon-white"></i>','class="btn btn-xs btn-success"').anchor(site_url('MsKategori/Penerimaan/delete/$1'),'<i title="hapus" class="glyphicon glyphicon-trash icon-white"></i>','class="btn btn-xs btn-danger" onclick="javasciprt: return confirm(\'Apakah anda yakin?\')"').'</div>', 'id');

        echo $this->datatables->generate();
	}

	public function create(){
		$data = array(
			'action'                   => base_url().'MsKategori/Penerimaan/save',
			'button'                   => 'Simpan',
			'nama_kategori_penerimaan' => set_value('nama_kategori_penerimaan'),
			'tahun'                    => set_value('tahun'),
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
			'tahun'                    => set_value('tahun',$kat->tahun),
			'id'                       => set_value('id',$kat->id),
		);
		$data['MsKategoriPenerimaan'] = 'active';
		$this->template->load('Homeadmin/templateadmin','MsKategori/penerimaan/form',$data);
	}

	public function save(){
		$id = $this->input->post('id');
		$data['nama_kategori_penerimaan'] = $this->input->post('nama_kategori_penerimaan');
		$data['tahun']                    = $this->input->post('tahun');

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

	public function migrasi_action()
	{
		$tahun_asal   = $this->input->post('tahun_asal', true);
		$tahun_tujuan = $this->input->post('tahun_tujuan', true);

		if (empty($tahun_asal) || empty($tahun_tujuan)) {
			echo json_encode([
				'status'  => 'error',
				'message' => 'Tahun referensi dan tahun tujuan wajib diisi.'
			]);
			return;
		}

		if ($tahun_asal == $tahun_tujuan) {
			echo json_encode([
				'status'  => 'error',
				'message' => 'Tahun referensi dan tahun tujuan tidak boleh sama.'
			]);
			return;
		}

		$cek_asal = $this->db
			->where('tahun', $tahun_asal)
			->count_all_results($this->table);

		if ($cek_asal == 0) {
			echo json_encode([
				'status'  => 'error',
				'message' => 'Data tahun referensi tidak ditemukan.'
			]);
			return;
		}

		$cek_tujuan = $this->db
			->where('tahun', $tahun_tujuan)
			->count_all_results($this->table);

		if ($cek_tujuan > 0) {
			echo json_encode([
				'status'  => 'error',
				'message' => 'Tahun tujuan '.$tahun_tujuan.' sudah pernah ada. Proses migrasi dibatalkan.'
			]);
			return;
		}

		$data_asal = $this->db
			->select('nama_kategori_penerimaan')
			->from($this->table)
			->where('tahun', $tahun_asal)
			->order_by('id', 'ASC')
			->get()
			->result();

		$insert_data = [];

		foreach ($data_asal as $row) {
			$insert_data[] = [
				'nama_kategori_penerimaan' => $row->nama_kategori_penerimaan,
				'tahun'                    => $tahun_tujuan,
			];
		}

		if (empty($insert_data)) {
			echo json_encode([
				'status'  => 'error',
				'message' => 'Tidak ada data yang bisa dimigrasikan.'
			]);
			return;
		}

		$this->db->trans_begin();

		$this->db->insert_batch($this->table, $insert_data);

		if ($this->db->trans_status() === false) {
			$this->db->trans_rollback();

			echo json_encode([
				'status'  => 'error',
				'message' => 'Migrasi gagal diproses.'
			]);
			return;
		}

		$this->db->trans_commit();

		echo json_encode([
			'status'  => 'success',
			'message' => 'Migrasi berhasil. Data tahun '.$tahun_asal.' berhasil disalin ke tahun '.$tahun_tujuan.'.'
		]);
	}

	public function get_tahun_migrasi()
	{
		header('Content-Type: application/json');

		$tahun = $this->db
			->select('tahun')
			->from($this->table)
			->group_by('tahun')
			->order_by('tahun', 'ASC')
			->get()
			->result();

		echo json_encode([
			'status' => 'success',
			'data'   => $tahun
		]);
	}
}
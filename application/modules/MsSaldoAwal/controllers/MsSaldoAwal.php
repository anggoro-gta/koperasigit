<?php
defined('BASEPATH') or exit('No direct script access allowed');

class MsSaldoAwal extends CI_Controller
{

	function __construct()
	{
		parent::__construct();
		$this->load->library('datatables');
		$this->load->model('MHome');
		$this->load->model('MMsSaldoAwal');
		// $this->load->model('MMscbUseranggota');
		// $this->load->model('MMscbStatuspekerjaan');
	}

	public function index()
	{
		$this->MHome->ceklogin();
		$data = null;
		$data['MsSaldoAwal'] = 'active';
		$this->template->load('Homeadmin/templateadmin', 'MsSaldoAwal/list', $data);
	}

	public function getListDetail()
	{
		$this->MHome->ceklogin();
		$data['act_add'] = base_url() . 'MsSaldoAwal/create';
		$this->load->view('MsSaldoAwal/listDetail', $data);
	}

	public function getDatatables()
	{
		$this->MHome->ceklogin();
		header('Content-Type: application/json');

		$this->datatables->select("
		id,
		tahun,
		anggaran");
		$this->datatables->from("ms_cb_saldo_awal_tahun");
		$this->db->order_by('id', 'asc');
		$this->datatables->add_column('action', '<div class="btn-group">' . anchor(site_url('MsSaldoAwal/update/$1'), '<i title="edit" class="glyphicon glyphicon-edit icon-white"></i>', 'class="btn btn-xs btn-success"') . anchor(site_url('MsSaldoAwal/delete/$1'), '<i title="hapus" class="glyphicon glyphicon-trash icon-white"></i>', 'class="btn btn-xs btn-danger" onclick="javasciprt: return confirm(\'Apakah anda yakin?\')"') . '</div>', 'id');

		echo $this->datatables->generate();
	}

	public function create()
	{
		$this->MHome->ceklogin();
		$data = array(
			'action'   => base_url() . 'MsSaldoAwal/save',
			'button'   => 'Simpan',
			'id'       => set_value('id'),
			'tahun'    => set_value('tahun'),
			'anggaran' => set_value('anggaran'),
		);

		$data['MsSaldoAwal'] = 'active';
		$data['act_back'] = base_url() . 'MsSaldoAwal';
		$this->template->load('Homeadmin/templateadmin', 'MsSaldoAwal/form', $data);
	}

	public function update($id)
	{
		$this->MHome->ceklogin();
		$kat = $this->db->query("SELECT * FROM ms_cb_saldo_awal_tahun WHERE id=$id")->row();

		$data = array(
			'action'   => base_url() . 'MsSaldoAwal/save',
			'button'   => 'Update',
			'id'       => set_value('id', $kat->id),
			'tahun'    => set_value('tahun', $kat->tahun),
			'anggaran' => set_value('anggaran', $kat->anggaran),
		);
		$data['MsSaldoAwal'] = 'active';
		$data['act_back'] = base_url() . 'MsSaldoAwal';
		$this->template->load('Homeadmin/templateadmin', 'MsSaldoAwal/form', $data);
	}

	public function save()
	{
		$this->MHome->ceklogin();
		$id = $this->input->post('id');
		$data['tahun'] = $this->input->post('tahun');
		
		$anggaran = trim($this->input->post('anggaran'));
		$anggaran = str_replace('.', '', $anggaran);
		$anggaran = str_replace(',', '.', $anggaran);
		$data['anggaran'] = $anggaran;

		// print_r($data);die();

		$existsQuery = $this->db->from('ms_cb_saldo_awal_tahun')->where('tahun', $data['tahun']);
		if (!empty($id)) {
			$existsQuery->where('id !=', $id);
		}
		$exists = $existsQuery->get()->row();

		if ($exists) {
			$this->session->set_flashdata('error', 'Tahun sudah pernah diinput.');
			if (empty($id)) {
				redirect('MsSaldoAwal/create');
			} else {
				redirect('MsSaldoAwal/update/' . $id);
			}
			return;
		}
		
		if (empty($id)) {
			$last = $this->db->query("SELECT id FROM ms_cb_saldo_awal_tahun ORDER BY id DESC LIMIT 1")->row();
			$castint = intval($last->id);

			$idnew = $castint + 1;

			$data['id'] = $idnew;

			$this->MMsSaldoAwal->insert($data);

			$this->session->set_flashdata('success', 'Data Berhasil disimpan.');
		} else {
			$this->MMsSaldoAwal->update($id, $data);

			$this->session->set_flashdata('success', 'Data Berhasil diupdate.');
		}
		redirect('MsSaldoAwal');
	}

	public function delete($id)
	{
		$this->MHome->ceklogin();
		$result = $this->MMsSaldoAwal->delete($id);
		if ($result) {
			$this->session->set_flashdata('success', 'Data berhasil dihapus.');
		} else {
			$this->session->set_flashdata('error', 'Data hanya bisa diupdate');
		}

		redirect('MsSaldoAwal');
	}
}
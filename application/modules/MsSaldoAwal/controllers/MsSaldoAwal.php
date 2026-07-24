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

		$tahun_terakhir = $this->_getTahunTerakhir();

		$this->datatables->select("
		id,
		tahun,
		anggaran");
		$this->datatables->from("ms_cb_saldo_awal_tahun");
		$this->db->order_by('id', 'asc');
		$this->datatables->add_column('action', '<div class="btn-group">' . anchor(site_url('MsSaldoAwal/update/$1'), '<i title="edit" class="glyphicon glyphicon-edit icon-white"></i>', 'class="btn btn-xs btn-success"') . anchor(site_url('MsSaldoAwal/delete/$1'), '<i title="hapus" class="glyphicon glyphicon-trash icon-white"></i>', 'class="btn btn-xs btn-danger" onclick="javasciprt: return confirm(\'Apakah anda yakin?\')"') . '</div>', 'id');

		$result = json_decode($this->datatables->generate(), true);

		if (isset($result['data']) && is_array($result['data'])) {
			foreach ($result['data'] as $key => $row) {
				if ((int) $row['tahun'] !== $tahun_terakhir) {
					$result['data'][$key]['action'] = '';
				}
			}
		}

		echo json_encode($result);
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

		if (!$kat || (int) $kat->tahun !== $this->_getTahunTerakhir()) {
			$this->session->set_flashdata('error', 'Hanya tahun terakhir yang bisa diubah.');
			redirect('MsSaldoAwal');
			return;
		}

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

	public function tarikAnggaran()
	{
		$this->MHome->ceklogin();

		$tahun = trim($this->input->post('tahun', true));

		if ($tahun === '' || !ctype_digit($tahun)) {
			return $this->output
				->set_content_type('application/json')
				->set_output(json_encode(array(
					'status' => 'warning',
					'message' => 'Tahun wajib diisi.'
				)));
		}

		$tahun = (int) $tahun;
		$tahun_sumber = $tahun - 1;
		$id = trim($this->input->post('id', true));

		$existsQuery = $this->db
			->from('ms_cb_saldo_awal_tahun')
			->where('tahun', $tahun);

		if ($id !== '' && ctype_digit($id)) {
			$existsQuery->where('id !=', (int) $id);
		}

		$exists = $existsQuery->get()->row();

		if ($exists) {
			return $this->output
				->set_content_type('application/json')
				->set_output(json_encode(array(
					'status' => 'warning',
					'message' => 'Tahun '.$tahun.' sudah ada.',
					'reset_anggaran' => true
				)));
		}

		$saldo_awal = $this->db
			->select('COUNT(*) AS total_data, COALESCE(SUM(anggaran), 0) AS total', false)
			->from('ms_cb_saldo_awal_tahun')
			->where('tahun', $tahun_sumber)
			->get()
			->row();

		if (!$saldo_awal || (int) $saldo_awal->total_data === 0) {
			return $this->output
				->set_content_type('application/json')
				->set_output(json_encode(array(
					'status' => 'warning',
					'message' => 'Saldo awal tahun '.$tahun_sumber.' wajib ada terlebih dahulu.'
				)));
		}

		$total_penerimaan = $this->_sumPenerimaanTahun($tahun_sumber);
		$total_pengeluaran = $this->_sumPengeluaranTahun($tahun_sumber);
		$anggaran = (float) $saldo_awal->total + $total_penerimaan - $total_pengeluaran;

		return $this->output
			->set_content_type('application/json')
			->set_output(json_encode(array(
				'status' => 'success',
				'message' => 'Anggaran berhasil ditarik dari saldo akhir tahun '.$tahun_sumber.'.',
				'anggaran' => $anggaran,
				'anggaran_format' => number_format($anggaran, 2, ',', '.'),
				'tahun_sumber' => $tahun_sumber,
				'total_penerimaan' => $total_penerimaan,
				'total_pengeluaran' => $total_pengeluaran
			)));
	}

	private function _sumPenerimaanTahun($tahun)
	{
		if (!$this->db->table_exists('t_cb_bku_penerimaan')) {
			return 0;
		}

		$row = $this->db
			->select("
				COALESCE(SUM(
					COALESCE(angsuran_pokok, 0) +
					COALESCE(angsuran_bunga, 0) +
					COALESCE(simpanan_pokok, 0) +
					COALESCE(simpanan_wajib, 0) +
					COALESCE(simpanan_tapim, 0) +
					COALESCE(simpanan_sukarela, 0) +
					COALESCE(angsuran_barang, 0) +
					COALESCE(penjualan_tunai, 0) +
					COALESCE(bank, 0) +
					COALESCE(foto_copy, 0) +
					COALESCE(shu_pkpri, 0) +
					COALESCE(barang_titipan, 0)
				), 0) AS total
			", false)
			->from('t_cb_bku_penerimaan')
			->where('tahun', $tahun)
			->get()
			->row();

		return $row ? (float) $row->total : 0;
	}

	private function _sumPengeluaranTahun($tahun)
	{
		if (!$this->db->table_exists('t_cb_bku_pengeluaran')) {
			return 0;
		}

		$row = $this->db
			->select("
				COALESCE(SUM(
					COALESCE(simpanan_pokok, 0) +
					COALESCE(simpanan_wajib, 0) +
					COALESCE(simpanan_tapim, 0) +
					COALESCE(simpanan_sukarela, 0) +
					COALESCE(dana_sosial, 0) +
					COALESCE(biaya, 0) +
					COALESCE(kredit_uang, 0) +
					COALESCE(barang, 0) +
					COALESCE(pajak, 0) +
					COALESCE(dana_pendidikan, 0) +
					COALESCE(shu, 0) +
					COALESCE(inventaris_kantor, 0) +
					COALESCE(cadangan_pemb_usaha, 0)
				), 0) AS total
			", false)
			->from('t_cb_bku_pengeluaran')
			->where('tahun', $tahun)
			->get()
			->row();

		return $row ? (float) $row->total : 0;
	}

	private function _getTahunTerakhir()
	{
		$row = $this->db
			->select_max('tahun')
			->get('ms_cb_saldo_awal_tahun')
			->row();

		return $row ? (int) $row->tahun : 0;
	}

	public function delete($id)
	{
		$this->MHome->ceklogin();
		$kat = $this->db
			->select('tahun')
			->where('id', $id)
			->get('ms_cb_saldo_awal_tahun')
			->row();

		if (!$kat || (int) $kat->tahun !== $this->_getTahunTerakhir()) {
			$this->session->set_flashdata('error', 'Hanya tahun terakhir yang bisa dihapus.');
			redirect('MsSaldoAwal');
			return;
		}

		$result = $this->MMsSaldoAwal->delete($id);
		if ($result) {
			$this->session->set_flashdata('success', 'Data berhasil dihapus.');
		} else {
			$this->session->set_flashdata('error', 'Data hanya bisa diupdate');
		}

		redirect('MsSaldoAwal');
	}
}

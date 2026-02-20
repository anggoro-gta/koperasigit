<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Opd extends CI_Controller
{

	function __construct()
	{
		parent::__construct();
		$this->load->library('datatables');
		$this->load->model('MHome');
		$this->load->model('MMscbUseranggota');
		$this->load->model('MMscbSkpd');
		$this->load->model('MSHU');
	}

	public function index()
	{
		$this->MHome->ceklogin();
		$data = null;
		$data['Opd'] = 'active';
		$data['arrSkpd'] = $this->MMscbSkpd->get();
		// $data['arrcabang'] = $this->MMsCabang->get();
		$this->template->load('Homeadmin/templateadmin', 'SHU/opd/list', $data);
	}
	public function getListDetail()
	{
		$this->MHome->ceklogin();
		$data['skpd'] = $this->input->post('skpd');
		$data['arrSkpd'] = $this->MMscbSkpd->get();

		$this->load->view('SHU/opd/listDetail', $data);
	}

	public function getDatatables()
	{
		$this->MHome->ceklogin();
		header('Content-Type: application/json');

		$skpd = $this->input->post('skpd');

		if ($skpd != '') {
			$this->datatables->where('fk_skpd_id', $skpd);
		}

		$this->datatables->select("a.id,a.tahun,a.status_posting,b.nama_skpd");
		$this->datatables->from("t_cb_temp_shu_opd a");
		$this->datatables->join("ms_cb_skpd b", "a.fk_skpd_id=b.id");
				
		$this->db->order_by("a.tahun desc");
		$this->db->order_by("a.status_posting asc");

		echo $this->datatables->generate();
	}

	public function create()
	{
		$this->MHome->ceklogin();
		// $skpd = $this->db->query("select * from ms_cb_skpd")->result_array();
		$data = array(
			'action'     => base_url() . 'SHU/Opd/save',
			'button'     => 'Submit',
			'id'         => set_value('id'),
			'fk_skpd_id' => set_value('fk_skpd_id'),
			'tahun'      => set_value('tahun'),
			'arrSKPD'    => [],
			'disable'    => '',
			'method'     => 'POST'
		);

		$data['Opd'] = 'active';
		$data['act_back'] = base_url() . 'SHU/Opd';
		$data['arrUserAnggota'] = $this->MMscbUseranggota->get();
		$this->template->load('Homeadmin/templateadmin', 'SHU/opd/form', $data);
	}
	
	function getData($id = null)
	{
		$fk_skpd_id = $this->input->post('fk_skpd_id');
		
		if ($id) {
			$detail = $this->db->query("select a.id, a.nama, a.nip, b.fk_anggota_id, b.fk_shu_opd_id, b.nominal
			from ms_cb_user_anggota a
			left join t_cb_temp_shu_opd_detail b on a.id=b.fk_anggota_id and b.fk_shu_opd_id=?
			where a.fk_id_skpd=? ORDER BY a.id asc",  [$id, $fk_skpd_id])->result();
			
			$readonly = true;
			$status_posting = $this->db->query("select * from t_cb_temp_shu_opd where id = ? ", [$id])->row()->status_posting;
		} else {
			$detail = $this->db->query("SELECT id,nama,nip FROM ms_cb_user_anggota where fk_id_skpd = ? AND status_keaktifan='Aktif'",  [$fk_skpd_id])->result();
			$readonly = false;
			$status_posting = 0;
		}
		$data = [
			'status_posting' => $status_posting,
			'detail' => $detail,
			'readonly' => $readonly
		];
		// print_r($data);die();
		$this->load->view('SHU/opd/_form', $data);
	}

	public function save()
	{
		$this->MHome->ceklogin();
		$this->db->trans_start();

		$shuOpdId   = $this->input->post('id') ?? '';
		$tahun      = $this->input->post('tahun');
		$fk_skpd_id = $this->input->post('fk_skpd_id');
		$nominalArr = $this->input->post('nominal'); // array [anggota_id => nominal]

		$data = [
			'user_act' => $this->session->id,
			'time_act' => date('Y-m-d H:i:s'),
		];

		if ($shuOpdId) {
			$this->MSHU->update_opd($shuOpdId, $data);

			// IMPORTANT: hapus dulu detail lama
			// $this->MSHU->delete_opd_detail_by_opd($shuOpdId);
		} else {
			$data['fk_skpd_id'] = $fk_skpd_id;
			$data['tahun']      = $tahun;

			$this->MSHU->insert_opd($data);
			$shuOpdId = $this->db->insert_id();
		}

		// rebuild detail
		$dataDetail = [];
		if (is_array($nominalArr)) {
			foreach ($nominalArr as $anggota_id => $val) {
				// kalau format rupiah pakai titik/koma -> ambil digit saja
				$nominal = preg_replace('/\D/', '', (string)$val);

				// optional: skip kalau kosong
				if ($nominal === '') continue;

				$dataDetail[] = [
					'fk_shu_opd_id' => $shuOpdId,
					'fk_anggota_id' => $anggota_id,
					'nominal'       => $nominal,
				];
			}
		}

		if (!empty($dataDetail)) {
			// $this->MSHU->insert_opd_detail_batch($dataDetail);
			$this->MSHU->upsert_opd_detail_batch($dataDetail);
		}

		$this->db->trans_complete();

		$this->session->set_flashdata(
			$this->db->trans_status() ? 'success' : 'error',
			$this->db->trans_status() ? 'Data Berhasil disimpan.' : 'Data Gagal disimpan.'
		);

		redirect('SHU/Opd');
	}

	public function edit($id)
	{
		$this->MHome->ceklogin();
		$detail = $this->db->query("select * from t_cb_temp_shu_opd where id = ? ", [$id])->row();
		$skpd = $this->db->query("select * from ms_cb_skpd where id=?", [$detail->fk_skpd_id])->result_array();
		$label_posting =  $detail->status_posting == 1 ? 'Batal Posting' : 'Posting';
		$data = array(
			'action'        => base_url() . 'SHU/Opd/save',
			'button'        => 'Submit',
			'id'            => set_value('id', $id),
			'fk_skpd_id'    => set_value('fk_skpd_id', $detail->fk_skpd_id),
			'label_posting' => set_value('label_posting', $label_posting),
			'tahun'         => set_value('tahun', $detail->tahun),
			'arrSKPD'       => $skpd,
			'disable'       => 'disabled',
			'method'        => 'PUT'
		);

		$data['Opd'] = 'active';
		$data['act_back'] = base_url() . 'SHU/Opd';
				
		$this->template->load('Homeadmin/templateadmin', 'SHU/opd/form', $data);
	}

	public function detail($id)
	{
		$this->MHome->ceklogin();
		$skpd = $this->db->query("select * from ms_cb_skpd")->result_array();
		$detail = $this->db->query("select * from t_cb_temp_shu_opd where id = ? ", [$id])->row();
		$label_posting =  $detail->status_posting == 1 ? 'Batal Posting' : 'Posting';
		$data = array(
			'action'        => base_url() . 'SHU/Opd/save',
			'button'        => 'Submit',
			'id'            => set_value('id', $id),
			'fk_skpd_id'    => set_value('fk_skpd_id', $detail->fk_skpd_id),
			'label_posting' => set_value('label_posting', $label_posting),
			'tahun'         => set_value('tahun', $detail->tahun),
			'nominal'       => set_value('nominal'),
			'arrSKPD'       => $skpd,
			'disable'       => 'disabled',
			'method'        => 'PUT'
		);

		$data['Opd'] = 'active';
		$data['act_back'] = base_url() . 'SHU/Opd';
		// print_r($data['arrUserAnggota']);die();
		$this->template->load('Homeadmin/templateadmin', 'SHU/opd/form', $data);
	}
	
	function posting($id)
	{
		$row = $this->db->query("select * from t_cb_temp_shu_opd where id = ? ", [$id])->row();
		$status = $row->status_posting == 1 ? 0 : 1;
		$msg = $row->status_posting == 1 ? 'Berhasil Batal Posting' : 'Berhasil Posting';
		$this->db->query("update  t_cb_temp_shu_opd set status_posting = ? where id =? ", [$status, $id]);
		$this->session->set_flashdata('success', $msg);
		redirect('SHU/Opd');
	}

	public function getSkpd()
	{
		if (!$this->input->is_ajax_request()) show_404();

		$tahun = $this->input->post('tahun');		

		$q = $this->db->query("SELECT s.*
			FROM ms_cb_skpd s
			WHERE NOT EXISTS (
				SELECT 1
				FROM t_cb_temp_shu_opd t
				WHERE t.fk_skpd_id = s.id
				AND t.tahun = ?
			)
		", [$tahun])->result_array();

		$data = [];

		foreach ($q as $item) {
			array_push($data, array(
					'id' => $item['id'],
					'nama_skpd' => $item['nama_skpd']
				)
			);
		}
		echo json_encode(['status'=>true, 'message'=>'success', 'result' => $data]);
	}
}
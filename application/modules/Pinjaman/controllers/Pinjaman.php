<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Pinjaman extends CI_Controller
{

	function __construct()
	{
		parent::__construct();
		$this->load->library('datatables');
		$this->load->model('MHome');
		$this->load->model('MMscbUseranggota');
		$this->load->model('MMscbSkpd');
		$this->load->model('MMscbStatuspekerjaan');
		$this->load->model('MSimpanan');
		// $this->load->model('MMsCabang');
	}

	public function index()
	{
		$this->MHome->ceklogin();
		$data = null;
		$data['Pinjaman'] = 'active';
		$data['arrSkpd'] = $this->MMscbSkpd->get();
		$this->template->load('Homeadmin/templateadmin', 'Pinjaman/list', $data);
	}

	public function getListDetail()
	{
		$this->MHome->ceklogin();
		$data['act_add'] = base_url() . 'Pinjaman/create';
		$data['skpd'] = $this->input->post('skpd');
		// $data['tgl_dari'] = $this->input->post('tgl_dari');
		// $data['tgl_sampai'] = $this->input->post('tgl_sampai');
		$data['arrSkpd'] = $this->MMscbSkpd->get();

		$this->load->view('Pinjaman/listDetail', $data);
	}

	public function getDatatables()
	{
		$this->MHome->ceklogin();
		header('Content-Type: application/json');

		$skpd = $this->input->post('skpd');
		// $tgl_dari = $this->input->post('tgl_dari');
		// $tgl_sampai = $this->input->post('tgl_sampai');

		if ($skpd != '') {
			$this->datatables->where('fk_id_skpd', $skpd);
		}

		// if ($tgl_dari != '') {
		// 	$this->datatables->where("p.tgl >=", $this->help->ReverseTgl($tgl_dari));
		// 	$this->datatables->where("p.tgl <=", $this->help->ReverseTgl($tgl_sampai));
		// }

		$this->datatables->select("pj.id,pj.fk_anggota_id,pj.tgl,pj.jml_angsuran,pj.nilai,pj.kategori,pj.status,an.nama");
		$this->datatables->from("t_cb_pinjaman pj");
		$this->datatables->join('ms_cb_user_anggota an', 'pj.fk_anggota_id=an.id', 'inner');
		$this->datatables->add_column('action', '<div class="btn-group">' . anchor(site_url('MscbAnggota/update/$1'), '<i title="detail" class="glyphicon glyphicon-share-alt icon-white"></i>', 'class="btn btn-xs btn-success"') . '</div>', 'id');

		echo $this->datatables->generate();
	}

	public function create()
	{
		$this->MHome->ceklogin();
		$data = array(
			'action' => base_url() . 'Simpanan/save',
			'button' => 'Simpan',
			'id' => set_value('id'),
			'fk_anggota_id' => set_value('fk_anggota_id'),
			'tgl' => set_value('tgl'),
			'wajib' => set_value('wajib'),
			'sukarela' => set_value('sukarela'),
		);

		$data['Simpanan'] = 'active';
		$data['act_back'] = base_url() . 'Simpanan';
		$data['arrUserAnggota'] = $this->MMscbUseranggota->get();
		$this->template->load('Homeadmin/templateadmin', 'Simpanan/form', $data);
	}

	public function save()
	{
		$this->MHome->ceklogin();

		$id_anggota = $this->input->post('fk_anggota_id');

		$getskpd = $this->db->query("SELECT fk_id_skpd FROM ms_cb_user_anggota where id = '$id_anggota'")->row();

		$data['fk_anggota_id'] = $id_anggota;
		$data['fk_skpd_id'] = $getskpd->fk_id_skpd;
		$data['tgl'] = $this->help->ReverseTgl($this->input->post('tgl'));
		$data['wajib'] = str_replace(',', '', $this->input->post('wajib'));
		$data['sukarela'] = str_replace(',', '', $this->input->post('sukarela'));

		$this->MSimpanan->insert($data);
		$this->session->set_flashdata('success', 'Data Berhasil disimpan.');

		redirect('Simpanan');
	}

	public function saveUpload()
	{
		$this->MHome->ceklogin();
		$fk_id_skpd = $this->input->post('fk_id_skpd');
		$tgl = $this->help->ReverseTgl($this->input->post('tgl'));
		if (isset($_FILES["fileExcel"]["name"])) {
			$path = $_FILES["fileExcel"]["tmp_name"];
			$object = PHPExcel_IOFactory::load($path);

			foreach ($object->getWorksheetIterator() as $worksheet) {
				$highestRow = $worksheet->getHighestRow();
				$highestColumn = $worksheet->getHighestColumn();
				for ($row = 2; $row <= $highestRow; $row++) {
					$id_anggota = $worksheet->getCellByColumnAndRow(1, $row)->getValue();
					if ($id_anggota != '') {
						$wajib = $worksheet->getCellByColumnAndRow(2, $row)->getValue();
						$sukarela = $worksheet->getCellByColumnAndRow(3, $row)->getValue();

						$temp_data[] = array(
							'fk_anggota_id' => $id_anggota,
							'fk_skpd_id' => $fk_id_skpd,
							'tgl' => $tgl,
							'wajib'	=> $wajib,
							'sukarela'	=> $sukarela,
							'user_act' => $this->session->id
						);
					}
				}

				$insert = $this->db->insert_batch('t_cb_simpanan', $temp_data);
				if ($insert) {
					$this->session->set_flashdata('success', 'file berhasil diupload');
				} else {
					$this->session->set_flashdata('error', 'file gagal diupload.');
				}
			}
		} else {
			$this->session->set_flashdata('error', 'Tidak ada file yang masuk.');
		}

		redirect('Simpanan');
	}

	public function detail($id)
	{
		$que = "SELECT s.*,mk.nama_skpd FROM t_cb_simpanan s INNER JOIN ms_cb_skpd mk ON mk.id=s.fk_skpd_id WHERE fk_anggota_id='$id'";
		$data['hasil'] = $this->db->query($que)->result();

		$this->template->load('Home/template', 'Simpanan/viewRiwayat', $data);
	}
}

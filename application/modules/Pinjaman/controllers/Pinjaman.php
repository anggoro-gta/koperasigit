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
		$this->load->model('MMscbKategoripinjam');
		$this->load->model('McbPinjaman');
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
			$this->datatables->where('us.fk_id_skpd', $skpd);
		}

		// if ($tgl_dari != '') {
		// 	$this->datatables->where("p.tgl >=", $this->help->ReverseTgl($tgl_dari));
		// 	$this->datatables->where("p.tgl <=", $this->help->ReverseTgl($tgl_sampai));
		// }

		$this->datatables->select("pj.id,us.nama,us.fk_id_skpd,DATE_FORMAT(pj.tgl,'%d-%m-%Y')tgl,FORMAT(pj.pinjaman,0) pinjaman,pj.jml_angsuran,pj.tenor,FORMAT(pj.pokok,0) pokok,FORMAT(pj.tapim,0) tapim,FORMAT(pj.bunga,0) bunga,FORMAT(pj.jml_tagihan,0) jml_tagihan,ka.kategori,CASE pj.status WHEN 1 THEN 'Sudah' ELSE 'Belum' END as status");
		$this->datatables->from("t_cb_pinjaman pj");
		$this->datatables->join('ms_cb_user_anggota us', 'pj.fk_anggota_id = us.id', 'inner');
		$this->datatables->join('ms_cb_kategori_pinjam ka', 'pj.fk_kategori_id = ka.id', 'inner');
		$this->datatables->add_column('action', '<div class="btn-group">' . anchor(site_url('MscbAnggota/update/$1'), '<i title="detail" class="glyphicon glyphicon-share-alt icon-white"></i>', 'class="btn btn-xs btn-success"') . '</div>', 'id');

		echo $this->datatables->generate();
	}

	public function create()
	{
		$this->MHome->ceklogin();
		$data = array(
			'action' => base_url() . 'Pinjaman/save',
			'button' => 'Simpan',
			'id' => set_value('id'),
			'nilaibunga' => set_value('nilaibunga'),
			'fk_anggota_id' => set_value('fk_anggota_id'),
			'fk_kategori_id' => set_value('fk_kategori_id'),
			'tgl_mulai_hutang' => set_value('tgl_mulai_hutang'),
			'jml_pinjam' => set_value('jml_pinjam'),
			'tenor' => set_value('tenor'),
			'bulat_pinjam' => set_value('bulat_pinjam'),
			'pokok' => set_value('pokok'),
			'tapim' => set_value('tapim'),
			'bunga' => set_value('bunga'),
			'jml_tagihan' => set_value('jml_tagihan'),
		);

		$data['Pinjaman'] = 'active';
		$data['act_back'] = base_url() . 'Pinjaman';
		$data['arrUserAnggota'] = $this->db->query("SELECT a.id,a.nama,s.nama_skpd FROM ms_cb_user_anggota a INNER JOIN ms_cb_skpd s ON s.id=a.fk_id_skpd")->result_array();
		$data['arrKategori'] = $this->MMscbKategoripinjam->get();
		$this->template->load('Homeadmin/templateadmin', 'Pinjaman/form', $data);
	}

	public function save()
	{
		$this->MHome->ceklogin();

		$id_anggota = $this->input->post('fk_anggota_id');

		$data['fk_kategori_id'] = $this->input->post('fk_kategori_id');
		$data['fk_anggota_id'] = $id_anggota;
		$data['tgl'] = $this->help->ReverseTgl($this->input->post('tgl_mulai_hutang'));
		$data['tenor'] = $this->input->post('tenor');
		$data['pinjaman'] = str_replace(",", "", $this->input->post('bulat_pinjam'));
		$data['pokok'] = str_replace(",", "", $this->input->post('pokok'));
		$data['tapim'] = str_replace(",", "", $this->input->post('tapim'));
		$data['bunga'] = str_replace(",", "", $this->input->post('bunga'));
		$data['jml_tagihan'] = str_replace(",", "", $this->input->post('bunga'));
		$data['status'] = 0;

		$get_hutang = $this->db->query("SELECT * FROM t_cb_pinjaman where id = '$id_anggota'")->row();

		if ($get_hutang == NULL) {
			$this->McbPinjaman->insert($data);
			$this->session->set_flashdata('success', 'Data Berhasil disimpan.');
		} else {
			$this->session->set_flashdata('error', 'Sudah ada data pinjaman mohon cek data pinjaman');
		}
		redirect('Pinjaman');
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

	public function cariBunga()
	{
		$idkategori = $this->input->post('idkategori');
		$hsl = $this->MMscbKategoripinjam->get(array('id' => $idkategori));
		$hsl = $hsl[0];

		$data['bunga'] = $hsl['bunga'];
		// $data['nominal'] = number_format($hsl['nominal']);
		// $data['fee_terapis'] = number_format($hsl['fee_terapis']);

		echo json_encode($data);
	}
}

<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Penarikan extends CI_Controller
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
	}

	public function index()
	{
		$this->MHome->ceklogin();
		$data = null;
		$data['Penarikan'] = 'active';
		$data['arrSkpd'] = $this->MMscbSkpd->get();
		$this->template->load('Homeadmin/templateadmin', 'Penarikan/list', $data);
	}

	public function getListDetail()
	{
		$this->MHome->ceklogin();
		$data['act_add'] = base_url() . 'Penarikan/create';
		$data['skpd'] = $this->input->post('skpd');
		$data['arrSkpd'] = $this->MMscbSkpd->get();

		$this->load->view('Penarikan/listDetail', $data);
	}

	public function getDatatables()
	{
		$this->MHome->ceklogin();
		header('Content-Type: application/json');

		$skpd = $this->input->post('skpd');
		
		if ($skpd != '') {
			$this->datatables->where('us.fk_id_skpd', $skpd);
		}

		$this->datatables->select("tcp.id,us.nama,us.fk_id_skpd,DATE_FORMAT(tcp.tgl_penarikan,'%d-%m-%Y')tgl,FORMAT(tcp.jumlah_penarikan,0) jumlah");
		$this->datatables->from("t_cb_penarikan tcp");
		$this->datatables->join('ms_cb_user_anggota us', 'tcp.fk_anggota_id = us.id', 'left');

		echo $this->datatables->generate();
	}

	public function create()
	{
		$this->MHome->ceklogin();

		$data = [
			'action'          => site_url('Penarikan/ajax_save'),
			'button'          => 'Simpan',
			'id'              => 0,
			'fk_anggota_id'   => '',
			'tgl_penarikan'   => date('Y-m-d'),
			'jumlah_penarikan'=> 0,
			'act_back'        => site_url('Penarikan'),
			'Penarikan'       => 'active',
			'arrUserAnggota'  => $this->db->query("
				SELECT a.id, a.nama, s.nama_skpd
				FROM ms_cb_user_anggota a
				INNER JOIN ms_cb_skpd s ON s.id = a.fk_id_skpd
			")->result_array()
		];

		$this->template->load('Homeadmin/templateadmin', 'Penarikan/form', $data);
	}

	public function edit($id)
	{
		$this->MHome->ceklogin();

		$row = $this->db->get_where('t_cb_penarikan', ['id' => (int)$id])->row_array();
		if (!$row) {
			redirect('Penarikan');
			return;
		}

		$data = [
			'action'          => site_url('Penarikan/ajax_save'),
			'button'          => 'Update',
			'id'              => (int)$row['id'],
			'fk_anggota_id'   => (int)$row['fk_anggota_id'],
			'tgl_penarikan'   => $row['tgl_penarikan'],
			'jumlah_penarikan'=> (float)$row['jumlah_penarikan'],
			'act_back'        => site_url('Penarikan'),
			'Penarikan'       => 'active',
			'arrUserAnggota'  => $this->db->query("
				SELECT a.id, a.nama, s.nama_skpd
				FROM ms_cb_user_anggota a
				INNER JOIN ms_cb_skpd s ON s.id = a.fk_id_skpd
			")->result_array()
		];

		$this->template->load('Homeadmin/templateadmin', 'Penarikan/form', $data);
	}

	public function ajax_detail()
	{
		if (!$this->input->is_ajax_request()) show_404();

		$anggota_id = (int) $this->input->post('fk_anggota_id');
		if ($anggota_id <= 0) {
			echo json_encode(['ok' => false, 'message' => 'Anggota tidak valid']);
			return;
		}

		// SIMPANAN
		$q_pokok = $this->db->query(
			"SELECT simpanan_pokok AS jumlah FROM ms_cb_user_anggota WHERE id = ? LIMIT 1",
			[$anggota_id]
		)->row_array();

		$q_wajib = $this->db->query(
			"SELECT SUM(jumlah) AS jumlah FROM (
				SELECT simpanan_wajib AS jumlah FROM ms_cb_user_anggota WHERE id = ?
				UNION ALL
				SELECT COALESCE(SUM(wajib),0) AS jumlah FROM t_cb_tagihan_simpanan WHERE fk_anggota_id = ?
			) a",
			[$anggota_id, $anggota_id]
		)->row_array();

		$q_tapim = $this->db->query(
			"SELECT COALESCE(SUM(tcp.jml_angsuran * tcp.tapim),0) AS jumlah
			FROM t_cb_pinjaman tcp
			WHERE tcp.fk_anggota_id = ?",
			[$anggota_id]
		)->row_array();

		$q_sukarela = $this->db->query(
			"SELECT COALESCE(SUM(sukarela),0) AS jumlah
			FROM t_cb_tagihan_simpanan
			WHERE fk_anggota_id = ?",
			[$anggota_id]
		)->row_array();

		$simpanan = [
			'pokok'    => (float)($q_pokok['jumlah'] ?? 0),
			'wajib'    => (float)($q_wajib['jumlah'] ?? 0),
			'tapim'    => (float)($q_tapim['jumlah'] ?? 0),
			'sukarela' => (float)($q_sukarela['jumlah'] ?? 0),
		];

		$total_simpanan = $simpanan['pokok'] + $simpanan['wajib'] + $simpanan['tapim'] + $simpanan['sukarela'];

		// TANGGUNGAN (3 kategori)
		$pinjaman_uang = $this->db->query(
			"SELECT pokok, bunga, tenor, jml_angsuran, (tenor - jml_angsuran) AS sisa_angsuran
			FROM t_cb_pinjaman
			WHERE fk_anggota_id = ? AND fk_kategori_id = 1",
			[$anggota_id]
		)->result_array();

		$pinjaman_barang = $this->db->query(
			"SELECT pokok, bunga, tenor, jml_angsuran, (tenor - jml_angsuran) AS sisa_angsuran
			FROM t_cb_pinjaman
			WHERE fk_anggota_id = ? AND fk_kategori_id = 2",
			[$anggota_id]
		)->result_array();

		$pinjaman_palen = $this->db->query(
			"SELECT pokok, bunga, tenor, jml_angsuran, (tenor - jml_angsuran) AS sisa_angsuran
			FROM t_cb_pinjaman
			WHERE fk_anggota_id = ? AND fk_kategori_id = 3",
			[$anggota_id]
		)->result_array();

		// hitung total tanggungan + siapkan data yang siap render
		$calc = function($rows) {
			$out = [];
			$total = 0;
			foreach ($rows as $r) {
				$sisa = (int)$r['sisa_angsuran'];
				if ($sisa <= 0) continue;

				$pokok = (float)$r['pokok'];
				$bunga = (float)$r['bunga'];
				$row_total = ($pokok + $bunga) * $sisa;

				$total += $row_total;
				$out[] = [
					'pokok' => $pokok,
					'bunga' => $bunga,
					'sisa_angsuran' => $sisa,
					'total' => $row_total
				];
			}
			return [$out, $total];
		};

		[$uang_rows, $total_uang] = $calc($pinjaman_uang);
		[$barang_rows, $total_barang] = $calc($pinjaman_barang);
		[$palen_rows, $total_palen] = $calc($pinjaman_palen);

		$total_tanggungan = $total_uang + $total_barang + $total_palen;
		$jumlah_akhir = $total_simpanan - $total_tanggungan;

		echo json_encode([
			'ok' => true,
			'simpanan' => $simpanan,
			'total_simpanan' => $total_simpanan,
			'tanggungan' => [
				'uang' => $uang_rows,
				'barang' => $barang_rows,
				'palen' => $palen_rows,
			],
			'total_tanggungan' => $total_tanggungan,
			'jumlah_akhir' => $jumlah_akhir,
			'can_withdraw' => ($jumlah_akhir > 0)
		]);
	}

	public function ajax_save()
	{
		if (!$this->input->is_ajax_request()) show_404();

		$id         = (int)$this->input->post('id');
		$anggota_id = (int)$this->input->post('fk_anggota_id');
		$tgl        = trim((string)$this->input->post('tanggal_penarikan'));
		$nominal    = (float)$this->input->post('nominal_penarikan');

		if ($anggota_id <= 0) {
			echo json_encode(['ok'=>false,'message'=>'Anggota wajib dipilih']); return;
		}
		if ($tgl === '') {
			echo json_encode(['ok'=>false,'message'=>'Tanggal penarikan wajib diisi']); return;
		}
		if ($nominal <= 0) {
			echo json_encode(['ok'=>false,'message'=>'Nominal penarikan harus > 0']); return;
		}

		$user_id = (int)($this->session->id ?? 0); // sesuaikan key session

		$data = [
			'fk_anggota_id'    => $anggota_id,
			'tgl_penarikan'    => $tgl,
			'jumlah_penarikan' => $nominal,
			'user_act'         => $user_id,
			'time_act'         => date('Y-m-d H:i:s'),
		];

		$this->db->trans_begin();

		if ($id > 0) {
			$this->db->where('id', $id)->update('t_cb_penarikan', $data);
		} else {
			$this->db->insert('t_cb_penarikan', $data);
			$id = $this->db->insert_id();
		}

		if ($this->db->trans_status() === false) {
			$this->db->trans_rollback();
			echo json_encode(['ok'=>false,'message'=>'Gagal menyimpan data']);
			return;
		}

		$this->db->trans_commit();

		echo json_encode([
			'ok' => true,
			'message' => ($this->input->post('id') ? 'Berhasil update' : 'Berhasil simpan'),
			'redirect_url' => site_url('Penarikan')
		]);
	}

	public function ajax_delete($id)
	{
		if (!$this->input->is_ajax_request()) show_404();

		$id = (int)$id;
		if ($id <= 0) {
			echo json_encode(['ok'=>false,'message'=>'ID tidak valid']);
			return;
		}

		$row = $this->db->get_where('t_cb_penarikan', ['id' => $id])->row_array(); // ganti nama tabel jika beda
		if (!$row) {
			echo json_encode(['ok'=>false,'message'=>'Data tidak ditemukan']);
			return;
		}

		$this->db->trans_begin();
		$this->db->delete('t_cb_penarikan', ['id' => $id]);

		if ($this->db->trans_status() === false) {
			$this->db->trans_rollback();
			echo json_encode(['ok'=>false,'message'=>'Gagal menghapus data']);
			return;
		}
		$this->db->trans_commit();

		echo json_encode(['ok'=>true,'message'=>'Berhasil dihapus']);
	}

}
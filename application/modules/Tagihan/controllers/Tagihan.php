<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Tagihan extends CI_Controller
{

	function __construct()
	{
		parent::__construct();
		$this->load->library('datatables');
		$this->load->model('MHome');
		$this->load->model('MMscbUseranggota');
		$this->load->model('MMscbSkpd');
		$this->load->model('MMscbStatuspekerjaan');
		$this->load->model('MTagihan');
		$this->load->model('MTagihanSimpanan');
		$this->load->model('MTagihanPinjaman');
		// $this->load->model('MMsCabang');
	}

	public function index()
	{
		$this->MHome->ceklogin();
		$data = null;
		$data['Tagihan'] = 'active';
		$data['arrSkpd'] = $this->MMscbSkpd->get();
		// $data['arrcabang'] = $this->MMsCabang->get();
		$this->template->load('Homeadmin/templateadmin', 'Tagihan/list', $data);
	}

	public function getListDetail()
	{
		$this->MHome->ceklogin();
		$data['act_add'] = base_url() . 'Simpanan/create';
		$data['skpd'] = $this->input->post('skpd');
		// $data['tgl_dari'] = $this->input->post('tgl_dari');
		// $data['tgl_sampai'] = $this->input->post('tgl_sampai');
		$data['arrSkpd'] = $this->MMscbSkpd->get();

		$this->load->view('Tagihan/listDetail', $data);
	}

	public function getDatatables()
	{
		$this->MHome->ceklogin();
		header('Content-Type: application/json');

		$skpd = $this->input->post('skpd');
		// $tgl_dari = $this->input->post('tgl_dari');
		// $tgl_sampai = $this->input->post('tgl_sampai');

		if ($skpd != '') {
			$this->datatables->where('fk_skpd_id', $skpd);
		}

		// if ($tgl_dari != '') {
		// 	$this->datatables->where("p.tgl >=", $this->help->ReverseTgl($tgl_dari));
		// 	$this->datatables->where("p.tgl <=", $this->help->ReverseTgl($tgl_sampai));
		// }

		$this->datatables->select("t.*,nama_skpd,CONCAT(bulan, ' ', tahun) AS periode");
		$this->datatables->from("t_cb_tagihan t");
		$this->datatables->join("ms_cb_skpd skpd", "t.fk_skpd_id=skpd.id");
		// $this->datatables->add_column('action', '<div class="btn-group">' . anchor(site_url('MscbAnggota/update/$1'), '<i title="detail" class="glyphicon glyphicon-share-alt icon-white"></i>', 'class="btn btn-xs btn-success"') . '</div>', 'id');

		echo $this->datatables->generate();
	}

	public function create_kolektif()
	{
		$this->MHome->ceklogin();
		$skpd = $this->db->query("select * from ms_cb_skpd")->result_array();
		$data = array(
			'action' => base_url() . 'Tagihan/save_kolektif',
			'button' => 'Buat Tagihan',
			'id' => set_value('id'),
			'fk_skpd_id' => set_value('fk_skpd_id'),
			'periode' => set_value('periode'),
			'wajib' => set_value('wajib'),
			'sukarela' => set_value('sukarela'),
			'arrSKPD' => $skpd,
			'method' => 'POST'
		);

		$data['Tagihan'] = 'active';
		$data['act_back'] = base_url() . 'Tagihan';
		$data['arrUserAnggota'] = $this->MMscbUseranggota->get();
		$this->template->load('Homeadmin/templateadmin', 'Tagihan/form', $data);
	}
	function getData($id = null)
	{
		$fk_skpd_id = $this->input->post('fk_skpd_id');
		if ($id) {
			$sw = 0;
			$simpanan = $this->db->query("select
			tcts.*, mcua.nama ,mcua.nip
		from
			t_cb_tagihan_simpanan tcts
			join ms_cb_user_anggota mcua on tcts.fk_anggota_id = mcua.id
		where
			fk_tagihan_id = ?",  [$id])->result();
			$pinjaman = $this->db->query("select
			tgl,
			nama,
			nip,
			kategori ,
			tctp.*,
			pinjaman,
			tenor
		from
			t_cb_tagihan_pinjaman tctp
		join ms_cb_user_anggota mcua on
			tctp.fk_anggota_id = mcua.id
			join t_cb_pinjaman tcp on tcp.id =tctp.fk_pinjaman_id
			join ms_cb_kategori_pinjam mckp on mckp.id = tcp.fk_kategori_id
		where
			fk_tagihan_id = ?",  [$id])->result();
			$readonly = true;
		} else {
			$simpanan = $this->db->query("SELECT id,nama,nip FROM ms_cb_user_anggota where fk_id_skpd = ?",  [$fk_skpd_id])->result();
			$sw = $this->db->query("SELECT nominal FROM ms_cb_simpanan where id = ? ", [2])->row()->nominal;
			$readonly = false;
			$pinjaman = $this->db->query("select
				tcp.id,
				tcp.fk_anggota_id,
				tgl,
				nama,
				nip,
				pinjaman,
				kategori ,
				jml_angsuran+1 as angsuran_ke,
				pokok,
				tapim,
				tcp.bunga,
				tenor,
				jml_tagihan
			from
				t_cb_pinjaman tcp
			join ms_cb_user_anggota mcua on
				tcp.fk_anggota_id = mcua.id
			join ms_cb_kategori_pinjam mckp on
				tcp.fk_kategori_id = mckp.id
				where status=0 and mcua.fk_id_skpd = ?",  [$fk_skpd_id])->result();
		}
		$data = [
			'simpanan' => $simpanan,
			'pinjaman' => $pinjaman,
			'sw' => $sw,
			'readonly' => $readonly
		];
		$this->load->view('Tagihan/_form', $data);
	}

	public function save_kolektif()
	{
		$this->MHome->ceklogin();
		$this->db->trans_start();
		$periode = $this->input->post('periode');
		$fk_skpd_id = $this->input->post('fk_skpd_id');
		$fk_anggota_id = $this->input->post('fk_anggota_id');
		$fk_pinjaman_id = $this->input->post('fk_pinjaman_id');

		$angsuran_ke = $this->input->post('angsuran_ke');
		$pokok = $this->input->post('pokok');
		$tapim = $this->input->post('tapim');
		$bunga = $this->input->post('bunga');
		$jml_tagihan = $this->input->post('jml_tagihan');
		$tenor = $this->input->post('tenor');

		$wajib = $this->input->post('wajib');
		$sukarela = $this->input->post('sukarela');

		$data['fk_skpd_id'] = $fk_skpd_id;
		$data['bulan'] = explode('-', $periode)[0];
		$data['tahun'] = explode('-', $periode)[1];
		$data['kategori'] = 'kolektif';
		$data['user_act'] = $this->session->id;
		$data['time_act'] = date('Y-m-d H:i:s');
		$this->MTagihan->insert($data);
		$tagihanId = $this->db->insert_id();

		$dataPinjaman = [];
		for ($i = 0; $i < count($this->input->post('pinjaman')); $i++) {
			$pinjaman = [
				'fk_tagihan_id' => $tagihanId,
				'fk_pinjaman_id' => $fk_pinjaman_id[$i],
				'fk_anggota_id' => $fk_anggota_id[$i],
				'angsuran_ke' => str_replace(".", "", $angsuran_ke[$i]),
				'pokok' => str_replace(".", "", $pokok[$i]),
				'tapim' => str_replace(".", "", $tapim[$i]),
				'bunga' => str_replace(".", "", $bunga[$i]),
				'jml_tagihan' => str_replace(".", "", $jml_tagihan[$i]),
			];
			$this->db->query("update  t_cb_pinjaman set jml_angsuran = ? where id =? ", [$angsuran_ke[$i], $fk_pinjaman_id[$i]]);
			if ($angsuran_ke[$i] == $tenor[$i]) {
				$this->db->query("update  t_cb_pinjaman set status = ? where id =? ", [1, $fk_pinjaman_id[$i]]);
			}
			array_push($dataPinjaman, $pinjaman);
		}
		if (count($dataPinjaman) > 0) {
			$this->MTagihanPinjaman->insert_batch($dataPinjaman);
		}
		// insert tagihan simpanan
		$dataSimpanan = [];
		for ($i = 0; $i < count($this->input->post('simpanan')); $i++) {
			$simpanan = [
				'fk_tagihan_id' => $tagihanId,
				'fk_skpd_id' => $fk_skpd_id,
				'fk_anggota_id' => $fk_anggota_id[$i],
				'wajib' => str_replace(".", "", $wajib[$i]),
				'sukarela' => str_replace(".", "", $sukarela[$i]),
			];
			array_push($dataSimpanan, $simpanan);
		}
		if (count($dataSimpanan) > 0) {
			$this->MTagihanSimpanan->insert_batch($dataSimpanan);
		}
		$this->db->trans_complete();

		if ($this->db->trans_status() === TRUE) {
			$this->session->set_flashdata('success', 'Data Berhasil disimpan.');
		} else {
			$this->session->set_flashdata('error', 'Data Gagal disimpan.');
		}
		redirect('Tagihan');
	}

	public function detail_kolektif($id)
	{
		$this->MHome->ceklogin();
		$skpd = $this->db->query("select * from ms_cb_skpd")->result_array();
		$tagihan = $this->db->query("select * from t_cb_tagihan where id = ? ", [$id])->row();
		$data = array(
			'action' => base_url() . 'Tagihan/save_kolektif',
			'button' => 'Buat Tagihan',
			'id' => set_value('id', $id),
			'fk_skpd_id' => set_value('fk_skpd_id', $tagihan->fk_skpd_id),
			'periode' => set_value('periode', $tagihan->bulan . '-' . $tagihan->tahun),
			'wajib' => set_value('wajib'),
			'sukarela' => set_value('sukarela'),
			'arrSKPD' => $skpd,
			'method' => 'PUT'
		);

		$data['Tagihan'] = 'active';
		$data['act_back'] = base_url() . 'Tagihan';
		$data['arrUserAnggota'] = $this->MMscbUseranggota->get();
		$this->template->load('Homeadmin/templateadmin', 'Tagihan/form', $data);
	}
	function delete_simpanan($id, $tagihanId)
	{
		$this->db->trans_start();
		$this->MTagihanSimpanan->delete($id);
		$jmlSimpanan = $this->db->query("select count(id) simpanan from t_cb_tagihan_simpanan where fk_tagihan_id = ? ", [$tagihanId])->row()->simpanan;
		$jmlPinjaman = $this->db->query("select count(id) pinjaman from t_cb_tagihan_pinjaman where fk_tagihan_id = ? ", [$tagihanId])->row()->pinjaman;
		if ($jmlSimpanan + $jmlPinjaman == 0) {
			$this->MTagihan->delete($tagihanId);
			$this->db->trans_complete();
			redirect('Tagihan');
		}

		$this->db->trans_complete();
		if ($this->db->trans_status() === TRUE) {
			$this->session->set_flashdata('success', 'Data Berhasil dihapus.');
		} else {
			$this->session->set_flashdata('error', 'Data Gagal dihapus.');
		}
		redirect($_SERVER['HTTP_REFERER']);
	}
	function delete_pinjaman($id, $tagihanId)
	{

		$this->db->trans_start();
		$tagihanPinjaman = $this->MTagihanPinjaman->get(['id' => $id])[0];
		$this->MTagihanPinjaman->delete($id);
		// update pinjaman
		$this->db->query("update  t_cb_pinjaman set status = ? , jml_angsuran = ? where id =? ", [0, $tagihanPinjaman['angsuran_ke'] - 1, $tagihanPinjaman['fk_pinjaman_id']]);

		// count detail
		$jmlSimpanan = $this->db->query("select count(id) simpanan from t_cb_tagihan_simpanan where fk_tagihan_id = ? ", [$tagihanId])->row()->simpanan;
		$jmlPinjaman = $this->db->query("select count(id) pinjaman from t_cb_tagihan_pinjaman where fk_tagihan_id = ? ", [$tagihanId])->row()->pinjaman;
		$this->session->set_flashdata('success', 'Data Berhasil dihapus.');
		if ($jmlSimpanan + $jmlPinjaman == 0) {
			$this->MTagihan->delete($tagihanId);
			$this->db->trans_complete();
			redirect('Tagihan');
		}
		$this->db->trans_complete();

		if ($this->db->trans_status() === TRUE) {
			$this->session->set_flashdata('success', 'Data Berhasil dihapus.');
		} else {
			$this->session->set_flashdata('error', 'Data Gagal dihapus.');
		}
		redirect($_SERVER['HTTP_REFERER']);
	}
	function delete_kolektif($id)
	{
		$this->db->trans_start();
		// simpanan
		$this->db->where('fk_tagihan_id', $id);
		$this->db->delete('t_cb_tagihan_simpanan');
		// pinjaman
		$pinjaman = $this->db->query("select *  from t_cb_tagihan_pinjaman where fk_tagihan_id = ? ", [$id])->result();
		foreach ($pinjaman as $key => $p) {
			$this->MTagihanPinjaman->delete($p->id);
			$this->db->query("update  t_cb_pinjaman set status = ? , jml_angsuran = ? where id =? ", [0, $p->angsuran_ke - 1, $p->fk_pinjaman_id]);
		}
		$this->MTagihan->delete($id);

		$this->db->trans_complete();
		if ($this->db->trans_status() === TRUE) {
			$this->session->set_flashdata('success', 'Data Berhasil dihapus.');
		} else {
			$this->session->set_flashdata('error', 'Data Gagal dihapus.');
		}
		redirect('Tagihan');
	}

	public function create_individu()
	{
		$this->MHome->ceklogin();
		$skpd = $this->db->query("select * from ms_cb_skpd")->result_array();
		$data = array(
			'action' => base_url() . 'Tagihan/save_individu',
			'button' => 'Simpan',
			'id' => set_value('id'),
			'fk_skpd_id' => set_value('fk_skpd_id'),
			'periode' => set_value('periode'),
			'wajib' => set_value('wajib'),
			'sukarela' => set_value('sukarela'),
			'arrSKPD' => $skpd,
			'method' => 'POST'
		);

		$data['Tagihan'] = 'active';
		$data['act_back'] = base_url() . 'Tagihan';
		$data['arrUserAnggota'] = $this->MMscbUseranggota->get();
		$this->template->load('Homeadmin/templateadmin', 'Tagihan/form_individu', $data);
	}
	function getAnggota()
	{
		$this->MHome->ceklogin();
		$fk_skpd_id = $this->input->post('fk_skpd_id');

		$hsl = $this->MMscbUseranggota->get(array('fk_id_skpd' => $fk_skpd_id));
		$data['data'] = "<option value=''>Pilih</option>\n";
		foreach ((array)$hsl as $val) {
			$data['data'] .= "<option value=\"" . $val['id'] . "\">" . $val['nama'] . " " . $val['nip'] . "</option>\n";
		}
		echo json_encode($data);
	}
	function getDataIndividu($id = null)
	{
		$fk_anggota_id = $this->input->post('fk_anggota_id');
		if ($id) {
			$sw = 0;
			$simpanan = $this->db->query("select
			tcts.*, mcua.nama ,mcua.nip
		from
			t_cb_tagihan_simpanan tcts
			join ms_cb_user_anggota mcua on tcts.fk_anggota_id = mcua.id
		where
			fk_tagihan_id = ?",  [$id])->result();
			$pinjaman = $this->db->query("select
			tgl,
			nama,
			nip,
			kategori ,
			tctp.*,
			pinjaman,
			tenor
		from
			t_cb_tagihan_pinjaman tctp
		join ms_cb_user_anggota mcua on
			tctp.fk_anggota_id = mcua.id
			join t_cb_pinjaman tcp on tcp.id =tctp.fk_pinjaman_id
			join ms_cb_kategori_pinjam mckp on mckp.id = tcp.fk_kategori_id
		where
			fk_tagihan_id = ?",  [$id])->result();
			$readonly = true;
		} else {
			$simpanan = $this->db->query("SELECT id,nama,nip FROM ms_cb_user_anggota where fk_id_skpd = ?",  [$fk_anggota_id])->result();
			$sw = $this->db->query("SELECT nominal FROM ms_cb_simpanan where id = ? ", [2])->row()->nominal;
			$readonly = false;
			$pinjaman = $this->db->query("select
				tcp.id,
				tcp.fk_anggota_id,
				tgl,
				nama,
				nip,
				pinjaman,
				kategori ,
				jml_angsuran+1 as angsuran_ke,
				pokok,
				tapim,
				tcp.bunga,
				tenor,
				jml_tagihan
			from
				t_cb_pinjaman tcp
			join ms_cb_user_anggota mcua on
				tcp.fk_anggota_id = mcua.id
			join ms_cb_kategori_pinjam mckp on
				tcp.fk_kategori_id = mckp.id
				where status=0 and tcp.fk_anggota_id = ?",  [$fk_anggota_id])->row();
		}
		$data = [
			'simpanan' => $simpanan,
			'pinjaman' => $pinjaman,
			'sw' => $sw,
			'readonly' => $readonly
		];
		$this->load->view('Tagihan/_form_individu', $data);
	}

	public function save_individu()
	{
		$this->MHome->ceklogin();
		$this->db->trans_start();
		$periode = $this->input->post('periode');
		$fk_skpd_id = $this->input->post('fk_skpd_id');
		$fk_anggota_id = $this->input->post('fk_anggota_id');
		$fk_pinjaman_id = $this->input->post('fk_pinjaman_id');

		$angsuran_ke = $this->input->post('angsuran_ke');
		$pokok = $this->input->post('pokok');
		$tapim = $this->input->post('tapim');
		$bunga = $this->input->post('bunga');
		$jml_tagihan = $this->input->post('jml_tagihan');
		$tenor = $this->input->post('tenor');

		$wajib = $this->input->post('wajib');
		$sukarela = $this->input->post('sukarela');
		$jml = $this->input->post('jml');

		$data['fk_skpd_id'] = $fk_skpd_id;
		$data['bulan'] = explode('-', $periode)[0];
		$data['tahun'] = explode('-', $periode)[1];
		$data['kategori'] = 'individu';
		$data['user_act'] = $this->session->id;
		$data['time_act'] = date('Y-m-d H:i:s');
		$this->MTagihan->insert($data);
		$tagihanId = $this->db->insert_id();

		$dataPinjaman = [];

		$pinjaman = [
			'fk_tagihan_id' => $tagihanId,
			'fk_pinjaman_id' => $fk_pinjaman_id,
			'fk_anggota_id' => $fk_anggota_id,
			'angsuran_ke' => str_replace(".", "", $angsuran_ke),
			'pokok' => str_replace(".", "", $pokok),
			'tapim' => str_replace(".", "", $tapim),
			'bunga' => str_replace(".", "", $bunga),
			'jml_tagihan' => str_replace(".", "", $jml_tagihan),
		];
		$this->db->query("update  t_cb_pinjaman set jml_angsuran = ? where id =? ", [$angsuran_ke, $fk_pinjaman_id]);
		if ($angsuran_ke == $tenor) {
			$this->db->query("update  t_cb_pinjaman set status = ? where id =? ", [1, $fk_pinjaman_id]);
		}
		$this->MTagihanPinjaman->insert($pinjaman);
		// insert tagihan simpanan
		if ($jml && $jml > 0) {
			$simpanan = [
				'fk_tagihan_id' => $tagihanId,
				'fk_skpd_id' => $fk_skpd_id,
				'fk_anggota_id' => $fk_anggota_id,
				'wajib' => str_replace(".", "", $wajib),
				'sukarela' => str_replace(".", "", $sukarela),
			];
			$this->MTagihanSimpanan->insert($simpanan);
		}
		$this->db->trans_complete();

		if ($this->db->trans_status() === TRUE) {
			$this->session->set_flashdata('success', 'Data Berhasil disimpan.');
		} else {
			$this->session->set_flashdata('error', 'Data Gagal disimpan.');
		}
		redirect('Tagihan');
	}

	function delete_individu($id)
	{
		$this->db->trans_start();
		// simpanan
		$this->db->where('fk_tagihan_id', $id);
		$this->db->delete('t_cb_tagihan_simpanan');
		// pinjaman
		$pinjaman = $this->db->query("select *  from t_cb_tagihan_pinjaman where fk_tagihan_id = ? ", [$id])->result();
		foreach ($pinjaman as $key => $p) {
			$this->MTagihanPinjaman->delete($p->id);
			$lastTagihanPinjaman = $this->db->query("select max(angsuran_ke) angsuran_ke  from t_cb_tagihan_pinjaman where fk_pinjaman_id = ? limit 1", [$p->fk_pinjaman_id])->row();

			$this->db->query("update  t_cb_pinjaman set status = ? , jml_angsuran = ? where id =? ", [0, ($lastTagihanPinjaman->angsuran_ke ?? 0), $p->fk_pinjaman_id]);
		}
		$this->MTagihan->delete($id);

		$this->db->trans_complete();
		if ($this->db->trans_status() === TRUE) {
			$this->session->set_flashdata('success', 'Data Berhasil dihapus.');
		} else {
			$this->session->set_flashdata('error', 'Data Gagal dihapus.');
		}
		redirect('Tagihan');
	}
}

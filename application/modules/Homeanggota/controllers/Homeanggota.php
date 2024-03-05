<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Homeanggota extends MX_Controller
{

	function __construct()
	{
		parent::__construct();
		$this->load->model('MHome');
		$this->load->model('MMscbUseranggota');
		$this->MHome->ceklogin();
	}

	public function index()
	{
		$data['beranda'] = 'active';

		$idANggota = $this->session->id;
		$que1 = "SELECT (COALESCE(a.simpanan_pokok,0)+COALESCE(a.simpanan_wajib,0)+COALESCE(ss.wajib,0)+COALESCE(ss.sukarela,0)+COALESCE(pp.tapim,0)) simpanan FROM ms_cb_user_anggota a
			LEFT JOIN (
					SELECT p.fk_anggota_id,sum(p.tapim) tapim,g1.status_posting FROM t_cb_tagihan_pinjaman p INNER JOIN t_cb_tagihan g1 ON g1.id=p.fk_tagihan_id WHERE p.fk_anggota_id=$idANggota AND g1.status_posting=1
			) pp ON pp.fk_anggota_id=a.id
			LEFT JOIN (
				SELECT s.fk_anggota_id,sum(s.wajib) wajib, sum(s.sukarela) sukarela  FROM t_cb_tagihan_simpanan s INNER JOIN t_cb_tagihan g2 ON g2.id=s.fk_tagihan_id WHERE s.fk_anggota_id=$idANggota AND g2.status_posting=1
			) ss ON ss.fk_anggota_id=a.id
			WHERE a.id=$idANggota ";
		$smpn = $this->db->query($que1)->row();
		$data['simpanan'] = !isset($smpn) ? '0' : $smpn->simpanan;

		$que2 = "SELECT sum(pinjaman) pinjaman FROM t_cb_pinjaman WHERE fk_anggota_id=$idANggota AND status=0";
		$pnjm = $this->db->query($que2)->row();
		$data['pinjaman'] = !isset($pnjm) ? '0' : $pnjm->pinjaman;

		$this->template->load('Homeanggota/templateanggota', 'Homeanggota/berandaanggota', $data);
	}

	public function updatedataanggota()
	{
		$id = $_SESSION['id'];

		$kat = $this->db->query("SELECT * FROM ms_cb_user_anggota WHERE id=$id")->row();

		$data = array(
			'action' => base_url() . 'Homeanggota/saveupdatedataanggota',
			'button' => 'Update',
			'id' => set_value('id', $kat->id),
			'nama' => set_value('nama', $kat->nama),
			'nik' => set_value('nik', $kat->nik),
			'nip' => set_value('nip', $kat->nip_gabung),
			'nomor_hp' => set_value('nomor_hp', $kat->nomor_hp),
			'alamat' => set_value('alamat', $kat->alamat),
			'fk_id_status_pekerjaan' => set_value('fk_id_status_pekerjaan', $kat->fk_id_status_pekerjaan),
			'arrPekerjaan' => $this->db->query("select * from ms_cb_status_pekerjaan order by id")->result_array()
		);

		$data['dataanggota'] = 'active';

		$this->template->load('Homeanggota/templateanggota', 'Homeanggota/formupdateanggota', $data);
	}

	function saveupdatedataanggota()
	{
		// 8 6 1 3
		$nip = $this->input->post('nip');
		$data['nama'] = $this->input->post('nama');
		$data['nik'] = $this->input->post('nik');
		$data['nip'] = substr($nip, 0, 8) . ' ' . substr($nip, 8, 6) . ' ' . substr($nip, 14, 1) . ' ' . substr($nip, -3);
		$data['nip_gabung'] = $this->input->post('nip');
		$data['nomor_hp'] = $this->input->post('nomor_hp');
		$data['alamat'] = $this->input->post('alamat');
		$data['fk_id_status_pekerjaan'] = $this->input->post('fk_id_status_pekerjaan');

		$this->MMscbUseranggota->update($this->input->post('id'), $data);
		$this->session->set_flashdata('success', 'Data Berhasil diupdate.');
		redirect('Homeanggota/updatedataanggota');
	}
	public function getListDtlSimpanan()
	{
		$idANggota = $this->session->id;
		$angg = $this->MMscbUseranggota->get(array('id' => $idANggota));
		$data['angg'] = $angg[0];
		$que = "SELECT max(t.bulan) bulan, max(tahun) tahun, sum(s.wajib) wajib,  sum(s.sukarela) sukarela FROM t_cb_tagihan_simpanan s INNER JOIN t_cb_tagihan t ON t.id=s.fk_tagihan_id WHERE fk_anggota_id=$idANggota";
		$data['wjb'] = $this->db->query($que)->row();

		$que2 = "SELECT max(t.bulan) bulan, max(tahun) tahun,sum(p.tapim) tapim FROM t_cb_tagihan_pinjaman p INNER JOIN t_cb_tagihan t ON t.id=p.fk_tagihan_id WHERE fk_anggota_id=$idANggota";
		$data['tpm'] = $this->db->query($que2)->row();

		$this->load->view('Homeanggota/listDtlSimpanan', $data);
	}

	public function getListDtlPinjaman()
	{
		$idANggota = $this->session->id;
		$angg = $this->MMscbUseranggota->get(array('id' => $idANggota));
		$data['angg'] = $angg[0];

		$que = "SELECT p.id,tenor,pinjaman,kategori FROM t_cb_pinjaman p
				INNER JOIN ms_cb_kategori_pinjam kp ON kp.id=p.fk_kategori_id
				WHERE p.status=0 AND fk_anggota_id=$idANggota ORDER BY tgl DESC;";
		$dataPnjam = $this->db->query($que)->result();
		$data['pinjam'] = $dataPnjam;

		$que1 = "SELECT fk_pinjaman_id,t.bulan,t.tahun,tp.angsuran_ke,tp.pokok,p.tapim,tp.bunga,tp.jml_tagihan FROM t_cb_tagihan_pinjaman tp
				INNER JOIN t_cb_tagihan t ON t.id=tp.fk_tagihan_id
				INNER JOIN t_cb_pinjaman p ON p.id=tp.fk_pinjaman_id
				WHERE p.status=0 AND t.status_posting=1 AND tp.fk_anggota_id=$idANggota
				ORDER BY fk_pinjaman_id,tp.angsuran_ke DESC";
		$dtl = $this->db->query($que1)->result();

		$arrDetail = array();
		foreach ($dtl as $val) {
			$arrDetail[$val->fk_pinjaman_id][] = $val;
		}
		$data['detailnya'] = $arrDetail;

		$this->load->view('Homeanggota/listDtlPinjaman', $data);
	}

	public function getListDtlSimulasi()
	{
		$data = null;
		$this->load->view('Homeanggota/listDtlSimulasi', $data);
	}
}

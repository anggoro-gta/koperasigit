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
			WHERE a.id=2671 ";
		$smpn = $this->db->query($que1)->row();
		$data['simpanan'] = !isset($smpn)?'0':$smpn->simpanan;

		$que2 = "SELECT pinjaman FROM t_cb_pinjaman WHERE id=$idANggota AND status=0";
		$pnjm = $this->db->query($que2)->row();
		$data['pinjaman'] = !isset($pnjm)?'0':$pnjm->pinjaman;

		$this->template->load('Homeanggota/templateanggota', 'Homeanggota/berandaanggota', $data);
	}

	public function getListDtlSimpanan()
	{
		$idANggota = $this->session->id;
		$angg = $this->MMscbUseranggota->get(array('id'=>$idANggota));
		$data['angg']=$angg[0];
		// $que = "SELECT * FROM ms_cb_user_anggota"
		
		$this->load->view('Homeanggota/listDtlSimpanan', $data);
	}

	public function getListDtlPinjaman()
	{
		die('pinjaman');
		$data = null;
		$this->load->view('Homeanggota/listDtlSimpanan', $data);
	}

	public function getListDtlSimulasi()
	{
		$data = null;
		$this->load->view('Homeanggota/listDtlSimulasi', $data);
	}
}

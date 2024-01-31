<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Homeanggota extends MX_Controller
{

	function __construct()
	{
		parent::__construct();
		$this->load->model('MHome');
		$this->MHome->ceklogin();
	}

	public function index()
	{
		$data['beranda'] = 'active';

		$idANggota = $this->session->id;
		$que1 = "SELECT (COALESCE(simpanan_pokok,0)+COALESCE(simpanan_wajib,0)+COALESCE(sum(wajib),0)+COALESCE(sum(sukarela),0)+COALESCE(sum(tapim),0)) simpanan FROM ms_cb_user_anggota a
			INNER JOIN t_cb_tagihan_simpanan s ON s.fk_anggota_id=a.id
			INNER JOIN t_cb_tagihan_pinjaman p ON p.fk_anggota_id=a.id
			WHERE a.id=$idANggota";
		$data['simpanan'] = $this->db->query($que1)->row()->simpanan;

		$que2 = "SELECT pinjaman FROM t_cb_pinjaman WHERE id=$idANggota AND status=0";
		$data['pinjaman'] = $this->db->query($que2)->row()->pinjaman;

		$this->template->load('Homeanggota/templateanggota', 'Homeanggota/berandaanggota', $data);
	}

	public function getListDtlSimpanan()
	{
		$data = null;
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

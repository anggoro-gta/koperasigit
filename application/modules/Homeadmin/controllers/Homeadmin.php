<?php
defined('BASEPATH') or exit('No direct script access allowed');

class homeadmin extends MX_Controller
{

	function __construct()
	{
		parent::__construct();
		$this->load->model('MHome');
	}

	public function index()
	{
		$this->MHome->ceklogin();
		$data['beranda'] = 'active';

		$idANggota = $this->session->id;
		$que1 = "SELECT (COALESCE(sum(simpanan_pokok),0)+COALESCE(sum(simpanan_wajib),0)+COALESCE(sum(wajib),0)+COALESCE(sum(sukarela),0)+COALESCE(sum(tapim),0)) simpanan FROM ms_cb_user_anggota a
			INNER JOIN t_cb_tagihan_simpanan s ON s.fk_anggota_id=a.id
			INNER JOIN t_cb_tagihan_pinjaman p ON p.fk_anggota_id=a.id";
		$data['simpanan'] = $this->db->query($que1)->row()->simpanan;

		$que2 = "SELECT sum(pinjaman) pinjaman FROM t_cb_pinjaman WHERE status=0";
		$data['pinjaman'] = $this->db->query($que2)->row()->pinjaman;

		// 	$get_simpanan = $this->db->query("SELECT
		// 	FORMAT(SUM(jml_simpanan),0) jumlah_simpanan
		// FROM
		// 	v_simpanan_new")->row();

		// 	$get_int_simpanan = $this->db->query("SELECT
		// 	SUM(jml_simpanan) jumlah_simpanan
		// FROM
		// 	v_simpanan_new")->row();

		// 	$get_pinjaman = $this->db->query("SELECT FORMAT(SUM(nilai),0) jml_pinjaman FROM t_cb_pinjaman")->row();
		// 	$get_int_pinjaman = $this->db->query("SELECT SUM(nilai) jml_pinjaman FROM t_cb_pinjaman")->row();

		// 	$floatsimpanan = (int)$get_int_simpanan->jumlah_simpanan;
		// 	$floatpinjaman = (int)$get_int_pinjaman->jml_pinjaman;
		// 	$floatsaldo = $floatsimpanan - $floatpinjaman;
		// 	$strsaldo = strval($floatsaldo);

		// 	$data['simpanan'] = str_replace(',', '.', $get_simpanan->jumlah_simpanan);
		// 	$data['pinjaman'] = str_replace(',', '.', $get_pinjaman->jml_pinjaman);
		// 	$data['saldo'] = number_format($floatsaldo, 0, ",", ".");


		$this->template->load('Homeadmin/templateadmin', 'Homeadmin/berandaadmin', $data);
	}
}

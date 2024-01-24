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

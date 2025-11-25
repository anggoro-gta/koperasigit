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

		//get data user tagihan simpanan
		$quetagihanwajib = "SELECT SUM(wajib) wajib FROM t_cb_tagihan_simpanan";
		$quetagihansukarela = "SELECT SUM(sukarela) sukarela FROM t_cb_tagihan_simpanan";

		$getrowtagihanwajib = $this->db->query($quetagihanwajib)->row()->wajib;
		$getrowtagihansukarela = $this->db->query($quetagihansukarela)->row()->sukarela;

		$doubletagihanwajib = doubleval($getrowtagihanwajib);
		$doubletagihansukarela = doubleval($getrowtagihansukarela);

		$totaltagihansimpanan = $doubletagihanwajib + $doubletagihansukarela;

		//get data user simpanan pokok dan wajib
		$queuserpokok = "SELECT SUM(simpanan_pokok) simpanan_pokok FROM ms_cb_user_anggota";
		$queuserwajib = "SELECT SUM(simpanan_wajib) simpanan_wajib FROM ms_cb_user_anggota";

		$getrowqueuserpokok = $this->db->query($queuserpokok)->row()->simpanan_pokok;
		$getrowqueuserwajib = $this->db->query($queuserwajib)->row()->simpanan_wajib;

		$doubleuserpokok = doubleval($getrowqueuserpokok);
		$doubleuserwajib = doubleval($getrowqueuserwajib);

		$totaluserpokokwajib = $doubleuserpokok + $doubleuserwajib;

		//TOTAL KESELURUHAN SIMPANAN
		$totalall = $totaltagihansimpanan + $totaluserpokokwajib;

		//get PIUTANG PINJAMAN Penerimaan dari tagihan
		$quepiupokok = "SELECT SUM(pokok) pokok FROM t_cb_tagihan_pinjaman";
		$quepiutapim = "SELECT SUM(tapim) tapim FROM t_cb_tagihan_pinjaman";
		$quepiubunga = "SELECT SUM(bunga) bunga FROM t_cb_tagihan_pinjaman";

		$doublepiupokok = doubleval($this->db->query($quepiupokok)->row()->pokok);
		$doublepiutapim = doubleval($this->db->query($quepiutapim)->row()->tapim);
		$doublepiubunga = doubleval($this->db->query($quepiubunga)->row()->bunga);

		$totalpiu = $doublepiupokok + $doublepiutapim + $doublepiubunga;

		//get perkiraan tagihan yang belum terbayar
		$quetagihan = "SELECT SUM(( pokok + tapim + bunga )*( tenor - jml_angsuran )) AS total FROM t_cb_pinjaman WHERE `status` = 0";

		$doubletagihan = doubleval($this->db->query($quetagihan)->row()->total);

		//total pinjaman aktif
		$quepinjaman = "SELECT sum(pinjaman) pinjaman FROM t_cb_pinjaman WHERE status = 0";

		$doublepinjaman = doubleval($this->db->query($quepinjaman)->row()->pinjaman);

		//total pinjaman lunas
		$quepinjamanlunas = "SELECT sum(pinjaman) pinjaman FROM t_cb_pinjaman WHERE status = 1";

		$doublepinjamanlunas = doubleval($this->db->query($quepinjamanlunas)->row()->pinjaman);

		//TOTAL SALDO
		$saldo = $totalall + $totalpiu + $doubletagihan - $doublepinjaman - $doublepinjamanlunas;

		// $que1 = "SELECT (COALESCE(sum(simpanan_pokok),0)+COALESCE(sum(simpanan_wajib),0)+COALESCE(sum(wajib),0)+COALESCE(sum(sukarela),0)+COALESCE(sum(tapim),0)) simpanan FROM ms_cb_user_anggota a
		// 	INNER JOIN t_cb_tagihan_simpanan s ON s.fk_anggota_id=a.id
		// 	INNER JOIN t_cb_tagihan_pinjaman p ON p.fk_anggota_id=a.id";
		// $data['simpanan'] = $this->db->query($que1)->row()->simpanan;

		$data['simpanan'] = $totalall;
		$data['piupinjaman'] = $totalpiu;
		$data['tagihan'] = $doubletagihan;

		// $que2 = "SELECT sum(pinjaman) pinjaman FROM t_cb_pinjaman WHERE status = 0";
		$data['pinjaman'] = $doublepinjaman;
		$data['pinjamanlunas'] = $doublepinjamanlunas;

		$data['saldo'] = $saldo;

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

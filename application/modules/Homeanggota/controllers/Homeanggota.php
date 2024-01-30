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

		$this->template->load('Homeanggota/templateanggota', 'Homeanggota/berandaanggota', $data);
	}

	public function getListDtlSimpanan(){
		$data=null;
		$this->load->view('Homeanggota/listDtlSimpanan', $data);
	}

	public function getListDtlPinjaman(){
		die('pinjaman');
		$data=null;
		$this->load->view('Homeanggota/listDtlSimpanan', $data);
	}

	public function getListDtlSimulasi(){
		die('simulasi');
		$data=null;
		$this->load->view('Homeanggota/listDtlSimpanan', $data);
	}
}

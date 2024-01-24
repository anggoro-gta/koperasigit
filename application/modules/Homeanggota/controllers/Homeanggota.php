<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Homeanggota extends MX_Controller
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

		$this->template->load('Homeanggota/templateanggota', 'Homeanggota/berandaanggota', $data);
	}
}

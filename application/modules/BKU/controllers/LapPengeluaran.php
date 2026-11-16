<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class LapPengeluaran extends CI_Controller {
	protected $table;
	
	function __construct(){
		parent::__construct();
		$this->load->library('datatables');
		$this->load->model('MBKUPengeluaran');
		$this->table = 't_cb_bku_pengeluaran';
	}

	public function index()
	{
		$data = array();
		$data['action'] = base_url().'BKU/LapPengeluaran/export';

		$this->template->load('Homeadmin/templateadmin','BKU/lap-pengeluaran/form',$data);
	}

	public function export(){
		$tipe = $_POST['tipe']; //pdf atau excel
		$periode = explode('-', $_POST['periode']);
		$bulan = (int) $periode[1];
		$tahun = $periode[0];
		$nilai_tunai = $_POST['nilai_tunai'];
		$nilai_bank = $_POST['nilai_bank'];
		$nama_ketua_1 = $_POST['nama_ketua_1'];
		$nama_bendahara_1 = $_POST['nama_bendahara_1'];
		$nama_manager = $_POST['nama_manager'];


		$check_next_tahun = $this->db
			->where('tahun >', $tahun)
			->get('ms_cb_saldo_awal_tahun')
			->row();

		$lock_data = false;
		$btn_tambah_pengeluaran = '';
		
		if(!empty($check_next_tahun)) {
			$lock_data = true;
			$btn_tambah_pengeluaran = 'hidden';
		}
		
		$html = '';

		$pengeluaran = $this->db
			->where('tahun', $tahun)
			->where('bulan', $bulan)
			->order_by('id', 'ASC')
			->get('t_cb_bku_pengeluaran')
			->result();

		$sum_simpanan_pokok = 0;
		$sum_simpanan_wajib = 0;
		$sum_simpanan_tapim = 0;
		$sum_simpanan_sukarela = 0;
		$sum_dana_sosial = 0;
		$sum_biaya = 0;
		$sum_kredit_uang = 0;
		$sum_barang = 0;
		$sum_pajak = 0;
		$sum_dana_pendidikan = 0;
		$sum_shu = 0;
		$sum_inventaris_kantor = 0;
		$sum_cadangan_pemb_usaha = 0;

		$sum_jml_pengeluaran = 0;
		
		if (count($pengeluaran) > 0) {
			
			foreach ($pengeluaran as $row) {
			
				// Ambil kategori pengeluaran sesuai tahun
				$kategori = $this->db
					->select('id, nama_kategori_pengeluaran, tahun')
					->from('ms_cb_kategori_pengeluaran')
					->where('id', $row->fk_id_ms_kategori_pengeluaran)
					->get()
					->row();

				$html .= '<tr>';
				$html .= '<th style="text-align: left">'.htmlspecialchars($kategori->nama_kategori_pengeluaran, ENT_QUOTES, 'UTF-8').'</th>';

				$html .= '<td style="text-align: right">'.$this->_rupiah_or_dash($row->simpanan_pokok).'</td>';
				$html .= '<td style="text-align: right">'.$this->_rupiah_or_dash($row->simpanan_wajib).'</td>';
				$html .= '<td style="text-align: right">'.$this->_rupiah_or_dash($row->simpanan_tapim).'</td>';
				$html .= '<td style="text-align: right">'.$this->_rupiah_or_dash($row->simpanan_sukarela).'</td>';
				$html .= '<td style="text-align: right">'.$this->_rupiah_or_dash($row->dana_sosial).'</td>';
				$html .= '<td style="text-align: right">'.$this->_rupiah_or_dash($row->biaya).'</td>';
				$html .= '<td style="text-align: right">'.$this->_rupiah_or_dash($row->kredit_uang).'</td>';
				$html .= '<td style="text-align: right">'.$this->_rupiah_or_dash($row->barang).'</td>';
				$html .= '<td style="text-align: right">'.$this->_rupiah_or_dash($row->pajak).'</td>';
				$html .= '<td style="text-align: right">'.$this->_rupiah_or_dash($row->dana_pendidikan).'</td>';
				$html .= '<td style="text-align: right">'.$this->_rupiah_or_dash($row->shu).'</td>';
				$html .= '<td style="text-align: right">'.$this->_rupiah_or_dash($row->inventaris_kantor).'</td>';
				$html .= '<td style="text-align: right">'.$this->_rupiah_or_dash($row->cadangan_pemb_usaha).'</td>';

				$jml_pengeluaran = $this->_total_pengeluaran_row($row);

				$sum_simpanan_pokok      += $row->simpanan_pokok;
				$sum_simpanan_wajib      += $row->simpanan_wajib;
				$sum_simpanan_tapim      += $row->simpanan_tapim;
				$sum_simpanan_sukarela   += $row->simpanan_sukarela;
				$sum_dana_sosial         += $row->dana_sosial;
				$sum_biaya               += $row->biaya;
				$sum_kredit_uang         += $row->kredit_uang;
				$sum_barang              += $row->barang;
				$sum_pajak               += $row->pajak;
				$sum_dana_pendidikan     += $row->dana_pendidikan;
				$sum_shu                 += $row->shu;
				$sum_inventaris_kantor   += $row->inventaris_kantor;
				$sum_cadangan_pemb_usaha += $row->cadangan_pemb_usaha;
				$sum_jml_pengeluaran	 += $jml_pengeluaran;
				
				$html .= '<td style="text-align: right"><b>'.$this->_rupiah_or_dash($jml_pengeluaran).'</b></td>';

				$html .= '</tr>';
			}

		}

		$html .= '<tr style="background-color: #d2d2d2;">
					<th style="text-align: center">JUMLAH</th>
					<th style="text-align: right">'.$this->_rupiah_or_dash($sum_simpanan_pokok).'</th>
					<th style="text-align: right">'.$this->_rupiah_or_dash($sum_simpanan_wajib).'</th>
					<th style="text-align: right">'.$this->_rupiah_or_dash($sum_simpanan_tapim).'</th>
					<th style="text-align: right">'.$this->_rupiah_or_dash($sum_simpanan_sukarela).'</th>
					<th style="text-align: right">'.$this->_rupiah_or_dash($sum_dana_sosial).'</th>
					<th style="text-align: right">'.$this->_rupiah_or_dash($sum_biaya).'</th>
					<th style="text-align: right">'.$this->_rupiah_or_dash($sum_kredit_uang).'</th>
					<th style="text-align: right">'.$this->_rupiah_or_dash($sum_barang).'</th>
					<th style="text-align: right">'.$this->_rupiah_or_dash($sum_pajak).'</th>
					<th style="text-align: right">'.$this->_rupiah_or_dash($sum_dana_pendidikan).'</th>
					<th style="text-align: right">'.$this->_rupiah_or_dash($sum_shu).'</th>
					<th style="text-align: right">'.$this->_rupiah_or_dash($sum_inventaris_kantor).'</th>
					<th style="text-align: right">'.$this->_rupiah_or_dash($sum_cadangan_pemb_usaha).'</th>
					<th style="text-align: right">'.$this->_rupiah_or_dash($sum_jml_pengeluaran).'</th>
				</tr>';
				
		$title = 'PENGELUARAN BULAN '.strtoupper($this->nama_bulan($bulan)).' '.$tahun;
		$data = array(
			'data'             => $html,
			'title'            => $title,
			'nilai_tunai'      => $nilai_tunai,
			'nilai_bank'       => $nilai_bank,
			'jml_pengeluaran'  => $sum_jml_pengeluaran,
			'nama_ketua_1'     => $nama_ketua_1,
			'nama_bendahara_1' => $nama_bendahara_1,
			'nama_manager'     => $nama_manager,
		);

		
		if ($tipe == 'pdf') {
			$html = $this->load->view('BKU/lap-pengeluaran/pdf', $data, true);
			$this->pdf($title, $html, $this->help->folio_L(), false);
		} else {
			$html = $this->load->view('BKU/lap-pengeluaran/excel', $data, true);
			$this->excel($title, $html);
		}
	}

	protected function pdf($title, $html, $page, $batas = false)
	{
		ini_set('pcre.backtrack_limit', '5000000');
		ini_set('memory_limit', '1024M');
		set_time_limit(300);

		$config = [
			'mode'   => 'utf-8',
			'format' => $page,
		];

		if (!$batas) {
			$config['margin_left']   = 8;
			$config['margin_right']  = 8;
			$config['margin_top']    = 8;
			$config['margin_bottom'] = 8;
			$config['margin_header'] = 8;
			$config['margin_footer'] = 8;
		}

		$mpdf = new \Mpdf\Mpdf($config);

		$mpdf->simpleTables = true;
		$mpdf->packTableData = true;

		// Pisahkan CSS dari body HTML
		preg_match_all('/<style\b[^>]*>(.*?)<\/style>/is', $html, $cssMatches);
		$css  = !empty($cssMatches[1]) ? implode("\n", $cssMatches[1]) : '';
		$body = preg_replace('/<style\b[^>]*>.*?<\/style>/is', '', $html);

		if (!empty($css)) {
			$mpdf->WriteHTML($css, \Mpdf\HTMLParserMode::HEADER_CSS);
		}

		// Pecah body berdasarkan marker khusus
		$parts = preg_split('/<!--\s*CHUNK_BREAK\s*-->/i', $body);

		foreach ($parts as $part) {
			$part = trim($part);
			if ($part !== '') {
				$mpdf->WriteHTML($part, \Mpdf\HTMLParserMode::HTML_BODY);
			}
		}

		$mpdf->Output($title . '.pdf', 'I');
	}

	protected function excel($title, $html)
	{
		$filename = preg_replace('/[^A-Za-z0-9_-]/', '_', $title);

		header('Content-Type: application/vnd.ms-excel; charset=UTF-8');
		header('Content-Disposition: attachment; filename="' . $filename . '.xls"');
		header('Cache-Control: max-age=0');

		echo "\xEF\xBB\xBF";
		echo $html;
		exit;
	}

	private function _rupiah_or_dash($angka)
	{
		$angka = (float) $angka;

		if ($angka == 0) {
			return '-';
		}

		return $this->_rupiah($angka);
	}

	private function _rupiah($angka)
	{
		if($angka < 1){
			return '-';
		}
		return number_format((float) $angka, 2, ',', '.');
	}

	private function _total_pengeluaran_row($row)
	{
		return
			(float) $row->simpanan_pokok +
			(float) $row->simpanan_wajib +
			(float) $row->simpanan_tapim +
			(float) $row->simpanan_sukarela +
			(float) $row->dana_sosial +
			(float) $row->biaya +
			(float) $row->kredit_uang +
			(float) $row->barang +
			(float) $row->pajak +
			(float) $row->dana_pendidikan +
			(float) $row->shu +
			(float) $row->inventaris_kantor +
			(float) $row->cadangan_pemb_usaha
		;
	}

	function nama_bulan($bulan)
	{
		$nama_bulan = [
			1  => 'Januari',
			2  => 'Februari',
			3  => 'Maret',
			4  => 'April',
			5  => 'Mei',
			6  => 'Juni',
			7  => 'Juli',
			8  => 'Agustus',
			9  => 'September',
			10 => 'Oktober',
			11 => 'November',
			12 => 'Desember',
		];

		return $nama_bulan[(int) $bulan] ?? '-';
	}
}
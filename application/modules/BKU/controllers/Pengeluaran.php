<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Pengeluaran extends CI_Controller {
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
		$data['BKUPengeluaran'] = 'active';
		$data['act_add'] = base_url().'BKU/Pengeluaran/create';

		$data['list_tahun'] = $this->db
			->select('tahun')
			->from($this->table)
			->group_by('tahun')
			->order_by('tahun', 'ASC')
			->get()
			->result();

		$this->template->load('Homeadmin/templateadmin','BKU/pengeluaran/list',$data);
	}

	public function getDatatables()
	{
		header('Content-Type: application/json');

		$tahun = $this->input->post('tahun', true);
		$tahun = !empty($tahun) ? (int) $tahun : null;

		$draw   = (int) $this->input->post('draw');
		$start  = (int) $this->input->post('start');
		$length = (int) $this->input->post('length');

		if ($length <= 0) {
			$length = 10;
		}

		$listRekap = $this->_getRekapPengeluaranBulanan($tahun);

		$data = array();

		foreach ($listRekap as $row) {

			$tahunRow = (int) $row->tahun;
			$bulanRow = (int) $row->bulan;

			$periodeParam = sprintf('%04d-%02d', $tahunRow, $bulanRow);

			$urlView = base_url('BKU/Pengeluaran/create') . '?periode=' . urlencode($periodeParam);

			$buttonView = '
				<a href="'.$urlView.'" class="btn btn-xs btn-info">
					<i class="glyphicon glyphicon-eye-open"></i> View
				</a>
			';

			$data[] = array(
				'id'                  => $tahunRow . '-' . $bulanRow,
				'bulan_angka'         => $bulanRow,
				'bulan'               => $this->_nama_bulan($bulanRow),
				'tahun'               => $tahunRow,

				'simpanan_pokok'      => $this->_rupiah($row->simpanan_pokok),
				'simpanan_wajib'      => $this->_rupiah($row->simpanan_wajib),
				'simpanan_tapim'      => $this->_rupiah($row->simpanan_tapim),
				'simpanan_sukarela'   => $this->_rupiah($row->simpanan_sukarela),
				'dana_sosial'         => $this->_rupiah($row->dana_sosial),
				'biaya'               => $this->_rupiah($row->biaya),
				'kredit_uang'         => $this->_rupiah($row->kredit_uang),
				'barang'              => $this->_rupiah($row->barang),
				'pajak'               => $this->_rupiah($row->pajak),
				'dana_pendidikan'     => $this->_rupiah($row->dana_pendidikan),
				'shu'                 => $this->_rupiah($row->shu),
				'inventaris_kantor'   => $this->_rupiah($row->inventaris_kantor),
				'cadangan_pemb_usaha' => $this->_rupiah($row->cadangan_pemb_usaha),
				'jumlah_pengeluaran'  => $this->_rupiah($row->jumlah_pengeluaran),

				'jumlah_raw'          => (float) $row->jumlah_pengeluaran,

				'action'              => $buttonView,
			);
		}

		$recordsTotal = count($data);

		$search = $this->input->post('search');
		$keyword = '';

		if (isset($search['value'])) {
			$keyword = strtolower(trim($search['value']));
		}

		if (!empty($keyword)) {
			$data = array_filter($data, function ($row) use ($keyword) {
				return strpos(strtolower($row['bulan']), $keyword) !== false
					|| strpos((string) $row['tahun'], $keyword) !== false
					|| strpos((string) $row['simpanan_pokok'], $keyword) !== false
					|| strpos((string) $row['simpanan_wajib'], $keyword) !== false
					|| strpos((string) $row['simpanan_tapim'], $keyword) !== false
					|| strpos((string) $row['simpanan_sukarela'], $keyword) !== false
					|| strpos((string) $row['dana_sosial'], $keyword) !== false
					|| strpos((string) $row['biaya'], $keyword) !== false
					|| strpos((string) $row['kredit_uang'], $keyword) !== false
					|| strpos((string) $row['barang'], $keyword) !== false
					|| strpos((string) $row['pajak'], $keyword) !== false
					|| strpos((string) $row['dana_pendidikan'], $keyword) !== false
					|| strpos((string) $row['shu'], $keyword) !== false
					|| strpos((string) $row['inventaris_kantor'], $keyword) !== false
					|| strpos((string) $row['cadangan_pemb_usaha'], $keyword) !== false
					|| strpos((string) $row['jumlah'], $keyword) !== false;
			});

			$data = array_values($data);
		}

		$recordsFiltered = count($data);

		$dataPaging = array_slice($data, $start, $length);

		foreach ($dataPaging as $key => $row) {
			$dataPaging[$key]['no'] = $start + $key + 1;
		}

		echo json_encode(array(
			'draw'            => $draw,
			'recordsTotal'    => $recordsTotal,
			'recordsFiltered' => $recordsFiltered,
			'data'            => $dataPaging
		));
	}
	
	public function create()
	{
		$periode = $this->input->get('periode', true);

		if (!preg_match('/^\d{4}-(0[1-9]|1[0-2])$/', $periode)) {
			$periode = '';
		}

		$data = array(
			'action'    => base_url().'BKU/Pengeluaran/save',
			'button'    => 'Simpan',
			'periode'   => set_value('periode', $periode),
			'auto_load' => !empty($periode),
		);

		$data['BKUPengeluaran'] = 'active';

		$this->template->load('Homeadmin/templateadmin', 'BKU/pengeluaran/form', $data);
	}

	public function get_form_periode()
	{
		header('Content-Type: application/json');

		$periode = $this->input->post('periode', true);

		if (empty($periode)) {
			echo json_encode(array(
				'status'  => 'warning',
				'message' => 'Periode wajib dipilih.'
			));
			return;
		}

		$pecah = explode('-', $periode);

		if (count($pecah) != 2) {
			echo json_encode(array(
				'status'  => 'warning',
				'message' => 'Format periode tidak valid.'
			));
			return;
		}

		$tahun = $pecah[0];
		$bulan = (int) $pecah[1];
		
		// Ambil kategori pengeluaran sesuai tahun
		$kategori = $this->db
			->select('id, nama_kategori_pengeluaran, tahun')
			->from('ms_cb_kategori_pengeluaran')
			->where('tahun', $tahun)
			->order_by('id', 'ASC')
			->get()
			->result();
		$html = '';
		
		if (count($kategori) > 0) {

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
			
			foreach ($kategori as $row) {

				$html .= '<tr>';
				$html .= '<th>'.htmlspecialchars($row->nama_kategori_pengeluaran, ENT_QUOTES, 'UTF-8').'</th>';

				$row_pengeluaran = $this->db
					->where('tahun', $tahun)
					->where('bulan', $bulan)
					->where('fk_id_ms_kategori_pengeluaran', $row->id)
					->get('t_cb_bku_pengeluaran')
					->row();

				if ($row_pengeluaran) {

					$html .= '<td class="text-right">'.$this->_rupiah_or_dash($row_pengeluaran->simpanan_pokok).'</td>';
					$html .= '<td class="text-right">'.$this->_rupiah_or_dash($row_pengeluaran->simpanan_wajib).'</td>';
					$html .= '<td class="text-right">'.$this->_rupiah_or_dash($row_pengeluaran->simpanan_tapim).'</td>';
					$html .= '<td class="text-right">'.$this->_rupiah_or_dash($row_pengeluaran->simpanan_sukarela).'</td>';
					$html .= '<td class="text-right">'.$this->_rupiah_or_dash($row_pengeluaran->dana_sosial).'</td>';
					$html .= '<td class="text-right">'.$this->_rupiah_or_dash($row_pengeluaran->biaya).'</td>';
					$html .= '<td class="text-right">'.$this->_rupiah_or_dash($row_pengeluaran->kredit_uang).'</td>';
					$html .= '<td class="text-right">'.$this->_rupiah_or_dash($row_pengeluaran->barang).'</td>';
					$html .= '<td class="text-right">'.$this->_rupiah_or_dash($row_pengeluaran->pajak).'</td>';
					$html .= '<td class="text-right">'.$this->_rupiah_or_dash($row_pengeluaran->dana_pendidikan).'</td>';
					$html .= '<td class="text-right">'.$this->_rupiah_or_dash($row_pengeluaran->shu).'</td>';
					$html .= '<td class="text-right">'.$this->_rupiah_or_dash($row_pengeluaran->inventaris_kantor).'</td>';
					$html .= '<td class="text-right">'.$this->_rupiah_or_dash($row_pengeluaran->cadangan_pemb_usaha).'</td>';

					$jml_pengeluaran = $this->_total_pengeluaran_row($row_pengeluaran);

					$sum_simpanan_pokok      += $row_pengeluaran->simpanan_pokok;
					$sum_simpanan_wajib      += $row_pengeluaran->simpanan_wajib;
					$sum_simpanan_tapim      += $row_pengeluaran->simpanan_tapim;
					$sum_simpanan_sukarela   += $row_pengeluaran->simpanan_sukarela;
					$sum_dana_sosial         += $row_pengeluaran->dana_sosial;
					$sum_biaya               += $row_pengeluaran->biaya;
					$sum_kredit_uang         += $row_pengeluaran->kredit_uang;
					$sum_barang              += $row_pengeluaran->barang;
					$sum_pajak               += $row_pengeluaran->pajak;
					$sum_dana_pendidikan     += $row_pengeluaran->dana_pendidikan;
					$sum_shu                 += $row_pengeluaran->shu;
					$sum_inventaris_kantor   += $row_pengeluaran->inventaris_kantor;
					$sum_cadangan_pemb_usaha += $row_pengeluaran->cadangan_pemb_usaha;
					$sum_jml_pengeluaran	 += $jml_pengeluaran;
					
					$html .= '<td class="text-right"><b>'.$this->_rupiah_or_dash($jml_pengeluaran).'</b></td>';

				} else {

					for ($i = 1; $i <= 14; $i++) {
						$html .= '<td class="text-right">-</td>';
					}
				}

				$html .= '<td class="text-center">
							<button type="button" 
									class="btn btn-xs btn-primary" 
									onclick="formModal('.$tahun.', '.$bulan.', '.$row->id.')">
								<i title="edit" class="glyphicon glyphicon-edit icon-white"></i>
							</button>
						</td>';

				$html .= '</tr>';
			}

			$html .= '<tr>
						<th class="text-center">JUMLAH</th>
						<th class="text-center">'.$this->_rupiah_or_dash($sum_simpanan_pokok).'</th>
						<th class="text-center">'.$this->_rupiah_or_dash($sum_simpanan_wajib).'</th>
						<th class="text-center">'.$this->_rupiah_or_dash($sum_simpanan_tapim).'</th>
						<th class="text-center">'.$this->_rupiah_or_dash($sum_simpanan_sukarela).'</th>
						<th class="text-center">'.$this->_rupiah_or_dash($sum_dana_sosial).'</th>
						<th class="text-center">'.$this->_rupiah_or_dash($sum_biaya).'</th>
						<th class="text-center">'.$this->_rupiah_or_dash($sum_kredit_uang).'</th>
						<th class="text-center">'.$this->_rupiah_or_dash($sum_barang).'</th>
						<th class="text-center">'.$this->_rupiah_or_dash($sum_pajak).'</th>
						<th class="text-center">'.$this->_rupiah_or_dash($sum_dana_pendidikan).'</th>
						<th class="text-center">'.$this->_rupiah_or_dash($sum_shu).'</th>
						<th class="text-center">'.$this->_rupiah_or_dash($sum_inventaris_kantor).'</th>
						<th class="text-center">'.$this->_rupiah_or_dash($sum_cadangan_pemb_usaha).'</th>
						<th class="text-center">'.$this->_rupiah_or_dash($sum_jml_pengeluaran).'</th>
					</tr>';

		} else {

			$html .= '<tr>';
			$html .= '<td colspan="16" class="text-center text-danger">';
			$html .= 'Data kategori pengeluaran tahun '.$tahun.' belum tersedia.';
			$html .= '</td>';
			$html .= '</tr>';
		}

		echo json_encode(array(
			'status'      => 'success',
			'html'        => $html,
			'tahun'       => $tahun,
			'bulan'       => $bulan,
			'total_row'   => count($kategori)
		));
	}

	public function form_modal()
	{
		$tahun       = $this->input->post('tahun', true);
		$bulan       = $this->input->post('bulan', true);
		$id_kategori = $this->input->post('id_kategori', true);

		if (empty($tahun) || empty($bulan) || empty($id_kategori)) {
			echo '<div class="alert alert-danger">Parameter tidak lengkap.</div>';
			return;
		}

		$kategori = $this->db
			->where('id', $id_kategori)
			->get('ms_cb_kategori_pengeluaran')
			->row();

		if (!$kategori) {
			echo '<div class="alert alert-danger">Kategori pengeluaran tidak ditemukan.</div>';
			return;
		}

		$row = $this->db
			->where('tahun', $tahun)
			->where('bulan', $bulan)
			->where('fk_id_ms_kategori_pengeluaran', $id_kategori)
			->get('t_cb_bku_pengeluaran')
			->row();

		$data = array(
			'tahun'       => $tahun,
			'bulan'       => $bulan,
			'nama_bulan' => $this->_nama_bulan($bulan),
			'id_kategori' => $id_kategori,
			'kategori'    => $kategori,
			'row'         => $row,
		);

		$this->load->view('BKU/pengeluaran/form_modal', $data);
	}

	public function save_modal()
	{
		header('Content-Type: application/json');
		
		$tahun       = $this->input->post('tahun', true);
		$bulan       = $this->input->post('bulan', true);
		$id_kategori = $this->input->post('fk_id_ms_kategori_pengeluaran', true);

		if (empty($tahun) || empty($bulan) || empty($id_kategori)) {
			echo json_encode(array(
				'status'  => 'warning',
				'message' => 'Data periode dan kategori tidak lengkap.'
			));
			return;
		}

		$data = array(
			'tahun'                         => $tahun,
			'bulan'                         => $bulan,
			'fk_id_ms_kategori_pengeluaran' => $id_kategori,
			
			'simpanan_pokok'                => $this->_to_decimal($this->input->post('simpanan_pokok', true)),
			'simpanan_wajib'                => $this->_to_decimal($this->input->post('simpanan_wajib', true)),
			'simpanan_tapim'                => $this->_to_decimal($this->input->post('simpanan_tapim', true)),
			'simpanan_sukarela'             => $this->_to_decimal($this->input->post('simpanan_sukarela', true)),
			'dana_sosial'                   => $this->_to_decimal($this->input->post('dana_sosial', true)),
			'biaya'                         => $this->_to_decimal($this->input->post('biaya', true)),
			'kredit_uang'                   => $this->_to_decimal($this->input->post('kredit_uang', true)),
			'barang'                        => $this->_to_decimal($this->input->post('barang', true)),
			'pajak'                         => $this->_to_decimal($this->input->post('pajak', true)),
			'dana_pendidikan'               => $this->_to_decimal($this->input->post('dana_pendidikan', true)),
			'shu'                           => $this->_to_decimal($this->input->post('shu', true)),
			'inventaris_kantor'             => $this->_to_decimal($this->input->post('inventaris_kantor', true)),
			'cadangan_pemb_usaha'           => $this->_to_decimal($this->input->post('cadangan_pemb_usaha', true)),
		);

		$row = $this->db
			->where('tahun', $tahun)
			->where('bulan', $bulan)
			->where('fk_id_ms_kategori_pengeluaran', $id_kategori)
			->get('t_cb_bku_pengeluaran')
			->row();

		$this->db->trans_begin();

		if ($row) {
			$this->db
				->where('id', $row->id)
				->update('t_cb_bku_pengeluaran', $data);

			$message = 'Data pengeluaran berhasil diperbarui.';
		} else {
			$data['user_act'] = $this->session->id;
			$data['time_act'] = date('Y-m-d H:i:s');
			$this->db->insert('t_cb_bku_pengeluaran', $data);

			$message = 'Data pengeluaran berhasil disimpan.';
		}

		if ($this->db->trans_status() === false) {
			$this->db->trans_rollback();

			echo json_encode(array(
				'status'  => 'error',
				'message' => 'Data gagal disimpan.'
			));
			return;
		}

		$this->db->trans_commit();

		echo json_encode(array(
			'status'  => 'success',
			'message' => $message
		));
	}

	private function _nama_bulan($bulan)
	{
		$data = array(
			'1' => 'Januari',
			'2' => 'Februari',
			'3' => 'Maret',
			'4' => 'April',
			'5' => 'Mei',
			'6' => 'Juni',
			'7' => 'Juli',
			'8' => 'Agustus',
			'9' => 'September',
			'10' => 'Oktober',
			'11' => 'November',
			'12' => 'Desember',
		);

		return isset($data[$bulan]) ? $data[$bulan] : '';
	}

	private function _rupiah($angka)
	{
		if($angka < 1){
			return '-';
		}
		return number_format((float) $angka, 2, ',', '.');
	}

	private function _to_decimal($value)
	{
		$value = trim((string) $value);

		if ($value === '') {
			return 0;
		}

		// Bersihkan karakter selain angka, titik, koma, minus
		$value = preg_replace('/[^0-9,.\-]/', '', $value);

		/*
		* Format Indonesia:
		* 1.950.000      => 1950000
		* 1.950.000,50   => 1950000.50
		* 50.000         => 50000
		* 1,95           => 1.95
		*/

		if (strpos($value, ',') !== false) {
			// Ada koma berarti koma dianggap desimal
			$value = str_replace('.', '', $value);
			$value = str_replace(',', '.', $value);
		} else {
			// Tidak ada koma, semua titik dianggap pemisah ribuan
			$value = str_replace('.', '', $value);
		}

		return (float) $value;
	}

	private function _sum_pengeluaran_sampai_bulan($tahun, $bulan_sampai)
	{
		$row = $this->db
			->select("
				COUNT(*) AS total_data,
				COALESCE(SUM(
					COALESCE(simpanan_pokok, 0) +
					COALESCE(simpanan_wajib, 0) +
					COALESCE(simpanan_tapim, 0) +
					COALESCE(simpanan_sukarela, 0) +
					COALESCE(dana_sosial, 0) +
					COALESCE(biaya, 0) +
					COALESCE(kredit_uang, 0) +
					COALESCE(barang, 0) +
					COALESCE(pajak, 0) +
					COALESCE(dana_pendidikan, 0) +
					COALESCE(shu, 0) +
					COALESCE(inventaris_kantor, 0) +
					COALESCE(cadangan_pemb_usaha, 0)
				), 0) AS total
			", false)
			->from('t_cb_bku_pengeluaran')
			->where('tahun', $tahun)
			->where('bulan <=', $bulan_sampai)
			->get()
			->row();

		return $row;
	}

	private function _sum_pengeluaran_bulan($tahun, $bulan)
	{
		$row = $this->db
			->select("
				COUNT(*) AS total_data,
				COALESCE(SUM(
					COALESCE(simpanan_pokok, 0) +
					COALESCE(simpanan_wajib, 0) +
					COALESCE(simpanan_tapim, 0) +
					COALESCE(simpanan_sukarela, 0) +
					COALESCE(dana_sosial, 0) +
					COALESCE(biaya, 0) +
					COALESCE(kredit_uang, 0) +
					COALESCE(barang, 0) +
					COALESCE(pajak, 0) +
					COALESCE(dana_pendidikan, 0) +
					COALESCE(shu, 0) +
					COALESCE(inventaris_kantor, 0) +
					COALESCE(cadangan_pemb_usaha, 0)
				), 0) AS total
			", false)
			->from('t_cb_bku_pengeluaran')
			->where('tahun', $tahun)
			->where('bulan', $bulan)
			->get()
			->row();

		return $row;
	}

	private function _html_error($message)
	{
		return '
			<tr>
				<td colspan="15" class="text-center text-danger">
					'.$message.'
				</td>
			</tr>
		';
	}

	private function _rupiah_or_dash($angka)
	{
		$angka = (float) $angka;

		if ($angka == 0) {
			return '-';
		}

		return $this->_rupiah($angka);
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

	private function _getRekapPengeluaranBulanan($tahun = null)
	{
		$this->db->select("
			tahun,
			bulan,

			COALESCE(SUM(simpanan_pokok), 0) AS simpanan_pokok,
			COALESCE(SUM(simpanan_wajib), 0) AS simpanan_wajib,
			COALESCE(SUM(simpanan_tapim), 0) AS simpanan_tapim,
			COALESCE(SUM(simpanan_sukarela), 0) AS simpanan_sukarela,

			COALESCE(SUM(dana_sosial), 0) AS dana_sosial,
			COALESCE(SUM(biaya), 0) AS biaya,
			COALESCE(SUM(kredit_uang), 0) AS kredit_uang,
			COALESCE(SUM(barang), 0) AS barang,
			COALESCE(SUM(pajak), 0) AS pajak,
			COALESCE(SUM(dana_pendidikan), 0) AS dana_pendidikan,
			COALESCE(SUM(shu), 0) AS shu,
			COALESCE(SUM(inventaris_kantor), 0) AS inventaris_kantor,
			COALESCE(SUM(cadangan_pemb_usaha), 0) AS cadangan_pemb_usaha,

			COALESCE(SUM(
				COALESCE(simpanan_pokok, 0) +
				COALESCE(simpanan_wajib, 0) +
				COALESCE(simpanan_tapim, 0) +
				COALESCE(simpanan_sukarela, 0) +
				COALESCE(dana_sosial, 0) +
				COALESCE(biaya, 0) +
				COALESCE(kredit_uang, 0) +
				COALESCE(barang, 0) +
				COALESCE(pajak, 0) +
				COALESCE(dana_pendidikan, 0) +
				COALESCE(shu, 0) +
				COALESCE(inventaris_kantor, 0) +
				COALESCE(cadangan_pemb_usaha, 0)
			), 0) AS jumlah_pengeluaran
		", false);

		$this->db->from('t_cb_bku_pengeluaran');
		$this->db->where('tahun IS NOT NULL', null, false);
		$this->db->where('bulan IS NOT NULL', null, false);

		if (!empty($tahun)) {
			$this->db->where('tahun', $tahun);
		}

		$this->db->group_by(array('tahun', 'bulan'));
		$this->db->order_by('tahun', 'DESC');
		$this->db->order_by('bulan', 'ASC');

		return $this->db->get()->result();
	}
}
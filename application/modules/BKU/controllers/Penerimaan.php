<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Penerimaan extends CI_Controller {
	protected $table;
	
	function __construct(){
		parent::__construct();
		$this->load->library('datatables');
		$this->load->model('MBKUPenerimaan');
		$this->table = 't_cb_bku_penerimaan';
	}

	public function index()
	{
		$data = array();
		$data['BKUPenerimaan'] = 'active';
		$data['act_add'] = base_url().'BKU/Penerimaan/create';

		$data['list_tahun'] = $this->db
			->select('tahun')
			->from($this->table)
			->group_by('tahun')
			->order_by('tahun', 'ASC')
			->get()
			->result();

		$this->template->load('Homeadmin/templateadmin','BKU/penerimaan/list',$data);
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

		$listRekap = $this->_getRekapPenerimaanBulanan($tahun);

		$data = array();

		foreach ($listRekap as $row) {

			$tahunRow = (int) $row->tahun;
			$bulanRow = (int) $row->bulan;

			$periodeParam = sprintf('%04d-%02d', $tahunRow, $bulanRow);

			$urlView = base_url('BKU/Penerimaan/create') . '?periode=' . urlencode($periodeParam);

			$buttonView = '
				<a href="'.$urlView.'" class="btn btn-xs btn-info">
					<i class="glyphicon glyphicon-eye-open"></i> View
				</a>
			';

			$saldo = $this->_getSaldoBulanBerjalan($tahunRow, $bulanRow);

			$data[] = array(
				'id'                  => $tahunRow . '-' . $bulanRow,
				'bulan_angka'         => $bulanRow,
				'bulan'               => $this->_nama_bulan($bulanRow),
				'tahun'               => $tahunRow,

				'angsuran_pokok'      => $this->_rupiah($row->angsuran_pokok),
				'angsuran_bunga'      => $this->_rupiah($row->angsuran_bunga),

				'simpanan_pokok'      => $this->_rupiah($row->simpanan_pokok),
				'simpanan_wajib'      => $this->_rupiah($row->simpanan_wajib),
				'simpanan_tapim'      => $this->_rupiah($row->simpanan_tapim),
				'simpanan_sukarela'   => $this->_rupiah($row->simpanan_sukarela),

				'angsuran_barang'     => $this->_rupiah($row->angsuran_barang),
				'penjualan_tunai'     => $this->_rupiah($row->penjualan_tunai),
				'bank'                => $this->_rupiah($row->bank),
				'foto_copy'           => $this->_rupiah($row->foto_copy),
				'barang_titipan'      => $this->_rupiah($row->barang_titipan),

				'jumlah_penerimaan'   => $this->_rupiah($row->jumlah_penerimaan),
				'saldo'               => $this->_rupiah($saldo),

				'jumlah_raw'          => (float) $row->jumlah_penerimaan,
				'saldo_raw'           => (float) $saldo,

				'action' => $buttonView,
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
					|| strpos((string) $row['angsuran_pokok'], $keyword) !== false
					|| strpos((string) $row['angsuran_bunga'], $keyword) !== false
					|| strpos((string) $row['simpanan_pokok'], $keyword) !== false
					|| strpos((string) $row['simpanan_wajib'], $keyword) !== false
					|| strpos((string) $row['simpanan_tapim'], $keyword) !== false
					|| strpos((string) $row['simpanan_sukarela'], $keyword) !== false
					|| strpos((string) $row['angsuran_barang'], $keyword) !== false
					|| strpos((string) $row['penjualan_tunai'], $keyword) !== false
					|| strpos((string) $row['bank'], $keyword) !== false
					|| strpos((string) $row['foto_copy'], $keyword) !== false
					|| strpos((string) $row['barang_titipan'], $keyword) !== false
					|| strpos((string) $row['jumlah_penerimaan'], $keyword) !== false
					|| strpos((string) $row['saldo'], $keyword) !== false;
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
			'action'    => base_url().'BKU/Penerimaan/save',
			'button'    => 'Simpan',
			'periode'   => set_value('periode', $periode),
			'auto_load' => !empty($periode),
		);

		$data['BKUPenerimaan'] = 'active';

		$this->template->load('Homeadmin/templateadmin', 'BKU/penerimaan/form', $data);
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
		
		// Ambil kategori penerimaan sesuai tahun
		$kategori = $this->db
			->select('id, nama_kategori_penerimaan, tahun')
			->from('ms_cb_kategori_penerimaan')
			->where('tahun', $tahun)
			->order_by('id', 'ASC')
			->get()
			->result();
		
		$total_saldo = 0;

		$saldo_awal = $this->db
			->where('tahun', $tahun)
			->get('ms_cb_saldo_awal_tahun')
			->row();

		if (!$saldo_awal) {
			echo json_encode(array(
				'status' => 'success',
				'html'   => $this->_html_error(
					'Silahkan tambah saldo awal tahun '.$tahun.' terlebih dahulu ! 
					<a href="'.base_url('MsSaldoAwal').'" class="btn btn-xs btn-primary">+ Saldo</a>'
				),
				'tahun' => $tahun,
				'bulan' => $bulan,
			));
			return;
		}

		$saldo_awal_tahun = (float) $saldo_awal->anggaran;

		if ($bulan == 1) {

			// Januari: saldo awal langsung dari tabel saldo awal tahun
			$total_saldo = $saldo_awal_tahun;

		} else {

			$bulan_prev = $bulan - 1;

			// Cek penerimaan bulan sebelumnya
			$cek_penerimaan_prev = $this->_sum_penerimaan_bulan($tahun, $bulan_prev);

			if (!$cek_penerimaan_prev || (int) $cek_penerimaan_prev->total_data == 0) {
				echo json_encode(array(
					'status' => 'success',
					'html'   => $this->_html_error(
						'Silahkan tambah BKU Penerimaan bulan '.$this->_nama_bulan($bulan_prev).' tahun '.$tahun.' terlebih dahulu ! 
						<a href="'.base_url('BKU/Penerimaan').'" class="btn btn-xs btn-primary">+ BKU Penerimaan</a>'
					),
					'tahun' => $tahun,
					'bulan' => $bulan,
				));
				return;
			}

			// Cek pengeluaran bulan sebelumnya
			$cek_pengeluaran_prev = $this->_sum_pengeluaran_bulan($tahun, $bulan_prev);

			if (!$cek_pengeluaran_prev || (int) $cek_pengeluaran_prev->total_data == 0) {
				echo json_encode(array(
					'status' => 'success',
					'html'   => $this->_html_error(
						'Silahkan tambah BKU Pengeluaran bulan '.$this->_nama_bulan($bulan_prev).' tahun '.$tahun.' terlebih dahulu ! 
						<a href="'.base_url('BKU/Pengeluaran').'" class="btn btn-xs btn-primary">+ BKU Pengeluaran</a>'
					),
					'tahun' => $tahun,
					'bulan' => $bulan,
				));
				return;
			}

			/*
			* Saldo awal bulan berjalan:
			* saldo awal tahun + total penerimaan sampai bulan sebelumnya
			* - total pengeluaran sampai bulan sebelumnya
			*/
			$total_penerimaan_prev = $this->_sum_penerimaan_sampai_bulan($tahun, $bulan_prev);
			$total_pengeluaran_prev = $this->_sum_pengeluaran_sampai_bulan($tahun, $bulan_prev);

			$total_saldo = $saldo_awal_tahun
				+ (float) $total_penerimaan_prev->total
				- (float) $total_pengeluaran_prev->total;
		}

		$html = '';

		$html .= '<tr>';
		$html .= '<th>SALDO AWAL</th>';

		for ($i = 1; $i <= 12; $i++) {
			$html .= '<td class="text-right">-</td>';
		}

		$html .= '<td class="text-right"><b>'.$this->_rupiah($total_saldo).'</b></td>';
		$html .= '<td class="text-center"></td>';
		$html .= '</tr>';

		$html .= '<tr>';
		$html .= '<td>&nbsp;</td>';

		for ($i = 1; $i <= 13; $i++) {
			$html .= '<td class="text-right">-</td>';
		}

		$html .= '<td></td>';
		$html .= '</tr>';

		if (count($kategori) > 0) {

			$sum_angsuran_pokok    = 0;
			$sum_angsuran_bunga    = 0;
			$sum_simpanan_pokok    = 0;
			$sum_simpanan_wajib    = 0;
			$sum_simpanan_tapim    = 0;
			$sum_simpanan_sukarela = 0;
			$sum_angsuran_barang   = 0;
			$sum_penjualan_tunai   = 0;
			$sum_bank              = 0;
			$sum_foto_copy         = 0;
			$sum_barang_titipan    = 0;

			$sum_jml_penerimaan    = 0;
			
			foreach ($kategori as $row) {

				$html .= '<tr>';
				$html .= '<th>'.htmlspecialchars($row->nama_kategori_penerimaan, ENT_QUOTES, 'UTF-8').'</th>';

				$row_penerimaan = $this->db
					->where('tahun', $tahun)
					->where('bulan', $bulan)
					->where('fk_id_ms_kategori_penerimaan', $row->id)
					->get('t_cb_bku_penerimaan')
					->row();

				if ($row_penerimaan) {

					$html .= '<td class="text-right">'.$this->_rupiah_or_dash($row_penerimaan->angsuran_pokok).'</td>';
					$html .= '<td class="text-right">'.$this->_rupiah_or_dash($row_penerimaan->angsuran_bunga).'</td>';
					$html .= '<td class="text-right">'.$this->_rupiah_or_dash($row_penerimaan->simpanan_pokok).'</td>';
					$html .= '<td class="text-right">'.$this->_rupiah_or_dash($row_penerimaan->simpanan_wajib).'</td>';
					$html .= '<td class="text-right">'.$this->_rupiah_or_dash($row_penerimaan->simpanan_tapim).'</td>';
					$html .= '<td class="text-right">'.$this->_rupiah_or_dash($row_penerimaan->simpanan_sukarela).'</td>';
					$html .= '<td class="text-right">'.$this->_rupiah_or_dash($row_penerimaan->angsuran_barang).'</td>';
					$html .= '<td class="text-right">'.$this->_rupiah_or_dash($row_penerimaan->penjualan_tunai).'</td>';
					$html .= '<td class="text-right">'.$this->_rupiah_or_dash($row_penerimaan->bank).'</td>';
					$html .= '<td class="text-right">'.$this->_rupiah_or_dash($row_penerimaan->foto_copy).'</td>';
					$html .= '<td class="text-right">'.$this->_rupiah_or_dash($row_penerimaan->barang_titipan).'</td>';

					$jml_penerimaan = $this->_total_penerimaan_row($row_penerimaan);
					
					$sum_angsuran_pokok    += $row_penerimaan->angsuran_pokok;
					$sum_angsuran_bunga    += $row_penerimaan->angsuran_bunga;
					$sum_simpanan_pokok    += $row_penerimaan->simpanan_pokok;
					$sum_simpanan_wajib    += $row_penerimaan->simpanan_wajib;
					$sum_simpanan_tapim    += $row_penerimaan->simpanan_tapim;
					$sum_simpanan_sukarela += $row_penerimaan->simpanan_sukarela;
					$sum_angsuran_barang   += $row_penerimaan->angsuran_barang;
					$sum_penjualan_tunai   += $row_penerimaan->penjualan_tunai;
					$sum_bank              += $row_penerimaan->bank;
					$sum_foto_copy         += $row_penerimaan->foto_copy;
					$sum_barang_titipan    += $row_penerimaan->barang_titipan;
					$sum_jml_penerimaan	   += $jml_penerimaan;

					$total_saldo += $jml_penerimaan;

					$html .= '<td class="text-right">'.$this->_rupiah_or_dash($jml_penerimaan).'</td>';
					$html .= '<td class="text-right"><b>'.$this->_rupiah($total_saldo).'</b></td>';

				} else {

					for ($i = 1; $i <= 13; $i++) {
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
						<th class="text-center">'.$this->_rupiah_or_dash($sum_angsuran_pokok).'</th>
						<th class="text-center">'.$this->_rupiah_or_dash($sum_angsuran_bunga).'</th>
						<th class="text-center">'.$this->_rupiah_or_dash($sum_simpanan_pokok).'</th>
						<th class="text-center">'.$this->_rupiah_or_dash($sum_simpanan_wajib).'</th>
						<th class="text-center">'.$this->_rupiah_or_dash($sum_simpanan_tapim).'</th>
						<th class="text-center">'.$this->_rupiah_or_dash($sum_simpanan_sukarela).'</th>
						<th class="text-center">'.$this->_rupiah_or_dash($sum_angsuran_barang).'</th>
						<th class="text-center">'.$this->_rupiah_or_dash($sum_penjualan_tunai).'</th>
						<th class="text-center">'.$this->_rupiah_or_dash($sum_bank).'</th>
						<th class="text-center">'.$this->_rupiah_or_dash($sum_foto_copy).'</th>
						<th class="text-center">'.$this->_rupiah_or_dash($sum_barang_titipan).'</th>
						<th class="text-center">'.$this->_rupiah_or_dash($sum_jml_penerimaan).'</th>
						<th class="text-center">'.$this->_rupiah_or_dash($total_saldo).'</th>
					</tr>';

		} else {

			$html .= '<tr>';
			$html .= '<td colspan="15" class="text-center text-danger">';
			$html .= 'Data kategori penerimaan tahun '.$tahun.' belum tersedia.';
			$html .= '</td>';
			$html .= '</tr>';
		}

		echo json_encode(array(
			'status'      => 'success',
			'html'        => $html,
			'tahun'       => $tahun,
			'bulan'       => $bulan,
			'saldo_awal'  => $total_saldo,
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
			->get('ms_cb_kategori_penerimaan')
			->row();

		if (!$kategori) {
			echo '<div class="alert alert-danger">Kategori penerimaan tidak ditemukan.</div>';
			return;
		}

		$row = $this->db
			->where('tahun', $tahun)
			->where('bulan', $bulan)
			->where('fk_id_ms_kategori_penerimaan', $id_kategori)
			->get('t_cb_bku_penerimaan')
			->row();

		$data = array(
			'tahun'       => $tahun,
			'bulan'       => $bulan,
			'nama_bulan' => $this->_nama_bulan($bulan),
			'id_kategori' => $id_kategori,
			'kategori'    => $kategori,
			'row'         => $row,
		);

		$this->load->view('BKU/penerimaan/form_modal', $data);
	}

	public function save_modal()
	{
		header('Content-Type: application/json');
		
		$tahun       = $this->input->post('tahun', true);
		$bulan       = $this->input->post('bulan', true);
		$id_kategori = $this->input->post('fk_id_ms_kategori_penerimaan', true);

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
			'fk_id_ms_kategori_penerimaan'  => $id_kategori,

			'angsuran_pokok'                => $this->_to_decimal($this->input->post('angsuran_pokok', true)),
			'angsuran_bunga'                => $this->_to_decimal($this->input->post('angsuran_bunga', true)),
			'simpanan_pokok'                => $this->_to_decimal($this->input->post('simpanan_pokok', true)),
			'simpanan_wajib'                => $this->_to_decimal($this->input->post('simpanan_wajib', true)),
			'simpanan_tapim'                => $this->_to_decimal($this->input->post('simpanan_tapim', true)),
			'simpanan_sukarela'             => $this->_to_decimal($this->input->post('simpanan_sukarela', true)),
			'angsuran_barang'               => $this->_to_decimal($this->input->post('angsuran_barang', true)),
			'penjualan_tunai'               => $this->_to_decimal($this->input->post('penjualan_tunai', true)),
			'bank'                          => $this->_to_decimal($this->input->post('bank', true)),
			'foto_copy'                     => $this->_to_decimal($this->input->post('foto_copy', true)),
			'barang_titipan'                => $this->_to_decimal($this->input->post('barang_titipan', true)),
		);

		$row = $this->db
			->where('tahun', $tahun)
			->where('bulan', $bulan)
			->where('fk_id_ms_kategori_penerimaan', $id_kategori)
			->get('t_cb_bku_penerimaan')
			->row();

		$this->db->trans_begin();

		if ($row) {
			$this->db
				->where('id', $row->id)
				->update('t_cb_bku_penerimaan', $data);

			$message = 'Data penerimaan berhasil diperbarui.';
		} else {
			$data['user_act'] = $this->session->id;
			$data['time_act'] = date('Y-m-d H:i:s');
			$this->db->insert('t_cb_bku_penerimaan', $data);

			$message = 'Data penerimaan berhasil disimpan.';
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

	private function _sum_penerimaan_sampai_bulan($tahun, $bulan_sampai)
	{
		$row = $this->db
			->select("
				COUNT(*) AS total_data,
				COALESCE(SUM(
					COALESCE(angsuran_pokok, 0) +
					COALESCE(angsuran_bunga, 0) +
					COALESCE(simpanan_pokok, 0) +
					COALESCE(simpanan_wajib, 0) +
					COALESCE(simpanan_tapim, 0) +
					COALESCE(simpanan_sukarela, 0) +
					COALESCE(angsuran_barang, 0) +
					COALESCE(penjualan_tunai, 0) +
					COALESCE(bank, 0) +
					COALESCE(foto_copy, 0) +
					COALESCE(barang_titipan, 0)
				), 0) AS total
			", false)
			->from('t_cb_bku_penerimaan')
			->where('tahun', $tahun)
			->where('bulan <=', $bulan_sampai)
			->get()
			->row();

		return $row;
	}

	private function _sum_penerimaan_bulan($tahun, $bulan)
	{
		$row = $this->db
			->select("
				COUNT(*) AS total_data,
				COALESCE(SUM(
					COALESCE(angsuran_pokok, 0) +
					COALESCE(angsuran_bunga, 0) +
					COALESCE(simpanan_pokok, 0) +
					COALESCE(simpanan_wajib, 0) +
					COALESCE(simpanan_tapim, 0) +
					COALESCE(simpanan_sukarela, 0) +
					COALESCE(angsuran_barang, 0) +
					COALESCE(penjualan_tunai, 0) +
					COALESCE(bank, 0) +
					COALESCE(foto_copy, 0) +
					COALESCE(barang_titipan, 0)
				), 0) AS total
			", false)
			->from('t_cb_bku_penerimaan')
			->where('tahun', $tahun)
			->where('bulan', $bulan)
			->get()
			->row();

		return $row;
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

	private function _total_penerimaan_row($row)
	{
		return
			(float) $row->angsuran_pokok +
			(float) $row->angsuran_bunga +
			(float) $row->simpanan_pokok +
			(float) $row->simpanan_wajib +
			(float) $row->simpanan_tapim +
			(float) $row->simpanan_sukarela +
			(float) $row->angsuran_barang +
			(float) $row->penjualan_tunai +
			(float) $row->bank +
			(float) $row->foto_copy +
			(float) $row->barang_titipan;
	}

	private function _getSaldoAwalTahun($tahun)
	{
		$row = $this->db
			->select('COALESCE(SUM(anggaran), 0) AS total', false)
			->from('ms_cb_saldo_awal_tahun')
			->where('tahun', $tahun)
			->get()
			->row();

		return $row ? (float) $row->total : 0;
	}

	private function _getSaldoBulanBerjalan($tahun, $bulan)
	{
		$saldoAwalTahun = $this->_getSaldoAwalTahun($tahun);

		$totalPenerimaan = $this->_sum_penerimaan_sampai_bulan($tahun, $bulan);

		$totalPengeluaran = 0;

		if ($bulan > 1) {
			$pengeluaranSampaiBulanLalu = $this->_sum_pengeluaran_sampai_bulan($tahun, $bulan - 1);
			$totalPengeluaran = $pengeluaranSampaiBulanLalu
				? (float) $pengeluaranSampaiBulanLalu->total
				: 0;
		}

		$totalPenerimaanNilai = $totalPenerimaan
			? (float) $totalPenerimaan->total
			: 0;

		return $saldoAwalTahun + $totalPenerimaanNilai - $totalPengeluaran;
	}

	private function _getRekapPenerimaanBulanan($tahun = null)
	{
		$this->db->select("
			tahun,
			bulan,

			COALESCE(SUM(angsuran_pokok), 0) AS angsuran_pokok,
			COALESCE(SUM(angsuran_bunga), 0) AS angsuran_bunga,

			COALESCE(SUM(simpanan_pokok), 0) AS simpanan_pokok,
			COALESCE(SUM(simpanan_wajib), 0) AS simpanan_wajib,
			COALESCE(SUM(simpanan_tapim), 0) AS simpanan_tapim,
			COALESCE(SUM(simpanan_sukarela), 0) AS simpanan_sukarela,

			COALESCE(SUM(angsuran_barang), 0) AS angsuran_barang,
			COALESCE(SUM(penjualan_tunai), 0) AS penjualan_tunai,
			COALESCE(SUM(bank), 0) AS bank,
			COALESCE(SUM(foto_copy), 0) AS foto_copy,
			COALESCE(SUM(barang_titipan), 0) AS barang_titipan,

			COALESCE(SUM(
				COALESCE(angsuran_pokok, 0) +
				COALESCE(angsuran_bunga, 0) +
				COALESCE(simpanan_pokok, 0) +
				COALESCE(simpanan_wajib, 0) +
				COALESCE(simpanan_tapim, 0) +
				COALESCE(simpanan_sukarela, 0) +
				COALESCE(angsuran_barang, 0) +
				COALESCE(penjualan_tunai, 0) +
				COALESCE(bank, 0) +
				COALESCE(foto_copy, 0) +
				COALESCE(barang_titipan, 0)
			), 0) AS jumlah_penerimaan
		", false);

		$this->db->from('t_cb_bku_penerimaan');
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
<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Simulasi extends CI_Controller
{

	function __construct()
	{
		parent::__construct();
		$this->load->library('datatables');
		$this->load->model('MHome');
		// $this->load->model('MMscbUseranggota');
		// $this->load->model('MMscbSkpd');
		// $this->load->model('MMscbStatuspekerjaan');
		// $this->load->model('MMsCabang');
	}

	public function index()
	{
		$this->MHome->ceklogin();
		$data = null;
		$data['Simulasi'] = 'active';
		// $data['arrAnggota'] = $this->MMscbSkpd->get();
		// $data['arrcabang'] = $this->MMsCabang->get();
		$this->template->load('Homeanggota/templateanggota', 'Simulasi/list', $data);
	}

	public function getListDetail()
	{
		$this->MHome->ceklogin();
		$data['act_add'] = base_url() . 'MscbAnggota/create';
		$data['skpd'] = $this->input->post('skpd');
		// $data['tgl_dari'] = $this->input->post('tgl_dari');
		// $data['tgl_sampai'] = $this->input->post('tgl_sampai');

		$this->load->view('MscbAnggota/listDetail', $data);
	}

	public function getTableSimulasi()
	{
		$this->MHome->ceklogin();

		$sisagajipokok = $this->input->post('sisagajipokok');
		$strreplacesisagajipokok = str_replace(",", "", $sisagajipokok);
		$intsisagajipokok = intval($strreplacesisagajipokok);

		$jumlahpinjam = $this->input->post('jumlahpinjam');
		$strreplacejumlahpinjam = str_replace(",", "", $jumlahpinjam);
		$intjumlahpinjam = intval($strreplacejumlahpinjam);

		$jumlahangsuran = $this->input->post('jumlahangsuran');
		$strreplacejumlahangsuran = str_replace(",", "", $jumlahangsuran);
		$intjumlahangsuran = intval($strreplacejumlahangsuran);

		$sisamasajabatan = $this->input->post('sisamasajabatan');
		$strreplacesisamasajabatan = str_replace(",", "", $sisamasajabatan);
		$intsisamasajabatan = intval($strreplacesisamasajabatan);

		$pokok = $intjumlahpinjam / $intjumlahangsuran;
		$tapim = (10 / 100) * $pokok;
		$bunga = (0.75 / 100) * $intjumlahpinjam;

		$pokokpembulatan = round($pokok);
		$tapimpembulatan = round($tapim);
		$bungapembulatan = round($bunga);

		$jumlahtagihan = $pokokpembulatan + $tapimpembulatan + $bungapembulatan;

		$arraytemp = [];

		for ($i = 0; $i < $intjumlahangsuran; $i++) {
			$temp_angsuran_ke = $i + 1;
			$arraytemp[$i]['angsuranke'] = $temp_angsuran_ke;
			$temp_pokok = $intjumlahpinjam / $temp_angsuran_ke;
			$arraytemp[$i]['pokok'] = round($temp_pokok);
			$temp_tapim = (10 / 100) * $temp_pokok;
			$arraytemp[$i]['tapim'] = round($temp_tapim);
			$temp_bunga = (0.75 / 100) * $intjumlahpinjam;
			$arraytemp[$i]['bunga'] = round($temp_bunga);
			$temp_total_angsuran = $temp_pokok + $temp_tapim + $temp_bunga;
			$arraytemp[$i]['total_angsuran'] = round($temp_total_angsuran);
		}

		$data['sisagajipokok'] = $intsisagajipokok;
		$data['jumlahpinjam'] = $intjumlahpinjam;
		$data['jumlahangsuran'] = $intjumlahangsuran;
		$data['sisamasajabatan'] = $intsisamasajabatan;
		// $data['pokok'] = $pokokpembulatan;
		// $data['tapim'] = $tapimpembulatan;
		// $data['bunga'] = $bungapembulatan;
		// $data['jumlahtagihan'] = $jumlahtagihan;
		$data['perhitungan_simulasi'] = $arraytemp;

		$this->load->view('Simulasi/listDetailsimulasi', $data);
	}

	public function getDatatables()
	{
		$this->MHome->ceklogin();
		header('Content-Type: application/json');

		$skpd = $this->input->post('skpd');
		// $tgl_dari = $this->input->post('tgl_dari');
		// $tgl_sampai = $this->input->post('tgl_sampai');

		if ($skpd != '') {
			$this->datatables->where('a.fk_id_skpd', $skpd);
		}

		// if ($tgl_dari != '') {
		// 	$this->datatables->where("p.tgl >=", $this->help->ReverseTgl($tgl_dari));
		// 	$this->datatables->where("p.tgl <=", $this->help->ReverseTgl($tgl_sampai));
		// }

		$this->datatables->select("
		a.id,
		a.nama,
		a.alamat,
		a.nik,
		a.nip,
		a.nomor_hp,
		a.jenis_kelamin,
		a.status_keaktifan,
		a.simpanan_pokok,
		s.nama_skpd");
		$this->datatables->from("ms_cb_user_anggota a");
		$this->datatables->join('ms_cb_skpd s', 'a.fk_id_skpd=s.id', 'inner');
		$this->db->order_by('id', 'asc');
		$this->datatables->add_column('action', '<div class="btn-group">' . anchor(site_url('MscbAnggota/update/$1'), '<i title="edit" class="glyphicon glyphicon-edit icon-white"></i>', 'class="btn btn-xs btn-success"') . anchor(site_url('MscbAnggota/delete/$1'), '<i title="hapus" class="glyphicon glyphicon-trash icon-white"></i>', 'class="btn btn-xs btn-danger" onclick="javasciprt: return confirm(\'Apakah anda yakin?\')"') . anchor(site_url('MscbAnggota/resetpassword/$1'), '<i title="reset password" class="glyphicon glyphicon-refresh icon-white"></i>', 'class="btn btn-xs btn-warning" onclick="javasciprt: return confirm(\'Apakah anda yakin?\')"') . '</div>', 'id');

		echo $this->datatables->generate();
	}

	public function create()
	{
		$this->MHome->ceklogin();
		$data = array(
			'action' => base_url() . 'MscbAnggota/save',
			'button' => 'Simpan',
			'id' => set_value('id'),
			'nama' => set_value('nama'),
			'alamat' => set_value('alamat'),
			'nik' => set_value('nik'),
			'nip' => set_value('nip'),
			'nomor_hp' => set_value('nomor_hp'),
			'jenis_kelamin' => set_value('jenis_kelamin'),
			'fk_id_status_pekerjaan' => set_value('fk_id_status_pekerjaan'),
			'fk_id_skpd' => set_value('fk_id_skpd'),
			'status_keaktifan' => set_value('status_keaktifan'),
			'simpanan_pokok' => set_value('simpanan_pokok'),
			'keterangan' => set_value('keterangan'),
		);

		$data['MscbAnggota'] = 'active';
		$data['act_back'] = base_url() . 'MscbAnggota';
		$data['arrStatuspekerjaan'] = $this->MMscbStatuspekerjaan->get();
		$data['arrSkpd'] = $this->MMscbSkpd->get();
		// $data['arrcabang'] = $this->MMsCabang->get(array('status'=>1));
		$this->template->load('Homeadmin/templateadmin', 'MscbAnggota/form', $data);
	}

	public function update($id)
	{
		$this->MHome->ceklogin();
		$kat = $this->db->query("SELECT * FROM ms_cb_user_anggota WHERE id=$id")->row();

		$data = array(
			'action' => base_url() . 'MscbAnggota/save',
			'button' => 'Update',
			'id' => set_value('id', $kat->id),
			'nama' => set_value('nama', $kat->nama),
			'alamat' => set_value('alamat', $kat->alamat),
			'nik' => set_value('nik', $kat->nik),
			'nip' => set_value('nip', $kat->nip),
			'nomor_hp' => set_value('nomor_hp', $kat->nomor_hp),
			'jenis_kelamin' => set_value('jenis_kelamin', $kat->jenis_kelamin),
			'fk_id_status_pekerjaan' => set_value('fk_id_status_pekerjaan', $kat->fk_id_status_pekerjaan),
			'fk_id_skpd' => set_value('fk_id_skpd', $kat->fk_id_skpd),
			'status_keaktifan' => set_value('status_keaktifan', $kat->status_keaktifan),
			'simpanan_pokok' => set_value('simpanan_pokok', $kat->simpanan_pokok),
			'keterangan' => set_value('keterangan', $kat->keterangan),
		);
		$data['MsPelanggan'] = 'active';
		$data['act_back'] = base_url() . 'MscbAnggota';
		$data['arrStatuspekerjaan'] = $this->MMscbStatuspekerjaan->get();
		$data['arrSkpd'] = $this->MMscbSkpd->get();
		$this->template->load('Homeadmin/templateadmin', 'MscbAnggota/form', $data);
	}

	public function save()
	{
		$this->MHome->ceklogin();
		$id = $this->input->post('id');

		$data['user_act'] = $this->session->id;
		$data['time_act'] = date('Y-m-d H:i:s');

		if (empty($id)) {
			$last = $this->db->query("SELECT id FROM ms_cb_user_anggota ORDER BY id DESC LIMIT 1")->row();
			$castint = intval($last->id);
			$caststring = strval($castint);
			$panjanghuruf = strlen($caststring);

			$idnew = $castint + 1;
			$stringidnew = strval($idnew);

			$finalidnew = '';

			if ($panjanghuruf == 1) {
				$stringnull = "00000";
				$finalidnew = $stringnull . '' . $stringidnew;
			} else if ($panjanghuruf == 2) {
				$stringnull = "0000";
				$finalidnew = $stringnull . '' . $stringidnew;
			} else if ($panjanghuruf == 3) {
				$stringnull = "000";
				$finalidnew = $stringnull . '' . $stringidnew;
			} else if ($panjanghuruf == 4) {
				$stringnull = "00";
				$finalidnew = $stringnull . '' . $stringidnew;
			} else if ($panjanghuruf == 5) {
				$stringnull = "0";
				$finalidnew = $stringnull . '' . $stringidnew;
			} else if ($panjanghuruf == 6) {
				$finalidnew = $stringidnew;
			}

			$data['id'] = $finalidnew;
			$data['username'] = $finalidnew;
			$data['password'] = md5('admin');
			$data['nama'] = $this->input->post('nama');
			$data['alamat'] = $this->input->post('alamat');
			$data['nik'] = $this->input->post('nik');
			$data['nip'] = $this->input->post('nip');
			$data['nomor_hp'] = $this->input->post('nomor_hp');
			$data['jenis_kelamin'] = $this->input->post('jenis_kelamin');
			$data['fk_id_status_pekerjaan'] = $this->input->post('fk_id_status_pekerjaan');
			$data['fk_id_skpd'] = $this->input->post('fk_id_skpd');
			$data['status_keaktifan'] = $this->input->post('status_keaktifan');
			$data['simpanan_pokok'] = str_replace(',', '', $this->input->post('simpanan_pokok'));
			$data['keterangan'] = $this->input->post('keterangan');

			$this->MMscbUseranggota->insert($data);
			$this->session->set_flashdata('success', 'Data Berhasil disimpan.');
		} else {
			$data['id'] = $id;
			$data['nama'] = $this->input->post('nama');
			$data['alamat'] = $this->input->post('alamat');
			$data['nik'] = $this->input->post('nik');
			$data['nip'] = $this->input->post('nip');
			$data['nomor_hp'] = $this->input->post('nomor_hp');
			$data['jenis_kelamin'] = $this->input->post('jenis_kelamin');
			$data['fk_id_status_pekerjaan'] = $this->input->post('fk_id_status_pekerjaan');
			$data['fk_id_skpd'] = $this->input->post('fk_id_skpd');
			$data['status_keaktifan'] = $this->input->post('status_keaktifan');
			$data['simpanan_pokok'] = str_replace(',', '', $this->input->post('simpanan_pokok'));
			$data['keterangan'] = $this->input->post('keterangan');

			$this->MMscbUseranggota->update($id, $data);
			$this->session->set_flashdata('success', 'Data Berhasil diupdate.');
		}

		redirect('MscbAnggota');
	}

	public function prosesKirimWA()
	{
		$this->MHome->ceklogin();
		$id = $this->input->post('id');
		$hsl = $this->MMsPelanggan->get(array('id' => $id));
		$hsl = $hsl[0];

		$kpd = 'Ibu ';
		if ($hsl['jenis_kel'] == 'L') {
			$kpd = 'Bapak ';
		}
		$kpdnya = $kpd . $hsl['nama'];

		$pesan = "Hallo *$kpdnya* Pelanggan Setia SNAP PIJAT!!! Anda capek? Badan Pegal-Pegal ? Sudah waktunya Pijat lagi nih, Yukk Buruan Datang ke SNAP PIJAT. Jangan sampai Capekmu mengganggu Produktifitasmu.";
		$this->help->kirim_wa($hsl['no_hp'], $pesan);

		$data2['notif'] = 'Pengiriman ke No WA Pelanggan telah berhasil.';
		echo json_encode($data2);
	}

	public function delete($id)
	{
		$this->MHome->ceklogin();
		// if($this->session->fk_level_id==1){
		$result = $this->MMscbUseranggota->delete($id);
		if ($result) {
			$this->session->set_flashdata('success', 'Data berhasil dihapus.');
		} else {
			$this->session->set_flashdata('error', 'Data hanya bisa diupdate');
		}
		// }else{
		// 	$this->session->set_flashdata('error', 'Data hanya bisa diupdate');
		// }

		redirect('MscbAnggota');
	}

	public function resetpassword($id)
	{
		$this->MHome->ceklogin();
		$data['password'] = md5('admin');
		// if($this->session->fk_level_id==1){
		$this->MMscbUseranggota->update($id, $data);
		$this->session->set_flashdata('success', 'Data berhasil direset passwordnya.');
		// if ($result) {
		// 	$this->session->set_flashdata('success', 'Data berhasil direset passwordnya.');
		// } else {
		// 	$this->session->set_flashdata('error', 'Data gagal direset passwordnya.');
		// }
		// }else{
		// 	$this->session->set_flashdata('error', 'Data hanya bisa diupdate');
		// }

		redirect('MscbAnggota');
	}

	public function viewRiwayat($id)
	{
		$this->MHome->ceklogin();
		$query = "SELECT kode,tgl,nama_paket,nama_terapis,mc.nama_cabang FROM t_pos_detail td 
			INNER JOIN t_pos t ON t.id=td.fk_pos_id
			INNER JOIN ms_cabang mc ON mc.id=t.fk_cabang_id
			WHERE t.fk_pelanggan_id=$id
			ORDER BY tgl DESC";
		$data['hasil'] =  $this->db->query($query)->result();

		$this->template->load('Home/template', 'MsPelanggan/viewRiwayat', $data);
	}

	public function ubahPswd()
	{
		$data = array(
			'pswdLama' => set_value('pswdLama'),
			'pswdBaru' => set_value('pswdBaru'),
			'ulangiPswdBaru' => set_value('ulangiPswdBaru'),
		);
		if (isset($_POST['pswdBaru'])) {
			$pswdLama = $this->input->post('pswdLama');
			$pswdBaru = $this->input->post('pswdBaru');
			$ulangiPswdBaru = $this->input->post('ulangiPswdBaru');

			if (md5($pswdLama) != $this->session->password) {
				$this->session->set_flashdata('error', 'Password Lama tidak sesuai.');
				$error = true;
			} else if ($pswdBaru != $ulangiPswdBaru) {
				$this->session->set_flashdata('error', 'Ulangi Password Baru harus sama dengan Password baru.');
				$error = true;
			} else {
				$dataUpdate['password'] = md5($pswdBaru);
				$dataUpdate['user_act'] = $this->session->id;
				$dataUpdate['time_act'] = date('Y-m-d H:i:s');
				$this->MMscbUseranggota->update($this->session->id, $dataUpdate);
				$error = false;
				$this->session->set_flashdata('success', 'Password Berhasil diubah, silahkan logout dan login kembali dengan password yg baru.');
			}

			if ($error) {
				$data = array(
					'pswdLama' => set_value('pswdLama', $pswdLama),
					'pswdBaru' => set_value('pswdBaru', $pswdBaru),
					'ulangiPswdBaru' => set_value('ulangiPswdBaru', $ulangiPswdBaru),
				);
			} else {
				$data['pswdLama'] = '';
				$data['pswdBaru'] = '';
				$data['ulangiPswdBaru'] = '';
			}
		}

		$this->template->load('Homeanggota/templateanggota', 'MscbAnggota/formUbahPswd', $data);
	}
}

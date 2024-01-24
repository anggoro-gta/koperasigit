<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Home extends CI_Controller {

	// function __construct(){
	// 	parent::__construct();

	// }

	public function index(){
		$data['contents']=null;
		
		// $data['arrOpd'] = $this->db->query("SELECT * FROM ms_opd")->result();
		$this->template->load('Home/template','Home/beranda',$data);
	}

	public function saveUpload(){
		if (isset($_FILES["fileExcel"]["name"])) {
			$path = $_FILES["fileExcel"]["tmp_name"];
			$object = PHPExcel_IOFactory::load($path);

			foreach($object->getWorksheetIterator() as $worksheet) {
				$highestRow = $worksheet->getHighestRow();
				$highestColumn = $worksheet->getHighestColumn();	
				for($row=3; $row<=$highestRow; $row++){
					$nik = $worksheet->getCellByColumnAndRow(1, $row)->getValue();
					if($nik!=''){
						$nama = $worksheet->getCellByColumnAndRow(2, $row)->getValue();
						$lhr = $worksheet->getCellByColumnAndRow(3, $row)->getValue();   
						$tglLhr = date('d/m/Y', $lhr); 
						$kecamatan = $worksheet->getCellByColumnAndRow(4, $row)->getValue();
						$desa = $worksheet->getCellByColumnAndRow(5, $row)->getValue();
						$alamat = $worksheet->getCellByColumnAndRow(6, $row)->getValue();

						$status_di_p3ke=0;
						$idnya=null;
						$id_kel_p3ke=null;
						$hub_keluarga=null;
						$desil=null;
						$is_validasi_nik='Ada';
						$is_validasi_nama='Ada';
						$is_validasi_tgl_lhr='Ada';
						$ket = '';

						$cek = $this->db->query("SELECT id,id_kel_p3ke,hub_keluarga,desil FROM ms_perbup_p3ke WHERE nik != 0 AND nik='$nik'")->row();
						if($cek){
							$status_di_p3ke=1;
							$idnya=$cek->id;
							$id_kel_p3ke=$cek->id_kel_p3ke;
							$hub_keluarga=$cek->hub_keluarga;
							$desil=$cek->desil;
						}
						else{				
							$is_validasi_nik='Tidak Ada';			
							// $criPetik = (strpbrk($nama, "'"));
							// if($criPetik){
							$nama = str_replace("'", "`", $nama);
							// 	die(var_dump($nama));
							// }

							$ket .= 'NIK, ';

							$cekNama = $this->db->query("SELECT id,id_kel_p3ke,hub_keluarga,desil FROM ms_perbup_p3ke WHERE kecamatan='$kecamatan' AND desa='$desa' AND nama='$nama'")->row();						
							if($cekNama){
								$idnya=$cekNama->id;
								// $id_kel_p3ke=$cekNama->id_kel_p3ke;
								$hub_keluarga=$cekNama->hub_keluarga;
								$desil=$cekNama->desil;
							}else{
								$ket .= 'NAMA, ';
								$is_validasi_nama='Tidak Ada';
								$cekTL = $this->db->query("SELECT id,id_kel_p3ke,nama,hub_keluarga,desil FROM ms_perbup_p3ke WHERE kecamatan='$kecamatan' AND desa='$desa' AND DATE_FORMAT(tgl_lahir,'%d/%m/%Y')='$tglLhr'")->row();
								if($cekTL){
									$idnya=$cekTL->id;
									// $id_kel_p3ke=$cekTL->id_kel_p3ke;
									$hub_keluarga=$cekTL->hub_keluarga;
									$desil=$cekTL->desil;
									// $namaTdftr=$cekTL->nama;
								}else{
									$ket .= 'Tgl Lhr, ';
									$is_validasi_tgl_lhr='Tidak Ada';
								}
							}
							$ket .= 'Tidak Ada';
						}					

						$temp_data[] = array(
							'nik'	=> $nik,
							'nama'	=> $nama,
							'tgl_lahir'	=> $tglLhr,
							'kecamatan'	=> $kecamatan,
							'desa'	=> $desa,
							'alamat' => $alamat,
							'keterangan' => $ket,
							'status_di_p3ke' => $status_di_p3ke,
							'desil' => $desil,
							'hub_keluarga' => $hub_keluarga,
							'is_validasi_nik' => $is_validasi_nik,
							'is_validasi_nama' => $is_validasi_nama,
							'is_validasi_tgl_lhr' => $is_validasi_tgl_lhr
						); 
					}	
				}

				// $insert = $this->db->insert_batch('t_hasil_pengecekan', $temp_data);
				// if($insert){
					// $this->session->set_flashdata('success', 'file berhasil diupload. Silahkan Buka File di Folder Download.');
				// }else{
				// 	$this->session->set_flashdata('error', 'file gagal diupload.');
				// }

				$data['hasil'] = $temp_data;

				$html = $this->load->view('Home/hasil_excel', $data, true);
				$title = 'Hsl Cek Data P3KE-'.date('dmY');

				$this->excel($title, $html);

				// $this->session->set_flashdata('success', 'file berhasil diupload. Silahkan Buka File di Folder Download.');
			}

		}else{
			$this->session->set_flashdata('error', 'Tidak ada file yang masuk.');
		}

		// redirect('Home');
	}

	protected function excel($title, $html, $ext = 'xls'){
		header("Content-type: application/x-msdownload");
		header("Content-Disposition: attachment; filename=$title.$ext");
		header("Pragma: no-cache");
		header("Expires: 0");
		echo $html;
	}

}

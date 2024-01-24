<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Help{
	public function __construct(){
      $this->ci =& get_instance();
    }

	public function labelnya(){
		return 'Isian dengan tanda (<span style="color:red">*</span>) tidak boleh kosong';
	}

	public function MoneyToDouble($num) {
        if (substr($num, 0, 1) == '(') {
            $num = '-'.preg_replace('/[\(\)]/', '', $num);
        }

        return $num = (double) str_replace(',', '', $num);
    }

    public function ReverseTgl($tgl) {
        $tgl = explode('-', $tgl);
        if (count($tgl) != 3)
            return $tgl[0];
        $tmp = '';
        for ($i = count($tgl) - 1; $i >= 0; $i--) {
            $tmp .= $tgl[$i] . '-';
        }
        $tmp = substr($tmp, 0, strlen($tmp) - 1);
        $tgl = $tmp;
        //$tgl[2] . '-' . $tgl[1] . '-' . $tgl[0];
        return $tgl;
    }

    public function namaBulan($x=null) { 
        $bulan = array(
                    '01'=>'Januari',
                    '02'=>'Februari',
                    '03'=>'Maret',
                    '04'=>'April',
                    '05'=>'Mei',
                    '06'=>'Juni',
                    '07'=>'Juli',
                    '08'=>'Agustus',
                    '09'=>'September',
                    '10'=>'Oktober',
                    '11'=>'November',
                    '12'=>'Desember'
                );
        if($x){
            return $bulan[$x];
        }
        
        return $bulan;
    }

    public function namaHari($tgl) { 
        $tbt = explode('-', $tgl);
        $info=date('w', mktime(0,0,0,$tbt[1],$tbt[0],$tbt[2]));    
        switch($info){
            case '0': return "Minggu"; break;
            case '1': return "Senin"; break;
            case '2': return "Selasa"; break;
            case '3': return "Rabu"; break;
            case '4': return "Kamis"; break;
            case '5': return "Jum'at"; break;
            case '6': return "Sabtu"; break;
        };
    }

    public function mkdir_nya($target_dir){
        if((!file_exists($target_dir))&&(!is_dir($target_dir))){
            mkdir('./'.$target_dir,0777,true);
            $indx=fopen($target_dir.'/'.'index.php','w');
            fwrite($indx,'<!DOCTYPE html>
                        <html>
                        <head>
                            <title>403 Forbidden</title>
                        </head>
                        <body>
                        <p>Directory access is forbidden.</p>
                        </body>
                        </html>');
            fclose($indx);
        }
    }

    public function terbilang ($angka) {
        $angka = (float)$angka;
        $bilangan = array('','Satu','Dua','Tiga','Empat','Lima','Enam','Tujuh','Delapan','Sembilan','Sepuluh','Sebelas');
        if ($angka < 12) {
            return $bilangan[$angka];
        } else if ($angka < 20) {
            return $bilangan[$angka - 10] . ' Belas';
        } else if ($angka < 100) {
            $hasil_bagi = (int)($angka / 10);
            $hasil_mod = $angka % 10;
            return trim(sprintf('%s Puluh %s', $bilangan[$hasil_bagi], $bilangan[$hasil_mod]));
        } else if ($angka < 200) { return sprintf('Seratus %s', $this->terbilang($angka - 100));
        } else if ($angka < 1000) { $hasil_bagi = (int)($angka / 100); $hasil_mod = $angka % 100; return trim(sprintf('%s Ratus %s', $bilangan[$hasil_bagi], $this->terbilang($hasil_mod)));
        } else if ($angka < 2000) { return trim(sprintf('Seribu %s', $this->terbilang($angka - 1000)));
        } else if ($angka < 1000000) { $hasil_bagi = (int)($angka / 1000); $hasil_mod = $angka % 1000; return sprintf('%s Ribu %s', $this->terbilang($hasil_bagi), $this->terbilang($hasil_mod));
        } else if ($angka < 1000000000) { $hasil_bagi = (int)($angka / 1000000); $hasil_mod = $angka % 1000000; return trim(sprintf('%s Juta %s', $this->terbilang($hasil_bagi), $this->terbilang($hasil_mod)));
        } else if ($angka < 1000000000000) { $hasil_bagi = (int)($angka / 1000000000); $hasil_mod = fmod($angka, 1000000000); return trim(sprintf('%s Milyar %s', $this->terbilang($hasil_bagi), $this->terbilang($hasil_mod)));
        } else if ($angka < 1000000000000000) { $hasil_bagi = $angka / 1000000000000; $hasil_mod = fmod($angka, 1000000000000); return trim(sprintf('%s Triliun %s', $this->terbilang($hasil_bagi), $this->terbilang($hasil_mod)));
        } else {
            return 'Data Salah';
        }
    }

    public function headerLaporan(){
        $html = " 
            <table width='100%' style='text-align:center;font-family: arial;font-size:11pt;'>
                <tr>
                    <td valign='top' rowspan='5' width='100px'><img src='".base_url()."assets_login/images/logo.png' width='110px' height='100px'></td>
                    <td style='font-size:14pt'><b>Nama</b></td>
                </tr>
                <tr>
                    <td style='font-size:14pt'><b>TESTING</b></td>
                </tr>
                <tr>
                    <td>Alamat</td>
                </tr>
                <tr>
                    <td>Website </td>
                </tr>
            </table>
            <hr style='color:black'>
        ";

        return $html;
    }

    public function kirim_wa($noHP,$pesan){
        $curl = curl_init();

        curl_setopt_array($curl, array(
          CURLOPT_URL => "https://api.fonnte.com/send",
          CURLOPT_RETURNTRANSFER => true,
          CURLOPT_ENCODING => "",
          CURLOPT_MAXREDIRS => 10,
          CURLOPT_TIMEOUT => 0,
          CURLOPT_FOLLOWLOCATION => true,
          CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
          CURLOPT_CUSTOMREQUEST => "POST",
          CURLOPT_POSTFIELDS => array(
            'target' => $noHP,
            'type' => 'text',
            'message' => $pesan,
            'delay' => '1',
            'schedule' => '0'),
          CURLOPT_HTTPHEADER => array(
            "Authorization: TxrICpy!HaBupwh8sIix"
          ),
        ));

        $response = curl_exec($curl);

        curl_close($curl);
        // echo $response;
        // sleep(1); #do not delete!
    }

    public function folio_P(){
        return array(216,330);
    }

    public function folio_L(){
        return array(330,216);
    }

    public function f5_P(){
        return array(165,210);
    }

    public function f5_L(){
        return array(210,165);
    }
}
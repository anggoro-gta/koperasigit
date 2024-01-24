<!doctype html>
<html>
    <head>
        <title>Cetak Nota</title>
    </head>
	<style>
		.center{
			text-align: center;
		}
	</style>
    <!-- <body onload="window.print()" style="margin:0" > -->
        <div class="responsive">
			<table width="400" style='font-size:11pt; font-family: "Arial Narrow", Arial, sans-serif; line-height: 15pt;' border="0">
				<tr>
					<td class="center" style="font-size: 14pt"><b><?=$cabang->nama_cabang?></b></td>
				</tr>
				<tr>
					<td class="center">Alamat : <?=$cabang->alamat?></td>
				</tr>
				<tr>
					<td class="center">Telp/WA :<?=$cabang->no_tlp?></td>
				</tr>
				<tr>
					<td style="text-align: center">
						<div style="border-bottom:1px solid black;"></div>
					</td>
				</tr>
				<tr>
					<td valign="top" class="center"> No  : <?=$pos->kode; ?> &nbsp; | &nbsp; Tgl : <?=$this->help->ReverseTgl($pos->tgl); ?></td>
				</tr> 
				<tr>
					<td valign="top" class="center" > Pelanggan : <?=ucwords(strtolower($pos->nama_pelanggan)); ?> &nbsp; | &nbsp; Kasir : <?=ucwords(strtolower($kasir->nama_lengkap)); ?></td>
				</tr>
				<tr>                                                 
					<td>
						<div style="border-bottom:1px solid black;"></div>
					</td>
				</tr>
			    <tr>
				    <td>
				    	<table border="0" cellspacing="-1" class="" style="font-size: 10pt">
				    		<tr>
				    			<th style="vertical-align: middle;" class="center" width="5%">No</th>
					    		<th style="vertical-align: middle;" class="center" width="40%">Paket</th>
						      	<th style="vertical-align: middle;" class="center" width="20%">Terapis</th>
						      	<th style="vertical-align: middle;" class="center" width="20%">Harga</th>
						    </tr>
					    	<?php $no = 1; $total=0; ?>
						    <?php foreach ((array)$detail as $val) { ?>
						    	<tr>
						    		<td align="center"><?=$no++?>.</td>
						    		<td align="center"><?=$val->nama_paket?></td>
						    		<td align="center"><?=ucwords(strtolower($val->nama_terapis))?></td>
						    		<td align="right"><?=number_format($val->nominal_paket)?></td>
						    	</tr>
						    <?php $total+=$val->nominal_paket; } ?>
							<tr>                                                 
								<td colspan="4"><div style="border-bottom:1px solid black;"></div></td>
							</tr>
							<tr>
								<td colspan="3" align="center"><b>Total</b></td>
								<td align="right"><b><?=number_format($total)?></b></td>
							</tr>
				    	</table>
				    </td>		      
			    </tr>
				<tr>
					<td>
						<div style="border-bottom:1px dashed black;"></div>
					</td>
				</tr>
				<tr>
					<td class="center" style="font-size: 10pt">TERIMAKASIH ATAS KUNJUNGAN ANDA</td>
				</tr>
				<tr>
					<td class="center" style="font-size: 10pt">INFO & SARAN : <?=$cabang->no_tlp?></td>
				</tr>
				<tr>
					<td class="center" style="font-size: 10pt">Follow Instagram Kami @snap.pijat</td>
				</tr>
			</table>
		</div>
	</body>
</html>

<!-- <table width="250" style="font-size:9pt">
	<tr id="trTombol">
		<td colspan="10" class="center">
			<a href="<?= base_url() ?>Pos/" class="btn btn-sm btn-warning"><i class="glyphicon glyphicon-chevron-left"></i> Kembali</a>
			<a class="btn btn-sm btn-success" onClick="cetak(document.getElementById('trTombol'));"><i class="glyphicon glyphicon-print"></i> Cetak</a>
		</td>
	</tr>
</table> -->
<script type="text/JavaScript">
	$(document).ready(function(){
 	$(document).keyup(function(e) {
	 	if(e.which == 13) {
	        cetak(document.getElementById('trTombol'));
	    }
	});
});
    function cetak(tombol){
        tombol.style.visibility='collapse';
        if(tombol.style.visibility=='collapse'){
        	window.print();
            window.location.href="<?= base_url() ?>Pos/create";
        }
    }

</script>


<style type="text/css">
    .bordersolid {
        border: 1px solid black;
        border-collapse: collapse;
    }
</style>
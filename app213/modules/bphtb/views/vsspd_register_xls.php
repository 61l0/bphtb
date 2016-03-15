<?php 
header("Content-type: application/octet-stream");
header("Content-Disposition: attachment; filename=sspd_register.xls");
header("Pragma: no-cache");
header("Expires: 0");
?>
<br>PEMERINTAH <?=$daerah?>
<br><?=$dinas?>
<br>REGISTER SSPD
<br>Tanggal <?=$from?> s.d. <?=$to?>
<p>
<table border='1' width="70%">
				<tr>
					<td>No</td>
					<td>No.SSPD</td>
					<td>Tgl.SSPD</td>
					<td>Nama WP</td>
					<td>PPAT</td>
					<td>NOP</td>
					<td>Thn SPPT</td>
					<td>NPOP</td>
					<td>BPHTB<br>Terhutang</td>
				</tr>
<?
foreach($rows as $item) {
?>
<tr>
					<td><?=$item->rownum?></td>
					<td><?=$item->sspdno?></td>
					<td><?=$item->tgl_transaksi?></td>
					<td><?=$item->wp_nama?></td>
					<td><?=$item->ppatnm?></td>
					<td><?=$item->nop?></td>
					<td><?=$item->thn_pajak_sppt?></td>
					<td><?=$item->npop?></td>
					<td><?=$item->bphtb_harus_dibayarkan?></td>
          
          
</tr>
<? } ?>

</table>
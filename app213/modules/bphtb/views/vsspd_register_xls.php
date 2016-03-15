<?php 
//header("Content-type: application/octet-stream");
//header("Content-Disposition: attachment; filename=sspd_register.xls");
//header("Pragma: no-cache");
//header("Expires: 0");
?>
<table border='1' widtd="70%">
				<tr>
					<td>No</td>
					<td>No.SSPD</td>
					<td>Tgl.SSPD</td>
					<td>Nama WP</td>
					<td>PPAT</td>
					<td>NOP</td>
					<td>tdn SPPT</td>
					<td>NPOP</td>
					<td>BPHTB<br>Terhutang</td>
					<td>Status<br>Pmb.</td>
					<td>Status<br>Pmh.</td>
					<td>Hasil<br>Penelitian</td>
				</tr>
<?
foreach($rows as $item) {
?>
<tr>
					<td><?=var_dump($item)?></td>
          
</tr>
<? } ?>

</table>
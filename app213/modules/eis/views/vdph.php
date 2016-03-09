<? $this->load->view('_head'); ?>
<? $this->load->view(active_module().'/_navbar'); ?>
<style>
.dataTables_processing {
    top: 50%;
    border: 0;
	background: none;
}
.table.dataTable {
	margin-bottom: 8px;
	font-size: 10px;
}
</style>

<script>
var mID;
var oTable;
var xRow;

function reload_grid() {
	var tahun = $("#tahun").val();
	var kec_kd = $("#kd_kecamatan").val();
	var kel_kd = $("#kd_kelurahan").val();
	window.location = "<? echo active_module_url($this->uri->segment(2));?>?tahun="+ tahun + "&kec_kd=" + kec_kd +"&kel_kd=" + kel_kd ;
}

$(document).ready(function() {
	oTable = $('#table1').dataTable({
		"iDisplayLength": '<?=$iDisplayLength?>',
		"iDisplayStart": '<?=$iDisplayStart?>',
		"sAjaxSource": "<?=$data_source?>",
		"bAutoWidth" : false,
		//"sScrollY": "250px", 
		// "bJQueryUI": true,
		"aLengthMenu": [[15, 50, 100,200, 500, -1], [15, 50, 100, 200, 500, "All"]],
		"bProcessing": true,
		"bServerSide": true,
		"bSort": true,
		"bInfo": true,
	
		"bPaginate": true,
		"bLengthChange": false,

		"sPaginationType": "full_numbers",
		"sDom": '<"toolbar">frtip',
		"aoColumnDefs": [
			{ "bSearchable": false, "bVisible": false, "aTargets": [ 0 ] }
		],
		"aoColumns": [
			null,
			{ "sWidth": "140px", "sClass": "left"},
			null,
			{ "sWidth": "125px", "sClass": "left"},
			{ "sWidth": "60px", "sClass": "left"},
			{ "sWidth": "90px", "sClass": "right"},
			{ "sWidth": "60px", "sClass": "center"},
			{ "sWidth": "90px", "sClass": "center"},
		],
		"fnRowCallback": function (nRow, aData, iDisplayIndex) {
			$(nRow).on("click", function (event) {
				if(aData[0]!=xRow) {
					if ($(this).hasClass('row_selected')) {
						$(this).removeClass('row_selected');
					} else {
						oTable.$('tr.row_selected').removeClass('row_selected');
						$(this).addClass('row_selected');
					}

					var data = oTable.fnGetData( this );
					mID = data[0];
				}
				xRow = aData[0];
			})
		},
		"oLanguage": {
        			"sProcessing":   "<img border='0' src='<?=base_url('assets/img/ajax-loader-big-circle-ball.gif')?>' />",
			"sLengthMenu":   "Tampilkan _MENU_",
			"sZeroRecords":  "Tidak ada data",
			"sInfo":         "Menampilkan _START_ sampai _END_ dari _TOTAL_ entri",
			"sInfoEmpty":    "Menampilkan 0 sampai 0 dari 0 entri",
			"sInfoFiltered": "(disaring dari _MAX_ entri keseluruhan)",
			"sInfoPostFix":  "",
			"sSearch":       "Cari : ",
			"sUrl":          "",
		},
	});
	
	var tb_array = [
		<? if($this->uri->segment(2) == 'dph') :?>
		'<div class="btn-group pull-left">',
		'	<button id="btn_tambah" class="btn" type="button">Tambah</button>',
		'	<button id="btn_edit" class="btn" type="button">Edit</button>',
		'	<button id="btn_delete" class="btn" type="button">Hapus</button>',
		'</div>',
		<? endif; ?>
		<? if($this->uri->segment(2) == 'dph_posting') :?>
		'<div class="btn-group pull-left">',
		'	<button id="btn_posting" class="btn btn-success" type="button">Download</button>',
		'</div>',
		<? endif; ?>
	];
	var tb = tb_array.join(' ');	
	$("div.toolbar").html(tb);

	$('#btn_tambah').click(function() {
		var kec_kd = $("#kd_kecamatan").val();
		var kel_kd = $("#kd_kelurahan").val();
		window.location = '<?=active_module_url($this->uri->segment(2));?>add/'+kec_kd+'/'+kel_kd;
	});

	$('#btn_edit').click(function() {
		if(mID) {
			window.location = '<?=active_module_url($this->uri->segment(2));?>edit/'+mID;
		}else{
			alert('Silahkan pilih data yang akan diedit');
		}
	});

	$('#btn_delete').click(function() {
		if(mID) {
			var hapus = confirm('Hapus data ini?');
			if(hapus==true) {
				window.location = '<?=active_module_url($this->uri->segment(2));?>delete/'+mID;
			};
		}else{
			alert('Silahkan pilih data yang akan dihapus');
		}
	});
	
	$('#btn_posting').click(function() {
		if(mID) {
			var url = '<?=active_module_url($this->uri->segment(2));?>posting';
					
			$('#download').val( mID );
			$('#download_form').attr('action', url);
			$('#download_form').submit();
		}else{
			alert('Silahkan pilih data yang akan didownload');
		}
	});
	
	/*
	// yang lama
	$('#btn_posting').click(function() {
		var url = '<?=active_module_url($this->uri->segment(2));?>posting';
		var data = JSON.stringify({ "dtTable" : oTable.fnGetData() });
				
		$('#download').val( data );
		$('#download_form').attr('action', url);
		$('#download_form').submit();
	});
	*/
	
	$("#btngo").click(function(){
		reload_grid();
	});
	
	$("#kd_kecamatan, #kd_kelurahan").change(function() {
		reload_grid();
	});
	
	/* Init */
});
</script>

<!--buat download -->
<form id="download_form" method="post" action="" class="hide" >
	<input type="hidden" id="download" name="download" />
</form>

<div class="content">	
    <div class="container-fluid">
        <ul class="nav nav-tabs">
            <li class="active"><a data-toggle="tab" href="#main_grid"><strong><? echo $this->uri->segment(2)=='dph' ? 'DPH - Entri Data' : 'DPH - Download dan Posting'; ?></strong></a></li>
        </ul>
        <?=msg_block();?>
        <div class="form-horizontal">
            <div class="control-group">
                <label class="control-label">Tahun Bayar</label> 
                <div class="controls">
					<input style="width:30px;" id="tahun" name="tahun" type="text" value="<?echo isset($tahun) ? $tahun : date('Y');?>"/>
                    <button class="btn btn-success" id="btngo" name="btngo">Go</button>
                </div>
               </div>
            <div class="control-group">
				<label class="control-label">Kecamatan</label> 
                <div class="controls">
					<select id="kd_kecamatan" name="kd_kecamatan" class="input-medium" <?echo get_user_kec_kd() != '000' ? "disabled" : "";?>>
						<?php
						if (get_user_kec_kd() == '000') echo "<option value=\"000\">Semua</option>\n";

						foreach ($kecamatan as $kec) 
						{
							$selected='';
							if ($kec->kd_kecamatan==$kec_kd) $selected=" selected";
							echo "<option value=\"".$kec->kd_kecamatan ."\" $selected>".$kec->nm_kecamatan."</option>\n";
						}
						?>
					</select> 
                    Kelurahan 
					<select id="kd_kelurahan" name="kd_kelurahan" class="input-medium">
						<?php
						if (get_user_kel_kd() == '000') echo "<option value=\"000\">Semua</option>\n";
						foreach ($kelurahan as $kel) 
						{
							$selected='';
							if ($kel->kd_kelurahan==$kel_kd) $selected=" selected";
							echo "<option value=\"".$kel->kd_kelurahan."\" $selected>".$kel->nm_kelurahan."</option>\n";
						}
						?>
					</select> 
                </div>
            </div>
        </div>
		<hr />
		
		<table class="table" id="table1">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Kode</th>
                    <th>Uraian</th>
                    <th>Tanggal</th>
                    <th>Pokok</th>
                    <th>Denda</th>
                    <th>Bayar</th>
                    <th>Posting</th>
                </tr>
            </thead>
            <tbody>
            </tbody>
        </table>
    </div>
</div>
<? $this->load->view('_foot'); ?>
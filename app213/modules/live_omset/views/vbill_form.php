<? $this->load->view('_head'); ?>
<? $this->load->view(active_module().'/_navbar'); ?>

<style>
.nav-tabs > .active > a, .nav-pills > .active > a:hover {
    color: blue;
}
.form-horizontal .controls {
  margin-left: 120px;  /* changed from 180px to 140px */
}
.form-horizontal .control-group {
    margin-bottom: 1px;
}
.form-horizontal .control-label{
	text-align:left;
	width: 120px; /* changed from 160px to 120px */
}
.form-horizontal input  {
	height: 14px !important;
	border-radius: 2px 2px 2px 2px !important;
	margin-bottom: 1px !important;
}
.form-horizontal select  {
	height: 24px !important;
	padding: 2px !important;
	border-radius: 2px 2px 2px 2px !important;
	margin-bottom: 1px !important;
}

button {
	height: 24px !important;
	padding: 4px 8px !important;
	border-radius: 2px 2px 2px 2px !important;
	margin-bottom: 1px !important;
}

hr {
  border: 0;
  border-bottom: 1px solid #dddddd;
}

.item_processing {    
	--background-color: #00c;
	position: absolute;
    text-align: center;
    top: 30%;
    left: 0;
	right:0;
	margin: auto;
}

.modal {
    top: 10%;
	width: 800px;
	margin-left: -400px;
	--max-height: 250px;
}
.modal-body {
	--padding: 5px;
}
</style>

<script>
$.fn.dataTableExt.oApi.fnReloadAjax = function ( oSettings, sNewSource, fnCallback, bStandingRedraw )
{
	if ( typeof sNewSource != 'undefined' && sNewSource != null ) {
		oSettings.sAjaxSource = sNewSource;
	}

	/* Server-side processing should just call fnDraw */
	if ( oSettings.oFeatures.bServerSide ) {
		this.fnDraw();
		return;
	}

	this.oApi._fnProcessingDisplay( oSettings, true );
	var that = this;
	var iStart = oSettings._iDisplayStart;
	var aData = [];

	this.oApi._fnServerParams( oSettings, aData );

	oSettings.fnServerData.call( oSettings.oInstance, oSettings.sAjaxSource, aData, function(json) {
		/* Clear the old information from the table */
		that.oApi._fnClearTable( oSettings );

		/* Got the data - add it to the table */
		var aData =  (oSettings.sAjaxDataProp !== "") ?
			that.oApi._fnGetObjectDataFn( oSettings.sAjaxDataProp )( json ) : json;

		for ( var i=0 ; i<aData.length ; i++ )
		{
			that.oApi._fnAddData( oSettings, aData[i] );
		}

		oSettings.aiDisplay = oSettings.aiDisplayMaster.slice();

		if ( typeof bStandingRedraw != 'undefined' && bStandingRedraw === true )
		{
			oSettings._iDisplayStart = iStart;
			that.fnDraw( false );
		}
		else
		{
			that.fnDraw();
		}

		that.oApi._fnProcessingDisplay( oSettings, false );

		/* Callback user function - for event handlers etc */
		if ( typeof fnCallback == 'function' && fnCallback != null )
		{
			fnCallback( oSettings );
		}
	}, oSettings );
};

function reload_grid_item() {
	itemTable.fnReloadAjax("<?=active_module_url($this->uri->segment(2));?>grid_item/<?=$dt['id']?>");
}

function get_item(item_id) {
	$('#item_processing').show();
    var op_id = parseFloat(<?=$dt['op_id'];?>);
	$.ajax({
		url: "<?php echo active_module_url($this->uri->segment(2))?>get_item/"+item_id+"/"+op_id,
		async: false,
		success: function (j) {
			var data = $.parseJSON(j);

			$('#form_item')[0].reset();

			$('#item_id').val(data['id']);
			$('#item_nama_produk').val(data['nama_produk']);
			$('#item_jumlah').val(data['jumlah']);
			$('#item_nominal').val(data['nominal']);
			$('#item_harga_satuan').val(data['harga_satuan']);
			$('#item_op_item_id').html(data['op_item']);

			$('#btn_item_new').hide();
			$('#btn_item_delete').show();
			$('#btn_item_submit').show();
			$('#btn_item_cancel').show();
		},
		error: function (xhr, desc, er) {
			alert(er);
		}
	});
	setTimeout(function(){
		$('#item_processing').hide();
	},500);
}

function new_item() {
    // ambil data op item doang
    var op_id = parseFloat(<?=$dt['op_id'];?>);
	$.ajax({
		url: "<?php echo active_module_url($this->uri->segment(2))?>new_item/"+op_id,
		async: false,
		success: function (j) {
			var data = $.parseJSON(j);

			$('#form_item')[0].reset();

			$('#item_id').val('');
			$('#item_op_item_id').html(data['op_item']);

			$('#btn_item_new').hide();
			$('#btn_item_delete').hide();
			$('#btn_item_submit').show();
			$('#btn_item_cancel').show();
		},
		error: function (xhr, desc, er) {
			alert(er);
		}
	});
}

var itemID;
var itemTable;
var itemRow;

var opTableDlg;
var mOpID;
var dtOpDlg;

$(document).ready(function() {
	/* Item */
	itemTable = $('#table_item').dataTable({
		/*
		"bAutoWidth": false,
		"bPaginate": false,
		"sPaginationType": "full_numbers",
		"sScrollY": "200px",
        "bScrollCollapse": true,
		"bLengthChange": false,
		*/

		"iDisplayLength": 9,
		"bJQueryUI": true,
		"bFilter": false,
		"bInfo": false,
		"sDom": '<"toolbar">frtip',
		"aaSorting": [[ 1, "asc" ]],
		"aoColumnDefs": [
			{ "bSearchable": false, "bVisible": false, "aTargets": [0] },
			{ "bSearchable": true, "bVisible": true, "aTargets": [1] }, 
		],
		"fnRowCallback": function (nRow, aData, iDisplayIndex) {
			$(nRow).on("click", function (event) {
				if ($(this).hasClass('row_selected')) {
					itemID = '';
					$('#btn_item_cancel').trigger('click');
					
					$(this).removeClass('row_selected');
				} else {
					var data = itemTable.fnGetData( this );
					itemID = data[0];

					/* map data */
					$('#item_id').val(itemID);
					get_item(itemID);
					
					itemTable.$('tr.row_selected').removeClass('row_selected');
					$(this).addClass('row_selected');
				}
			})
		},
		"fnDrawCallback": function( oSettings ) {
			itemRow = ''; itemID = '';
			$('#btn_item_cancel').trigger('click');
		},
		"bProcessing": true,
		"bServerSide": true,
		"sAjaxSource": "<?=active_module_url($this->uri->segment(2));?>grid_item/<?=$dt['id']?>"
	});

	$('#item_form').wrap('<form id="form_item" action="<?php echo active_module_url($this->uri->segment(2))?>proces_item/" method="post"></form>');

	$('#btn_item_submit').click(function() {
		var mode    = 'add';
		var bill_id = "<?=$dt['id'];?>";
		var id      = $('#item_id').val();
		if (id != '') mode = 'edit';

		$.ajax({
			url: "<?php echo active_module_url($this->uri->segment(2))?>proces_item/"+mode,
			type: "post",
			async: false,
			data: $('#form_item').serialize()+"&bill_id="+bill_id,
			success: function (j) {
				$('#btn_item_new').show();
				$('#btn_item_delete').hide();
				$('#btn_item_submit').hide();
				$('#btn_item_cancel').hide();

				reload_grid_item();
				$('#form_item')[0].reset();
			},
			error: function (xhr, desc, er) {
				alert(er);
			}
		});
	});

	$('#btn_item_delete').click(function() {
		if(itemID) {
			var hapus = confirm('Hapus data ini?');
			if(hapus==true) {
				var url  = '<?=active_module_url($this->uri->segment(2));?>delete_item/'+itemID;
				$.get(url, function(data) {
					if (data=='sip') {
						reload_grid_item();
						$('#btn_item_cancel').trigger('click');
					} else alert ('Gagal hapus!');
				});
			};
		}else{
			alert('Silahkan pilih data yang akan dihapus');
		}
	});
	
	$('#btn_item_cancel').click(function() {
		itemTable.$('tr.row_selected').removeClass('row_selected');
		$('#form_item')[0].reset();
		$('#btn_item_new').show();
		$('#btn_item_delete').hide();
		$('#btn_item_submit').hide();
		$('#btn_item_cancel').hide();
	});

	$('#btn_item_new').click(function() {
		$('#form_item')[0].reset();
		$('#btn_item_new').hide();
		$('#btn_item_delete').hide();
		$('#btn_item_submit').show();
		$('#btn_item_cancel').show();

        $('#item_nama_produk').focus();
		new_item();
	});
	/* end Item */
    
    /* op dlg */
	opTableDlg = $('#table_dlg_op').dataTable({
		"iDisplayLength": 9,
		"bJQueryUI": true,
		"bAutoWidth": false,
		"sPaginationType": "full_numbers",
		"sDom": '<"toolbar">frtip',
		"aaSorting": [[ 0, "desc" ]],
		"aoColumnDefs": [			
			{ "aTargets": [0,6,7], "bSearchable": false, "bVisible": false, "sWidth": "", "sClass": "" },
			// { "aTargets": [3,4,5], "bSearchable": false, "bVisible": true, "sWidth": "", "sClass": "right" },
		], 
		"fnRowCallback": function (nRow, aData, iDisplayIndex) {
			$(nRow).on("click", function (event) {
                opTableDlg.$('tr.row_selected').removeClass('row_selected');
				if ($(this).hasClass('row_selected')) {
					mOpID = ''; 
					// $(this).removeClass('row_selected');
				} else {
					dtOpDlg = opTableDlg.fnGetData( this );
					mOpID = dtOpDlg[0];
					
					$(this).addClass('row_selected');
				}
			})
		},
		"fnDrawCallback": function( oSettings ) {
			mOpID = '';
		},
		"oLanguage": {
			"sProcessing":   "<img border='0' src='<?=base_url('assets/img/ajax-loader-big-circle-ball.gif')?>' />",
			"sLengthMenu":   "Tampilkan _MENU_ entri",
			"sZeroRecords":  "Tidak ada data",
			"sInfo":         "Menampilkan _START_ sampai _END_ dari _TOTAL_ entri",
			"sInfoEmpty":    "Menampilkan 0 sampai 0 dari 0 entri",
			"sInfoFiltered": "(disaring dari _MAX_ entri keseluruhan)",
			"sInfoPostFix":  "",
			"sSearch":       "Cari : ",
			"sUrl":          "",
			"oPaginate": {
				"sFirst":    "&laquo;",
				"sPrevious": "&lsaquo;",
				"sNext":     "&rsaquo;",
				"sLast":     "&raquo;",
			}
		},
		"bProcessing": true,
		// "bServerSide": true,
		"sAjaxSource": "<?=active_module_url($this->uri->segment(2)).'grid_op';?>"
	});

	$('#btn_dialog_op_ok').click(function() {
		if (mOpID == '' || mOpID == null)
			alert('Data belum dipilih.');
		else {
            $('#op_id').val(dtOpDlg[0]);
            $('#op_nama').val(dtOpDlg[1]);
            $('#wp_nama').val(dtOpDlg[2]);
            $('#npwp').val(dtOpDlg[3]);
            
            $('#agent_id').val(dtOpDlg[6]);
            $('#jalur_id').val(dtOpDlg[7]);
            
			$('#opDialog').modal('hide');
		}
	});
    /* end op dlg */
    
	$('#tgl, #tgl_kwitansi, #tgl_kirim').datepicker({
        dateFormat: 'dd-mm-yy'
	});
    
	$('#btn_cancel').click(function() {
		window.location = '<?=active_module_url($this->uri->segment(2));?>';
	});
});

$(document).keypress(function(event){
	if (event.which == '13') {
		event.preventDefault();
	}
});
</script>

<div class="content">
	<!-- Modal OP -->
	<div id="opDialog" class="modal" tabindex="-1" role="dialog" aria-labelledby="cuDialogLabel" aria-hidden="true" data-backdrop="static">
		<div class="modal-header">
			<button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
			<h3 id="DialogLabel">Daftar Objek Pajak</h3>
		</div>
		<div class="modal-body">
			<table class="table" id="table_dlg_op">
				<thead>
					<tr>
						<th>idx</th>
						<th>Objek Pajak</th>
						<th>Wajib Pajak</th>
						<th>NPWP</th>
						<th>Kelurahan</th>
						<th>Kecamatan</th>
						<th>Agent ID</th>
						<th>Jalur ID</th>
					</tr>
				</thead>
				<tbody>
				</tbody>
			</table>
		</div>
		<div class="modal-footer">
			<button class="btn btn-primary" id="btn_dialog_op_ok">OK!</button>
			<button class="btn" data-dismiss="modal" aria-hidden="true">Batal</button>
		</div>
	</div>
    
    <!-- contetnt -->
    <div class="container-fluid">
		<ul class="nav nav-tabs">
			<li class="active">
				<a href="#"><strong>BILL</strong></a>
			</li>
		</ul>
		
		<? 
		echo msg_block();
		if(validation_errors()){
			echo '<blockquote><strong>Harap melengkapi data berikut :</strong>';
			echo validation_errors('<small>','</small>');
			echo '</blockquote>';
		} 
		?>
		
		<?php echo form_open($faction, array('id'=>'myform','class'=>'form-horizontal'));?>
            <input type="hidden" name="id" value="<?=$dt['id']?>"/>
            <input type="hidden" name="jalur_id" id="jalur_id" value="<?=$dt['jalur_id']?>" />
            
            <div class="row">
                <div class="span4">
                    <div class="control-group">
                        <label class="control-label" for="tgl">Tanggal</label>
                        <div class="controls">
                            <input style="width:66px;" class="input" type="text" name="tgl" id="tgl" value="<?=$dt['tgl']?>" />
                        </div>
                    </div>
                    <div class="control-group">
                        <label class="control-label" for="op_id">Objek Pajak</label>
                        <div class="controls">
                            <input type="hidden" name="op_id" id="op_id" value="<?=$dt['op_id']?>" />
                            <input style="width:162px;" class="input" type="text" name="op_nama" id="op_nama" value="<?=$dt['op_nama']?>" />
                            <button type="button" class="btn btn-success" data-toggle="modal" data-target="#opDialog">Cari</button>
                        </div>
                    </div>
                    <div class="control-group">
                        <label class="control-label" for="wp_id">Wajib Pajak</label>
                        <div class="controls">
                            <input class="input" type="text" name="wp_nama" id="wp_nama" value="<?=$dt['wp_nama']?>" readonly />
                        </div>
                    </div>
                    <div class="control-group">
                        <label class="control-label" for="npwp">NPWP</label>
                        <div class="controls">
                            <input class="input" type="text" name="npwp" id="npwp" value="<?=$dt['npwp']?>" readonly />
                        </div>
                    </div>
                    <div class="control-group">
                        <label class="control-label" for="agent_id">Agent ID</label>
                        <div class="controls">
                            <input class="input" type="text" name="agent_id" id="agent_id" value="<?=$dt['agent_id']?>" readonly />
                        </div>
                    </div>
                </div>
                
                <div class="span4">
                    <div class="control-group">
                        <label class="control-label" for="nominal">Nominal</label>
                        <div class="controls">
                            <input style="width:100px;" class="input" type="text" name="nominal" id="nominal" value="<?=$dt['nominal']?>" />
                        </div>
                    </div>
                    <div class="control-group">
                        <label class="control-label" for="ket_pengirim">Ket. Pengirim</label>
                        <div class="controls">
                            <input class="input" type="text" name="ket_pengirim" id="ket_pengirim" value="<?=$dt['ket_pengirim']?>" />
                        </div>
                    </div>
                    <div class="control-group">
                        <label class="control-label" for="tgl_kirim">Tgl. Kirim</label>
                        <div class="controls">
                            <input style="width:66px;" class="input" type="text" name="tgl_kirim" id="tgl_kirim" value="<?=$dt['tgl_kirim']?>" />
                        </div>
                    </div>
                    <div class="control-group">
                        <label class="control-label" for="tgl_kwitansi">Tgl. Kwitansi</label>
                        <div class="controls">
                            <input style="width:66px;" class="input" type="text" name="tgl_kwitansi" id="tgl_kwitansi" value="<?=$dt['tgl_kwitansi']?>" />
                        </div>
                    </div>
                    <div class="control-group">
                        <label class="control-label" for="no_kwitansi">No. Kwitansi</label>
                        <div class="controls">
                            <input class="input" type="text" name="no_kwitansi" id="no_kwitansi" value="<?=$dt['no_kwitansi']?>" />
                        </div>
                    </div>
                </div>
            </div>
            
            <? if ($dt['id'] > 0) : ?>
            <div class="tabbable">
                <ul class="nav nav-tabs">
                    <li class="active"><a href="#bill_item" data-toggle="tab"><strong>Bill Item</strong></a></li>
                </ul>
                
                <div class="tab-content">
                    <div class="tab-pane fade in <?echo $dt['id'] > 0 ? 'active' : ''; ?>" id="bill_item">
                        <div class="row">
                            <div class="span4" style="width: 370px; position: relative;">
                                <div id="item_processing" class="item_processing" style="display: none;">
                                    <img border="0" src="<?=base_url('assets/img/ajax-loader-bert.gif')?>"></img>
                                </div>
                                <div id="item_form">
                                    <input type="hidden" name="item_id" id="item_id" />

                                    <div class="control-group">
                                        <label class="control-label" for="item_nama_produk">Nama Produk</label>
                                        <div class="controls">
                                            <input class="input" type="text" name="item_nama_produk" id="item_nama_produk" value="" />
                                        </div>
                                    </div>
                                    <div class="control-group">
                                        <label class="control-label" for="item_jumlah">Jumlah</label>
                                        <div class="controls">
                                            <input class="input" style="width:70px;" type="text" name="item_jumlah" id="item_jumlah" value="" />
                                        </div>
                                    </div>
                                    <div class="control-group">
                                        <label class="control-label" for="item_nominal">Nominal</label>
                                        <div class="controls">
                                            <input class="input" style="width:100px;" type="text" name="item_nominal" id="item_nominal" value="" />
                                        </div>
                                    </div>
                                    <div class="control-group">
                                        <label class="control-label" for="item_harga_satuan">Harga Satuan</label>
                                        <div class="controls">
                                            <input class="input" style="width:100px;" type="text" name="item_harga_satuan" id="item_harga_satuan" value="" />
                                        </div>
                                    </div>
                                    <div class="control-group">
                                        <label class="control-label" for="item_op_item_id">OP Item</label>
                                        <div class="controls">
                                            <select id="item_op_item_id" name="item_op_item_id"><option></option></select>
                                        </div>
                                    </div>
                                    <p>&nbsp;</p>
                                    <button type="button" class="btn btn-primary" id="btn_item_new">Tambah Item</button>
                                    <button type="button" class="btn btn-primary hide" id="btn_item_submit">Simpan Item</button>
                                    <button type="button" class="btn btn-danger hide" id="btn_item_delete">Hapus Item</button>
                                    <button type="button" class="btn hide" id="btn_item_cancel">Batal</button>
                                </div>
                            </div>
                            <div class="span6">
                                <table class="table" id="table_item">
                                    <thead>
                                        <tr>
                                            <th>Index</th>
                                            <th>Nama Produk</th>
                                            <th>Jumlah</th>
                                            <th>Nominal</th>
                                            <th>Harga Satuan</th>
                                            <th>OP Item</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <? endif;?>
            <hr>
            <button type="submit" class="btn btn-primary">Simpan</button>
            <button type="button" class="btn" id="btn_cancel">Batal</button>
		<?php echo form_close();?>
    </div>
</div>
<? $this->load->view('_foot'); ?>
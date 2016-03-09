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

.op_processing, .op_item_processing {    
	--background-color: #00c;
	position: absolute;
    text-align: center;
    top: 30%;
    left: 0;
	right:0;
	margin: auto;
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

function reload_grid_op() {
	opTable.fnReloadAjax("<?=active_module_url($this->uri->segment(2));?>grid_objek_pajak/<?=$dt['id']?>");
}

function reload_grid_op_item() {
	opItemTable.fnReloadAjax("<?=active_module_url($this->uri->segment(2));?>grid_op_item/<?=$dt['id']?>");
}

function get_op(op_id) {
	$('#op_processing').show();
	$.ajax({
		url: "<?php echo active_module_url($this->uri->segment(2))?>get_op/"+op_id,
		async: false,
		success: function (j) {
			var data = $.parseJSON(j);

			$('#form_op')[0].reset();

			$('#op_id').val(data['id']);
			$('#op_nama').val(data['nama']);
			$('#op_jalan').val(data['jalan']);
			$('#op_rt').val(data['rt']);
			$('#op_rw').val(data['rw']);
			$('#op_kelurahan').val(data['kelurahan']);
			$('#op_kecamatan').val(data['kecamatan']);
			$('#op_kabupaten').val(data['kabupaten']);
			$('#op_propinsi').val(data['propinsi']);
			$('#op_kode_pos').val(data['kode_pos']);

			$('#btn_op_new').hide();
			$('#btn_op_delete').show();
			$('#btn_op_submit').show();
			$('#btn_op_cancel').show();
		},
		error: function (xhr, desc, er) {
			alert(er);
		}
	});
	setTimeout(function(){
		$('#op_processing').hide();
	},500);
}

function get_op_item(op_item_id) {
	$('#op_item_processing').show();
	$.ajax({
		url: "<?php echo active_module_url($this->uri->segment(2))?>get_op_item/"+op_item_id+"/"+<?=$dt['id'];?>,
		async: false,
		success: function (j) {
			var data = $.parseJSON(j);

			$('#form_op_item')[0].reset();

			$('#op_item_id').val(data['id']);
			$('#op_item_op_id').html(data['op']);
			$('#op_item_nama').val(data['nama']);

			$('#btn_op_item_new').hide();
			$('#btn_op_item_delete').show();
			$('#btn_op_item_submit').show();
			$('#btn_op_item_cancel').show();
		},
		error: function (xhr, desc, er) {
			alert(er);
		}
	});
	setTimeout(function(){
		$('#op_item_processing').hide();
	},500);
}

function new_op_item() {
	$.ajax({
		url: "<?php echo active_module_url($this->uri->segment(2))?>new_op_item/"+<?=$dt['id'];?>,
		async: false,
		success: function (j) {
			var data = $.parseJSON(j);

			$('#form_op_item')[0].reset();

			$('#op_item_id').val('');
			$('#op_item_op_id').html(data['op']);
			$('#op_item_nama').val(data['nama']);

			$('#btn_op_item_new').hide();
			$('#btn_op_item_delete').hide();
			$('#btn_op_item_submit').show();
			$('#btn_op_item_cancel').show();
		},
		error: function (xhr, desc, er) {
			alert(er);
		}
	});
}

var opID;
var opTable;
var opRow;

var opItemID;
var opItemTable;
var opItemRow;

$(document).ready(function() {
	/* OP */
	opTable = $('#table_op').dataTable({
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
					opID = '';
					$('#btn_op_cancel').trigger('click');
					
					$(this).removeClass('row_selected');
				} else {
					var data = opTable.fnGetData( this );
					opID = data[0];

					/* map data */
					$('#op_id').val(opID);
					get_op(opID);
					
					opTable.$('tr.row_selected').removeClass('row_selected');
					$(this).addClass('row_selected');
				}
			})
		},
		"fnDrawCallback": function( oSettings ) {
			opRow = ''; opID = '';
			$('#btn_op_cancel').trigger('click');
		},
		"bProcessing": true,
		"bServerSide": true,
		"sAjaxSource": "<?=active_module_url($this->uri->segment(2));?>grid_objek_pajak/<?=$dt['id']?>"
	});

	$('#op_form').wrap('<form id="form_op" action="<?php echo active_module_url($this->uri->segment(2))?>proces_op/" method="post"></form>');

	$('#btn_op_submit').click(function() {
		var mode  = 'add';
		var wp_id = "<?=$dt['id'];?>";
		var id    = $('#op_id').val();
		if (id != '') mode = 'edit';

		$.ajax({
			url: "<?php echo active_module_url($this->uri->segment(2))?>proces_op/"+mode,
			type: "post",
			async: false,
			data: $('#form_op').serialize()+"&op_wp_id="+wp_id,
			success: function (j) {
				$('#btn_op_new').show();
				$('#btn_op_delete').hide();
				$('#btn_op_submit').hide();
				$('#btn_op_cancel').hide();

				reload_grid_op();
				$('#form_op')[0].reset();
			},
			error: function (xhr, desc, er) {
				alert(er);
			}
		});
	});

	$('#btn_op_delete').click(function() {
		if(opID) {
			var hapus = confirm('Hapus data ini?');
			if(hapus==true) {
				var url  = '<?=active_module_url($this->uri->segment(2));?>delete_op/'+opID;
				$.get(url, function(data) {
					if (data=='sip') {
						reload_grid_op();
						$('#btn_op_cancel').trigger('click');
					} else alert ('Gagal hapus!');
				});
			};
		}else{
			alert('Silahkan pilih data yang akan dihapus');
		}
	});
	
	$('#btn_op_cancel').click(function() {
		opTable.$('tr.row_selected').removeClass('row_selected');
		$('#form_op')[0].reset();
		$('#btn_op_new').show();
		$('#btn_op_delete').hide();
		$('#btn_op_submit').hide();
		$('#btn_op_cancel').hide();
	});

	$('#btn_op_new').click(function() {
		$('#form_op')[0].reset();
		$('#btn_op_new').hide();
		$('#btn_op_delete').hide();
		$('#btn_op_submit').show();
		$('#btn_op_cancel').show();

        $('#op_nama').focus();
		/* new_op(); */
	});
	/* end OP */
    
	/* OP Item*/
	opItemTable = $('#table_op_item').dataTable({
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
					opItemID = '';
					$('#btn_op_item_cancel').trigger('click');
					
					$(this).removeClass('row_selected');
				} else {
					var data = opItemTable.fnGetData( this );
					opItemID = data[0];

					/* map data */
					$('#op_item_id').val(opItemID);
					get_op_item(opItemID);
					
					opItemTable.$('tr.row_selected').removeClass('row_selected');
					$(this).addClass('row_selected');
				}
			})
		},
		"fnDrawCallback": function( oSettings ) {
			opItemRow = ''; opItemID = '';
			$('#btn_op_item_cancel').trigger('click');
		},
		"bProcessing": true,
		"bServerSide": true,
		"sAjaxSource": "<?=active_module_url($this->uri->segment(2));?>grid_op_item/<?=$dt['id']?>"
	});

	$('#op_item_form').wrap('<form id="form_op_item" action="<?php echo active_module_url($this->uri->segment(2))?>proces_op_item/" method="post"></form>');

	$('#btn_op_item_submit').click(function() {
		var mode  = 'add';
		var wp_id = "<?=$dt['id'];?>";
		var id    = $('#op_item_id').val();
		if (id != '') mode = 'edit';

		$.ajax({
			url: "<?php echo active_module_url($this->uri->segment(2))?>proces_op_item/"+mode,
			type: "post",
			async: false,
			data: $('#form_op_item').serialize(), 
			success: function (j) {
				$('#btn_op_item_new').show();
				$('#btn_op_item_delete').hide();
				$('#btn_op_item_submit').hide();
				$('#btn_op_item_cancel').hide();

				reload_grid_op_item();
				$('#form_op_item')[0].reset();
			},
			error: function (xhr, desc, er) {
				alert(er);
			}
		});
	});

	$('#btn_op_item_delete').click(function() {
		if(opItemID) {
			var hapus = confirm('Hapus data ini?');
			if(hapus==true) {
				var url  = '<?=active_module_url($this->uri->segment(2));?>delete_op_item/'+opItemID;
				$.get(url, function(data) {
					if (data=='sip') {
						reload_grid_op_item();
						$('#btn_op_item_cancel').trigger('click');
					} else alert ('Gagal hapus!');
				});
			};
		}else{
			alert('Silahkan pilih data yang akan dihapus');
		}
	});
	
	$('#btn_op_item_cancel').click(function() {
		opItemTable.$('tr.row_selected').removeClass('row_selected');
		$('#form_op_item')[0].reset();
		$('#btn_op_item_new').show();
		$('#btn_op_item_delete').hide();
		$('#btn_op_item_submit').hide();
		$('#btn_op_item_cancel').hide();
	});

	$('#btn_op_item_new').click(function() {
		$('#form_op_item')[0].reset();
		$('#btn_op_item_new').hide();
		$('#btn_op_item_delete').hide();
		$('#btn_op_item_submit').show();
		$('#btn_op_item_cancel').show();

        $('#op_item_op_id').focus();
		new_op_item();
	});
	/* end OP Item */
    
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
    <div class="container-fluid">
		<ul class="nav nav-tabs">
			<li class="active">
				<a href="#"><strong>WAJIB PAJAK</strong></a>
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
            <div class="row">
                <div class="span4">
                    <div class="control-group">
                        <label class="control-label" for="npwp">NPWP</label>
                        <div class="controls">
                            <input class="input" type="text" name="npwp" id="npwp" value="<?=$dt['npwp']?>" />
                        </div>
                    </div>
                    <div class="control-group">
                        <label class="control-label" for="nama">Nama WP</label>
                        <div class="controls">
                            <input class="input" type="text" name="nama" id="nama" value="<?=$dt['nama']?>" />
                        </div>
                    </div>
                    <div class="control-group">
                        <label class="control-label" for="jalan">Jalan</label>
                        <div class="controls">
                            <input class="input" type="text" name="jalan" id="jalan" value="<?=$dt['jalan']?>" />
                        </div>
                    </div>
                    <div class="control-group">
                        <label class="control-label" for="rt">RT / RW</label>
                        <div class="controls">
                            <input class="input" style="width:30px;" type="text" name="rt" id="rt" value="<?=$dt['rt']?>" /> / 
                            <input class="input" style="width:30px;" type="text" name="rw" id="rw" value="<?=$dt['rw']?>" />
                        </div>
                    </div>
                </div>
            
                <div class="span4">
                    <div class="control-group">
                        <label class="control-label" for="kelurahan">Kel. / Kec.</label>
                        <div class="controls">
                            <input class="input" style="width:91px;" type="text" name="kelurahan" id="kelurahan" value="<?=$dt['kelurahan']?>" /> /
                            <input class="input" style="width:92px;" type="text" name="kecamatan" id="kecamatan" value="<?=$dt['kecamatan']?>" />
                        </div>
                    </div>
                    <div class="control-group">
                        <label class="control-label" for="kabupaten">Kab./Kota</label>
                        <div class="controls">
                            <input class="input" type="text" name="kabupaten" id="kabupaten" value="<?=$dt['kabupaten']?>" />
                        </div>
                    </div>
                    <div class="control-group">
                        <label class="control-label" for="propinsi">Propinsi</label>
                        <div class="controls">
                            <input class="input" type="text" name="propinsi" id="propinsi" value="<?=$dt['propinsi']?>" />
                        </div>
                    </div>
                    <div class="control-group">
                        <label class="control-label" for="kode_pos">Kode Pos</label>
                        <div class="controls">
                            <input class="input" type="text" name="kode_pos" id="kode_pos" value="<?=$dt['kode_pos']?>" />
                        </div>
                    </div>
                </div>
            </div>
            
            <? if ($dt['id'] > 0) : ?>
            <div class="tabbable">
                <ul class="nav nav-tabs">
                    <li class="active"><a href="#op" data-toggle="tab"><strong>Objek Pajak</strong></a></li>
                    <li><a href="#op_item" data-toggle="tab"><strong>Objek Pajak Item</strong></a></li>
                </ul>
                
                <div class="tab-content">
                    <div class="tab-pane fade in <?echo $dt['id'] > 0 ? 'active' : ''; ?>" id="op">
                        <div class="row">
                            <div class="span4" style="width: 370px; position: relative;">
                                <div id="op_processing" class="op_processing" style="display: none;">
                                    <img border="0" src="<?=base_url('assets/img/ajax-loader-bert.gif')?>"></img>
                                </div>
                                <div id="op_form">
                                    <input type="hidden" name="op_id" id="op_id" />

                                    <div class="control-group">
                                        <label class="control-label" for="op_nama">Objek Pajak</label>
                                        <div class="controls">
                                            <input class="input" type="text" name="op_nama" id="op_nama" value="<?=$dt['op_nama']?>" />
                                        </div>
                                    </div>
                                    <div class="control-group">
                                        <label class="control-label" for="op_jalan">Jalan</label>
                                        <div class="controls">
                                            <input class="input" type="text" name="op_jalan" id="op_jalan" value="<?=$dt['op_jalan']?>" />
                                        </div>
                                    </div>
                                    <div class="control-group">
                                        <label class="control-label" for="op_rt">RT / RW</label>
                                        <div class="controls">
                                            <input class="input" style="width:30px;" type="text" name="op_rt" id="op_rt" value="<?=$dt['op_rt']?>" /> / 
                                            <input class="input" style="width:30px;" type="text" name="op_rw" id="op_rw" value="<?=$dt['op_rw']?>" />
                                        </div>
                                    </div>
                                    <div class="control-group">
                                        <label class="control-label" for="op_kelurahan">Kel. / Kec.</label>
                                        <div class="controls">
                                            <input class="input" style="width:91px;" type="text" name="op_kelurahan" id="op_kelurahan" value="<?=$dt['op_kelurahan']?>" /> /
                                            <input class="input" style="width:92px;" type="text" name="op_kecamatan" id="op_kecamatan" value="<?=$dt['op_kecamatan']?>" />
                                        </div>
                                    </div>
                                    <div class="control-group">
                                        <label class="control-label" for="op_kabupaten">Kab./Kota</label>
                                        <div class="controls">
                                            <input class="input" type="text" name="op_kabupaten" id="op_kabupaten" value="<?=$dt['op_kabupaten']?>" />
                                        </div>
                                    </div>
                                    <div class="control-group">
                                        <label class="control-label" for="op_propinsi">Propinsi</label>
                                        <div class="controls">
                                            <input class="input" type="text" name="op_propinsi" id="op_propinsi" value="<?=$dt['op_propinsi']?>" />
                                        </div>
                                    </div>
                                    <div class="control-group">
                                        <label class="control-label" for="op_kode_pos">Kode Pos</label>
                                        <div class="controls">
                                            <input class="input" type="text" name="op_kode_pos" id="op_kode_pos" value="<?=$dt['op_kode_pos']?>" />
                                        </div>
                                    </div>
                                    <p>&nbsp;</p>
                                    <button type="button" class="btn btn-primary" id="btn_op_new">Tambah OP</button>
                                    <button type="button" class="btn btn-primary hide" id="btn_op_submit">Simpan OP</button>
                                    <button type="button" class="btn btn-danger hide" id="btn_op_delete">Hapus OP</button>
                                    <button type="button" class="btn hide" id="btn_op_cancel">Batal</button>
                                </div>
                            </div>
                            <div class="span6">
                                <table class="table" id="table_op">
                                    <thead>
                                        <tr>
                                            <th>Index</th>
                                            <th>Objek Pajak</th>
                                            <th>Kelurahan</th>
                                            <th>Kecamatan</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                    
                    <div class="tab-pane fade in" id="op_item">
                        <div class="row">
                            <div class="span4" style="width: 370px; position: relative;">
                                <div id="op_item_processing" class="op_item_processing" style="display: none;">
                                    <img border="0" src="<?=base_url('assets/img/ajax-loader-bert.gif')?>"></img>
                                </div>
                                <div id="op_item_form">
                                    <input type="hidden" name="op_item_id" id="op_item_id" />

                                    <div class="control-group">
                                        <label class="control-label" for="op_item_op_id">Objek Pajak</label>
                                        <div class="controls">
                                            <select name="op_item_op_id" id="op_item_op_id"><option></option></select>
                                        </div>
                                    </div>
                                    <div class="control-group">
                                        <label class="control-label" for="op_item_nama">Uraian Item</label>
                                        <div class="controls">
                                            <input class="input" type="text" name="op_item_nama" id="op_item_nama" value="<?=$dt['op_item_nama']?>" />
                                        </div>
                                    </div>
                                    <p>&nbsp;</p>
                                    <button type="button" class="btn btn-primary" id="btn_op_item_new">Tambah Item OP</button>
                                    <button type="button" class="btn btn-primary hide" id="btn_op_item_submit">Simpan Item OP</button>
                                    <button type="button" class="btn btn-danger hide" id="btn_op_item_delete">Hapus Item OP</button>
                                    <button type="button" class="btn hide" id="btn_op_item_cancel">Batal</button>
                                </div>                            
                            </div>
                            <div class="span4">
                                <table class="table" id="table_op_item">
                                    <thead>
                                        <tr>
                                            <th>Index</th>
                                            <th>Objek Pajak</th>
                                            <th>Uraian</th>
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
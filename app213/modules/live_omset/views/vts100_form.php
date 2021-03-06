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
var agentTableDlg;
var mAgentID;
var dtAgentDlg;

var opTableDlg;
var mOpID;
var dtOpDlg;

$(document).ready(function() {
    /* agent dlg */
	agentTableDlg = $('#table_dlg_agent').dataTable({
		"iDisplayLength": 9,
		"bJQueryUI": true,
		"bAutoWidth": false,
		"sPaginationType": "full_numbers",
		"sDom": '<"toolbar">frtip',
		"aaSorting": [[ 0, "desc" ]],
		"aoColumnDefs": [			
			{ "aTargets": [3,4,5], "bSearchable": false, "bVisible": false, "sWidth": "", "sClass": "" },
			// { "aTargets": [3,4,5], "bSearchable": false, "bVisible": true, "sWidth": "", "sClass": "right" },
		], 
		"fnRowCallback": function (nRow, aData, iDisplayIndex) {
			$(nRow).on("click", function (event) {
				agentTableDlg.$('tr.row_selected').removeClass('row_selected');
				if ($(this).hasClass('row_selected')) {
					mAgentID = ''; 
					//$(this).removeClass('row_selected');
				} else {
					dtAgentDlg = agentTableDlg.fnGetData( this );
					mAgentID = dtAgentDlg[0];
					
					$(this).addClass('row_selected');
				}
			})
		},
		"fnDrawCallback": function( oSettings ) {
			mAgentID = '';
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
		"sAjaxSource": "<?=active_module_url($this->uri->segment(2)).'grid_agent';?>"
	});

	$('#btn_dialog_agent_ok').click(function() {
		if (mAgentID == '' || mAgentID == null)
			alert('Data belum dipilih.');
		else {
            $('#agent_id').val(dtAgentDlg[0]);
			$('#agentDialog').modal('hide');
		}
	});
    /* end agent dlg */
    
    /* op dlg */
	opTableDlg = $('#table_dlg_op').dataTable({
		"iDisplayLength": 9,
		"bJQueryUI": true,
		"bAutoWidth": false,
		"sPaginationType": "full_numbers",
		"sDom": '<"toolbar">frtip',
		"aaSorting": [[ 0, "desc" ]],
		"aoColumnDefs": [			
			{ "aTargets": [0], "bSearchable": false, "bVisible": false, "sWidth": "", "sClass": "" },
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
            
			$('#opDialog').modal('hide');
		}
	});
    /* end op dlg */
    
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
	<!-- Modal Agent -->
	<div id="agentDialog" class="modal" tabindex="-1" role="dialog" aria-labelledby="cuDialogLabel" aria-hidden="true" data-backdrop="static">
		<div class="modal-header">
			<button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
			<h3 id="DialogLabel">Daftar Agent</h3>
		</div>
		<div class="modal-body">
			<table class="table" id="table_dlg_agent">
				<thead>
					<tr>
                        <th>Agent ID</th>
                        <th>Jalur</th>
                        <th>Status</th>
                        <th>Job</th>
                        <th>Last Job</th>
                        <th>Star Up</th>
                        <th>Notes</th>
					</tr>
				</thead>
				<tbody>
				</tbody>
			</table>
		</div>
		<div class="modal-footer">
			<button class="btn btn-primary" id="btn_dialog_agent_ok">OK!</button>
			<button class="btn" data-dismiss="modal" aria-hidden="true">Batal</button>
		</div>
	</div>
    
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
				<a href="#"><strong>TS100</strong></a>
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
            <div class="control-group">
                <label class="control-label" for="agent_id">Agent ID</label>
                <div class="controls">
                    <input class="input" style="width:162px;" type="text" name="agent_id" id="agent_id" value="<?=$dt['agent_id']?>" readonly />
                    <button type="button" class="btn btn-success" data-toggle="modal" data-target="#agentDialog">Cari</button>
                </div>
            </div>
            <div class="control-group">
                <label class="control-label" for="op_nama">Objek Pajak</label>
                <div class="controls">
                    <input class="input" type="hidden" name="op_id" id="op_id" value="<?=$dt['op_id']?>" readonly />
                    <input class="input" style="width:162px;" type="text" name="op_nama" id="op_nama" value="<?=$dt['op_nama']?>" readonly />
                    <button type="button" class="btn btn-success" data-toggle="modal" data-target="#opDialog">Cari</button>
                </div>
            </div>
            <div class="control-group">
                <label class="control-label" for="wp_nama">Wajib Pajak</label>
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
                <label class="control-label" for="latitude">Latitude</label>
                <div class="controls">
                    <input class="input" style="width:100px;" type="text" name="latitude" id="latitude" value="<?=$dt['latitude']?>" />
                </div>
            </div>
            <div class="control-group">
                <label class="control-label" for="longitude">Longitude</label>
                <div class="controls">
                    <input class="input" style="width:100px;" type="text" name="longitude" id="longitude" value="<?=$dt['longitude']?>" />
                </div>
            </div>
            <br>
            <div class="control-group">
                <div class="controls">
                    <button type="submit" class="btn btn-primary">Simpan</button>
                    <button type="button" class="btn" id="btn_cancel">Batal</button>
                </div>
            </div>
		<?php echo form_close();?>
    </div>
</div>
<? $this->load->view('_foot'); ?>
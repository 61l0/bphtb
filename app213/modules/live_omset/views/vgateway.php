<? $this->load->view('_head'); ?>
<? $this->load->view(active_module().'/_navbar'); ?>

<style>
.nav-tabs > .active > a, .nav-pills > .active > a:hover {
    color: blue;
}
.table.dataTable {
	margin-bottom: 8px;
	font-size: 10px;
}

input {
	height: 14px !important;
	border-radius: 2px 2px 2px 2px !important;
	margin-bottom: 2px !important;
}

select {
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

.dataTables_filter {
	width: 280px;
}
.dataTables_processing {
    top: 50%;
    border: 0;
	background: none;
}
</style>

<script>
var mID;
var oTable;

$(document).ready(function() {	
	oTable = $('#table1').dataTable({
		"iDisplayLength": 13,
		"sPaginationType": "full_numbers",
		"bJQueryUI": true,
		"bAutoWidth": false,
		"sDom": '<"toolbar">frtip',
		"aaSorting": [[ 1, "asc" ]],
		"aoColumnDefs": [			
			{ "aTargets": [0], "bSearchable": true,  "bVisible": true,  "sWidth": "50px", "sClass": "" },
			{ "aTargets": [1], "bSearchable": true,  "bVisible": true,  "sWidth": "", "sClass": "" },
		],
		"fnRowCallback": function (nRow, aData, iDisplayIndex) {
			$(nRow).on("click", function (event) {
				if ($(this).hasClass('row_selected')) {
					mID = '';
					$(this).removeClass('row_selected');
				} else {
					var data = oTable.fnGetData( this );
					mID = data[0];
					
					oTable.$('tr.row_selected').removeClass('row_selected');
					$(this).addClass('row_selected');
				}
			})
		},
		"fnDrawCallback": function( oSettings ) {
			mID = '';
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
		// "bServerSide": true,
		"bProcessing": true,
		"sAjaxSource": "<?=active_module_url($this->uri->segment(2));?>grid"
	}); 
	
	var tb_array = [
		'<div class="btn-group pull-left">',
		'	<button id="btn_tambah" class="btn pull-left" type="button">Tambah</button>',
		'	<button id="btn_edit" class="btn pull-left" type="button">Edit</button>',
		'	<button id="btn_delete" class="btn pull-left" type="button">Hapus</button>',
		'</div>'
	];
	var tb = tb_array.join(' ');	
	$("div.toolbar").html(tb);

	$('#btn_tambah').click(function() {
		window.location = '<?=active_module_url($this->uri->segment(2));?>add/';
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
});
</script>
 <div class="content">  
	 <div class="container-fluid">  
		
		<ul class="nav nav-tabs">
			<li class="active">
				<a href="#"><strong>GATEWAY</strong></a>
			</li>
		</ul>
		
		<?=msg_block();?>

		<table class="table" id="table1">
			<thead>
				<tr>
					<th>ID</th>
					<th>Gateway Name</th>
				</tr>
			</thead>
			<tbody>
			</tbody>
		</table>

	</div>
</div>
<? $this->load->view('_foot'); ?>
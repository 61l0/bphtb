<? $this->load->view('_head'); ?>
<? $this->load->view(active_module().'/_navbar'); ?>

<style type="text/css">
  @import url("<?=base_url()?>assets/css/jumbotrons.css");
  @import url("<?=base_url()?>assets/css/multi-line-button.css");
</style>

<script src="<?=base_url()?>assets/js/highcharts/highcharts.js"></script>
<script src="<?=base_url()?>assets/js/highcharts/modules/exporting.js"></script>

<script type="text/javascript">
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

function get_realisasi() {
	$.ajax({
		url: "<?php echo active_module_url($this->uri->segment(2))?>get_realisasi",
		async: true,
		success: function (j) {
			var data = $.parseJSON(j);
			$('#bulan_ini1').html(data['monthly']);
			$('#bulan_ini2').html(data['monthly']);
			$('#tahun_ini').html(data['yearly']);
		},
		error: function (xhr, desc, er) {
			alert(er);
		}
	});
}

function get_realisasi_op() {
    var categories;
    var series1;
    var series2;
    
	$.ajax({
		url: "<?php echo active_module_url($this->uri->segment(2))?>get_realisasi_op",
		async: false,
		success: function (j) {
			var data = $.parseJSON(j);
            categories = data['categories'];
            series1 = data['series_last_month'];
            series2 = data['series_this_month'];
		},
		error: function (xhr, desc, er) {
			alert(er);
		}
	});
    
    $('#realisasi_bar').highcharts({
        chart: {
            type: 'bar'
        },
        title: {
            text: 'Realisasi Live Omset'
        },
        subtitle: {
            text: '<?=LICENSE_TO_SUB?> <?=LICENSE_TO?>'
        },
        xAxis: {
            categories: categories,
            title: {
                text: null
            }
        },
        yAxis: {
            min: 0,
            title: {
                text: 'Omset (Rupiah)',
                align: 'high'
            },
            labels: {
                overflow: 'justify'
            }
        },
        tooltip: {
            valuePrefix: 'Rp. ',
            valueSuffix: ' '
        },
        plotOptions: {
            bar: {
                dataLabels: {
                    enabled: true
                }
            }
        },
        legend: {
            layout: 'vertical',
            align: 'right',
            verticalAlign: 'top',
            x: -40,
            y: 100,
            floating: true,
            borderWidth: 1,
            backgroundColor: '#FFFFFF',
            shadow: true
        },
        credits: {
            enabled: false
        },
        series: [{
            name: 'Bulan Ini',
            data: series1
        }, {
            name: 'Bulan Lalu',
            data: series2
        },
        ]
    });
}

function reload_grid() {
    $('#link_grid').html('<a href="#" onClick="javascript:reload_grid();" class="label label-info">:: REALISASI</a>');
    $('#th_op').html('Objek Pajak');
	oTable.fnReloadAjax("<?=$this->uri->segment(2);?>grid_realisasi_op");
}

function get_realisasi_wp(objek_pajak) {
    $('#link_grid').html('<a href="#" onClick="javascript:reload_grid();" class="label label-info"><< REALISASI '+objek_pajak+'</a>');
    $('#th_op').html('Wajib Pajak');
	oTable.fnReloadAjax("<?=$this->uri->segment(2);?>grid_realisasi_wp/"+objek_pajak);
}

var mID;
var oTable;
$(document).ready(function() {
	oTable = $('#table1').dataTable({
		"iDisplayLength": 99,
		"sPaginationType": "full_numbers",
		"bJQueryUI": true,
		"bAutoWidth": false,
		"bFilter": false,
		"sDom": '<"toolbar">frtip',
		"aaSorting": [[ 1, "asc" ]],
		"aoColumnDefs": [			
			{ "aTargets": [0], "bSearchable": true,  "bVisible": true,  "sWidth": "", "sClass": "" },
			{ "aTargets": [1], "bSearchable": true,  "bVisible": true,  "sWidth": "100px", "sClass": "right" },
			{ "aTargets": [2], "bSearchable": true,  "bVisible": true,  "sWidth": "100px", "sClass": "right" },
		],
        /*
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
        */
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
		"sAjaxSource": "<?=active_module_url($this->uri->segment(2));?>grid_realisasi_op"
	}); 
    
    $('.toolbar').append($('#table_title'));
    
    get_realisasi();
    get_realisasi_op();
});
</script>
        
<div class="jumbotron masthead">
    <!--p>
      <a class='multi-line-button' href='#' style='width:14em'>
        <span class='title'>Start Free Trial</span>
        <span class='subtitle'>30-days free! Signup in 60 seconds</span>
      </a>
    </p>
    <p>
      <a class='multi-line-button green' href='#' style='width:14em'>
        <span class='title'>Start Free Trial</span>
        <span class='subtitle'>30-days free! Signup in 60 seconds</span>
      </a>
    </p-->
    <p></p>
    <div class="container-fluid">
        <div class="row">
            <div class="offset3 visible-desktop">
              <a class='span3 multi-line-button red' href='#'>
                <span class='title' id="bulan_ini1">calculating...</span>
                <span class='subtitle'>Bulan ini</span>
              </a>
            </div>
            <div class="span3 hidden-desktop">
              <a class='span3 multi-line-button red' href='#'>
                <span class='title' id="bulan_ini2">calculating...</span>
                <span class='subtitle'>Bulan ini</span>
              </a>
            </div>
            <div class="span3">
              <a class='span3 multi-line-button orange' href='#'>
                <span class='title' id="tahun_ini">calculating...</span>
                <span class='subtitle'>Tahun ini</span>
              </a>
            </div>
        </div>
    </div>
</div>
        
<p></p>
<div class="container-fluid">
    <div class="tabbable">
        <ul class="nav nav-tabs">
            <li class="active"><a href="#rbar" data-toggle="tab"><strong>Grafik Realisasi</strong></a></li>
            <li><a href="#rdata" data-toggle="tab"><strong>Data Realisasi</strong></a></li>
        </ul>
        
        <div class="tab-content">
            <div class="tab-pane fade in active" id="rbar">
                <div id="realisasi_bar" style="min-width: 310px; height: 280px; margin: 0 auto"></div>
            </div>
            <div class="tab-pane fade in" id="rdata">
                <div id="table_title" class="btn-group pull-left">
                    <span id="link_grid"><a href="#" onClick="javascript:reload_grid();" class="label label-info">:: REALISASI</a></span>
                </div>
                <table class="table" id="table1">
                    <thead>
                        <tr>
                            <th id="th_op">Objek Pajak</th>
                            <th>Bulan Lalu</th>
                            <th>Bulan Ini</th>
                        </tr>
                    </thead>
                    <tbody>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<!--div class="content">
	<div class="container-fluid">
		<div class="hero-unit">
		  <center>
  			<h2>PEMERINTAH <?=LICENSE_TO?></h2>
  			<h3><?=LICENSE_TO_SUB?></h3>
  			<img src="<?=base_url()?>assets/img/logo.png" alt="logo">
  			<h2>Module Live Omset</h2>
  			<P><i class="icon-star"></i> SELAMAT BEKERJA <i class="icon-star"></i></P>
			</center>
		</div>
	</div>
</div-->

<? $this->load->view('_foot'); ?>
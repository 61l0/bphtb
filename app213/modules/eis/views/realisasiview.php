<? $this->load->view('_head'); ?>
<? $this->load->view('_navbar'); ?>
<style>
.dataTables_processing {
    top: 50%;
    border: 0;
	background: none;
}
    .display.dataTable {
    margin-bottom: 8px;
    font-size: 10px;
    }
</style>
<script>
    var oCache = {
    	iCacheLower: -1
    };
    
    function fnSetKey( aoData, sKey, mValue )
    {
    	for ( var i=0, iLen=aoData.length ; i<iLen ; i++ )
    	{
    		if ( aoData[i].name == sKey )
    		{
    			aoData[i].value = mValue;
    		}
    	}
    }
    
    function fnGetKey( aoData, sKey )
    {
    	for ( var i=0, iLen=aoData.length ; i<iLen ; i++ )
    	{
    		if ( aoData[i].name == sKey )
    		{
    			return aoData[i].value;
    		}
    	}
    	return null;
    }
    
    function fnDataTablesPipeline ( sSource, aoData, fnCallback ) {
    	var iPipe = 5; /* Ajust the pipe size */
    	
    	var bNeedServer = false;
    	var sEcho = fnGetKey(aoData, "sEcho");
    	var iRequestStart = fnGetKey(aoData, "iDisplayStart");
    	var iRequestLength = fnGetKey(aoData, "iDisplayLength");
    	var iRequestEnd = iRequestStart + iRequestLength;
    	oCache.iDisplayStart = iRequestStart;
    	
    	/* outside pipeline? */
    	if ( oCache.iCacheLower < 0 || iRequestStart < oCache.iCacheLower || iRequestEnd > oCache.iCacheUpper )
    	{
    		bNeedServer = true;
    	}
    	
    	/* sorting etc changed? */
    	if ( oCache.lastRequest && !bNeedServer )
    	{
    		for( var i=0, iLen=aoData.length ; i<iLen ; i++ )
    		{
    			if ( aoData[i].name != "iDisplayStart" && aoData[i].name != "iDisplayLength" && aoData[i].name != "sEcho" )
    			{
    				if ( aoData[i].value != oCache.lastRequest[i].value )
    				{
    					bNeedServer = true;
    					break;
    				}
    			}
    		}
    	}
    	
    	/* Store the request for checking next time around */
    	oCache.lastRequest = aoData.slice();
    	
    	if ( bNeedServer )
    	{
    		if ( iRequestStart < oCache.iCacheLower )
    		{
    			iRequestStart = iRequestStart - (iRequestLength*(iPipe-1));
    			if ( iRequestStart < 0 )
    			{
    				iRequestStart = 0;
    			}
    		}
    		
    		oCache.iCacheLower = iRequestStart;
    		oCache.iCacheUpper = iRequestStart + (iRequestLength * iPipe);
    		oCache.iDisplayLength = fnGetKey( aoData, "iDisplayLength" );
    		fnSetKey( aoData, "iDisplayStart", iRequestStart );
    		fnSetKey( aoData, "iDisplayLength", iRequestLength*iPipe );
    		
    		$.getJSON( sSource, aoData, function (json) { 
    			/* Callback processing */
    			oCache.lastJson = jQuery.extend(true, {}, json);
    			
    			if ( oCache.iCacheLower != oCache.iDisplayStart )
    			{
    				json.aaData.splice( 0, oCache.iDisplayStart-oCache.iCacheLower );
    			}
    			json.aaData.splice( oCache.iDisplayLength, json.aaData.length );
    			
    			fnCallback(json)
    		} );
    	}
    	else
    	{
    		json = jQuery.extend(true, {}, oCache.lastJson);
    		json.sEcho = sEcho; /* Update the echo for each response */
    		json.aaData.splice( 0, iRequestStart-oCache.iCacheLower );
    		json.aaData.splice( iRequestLength, json.aaData.length );
    		fnCallback(json);
    		return;
    	}
    }
    
    $(document).ready(function() {
    	var oTable = $('#datatable').dataTable( {
    		//"bJQueryUI" : true, 
    		"sPaginationType" : "full_numbers",
    		"aoColumns" : [   
            { sWidth: '110pt' },
            null,
            { sWidth: '20pt', sClass: "right" },
            { sWidth: '25pt', sClass: "right" },
            { sWidth: '20pt', sClass: "right" },
            { sWidth: '25pt', sClass: "right" },
            { sWidth: '20pt', sClass: "right" },
            { sWidth: '25pt', sClass: "right" },
            { sWidth: '20pt', sClass: "right" },
            { sWidth: '25pt', sClass: "right" },
            { sWidth: '10pt', sClass: "center"},
            { sWidth: '20pt', sClass: "right" },
            { sWidth: '25pt', "sClass": "right" },
            { sWidth: '10pt', "sClass": "center"}
        ] ,
        /*
    		"aoColumnDefs": [ 
    			{ "bSearchable": false, "aTargets": [ 0 ], "bSortable": true, "aTargets": [ 0 ] }
          /*,
    			{ "bSearchable": false, "aTargets": [ 1 ], "bSortable": true, "aTargets": [ 1 ] },
    			{ "bSearchable": false, "aTargets": [ 2 ], "bSortable": true, "aTargets": [ 2 ] }
    		],*/
        //"sDom": "<'row-fluid'<'span6'T><'span6'f>r>t<'row-fluid'<'span6'i><'span6'p>>",
        //"sDom": '<"H"lTfr>t<"F"ip>',
    		"sDom":'<"toolbar">fTl<"clear">rtip',
        "oTableTools": {
        
          "sSwfPath": "<?=base_url()?>assets/datatables/extras/TableTools/media/swf/copy_csv_xls_pdf.swf"
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
        
    		"iDisplayLength": '<?=$iDisplayLength?>',
    		"iDisplayStart": '<?=$iDisplayStart?>',
    		"iSortCol_0": '<?=$iSortCol_0?>',
    		"iSortingCols": '<?=$iSortingCols?>',
    		"sEcho": '<?=$sEcho?>',
    		"sSearch": '"<?=$sSearch?>"',
    		"sSearch_0": '<?=$sSearch_0?>',
    		"sSearch_1": '<?=$sSearch_1?>',
    		"sSearch_2": '<?=$sSearch_2?>',
    		"sSortDir_0": '<?=$sSortDir_0?>',
    		"aLengthMenu": [[15, 50, 100,200, -1], [15, 50, 100, 200, "All"]],
    		"bProcessing": true,
    		"bServerSide": true,
    		"sAjaxSource": "<?=$data_source?>"
    	} );
    
      $( "#tglawal, #tglakhir" ).datepicker({
    				dateFormat:'dd-mm-yy', 
    				changeMonth:true, 
    				changeYear:true
        });
    
      $("#btngo").click(function(){
         var tahun = $("#tahun").val();
         var buku = $("#buku").val();
         var tglawal = $("#tglawal").val();
         var tglakhir = $("#tglakhir").val();
         var kec_kd = $("#kec_kd").val();
         var kel_kd = $("#kel_kd").val();
         window.location = "<?=active_module_url().'realisasi'?>/?tahun="+tahun+"&buku="+buku+"&tglawal="+ tglawal + "&tglakhir=" + tglakhir+ "&kec_kd=" + kec_kd +"&kel_kd=" + kel_kd;
      });
    
      
      $("#kec_kd, #kel_kd, #tahun, #buku").change(function(){
         var tahun = $("#tahun").val();
         var buku = $("#buku").val();
         var tglawal = $("#tglawal").val();
         var tglakhir = $("#tglakhir").val();
         var kec_kd = $("#kec_kd").val();
         var kel_kd = $("#kel_kd").val();
         window.location = "<?=active_module_url().'realisasi'?>/?tahun="+tahun+"&buku="+buku+"&tglawal="+ tglawal + "&tglakhir=" + tglakhir+ "&kec_kd=" + kec_kd +"&kel_kd=" + kel_kd;
    
      });
      
      $('#btnprint').click(function() {
         var tahun = $("#tahun").val();
         var buku = $("#buku").val();
         var tglawal = $("#tglawal").val();
         var tglakhir = $("#tglakhir").val();
         var kec_kd = $("#kec_kd").val();
         var kel_kd = $("#kel_kd").val();
         window.open("<?=active_module_url()."real_rpt/nb"?>?tahun="+tahun+"&tglawal="+ tglawal + "&tglakhir=" + tglakhir+ "&kec_kd=" + kec_kd +"&kel_kd=" + kel_kd + "&buku=" + buku,target="laporan");
       });
      
    } );
    
</script>
<div class="content">
    <div class="container-fluid">
        <ul class="nav nav-tabs" id="myTab">
            <li class="active"><a data-toggle="tab" href="#realisasi">Ketetapan dan Realisasi PBB-P2</a></li>
        </ul>
				
				<div class="form-horizontal">
                    <div class="control-group">
                        <label class="control-label">Tahun SPPT</label> 
                        <div class="controls">
                            <select id="tahun" name="tahun" style="width:80px;">
                            <?php
                                $maxtahun=date('Y');
                                for ($i=$maxtahun; $i>$maxtahun-10; $i--)
                                {
                                  $selected='';
                                  if ($i==$tahun) $selected=" selected";
                                  echo "<option value=\"$i\" $selected>$i</option>\n"; 
                                }
                                ?>
                            </select> Buku
                            <select id="buku" name="buku" style="width:125px;">
                            <?for ($i=1; $i<=5; $i++){
                                for ($j=$i;$j<=5;$j++){
                                    $r="";
                                    for ($k=$i;$k<=$j;$k++) $r.="$k,";
                                    $r=substr($r,0,strlen($r)-1);
                                    if ($buku=="$i$j") $selected="selected";
                                    else $selected="";
                                    echo "<option value=\"$i$j\" $selected>Buku $r</option>\n";
                                }
                                }
                                ?>
                            </select>
                        </div>
                    </div>
                    <div class="control-group">
                        <label class="control-label">Tgl. Realisasi</label> 
                        <div class="controls">
                            <input style="width:80px;" id="tglawal" name="tglawal" width="5" type="text" value="<?if(isset($tglawal)) echo $tglawal?>"/>
                            s.d. <input style="width:80px;" id="tglakhir" name="tglakhir" type="text" value="<?if(isset($tglakhir)) echo $tglakhir?>"/>
                            <button class="btn btn-success" id="btngo" name="btngo">Go</button>
                            <button class="btn btn-success" id="btnprint">Print Format</button>

                        </div>
                    </div>
                    <div class="control-group">
                        <label class="control-label">Kecamatan</label> 
                        <div class="controls">
                            <select id="kec_kd" name="kec_kd" <?=($user_kec_kd!='000'?" disabled" :"")?>>
                            <?php
                                if ($user_kec_kd=='000')
                                   echo "<option value=\"000\">Semua</option>\n";
                                
                                foreach ($kecamatan as $kec) 
                                {
                                 $selected='';
                                 if ($kec->kd_kecamatan==$kec_kd) $selected=" selected";
                                 echo "<option value=\"".$kec->kd_kecamatan ."\" $selected>".$kec->nm_kecamatan."</option>\n";
                                }
                                ?>
                            </select> 
                            Kelurahan
                            <select id="kel_kd" name="kel_kd">
                            <?php
                                if ($user_kel_kd=='000')
                                    echo "<option value=\"000\">Semua</option>\n";
                                print_r($kelurahan);
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
					
					<hr>
					
                    <table class="display" id="datatable" cellpadding="0" cellspacing="0" border="1">
                        <thead>
                            <tr>
                                <th rowspan="3">Kode</th>
                                <th rowspan="3">Uraian</th>
                                <th colspan="2">Pokok</th>
                                <th colspan="7">Realisasi</th>
                                <th colspan="3">Sisa</th>
                            </tr>
                            <tr>
                                <th rowspan="2">SPPT</th>
                                <th rowspan="2">Jumlah</th>
                                <th colspan="2">Lalu</th>
                                <th colspan="2">Kini</th>
                                <th colspan="2">Jumlah</th>
                                <th rowspan="2">%</th>
                                <th rowspan="2">SPPT</th>
                                <th rowspan="2">Jumlah</th>
                                <th rowspan="2">%</th>
                            </tr>
                            <tr>
                                <th>SPPT</th>
                                <th>Jumlah</th>
                                <th>SPPT</th>
                                <th>Jumlah</th>
                                <th>SPPT</th>
                                <th>Jumlah</th>
                            </tr>
                        </thead>
                        <!--tfoot> 
                            <tr> 
                              <th>Kode</th> 
                              <th>Uraian</th> 
                              <th>SPPT</th> 
                              <th>Nilai</th>
                            </tr> 
                            </tfoot-->
                        <tbody>
                            <tr>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                            </tr>
                        </tbody>
                    </table>
					
    </div>
</div>
<? $this->load->view('_foot'); ?>
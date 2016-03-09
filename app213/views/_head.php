<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="utf-8">
	<title><?=APP_TITLE?></title>
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<meta name="description" content="sistem informasi keuangan daerah">
	<meta name="author" content="irul">

    <meta http-equiv="Cache-Control" content="no-cache, no-store, must-revalidate" />
    <meta http-equiv="Pragma" content="no-cache" />
    <meta http-equiv="Expires" content="0" />

    <noscript>
        <meta http-equiv="refresh" content="0; url=<?=base_url('noscript')?>" />
    </noscript>

	<!-- Fav and touch icons -->
	<link rel="shortcut icon" href="<?=base_url()?>assets/img/favicon.ico?v=2">

	<!-- Le styles -->
	<link href="<?=base_url()?>assets/bootstrap/css/bootstrap.css" rel="stylesheet">
	<link href="<?=base_url()?>assets/css/font-static.css" rel="stylesheet">
	<style>
    body {
        padding-top: 70px; /* 60px to make the container go all the way to the bottom of the topbar */
        padding-bottom: 40px;
    }
    html {
        overflow: -moz-scrollbars-vertical; /* Always show scrollbar */
    }
    </style>
	<link href="<?=base_url()?>assets/bootstrap/css/bootstrap-responsive.css" rel="stylesheet">
    
	<link href="<?=base_url()?>assets/jq/ui-lightness/jquery-ui-1.10.2.custom.min.css" rel="stylesheet">
	<link href="<?=base_url()?>assets/datatables/media/css/jquery.dataTables.css" rel="stylesheet">
	<link href="<?=base_url()?>assets/datatables/extras/TableTools/media/css/TableTools.css" rel="stylesheet">
	
	<link href="<?=base_url()?>assets/datatables/media/css/demo_page.css" rel="stylesheet">
	<link href="<?=base_url()?>assets/datatables/media/css/demo_table_jui.css" rel="stylesheet">
	<link href="<?=base_url()?>assets/jq/smoothness/jquery-ui-1.8.4.custom.css" rel="stylesheet">
	
	<link href="<?=base_url()?>assets/css/global.css" rel="stylesheet">
  
	<script src="<?=base_url()?>assets/jq/js/jquery-1.8.2.min.js"></script>
	<script src="<?=base_url()?>assets/jq/js/jquery-ui-1.10.2.custom.min.js"></script>
  
	<script src="<?=base_url()?>assets/datatables/media/js/jquery.dataTables.min.js"></script>
	<script src="<?=base_url()?>assets/datatables/media/js/jquery.dataTables.ext.js"></script>
	<script src="<?=base_url()?>assets/datatables/extras/TableTools/media/js/ZeroClipboard.js"></script>
	<script src="<?=base_url()?>assets/datatables/extras/TableTools/media/js/TableTools.min.js"></script>
	
	<!-- FROM PAD -->
	<link href="<?=base_url()?>assets/pad/css/jquery-dialog2/jquery.dialog2.css" rel="stylesheet">
	<link href="<?=base_url()?>assets/pad/css/bootstrap-combobox.css" rel="stylesheet">
	<script src="<?=base_url()?>assets/pad/js/bootstrap-combobox.js"></script>
	<!--link href="<?=base_url()?>assets/pad/css/datepicker.css" rel="stylesheet">
	<script src="<?=base_url()?>assets/pad/js/bootstrap-datepicker.js"></script-->	
	<script src="<?=base_url()?>assets/pad/js/jquery.controls.js"></script>
	<script src="<?=base_url()?>assets/pad/js/jquery.form.js"></script>
	<script src="<?=base_url()?>assets/pad/js/jquery.dialog2.js"></script>
	<script src="<?=base_url()?>assets/pad/js/jquery.dialog2.helpers.js"></script>    
	
	<script src="<?=base_url()?>assets/bootstrap/js/bootstrap-transition.js"></script>
	<script src="<?=base_url()?>assets/bootstrap/js/bootstrap-alert.js"></script>
	<script src="<?=base_url()?>assets/bootstrap/js/bootstrap-modal.js"></script>
	<script src="<?=base_url()?>assets/bootstrap/js/bootstrap-dropdown.js"></script>
	<script src="<?=base_url()?>assets/bootstrap/js/bootstrap-scrollspy.js"></script>
	<script src="<?=base_url()?>assets/bootstrap/js/bootstrap-tab.js"></script>
	<script src="<?=base_url()?>assets/bootstrap/js/bootstrap-tooltip.js"></script>
	<script src="<?=base_url()?>assets/bootstrap/js/bootstrap-popover.js"></script>
	<script src="<?=base_url()?>assets/bootstrap/js/bootstrap-button.js"></script>
	<script src="<?=base_url()?>assets/bootstrap/js/bootstrap-collapse.js"></script>
	<script src="<?=base_url()?>assets/bootstrap/js/bootstrap-carousel.js"></script>
	<script src="<?=base_url()?>assets/bootstrap/js/bootstrap-typeahead.js"></script>	

	
	<script src="<?=base_url()?>assets/js/numberFormatter.js"></script>	
	<script src="<?=base_url()?>assets/js/autoNumeric.js"></script>
	<script src="<?=base_url()?>assets/js/jquery.formatter.js"></script>
	
	<script>
	var timer;
	var wait=10;
	document.onkeypress=resetTimer;
	document.onmousemove=resetTimer;

	function resetTimer() {
		clearTimeout(timer);
		timer=setTimeout("logout()", 60000*wait);
	}

	function logout() {
        <? if(MY_ENV != 'development'): ?>
		window.location.href='<?=base_url()?>logout';
        <? else: ?>
        resetTimer();
        <? endif; ?>
	}

	$(document).ready(function() {	
		$('#app_id').change( function() {
			window.location = '<?=base_url();?>change_module/'+$('#app_id').val();
		});

		$('#msg_helper').delay(5000).fadeOut('slow');
		$('#modalform').on('hidden', function() {
			$(this).removeData('modal');
		});
	});
	</script>
	
	<style>
	.navbar-inverse .navbar-inner {
		background-color: #373737;
	}
	.navbar-inverse .nav > li > a {
		color: #E6E6E6;
		text-shadow: 0px -1px 0px rgba(0, 0, 0, 0.25);
	}
    
	@media (min-width: 1200px)  {
        .content {
            padding-top: 45px;
        }
    }
    @media (min-width: 768px) and (max-width: 979px) {
        .content {
            padding-top: 0px;
        }
        .navbar-fixed-top {
            margin-bottom: 0px !important;
        }
    }
    @media (max-width: 767px) {
        .content {
            padding-top: 0px;
        }
    }
    @media (max-width: 480px) {
        .content {
            padding-top: 0px;
        }
    }
	</style>
    
</head>

<body>

<div class="navbar navbar-fixed-top">
  <div class="navbar-inner">
    
    <div class="container-fluid">
        <a class="brand visible-desktop" href="<?=base_url()?>" style="padding:0px;">
            <img src="<?=app_img_header('assets/img/img_header.png')?>" alt="logo-header" style="height:68px;">
        </a>
        <a class="brand hidden-desktop" href="<?=base_url()?>">
            <img src="<?=app_img_header('assets/img/img_header.png')?>" alt="logo-header" style="height:40px;">
        </a>
        
        <?if(is_login()) :?>
		<div class="btn-group pull-right" style="margin-left:4px;" >
			<a class="btn dropdown-toggle" data-toggle="dropdown" href="#">
                <span class="add-on"><i class="icon-user"></i></span>
                <span class="visible-desktop"><? echo $this->session->userdata('username');?></span>
            </a>
			<ul class="dropdown-menu pull-right">
                <li class="nav-header hidden-desktop"><? echo $this->session->userdata('username');?></li>
				<li><a href="<?echo base_url().'admin/users2/changepwd/'.sipkd_user_id();?>">Ubah Password</a></li>
				<li><a href="<?echo base_url().'logout';?>">Logout</a></li>
			</ul>
		</div>
      	<?endif;?>
		
      	<?if(is_super_admin() || $this->session->userdata('canchangemod')) :?>
		<form class="btn-group pull-right" style="margin-bottom:0px !important;">
			<select class="input-small" name="app_id" id="app_id" <?//if(!$app_enabled) echo 'disabled';?>>
				<?php if( isset($apps) && $apps): ?>
                    <? if(is_super_admin()): ?>
                        <option value="admin">ADMIN</option>
                    <?php endif; ?>
                    
                    <?php foreach($apps as $data): ?>
                        <option value="<?php echo $data->app_path;?>" <?php if(active_module()==$data->app_path) echo 'selected';?>><?php echo $data->nama;?></option>
                    <?php endforeach;?>
				<?php else:?>
                    <option value="">Not configured!</option>
				<?php endif; ?>
			</select>
		</form>
      	<?endif?>
    </div>
  </div>
</div>
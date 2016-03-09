<!--berubah-->
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
	.content {
		padding-top: 20px;
	}
    </style>
	<link href="<?=base_url()?>assets/bootstrap/css/bootstrap-responsive.css" rel="stylesheet">
	<link href="<?=base_url()?>assets/css/global.css" rel="stylesheet">
  
	<script src="<?=base_url()?>assets/jq/js/jquery-1.8.2.min.js"></script>
    
	<script>
	$(document).ready(function() {
		$('#msg_helper').delay(5000).fadeOut('slow');
	});
	</script>
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
    </div>
  </div>
</div>

<div class="content">
	<div class="container">
		<?php echo form_open('login', array('id'=>'frmlogin', 'class'=>'form'));?>
			<fieldset>
				<?=msg_block();?>
				<legend>Login Page</legend>
				<div class="control-group">
					<label class="control-label" for="userid">User ID</label>
					<div class="controls"> 
						<div class="input-prepend">
							<span class="add-on"><i class="icon-user"></i></span>
							<input type="text" style="width:180px !important;" name="userid" placeholder="User ID" autocomplete="off" />
						</div>
					</div>
				</div>
				<div class="control-group">
					<label class="control-label" for="passwd">Password</label>
					<div class="controls">
						<div class="input-prepend">
							<span class="add-on"><i class="icon-lock"></i></span>
							<input type="password" style="width:180px !important;" name="passwd" placeholder="Password" autocomplete="off" />
						</div>
					</div>
				</div>
				<div class="control-group">
					<div class="controls">
						<!--label class="checkbox">
							<input type="checkbox"> Remember me
						</label-->
						<button type="submit" class="btn btn-primary">Sign in</button>
					</div>
				</div>
			</fieldset>
		</form>
	</div>
</div>

<? $this->session->sess_destroy();?>
<? $this->load->view('_foot'); ?>
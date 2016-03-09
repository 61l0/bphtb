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

    <script>
        location.replace('<?=base_url();?>');
    </script>
    
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
	<link href="<?=base_url()?>assets/jq/ui-lightness/jquery-ui-1.10.2.custom.min.css" rel="stylesheet">
	<link href="<?=base_url()?>assets/jq/smoothness/jquery-ui-1.8.4.custom.css" rel="stylesheet">
	<link href="<?=base_url()?>assets/css/global.css" rel="stylesheet">
  
	<script src="<?=base_url()?>assets/jq/js/jquery-1.8.2.min.js"></script>
	<script src="<?=base_url()?>assets/jq/js/jquery-ui-1.10.2.custom.min.js"></script>
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
        <legend>JavaScript Required</legend>
        <div id="msg_helper1" class="alert alert-danger">
            Kami mohon maaf, Aplikasi ini memerlukan JavaScript agar dapat berjalan dengan baik. Jika Anda tidak dapat mengaktifkan JavaScript silahkan menghubungi Web Administrator. Terimakasih.
        </div>
        <div class="control-group">
            <div class="controls">
                <a href="<?=base_url();?>" class="btn">Reload Page</a>
                <a href="<?=base_url('logout');?>" class="btn btn-primary">Logout</a>
            </div>
        </div>
	</div>
</div>

<? $this->load->view('_foot'); ?>
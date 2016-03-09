<style>
	@media (min-width: 979px) {
		.wekeke{
			 margin-top: -2px !important;
			 width:100%;
			 position:fixed;
		}
		.navbar-inner {
			 border: 0px !important;
			 border-radius: 0px !important;
		}
		footer .container-fluid {
			width:100%;
			background: #000 !important;
		}
		footer .container-fluid p {
			float: right;
			margin-right: 40px;
			margin-top: 2px;
			margin-bottom: 2px;
		}
	}
	.nav-tabs {
		margin-bottom: 6px;
	}
</style>

<div class="navbar navbar-inverse wekeke" style="z-index:1029; ">
    <div class="navbar-inner">
        <button style="margin-top:8px;" class="btn btn-navbar collapsed" data-target=".nav-collapse" data-toggle="collapse" type="button">
            <span class="icon-bar" style="margin-bottom:4px;height:3px;"></span>
            <span class="icon-bar" style="margin-bottom:4px;height:3px;"></span>
            <span class="icon-bar" style="margin-bottom:4px;height:3px;"></span>
        </button>
        <a class="brand hidden-desktop" href="<?=active_module_url();?>">PBB Monitoring</a>
        
        <div class="container-fluid">
			<?if(is_login()) :?>
            <div class="nav-collapse collapse">
                <ul class="nav">
                    <!--li <?echo $current=='home' ? 'class="active"' : '';?>><a class="brand" href="<?=active_module_url();?>"><?=strtoupper(active_module());?></a></li-->
                    <li <?echo $current=='beranda' ? 'class="active"' : '';?>><a class="brand visible-desktop" href="<?=active_module_url();?>">PBB Monitoring</a></li>
                    
                    <li class="dropdown <?echo $current=='dph' ? 'active' : '';?>">
                        <a href="#" class="dropdown-toggle" data-toggle="dropdown">DPH<strong class="caret"></strong></a>
                        <ul class="dropdown-menu">
                            <li><a href="<?=active_module_url();?>dph">Entri Data</a></li>
                            <li><a href="<?=active_module_url();?>dph_posting">Download dan Posting</a></li>
                            <li><a href="<?=active_module_url();?>dph_laporan">Cetak File Keluaran</a></li>
                            <li><a href="<?=active_module_url();?>dph_gagal">Gagal Transaksi</a></li>
                        </ul>
                    </li>
                    <li class="dropdown <?echo $current=='dhkp' ? 'active' : '';?>">
                        <a href="<?=active_module_url();?>dhkp">DHKP</a>
                    </li>
                    
                    <li class="dropdown <?echo $current=='transaksi' ? 'active' : '';?>">
                        <a href="#" class="dropdown-toggle" data-toggle="dropdown">Transaksi <strong class="caret"></strong></a>
                        <ul class="dropdown-menu">
                            <li class="dropdown"><a href="<?=active_module_url();?>tranmonths">Rekap Bulanan</a></li>
                            <li class="dropdown"><a href="<?=active_module_url();?>transaksi/2">Rekap Harian</a></li>    
                            <li class="dropdown"><a href="<?=active_module_url();?>transaksi/1">Rincian Harian</a></li>
                        </ul>
                    </li>

                    <li class="dropdown <?echo $current=='realisasi' ? 'active' : '';?>">
                        <a href="#"  class="dropdown-toggle" data-toggle="dropdown">Realisasi <strong class="caret"></strong></a>
                        <ul class="dropdown-menu">
                            <li class="dropdown"><a href="<?=active_module_url();?>realisasi">Semua</a></li>
                            <li class="dropdown"><a href="<?=active_module_url();?>lb">Lebih Bayar</a></li>
                            <li class="dropdown"><a href="<?=active_module_url();?>kb">Kurang Bayar</a></li>
                            <li class="dropdown"><a href="<?=active_module_url();?>pmb">Penerimaan Pembayaran</a></li>
                        </ul>
                    </li>
                    <li class="dropdown <?echo $current=='piutang' ? 'active' : '';?>">
                        <a href="<?=active_module_url();?>piutang" class="">Piutang </strong></a>
                    </li>
                    <li class="dropdown <?echo $current=='op' ? 'active' : '';?>">
                        <a href="<?=active_module_url();?>op" class="">Objek Pajak </strong></a>
                    </li>
                    <li class="dropdown <?echo $current=='ref' ? 'active' : '';?>">
                        <a href="#" class="dropdown-toggle" data-toggle="dropdown">Referensi <strong class="caret"></strong></a>
                        <ul class="dropdown-menu">
                            <li class="dropdown"><a href="<?=active_module_url();?>user_pbbms">User PBB</a></li>
                        </ul>
                    </li>
                  </ul>
            </div>
			<? endif; ?>
		</div>
    </div>
  </div>
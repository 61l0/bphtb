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
	}
	.nav-tabs {
		margin-bottom: 6px;
	}
	.content {
		padding-top: 45px;
	}
</style>

<div class="navbar navbar-inverse wekeke" style="z-index:1029; ">
    <div class="navbar-inner">
        <div class="container-fluid">
			<?if($this->session->userdata('login')) :?>
            <div class="nav-collapse collapse">
                <ul class="nav">
                    <li <?echo $current=='beranda' ? 'class="active"' : '';?>><a class="brand" href="<?=active_module_url();?>"><?=strtoupper(active_module());?></a></li>
                    <li class="dropdown <?echo $current=='dashboard' ? 'active' : '';?>">
                        <a href="#" class="dropdown-toggle" data-toggle="dropdown">DPH <strong class="caret"></strong></a>
                        <ul class="dropdown-menu">
                            <li class="dropdown"><a href="<?=active_module_url();?>dph/entri">Entry</a></li>
                            <li class="dropdown"><a href="<?=active_module_url();?>dph/lap">Laporan</a></li>    
                            <li class="dropdown"><a href="<?=active_module_url();?>dph/download">Download</a></li>
                        </ul>
                    </li>
                    
                    <li class="dropdown <?echo $current=='transaksi' ? 'active' : '';?>">
                        <a href="#" class="dropdown-toggle" data-toggle="dropdown">Transaksi <strong class="caret"></strong></a>
                        <ul class="dropdown-menu">
                            <li class="dropdown"><a href="<?=active_module_url();?>tranmonths">Bulanan</a></li>
                            <li class="dropdown"><a href="<?=active_module_url();?>transaksi/2">Harian</a></li>    
                            <li class="dropdown"><a href="<?=active_module_url();?>transaksi/1">Range Tanggal</a></li>
                        </ul>
                    </li>

                    <li class="dropdown <?echo $current=='realiasi' ? 'active' : '';?>">
                        <a href="#"  class="dropdown-toggle" data-toggle="dropdown">Realisasi <strong class="caret"></strong></a>
                        <ul class="dropdown-menu">
                            <li class="dropdown"><a href="<?=active_module_url();?>realisasi">Semua</a></li>
                            <li class="dropdown"><a href="<?=active_module_url();?>lb">Lebih Bayar</a></li>
                            <li class="dropdown"><a href="<?=active_module_url();?>kb">Kurang Bayar</a></li>
                        </ul>
                    </li>
                    <li class="dropdown <?echo $current=='piutang' ? 'active' : '';?>">
                        <a href="<?=active_module_url();?>piutang" class="dropdown-toggle">Piutang <strong class="caret"></strong></a>
                    </li>
                    <li class="dropdown <?echo $current=='op' ? 'active' : '';?>">
                        <a href="<?=active_module_url();?>op" class="dropdown-toggle">Objek Pajak <strong class="caret"></strong></a>
                    </li>
                  </ul>
            </div>
			<? endif; ?>
		</div>
    </div>
  </div>
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
 		
			<?if(is_login()) :?>
            <div class="nav-collapse collapse">
                <ul class="nav">
                    <li <?echo $current=='beranda' ? 'class="active"' : '';?>><a class="brand" href="<?=active_module_url();?>">LIVE OMSET</a></li>
                    <li class="dropdown <?echo $current=='im' ? 'active' : '';?>">
                        <a href="#" class="dropdown-toggle" data-toggle="dropdown">IM <strong class="caret"></strong></a>
                        <ul class="dropdown-menu">
                            <li><a href="<?=active_module_url('gateway');?>">IM Gateway</a></li>
                            <li><a href="<?=active_module_url('agent');?>">Agent</a></li>
                            <li><a href="<?=active_module_url('ts100');?>">TS100</a></li>
                        </ul>
                    </li>
                    <li class="dropdown <?echo $current=='master' ? 'active' : '';?>">
                        <a href="#" class="dropdown-toggle" data-toggle="dropdown">Master <strong class="caret"></strong></a>
                        <ul class="dropdown-menu">
                            <li><a href="<?=active_module_url('wp');?>">Wajib Pajak</a></li>
                        </ul>
                    </li>
                    <li class="dropdown <?echo $current=='transaksi' ? 'active' : '';?>">
                        <a href="<?=active_module_url('bill');?>">Transaksi </strong></a>
                    </li>
                    <!--li class="dropdown <?echo $current=='dashboard' ? 'active' : '';?>">
                        <a href="#">Dashboard </strong></a>
                    </li-->
                </ul>
            </div>
			<? endif; ?>
        </div>
    </div>
</div>
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
        <a class="brand hidden-desktop" href="<?=active_module_url();?>"><?=strtoupper(active_module());?></a>
        
        <div class="container-fluid">
			<?if(is_login()) :?>
            <div class="nav-collapse collapse">
                <ul class="nav">
                    <li <?echo $current=='beranda' ? 'class="active"' : '';?>><a class="brand visible-desktop" href="<?=active_module_url();?>"><?=strtoupper(active_module());?></a></li>
                    <li class="dropdown <?echo $current=='pengaturan' ? 'active' : '';?>">
                        <a href="#" class="dropdown-toggle" data-toggle="dropdown">Pengaturan <strong class="caret"></strong></a>
                        <ul class="dropdown-menu">
                            <li><a href="<?=active_module_url('apps');?>">Aplikasi</a></li>
                            <li class="nav-header">User &amp; Privileges</li>
                            <li><a href="<?=active_module_url('users');?>">Users</a></li>
                            <li><a href="<?=active_module_url('groups');?>">Group Users</a></li>
                            <li><a href="<?=active_module_url('privileges');?>">Group Privileges</a></li>
                        </ul>
                    </li>
                </ul>
            </div>
			<? endif; ?>
        </div>
    </div>
</div>
<? $this->load->view('_head'); ?>
<? $this->load->view(active_module().'/_navbar'); ?>

<style>
.nav-tabs > .active > a, .nav-pills > .active > a:hover {
    color: blue;
}
.form-horizontal .controls {
  margin-left: 120px;  /* changed from 180px to 140px */
}
.form-horizontal .control-group {
    margin-bottom: 1px;
}
.form-horizontal .control-label{
	text-align:left;
	width: 120px; /* changed from 160px to 120px */
}
.form-horizontal input  {
	height: 14px !important;
	border-radius: 2px 2px 2px 2px !important;
	margin-bottom: 1px !important;
}
.form-horizontal select  {
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

hr {
  border: 0;
  border-bottom: 1px solid #dddddd;
}
</style>

<script>
$(document).ready(function() {
	$('#btn_cancel').click(function() {
		window.location = '<?=active_module_url($this->uri->segment(2));?>';
	});
});

$(document).keypress(function(event){
	if (event.which == '13') {
		event.preventDefault();
	}
});
</script>

<div class="content">
    <div class="container-fluid">
		<ul class="nav nav-tabs">
			<li class="active">
				<a href="#"><strong>OBJEK PAJAK</strong></a>
			</li>
		</ul>
		
		<? 
		echo msg_block();
		if(validation_errors()){
			echo '<blockquote><strong>Harap melengkapi data berikut :</strong>';
			echo validation_errors('<small>','</small>');
			echo '</blockquote>';
		} 
		?>
		
		<?php echo form_open($faction, array('id'=>'myform','class'=>'form-horizontal'));?>
                <input type="hidden" name="id" value="<?=$dt['id']?>"/>
                <div class="control-group">
                    <label class="control-label" for="nama">Nama OP</label>
                    <div class="controls">
                        <input class="input" type="text" name="nama" id="nama" value="<?=$dt['nama']?>" />
                    </div>
                </div>
                <div class="control-group">
                    <label class="control-label" for="jalan">Jalan</label>
                    <div class="controls">
                        <input class="input" type="text" name="jalan" id="jalan" value="<?=$dt['jalan']?>" />
                    </div>
                </div>
                <div class="control-group">
                    <label class="control-label" for="rt">RT</label>
                    <div class="controls">
                        <input class="input" type="text" name="rt" id="rt" value="<?=$dt['rt']?>" />
                    </div>
                </div>
                <div class="control-group">
                    <label class="control-label" for="rw">RT</label>
                    <div class="controls">
                        <input class="input" type="text" name="rw" id="rw" value="<?=$dt['rw']?>" />
                    </div>
                </div>
                <div class="control-group">
                    <label class="control-label" for="kelurahan">Kelurahan</label>
                    <div class="controls">
                        <input class="input" type="text" name="kelurahan" id="kelurahan" value="<?=$dt['kelurahan']?>" />
                    </div>
                </div>
                <div class="control-group">
                    <label class="control-label" for="kecamatan">Kecamatan</label>
                    <div class="controls">
                        <input class="input" type="text" name="kecamatan" id="kecamatan" value="<?=$dt['kecamatan']?>" />
                    </div>
                </div>
                <div class="control-group">
                    <label class="control-label" for="kabupaten">Kab./Kota</label>
                    <div class="controls">
                        <input class="input" type="text" name="kabupaten" id="kabupaten" value="<?=$dt['kabupaten']?>" />
                    </div>
                </div>
                <div class="control-group">
                    <label class="control-label" for="propinsi">Propinsi</label>
                    <div class="controls">
                        <input class="input" type="text" name="propinsi" id="propinsi" value="<?=$dt['propinsi']?>" />
                    </div>
                </div>
                <div class="control-group">
                    <label class="control-label" for="kode_pos">Kode Pos</label>
                    <div class="controls">
                        <input class="input" type="text" name="kode_pos" id="kode_pos" value="<?=$dt['kode_pos']?>" />
                    </div>
                </div>
                <div class="control-group">
                    <div class="controls">
                        <button type="submit" class="btn btn-primary">Simpan</button>
                        <button type="button" class="btn" id="btn_cancel">Batal</button>
                    </div>
                </div>
		<?php echo form_close();?>
    </div>
</div>
<? $this->load->view('_foot'); ?>
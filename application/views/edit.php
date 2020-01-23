<div class="content-wrapper">
	<section class="content">
		<?php foreach($mahasiswa as $mhs) :?>

		<?php echo form_open_multipart('mahasiswa/update'); ?>
			
			<div class="form-group">
				<label>Nama Mahasiswa</label>
				<input type="hidden" name="id" class="form-control" value="<?php echo $mhs->id ?>">
				<input type="text" name="nama" class="form-control" value="<?php echo $mhs->nama ?>">
			</div>

			<div class="form-group">
				<label>NPM</label>
				<input type="text" name="npm" class="form-control" value="<?php echo $mhs->npm ?>">
			</div>

			<div class="form-group">
				<label>Tanggal Lahir</label>
				<input type="date" name="tgl_lahir" class="form-control" value="<?php echo $mhs->tgl_lahir ?>">
			</div>

			<div class="form-group">
        		<label>Jurusan</label>
            <select name="jurusan" class="form-control" value="<?php echo $mhs->jurusan ?>">
                <option>Teknik Informatika</option>
                <option>Sistem Komputer</option>
                <option>Sistem Informasi</option>
            </select>
        	</div>

        	<div class="form-group">
				<label>Alamat</label>
				<input type="text" name="alamat" class="form-control" value="<?php echo $mhs->alamat ?>">
			</div>

			<div class="form-group">
				<label>Email</label>
				<input type="text" name="email" class="form-control" value="<?php echo $mhs->email ?>">
			</div>

			<div class="form-group">
				<label>No. Telpon</label>
				<input type="text" name="no_telp" class="form-control" value="<?php echo $mhs->no_telp ?>">
			</div>

			<div class="form-group">
				<label>Upload Foto</label>
				<input type="file" name="foto" class="form-control" value="<?php echo $mhs->foto ?>">
			</div>

			<button type="reset" class="btn btn-danger">Reset</button>
			<button type="submit" class="btn btn-primary">Simpan</button>

		<?php echo form_close(); ?>

		<?php endforeach; ?>
	</section>
</div>
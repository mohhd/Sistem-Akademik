<!DOCTYPE html>
<html><head>
	<title></title>
</head><body>

	<h3 style="text-align: center;">DATA MAHASISWA</h3>
	<br><br>
	<table>
		<tr>
			<th>No</th>
			<th>Nama Mahasiswa</th>
			<th>NPM</th>
			<th>Tanggal Lahir</th>
			<th>Jurusan</th>
			<th>Alamat</th>
			<th>Email</th>
			<th>No.Telpon</th>
		</tr>

		<?php 
		$no = 1;
		foreach ($mahasiswa as $mhs): ?>

			<tr>
				<td><?php echo $no++ ?></td>
				<td><?php echo $mhs->nama ?></td>
				<td><?php echo $mhs->npm ?></td>
				<td><?php echo $mhs->tgl_lahir ?></td>
				<td><?php echo $mhs->jurusan ?></td>
				<td><?php echo $mhs->alamat ?></td>
				<td><?php echo $mhs->email ?></td>
				<td><?php echo $mhs->no_telp ?></td>
			</tr>

		<?php endforeach; ?>
	</table>

</body></html>
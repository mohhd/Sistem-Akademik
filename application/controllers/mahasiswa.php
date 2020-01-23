<?php 

class Mahasiswa extends CI_Controller{
	public function index()
	{
		$data['mahasiswa'] = $this->m_mahasiswa->tampil_data()->result();
		$this->load->view('templates/header');
		$this->load->view('templates/sidebar');
		$this->load->view('mahasiswa', $data);
		$this->load->view('templates/footer');
	}

	public function tambah()
	{
		$this->load->view('templates/header');
		$this->load->view('templates/sidebar');
		$this->load->view('mahasiswa');
		$this->load->view('templates/footer');
	}

	public function tambah_aksi()
	{
		$nama		= $this->input->post('nama');
		$npm		= $this->input->post('npm');
		$tgl_lahir	= $this->input->post('tgl_lahir');
		$jurusan	= $this->input->post('jurusan');
		$alamat		= $this->input->post('alamat');
		$email		= $this->input->post('email');
		$no_telp	= $this->input->post('no_telp');
		$foto 		= $_FILES['foto'];
		if($foto = ''){}else{
			$config['upload_path'] 	= './assets/foto';
			$config['allowed_types'] = 'jpg|png|gif';

			$this->load->library('upload', $config);
			if(!$this->upload->do_upload('foto')){
				echo "upload gagal!"; die();
			}else{
				$foto = $this->upload->data('file_name');
			}
		}

		$data = array(
			'nama' => $nama,
			'npm' => $npm,
			'tgl_lahir' => $tgl_lahir,
			'jurusan' => $jurusan,
			'alamat' => $alamat,
			'email' => $email,
			'no_telp' => $no_telp,
			'foto'	=> $foto
		);

		$this->m_mahasiswa->input_data($data, 'tb_mahasiswa');
		$this->session->set_flashdata('message', '<div class="alert alert-success alert-dismissible" role="alert">
		  <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
		  	Data Berhasil Ditambahkan!
		  </div>');
		redirect('mahasiswa/index');
	}

	public function hapus($id)
	{
		$where = array('id' => $id);
		$this->m_mahasiswa->hapus_data($where, 'tb_mahasiswa');
		$this->session->set_flashdata('message', '<div class="alert alert-danger alert-dismissible" role="alert">
		  <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
		  	Data Berhasil Dihapus!
		  </div>');
		redirect('mahasiswa/index');
	}

	public function edit($id)
	{
		$where = array('id' => $id);
		$data['mahasiswa'] = $this->m_mahasiswa->edit_data($where, 'tb_mahasiswa')->result();

		$this->load->view('templates/header');
		$this->load->view('templates/sidebar');
		$this->load->view('edit', $data);
		$this->load->view('templates/footer');
	}

	public function update()
	{
		$id = $this->input->post('id');
		$nama = $this->input->post('nama');
		$npm = $this->input->post('npm');
		$tgl_lahir = $this->input->post('tgl_lahir');
		$jurusan = $this->input->post('jurusan');
		$alamat = $this->input->post('alamat');
		$email = $this->input->post('email');
		$no_telp = $this->input->post('no_telp');
		if($foto = ''){}else{
			$config['upload_path'] 	= './assets/foto';
			$config['allowed_types'] = 'jpg|png|gif';

			$this->load->library('upload', $config);
			if(!$this->upload->do_upload('foto')){
				echo "upload gagal!"; die();
			}else{
				$foto = $this->upload->data('file_name');
			}
		}

		$data = array(
			'nama' => $nama,
			'npm' => $npm,
			'tgl_lahir' => $tgl_lahir,
			'jurusan' => $jurusan,
			'alamat' => $alamat,
			'email' => $email,
			'no_telp' => $no_telp,
			'foto' => $foto
		);

		$where = array('id' => $id);
		$this->m_mahasiswa->update_data($where, $data, 'tb_mahasiswa');
		$this->session->set_flashdata('message', '<div class="alert alert-info alert-dismissible" role="alert">
		  <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
		  	Data Berhasil Diubah!
		  </div>');
		redirect('mahasiswa/index');
	}

	public function detail($id)
	{
		$this->load->model('m_mahasiswa');
		$detail = $this->m_mahasiswa->detail_data($id);
		$data['detail'] = $detail;

		$this->load->view('templates/header');
		$this->load->view('templates/sidebar');
		$this->load->view('detail', $data);
		$this->load->view('templates/footer');
	}

	public function cari()
	{
		$keyword = $this->input->post('keyword');
		$data['mahasiswa'] = $this->m_mahasiswa->get_keyword($keyword);
		$this->load->view('templates/header');
		$this->load->view('templates/sidebar');
		$this->load->view('mahasiswa', $data);
		$this->load->view('templates/footer');
	}

	public function print()
	{
		$data['mahasiswa'] = $this->m_mahasiswa->tampil_data("tb_mahasiswa")->result();
		$this->load->view('print_mahasiswa', $data);
	}

	public function pdf()
	{
		$this->load->library('dompdf_gen');
		$data['mahasiswa'] = $this->m_mahasiswa->tampil_data('tb_mahasiswa')->result();
		$this->load->view('laporan_pdf', $data);

		$paper_size = 'A4';
		$orientation = 'landscape';
		$html = $this->output->get_output();
		$this->dompdf->set_paper($paper_size, $orientation);
		$this->dompdf->load_html($html);
		$this->dompdf->render();
		$this->dompdf->stream("laporan_mahasiswa.pdf", array('Attachment' => 0));
	}

	public function excel()
	{
		$data['mahasiswa'] = $this->m_mahasiswa->tampil_data('tb_mahasiswa')->result();

		require(APPPATH.'PHPExcel-1.8/Classes/PHPExcel.php');
		require(APPPATH.'PHPExcel-1.8/Classes/PHPExcel/Writer/Excel2007.php');

		$object = new PHPExcel();
		$object->getProperties()->setCreator("Mohadi");
		$object->getProperties()->setLastModifiedBy("Mohadi");
		$object->getProperties()->setTitle("Daftar Mahasiswa");

		$object->setActiveSheetIndex(0);

		$object->getActiveSheet()->setCellValue('A1', 'NO');
		$object->getActiveSheet()->setCellValue('B1', 'NAMA MAHASISWA');
		$object->getActiveSheet()->setCellValue('C1', 'NPM');
		$object->getActiveSheet()->setCellValue('D1', 'TANGGAL LAHIR');
		$object->getActiveSheet()->setCellValue('E1', 'JURUSAN');
		$object->getActiveSheet()->setCellValue('F1', 'ALAMAT');
		$object->getActiveSheet()->setCellValue('G1', 'EMAIL');
		$object->getActiveSheet()->setCellValue('H1', 'NO.TELPON');

		$baris = 2;
		$no = 1;
		foreach ($data['mahasiswa'] as $mhs) {
			$object->getActiveSheet()->setCellValue('A'.$baris, $no++);
			$object->getActiveSheet()->setCellValue('B'.$baris, $mhs->nama);
			$object->getActiveSheet()->setCellValue('C'.$baris, $mhs->npm);
			$object->getActiveSheet()->setCellValue('D'.$baris, $mhs->tgl_lahir);
			$object->getActiveSheet()->setCellValue('E'.$baris, $mhs->jurusan);
			$object->getActiveSheet()->setCellValue('F'.$baris, $mhs->alamat);
			$object->getActiveSheet()->setCellValue('G'.$baris, $mhs->email);
			$object->getActiveSheet()->setCellValue('H'.$baris, $mhs->no_telp);

			$baris++;
		}

		$filename = "Data_Mahasiswa".'.xlsx';
		$object->getActiveSheet()->setTitle("Data Mahasiswa");
		header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
		header('Content-Disposition: attachment;filename="'.$filename.'"');
		header('Cache-Control: max-age=0');

		$writer = PHPExcel_IOFactory::createwriter($object, 'Excel2007');
		$writer->save('php://output');

		exit;
	}
}
<h2> Tampilan Dosen </h2>

<a href="tampildosen/tambahdata" class="btn btn-primary mb-3"> Tambah Data Dosen</a>

<?php

$model = new App\Models\Dosen;

echo "<pre>";
$data=$model->all();
foreach($data as $isi) {
echo "NIDN : ".$isi->nidn."<br />";
echo "Nama : ".$isi->nama."<br />";
echo "Alamat : ".$isi->alamat."<br />";
echo "Jurusan : ".$isi->jurusan."<br />";
echo "<hr />";
}

?>

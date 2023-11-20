<!DOCTYPE html>

<?php 
   
   ob_start();
   session_start();
   if(!isset($_SESSION['emailuser']))
   {
       header("location: login.php");
   }
   
   include "header.php";?>
   
   <!--ADA DARI TABLES.HTML-->
   <div class="container-fluid"> 
   <div class="card shadow mb-4">

<!--menggabungkan file input dan output menjadi 1-->
<?php
    include "includes/config.php";

    //kalo batal
    if(isset($_POST['batal']))
    {
        header("location:berita.php");
    }

    /*pengiriman setelah tombol submit diklik. isi dalam kurung siku hrs sesuai sama name di tombol submit*/
    if(isset($_POST['ubah']))
    {
        if(isset($_REQUEST['inputKode']))
        {
            $beritaKode = $_REQUEST['inputKode'];
        }

        if(!empty($beritaKode))
        {
            $beritaKode = $_REQUEST['inputKode'];
        }
        else
        {
            ?> <h1>Anda harus mengisi data</h1> <?php
            die("Data harus terisi");
        }
       
        $beritaJudul = $_POST['inputJudul'];
        $beritaInti = $_POST['inputInti'];
        $penulis = $_POST['inputPenulis'];
        $penerbit = $_POST['inputPenerbit'];
        $tanggal = $_POST['inputTanggal'];
        $destinasiKode = $_POST['kodeDestinasi'];

        mysqli_query($connection,"update berita set beritaJudul = '$beritaJudul', beritaInti = '$beritaInti',
        penulis = '$penulis', penerbit = '$penerbit', tanggalTerbit = '$tanggal', destinasiID = '$destinasiKode'
        where beritaID = '$beritaKode'");

        /*buat manggil formnya lagi = header(namaFile)*/
        header("location:berita.php");
    }

    $dataDestinasi = mysqli_query($connection, "select * from destinasi");

    //MENAMPILKANN DATA PADA FORM
    $kodeberita = $_GET["ubah"];
    //memanggil file berita
    $editberita = mysqli_query($connection, "select * from berita 
    where beritaID = '$kodeberita'");
    $rowedit = mysqli_fetch_array($editberita);

    //MEMUNCULKAN NAMA DESTINASI DI SEARCH
    $editdestinasi = mysqli_query($connection, "select * from berita, destinasi
    where beritaID = '$kodeberita' and berita.destinasiID = destinasi.destinasiID");
    $rowedit2 = mysqli_fetch_array($editdestinasi);
?>

<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Daftar Destinasi Wisata</title>
    <link href="css/bootstrap.min.css" rel="stylesheet" type="text/css">
    <!--link untuk membuat pluggin search-->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.3/css/select2.min.css" rel="stylesheet" type="text/css">
</head>
<body>

<div class="row">
    <div class="col-sm-1"></div>
            
        <div class="col-sm-10">
            <div class="jumbotron jumbotron-fluid" style="margin-top: 15px;">
                <div class="container">
                    <h1 class="display-4">Edit Berita Wisata</h1>
                </div>
            </div> <!--penutup jumbotron-->

            <!--FORM = dari bootstrap-->
            <form method="POST"> <!--method untuk mengirim isi input ke database-->
                <!--KODE BERITA-->
                <div class="form-group row">
                    <label for="kodeBerita" class="col-sm-2 col-form-label">Kode Berita</label>
                    <div class="col-sm-10">
                    <input type="text" class="form-control" id="kodeBerita" placeholder="Kode Berita"
                    name="inputKode" maxlength="4" value="<?php echo $rowedit["beritaID"]?>" readonly> <!--maxlength=membatasi isi, required=hrs diiisi-->
                    </div>
                </div>

                <!--JUDUL BERITA-->
                <div class="form-group row">
                    <label for="judulBerita" class="col-sm-2 col-form-label">Nama Berita</label>
                    <div class="col-sm-10">
                    <input type="text" class="form-control" id="judulBerita" placeholder="Nama Berita"
                    name="inputJudul" value="<?php echo $rowedit["beritaJudul"]?>">
                    </div>
                </div>

                <!--INTI BERITA-->
                <div class="form-group row">
                    <label for="intiBerita" class="col-sm-2 col-form-label">Inti Berita</label>
                    <div class="col-sm-10">
                    <input type="text" class="form-control" id="intiBerita" placeholder="Inti Berita"
                    name="inputInti" value="<?php echo $rowedit["beritaInti"]?>">
                    </div>
                </div>

                <!--PENULIS-->
                <div class="form-group row">
                    <label for="penulisBerita" class="col-sm-2 col-form-label">Penulis Berita</label>
                    <div class="col-sm-10">
                    <input type="text" class="form-control" id="penulisBerita" placeholder="Penulis Berita"
                    name="inputPenulis" value="<?php echo $rowedit["penulis"]?>">
                    </div>
                </div>
                
                <!--PENERBIT-->
                <div class="form-group row">
                    <label for="penerbitBerita" class="col-sm-2 col-form-label">Penerbit Berita</label>
                    <div class="col-sm-10">
                    <input type="text" class="form-control" id="penerbitBerita" placeholder="Penerbit Berita"
                    name="inputPenerbit" value="<?php echo $rowedit["penerbit"]?>">
                    </div>
                </div>

                <!--TANGGAL TERBIT-->
                <div class="form-group row">
                    <label for="tanggalTerbit" class="col-sm-2 col-form-label">Tanggal Terbit</label>
                    <div class="col-sm-10">
                    <input type="date" class="form-control" id="tanggalTerbit" placeholder="Tanggal Terbit"
                    name="inputTanggal" value="<?php echo $rowedit["tanggalTerbit"]?>">
                    </div>
                </div>

                <!--DESTINASI ID-->
                <div class="form-group row">
                    <label for="refKategori" class="col-sm-2 col-form-label">Daftar Destinasi</label>
                    <div class="col-sm-10">
                    <select class="form-control" name="kodeDestinasi" id="kodedestinasi">
                            <option value="<?php echo $rowedit["destinasiID"]?>">
                                <?php echo $rowedit["destinasiID"]?>
                                <?php echo $rowedit2["destinasiNama"]?>
                            </option>
                        <?php while($row = mysqli_fetch_array($dataDestinasi))
                        {?>
                            <option value="<?php echo $row["destinasiID"]?>">
                                <?php echo $row["destinasiID"]?>
                                <?php echo $row["destinasiNama"]?>
                            </option>
                        <?php } ?>
                    </select>
                    </div>
                </div>

                <!--BUTTON = dari bootstrap-->
                <div class="form-group row mb-5">
                    <div class="col-sm-2"></div>
                    <div class="col-sm-10">
                    <button type="submit" class="btn btn-primary" style="background: #3A8891; border: 1px solid #3A8891;" name="ubah">Ubah</button>
                    <button type="reset" class="btn btn-secondary" name="batal">Batal</button>
                    </div>
                </div>
            </form>
        </div>
        
        <div class="col-sm-1"></div>
</div> <!--penutup row input-->


    <!--dikomputer ada 12 kolom. dalam bootstrap ada grid = untuk kasih jarak/mirip kaya padding-->
    <div class="row">
        <div class="col-sm-1"></div>
        <div class="col-sm-10">
            <div class="jumbotron jumbotron-fluid">
                <div class="container">
                    <h1 class="display-4">Daftar Berita Wisata</h1>
                    <h2>Hasil Entri Data pada Tabel Berita</h2>
                </div>
            </div> <!--penutup jumbotron-->

            <!--untuk mencari data pda tabel. POSt = untuk mengirim-->
            <form method="POST">
                <div class="from-group row mb-2">
                <label for="search" class="col-sm-3">Judul Berita</label>
                    <div class="col-sm-6">
                    <!--supaya gailang tulisannya pas di search-->
                        <input type="text" class="form-control" name="search" id="search" 
                        placeholder="Cari Judul Berita" value="<?php 
                        if(isset($_POST['search'])) {echo $_POST['search'];}?>">
                    </div>
                    <input type="submit" name="kirim" class="col-sm-1 btn btn-danger" value="Search">
                </div>
            </form>

            <table class="table table-hover table" style="background: #EFF5F5;">
                <thead class="thead-dark">
                    <tr>
                        <th>No</th>
                        <th>Kode Berita</th>
                        <th>Judul Berita</th>
                        <th>Inti Berita</th>
                        <th>Penulis</th>
                        <th>Penerbit</th>
                        <th>Tanggal Terbit</th>
                        <th>Objek Wisata</th>

                        <th colspan="2" style="text-align: center;">Action</th>
                    </tr>
                </thead>
                <tbody>
                    <!--pemanggilan tabel dari database-->
                    <?php
                        //untuk menerima apa yang dikirim dari search
                        if(isset($_POST['kirim']))
                        {
                            $search = $_POST['search'];
                            $query = mysqli_query($connection, "select * from berita, destinasi
                            where beritaJudul like '%$search%'
                            and berita.destinasiID = destinasi.destinasiID");
                            //'%".$search."%' atau '%$search%'= mencari dari kata yang terkandung
                            //'%$search' = mencari dari kata paling blakang
                            //'$search%' = mencari dari kata paling depan
                        }
                        else
                        { 
                            $query = mysqli_query($connection, "select * from berita, destinasi
                            where berita.destinasiID = destinasi.destinasiID");
                        }
                        $nomor = 1; //menampilkan nomor dari no. 1
                        while($row = mysqli_fetch_array($query))
                        {?>
                            <tr>
                                <td><?php echo $nomor;?></td>
                                <td><?php echo $row['beritaID'];?></td>
                                <td><?php echo $row['beritaJudul'];?></td>
                                <td><?php echo $row['beritaInti'];?></td>
                                <td><?php echo $row['penulis'];?></td>
                                <td><?php echo $row['penerbit'];?></td>
                                <td><?php echo $row['tanggalTerbit'];?></td>
                                <td><?php echo $row['destinasiNama'];?></td>

                                <!--ICON EDIT-->
                                <td>
                                    <!--php?ubah. ubah = variabel penampungnya-->
                                    <a href="beritaedit.php?ubah=<?php echo $row["beritaID"]?>" class="btn btn-success btn-sm"
                                    title="Edit">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-pencil-square" viewBox="0 0 16 16">
                                        <path d="M15.502 1.94a.5.5 0 0 1 0 .706L14.459 3.69l-2-2L13.502.646a.5.5 0 0 1 .707 0l1.293 1.293zm-1.75 2.456-2-2L4.939 9.21a.5.5 0 0 0-.121.196l-.805 2.414a.25.25 0 0 0 .316.316l2.414-.805a.5.5 0 0 0 .196-.12l6.813-6.814z"/>
                                        <path fill-rule="evenodd" d="M1 13.5A1.5 1.5 0 0 0 2.5 15h11a1.5 1.5 0 0 0 1.5-1.5v-6a.5.5 0 0 0-1 0v6a.5.5 0 0 1-.5.5h-11a.5.5 0 0 1-.5-.5v-11a.5.5 0 0 1 .5-.5H9a.5.5 0 0 0 0-1H2.5A1.5 1.5 0 0 0 1 2.5v11z"/>
                                        </svg>
                                    </a>
                                </td>
                                
                                <!--ICON DELETE-->
                                <td>
                                    <a href="beritahapus.php?hapus=<?php echo $row["beritaID"]?>" class="btn btn-danger btn-sm"
                                    title="Delete">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-trash" viewBox="0 0 16 16">
                                        <path d="M5.5 5.5A.5.5 0 0 1 6 6v6a.5.5 0 0 1-1 0V6a.5.5 0 0 1 .5-.5zm2.5 0a.5.5 0 0 1 .5.5v6a.5.5 0 0 1-1 0V6a.5.5 0 0 1 .5-.5zm3 .5a.5.5 0 0 0-1 0v6a.5.5 0 0 0 1 0V6z"/>
                                        <path fill-rule="evenodd" d="M14.5 3a1 1 0 0 1-1 1H13v9a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V4h-.5a1 1 0 0 1-1-1V2a1 1 0 0 1 1-1H6a1 1 0 0 1 1-1h2a1 1 0 0 1 1 1h3.5a1 1 0 0 1 1 1v1zM4.118 4 4 4.059V13a1 1 0 0 0 1 1h6a1 1 0 0 0 1-1V4.059L11.882 4H4.118zM2.5 3V2h11v1h-11z"/>
                                        </svg>
                                    </a>
                                </td>
                            </tr>
                        <?php
                        $nomor = $nomor + 1;}
                    ?>

                </tbody>
            </table>
        </div>
        <div class="col-sm-1"></div>
    </div>
<script type="text/javascript" src="js/bootstrap.min.js"></script>
<!--script untuk select2-->
<script type="text/javascript" src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.1/jquery.min.js"></script>
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.3/js/select2.min.js"></script>

<script type="text/javascript">
    $(document).ready(function(){
        $('#kodekategori').select2({
            placeholder: "Pilih kategori Wisata",
            allowClear: true
        });
    });
</script>

<script type="text/javascript">
    $(document).ready(function(){
        $('#kodearea').select2({
            placeholder: "Pilih area Wisata",
            allowClear: true
        });
    });
</script>

<?php include "footer.php";?>
<?php
    mysqli_close($connection);
    ob_end_flush();
?>

</body>
</html>
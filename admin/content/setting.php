<?php
//jika data setting sudah ada maka update data tersebut
//selain itu kalo blm ada maka insert data

$querySetting = mysqli_query($koneksi, "SELECT * FROM settings LIMIT 1"); //LIMIT 1 adalah data yang dimaksudkan hanya 1
$row = mysqli_fetch_assoc($querySetting);

if (isset($_POST['simpan'])) {
    $name = $_POST['name'];
    $fb = $_POST['fb'];
    $ig = $_POST['ig'];
    $twitter = $_POST['twitter'];
    $linkedin = $_POST['linkedin'];

    //jika gambar terupload
    if (!empty($_FILES['logo']['name'])) {
        $logo = $_FILES['logo']['name'];
        $path = "uploads/";
        if (!is_dir($path))
            mkdir($path); //mkdir itu untuk memebuat folder jika belum ada //is_dir itu untuk mengecek apakah folder sudah ada atau belum

        $logo_name = time() . "-" . basename($logo);
        $target_files = $path . $logo_name;
        if (move_uploaded_file($_FILES['logo']['tmp_name'], $target_files)) {
            //jika gambarnya ada maka gambar sebelumnya akan di ganti oleh gambar baru
            if (!empty($row['logo'])) {
                unlink($path . $row['logo']); //unlink untuk menghapus file

            }

        }
    }


    if ($row) {
        //update 

        $id_setting = $row['id'];
        $update = mysqli_query($koneksi, "UPDATE settings SET name='$name',ig='$ig', fb='$fb', twitter= '$twitter',linkedin='$linkedin'");
        if ($update) {
            header("location:?page=setting&ubah=berhasil");
        }
    } else {
        //insert
        $insert = mysqli_query($koneksi, "INSERT INTO settings (name, ig, fb, twitter,linkedin) VALUES ('$name', '$ig', '$fb', '$twitter','$linkedin')");
        if ($insert) {
            header("location:?page=setting&tambah=berhasil");
        }

    }
}


?>


<div class="pagetitle">
    <h1 class="text-light mb-4">Setting</h1>
</div>

<section class="section">
    <div class="row justify-content-center">
        <div class="col-lg-10">

            <!-- Card utama -->
            <div class="card bg-secondary bg-gradient text-light shadow-lg border-0">
                <div class="card-body p-4">
                    <h5 class="card-title text-warning border-bottom border-light pb-2">Pengaturan Umum</h5>

                    <form action="" method="post" enctype="multipart/form-data">
                        <!-- Name -->
                        <div class="mb-3 mt-3 row">
                            <label class="col-sm-2 col-form-label fw-semibold text-light">Name</label>
                            <div class="col-sm-8">
                                <input type="text" name="name" class="form-control bg-dark-subtle text-light border-0"
                                    value="<?php echo isset($row['name']) ? $row['name'] : '' ?>">
                            </div>
                        </div>

                        <!-- Email -->
                        <div class="mb-3 row">
                            <label class="col-sm-2 col-form-label fw-semibold text-light">Email</label>
                            <div class="col-sm-8">
                                <input type="email" name="email" class="form-control bg-dark-subtle text-light border-0"
                                    value="<?php echo isset($row['email']) ? $row['email'] : '' ?>">
                            </div>
                        </div>

                        <!-- Alamat -->
                        <div class="mb-3 row">
                            <label class="col-sm-2 col-form-label fw-semibold text-light">Alamat</label>
                            <div class="col-sm-8">
                                <textarea name="alamat" id="alamat" class="form-control bg-dark-subtle text-light border-0"
                                    rows="3"><?php echo isset($row['address']) ? $row['address'] : '' ?></textarea>
                            </div>
                        </div>

                        <!-- Facebook -->
                        <div class="mb-3 row">
                            <label class="col-sm-2 col-form-label fw-semibold text-light">Facebook</label>
                            <div class="col-sm-8">
                                <input type="url" name="fb" class="form-control bg-dark-subtle text-light border-0"
                                    value="<?php echo isset($row['fb']) ? $row['fb'] : '' ?>">
                            </div>
                        </div>

                        <!-- Twitter -->
                        <div class="mb-3 row">
                            <label class="col-sm-2 col-form-label fw-semibold text-light">Twitter</label>
                            <div class="col-sm-8">
                                <input type="url" name="twitter" class="form-control bg-dark-subtle text-light border-0"
                                    value="<?php echo isset($row['twitter']) ? $row['twitter'] : '' ?>">
                            </div>
                        </div>

                        <!-- Instagram -->
                        <div class="mb-3 row">
                            <label class="col-sm-2 col-form-label fw-semibold text-light">Instagram</label>
                            <div class="col-sm-8">
                                <input type="url" name="ig" class="form-control bg-dark-subtle text-light border-0"
                                    value="<?php echo isset($row['ig']) ? $row['ig'] : '' ?>">
                            </div>
                        </div>

                        <!-- LinkedIn -->
                        <div class="mb-4 row">
                            <label class="col-sm-2 col-form-label fw-semibold text-light">LinkedIn</label>
                            <div class="col-sm-8">
                                <input type="url" name="linkedin" class="form-control bg-dark-subtle text-light border-0"
                                    value="<?php echo isset($row['linkedin']) ? $row['linkedin'] : '' ?>">
                            </div>
                        </div>

                        <!-- Tombol -->
                        <div class="text-end">
                            <button type="submit" name="simpan" class="btn btn-warning fw-bold px-4">
                                Simpan
                            </button>
                        </div>
                    </form>

                </div>
            </div>

        </div>
    </div>
</section>


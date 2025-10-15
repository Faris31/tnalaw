<?php
// Ambil semua data user
$query = mysqli_query($koneksi, "SELECT * FROM users ORDER BY id DESC");
$rows = mysqli_fetch_all($query, MYSQLI_ASSOC);

// Inisialisasi variabel
$id = isset($_POST['id']) ? $_POST['id'] : '';
$name = isset($_POST['name']) ? $_POST['name'] : '';
$email = isset($_POST['email']) ? $_POST['email'] : '';
$password = isset($_POST['password']) ? $_POST['password'] : '';

// DELETE 
if (isset($_GET['delete'])) {
    $id = $_GET['delete'];
    $delete = mysqli_query($koneksi, "DELETE FROM users WHERE id='$id'");
    if ($delete) {
        header("location:?page=user&hapus=berhasil");
        exit;
    }
}

// INSERT / UPDATE 
if (isset($_POST['simpan'])) {
    if (!empty($id)) {
        // update user
        $update = mysqli_query($koneksi, "UPDATE users SET name='$name', email='$email', password='$password' WHERE id='$id'");
        if ($update) {
            header("location:?page=user&ubah=berhasil");
            exit;
        }
    } else {
        // insert user baru
        $insert = mysqli_query($koneksi, "INSERT INTO users (name, email, password) VALUES('$name', '$email', '$password')");
        if ($insert) {
            header("location:?page=user&tambah=berhasil");
            exit;
        }
    }
}
?>

<div class="pagetitle">
    <h1 class="text-light mb-4">Data User</h1>
</div>

<section class="section">
    <div class="row">
        <div class="col-lg-12">
            <div class="card bg-secondary bg-gradient text-light shadow-lg border-0">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center mt-3 mb-4">
                        <h5 class="card-title text-warning mb-0">Daftar Pengguna</h5>
                        <button class="btn btn-warning fw-semibold" data-bs-toggle="modal" data-bs-target="#modalUser" onclick="resetForm()">
                            <i class="bi bi-person-plus"></i> Tambah User
                        </button>
                    </div>

                    <table class="table table-dark table-striped table-hover align-middle text-center rounded-3 overflow-hidden">
                        <thead class="table-warning text-dark">
                            <tr>
                                <th scope="col">No</th>
                                <th scope="col">Nama</th>
                                <th scope="col">Email</th>
                                <th scope="col">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($rows as $key => $row): ?>
                                <tr>
                                    <td><?= $key + 1 ?></td>
                                    <td><?= htmlspecialchars($row['name']) ?></td>
                                    <td><?= htmlspecialchars($row['email']) ?></td>
                                    <td>
                                        <button 
                                            class="btn btn-sm btn-outline-warning me-1"
                                            data-bs-toggle="modal"
                                            data-bs-target="#modalUser"
                                            onclick="editUser('<?= $row['id'] ?>', '<?= htmlspecialchars($row['name']) ?>', '<?= htmlspecialchars($row['email']) ?>', '<?= htmlspecialchars($row['password']) ?>')">
                                            <i class="bi bi-pencil-square"></i>
                                        </button>
                                        <a href="?page=user&delete=<?= $row['id'] ?>" 
                                           class="btn btn-sm btn-outline-danger"
                                           onclick="return confirm('Apakah Anda yakin ingin menghapus data ini?')">
                                           <i class="bi bi-trash"></i>
                                        </a>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>

                </div>
            </div>
        </div>
    </div>
</section>

<!-- Modal Tambah/Edit User -->
<div class="modal fade" id="modalUser" tabindex="-1" aria-labelledby="modalUserLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content bg-dark text-light border-0 shadow-lg">
      <form method="POST">
        <div class="modal-header bg-secondary bg-gradient text-warning">
          <h5 class="modal-title fw-semibold" id="modalUserLabel">Tambah User</h5>
          <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
            <input type="hidden" name="id" id="id">
            <div class="mb-3">
                <label class="form-label">Nama</label>
                <input type="text" class="form-control bg-dark-subtle text-light border-0" name="name" id="name" required>
            </div>
            <div class="mb-3">
                <label class="form-label">Email</label>
                <input type="email" class="form-control bg-dark-subtle text-light border-0" name="email" id="email" required>
            </div>
            <div class="mb-3">
                <label class="form-label">Password</label>
                <input type="text" class="form-control bg-dark-subtle text-light border-0" name="password" id="password" required>
            </div>
        </div>
        <div class="modal-footer bg-secondary bg-gradient border-0">
          <button type="button" class="btn btn-outline-light" data-bs-dismiss="modal">Batal</button>
          <button type="submit" name="simpan" class="btn btn-warning fw-semibold">Simpan</button>
        </div>
      </form>
    </div>
  </div>
</div>


<script>
function editUser(id, name, email, password) {
    document.getElementById('modalUserLabel').innerText = "Edit User";
    document.getElementById('id').value = id;
    document.getElementById('name').value = name;
    document.getElementById('email').value = email;
    document.getElementById('password').value = password;
}

function resetForm() {
    document.getElementById('modalUserLabel').innerText = "Tambah User";
    document.getElementById('id').value = "";
    document.getElementById('name').value = "";
    document.getElementById('email').value = "";
    document.getElementById('password').value = "";
}
</script>

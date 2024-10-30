<?php
// Inisialisasi array barang
$barang = [
    ["id" => 1, "nama" => "Buku", "kategori" => "Alat Tulis", "harga" => 20000],
    ["id" => 2, "nama" => "Pulpen", "kategori" => "Alat Tulis", "harga" => 5000]
];

// Fungsi untuk mendapatkan ID baru
function getNewId($barang) {
    return count($barang) > 0 ? end($barang)["id"] + 1 : 1;
}

// Tambah barang
if (isset($_POST["tambah"])) {
    $id = getNewId($barang);
    $nama = $_POST["nama"];
    $kategori = $_POST["kategori"];
    $harga = $_POST["harga"];
    $barang[] = ["id" => $id, "nama" => $nama, "kategori" => $kategori, "harga" => $harga];
}

// Edit barang
if (isset($_POST["edit"])) {
    foreach ($barang as &$item) {
        if ($item["id"] == $_POST["id"]) {
            $item["nama"] = $_POST["nama"];
            $item["kategori"] = $_POST["kategori"];
            $item["harga"] = $_POST["harga"];
            break;
        }
    }
}

// Hapus barang
if (isset($_GET["hapus"])) {
    $id_hapus = $_GET["hapus"];
    foreach ($barang as $key => $item) {
        if ($item["id"] == $id_hapus) {
            unset($barang[$key]);
            break;
        }
    }
    $barang = array_values($barang); // Reindex array
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Manajemen Barang</title>
</head>
<body>
    <h2>Tambah Barang</h2>
    <form method="POST">
        <label>Nama Barang:</label><br>
        <input type="text" name="nama" required><br>
        <label>Kategori Barang:</label><br>
        <input type="text" name="kategori" required><br>
        <label>Harga Barang:</label><br>
        <input type="number" name="harga" required><br><br>
        <button type="submit" name="tambah">Tambah Barang</button>
    </form>

    <h2>Daftar Barang</h2>
    <table border="1">
        <tr>
            <th>ID</th>
            <th>Nama Barang</th>
            <th>Kategori</th>
            <th>Harga</th>
            <th>Aksi</th>
        </tr>
        <?php foreach ($barang as $item): ?>
        <tr>
            <td><?= $item["id"] ?></td>
            <td><?= $item["nama"] ?></td>
            <td><?= $item["kategori"] ?></td>
            <td><?= $item["harga"] ?></td>
            <td>
                <a href="?edit=<?= $item["id"] ?>">Edit</a>
                <a href="?hapus=<?= $item["id"] ?>">Hapus</a>
            </td>
        </tr>
        <?php endforeach; ?>
    </table>

    <?php if (isset($_GET["edit"])): ?>
        <?php
        $id_edit = $_GET["edit"];
        $barang_edit = null;
        foreach ($barang as $item) {
            if ($item["id"] == $id_edit) {
                $barang_edit = $item;
                break;
            }
        }
        ?>
        <?php if ($barang_edit): ?>
            <h2>Edit Barang</h2>
            <form method="POST">
                <input type="hidden" name="id" value="<?= $barang_edit["id"] ?>">
                <label>Nama Barang:</label><br>
                <input type="text" name="nama" value="<?= $barang_edit["nama"] ?>" required><br>
                <label>Kategori Barang:</label><br>
                <input type="text" name="kategori" value="<?= $barang_edit["kategori"] ?>" required><br>
                <label>Harga Barang:</label><br>
                <input type="number" name="harga" value="<?= $barang_edit["harga"] ?>" required><br><br>
                <button type="submit" name="edit">Simpan Perubahan</button>
            </form>
        <?php endif; ?>
    <?php endif; ?>
</body>
</html>

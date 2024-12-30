<?php
include 'db.php';

// Fungsi delete jika ada parameter `delete` di URL
if (isset($_GET['delete'])) {
    $id = $_GET['delete'];
    $conn->query("DELETE FROM news WHERE id = $id");
    header('Location: index.php'); // Redirect setelah delete
    exit;
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Portal Berita</title>
    <link rel="stylesheet" href="assets/css/bootstrap.min.css">
</head>

<body>
    <div class="container mt-4">
        <h1 class="mb-4">Portal Berita</h1>
        <a href="insert.php" class="btn btn-primary mb-3">Tambah Berita</a>
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>No</th>
                    <th>Judul</th>
                    <th>Kategori</th>
                    <th>Penulis</th>
                    <th>Tanggal</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                <?php
                $query = "
            SELECT 
                news.id, 
                news.title, 
                categories.name AS category, 
                authors.name AS author, 
                news.created_at 
            FROM news
            LEFT JOIN categories ON news.category_id = categories.id
            LEFT JOIN authors ON news.author_id = authors.id
            ORDER BY news.created_at DESC
        ";
                $result = $conn->query($query);
                $no = 1;
                while ($row = $result->fetch_assoc()): ?>
                    <tr>
                        <td><?= $no++ ?></td>
                        <td><?= htmlspecialchars($row['title']) ?></td>
                        <td><?= htmlspecialchars($row['category'] ?? 'Tidak Ada') ?></td>
                        <td><?= htmlspecialchars($row['author'] ?? 'Tidak Ada') ?></td>
                        <td><?= $row['created_at'] ?></td>
                        <td>
                            <a href="detail.php?id=<?= $row['id'] ?>" class="btn btn-info btn-sm">Detail</a>
                            <a href="update.php?id=<?= $row['id'] ?>" class="btn btn-warning btn-sm">Edit</a>
                            <a href="index.php?delete=<?= $row['id'] ?>" class="btn btn-danger btn-sm" onclick="return confirm('Yakin ingin menghapus berita ini?')">Hapus</a>
                        </td>
                    </tr>
                <?php endwhile; ?>
            </tbody>
        </table>
    </div>
</body>

</html>
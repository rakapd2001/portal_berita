<?php include 'db.php'; ?>

<?php
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $title = $_POST['title'];
    $content = $_POST['content'];
    $category_id = $_POST['category_id'];
    $author_id = $_POST['author_id'];
    $conn->query("INSERT INTO news (title, content, category_id, author_id) VALUES ('$title', '$content', $category_id, $author_id)");
    header('Location: index.php');
    exit;
}

// Fetch kategori dan penulis
$categories = $conn->query("SELECT * FROM categories");
$authors = $conn->query("SELECT * FROM authors");
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tambah Berita</title>
    <link rel="stylesheet" href="assets/css/bootstrap.min.css">
</head>

<body>
    <div class="container mt-4">
        <h1>Tambah Berita</h1>
        <form method="POST">
            <div class="mb-3">
                <label for="title" class="form-label">Judul</label>
                <input type="text" class="form-control" id="title" name="title" required>
            </div>
            <div class="mb-3">
                <label for="content" class="form-label">Konten</label>
                <textarea class="form-control" id="content" name="content" rows="5" required></textarea>
            </div>
            <div class="mb-3">
                <label for="category_id" class="form-label">Kategori</label>
                <select name="category_id" id="category_id" class="form-control" required>
                    <option value="">-- Pilih Kategori --</option>
                    <?php while ($category = $categories->fetch_assoc()): ?>
                        <option value="<?= $category['id'] ?>"><?= $category['name'] ?></option>
                    <?php endwhile; ?>
                </select>
            </div>
            <div class="mb-3">
                <label for="author_id" class="form-label">Penulis</label>
                <select name="author_id" id="author_id" class="form-control" required>
                    <option value="">-- Pilih Penulis --</option>
                    <?php while ($author = $authors->fetch_assoc()): ?>
                        <option value="<?= $author['id'] ?>"><?= $author['name'] ?></option>
                    <?php endwhile; ?>
                </select>
            </div>
            <button type="submit" class="btn btn-primary">Simpan</button>
            <a href="index.php" class="btn btn-secondary">Kembali</a>
        </form>
    </div>
</body>

</html>
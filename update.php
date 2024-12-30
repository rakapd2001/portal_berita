<?php include 'db.php'; ?>

<?php
// Ambil ID berita dari parameter URL
$id = $_GET['id'] ?? null;

// Redirect ke index.php jika ID tidak ada
if (!$id) {
    header('Location: index.php');
    exit;
}

// Ambil data berita berdasarkan ID
$result = $conn->query("SELECT * FROM news WHERE id = $id");
$news = $result->fetch_assoc();

// Redirect jika berita tidak ditemukan
if (!$news) {
    header('Location: index.php');
    exit;
}

// Ambil data kategori dan penulis
$categories = $conn->query("SELECT * FROM categories");
$authors = $conn->query("SELECT * FROM authors");

// Proses update data
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $title = $_POST['title'];
    $content = $_POST['content'];
    $category_id = $_POST['category_id'];
    $author_id = $_POST['author_id'];

    $conn->query("
        UPDATE news 
        SET 
            title = '$title',
            content = '$content',
            category_id = $category_id,
            author_id = $author_id
        WHERE id = $id
    ");

    header('Location: index.php'); // Redirect setelah update
    exit;
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Update Berita</title>
    <link rel="stylesheet" href="assets/css/bootstrap.min.css">
</head>

<body>
    <div class="container mt-4">
        <h1>Update Berita</h1>
        <form method="POST">
            <div class="mb-3">
                <label for="title" class="form-label">Judul</label>
                <input
                    type="text"
                    class="form-control"
                    id="title"
                    name="title"
                    value="<?= htmlspecialchars($news['title']) ?>"
                    required>
            </div>
            <div class="mb-3">
                <label for="content" class="form-label">Konten</label>
                <textarea
                    class="form-control"
                    id="content"
                    name="content"
                    rows="5"
                    required><?= htmlspecialchars($news['content']) ?></textarea>
            </div>
            <div class="mb-3">
                <label for="category_id" class="form-label">Kategori</label>
                <select name="category_id" id="category_id" class="form-control" required>
                    <option value="">-- Pilih Kategori --</option>
                    <?php while ($category = $categories->fetch_assoc()): ?>
                        <option
                            value="<?= $category['id'] ?>"
                            <?= $news['category_id'] == $category['id'] ? 'selected' : '' ?>>
                            <?= htmlspecialchars($category['name']) ?>
                        </option>
                    <?php endwhile; ?>
                </select>
            </div>
            <div class="mb-3">
                <label for="author_id" class="form-label">Penulis</label>
                <select name="author_id" id="author_id" class="form-control" required>
                    <option value="">-- Pilih Penulis --</option>
                    <?php while ($author = $authors->fetch_assoc()): ?>
                        <option
                            value="<?= $author['id'] ?>"
                            <?= $news['author_id'] == $author['id'] ? 'selected' : '' ?>>
                            <?= htmlspecialchars($author['name']) ?>
                        </option>
                    <?php endwhile; ?>
                </select>
            </div>
            <button type="submit" class="btn btn-primary">Simpan Perubahan</button>
            <a href="index.php" class="btn btn-secondary">Batal</a>
        </form>
    </div>
</body>

</html>
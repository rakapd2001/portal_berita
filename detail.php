<?php
// Include file koneksi database
include 'db.php';

// Ambil ID berita dari URL
$id = isset($_GET['id']) ? intval($_GET['id']) : 0;

// Query untuk mengambil detail berita berdasarkan ID
$query = "SELECT 
            news.title, 
            news.content, 
            categories.name AS category_name, 
            authors.name AS author_name, 
            news.created_at 
          FROM 
            news 
          JOIN 
            categories ON news.category_id = categories.id 
          JOIN 
            authors ON news.author_id = authors.id 
          WHERE 
            news.id = ?";
$stmt = $conn->prepare($query);
$stmt->bind_param("i", $id);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows > 0) {
    $row = $result->fetch_assoc();
} else {
    echo "Berita tidak ditemukan!";
    exit;
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Detail Berita</title>
    <link rel="stylesheet" href="assets/css/bootstrap.min.css">
</head>

<body>
    <div class="container mt-5">
        <a href="index.php" class="btn btn-secondary mb-3">Kembali</a>
        <h1><?php echo htmlspecialchars($row['title']); ?></h1>
        <p><strong>Kategori:</strong> <?php echo htmlspecialchars($row['category_name']); ?></p>
        <p><strong>Penulis:</strong> <?php echo htmlspecialchars($row['author_name']); ?></p>
        <p><strong>Tanggal:</strong> <?php echo date('d M Y, H:i', strtotime($row['created_at'])); ?></p>
        <hr>
        <p><?php echo nl2br(htmlspecialchars($row['content'])); ?></p>
    </div>
</body>

</html>
<?php
$uploadDir = "uploads/";

if (!is_dir($uploadDir)) {
    mkdir($uploadDir, 0777, true);
}

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_FILES['file'])) {
    $tmp_name = $_FILES['file']['tmp_name'];
    $name = basename($_FILES['file']['name']);
    move_uploaded_file($tmp_name, "$uploadDir$name");
    echo "<p>File uploaded: $name</p>";
}

$files = glob("$uploadDir*");
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>File Manager</title>
</head>
<body>

<h2>Upload & Manage Files</h2>

<form method="post" enctype="multipart/form-data">
    <input type="file" name="file" required>
    <button type="submit">Upload</button>
</form>

<h3>Uploaded Files</h3>
<ul>
    <?php foreach ($files as $file): ?>
        <li>
            <a href="<?= $file ?>" target="_blank"><?= basename($file) ?></a>
            <form method="post" style="display:inline;">
                <input type="hidden" name="delete" value="<?= $file ?>">
                <button type="submit" onclick="return confirm('Delete?')">Delete</button>
            </form>
        </li>
    <?php endforeach; ?>
</ul>

<?php
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['delete'])) {
    unlink($_POST['delete']);
    header("Location: 102-file_manager.php");
    exit();
}
?>
</body>
</html>

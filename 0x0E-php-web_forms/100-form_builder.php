<?php
$fields = $_POST['fields'] ?? [];

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['build'])) {
    $fields = array_filter(explode("\n", $_POST['raw_fields']));
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Dynamic Form Builder</title>
</head>
<body>

<h2>Dynamic Form Builder</h2>

<form method="post">
    <label>Enter field names (one per line):<br>
    <textarea name="raw_fields" rows="5"><?= htmlspecialchars($_POST['raw_fields'] ?? '') ?></textarea></label><br>
    <button type="submit" name="build">Build Form</button>
</form>

<?php if (!empty($fields)): ?>
    <h3>Generated Form</h3>
    <form method="post">
        <?php foreach ($fields as $field): ?>
            <label><?= ucfirst($field) ?>:<br>
            <input type="text" name="<?= strtolower(str_replace(' ', '_', $field)) ?>"></label><br><br>
        <?php endforeach; ?>
        <button type="submit">Submit</button>
    </form>
<?php endif; ?>

</body>
</html>

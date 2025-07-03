<?php
$results = [];

if (isset($_GET['query']) && !empty($_GET['query'])) {
    $query = strtolower(trim($_GET['query']));
    $sampleData = ['apple', 'banana', 'cherry', 'date', 'elderberry', 'fig'];

    foreach ($sampleData as $item) {
        if (strpos(strtolower($item), $query) !== false) {
            $results[] = $item;
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Search Form</title>
</head>
<body>

<h2>Search</h2>

<form method="get">
    <input type="text" name="query" placeholder="Search..." value="<?= htmlspecialchars($_GET['query'] ?? '') ?>">
    <button type="submit">Search</button>
</form>

<?php if (!empty($results)): ?>
    <h3>Results:</h3>
    <ul>
        <?php foreach ($results as $result): ?>
            <li><?= $result ?></li>
        <?php endforeach; ?>
    </ul>
<?php elseif (isset($_GET['query'])): ?>
    <p>No results found.</p>
<?php endif; ?>

</body>
</html>

<?php
session_start();
$_SESSION['wizard_data'] = $_SESSION['wizard_data'] ?? [];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    foreach ($_POST as $key => $value) {
        if ($key != 'step') {
            $_SESSION['wizard_data'][$key] = htmlspecialchars($value);
        }
    }

    $step = $_POST['step'];

    if ($step == 'personal') {
        header("Location: ?step=address");
    } elseif ($step == 'address') {
        header("Location: ?step=confirmation");
    }
    exit();
}

$step = $_GET['step'] ?? 'personal';
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Form Wizard</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap @5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="container mt-5">

<h2>Form Wizard</h2>

<ul class="nav nav-tabs mb-4">
    <li class="nav-item"><a class="nav-link <?= $step === 'personal' ? 'active' : '' ?>">Step 1</a></li>
    <li class="nav-item"><a class="nav-link <?= $step === 'address' ? 'active' : '' ?>">Step 2</a></li>
    <li class="nav-item"><a class="nav-link <?= $step === 'confirmation' ? 'active' : '' ?>">Step 3</a></li>
</ul>

<?php if ($step === 'personal'): ?>
<form method="post">
    <input type="hidden" name="step" value="personal">
    <div class="mb-3">
        <label class="form-label">Name</label>
        <input class="form-control" name="name" value="<?= $_SESSION['wizard_data']['name'] ?? '' ?>">
    </div>
    <button type="submit" class="btn btn-primary">Next</button>
</form>

<?php elseif ($step === 'address'): ?>
<form method="post">
    <input type="hidden" name="step" value="address">
    <div class="mb-3">
        <label class="form-label">Street</label>
        <input class="form-control" name="street" value="<?= $_SESSION['wizard_data']['street'] ?? '' ?>">
    </div>
    <div class="mb-3">
        <label class="form-label">City</label>
        <input class="form-control" name="city" value="<?= $_SESSION['wizard_data']['city'] ?? '' ?>">
    </div>
    <button type="submit" class="btn btn-primary">Next</button>
    <a href="?step=personal" class="btn btn-secondary">Back</a>
</form>

<?php elseif ($step === 'confirmation'): ?>
<h3>Summary</h3>
<p><strong>Name:</strong> <?= $_SESSION['wizard_data']['name'] ?></p>
<p><strong>Street:</strong> <?= $_SESSION['wizard_data']['street'] ?></p>
<p><strong>City:</strong> <?= $_SESSION['wizard_data']['city'] ?></p>
<a href="?" class="btn btn-success">Finish</a>
<?php endif; ?>

</body>
</html>

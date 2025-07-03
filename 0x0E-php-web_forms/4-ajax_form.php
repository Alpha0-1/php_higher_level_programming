[O<?php
// Handle AJAX request
if ($_SERVER['REQUEST_METHOD'] === 'POST' && !empty($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest') {
    $name = htmlspecialchars(trim($_POST['name']));
    $email = filter_input(INPUT_POST, 'email', FILTER_VALIDATE_EMAIL);
    $errors = [];

    if (empty($name)) {
        $errors[] = "Name is required.";
    }
    if (!$email) {
        $errors[] = "Valid email is required.";
    }

    if (!empty($errors)) {
        echo json_encode(['success' => false, 'errors' => $errors]);
    } else {
        // Simulate success
        echo json_encode(['success' => true, 'message' => "Form submitted successfully!"]);
    }
    exit();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>AJAX Form</title>
    <script>
        document.addEventListener("DOMContentLoaded", function () {
            const form = document.getElementById('ajax-form');
            const output = document.getElementById('output');

            form.addEventListener('submit', function (e) {
                e.preventDefault();

                const formData = new FormData(form);

                fetch('', {
                    method: 'POST',
                    body: formData
                })
                .then(response => response.json())
                .then(data => {
                    output.innerHTML = '';
                    if (!data.success) {
                        data.errors.forEach(err => {
                            const p = document.createElement('p');
                            p.style.color = 'red';
                            p.textContent = err;
                            output.appendChild(p);
                        });
                    } else {
                        const p = document.createElement('p');
                        p.style.color = 'green';
                        p.textContent = data.message;
                        output.appendChild(p);
                        form.reset();
                    }
                })
                .catch(error => {
                    console.error('Error:', error);
                });
            });
        });
    </script>
</head>
<body>

<h2>AJAX Form Processing</h2>

<form id="ajax-form" method="post">
    <label>Name:<br><input type="text" name="name"></label><br>
    <label>Email:<br><input type="email" name="email"></label><br>
    <button type="submit">Submit</button>
</form>

<div id="output"></div>

</body>
</html>


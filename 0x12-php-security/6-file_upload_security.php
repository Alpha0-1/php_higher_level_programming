<?php
/**
 * Secure file upload handling
 */

// Configuration
$uploadDir = __DIR__ . '/uploads/';
$allowedTypes = ['image/jpeg', 'image/png', 'application/pdf'];
$maxFileSize = 2 * 1024 * 1024; // 2MB

function handleFileUpload($file) {
    global $uploadDir, $allowedTypes, $maxFileSize;
    
    // Check for errors
    if ($file['error'] !== UPLOAD_ERR_OK) {
        throw new RuntimeException("Upload error: " . $file['error']);
    }
    
    // Check file size
    if ($file['size'] > $maxFileSize) {
        throw new RuntimeException("File too large. Maximum size: " . ($maxFileSize / 1024 / 1024) . "MB");
    }
    
    // Verify file type
    $finfo = new finfo(FILEINFO_MIME_TYPE);
    $mime = $finfo->file($file['tmp_name']);
    if (!in_array($mime, $allowedTypes)) {
        throw new RuntimeException("Invalid file type. Allowed types: " . implode(', ', $allowedTypes));
    }
    
    // Generate a safe filename
    $extension = pathinfo($file['name'], PATHINFO_EXTENSION);
    $basename = bin2hex(random_bytes(8)); // Random name
    $filename = sprintf('%s.%s', $basename, $extension);
    
    // Move the file to upload directory
    if (!move_uploaded_file($file['tmp_name'], $uploadDir . $filename)) {
        throw new RuntimeException("Failed to move uploaded file");
    }
    
    return $filename;
}

// Example usage
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_FILES['file'])) {
    try {
        // Create upload directory if it doesn't exist
        if (!is_dir($uploadDir)) {
            mkdir($uploadDir, 0755, true);
        }
        
        $filename = handleFileUpload($_FILES['file']);
        echo "File uploaded successfully: " . htmlspecialchars($filename);
    } catch (RuntimeException $e) {
        echo "Error: " . $e->getMessage();
    }
}
?>

<!-- Example upload form -->
<form method="post" enctype="multipart/form-data">
    <input type="file" name="file" required>
    <button type="submit">Upload</button>
</form>

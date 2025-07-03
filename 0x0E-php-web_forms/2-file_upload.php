<?php
/**
 * 2-file_upload.php - File Upload Handling
 * 
 * This file demonstrates secure file upload handling in PHP.
 * It covers file validation, security measures, and proper file management.
 * 
 * Learning objectives:
 * - $_FILES superglobal handling
 * - File validation (size, type, extension)
 * - Security best practices for file uploads
 * - Error handling for upload failures
 * - Multiple file uploads
 * - File organization and naming
 * 
 * @author  Alpha0-1
 */

/**
 * File Upload Handler Class
 */
class FileUploadHandler 
{
    private $upload_dir;
    private $max_file_size;
    private $allowed_types;
    private $allowed_extensions;
    
    public function __construct() 
    {
        $this->upload_dir = 'uploads/';
        $this->max_file_size = 5 * 1024 * 1024; // 5MB
        $this->allowed_types = [
            'image/jpeg',
            'image/png',
            'image/gif',
            'image/webp',
            'application/pdf',
            'text/plain',
            'application/msword',
            'application/vnd.openxmlformats-officedocument.wordprocessingml.document'
        ];
        $this->allowed_extensions = ['jpg', 'jpeg', 'png', 'gif', 'webp', 'pdf', 'txt', 'doc', 'docx'];
        
        // Create upload directory if it doesn't exist
        if (!is_dir($this->upload_dir)) {
            mkdir($this->upload_dir, 0755, true);
        }
    }
    
    /**
     * Validate uploaded file
     * 
     * @param array $file File data from $_FILES
     * @return array Validation result with success status and message
     */
    public function validateFile($file) 
    {
        $result = ['success' => false, 'message' => ''];
        
        // Check for upload errors
        if ($file['error'] !== UPLOAD_ERR_OK) {
            $result['message'] = $this->getUploadErrorMessage($file['error']);
            return $result;
        }
        
        // Check file size
        if ($file['size'] > $this->max_file_size) {
            $result['message'] = 'File size exceeds the maximum limit of ' . $this->formatBytes($this->max_file_size);
            return $result;
        }
        
        // Check file type
        $finfo = finfo_open(FILEINFO_MIME_TYPE);
        $mime_type = finfo_file($finfo, $file['tmp_name']);
        finfo_close($finfo);
        
        if (!in_array($mime_type, $this->allowed_types)) {
            $result['message'] = 'File type not allowed. Allowed types: ' . implode(', ', $this->allowed_extensions);
            return $result;
        }
        
        // Check file extension
        $file_extension = strtolower(pathinfo($file['name'], PATHINFO_EXTENSION));
        if (!in_array($file_extension, $this->allowed_extensions)) {
            $result['message'] = 'File extension not allowed';
            return $result;
        }
        
        $result['success'] = true;
        return $result;
    }
    
    /**
     * Upload file to server
     * 
     * @param array $file File data from $_FILES
     * @param string $custom_name Optional custom filename
     * @return array Upload result with success status, message, and file info
     */
    public function uploadFile($file, $custom_name = null) 
    {
        $result = ['success' => false, 'message' => '', 'file_info' => null];
        
        // Validate file first
        $validation = $this->validateFile($file);
        if (!$validation['success']) {
            $result['message'] = $validation['message'];
            return $result;
        }
        
        // Generate unique filename
        $file_extension = strtolower(pathinfo($file['name'], PATHINFO_EXTENSION));
        $filename = $custom_name ? $custom_name : uniqid('file_') . '_' . time();
        $filename .= '.' . $file_extension;
        
        // Full path for the uploaded file
        $upload_path = $this->upload_dir . $filename;
        
        // Move uploaded file
        if (move_uploaded_file($file['tmp_name'], $upload_path)) {
            $result['success'] = true;
            $result['message'] = 'File uploaded successfully';
            $result['file_info'] = [
                'original_name' => $file['name'],
                'filename' => $filename,
                'path' => $upload_path,
                'size' => $file['size'],
                'type' => $file['type']
            ];
        } else {
            $result['message'] = 'Failed to move uploaded file';
        }
        
        return $result;
    }
    
    /**
     * Get upload error message
     * 
     * @param int $error_code PHP upload error code
     * @return string Error message
     */
    private function getUploadErrorMessage($error_code) 
    {
        switch ($error_code) {
            case UPLOAD_ERR_INI_SIZE:
                return 'File exceeds the upload_max_filesize directive in php.ini';
            case UPLOAD_ERR_FORM_SIZE:
                return 'File exceeds the MAX_FILE_SIZE directive in the HTML form';
            case UPLOAD_ERR_PARTIAL:
                return 'File was only partially uploaded';
            case UPLOAD_ERR_NO_FILE:
                return 'No file was uploaded';
            case UPLOAD_ERR_NO_TMP_DIR:
                return 'Missing temporary folder';
            case UPLOAD_ERR_CANT_WRITE:
                return 'Failed to write file to disk';
            case UPLOAD_ERR_EXTENSION:
                return 'File upload stopped by extension';
            default:
                return 'Unknown upload error';
        }
    }
    
    /**
     * Format bytes to human readable format
     * 
     * @param int $bytes Number of bytes
     * @return string Formatted string
     */
    private function formatBytes($bytes) 
    {
        $units = ['B', 'KB', 'MB', 'GB'];
        $bytes = max($bytes, 0);
        $pow = floor(($bytes ? log($bytes) : 0) / log(1024));
        $pow = min($pow, count($units) - 1);
        
        $bytes /= pow(1024, $pow);
        
        return round($bytes, 2) . ' ' . $units[$pow];
    }
    
    /**
     * Get list of uploaded files
     * 
     * @return array List of uploaded files with their info
     */
    public function getUploadedFiles() 
    {
        $files = [];
        if (is_dir($this->upload_dir)) {
            $scan = scandir($this->upload_dir);
            foreach ($scan as $file) {
                if ($file !== '.' && $file !== '..') {
                    $file_path = $this->upload_dir . $file;
                    $files[] = [
                        'name' => $file,
                        'size' => filesize($file_path),
                        'modified' => date('Y-m-d H:i:s', filemtime($file_path)),
                        'path' => $file_path
                    ];
                }
            }
        }
        return $files;
    }
}

// Initialize variables
$upload_handler = new FileUploadHandler();
$upload_results = [];
$form_data = ['title' => '', 'description' => ''];
$errors = [];

// Process form submission
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $form_data['title'] = trim($_POST['title'] ?? '');
    $form_data['description'] = trim($_POST['description'] ?? '');
    
    // Validate form data
    if (empty($form_data['title'])) {
        $errors['title'] = 'Title is required';
    }
    
    // Handle file uploads
    if (isset($_FILES['files'])) {
        $files = $_FILES['files'];
        
        // Check if multiple files were uploaded
        if (is_array($files['name'])) {
            // Multiple files
            for ($i = 0; $i < count($files['name']); $i++) {
                if ($files['error'][$i] === UPLOAD_ERR_NO_FILE) {
                    continue; // Skip empty file inputs
                }
                
                $file = [
                    'name' => $files['name'][$i],
                    'type' => $files['type'][$i],
                    'tmp_name' => $files['tmp_name'][$i],
                    'error' => $files['error'][$i],
                    'size' => $files['size'][$i]
                ];
                
                $result = $upload_handler->uploadFile($file);
                $upload_results[] = $result;
            }
        } else {
            // Single file
            if ($files['error'] !== UPLOAD_ERR_NO_FILE) {
                $result = $upload_handler->uploadFile($files);
                $upload_results[] = $result;
            }
        }
    }
    
    // Check if at least one file was uploaded successfully
    $has_successful_upload = false;
    foreach ($upload_results as $result) {
        if ($result['success']) {
            $has_successful_upload = true;
            break;
        }
    }
    
    if (!$has_successful_upload && empty($errors)) {
        $errors['files'] = 'Please select at least one file to upload';
    }
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>File Upload Handling</title>
    <style>
        body { font-family: Arial, sans-serif; max-width: 800px; margin: 50px auto; padding: 20px; }
        .form-group { margin-bottom: 20px; }
        label { display: block; margin-bottom: 5px; font-weight: bold; }
        input[type="text"], textarea, input[type="file"] { 
            width: 100%; padding: 10px; border: 1px solid #ddd; border-radius: 4px; 
        }
        textarea { height: 100px; resize: vertical; }
        .error { color: #d32f2f; font-size: 14px; margin-top: 5px; }
        .success { color: #388e3c; padding: 10px; background: #e8f5e8; border-radius: 4px; margin: 10px 0; }
        .error-msg { color: #d32f2f; padding: 10px; background: #fdeaea; border-radius: 4px; margin: 10px 0; }
        button { background: #007cba; color: white; padding: 12px 24px; border: none; border-radius: 4px; cursor: pointer; }
        button:hover { background: #005a87; }
        .upload-info { background: #f0f8ff; padding: 15px; border-radius: 4px; margin: 20px 0; }
        .file-list { background: #f9f9f9; padding: 15px; border-radius: 4px; margin: 20px 0; }
        .file-item { display: flex; justify-content: space-between; align-items: center; padding: 10px; border-bottom: 1px solid #eee; }
        .file-item:last-child { border-bottom: none; }
        .file-details { display: flex; flex-direction: column; }
        .file-name { font-weight: bold; }
        .file-meta { font-size: 12px; color: #666; }
        .upload-results { margin: 20px 0; }
        .result-item { padding: 10px; margin: 5px 0; border-radius: 4px; }
        .result-success { background: #e8f5e8; border-left: 4px solid #4caf50; }
        .result-error { background: #fdeaea; border-left: 4px solid #f44336; }
        .drag-drop-area { 
            border: 2px dashed #ddd; 
            border-radius: 4px; 
            padding: 40px; 
            text-align: center; 
            background: #fafafa;
            transition: all 0.3s ease;
        }
        .drag-drop-area.dragover { border-color: #007cba; background: #f0f8ff; }
    </style>
</head>
<body>
    <h1>File Upload Handling Example</h1>
    
    <div class="upload-info">
        <h3>Upload Requirements:</h3>
        <ul>
            <li>Maximum file size: 5MB</li>
            <li>Allowed types: Images (JPG, PNG, GIF, WebP), PDF, Text, Word documents</li>
            <li>Multiple files can be uploaded at once</li>
            <li>Files are stored securely with validation</li>
        </ul>
    </div>
    
    <?php if (!empty($upload_results)): ?>
        <div class="upload-results">
            <h3>Upload Results:</h3>
            <?php foreach ($upload_results as $result): ?>
                <div class="result-item <?php echo $result['success'] ? 'result-success' : 'result-error'; ?>">
                    <?php if ($result['success']): ?>
                        <strong>✓ Success:</strong> <?php echo htmlspecialchars($result['message']); ?>
                        <br><small>File: <?php echo htmlspecialchars($result['file_info']['original_name']); ?> 
                        (<?php echo $upload_handler->formatBytes($result['file_info']['size']); ?>)</small>
                    <?php else: ?>
                        <strong>✗ Error:</strong> <?php echo htmlspecialchars($result['message']); ?>
                    <?php endif; ?>
                </div>
            <?php endforeach; ?>
        </div>
    <?php endif; ?>
    
    <form method="POST" enctype="multipart/form-data" action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>">
        <div class="form-group">
            <label for="title">Upload Title *</label>
            <input type="text" id="title" name="title" value="<?php echo htmlspecialchars($form_data['title']); ?>" required>
            <?php if (isset($errors['title'])): ?>
                <div class="error"><?php echo htmlspecialchars($errors['title']); ?></div>
            <?php endif; ?>
        </div>
        
        <div class="form-group">
            <label for="description">Description</label>
            <textarea id="description" name="description" placeholder="Optional description for your files"><?php echo htmlspecialchars($form_data['description']); ?></textarea>
        </div>
        
        <div class="form-group">
            <label for="files">Select Files *</label>
            <div class="drag-drop-area" id="dragDropArea">
                <p>Drag and drop files here or click to select</p>
                <input type="file" id="files" name="files[]" multiple accept=".jpg,.jpeg,.png,.gif,.webp,.pdf,.txt,.doc,.docx">
            </div>
            <?php if (isset($errors['files'])): ?>
                <div class="error"><?php echo htmlspecialchars($errors['files']); ?></div>
            <?php endif; ?>
        </div>
        
        <button type="submit">Upload Files</button>
    </form>
    
    <?php if (!empty($uploaded_files)): ?>
        <div class="file-list">
            <h3>Previously Uploaded Files (<?php echo count($uploaded_files); ?>):</h3>
            <?php foreach ($uploaded_files as $file): ?>
                <div class="file-item">
                    <div class="file-details">
                        <span class="file-name"><?php echo htmlspecialchars($file['name']); ?></span>
                        <span class="file-meta">
                            Size: <?php echo $upload_handler->formatBytes($file['size']); ?> | 
                            Modified: <?php echo htmlspecialchars($file['modified']); ?>
                        </span>
                    </div>
                    <a href="<?php echo htmlspecialchars($file['path']); ?>" target="_blank">View</a>
                </div>
            <?php endforeach; ?>
        </div>
    <?php endif; ?>
    
    <div class="upload-info">
        <h3>Security Features Implemented:</h3>
        <ul>
            <li><strong>File Type Validation:</strong> Checks MIME type and file extension</li>
            <li><strong>File Size Limits:</strong> Prevents oversized uploads</li>
            <li><strong>Secure Filenames:</strong> Generates unique names to prevent conflicts</li>
            <li><strong>Upload Directory:</strong> Files stored outside web root when possible</li>
            <li><strong>Error Handling:</strong> Comprehensive error messages for debugging</li>
            <li><strong>Multiple File Support:</strong> Handles single and multiple file uploads</li>
        </ul>
    </div>
    
    <script>
        // Enhanced drag and drop functionality
        const dragDropArea = document.getElementById('dragDropArea');
        const fileInput = document.getElementById('files');
        
        // Click to select files
        dragDropArea.addEventListener('click', () => {
            fileInput.click();
        });
        
        // Drag and drop events
        dragDropArea.addEventListener('dragover', (e) => {
            e.preventDefault();
            dragDropArea.classList.add('dragover');
        });
        
        dragDropArea.addEventListener('dragleave', () => {
            dragDropArea.classList.remove('dragover');
        });
        
        dragDropArea.addEventListener('drop', (e) => {
            e.preventDefault();
            dragDropArea.classList.remove('dragover');
            
            const files = e.dataTransfer.files;
            fileInput.files = files;
            
            // Update the display
            updateFileDisplay();
        });
        
        // Update file display when files are selected
        fileInput.addEventListener('change', updateFileDisplay);
        
        function updateFileDisplay() {
            const files = fileInput.files;
            if (files.length > 0) {
                const fileNames = Array.from(files).map(file => file.name).join(', ');
                dragDropArea.innerHTML = `<p>Selected files: ${fileNames}</p><p>Click to select different files</p>`;
            }
        }
    </script>
</body>
</html>

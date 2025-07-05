<?php
/**
 * Data Compression in PHP
 * 
 * Techniques for compressing data to reduce storage and bandwidth usage.
 */

class DataCompressor
{
    /**
     * 1. Gzip Compression
     */
    public static function compressString(string $data): string
    {
        if (empty($data)) {
            return '';
        }
        
        $compressed = gzencode($data, 9); // Maximum compression level
        if ($compressed === false) {
            throw new RuntimeException('Gzip compression failed');
        }
        
        return $compressed;
    }
    
    public static function decompressString(string $compressed): string
    {
        if (empty($compressed)) {
            return '';
        }
        
        $data = gzdecode($compressed);
        if ($data === false) {
            throw new RuntimeException('Gzip decompression failed');
        }
        
        return $data;
    }
    
    /**
     * 2. Output Compression
     */
    public static function enableOutputCompression(): void
    {
        if (extension_loaded('zlib') && !ini_get('zlib.output_compression')) {
            ini_set('zlib.output_compression', 'On');
        }
    }
    
    /**
     * 3. Database Compression
     */
    public static function compressForDatabase(string $data): string
    {
        // For text data in databases
        $compressed = gzcompress($data, 9);
        if ($compressed === false) {
            throw new RuntimeException('Compression failed');
        }
        return base64_encode($compressed);
    }
    
    public static function decompressFromDatabase(string $compressed): string
    {
        $decoded = base64_decode($compressed);
        if ($decoded === false) {
            throw new RuntimeException('Base64 decode failed');
        }
        
        $data = gzuncompress($decoded);
        if ($data === false) {
            throw new RuntimeException('Decompression failed');
        }
        
        return $data;
    }
    
    /**
     * 4. Image Compression
     */
    public static function compressImage(string $sourcePath, string $destPath, int $quality = 75): bool
    {
        $info = getimagesize($sourcePath);
        if ($info === false) {
            return false;
        }
        
        switch ($info[2]) {
            case IMAGETYPE_JPEG:
                $image = imagecreatefromjpeg($sourcePath);
                imagejpeg($image, $destPath, $quality);
                break;
            case IMAGETYPE_PNG:
                $image = imagecreatefrompng($sourcePath);
                imagepng($image, $destPath, round(9 * $quality / 100));
                break;
            case IMAGETYPE_WEBP:
                $image = imagecreatefromwebp($sourcePath);
                imagewebp($image, $destPath, $quality);
                break;
            default:
                return false;
        }
        
        imagedestroy($image);
        return true;
    }
}

// Usage examples:
$originalText = str_repeat("Lorem ipsum dolor sit amet, ", 100);
$compressed = DataCompressor::compressString($originalText);
echo "Original: " . strlen($originalText) . " bytes\n";
echo "Compressed: " . strlen($compressed) . " bytes\n";
echo "Saved: " . round((1 - strlen($compressed)/strlen($originalText)) * 100) . "%\n";

// Enable for all script output
DataCompressor::enableOutputCompression();

/**
 * Key Takeaways:
 * 1. Compression reduces bandwidth and storage needs
 * 2. Different compression methods for different data types
 * 3. Balance between compression ratio and CPU usage
 */
?>

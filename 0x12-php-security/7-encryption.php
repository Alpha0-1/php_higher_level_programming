<?php
/**
 * Data encryption in PHP using OpenSSL
 */

class SecureEncryption {
    private $encryptionKey;
    private $cipher = 'aes-256-gcm'; // Modern authenticated encryption
    
    public function __construct($keyPath = null) {
        if ($keyPath && file_exists($keyPath)) {
            $this->encryptionKey = file_get_contents($keyPath);
        } else {
            // Generate a new key if none exists
            $this->encryptionKey = random_bytes(32); // 256-bit key
            if ($keyPath) {
                file_put_contents($keyPath, $this->encryptionKey);
                chmod($keyPath, 0600); // Restrict file permissions
            }
        }
        
        if (strlen($this->encryptionKey) !== 32) {
            throw new RuntimeException("Encryption key must be 32 bytes (256 bits)");
        }
    }
    
    public function encrypt($plaintext) {
        $iv = random_bytes(openssl_cipher_iv_length($this->cipher));
        $ciphertext = openssl_encrypt(
            $plaintext,
            $this->cipher,
            $this->encryptionKey,
            OPENSSL_RAW_DATA,
            $iv,
            $tag
        );
        
        if ($ciphertext === false) {
            throw new RuntimeException("Encryption failed: " . openssl_error_string());
        }
        
        // Return IV + tag + ciphertext (all needed for decryption)
        return base64_encode($iv . $tag . $ciphertext);
    }
    
    public function decrypt($encrypted) {
        $data = base64_decode($encrypted);
        $ivLength = openssl_cipher_iv_length($this->cipher);
        $iv = substr($data, 0, $ivLength);
        $tag = substr($data, $ivLength, 16); // GCM tag is 16 bytes
        $ciphertext = substr($data, $ivLength + 16);
        
        $plaintext = openssl_decrypt(
            $ciphertext,
            $this->cipher,
            $this->encryptionKey,
            OPENSSL_RAW_DATA,
            $iv,
            $tag
        );
        
        if ($plaintext === false) {
            throw new RuntimeException("Decryption failed: " . openssl_error_string());
        }
        
        return $plaintext;
    }
}

// Example usage
try {
    // In production, store the key in a secure location outside web root
    $encryptor = new SecureEncryption(__DIR__ . '/encryption_key.key');
    
    $secretMessage = "This is a very secret message!";
    $encrypted = $encryptor->encrypt($secretMessage);
    $decrypted = $encryptor->decrypt($encrypted);
    
    echo "Original: $secretMessage<br>";
    echo "Encrypted: " . htmlspecialchars($encrypted) . "<br>";
    echo "Decrypted: $decrypted<br>";
} catch (RuntimeException $e) {
    echo "Error: " . $e->getMessage();
}

// Important notes:
// - Always use authenticated encryption (GCM mode)
// - Never use ECB mode or unauthenticated modes like CBC without HMAC
// - Store the encryption key securely (not in the code or database)
// - Rotate keys periodically
?>

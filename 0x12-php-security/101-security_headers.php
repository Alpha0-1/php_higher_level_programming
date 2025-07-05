<?php
/**
 * Security headers configuration
 */

class SecurityHeaders {
    public static function setDefaultHeaders() {
        // Remove server signature
        header_remove('X-Powered-By');
        
        // Content Security Policy (adjust based on your needs)
        $csp = [
            "default-src 'self'",
            "script-src 'self' 'unsafe-inline' https://cdn.example.com",
            "style-src 'self' 'unsafe-inline'",
            "img-src 'self' data: https://*.example.com",
            "font-src 'self' https://fonts.gstatic.com",
            "connect-src 'self' https://api.example.com",
            "frame-src 'none'",
            "object-src 'none'",
            "base-uri 'self'",
            "form-action 'self'",
            "frame-ancestors 'none'",
        ];
        header("Content-Security-Policy: " . implode('; ', $csp));
        
        // Other security headers
        header("X-Content-Type-Options: nosniff");
        header("X-Frame-Options: DENY");
        header("X-XSS-Protection: 1; mode=block");
        header("Referrer-Policy: strict-origin-when-cross-origin");
        header("Strict-Transport-Security: max-age=31536000; includeSubDomains; preload");
        
        // Feature Policy (now Permissions Policy)
        $permissionsPolicy = [
            "accelerometer 'none'",
            "ambient-light-sensor 'none'",
            "autoplay 'none'",
            "battery 'none'",
            "camera 'none'",
            "display-capture 'none'",
            "document-domain 'none'",
            "encrypted-media 'none'",
            "execution-while-not-rendered 'none'",
            "execution-while-out-of-viewport 'none'",
            "fullscreen 'none'",
            "geolocation 'none'",
            "gyroscope 'none'",
            "magnetometer 'none'",
            "microphone 'none'",
            "midi 'none'",
            "navigation-override 'none'",
            "payment 'none'",
            "picture-in-picture 'none'",
            "publickey-credentials-get 'none'",
            "screen-wake-lock 'none'",
            "sync-xhr 'none'",
            "usb 'none'",
            "web-share 'none'",
            "xr-spatial-tracking 'none'",
        ];
        header("Permissions-Policy: " . implode(', ', $permissionsPolicy));
    }
}

// Example usage
SecurityHeaders::setDefaultHeaders();

// Your application code here
echo "Security headers have been set!";

// To verify headers are working:
// 1. Use browser developer tools (Network tab)
// 2. Use online tools like securityheaders.com
// 3. Use curl: curl -I http://yourdomain.com

// Note: Adjust CSP and other policies based on your application's actual requirements
?>

<?php
/**
 * Cross-Site Scripting (XSS) prevention techniques
 */

// 1. Basic output escaping
function escapeOutput($data) {
    return htmlspecialchars($data, ENT_QUOTES | ENT_HTML5, 'UTF-8');
}

// 2. Context-specific escaping
function escapeHtmlAttribute($data) {
    return htmlspecialchars($data, ENT_QUOTES, 'UTF-8');
}

function escapeJavaScript($data) {
    return json_encode($data, JSON_HEX_TAG | JSON_HEX_APOS | JSON_HEX_QUOT | JSON_HEX_AMP);
}

// Example usage with user input
$userInput = '<script>alert("XSS Attack!");</script>';

// Display in HTML
echo "<div>" . escapeOutput($userInput) . "</div>";

// Use in HTML attribute
echo '<input type="text" value="' . escapeHtmlAttribute($userInput) . '">';

// Use in JavaScript
echo '<script>var userInput = ' . escapeJavaScript($userInput) . ';</script>';

// For HTML content that needs to allow some tags (use a library like HTML Purifier)
function sanitizeRichText($html) {
    require_once 'HTMLPurifier.auto.php';
    $config = HTMLPurifier_Config::createDefault();
    $purifier = new HTMLPurifier($config);
    return $purifier->purify($html);
}

// Example with rich text
$richText = '<b>Bold text</b><script>alert("XSS");</script>';
echo sanitizeRichText($richText); // Will only output <b>Bold text</b>
?>

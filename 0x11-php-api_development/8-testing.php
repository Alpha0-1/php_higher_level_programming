<?php
/**
 * 8-testing.php
 *
 * Demonstrates a simple test script for an API endpoint.
 */

function testEndpoint($url, $expectedCode) {
    $ch = curl_init($url);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    $response = curl_exec($ch);
    $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
    curl_close($ch);

    if ($httpCode == $expectedCode) {
        echo "[PASS] $url returned $httpCode\n";
    } else {
        echo "[FAIL] $url expected $expectedCode got $httpCode\n";
    }
}

testEndpoint("http://localhost:8000/0-simple_api.php", 200);
testEndpoint("http://localhost:8000/4-rate_limiting.php", 200);
?>
/** 
 * Usage : 
 * Run from command line: php 8-testing.php
 */

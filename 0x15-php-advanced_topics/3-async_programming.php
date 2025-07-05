<?php
/**
 * Demonstrates Asynchronous Programming techniques in PHP
 */

/**
 * Using cURL for parallel requests
 */
function fetchMultipleUrls(array $urls): array
{
    $multiHandle = curl_multi_init();
    $handles = [];
    $results = [];

    foreach ($urls as $url) {
        $handle = curl_init($url);
        curl_setopt($handle, CURLOPT_RETURNTRANSFER, true);
        curl_multi_add_handle($multiHandle, $handle);
        $handles[$url] = $handle;
    }

    $running = null;
    do {
        curl_multi_exec($multiHandle, $running);
        curl_multi_select($multiHandle);
    } while ($running > 0);

    foreach ($handles as $url => $handle) {
        $results[$url] = curl_multi_getcontent($handle);
        curl_multi_remove_handle($multiHandle, $handle);
        curl_close($handle);
    }

    curl_multi_close($multiHandle);
    return $results;
}

// Usage
$urls = [
    'https://jsonplaceholder.typicode.com/posts/1',
    'https://jsonplaceholder.typicode.com/comments/1',
    'https://jsonplaceholder.typicode.com/albums/1'
];

$results = fetchMultipleUrls($urls);
foreach ($results as $url => $content) {
    echo "Fetched from $url: " . substr($content, 0, 50) . "...\n";
}

/**
 * Using Amp for async programming (example)
 * 
 * Note: Requires amphp/amp package
 * 
 * composer require amphp/amp
 */
// 
// use Amp\Loop;
// use function Amp\asyncCall;
// use function Amp\delay;
// 
// asyncCall(function() {
//     echo "Starting async operation 1...\n";
//     yield delay(1000); // non-blocking delay
//     echo "Async operation 1 completed\n";
// });
// 
// asyncCall(function() {
//     echo "Starting async operation 2...\n";
//     yield delay(500);
//     echo "Async operation 2 completed\n";
// });
// 
// Loop::run();

/**
 * Using ReactPHP (example)
 * 
 * Note: Requires react/event-loop and react/http
 * 
 * composer require react/event-loop react/http
 */
// 
// use React\EventLoop\Factory;
// use React\Http\Browser;
// 
// $loop = Factory::create();
// $browser = new Browser($loop);
// 
// $browser->get('https://example.com/')->then(
//     function (Psr\Http\Message\ResponseInterface $response) {
//         echo $response->getBody();
//     },
//     function (Exception $e) {
//         echo 'Error: ' . $e->getMessage() . PHP_EOL;
//     }
// );
// 
// $loop->run();

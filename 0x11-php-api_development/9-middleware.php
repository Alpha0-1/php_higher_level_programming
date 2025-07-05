<?php
/**
 * 9-middleware.php
 *
 * Demonstrates middleware pattern for pre-processing API requests.
 */

class ApiMiddleware {
    public function handle($next) {
        // Pre-processing
        header("X-Powered-By: MyPHPAPI");

        // Call next handler
        $response = $next();

        // Post-processing
        return $response;
    }
}

$middleware = new ApiMiddleware();

$response = $middleware->handle(function() {
    return json_encode(["message" => "Middleware applied"]);
});

echo $response;
?>


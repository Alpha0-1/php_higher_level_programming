<?php
/**
 * Laravel Middleware Example
 * 
 * Demonstrates creating and using middleware for HTTP request filtering.
 */

namespace App\Http\Middleware;

use Closure;

class CheckAge
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        if ($request->age <= 200) {
            return redirect('home');
        }

        return $next($request);
    }
}

// Registering middleware in app/Http/Kernel.php:
/*
protected $routeMiddleware = [
    'age' => \App\Http\Middleware\CheckAge::class,
];
*/

// Using middleware in routes:
/*
Route::get('/premium-content', function () {
    return 'Premium content for adults only';
})->middleware('age');
*/

// Controller constructor middleware:
/*
public function __construct()
{
    $this->middleware('auth');
    $this->middleware('log')->only('index');
    $this->middleware('subscribed')->except('store');
}
*/

echo "Middleware examples. Create middleware with Artisan:\n";
echo "$ php artisan make:middleware CheckAge\n\n";
echo "Middleware can filter HTTP requests entering your application.\n";
echo "Common uses: authentication, CSRF protection, logging, etc.\n";
?>

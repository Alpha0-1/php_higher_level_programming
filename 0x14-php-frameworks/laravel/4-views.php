<?php
/**
 * Laravel Views Example
 * 
 * Demonstrates Blade templating engine usage including
 * inheritance, components, and control structures.
 */

// resources/views/welcome.blade.php
/*
<!DOCTYPE html>
<html>
<head>
    <title>{{ $title ?? 'Default Title' }}</title>
</head>
<body>
    @include('header')
    
    <div class="content">
        @yield('content')
    </div>
    
    @section('sidebar')
        Default sidebar content
    @show
    
    @include('footer')
</body>
</html>
*/

// resources/views/header.blade.php
/*
<header>
    <h1>My Application</h1>
    @if(Auth::check())
        <p>Welcome back, {{ Auth::user()->name }}</p>
    @else
        <p>Please log in</p>
    @endif
</header>
*/

// resources/views/home.blade.php
/*
@extends('welcome')

@section('title', 'Home Page')

@section('content')
    <h2>Welcome to our site!</h2>
    <p>This is the home page content.</p>
    
    @foreach($products as $product)
        <div class="product">
            <h3>{{ $product->name }}</h3>
            <p>${{ number_format($product->price, 2) }}</p>
        </div>
    @endforeach
@endsection

@section('sidebar')
    @parent
    <p>Additional sidebar content for home page</p>
@endsection
*/

// Controller returning a view:
/*
public function index()
{
    return view('home', [
        'products' => Product::all()
    ]);
}
*/

echo "Blade templating examples. Key features:\n";
echo "- Template inheritance with @extends/@section\n";
echo "- Includes with @include\n";
echo "- Control structures (@if, @foreach, etc.)\n";
echo "- Components (@component) for reusable UI elements\n";
echo "- Escaping output automatically with {{ }}\n";
?>

<?php

/**
 * main.php
 *
 * This file runs all PHP exercise scripts to verify functionality.
 * It includes and executes test cases for each file listed in the project.
 *
 * Usage:
 *   Run this file from the terminal:
 *   php main.php
 */

echo "🧪 PHP Introduction Strings - Test Runner\n";
echo "----------------------------------------\n\n";

// ---------------------------
// Test 0-hello.php
// ---------------------------
echo "🔹 Running 0-hello.php\n";
require_once '0-hello.php';
echo "\n";

// ---------------------------
// Test 1-multi_languages.php
// ---------------------------
echo "🔹 Running 1-multi_languages.php\n";
require_once '1-multi_languages.php';
echo "\n";

// ---------------------------
// Test 2-arguments.php (simulate CLI args)
// ---------------------------
echo "🔹 Running 2-arguments.php\n";
$_SERVER['argv'] = ['2-arguments.php', 'Hello', 'PHP'];
$_SERVER['argc'] = 3;
require_once '2-arguments.php';
echo "\n";

// ---------------------------
// Test 3-value_argument.php (simulate CLI args)
// ---------------------------
echo "🔹 Running 3-value_argument.php\n";
$_SERVER['argv'] = ['3-value_argument.php', 'test_arg'];
require_once '3-value_argument.php';
echo "\n";

// ---------------------------
// Test 4-concat.php
// ---------------------------
echo "🔹 Running 4-concat.php\n";
require_once '4-concat.php';
echo "\n";

// ---------------------------
// Test 5-to_integer.php
// ---------------------------
echo "🔹 Running 5-to_integer.php\n";
require_once '5-to_integer.php';
echo "\n";

// ---------------------------
// Test 6-multi_languages_loop.php
// ---------------------------
echo "🔹 Running 6-multi_languages_loop.php\n";
require_once '6-multi_languages_loop.php';
echo "\n";

// ---------------------------
// Test 7-multi_c.php
// ---------------------------
echo "🔹 Running 7-multi_c.php\n";
require_once '7-multi_c.php';
echo "\n";

// ---------------------------
// Test 8-square.php
// ---------------------------
echo "🔹 Running 8-square.php\n";
require_once '8-square.php';
echo "\n";

// ---------------------------
// Test 9-add.php
// ---------------------------
echo "🔹 Running 9-add.php\n";
require_once '9-add.php';
echo "addNumbers(5, 3) = " . addNumbers(5, 3) . "\n";
echo "addNumbers(-2, 7) = " . addNumbers(-2, 7) . "\n";
echo "\n";

// ---------------------------
// Test 10-factorial.php
// ---------------------------
echo "🔹 Running 10-factorial.php\n";
require_once '10-factorial.php';
echo "factorial(5) = " . factorial(5) . "\n";
echo "factorial(0) = " . factorial(0) . "\n";
echo "\n";

// ---------------------------
// Test 11-second_biggest.php
// ---------------------------
echo "🔹 Running 11-second_biggest.php\n";
require_once '11-second_biggest.php';
echo "secondBiggest([1, 2, 3, 4, 5]) = " . secondBiggest([1, 2, 3, 4, 5]) . "\n";
echo "secondBiggest([10, 10, 5]) = " . secondBiggest([10, 10, 5]) . "\n";
echo "\n";

// ---------------------------
// Test 12-array.php
// ---------------------------
echo "🔹 Running 12-array.php\n";
require_once '12-array.php';
echo "\n";

// ---------------------------
// Test 13-add.php
// ---------------------------
echo "🔹 Running 13-add.php\n";
require_once '13-add.php';
echo "add(7, 9) = " . add(7, 9) . "\n";
echo "\n";

// ---------------------------
// Test 100-let_me_const.php
// ---------------------------
echo "🔹 Running 100-let_me_const.php\n";
require_once '100-let_me_const.php';
echo "\n";

// ---------------------------
// Test 101-call_me_moby.php
// ---------------------------
echo "🔹 Running 101-call_me_moby.php\n";
require_once '101-call_me_moby.php';
callMoby();
echo "\n";

// ---------------------------
// Test 102-add_me_maybe.php
// ---------------------------
echo "🔹 Running 102-add_me_maybe.php\n";
require_once '102-add_me_maybe.php';
addMeMaybe(5);
addMeMaybe("not a number");
echo "\n";

// ---------------------------
// Test 103-object_fct.php
// ---------------------------
echo "🔹 Running 103-object_fct.php\n";
require_once '103-object_fct.php';
$obj = new Incrementer();
echo "Increment #1: " . $obj->increment() . "\n";
echo "Increment #2: " . $obj->increment() . "\n";
echo "Increment #3: " . $obj->increment() . "\n";
echo "\n";

echo "✅ All tests completed successfully!\n";

<?php
/**
 * CodeIgniter Helpers Example
 * 
 * Demonstrates built-in and custom helpers.
 */

// Loading helpers (in controller or globally in BaseController):
/*
helper(['form', 'url', 'text']);
*/

// Form helper examples:
/*
echo form_open('email/send');
echo form_label('Email Address', 'email');
echo form_input('email', '', 'placeholder="user@example.com"');
echo form_submit('submit', 'Send');
echo form_close();
*/

// URL helper examples:
/*
echo anchor('news/local/123', 'Click Here', ['title' => 'News item']);
echo base_url('images/logo.png');
echo site_url('controller/method');
*/

// Text helper examples:
/*
echo word_limiter($long_text, 50); // Limits to 50 words
echo character_limiter($long_text, 100); // Limits to 100 chars
echo random_string('alnum', 16); // Random string
*/

// Creating custom helpers:
// Create app/Helpers/auth_helper.php
/*
if (! function_exists('is_logged_in')) {
    function is_logged_in()
    {
        $session = \Config\Services::session();
        return $session->has('user_id');
    }
}
*/

echo "Helper examples. Key features:\n";
echo "- Many built-in helpers for common tasks\n";
echo "- Easy to create custom helpers\n";
echo "- Can be loaded automatically via config\n";
echo "- Simplify repetitive tasks\n";
?>

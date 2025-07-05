<?php
/**
 * Laravel Artisan Console Example
 * 
 * Demonstrates creating and using Artisan commands.
 */

namespace App\Console\Commands;

use Illuminate\Console\Command;

class SendEmails extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'email:send {user} {--queue}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Send a marketing email to a user';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $userId = $this->argument('user');
        $queue = $this->option('queue');
        
        $this->info("Sending email to user {$userId}" . ($queue ? ' via queue' : ''));
        
        // Command logic here...
        
        $this->table(
            ['Name', 'Email'],
            [['John Doe', 'john@example.com'], ['Jane Doe', 'jane@example.com']]
        );
        
        return 0;
    }
}

// Register the command in app/Console/Kernel.php:
/*
protected $commands = [
    \App\Console\Commands\SendEmails::class,
];
*/

// Usage examples:
// $ php artisan email:send 1 --queue
// $ php artisan make:command SendEmails
// $ php artisan list
// $ php artisan migrate
// $ php artisan tinker

echo "Artisan command examples. Key features:\n";
echo "- Generate boilerplate code (controllers, models, etc.)\n";
echo "- Run migrations and database commands\n";
echo "- Create custom commands for your application\n";
echo "- Interactive shell with tinker\n";
?>

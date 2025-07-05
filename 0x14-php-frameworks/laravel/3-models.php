<?php
/**
 * Laravel Models Example
 * 
 * Demonstrates Eloquent model usage, relationships, and mass assignment.
 */

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class User extends Model
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'users';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['name', 'email', 'password'];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = ['password', 'remember_token'];

    /**
     * Get the posts for the user.
     */
    public function posts()
    {
        return $this->hasMany(Post::class);
    }
}

class Post extends Model
{
    protected $fillable = ['title', 'content', 'user_id'];

    /**
     * Get the user that owns the post.
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}

// Usage examples:
// $user = User::create(['name' => 'John', 'email' => 'john@example.com']);
// $post = $user->posts()->create(['title' => 'First Post', 'content' => 'Content here']);
// $posts = User::find(1)->posts;

echo "Model examples. Create models using Artisan:\n";
echo "$ php artisan make:model User\n";
echo "$ php artisan make:model Post -m (creates migration too)\n\n";
echo "Models provide an ActiveRecord implementation for working with your database.\n";
?>

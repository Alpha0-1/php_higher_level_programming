<?php
/**
 * Laravel Eloquent ORM Example
 * 
 * Demonstrates advanced Eloquent features including
 * query scopes, accessors/mutators, and events.
 */

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    // Query scopes
    public function scopePopular($query)
    {
        return $query->where('votes', '>', 100);
    }

    public function scopeActive($query)
    {
        return $query->where('active', 1);
    }

    // Accessor
    public function getPriceAttribute($value)
    {
        return '$' . number_format($value, 2);
    }

    // Mutator
    public function setNameAttribute($value)
    {
        $this->attributes['name'] = strtolower($value);
    }

    // Model events
    protected static function booted()
    {
        static::creating(function ($product) {
            $product->slug = str_slug($product->name);
        });
    }
}

// Usage examples:
// $popularProducts = Product::popular()->active()->get();
// $product = Product::find(1);
// echo $product->price; // Returns formatted price
// $product->name = 'New Product'; // Automatically converted to lowercase
// Product::create(['name' => 'Laptop', 'price' => 999]); // Auto-generates slug

echo "Eloquent ORM examples. Key features:\n";
echo "- Fluent query builder with scopes\n";
echo "- Attribute casting and accessors/mutators\n";
echo "- Model events and observers\n";
echo "- Soft deletes, relationships, eager loading\n";
?>

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;

    protected $fillable = ['photo', 'sku', 'description', 'size', 'stock'];

    public function stocks()
    {
        return $this->hasMany(Stock::class);
    }

    public function tags()
    {
        return $this->belongsToMany(Tag::class, 'products_tags');
    }
}

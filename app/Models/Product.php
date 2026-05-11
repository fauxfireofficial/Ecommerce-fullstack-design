<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;
    
    public static function getCategories()
    {
        return [
            'Mobile and Tablets',
            'Computer and tech',
            'Clothes and wear',
            'Home interiors',
            'Tools, equipments',
            'Health and Beauty',
            'Sports and outdoor',
            'Accessories',
            'Gift Boxes'
        ];
    }

    protected $fillable = [
        'name',
        'slug',
        'sku',
        'price',
        'compare_price',
        'stock_quantity',
        'category_id',
        'search_tags',
        'meta_title',
        'meta_description',
        'image',
        'images',
        'description',
        'features',
        'status',
        'is_recommended',
        'is_deal',
        'discount_percent',
        'views',
        'brand',
        'weight',
        'dimensions',
        'colors',
        'sizes',
        'materials',
    ];

    protected $casts = [
        'price' => 'decimal:2',
        'compare_price' => 'decimal:2',
        'stock_quantity' => 'integer',
        'views' => 'integer',
        'weight' => 'decimal:2',
        'colors' => 'array',
        'sizes' => 'array',
        'materials' => 'array',
    ];

    // Check if product is in stock
    public function inStock()
    {
        return $this->stock_quantity > 0;
    }

    // Get discount percentage
    public function getDiscountPercentageAttribute()
    {
        if ($this->compare_price && $this->compare_price > $this->price) {
            return round((($this->compare_price - $this->price) / $this->compare_price) * 100);
        }
        return 0;
    }

    // Relationship with orders
    public function orders()
    {
        return $this->belongsToMany(Order::class, 'order_items')
                    ->withPivot('quantity', 'price')
                    ->withTimestamps();
    }

    public function category()
    {
        return $this->belongsTo(Category::class);
    }
}

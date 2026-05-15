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
        'is_free_shipping',
        'shipping_fee_national',
        'shipping_fee_international',
        'discount_percent',
        'views',
        'sold_count',
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

    public function orderItems()
    {
        return $this->hasMany(OrderItem::class);
    }

    public function reviews()
    {
        return $this->hasMany(Review::class)->where('status', 'approved');
    }

    // Get average rating
    public function getAverageRatingAttribute()
    {
        return $this->reviews()->avg('rating') ?: 0;
    }

    // Check if user has already reviewed
    public function hasUserReviewed($userId)
    {
        return Review::where('product_id', $this->id)
                     ->where('user_id', $userId)
                     ->exists();
    }

    // Get star distribution
    public function getStarDistributionAttribute()
    {
        $distribution = [
            5 => 0,
            4 => 0,
            3 => 0,
            2 => 0,
            1 => 0,
        ];

        $counts = $this->reviews()
            ->select('rating', \DB::raw('count(*) as total'))
            ->groupBy('rating')
            ->pluck('total', 'rating')
            ->toArray();

        foreach ($counts as $rating => $count) {
            $distribution[$rating] = $count;
        }

        return $distribution;
    }

    public function category()
    {
        return $this->belongsTo(Category::class);
    }



    // Get total orders count
    public function getTotalOrdersAttribute()
    {
        return $this->orderItems()->sum('quantity');
    }
}

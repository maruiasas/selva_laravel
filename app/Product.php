<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;
use App\ProductCategory;
use App\Review;

class Product extends Model
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'member_id', 'name', 'product_content', 'product_category_id', 'product_subcategory_id', 'image_1', 'image_2', 'image_3', 'image_4',
    ];

    public function categories() {
        return $this->belongsTo(ProductCategory::class, 'product_category_id', 'id');
    }

    public function subcategories() {
        return $this->belongsTo(ProductSubcategory::class, 'product_subcategory_id', 'id');
    }

    public function reviews() {
        return $this->hasMany(Review::class);
    }
}
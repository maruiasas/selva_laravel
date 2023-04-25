<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;
use App\Product;

class ProductCategory extends Model
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'id', 'name',
    ];

        /**
     * カテゴリーの一覧を取得
     */
    public function getLists()
    {
        $categories = ProductCategory::orderBy('id','asc')->pluck('name', 'id');
    
        return $categories;
    }

    public function product() {
        return $this->hasMany(Product::class);
    }
}

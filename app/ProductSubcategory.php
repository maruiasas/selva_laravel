<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;
use App\Product;

class ProductSubcategory extends Model
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
        $subcategories = ProductSubcategory::orderBy('id','asc')->pluck('name', 'id');
    
        return $subcategories;
    }

    public function product() {
        return $this->hasMany(Product::class);
    }
}


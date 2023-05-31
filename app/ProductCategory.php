<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;
use App\Product;
use Kyslik\ColumnSortable\Sortable;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\ProductSubcategory;

class ProductCategory extends Model
{
    use Notifiable;
    use SoftDeletes;
    use Sortable;

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

    public function subcategories() {
        return $this->belongsTo(ProductSubcategory::class, 'id', 'product_category_id');
    }
}

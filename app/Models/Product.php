<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Cviebrock\EloquentSluggable\Sluggable;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Builder;

class Product extends Model
{
    use HasFactory, SoftDeletes, Sluggable;

    public function sluggable(): array
    {
        return [
            'slug' => [
                'source' => 'name'
            ]
        ];
    }
    protected $table = "products";
    protected $fillable = ['name','entesharat', 'price', 'image', 'description', 'brand_id', 'category_id', 'slug', 'tags', 'weight'];

    protected $casts = [
        'price' => 'integer',
        'weight' => 'integer',
    ];

    ///mutators convert to english number in database
    public function setPriceAttribute($value)
    {
        $converted = convertPersianToEnglish($value);
        $value = convertArabicToEnglish($converted);
        $this->attributes["price"] = $value;
    }
    public function setNumberAttribute($value)
    {
        $converted = convertPersianToEnglish($value);
        $value = convertArabicToEnglish($converted);
        $this->attributes["number"] = $value;
    }
    public function setWeightAttribute($value)
    {
        $converted = convertPersianToEnglish($value);
        $value = convertArabicToEnglish($converted);
        $this->attributes["weight"] = $value;
    }

    ////relations
    public function category()
    {
        return $this->belongsTo(Category::class, "category_id");
    }

    public function discount()
    {
        $now_timestamp = Carbon::now()->timestamp;
        return $this->hasOne(ProductDiscount::class)->where("status", 1)->where("percent_discount", ">", 0)->where("start_discount", "<", $now_timestamp)->where("finish_discount", ">", $now_timestamp);
    }
    public function attribute()
    {
        return $this->hasMany(ProductAttribute::class)->where("status", 1);
    }

    public function colorEnought()
    {
        return $this->hasMany(ProductAttribute::class)->where("status", 1)->where("number", ">", 0);
    }


    public function property_product()
    {

        return $this->hasMany(PropertyProduct::class);
    }
    public function comments()
    {
        return $this->hasMany(Comment::class);
    }

    public function scopeFilterProducts($query, $filters, $propertyIds, $filter_ids)
    {
        if ($filters) {
            foreach ($filters as $filter) {
                array_push($propertyIds, $filter["property_id"]);
            }
            $propertyIds = array_unique($propertyIds);
            foreach ($filters as $filter) {
                foreach ($propertyIds as $id) {
                    if ($filter["property_id"] == $id) {
                        if (array_key_exists($id, $filter_ids)) {
                            $filter_ids[$id] = [...$filter_ids[$id], $filter["id"]];
                        } else {
                            $filter_ids[$id] = [$filter["id"]];
                        }
                    }
                }
            }
        }
        return $query->when($filters, function ($query) use ($filter_ids) {
                foreach ($filter_ids as $filter_ids) {
                    $query->whereHas("property_product", function ($query) use ($filter_ids) {
                        $query->whereIn("property_id", $filter_ids);
                    });
                }
            });
    }

    public function scopeProducts($query)
    {
        return $query
            ->leftJoin('product_attributes', function ($join) {
                $join->on('products.id', '=', 'product_attributes.product_id')
                    ->where("product_attributes.deleted_at", null)
                    ->where("product_attributes.status", 1)
                    ->where("product_attributes.number", ">", 0);
            })->with("discount", "attribute.color", "attribute.size");
    }
    public function scopeProductsCategory($query , $categoriesId ){
        return $query
        ->whereIn("products.category_id", $categoriesId);
    }
    public function scopeSortProducts($query, $sortType)
    {
        return $query->when($sortType == 3, function ($query) {
            $query->orderByRaw('product_attributes.number > 0 desc , products.price + product_attributes.price_increase asc');
        })
            ->when($sortType == 2, function ($query) {
                $query->orderByRaw('product_attributes.number > 0 desc , products.price + product_attributes.price_increase desc');
            })
            ->when($sortType == 1, function ($query) {
                $query->orderBy("product_attributes.product_id", "desc");
            });
    }
    public function scopeAvailableProducts($query, $available)
    {
        return $query->when($available == 1, function ($query) {
            $query->where("product_attributes.number", ">", 0);
        });
    }
    public function scopeBrandFilterProducts($query, $brands_selected)
    {
        return $query->when($brands_selected, function ($query) use ($brands_selected) {
            $query->whereIn("brand_id", $brands_selected);
        });
    }
    public function scopePaginationProducts($query, $products_id_list)
    {
        return 
        $query
        ->whereNotIn("products.id" , $products_id_list)->take(70);
    }
    public function scopeDiscounted($query){
        return $query->whereHas("discount");
    }
    public function scopeGetProducts($query)
    {
        return 
        $query->orderBy("products.id", "desc")
              ->groupBy('products.id')
              ->get(['products.*', 'product_attributes.price_increase', 'product_attributes.number', "product_attributes.product_id"]);
    }

    protected static function booted()
    {
        static::addGlobalScope('published', function (Builder $builder) {
            $builder->whereHas("attribute");
        });
    }
}

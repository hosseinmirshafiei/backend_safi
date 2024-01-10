<?php

namespace App\Models;

use Cviebrock\EloquentSluggable\Sluggable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Category extends Model
{
    use HasFactory , SoftDeletes ,Sluggable;
    protected $table = "category";
    protected $fillable = ['name' ,'slug' , 'category_id' , 'image' , 'status'];

    public function sluggable(): array
    {
        return [
            'slug' => [
                'source' => 'name'
            ]
        ];
    }

    public function parent(){
        return $this->belongsTo(Category::class , "category_id");
    }
    public function parents()
    {
        return $this->belongsTo(Category::class, "category_id")
        ->with("property")
        ->with("parents");
    }
    public function child()
    {
        return $this->hasMany(Category::class);
    }
    public function childes()
    {
        return $this->hasMany(Category::class)->with("childes");
    }
    public function property(){
        return $this->hasMany(Property::class);
    }
    public function products(){
        return $this->hasMany(Product::class , "category_id");
    }

    public static function categoryChilds($category , $categoriesId){
        array_push($categoriesId, $category->id);
        foreach ($category->childes as $category) {
             $categoriesId = static::categoryChilds($category, $categoriesId);
        }
        return $categoriesId;   
    }

}

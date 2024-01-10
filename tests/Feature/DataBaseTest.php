<?php

namespace Tests\Feature;

use App\Models\Category;
use App\Models\Product;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class DataBaseTest extends TestCase
{
    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function test_database()
    {
        // $data = Product::factory()->for(Category::factory())->create();   // create data with one category field 
        // $data = Product::make(factory())->toArray();    // no create to database just return data
        // $product = Product::factory()->create();             // create to database data
        // $category = Category::factory()->hasProducts(2)->create();   //add many childs to record
        // dd($category->products->toArray());

        // $this->assertDatabaseCount("products" , 9);               // count table record
        // $this->assertDatabaseHas("products" , $data);            // is data in table
        // $this->assertDatabaseMissing("products" , $data);        //  data is not in table
        // $this->assertTrue(isset($data->category->id));           // conditional is true ? 
        // $this->assertCount(1 , $category->products);             //two parameter is equals
        // $this->assertInstanceOf(Product::class , $product);      // check property is for model


    }
}

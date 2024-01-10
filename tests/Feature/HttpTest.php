<?php

namespace Tests\Feature;

use App\Http\Middleware\AdminMiddleWare;
use App\Models\Category;
use App\Models\Product;
use App\Models\User;
use Doctrine\DBAL\Logging\Middleware;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Http\Request;
use Illuminate\Http\UploadedFile;
use Tests\TestCase;

class HttpTest extends TestCase
{
    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function test_http()
    {
        //in feature test we access to all service laravel test but in unit test we have not access

        // $this->withoutMiddleware([IsLogin::class]);               // disActive middleware
        // $this->withoutExceptionHandling();        //detail perfect error during testing
        // $user = User::factory()->state(['type'=>'admin'])->make(); // make user but dont create in database and state is for add field to user
        // $user = User::factory()->count(4)->make();    //make record to size 4 
        // $this->assertEquals($user->count(), 4);
        // $this->actingAs($user);                     // go to rout by user
        // $response = $this->post(route("admin.comment.create"));     // go to route

        // $response->assertViewIs("name view");       // blade is exists in route 
        // $response->assertViewHasAll([]);            // data compact to view blade

        // $response->assertStatus(200);               // any things is ok
        // $response->assertOk();                      // any things is ok 
        // $response->assertRedirect(route("create", ["id" => 5]));   //assert is redirect to another route
        // $this->assertEmpty($data);                                  // check data is Empty

        // $this->assertDatabaseMissing("products", ["id"=>1000]);    // no match in table

        //test validation
        // $response->assertStatus(302);                 //if has validation error -- code 302
        // $response->assertSessionHasErrors();          //if has validation error

        //test middleware
        // $request = Request::create("admin.comment.create" , 'POST');
        // $middleware = new AdminMiddleWare();
        // $response = $middleware->handle($request , function(){});
        // $this->assertEquals($response->getStatusCode() , 302);    //middleware have error 302 if it was ok status code is 200

        ///route have middleware
        // $this->assertEquals(request()->route()->middleware() , ["api","admin"]);

        ///test upload file
        // $image = UploadedFile::fake()->image("image.png");    //create file
        // $response = $this->json('POST', route('admin.admin-info.uploadImage'), ['image' => $image]);
        // $response->assertStatus(200);
        // $this->assertFileExists(public_path($response["image"]));   //check file exist in directory
        // $this->assertFileDoesNotExist(public_path($response["image"]));  //check file not exist in directory
        // $this->travel(20);    //add 20 seconds to now time for example 

        


    }
}

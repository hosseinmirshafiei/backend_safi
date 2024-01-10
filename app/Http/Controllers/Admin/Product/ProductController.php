<?php

namespace App\Http\Controllers\Admin\Product;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\ProductRequest;
use App\Http\Services\ImageUpload\ImageUploadService;
use App\Models\Brand;
use App\Models\Category;
use App\Models\Color;
use App\Models\GeneralDiscount;
use App\Models\Product;
use App\Models\ProductAttribute;
use App\Models\ProductColor;
use App\Models\ProductDiscount;
use App\Models\Size;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\File;
use Image;

class ProductController extends Controller
{
    public function index(ProductRequest $request)
    {

        $req = $request->all();
        $name = $req['name'];
        $lastId = $req["last_id"];
        $page = $req["page"];

        $products = Product::when($name != null, function ($query) use ($name) {
                $query->where('name', 'LIKE', "%$name%");
            })
            ->when($page == 1, function ($query) {
                $query->where('id', ">", 0);
            })
            ->when($page != 1, function ($query) use ($lastId) {
                $query->where('id', "<", $lastId);
            })
            ->with("category", "discount", "attribute.color", "attribute.size")
            ->withTrashed()
            ->orderBy('id', 'desc')
            ->limit(20)
            ->get();
        return response()->json($products);
    }

    public function generalDiscount()
    {
        $general_discount = GeneralDiscount::generalDiscount();
        $now_timestamp = Carbon::now()->timestamp;
        $response = ["general_discount" => $general_discount, "nowDate" => $now_timestamp];
        return response()->json($response);
    }

    public function delete(ProductRequest $request)
    {
        $req = $request->all();
        $id_product = $req["id"];
        $product = Product::where('id', $id_product)->withTrashed()->get()->first();
        if (!empty($product)) {
            if ($product->deleted_at == null) {
                $product->delete();
                ProductDiscount::where('product_id', $id_product)->delete();
                return response()->json("delete");
            } else {
                $product->restore();
                ProductDiscount::where('product_id', $id_product)->restore();
                return response()->json("restore");
            }
        }
    }

    public function ckeditor(ProductRequest $request)
    {
        // if ($request->hasFile('upload')) {
            $originName = $request->file('upload')->getClientOriginalName();
            $fileName = pathinfo($originName, PATHINFO_FILENAME);
            $extension = $request->file('upload')->getClientOriginalExtension();
            $randomStr = Str::random(40);
            $fileName = date('mdYHis') . '-' . $randomStr . '-' . uniqid() . '.' . $extension;
            $request->file('upload')->move(public_path('images-products-description'), $fileName);
            $CKEditorFuncNum = $request->input('CKEditorFuncNum');
            $url = asset('images/images-products-description/' . $fileName);
            $msg = 'تصویر با موفقیت بارگذاری شد.';
            return response()->json(['fileName' => $fileName, 'uploaded' => 1, 'url' => $url , 'CKEditorFuncNum'=>$CKEditorFuncNum]);
        // }
    }

    public function uploadImage(ProductRequest $request)
    {

        $path = 'images/products/';
        $response_key = "image";
        $request_key = "image";
        $response = ImageUploadService::UploadImage($path, $request, $request_key, $response_key);
        return response()->json([$response_key => $response]);
    }

    public function create()
    {
        $categories = Category::all();
        $brands = Brand::all();
        $colors = Color::all();
        $sizes = Size::all();
        return response()->json(["success", "categories" => $categories, "brands" => $brands, "colors" => $colors, "sizes" => $sizes]);
    }

    public function store(ProductRequest $request)
    {

        $req = $request->all();
        $colors = $request["colors"];
        $req["tags"] = "tag";
        $product = Product::create($req);
        //create colors product 
        if ($request->has("colors")) {
            foreach ($colors as $color) {
                ProductAttribute::create([
                    "product_id"       => $product->id,
                    "color_id"         => $color["color_id"],
                    "size_id"          => $color["size_id"],
                    "price_increase"   => $color["price_increase"],
                    "number"           => $color["number"],
                ]);
            }
        } else {
            ProductAttribute::create([
                "product_id" => $product->id,
                "color_id"   => null,
                "size_id"    => null,
                "price_increase"      => 0,
                "number"     => $req["number"],
            ]);
        }
        /////
        $new_product = Product::where("id", $product->id)->with("category", "discount", "attribute.color", "attribute.size")->get()->first();
        return response()->json(["success", "new_product" => $new_product]);
    }

    public function edit(ProductRequest $request)
    {

        $req = $request->all();
        $product = Product::where("id", $req['id'])->get()->first();
        $categories = Category::all();
        $brands = Brand::all();
        if (!empty($product)) {
            return response()->json(["categories" => $categories, "product" => $product, "brands" => $brands]);
        }
    }

    public function update(ProductRequest $request)
    {

        $req = $request->all();
        $product = Product::where("id", $req['id'])->get()->first();
        if (!empty($product)) {
            $product->update($req);
            $updated_product = Product::where("id", $product->id)->with("category", "discount")->get()->first();
            return response()->json(["success", "updated" => $updated_product]);
        }
    }
}

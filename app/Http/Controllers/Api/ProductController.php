<?php

namespace App\Http\Controllers\Api;

use App\Models\Product;
use Illuminate\Support\Str;
use App\Models\ProductImage;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;

/**
 * There is always a room for improvement for this controller
 * We can wrap the product business logic to a repository class
 * Apply Dependency Injection
 * FormRequest for validation
 */
class ProductController extends Controller
{

    public function index(Request $request)
    {
        $category = array_filter($request->category ?? []);
        $products = Product::with(['categories', 'images'])
            ->when($category, fn ($q) => $q->whereHas('categories', fn ($q) => $q->whereIn('id', $category)))
            ->when($request->has('search'), fn ($q) => $q->where(fn ($q) => $q->where('name', 'like', "%{$request->input('search')}%")
                ->orWhere('description', 'like', "%{$request->input('search')}%")))
            ->paginate(10);

        return response()->json($products);
    }

    public function edit(int $id)
    {
        return Product::with(['images', 'categories'])->find($id);
    }


    public function store(Request $request)
    {
        $this->validate($request, [
            'name' => ['required'],
            'categories' => ['required'],
            'description' => ['required', 'max:200'],
            'images.*' => ['required'],
            'dateAndTime' => ['required', 'date'],
        ]);

        return DB::transaction(function () use ($request) {
            $product = Product::create([
                'name' => $request->name,
                'description' => $request->description,
                'date_and_time' => $request->dateAndTime,
            ]);

            $categories = explode(",", $request->categories);

            $product->categories()->attach($categories);

            $productImages = [];

            foreach ($request->file('images') as $image) {
                $path = $image->store('public/product-images');
                $productImages[] = new ProductImage(['path' => Str::remove("public/", $path)]);
            }

            $product->images()->saveMany($productImages);
            return response()->json(['success' => true], 201);
        });
    }

    public function update(int $id, Request $request)
    {
        $this->validate($request, [
            'name' => ['required'],
            'categories' => ['required'],
            'description' => ['required', 'max:200'],
            'images.*' => ['nullable'],
            'dateAndTime' => ['required', 'date'],
        ]);

        return DB::transaction(function () use ($request, $id) {
            $product = Product::find($id);
            $product->name = $request->name;
            $product->description = $request->description;
            $product->date_and_time = $request->dateAndTime;
            $product->save();

            $categories = explode(",", $request->categories);
            $product->categories()->sync($categories);

            if ($request->hasFile('images')) {
                
                $product->images()->delete();

                $productImages = [];

                foreach ($request->file('images') as $image) {
                    $path = $image->store('public/product-images');
                    $productImages[] = new ProductImage(['path' => Str::remove("public/", $path)]);
                }

                $product->images()->saveMany($productImages);
            }
            return response()->json(['success' => true], 201);
        });
    }
}

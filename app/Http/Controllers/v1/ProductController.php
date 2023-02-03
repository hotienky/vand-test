<?php

namespace App\Http\Controllers\v1;

use App\Http\Controllers\Controller;
use App\Http\Requests\CreateProductRequest;
use App\Http\Resources\Product\ProductCollection;
use App\Http\Resources\Product\ProductResource;
use App\Models\Product;
use App\Models\ProductVariant;
use App\Models\Store;
use App\Pipelines\ProductFilterPipeline;
use App\QueryBuilder\Product\ProductName;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $products = ProductFilterPipeline::run(Product::query(), $request->all());
        $products = $products->paginate(min(
            $request->input(config('page.page_size_parameter'), config('page.per_page')),
            config('page.max_per_page')
        ));
        return api_success(
            ProductCollection::make($products)->toArray($request),
        );
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(CreateProductRequest $request)
    {
        try {
            DB::beginTransaction();
            //TODO check product Belongs to user

            //End TODO

            //get user calling
            $user = Auth::user();

            //get params product user transmit down
            $params = $request->only([
                "product_name",
                "description",
                "images",
                "status",
            ]);

            //get params stores user transmit down
            $store_ids = $request->input('store_ids');

            //get params product variants user transmit down
            $product_variants = $request->input('product_variants');

            //create product
            $product = Product::create([...$params, "slug" => Str::slug($params['product_name']), 'user_id' => $user->id]);
            if(!$product) {
                new Exception('');
            }

            //save store_ids
            $store = Store::find($store_ids);
            $product->stores()->attach($store);

            //create product variant
            $arr_variants = [];
            foreach ($product_variants as $variant) {
                array_push($arr_variants, new ProductVariant([...$variant, 'product_id' => $product->id, 'sku' => Str::slug($variant['name'])]));
            }
            if(count($arr_variants) <= 0) {
                new Exception('');
            }
            $product->product_variants()->saveMany($arr_variants);

            //commit insert database
            DB::commit();

            //find product
            $product = Product::find($product->id);
            return api_success(ProductResource::make($product));
        } catch (\Throwable $th) {
            DB::rollBack();
            return api_errors('Error! An error occurred. Please try again later');
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Product $product)
    {
        // TODO Check if the product belongs to the requesting user or not
        $user = Auth::user();

        //check product exists
        if(!$product) {
            return api_errors('product not found');
        }
        return api_success(ProductResource::make($product));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}

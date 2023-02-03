<?php

namespace App\Http\Controllers\v1;

use Exception;
use App\Http\Controllers\Controller;
use App\Http\Requests\ProductVariantRequest;
use App\Http\Resources\ProductVariant\ProductVariantCollection;
use App\Http\Resources\ProductVariant\ProductVariantResource;
use App\Models\ProductVariant;
use App\Pipelines\ProductVariantFilterPipeline;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;


class ProductVariantController extends Controller
{
    /**
     * Display a listing of the resource.
     * \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $product_variants = ProductVariantFilterPipeline::run(ProductVariant::query(), $request->all());
        $product_variants = $product_variants->paginate(min(
            $request->input(config('page.page_size_parameter'), config('page.per_page')),
            config('page.max_per_page')
        ));
        return api_success(
            ProductVariantCollection::make($product_variants)->toArray($request),
        );
    }


    /**
     * Store a newly created resource in storage.
     *
     * @param  ProductVariantRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(ProductVariantRequest $request)
    {
        try {
            DB::beginTransaction();

            //get params product variant user transmit down
            $params = $request->only([
                "product_id",
                "name",
                "stock_price",
                "price",
                "stock",
                "status",
                "images",
                "description",
            ]);

            $params = [...$params, 'sku' => Str::slug($params['name'])];

            $product_variant = ProductVariant::updateOrCreate($params);

            if($product_variant) {
                new Exception('');
            }

            DB::commit();
            return api_success(ProductVariantResource::make($product_variant));
        } catch (\Throwable $th) {
            DB::rollBack();
            return api_errors('Error! An error occurred. Please try again later');
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  ProductVariant  $product_variant
     * @return \Illuminate\Http\Response
     */
    public function show(ProductVariant $product_variant)
    {
        //check product_variant exists
        if(!$product_variant){
            return api_errors('product variant not found');
        }
        return api_success(ProductVariantResource::make($product_variant));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  ProductVariant  $product_variant
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, ProductVariant $product_variant)
    {
        //check product_variant exists
        if(!$product_variant){
            return api_errors('product variant not found');
        }

        try {
            DB::beginTransaction();

            //get params product variant user transmit down
            $params = $request->only([
                "product_id",
                "sku",
                "name",
                "stock_price",
                "price",
                "stock",
                "status",
                "images",
                "description",
            ]);

            $params = [...$params, 'sku' => Str::slug($params['sku'])];

            $product_variant->update($params);

            DB::commit();
            return api_success(ProductVariantResource::make($product_variant));
        } catch (\Throwable $th) {
            DB::rollBack();
            return api_errors('Error! An error occurred. Please try again later');
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  ProductVariant  $product_variant
     * @return \Illuminate\Http\Response
     */
    public function destroy(ProductVariant  $product_variant)
    {
        //check product_variant exists
        if(!$product_variant){
            return api_errors('product variant not found');
        }

        $product_variant->delete();
        return api_success("Delete success");
    }
}

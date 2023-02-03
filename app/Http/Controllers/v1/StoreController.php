<?php

namespace App\Http\Controllers\v1;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreRequest;
use App\Http\Requests\StoreUpdateRequest;
use App\Http\Resources\Store\StoreCollection;
use App\Http\Resources\Store\StoreResource;
use App\Models\Store;
use App\Pipelines\StoreFilterPipeline;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class StoreController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $user = Auth::user();
        $stores = StoreFilterPipeline::run(Store::where('user_id', $user->id)
        ->with(['products']), $request->all());
        $stores = $stores->paginate(min(
            $request->input(config('page.page_size_parameter'), config('page.per_page')),
            config('page.max_per_page')
        ));
        return api_success(
            StoreCollection::make($stores)->toArray($request),
        );
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  StoreRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreRequest $request)
    {
        try {
            $user = Auth::user();
            $params = $request->only([
                'store_name',
                'images',
                'address',
                'time_open',
                'time_close',
            ]);
            $params = [...$params, 'user_id' => $user->id];
            $arrayResponse = Store::create($params);
            if(!$arrayResponse) {
                new Exception('');
            }
            return api_success(StoreResource::make($arrayResponse));
        } catch (\Throwable $th) {
            return api_errors('Error! An error occurred. Please try again later');
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  Store  $store
     * @return \Illuminate\Http\Response
     */
    public function show(Store $store)
    {
        if(!$store){
            return api_errors('store not found');
        }
        return api_success(StoreResource::make($store));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  StoreUpdateRequest  $request
     * @param  Store  $store
     * @return \Illuminate\Http\Response
     */
    public function update(StoreUpdateRequest $request, Store $store)
    {
        if(!$store) {
            return api_errors('store not found');
        }

        $store->update($request->all());

        return api_success(StoreResource::make($store));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  Store  $store
     * @return \Illuminate\Http\Response
     */
    public function destroy(Store $store)
    {
        if(!$store) {
            return api_errors('store not found');
        }
        $store->delete();
        return api_success("Delete success");
    }
}

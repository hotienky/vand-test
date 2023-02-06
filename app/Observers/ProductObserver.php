<?php

namespace App\Observers;

use App\Models\Product;

class ProductObserver
{

    /**
     * Handle the product "created" event.
     *
     * @param  Product  $site
     * @return void
     */

    public function creating(Product $site)
    {
    }

    /**
     * Handle the product "created" event.
     *
     * @param  Product  $site
     * @return void
     */
    public function created(Product $product)
    {
    }

    /**
     * Handle the product "saving" event.
     *
     * @param  Product  $product
     * @return void
     */

    public function saving(Product $product)
    {

    }

    /**
     * Handle the product "updated" event.
     *
     * @param  Product  $product
     * @return void
     */
    public function updated(Product $product)
    {

    }

    /**
     * Handle the product "deleted" event.
     *
     * @param  Product $product
     * @return void
     */
    public function deleted(Product $product)
    {
        //
    }

    /**
     * Handle the product "restored" event.
     *
     * @param  Product $product
     * @return void
     */
    public function restored(Product $product)
    {
        //
    }

    /**
     * Handle the product "force deleted" event.
     *
     * @param  Product $product
     * @return void
     */
    public function forceDeleted(Product $product)
    {
        //
    }
}

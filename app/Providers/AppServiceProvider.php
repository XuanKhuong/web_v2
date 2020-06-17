<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use View;
use App\Product;
use App\Image;
use App\ProductDetail;
use App\Manufacturer;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {

        view()->composer('*', function ($view)
        {  
            $cate_products = Product::select('name', 'id')->get();

            foreach ($cate_products as $cate_product) {
                $cate_product['manufacturer_products'] = manufacturer::select('id', 'name', 'thumbnail', 'product_id')
                ->where('product_id', $cate_product->id)
                ->get();

                foreach ($cate_product['manufacturer_products'] as $dt_product) {
                // dd($dt_product->id);
                    $dt_product['products'] = ProductDetail::select('name', 'id', 'manufacturer_id', 'slug')
                    ->where('manufacturer_id', $dt_product->id)
                    ->get();
                }
            }
                
            $view->with('cate_product', $cate_product);
        });
    }
}

<?php

namespace App\Http\Middleware;

use Closure;
use App\Product;

class CheckProductOwnership
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        //dapatkan product id dari url
        $product_id = $request->product;

        //dapatkan product info based on product_id

        $product = Product::find($product_id);

        if ($product) {
            //dapatkan user_id untuk product tersebut
            $product_owner = $product->user_id;

            //dapatkan current logged in user id

            $current_user_id = auth()->id();

            //check jika current user yang cuba akses, tak sama dengan product owner

            if ($current_user_id!=$product_owner) {
                dd("PERIGAT JANGE MENCEROBOH");
            }
        }

        return $next($request);
    }
}

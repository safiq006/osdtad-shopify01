<?php

namespace App\Http\Controllers;


use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use App\Models\Collection;
use App\Models\Product;


class ProductController extends Controller
{
    // public function index()
    // {
    //     $shop = Auth::user();
    //     $data = $shop->api()->rest('GET', '/admin/products.json');
    //     $products   = $data['body']->products;
    //     return view('welcome', compact('products'));
    // }

    function products(Request $request, $collectionid)
    {
        //get products for a collection
        //check if this collection id belongs to shop id
        $collection = Collection::findOrFail($collectionid);
        $shop = $request->user();
        if ($collection->shop_id != $request->user()->id) {
            return Redirect::tokenRedirect('collection.index');
        }

        if ($request->isMethod('post')) {
            $productid = $request->productid;
            if ($productid != 0) {
                $product = product::find($productid);
            } else {
                $product = new product();
            }

            $product->name = $request->name;
            $product->description = $request->description;
            $product->collection_id = $collection->id;
            $product->shop_id = $shop->id;
            //$product->status = 1;

            $product->save();

            $redirectUrl = getRedirectRoute('collection.products', ['collectionid' => $collection->id]);
            return redirect($redirectUrl);

        }

        $products = Product::where('collection_id', $collection->id)->get();
        return view('collection.products', compact('products', 'collection'));
    }
}

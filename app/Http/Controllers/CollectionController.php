<?php

namespace App\Http\Controllers;

use App\Models\Group;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Facades\Redirect;
use App\Models\Collection;
use Illuminate\Support\Facades\URL;

class CollectionController extends Controller {
    public function collectionIndex(Request $request): View
    {
        $collections = Collection::where('shop_id', auth()->user()->id)->get();
    

        return view('collection.index', compact('collections'));
    }

    public function collectionSave(Request $request): RedirectResponse
    {
        $collectionid = $request->collectionid;
        if ($collectionid != 0) {
            $collection = Collection::find($collectionid);
        } else {
            $collection = new Collection();
        }

        $collection->name = $request->name;
        $collection->description = $request->description;
        $collection->shop_id = auth()->user()->id;        

        $collection->save();

        return Redirect::away(URL::shopifyRoute('collection.index'));

    }
}
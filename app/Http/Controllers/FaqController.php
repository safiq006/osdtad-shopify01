<?php

namespace App\Http\Controllers;

use App\Models\Group;
use Illuminate\Http\Request;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Facades\Redirect;

class FaqController extends Controller
{
    public function groupIndex(Request $request): View
    {
        //check if it is a POST request
        if ($request->isMethod('post')) {

            $groupid = $request->groupid;
            if($groupid != 0){
                $group = Group::find($groupid);
                $group->name = $request->name;
                $group->description = $request->description;
                $group->shop_id = auth()->user()->id;
                $group->status = 1;

                $group->save();
            }
            else{
                $group = new Group();

                $group->name = $request->name;
                $group->description = $request->description;
                $group->shop_id = auth()->user()->id;
                $group->status = 1;

                $group->save();
            }

        }
        $groups = Group::where('shop_id', auth()->user()->id)->get();
        return view('group.index', compact('groups'));
    }


    public function groupStore(Request $request)
    {
        $group = new Group();

        $group->name = $request->name;
        $group->description = $request->description;
        $group->shop_id = auth()->user()->id;
        $group->status = 1;

        $group->save();
        return Redirect::tokenRedirect('group.index');
    }
}

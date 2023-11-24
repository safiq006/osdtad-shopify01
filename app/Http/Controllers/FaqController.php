<?php

namespace App\Http\Controllers;

use App\Models\Group;
use Illuminate\Http\Request;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Facades\Redirect;
use App\Models\Faq;
use URL;

class FaqController extends Controller {
    public function groupIndex(Request $request) {
        //check if it is a POST request
        if ($request->isMethod('post')) {

            $groupid = $request->groupid;
            if ($groupid != 0) {
                $group = Group::find($groupid);
            } else {
                $group = new Group();
            }

            $group->name = $request->name;
            $group->description = $request->description;
            $group->shop_id = auth()->user()->id;
            $group->status = 1;

            $group->save();
            $redirectUrl = getRedirectRoute('group.index');
            return redirect($redirectUrl);
        }
        $groups = Group::where('shop_id', auth()->user()->id)->get();
        return view('group.index', compact('groups'));
    }


    public function groupStore(Request $request) {
        $group = new Group();

        $group->name = $request->name;
        $group->description = $request->description;
        $group->shop_id = auth()->user()->id;
        $group->status = 1;

        $group->save();
        return Redirect::tokenRedirect('group.index');
    }

    function faqs(Request $request, $groupid) {
        //get FAQs for a group
        //check if this group id belongs to shop id
        $group = Group::findOrFail($groupid);
        $shop = $request->user();
        if ($group->shop_id != $request->user()->id) {
            return Redirect::tokenRedirect('group.index');
        }

        if ($request->isMethod('post')) {
            $faqid = $request->faqid;
            if ($faqid != 0) {
                $faq = Faq::find($faqid);
            } else {
                $faq = new Faq();
            }

            $faq->question = $request->question;
            $faq->answer = $request->answer;
            $faq->group_id = $group->id;
            $faq->shop_id = $shop->id;
            $faq->status = 1;

            $faq->save();

            // $redirectUrl = URL::tokenRoute('group.faqs', ['groupid' => $group->id]);
            // $redirectUrl = str_replace("http","https",$redirectUrl);
            // $redirectUrl .= "&host=YWRtaW4uc2hvcGlmeS5jb20vc3RvcmUvb3N0YWRzdG9yZTE2";

            $redirectUrl = getRedirectRoute('group.faqs', ['groupid' => $group->id]);
            return redirect($redirectUrl);

        }

        $faqs = Faq::where('group_id', $group->id)->get();
        return view('group.faqs', compact('faqs', 'group'));
    }
}

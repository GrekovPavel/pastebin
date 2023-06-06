<?php

namespace App\Http\Controllers;

use App\Models\Paste;
use Illuminate\Support\Facades\Cache;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Str;



class PasteController extends Controller
{

    public function index() {

        $dataTable = Paste::all();

        return View('paste', compact('dataTable'));
    }

    public function submit(Request $request) {

        $request = $request->input('pasteTextarea');
        $hash = Str::limit(hash('sha256', $request), 4, "") . Str::random(3);
        $link = $hash;
        $this->create($request, $link);

        $url = route('form.paste', ['hash' => $hash]);
        Cache::put($hash, $request);

        return Redirect::to($url);
    }

    public function paste($hash)
    {
        $data = Cache::get($hash);
        $dataTable = Paste::all();

        if ($data) {
            return View('myPaste', compact('data', 'dataTable'));
        }

        return abort(404);
    }

    public function create($request, $link) {

       return Paste::create([
            "content" => $request,
            "link" => $link,
            "visibility" => "public"
        ]);
    }
}

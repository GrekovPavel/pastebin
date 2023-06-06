<?php

namespace App\Http\Controllers;

use App\Models\Paste;
use Illuminate\Http\Request;


class PasteController extends Controller
{

    public function index() {

        $dataTable = Paste::all();

        return View('paste', compact('dataTable'));
    }

    public function submit(Request $request) {

        $request = $request->input('pasteTextarea');
        $this->create($request);

        return $this->index();
    }

    public function create($request) {

       return Paste::create([
            "content" => $request,
            "visibility" => "public"
        ]);
    }
}

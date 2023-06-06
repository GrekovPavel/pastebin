<?php

namespace App\Http\Controllers;

use App\Models\Paste;
use Illuminate\Http\Request;

class PasteController extends Controller
{
    public function index() {
        $paste = 'hi';

        return View('paste', compact('paste'));
    }
}

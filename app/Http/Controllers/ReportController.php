<?php

namespace App\Http\Controllers;

use App\Models\Paste;
use App\Models\Report;
use App\Models\User;
use App\Providers\RouteServiceProvider;
use App\Service\SocialService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Laravel\Socialite\Facades\Socialite;

class ReportController extends Controller
{
    public function store(Request $request)
    {
        $report = new Report;
        $report->paste_id = $request->paste_id;
        $report->reason = $request->reason;
        $report->save();

        return back();
    }
}

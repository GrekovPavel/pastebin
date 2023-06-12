<?php

namespace App\Http\Controllers;

use App\Models\Paste;
use App\Models\Report;
use App\Models\User;
use App\Providers\RouteServiceProvider;
use App\Service\SocialService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Laravel\Socialite\Facades\Socialite;

class ReportController extends Controller
{
    /**
     *
     * Записывает данные жалобы в базу
     *
     * @param Request $request
     * @return RedirectResponse
     */
    public function store(Request $request): RedirectResponse
    {
        $report = new Report();
        $report->paste_id = $request->input('paste_id');
        $report->reason = $request->input('reason');
        $report->save();

        return back();
    }
}

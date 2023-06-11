<?php

namespace App\Http\Middleware;

use App\Models\Paste;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use League\CommonMark\Extension\CommonMark\Node\Inline\Link;

class PermissionMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param \Illuminate\Http\Request $request
     * @param \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse) $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next, $hash)
    {
        $link = $request->route('hash');

        $paste = Paste::where('link', $link)->first();

        if (Auth::user() !== null) {
            $userId = Auth::user()->id;
        } else {
            $userId = null;
        }

        if ($paste->access_paste === 'private' and $paste->user_id !== $userId) {
            abort(403, 'У вас нет прав для доступа к этой странице');
        }

        return $next($request);
    }
}

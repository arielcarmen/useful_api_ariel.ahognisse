<?php

namespace App\Http\Middleware;

use App\Models\UserModule;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class CheckModuleActive
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next, string $module_id): Response
    {
        $user_module = UserModule::where([['user_id', Auth::id()], ['module_id', $module_id]])->first();

        if (!$user_module || $user_module->active === 0) {
            return response(['error' => 'Module inactive. Please activate this module to use it.'], 403);
        }
        return $next($request);
    }
}

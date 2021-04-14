<?php

namespace Iwindy\LaravelPermission\Http\Middleware;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Iwindy\LaravelPermission\Facade\Permission;

class PermissionMiddleware
{
    /**
     * @param Request $request
     * @param \Closure $next
     * @return mixed
     */
    public function handle(Request $request, \Closure $next)
    {
        if (!$user = Auth::user()) {
            return $next($request);
        }

        $route = $request->route();
        $current_auth_note = sprintf('%s:%s', implode('|', $route->methods()), $route->uri());

        $auth_nodes = Permission::getNodes();
        $is_check = $auth_nodes->contains($current_auth_note);

        if ($is_check && !$user->checkPermission($current_auth_note)) {
            abort(403, '权限不足');
            exit;
        }

        return $next($request);
    }
}

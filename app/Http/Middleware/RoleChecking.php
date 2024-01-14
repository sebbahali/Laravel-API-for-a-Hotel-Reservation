<?php

namespace App\Http\Middleware;

use App\Models\Hotel;
use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class RoleChecking
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
public function handle(Request $request, Closure $next,...$roles): Response
    {
/ Check if the authenticated user has the specified roles
      if (!$request->user()->hasRoles($roles)) {

        abort(403, 'You do not have permission role');

      }
      return $next($request);

    }
}

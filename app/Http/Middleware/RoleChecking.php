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

  $nameroles=[

    'Admin'=>2 ,
    'Owner'=>3,
  ];

  foreach ($roles as $role) {
      if ($request->user()->role_id === $nameroles[$role]) {

        return $next($request);
      }

    }
    abort(403, 'You do not have permission role');
    }
}

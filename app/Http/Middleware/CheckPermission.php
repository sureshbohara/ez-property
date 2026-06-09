<?php
namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class CheckPermission 
{
    public function handle(Request $request, Closure $next, string $entity, string $action): Response
    {
        $user = $request->user('admin');
        
     
        if (!$user) {
            return $request->expectsJson() 
                ? response()->json(['message' => 'Unauthenticated'], 401) 
                : redirect()->route('admin.login');
        }

 
        if ($user->isSuperAdmin()) {
            return $next($request);
        }

   
        if (!$user->hasPermission($entity, $action)) {
            return $request->expectsJson()
                ? response()->json(['message' => 'Forbidden: Insufficient permissions'], 403)
                : abort(403, 'You do not have permission to ' . $action . ' ' . $entity);
        }

        return $next($request);
    }
}
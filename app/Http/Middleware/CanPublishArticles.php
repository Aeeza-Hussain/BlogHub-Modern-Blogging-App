<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class CanPublishArticles
{
    /**
     * Allow admins and authors through, since both publish to the blog.
     *
     * @param  Closure(Request): (Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $user = $request->user();

        if (!$user) {
            return redirect()->guest(route('login'));
        }

        if (!$user->canPublish()) {
            abort(403, 'Your account is not approved to publish articles yet.');
        }

        return $next($request);
    }
}

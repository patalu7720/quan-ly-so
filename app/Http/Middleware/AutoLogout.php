<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Session\Store;

class AutoLogout
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */

    protected $session;
    protected $timeout = 120;

    public function __construct(Store $session)
    {
        $this->session = $session;
    }

    public function handle(Request $request, Closure $next): Response
    {
        $is_logged_in = $request->path() != '/dangxuat';

        if(!session('last_active')) {
            $this->session->put('last_active', time());
        } elseif(time() - $this->session->get('last_active') > $this->timeout) {
            
            $this->session->forget('last_active');
            
            $cookie = cookie('intend', $is_logged_in ? url()->current() : '/');
            
            auth()->logout();
        }

        $is_logged_in ? $this->session->put('last_active', time()) : $this->session->forget('last_active');
        
        return $next($request);
    }
}

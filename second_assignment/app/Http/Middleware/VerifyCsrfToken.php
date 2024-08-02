<?php

namespace App\Http\Middleware;

use Illuminate\Foundation\Http\Middleware\VerifyCsrfToken as Middleware;

class VerifyCsrfToken extends Middleware
{
    /**
     * The URIs that should be excluded from CSRF verification.
     *
     * @var array<int, string>
     */
    protected $except = [
        'register', // Explicitly exclude specific routes
        'login',
        'user-details',
        'courses',
        'courses/*', // Exclude routes with parameters like courses/{id}
        'threads',
        'threads/*',
        'replies', 
        'replies/*', 
    ];
}

<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

use Illuminate\Foundation\Http\Middleware\VerifyCsrfToken as Middleware;

class VerifyCsrfToken extends Middleware
{
    /**
     * A CSRF-védelem alól kivett URI-k.
     *
     * @var array<int, string>
     */
    protected $except = [
        'api/new-order'
    ];
}

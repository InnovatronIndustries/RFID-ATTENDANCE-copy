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
        '/check-uid',
        '/rfid-login',
        '/rfid-logout',
        '/add-employee',
        '/remove-employee',
        '/remove-student',
        '/update-employee',
        '/update-student'
    ];
}

<?php

namespace App\Http\Middleware;

use Illuminate\Foundation\Http\Middleware\VerifyCsrfToken as Middleware;

class VerifyCsrfToken extends Middleware
{
    /**
     * The URIs that should be excluded from CSRF verification.
     *
     * @var array
     */
    protected $except = [
        '*users-inactive',
        '*users-active',
        'admin/service',
        '*plans-active',
        '*plans-inactive',

        '*sort-payment-methods',
        '*add-fund',
        'success',
        'failed',
        'payment/*',

        '*category-active',
        '*category-deactive',

        '*tournament-active',
        '*tournament-deactive',

        '*team-active',
        '*team-deactive',

        '*ajax-match/list',
        '*match-active',
        '*match-deactive',
        "*anyData*",
        '*ajax-match/question/update',
        '*match/question/active',
        '*match/question/deactive',
        '*match/question/close',
        '*withdraw-bank-list',
        '*withdraw-bank-from',
    ];
}

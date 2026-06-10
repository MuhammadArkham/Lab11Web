<?php

namespace Config;

use CodeIgniter\Config\Filters as BaseFilters;
use CodeIgniter\Filters\CSRF;
use CodeIgniter\Filters\DebugToolbar;
use CodeIgniter\Filters\ForceHTTPS;
use CodeIgniter\Filters\Honeypot;
use CodeIgniter\Filters\PageCache;
use CodeIgniter\Filters\PerformanceMetrics;
use CodeIgniter\Filters\Cors;
use App\Filters\Auth;

class Filters extends BaseFilters
{
    public array $aliases = [
        'csrf'        => CSRF::class,
        'toolbar'     => DebugToolbar::class,
        'honeypot'    => Honeypot::class,
        'forcehttps'  => ForceHTTPS::class,
        'pagecache'   => PageCache::class,
        'performance' => PerformanceMetrics::class,
        'auth'        => Auth::class,
        'apiauth'     => \App\Filters\ApiAuthFilter::class,
        'cors'        => Cors::class,
    ];

    public array $required = [
        'before' => [
            'forcehttps',
            'pagecache',
        ],
        'after' => [
            'pagecache',
            'performance',
            'toolbar',
        ],
    ];

    public array $globals = [
        'before' => [
            'cors',
        ],
        'after'  => [
            'cors',
        ],
    ];

    public array $methods = [];

    public array $filters = [];
}
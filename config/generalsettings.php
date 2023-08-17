<?php
return [
    'settings' => [
        'plugin' => [
            'route' => 'plugin.config',
            'route_segment' => ['plugin'],
            'icon' => 'fas fa-toolbox',
            'short_description' => 'Plugin such as, message your customers, reCAPTCHA protects, google analytics your website and so on.',
        ],
    ],
    'plugin' => [
        'tawk-control' => [
            'route' => 'admin.tawk.control',
            'icon' => 'fa fa-drumstick-bite',
            'short_description' => 'Message your customers,they\'ll love you for it',
        ],
//        'fb-messenger-control' => [
//            'route' => 'admin.fb.messenger.control',
//            'icon' => 'fab fa-facebook-messenger',
//            'short_description' => 'Message your customers,they\'ll love you for it',
//		],
        'google-recaptcha-control' => [
            'route' => 'admin.google.recaptcha.control',
            'icon' => 'fas fa-puzzle-piece',
            'short_description' => 'reCAPTCHA protects your website from fraud and abuse.',
        ],
        'google-analytics-control' => [
            'route' => 'admin.google.analytics.control',
            'icon' => 'fas fa-chart-line',
            'short_description' => 'Google Analytics is a web analytics service offered by Google.',
        ],
    ],
];

<?php

$customizeDir = __DIR__ . '/resources/views/customize/';
$files = [
    'index.blade.php',
    'select-product.blade.php', 
    'select-type.blade.php',
    'receiver-info.blade.php',
    'form.blade.php',
    'checkout.blade.php'
];

$fontStyles = '
/* Font sizes and weights matching wallet page */
.page-title {
    font-size: 0.95rem !important;
    font-weight: 600 !important;
    color: #ffffff !important;
}

.page-subtitle {
    font-size: 0.75rem !important;
    color: rgba(255,255,255,0.6) !important;
    font-weight: normal !important;
}

.product-title {
    font-size: 0.85rem !important;
    font-weight: 500 !important;
    color: #ffffff !important;
}

.product-description {
    font-size: 0.75rem !important;
    color: rgba(255,255,255,0.7) !important;
    font-weight: normal !important;
}

.product-price {
    font-size: 0.95rem !important;
    font-weight: 600 !important;
    color: #ffffff !important;
}

.progress-step-title {
    font-size: 0.85rem !important;
    font-weight: 500 !important;
    color: #ffffff !important;
}

.progress-step-label {
    font-size: 0.75rem !important;
    color: rgba(255,255,255,0.6) !important;
    font-weight: normal !important;
}

.progress-step-number {
    font-size: 0.85rem !important;
    font-weight: 600 !important;
    color: #ffffff !important;
}

.category-title {
    font-size: 0.85rem !important;
    font-weight: 500 !important;
    color: #ffffff !important;
}

.category-description {
    font-size: 0.75rem !important;
    color: rgba(255,255,255,0.7) !important;
    font-weight: normal !important;
}

/* Override any template font styles */
* {
    font-family: inherit !important;
}

/* Ensure no bold text from template */
strong, b, .fw-bold {
    font-weight: inherit !important;
}

/* Line height for consistency */
p, h6, span, div {
    line-height: 1.2 !important;
}

/* Override any Bootstrap classes */
.small {
    font-size: 0.75rem !important;
    font-weight: normal !important;
}

.fw-bold {
    font-weight: 600 !important;
}

/* Override any template font weights */
strong, b {
    font-weight: 600 !important;
}
';

foreach ($files as $file) {
    $filePath = $customizeDir . $file;
    if (file_exists($filePath)) {
        $content = file_get_contents($filePath);
        
        // Add font styles before the closing </style> tag
        if (strpos($content, '</style>') !== false) {
            $content = str_replace('</style>', $fontStyles . "\n</style>", $content);
        }
        
        // Update specific HTML elements with inline styles
        $replacements = [
            'h4 class="fw-bold text-theme-1' => 'h4 class="fw-bold text-theme-1" style="font-size: 0.95rem !important; font-weight: 600 !important; color: #ffffff !important;"',
            'h5 class="fw-bold text-theme-1' => 'h5 class="fw-bold text-theme-1" style="font-size: 0.95rem !important; font-weight: 600 !important; color: #ffffff !important;"',
            'h6 class="fw-bold text-theme-1' => 'h6 class="fw-bold text-theme-1" style="font-size: 0.85rem !important; font-weight: 500 !important; color: #ffffff !important;"',
            'h6 class="text-theme-1' => 'h6 class="text-theme-1" style="font-size: 0.85rem !important; font-weight: 500 !important; color: #ffffff !important;"',
            'p class="text-secondary' => 'p class="text-secondary" style="font-size: 0.75rem !important; color: rgba(255,255,255,0.6) !important; font-weight: normal !important;"',
            'p class="small text-secondary' => 'p class="small text-secondary" style="font-size: 0.75rem !important; color: rgba(255,255,255,0.6) !important; font-weight: normal !important;"',
            'span class="fw-bold text-theme-accent-1' => 'span class="fw-bold text-theme-accent-1" style="font-size: 0.95rem !important; font-weight: 600 !important; color: #ffffff !important;"',
            'span class="text-white fw-bold' => 'span class="text-white fw-bold" style="font-size: 0.85rem !important; font-weight: 600 !important; color: #ffffff !important;"'
        ];
        
        foreach ($replacements as $search => $replace) {
            $content = str_replace($search, $replace, $content);
        }
        
        file_put_contents($filePath, $content);
        echo "Updated: $file\n";
    }
}

echo "All customize files updated with consistent font sizing!\n";
?> 
<?php
/**
 * Phosphor-style line-art SVG icons.
 * Custom-drawn, consistent stroke (1.5), 24-grid, premium beauty-tech fit.
 *
 * Usage:  echo icon('shield', ['size' => 24, 'class' => 'extra-class']);
 */

if (!function_exists('icon')) {
    function icon(string $name, array $opts = []): string {
        $size  = $opts['size']  ?? 24;
        $class = $opts['class'] ?? '';
        $stroke = $opts['stroke'] ?? 1.5;

        $paths = [
            // Trust / advantages
            'shield' => '<path d="M12 3l8 3v6c0 4.4-3.5 8.4-8 9-4.5-.6-8-4.6-8-9V6l8-3z"/><path d="M9 12l2 2 4-4"/>',
            'truck'  => '<path d="M3 7h11v9H3z"/><path d="M14 10h4l3 3v3h-7"/><circle cx="7" cy="18" r="2"/><circle cx="17" cy="18" r="2"/>',
            'cap'    => '<path d="M2 9l10-4 10 4-10 4-10-4z"/><path d="M6 11v4c0 1.5 2.7 3 6 3s6-1.5 6-3v-4"/><path d="M22 9v5"/>',
            'wrench' => '<path d="M14.7 5.3a4 4 0 105.5 5.5L21 10l-2-2 1.5-1.5a3 3 0 00-4.5-1.5l-1.3 1.3-3 3-7.5 7.5a2.1 2.1 0 003 3l7.5-7.5"/>',
            'brain'  => '<path d="M9 6a3 3 0 016 0v1a3 3 0 013 3v1a3 3 0 01-1 2.2A3 3 0 0116 17a3 3 0 01-4-2v-1m0 0V7"/><path d="M12 14a3 3 0 11-3 3 3 3 0 01-3-3 3 3 0 01-1-2.2A3 3 0 016 7a3 3 0 013-3"/>',
            'spark'  => '<path d="M12 3v4M12 17v4M3 12h4M17 12h4M5.6 5.6l2.8 2.8M15.6 15.6l2.8 2.8M5.6 18.4l2.8-2.8M15.6 8.4l2.8-2.8"/>',
            'check'  => '<path d="M5 12.5l4.5 4.5L19 7.5"/>',
            'plus'   => '<path d="M12 5v14M5 12h14"/>',

            // Numbers & money
            'euro'      => '<path d="M18 7a6 6 0 100 10"/><path d="M4 10h10M4 14h10"/>',
            'chart'     => '<path d="M4 19V5M4 19h16"/><path d="M8 15v-4M12 15V9M16 15v-7"/>',
            'calendar'  => '<rect x="3.5" y="5" width="17" height="15" rx="2"/><path d="M8 3v4M16 3v4M3.5 10h17"/>',
            'percent'   => '<circle cx="7.5" cy="7.5" r="2.5"/><circle cx="16.5" cy="16.5" r="2.5"/><path d="M19 5L5 19"/>',
            'gauge'     => '<path d="M4 17a8 8 0 1116 0"/><path d="M12 17l4-5"/><circle cx="12" cy="17" r="1.2" fill="currentColor" stroke="none"/>',

            // Tech
            'wave'      => '<path d="M3 12c1.5-3 3-3 4.5 0s3 3 4.5 0 3-3 4.5 0 3 3 4.5 0"/>',
            'cpu'       => '<rect x="6" y="6" width="12" height="12" rx="1.5"/><rect x="9" y="9" width="6" height="6" rx="0.5"/><path d="M9 3v3M15 3v3M9 18v3M15 18v3M3 9h3M3 15h3M18 9h3M18 15h3"/>',
            'crosshair' => '<circle cx="12" cy="12" r="9"/><path d="M12 3v4M12 17v4M3 12h4M17 12h4"/><circle cx="12" cy="12" r="2.2"/>',
            'thermo'    => '<path d="M14 14V5a2 2 0 10-4 0v9a4 4 0 104 0z"/>',

            // Communication
            'phone' => '<path d="M5 4h3l1.5 4-2 1a11 11 0 005.5 5.5l1-2 4 1.5v3a2 2 0 01-2 2A14 14 0 013 6a2 2 0 012-2z"/>',
            'mail'  => '<rect x="3" y="5.5" width="18" height="13" rx="1.5"/><path d="M3.5 6.5L12 13l8.5-6.5"/>',
            'pin'   => '<path d="M12 21s7-6.5 7-12a7 7 0 10-14 0c0 5.5 7 12 7 12z"/><circle cx="12" cy="9" r="2.5"/>',
            'instagram' => '<rect x="3.5" y="3.5" width="17" height="17" rx="4.5"/><circle cx="12" cy="12" r="4"/><circle cx="17" cy="7" r="0.9" fill="currentColor" stroke="none"/>',

            // Decorative
            'sparkle'   => '<path d="M12 3l1.6 5.2L19 10l-5.4 1.8L12 17l-1.6-5.2L5 10l5.4-1.8L12 3z"/>',
            'star'      => '<path d="M12 3.5l2.6 5.5 6 .9-4.4 4.2 1 6-5.2-2.8-5.2 2.8 1-6L3.4 9.9l6-.9z"/>',
            'arrowRight'=> '<path d="M4 12h16M14 6l6 6-6 6"/>',
            'arrowDown' => '<path d="M12 4v16M6 14l6 6 6-6"/>',
            'flame'     => '<path d="M12 21c-4 0-7-2.7-7-6.5 0-3 1.8-4.8 3.5-6.2C10 7 11 5.5 11 3c2.5 1.5 4 4 4 6.5 0 1 .5 1.5 1.5 1.5 1 0 2-1 2-2.5 1.5 1.5 2.5 3.5 2.5 6 0 3.8-3 6.5-7 6.5z"/>',
            'cube'      => '<path d="M12 3l8 4.5v9L12 21 4 16.5v-9L12 3z"/><path d="M4 7.5L12 12l8-4.5M12 12v9"/>',
            'cooling'   => '<path d="M12 3v18M3 12h18M5.6 5.6l12.8 12.8M5.6 18.4l12.8-12.8"/>',
        ];

        $body = $paths[$name] ?? $paths['plus'];

        $extra = $class ? ' ' . htmlspecialchars($class) : '';

        return sprintf(
            '<svg class="ic ic--%s%s" width="%d" height="%d" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="%s" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">%s</svg>',
            htmlspecialchars($name),
            $extra,
            $size, $size,
            $stroke,
            $body
        );
    }
}

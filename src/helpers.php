<?php
/**
 * Global Helper Functions
 */

/**
 * Escapes HTML for safe output
 * 
 * @param string $text Raw text
 * @return string Escaped HTML
 */
function e(string $text): string
{
    return htmlspecialchars($text, ENT_QUOTES, 'UTF-8');
}

/**
 * Formats a date string into a "Time Ago" format
 * 
 * @param string $date_string MySQL format date string
 * @return string Relative time (e.g., "5 minutes ago")
 */
function format_date(string $date_string): string
{
    $time = strtotime($date_string);
    $diff = time() - $time;

    if ($diff < 1) {
        return 'just now';
    }

    $intervals = [
        31536000 => 'year',
        2592000  => 'month',
        604800   => 'week',
        86400    => 'day',
        3600     => 'hour',
        60       => 'minute',
        1        => 'second'
    ];

    foreach ($intervals as $secs => $label) {
        $div = $diff / $secs;

        if ($div >= 1) {
            $value = round($div);
            return $value . ' ' . $label . ($value > 1 ? 's' : '') . ' ago';
        }
    }

    return $date_string;
}

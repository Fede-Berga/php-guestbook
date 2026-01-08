<?php
/**
 * Security Helper Class
 */
class Security
{
    /**
     * Generates a CSRF token and stores it in the session
     * 
     * @return string
     */
    public static function generateCsrfToken(): string
    {
        if (empty($_SESSION['csrf_token'])) {
            $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
        }
        return $_SESSION['csrf_token'];
    }

    /**
     * Validates a CSRF token
     * 
     * @param string|null $token
     * @return bool
     */
    public static function validateCsrfToken(?string $token): bool
    {
        if (empty($_SESSION['csrf_token']) || empty($token)) {
            return false;
        }
        return hash_equals($_SESSION['csrf_token'], $token);
    }

    /**
     * Sets security headers
     */
    public static function setSecurityHeaders(): void
    {
        // Prevent Clickjacking
        header('X-Frame-Options: DENY');
        
        // Prevent MIME-type sniffing
        header('X-Content-Type-Options: nosniff');
        
        // Basic XSS Protection
        header('X-XSS-Protection: 1; mode=block');
        
        // Referrer Policy
        header('Referrer-Policy: strict-origin-when-cross-origin');
        
        // Content Security Policy (Basic)
        header("Content-Security-Policy: default-src 'self'; style-src 'self' 'unsafe-inline'; script-src 'self' 'unsafe-inline';");
    }

    /**
     * Sets secure session cookie parameters
     */
    public static function setSecureSessionConfig(): void
    {
        ini_set('session.cookie_httponly', 1);
        ini_set('session.use_only_cookies', 1);
        
        // Only set Secure flag if using HTTPS (we'll check for proxy or dev)
        $secure = isset($_SERVER['HTTPS']) || (isset($_SERVER['HTTP_X_FORWARDED_PROTO']) && $_SERVER['HTTP_X_FORWARDED_PROTO'] === 'https');
        
        session_set_cookie_params([
            'lifetime' => 0,
            'path' => '/',
            'domain' => '',
            'secure' => $secure,
            'httponly' => true,
            'samesite' => 'Strict'
        ]);
    }
}

<?php

/**
 * Laravel - Built-in server router (project public root: /app)
 */

$projectRoot = dirname(__DIR__);
$uri = urldecode(
    parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH)
);

// Always use landing page as the public root entrypoint.
if ($uri === '/' || $uri === '/index.html') {
    header('Location: /landing/index.html', true, 302);
    exit;
}

// Serve project-root static files directly (built-in server docroot can handle these).
if ($uri !== '/' && file_exists($projectRoot.$uri)) {
    return false;
}

// Serve app-local static files (e.g. /landing/*) explicitly.
if ($uri !== '/' && file_exists(__DIR__.$uri)) {
    $path = __DIR__.$uri;
    if (is_file($path)) {
        $ext = strtolower(pathinfo($path, PATHINFO_EXTENSION));
        $mimes = [
            'html' => 'text/html; charset=UTF-8',
            'css' => 'text/css; charset=UTF-8',
            'js' => 'application/javascript; charset=UTF-8',
            'json' => 'application/json; charset=UTF-8',
            'png' => 'image/png',
            'jpg' => 'image/jpeg',
            'jpeg' => 'image/jpeg',
            'gif' => 'image/gif',
            'svg' => 'image/svg+xml',
            'webp' => 'image/webp',
            'ico' => 'image/x-icon',
            'woff' => 'font/woff',
            'woff2' => 'font/woff2',
            'ttf' => 'font/ttf',
            'mp4' => 'video/mp4',
        ];
        if (isset($mimes[$ext])) {
            header('Content-Type: '.$mimes[$ext]);
        }
        readfile($path);
        return true;
    }
}

require_once __DIR__.'/index.php';

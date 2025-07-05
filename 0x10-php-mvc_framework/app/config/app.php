<?php
/**
 * Application Configuration File
 * 
 * This file contains the main configuration settings for the PHP MVC application.
 * It defines constants and settings that are used throughout the application,
 * including environment settings, security configurations, and application metadata.
 * 
 * @author Alpha Omollo
 */

// Prevent direct access to this file
if (!defined('APP_INIT')) {
    http_response_code(403);
    exit('Direct access forbidden');
}

return [
    /*
    |--------------------------------------------------------------------------
    | Application Environment
    |--------------------------------------------------------------------------
    |
    | This value determines the "environment" your application is currently
    | running in. This may determine how you prefer to configure various
    | services the application utilizes. Set this in your ".env" file.
    |
    */
    'env' => getenv('APP_ENV') ?: 'production',

    /*
    |--------------------------------------------------------------------------
    | Application Debug Mode
    |--------------------------------------------------------------------------
    |
    | When your application is in debug mode, detailed error messages with
    | stack traces will be shown on every error that occurs within your
    | application. If disabled, a simple generic error page is shown.
    |
    */
    'debug' => filter_var(getenv('APP_DEBUG') ?: false, FILTER_VALIDATE_BOOLEAN),

    /*
    |--------------------------------------------------------------------------
    | Application Name
    |--------------------------------------------------------------------------
    |
    | This value is the name of your application. This value is used when the
    | framework needs to place the application's name in a notification or
    | any other location as required by the application or its packages.
    |
    */
    'name' => getenv('APP_NAME') ?: 'PHP MVC Framework',

    /*
    |--------------------------------------------------------------------------
    | Application Version
    |--------------------------------------------------------------------------
    |
    | This value represents the version of your application. It's useful for
    | cache busting, API versioning, and displaying in the application footer.
    |
    */
    'version' => '1.0.0',

    /*
    |--------------------------------------------------------------------------
    | Application URL
    |--------------------------------------------------------------------------
    |
    | This URL is used by the console to properly generate URLs when using
    | the Artisan command line tool. You should set this to the root of
    | your application so that it is used when running Artisan tasks.
    |
    */
    'url' => getenv('APP_URL') ?: 'http://localhost',

    /*
    |--------------------------------------------------------------------------
    | Application Timezone
    |--------------------------------------------------------------------------
    |
    | Here you may specify the default timezone for your application, which
    | will be used by the PHP date and date-time functions. We have gone
    | ahead and set this to a sensible default for you out of the box.
    |
    */
    'timezone' => getenv('APP_TIMEZONE') ?: 'UTC',

    /*
    |--------------------------------------------------------------------------
    | Application Locale Configuration
    |--------------------------------------------------------------------------
    |
    | The application locale determines the default locale that will be used
    | by the translation service provider. You are free to set this value
    | to any of the locales which will be supported by the application.
    |
    */
    'locale' => getenv('APP_LOCALE') ?: 'en',

    /*
    |--------------------------------------------------------------------------
    | Application Fallback Locale
    |--------------------------------------------------------------------------
    |
    | The fallback locale determines the locale to use when the current one
    | is not available. You may change the value to correspond to any of
    | the language folders that are provided through your application.
    |
    */
    'fallback_locale' => 'en',

    /*
    |--------------------------------------------------------------------------
    | Encryption Key
    |--------------------------------------------------------------------------
    |
    | This key is used by the encryption service and should be set
    | to a random, 32 character string, otherwise these encrypted strings
    | will not be safe. Please do this before deploying an application!
    |
    */
    'key' => getenv('APP_KEY') ?: 'base64:your-32-character-secret-key-here',

    /*
    |--------------------------------------------------------------------------
    | Security Configuration
    |--------------------------------------------------------------------------
    |
    | These settings control various security aspects of the application
    | including CSRF protection, password hashing, and session security.
    |
    */
    'security' => [
        'csrf_protection' => true,
        'csrf_token_name' => 'csrf_token',
        'csrf_regenerate' => true,
        'password_algorithm' => PASSWORD_DEFAULT,
        'password_options' => [
            'cost' => 12,
        ],
        'session_name' => 'PHPMVC_SESS',
        'session_lifetime' => 120, // minutes
        'session_secure' => filter_var(getenv('SESSION_SECURE') ?: false, FILTER_VALIDATE_BOOLEAN),
        'session_httponly' => true,
        'session_samesite' => 'Lax',
    ],

    /*
    |--------------------------------------------------------------------------
    | Database Configuration
    |--------------------------------------------------------------------------
    |
    | Here you may specify which of the database connections below you wish
    | to use as your default connection for all database work.
    |
    */
    'database' => [
        'default' => getenv('DB_CONNECTION') ?: 'mysql',
        'fetch_mode' => PDO::FETCH_ASSOC,
        'charset' => 'utf8mb4',
        'collation' => 'utf8mb4_unicode_ci',
    ],

    /*
    |--------------------------------------------------------------------------
    | View Configuration
    |--------------------------------------------------------------------------
    |
    | Here you may specify the default view engine and related settings
    | for rendering views in your application.
    |
    */
    'view' => [
        'engine' => 'php', // Future: 'twig', 'smarty'
        'cache' => filter_var(getenv('VIEW_CACHE') ?: false, FILTER_VALIDATE_BOOLEAN),
        'cache_path' => 'storage/views',
        'default_layout' => 'layouts/app',
        'error_layout' => 'layouts/error',
    ],

    /*
    |--------------------------------------------------------------------------
    | Logging Configuration
    |--------------------------------------------------------------------------
    |
    | Here you may configure the log settings for your application. PHP MVC
    | supports various log handlers out of the box.
    |
    */
    'logging' => [
        'default' => getenv('LOG_CHANNEL') ?: 'file',
        'level' => getenv('LOG_LEVEL') ?: 'info',
        'path' => 'storage/logs',
        'max_files' => 10,
        'max_size' => '10MB',
        'format' => '[%datetime%] %level_name%: %message% %context%',
    ],

    /*
    |--------------------------------------------------------------------------
    | Cache Configuration
    |--------------------------------------------------------------------------
    |
    | Here you may specify the default cache driver and related settings
    | for caching data in your application.
    |
    */
    'cache' => [
        'default' => getenv('CACHE_DRIVER') ?: 'file',
        'ttl' => 3600, // seconds
        'path' => 'storage/cache',
        'prefix' => 'phpmvc_',
    ],

    /*
    |--------------------------------------------------------------------------
    | Mail Configuration
    |--------------------------------------------------------------------------
    |
    | Here you may specify the mail settings for your application including
    | SMTP configuration for sending emails.
    |
    */
    'mail' => [
        'driver' => getenv('MAIL_DRIVER') ?: 'smtp',
        'host' => getenv('MAIL_HOST') ?: 'localhost',
        'port' => getenv('MAIL_PORT') ?: 587,
        'username' => getenv('MAIL_USERNAME') ?: '',
        'password' => getenv('MAIL_PASSWORD') ?: '',
        'encryption' => getenv('MAIL_ENCRYPTION') ?: 'tls',
        'from' => [
            'address' => getenv('MAIL_FROM_ADDRESS') ?: 'hello@example.com',
            'name' => getenv('MAIL_FROM_NAME') ?: 'PHP MVC Framework',
        ],
    ],

    /*
    |--------------------------------------------------------------------------
    | File Upload Configuration
    |--------------------------------------------------------------------------
    |
    | Here you may specify the file upload settings including allowed
    | file types, maximum file size, and upload directory.
    |
    */
    'upload' => [
        'path' => 'public/uploads',
        'max_size' => 10 * 1024 * 1024, // 10MB in bytes
        'allowed_types' => [
            'image' => ['jpg', 'jpeg', 'png', 'gif', 'webp'],
            'document' => ['pdf', 'doc', 'docx', 'txt'],
            'archive' => ['zip', 'rar', '7z'],
        ],
        'create_thumbnails' => true,
        'thumbnail_sizes' => [
            'small' => [150, 150],
            'medium' => [300, 300],
            'large' => [600, 600],
        ],
    ],

    /*
    |--------------------------------------------------------------------------
    | Pagination Configuration
    |--------------------------------------------------------------------------
    |
    | Here you may specify the default pagination settings for your
    | application including items per page and pagination view.
    |
    */
    'pagination' => [
        'per_page' => 15,
        'max_per_page' => 100,
        'page_name' => 'page',
        'view' => 'partials/pagination',
    ],

    /*
    |--------------------------------------------------------------------------
    | API Configuration
    |--------------------------------------------------------------------------
    |
    | Here you may specify API-related settings including rate limiting,
    | authentication, and response formats.
    |
    */
    'api' => [
        'rate_limit' => [
            'max_requests' => 100,
            'window' => 3600, // seconds (1 hour)
        ],
        'default_format' => 'json',
        'version' => 'v1',
        'prefix' => 'api',
    ],

    /*
    |--------------------------------------------------------------------------
    | Error Handling Configuration
    |--------------------------------------------------------------------------
    |
    | Here you may configure how errors are handled in your application
    | including error reporting levels and custom error pages.
    |
    */
    'error' => [
        'report_level' => getenv('ERROR_REPORTING') ?: E_ALL,
        'display_errors' => filter_var(getenv('DISPLAY_ERRORS') ?: false, FILTER_VALIDATE_BOOLEAN),
        'log_errors' => true,
        'custom_pages' => [
            404 => 'errors/404',
            500 => 'errors/500',
            403 => 'errors/403',
        ],
    ],

    /*
    |--------------------------------------------------------------------------
    | Maintenance Mode
    |--------------------------------------------------------------------------
    |
    | When your application is in maintenance mode, a custom view will be
    | displayed for all requests. This is useful for performing updates.
    |
    */
    'maintenance' => [
        'enabled' => filter_var(getenv('MAINTENANCE_MODE') ?: false, FILTER_VALIDATE_BOOLEAN),
        'secret' => getenv('MAINTENANCE_SECRET') ?: 'secret-key',
        'template' => 'maintenance',
        'retry_after' => 3600, // seconds
    ],

    /*
    |--------------------------------------------------------------------------
    | Asset Configuration
    |--------------------------------------------------------------------------
    |
    | Here you may configure asset-related settings including versioning,
    | compression, and CDN settings.
    |
    */
    'assets' => [
        'version' => getenv('ASSET_VERSION') ?: '1.0.0',
        'minify' => filter_var(getenv('ASSET_MINIFY') ?: false, FILTER_VALIDATE_BOOLEAN),
        'cdn_url' => getenv('CDN_URL') ?: '',
        'cache_bust' => true,
    ],

    /*
    |--------------------------------------------------------------------------
    | Third-Party Services
    |--------------------------------------------------------------------------
    |
    | Here you may configure credentials for third-party services such as
    | payment gateways, social media APIs, and other external services.
    |
    */
    'services' => [
        'google' => [
            'analytics_id' => getenv('GOOGLE_ANALYTICS_ID') ?: '',
            'maps_api_key' => getenv('GOOGLE_MAPS_API_KEY') ?: '',
        ],
        'stripe' => [
            'public_key' => getenv('STRIPE_PUBLIC_KEY') ?: '',
            'secret_key' => getenv('STRIPE_SECRET_KEY') ?: '',
        ],
        'paypal' => [
            'client_id' => getenv('PAYPAL_CLIENT_ID') ?: '',
            'client_secret' => getenv('PAYPAL_CLIENT_SECRET') ?: '',
            'mode' => getenv('PAYPAL_MODE') ?: 'sandbox',
        ],
    ],

    /*
    |--------------------------------------------------------------------------
    | Feature Flags
    |--------------------------------------------------------------------------
    |
    | Here you may enable or disable specific features in your application
    | using feature flags. This is useful for gradual rollouts.
    |
    */
    'features' => [
        'user_registration' => filter_var(getenv('FEATURE_USER_REGISTRATION') ?: true, FILTER_VALIDATE_BOOLEAN),
        'email_verification' => filter_var(getenv('FEATURE_EMAIL_VERIFICATION') ?: false, FILTER_VALIDATE_BOOLEAN),
        'two_factor_auth' => filter_var(getenv('FEATURE_TWO_FACTOR_AUTH') ?: false, FILTER_VALIDATE_BOOLEAN),
        'api_access' => filter_var(getenv('FEATURE_API_ACCESS') ?: true, FILTER_VALIDATE_BOOLEAN),
        'file_uploads' => filter_var(getenv('FEATURE_FILE_UPLOADS') ?: true, FILTER_VALIDATE_BOOLEAN),
    ],
];

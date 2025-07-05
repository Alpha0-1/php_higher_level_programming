<?php
/**
 * Database Configuration File
 * 
 * This file contains the database connection settings for the PHP MVC application.
 * It supports multiple database connections and different database drivers.
 * The configuration uses environment variables for security and flexibility.
 * 
 * @author Software Engineering Student
 * @version 1.0
 */

// Prevent direct access to this file
if (!defined('APP_INIT')) {
    http_response_code(403);
    exit('Direct access forbidden');
}

return [
    /*
    |--------------------------------------------------------------------------
    | Default Database Connection Name
    |--------------------------------------------------------------------------
    |
    | Here you may specify which of the database connections below you wish
    | to use as your default connection for all database work. Of course
    | you may use many connections at once using the Database library.
    |
    */
    'default' => getenv('DB_CONNECTION') ?: 'mysql',

    /*
    |--------------------------------------------------------------------------
    | Database Connections
    |--------------------------------------------------------------------------
    |
    | Here are each of the database connections setup for your application.
    | Of course, examples of configuring each database platform that is
    | supported by Laravel is shown below to make development simple.
    |
    */
    'connections' => [
        /*
        |--------------------------------------------------------------------------
        | MySQL Database Connection
        |--------------------------------------------------------------------------
        |
        | MySQL is one of the most popular relational database management systems.
        | This configuration supports both MySQL and MariaDB databases.
        |
        */
        'mysql' => [
            'driver' => 'mysql',
            'host' => getenv('DB_HOST') ?: 'localhost',
            'port' => getenv('DB_PORT') ?: 3306,
            'database' => getenv('DB_DATABASE') ?: 'php_mvc_db',
            'username' => getenv('DB_USERNAME') ?: 'root',
            'password' => getenv('DB_PASSWORD') ?: '',
            'charset' => getenv('DB_CHARSET') ?: 'utf8mb4',
            'collation' => getenv('DB_COLLATION') ?: 'utf8mb4_unicode_ci',
            'prefix' => getenv('DB_PREFIX') ?: '',
            'strict' => filter_var(getenv('DB_STRICT_MODE') ?: true, FILTER_VALIDATE_BOOLEAN),
            'engine' => getenv('DB_ENGINE') ?: 'InnoDB',
            'timezone' => getenv('DB_TIMEZONE') ?: '+00:00',
            'options' => [
                PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
                PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
                PDO::ATTR_EMULATE_PREPARES => false,
                PDO::ATTR_PERSISTENT => false,
                PDO::MYSQL_ATTR_SSL_CA => getenv('DB_SSL_CA') ?: null,
                PDO::MYSQL_ATTR_SSL_VERIFY_SERVER_CERT => filter_var(getenv('DB_SSL_VERIFY') ?: false, FILTER_VALIDATE_BOOLEAN),
            ],
        ],

        /*
        |--------------------------------------------------------------------------
        | PostgreSQL Database Connection
        |--------------------------------------------------------------------------
        |
        | PostgreSQL is a powerful, open-source object-relational database system.
        | It has more than 15 years of active development and a proven architecture.
        |
        */
        'pgsql' => [
            'driver' => 'pgsql',
            'host' => getenv('DB_HOST') ?: 'localhost',
            'port' => getenv('DB_PORT') ?: 5432,
            'database' => getenv('DB_DATABASE') ?: 'php_mvc_db',
            'username' => getenv('DB_USERNAME') ?: 'postgres',
            'password' => getenv('DB_PASSWORD') ?: '',
            'charset' => getenv('DB_CHARSET') ?: 'utf8',
            'prefix' => getenv('DB_PREFIX') ?: '',
            'schema' => getenv('DB_SCHEMA') ?: 'public',
            'sslmode' => getenv('DB_SSLMODE') ?: 'prefer',
            'options' => [
                PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
                PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
                PDO::ATTR_EMULATE_PREPARES => false,
                PDO::ATTR_PERSISTENT => false,
            ],
        ],

        /*
        |--------------------------------------------------------------------------
        | SQLite Database Connection
        |--------------------------------------------------------------------------
        |
        | SQLite is a C library that provides a lightweight disk-based database.
        | It's useful for development, testing, and small applications.
        |
        */
        'sqlite' => [
            'driver' => 'sqlite',
            'database' => getenv('DB_DATABASE') ?: 'storage/database/database.sqlite',
            'prefix' => getenv('DB_PREFIX') ?: '',
            'foreign_key_constraints' => filter_var(getenv('DB_FOREIGN_KEYS') ?: true, FILTER_VALIDATE_BOOLEAN),
            'options' => [
                PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
                PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
                PDO::ATTR_EMULATE_PREPARES => false,
                PDO::ATTR_PERSISTENT => false,
            ],
        ],

        /*
        |--------------------------------------------------------------------------
        | SQL Server Database Connection
        |--------------------------------------------------------------------------
        |
        | Microsoft SQL Server is a relational database management system
        | developed by Microsoft. This configuration supports SQL Server connections.
        |
        */
        'sqlsrv' => [
            'driver' => 'sqlsrv',
            'host' => getenv('DB_HOST') ?: 'localhost',
            'port' => getenv('DB_PORT') ?: 1433,
            'database' => getenv('DB_DATABASE') ?: 'php_mvc_db',
            'username' => getenv('DB_USERNAME') ?: 'sa',
            'password' => getenv('DB_PASSWORD') ?: '',
            'charset' => getenv('DB_CHARSET') ?: 'utf8',
            'prefix' => getenv('DB_PREFIX') ?: '',
            'options' => [
                PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
                PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
                PDO::ATTR_EMULATE_PREPARES => false,
                PDO::ATTR_PERSISTENT => false,
            ],
        ],
    ],

    /*
    |--------------------------------------------------------------------------
    | Migration Repository Table
    |--------------------------------------------------------------------------
    |
    | This table keeps track of all the migrations that have already run for
    | your application. Using this information, we can determine which of
    | the migrations on disk haven't actually been run in the database.
    |
    */
    'migrations' => 'migrations',

    /*
    |--------------------------------------------------------------------------
    | Connection Pool Configuration
    |--------------------------------------------------------------------------
    |
    | Here you may configure connection pooling settings to optimize
    | database performance under high load conditions.
    |
    */
    'pool' => [
        'enabled' => filter_var(getenv('DB_POOL_ENABLED') ?: false, FILTER_VALIDATE_BOOLEAN),
        'max_connections' => (int) getenv('DB_POOL_MAX_CONNECTIONS') ?: 10,
        'min_connections' => (int) getenv('DB_POOL_MIN_CONNECTIONS') ?: 2,
        'idle_timeout' => (int) getenv('DB_POOL_IDLE_TIMEOUT') ?: 300, // seconds
        'max_lifetime' => (int) getenv('DB_POOL_MAX_LIFETIME') ?: 1800, // seconds
    ],

    /*
    |--------------------------------------------------------------------------
    | Query Logging Configuration
    |--------------------------------------------------------------------------
    |
    | Here you may configure query logging settings for debugging and
    | performance monitoring purposes.
    |
    */
    'logging' => [
        'enabled' => filter_var(getenv('DB_LOG_QUERIES') ?: false, FILTER_VALIDATE_BOOLEAN),
        'slow_query_threshold' => (float) getenv('DB_SLOW_QUERY_THRESHOLD') ?: 1.0, // seconds
        'log_all_queries' => filter_var(getenv('DB_LOG_ALL_QUERIES') ?: false, FILTER_VALIDATE_BOOLEAN),
        'log_file' => 'storage/logs/queries.log',
        'max_log_size' => '10MB',
    ],

    /*
    |--------------------------------------------------------------------------
    | Cache Configuration
    |--------------------------------------------------------------------------
    |
    | Here you may configure database query caching settings to improve
    | application performance by reducing database load.
    |
    */
    'cache' => [
        'enabled' => filter_var(getenv('DB_CACHE_ENABLED') ?: false, FILTER_VALIDATE_BOOLEAN),
        'driver' => getenv('DB_CACHE_DRIVER') ?: 'file',
        'ttl' => (int) getenv('DB_CACHE_TTL') ?: 3600, // seconds
        'prefix' => getenv('DB_CACHE_PREFIX') ?: 'db_cache_',
        'tags' => filter_var(getenv('DB_CACHE_TAGS') ?: false, FILTER_VALIDATE_BOOLEAN),
    ],

    /*
    |--------------------------------------------------------------------------
    | Transaction Configuration
    |--------------------------------------------------------------------------
    |
    | Here you may configure transaction-related settings including
    | isolation levels and automatic rollback behavior.
    |
    */
    'transactions' => [
        'isolation_level' => getenv('DB_ISOLATION_LEVEL') ?: 'READ_COMMITTED',
        'auto_rollback' => filter_var(getenv('DB_AUTO_ROLLBACK') ?: true, FILTER_VALIDATE_BOOLEAN),
        'max_retries' => (int) getenv('DB_MAX_RETRIES') ?: 3,
        'retry_delay' => (int) getenv('DB_RETRY_DELAY') ?: 100, // milliseconds
    ],

    /*
    |--------------------------------------------------------------------------
    | Database Seeding Configuration
    |--------------------------------------------------------------------------
    |
    | Here you may configure database seeding settings for populating
    | your database with test data during development.
    |
    */
    'seeding' => [
        'enabled' => filter_var(getenv('DB_SEEDING_ENABLED') ?: false, FILTER_VALIDATE_BOOLEAN),
        'truncate_before_seed' => filter_var(getenv('DB_TRUNCATE_BEFORE_SEED') ?: true, FILTER_VALIDATE_BOOLEAN),
        'seed_path' => 'database/seeds',
        'factories_path' => 'database/factories',
    ],

    /*
    |--------------------------------------------------------------------------
    | Backup Configuration
    |--------------------------------------------------------------------------
    |
    | Here you may configure database backup settings including
    | automatic backups and backup retention policies.
    |
    */
    'backup' => [
        'enabled' => filter_var(getenv('DB_BACKUP_ENABLED') ?: false, FILTER_VALIDATE_BOOLEAN),
        'path' => getenv('DB_BACKUP_PATH') ?: 'storage/backups',
        'frequency' => getenv('DB_BACKUP_FREQUENCY') ?: 'daily', // daily, weekly, monthly
        'retention_days' => (int) getenv('DB_BACKUP_RETENTION_DAYS') ?: 30,
        'compression' => filter_var(getenv('DB_BACKUP_COMPRESSION') ?: true, FILTER_VALIDATE_BOOLEAN),
        'include_data' => filter_var(getenv('DB_BACKUP_INCLUDE_DATA') ?: true, FILTER_VALIDATE_BOOLEAN),
    ],

    /*
    |--------------------------------------------------------------------------
    | Performance Monitoring
    |--------------------------------------------------------------------------
    |
    | Here you may configure database performance monitoring settings
    | to track and optimize database performance.
    |
    */
    'monitoring' => [
        'enabled' => filter_var(getenv('DB_MONITORING_ENABLED') ?: false, FILTER_VALIDATE_BOOLEAN),
        'slow_query_alert' => (float) getenv('DB_SLOW_QUERY_ALERT') ?: 2.0, // seconds
        'connection_timeout_alert' => (int) getenv('DB_CONNECTION_TIMEOUT_ALERT') ?: 30, // seconds
        'max_connections_alert' => (int) getenv('DB_MAX_CONNECTIONS_ALERT') ?: 80, // percentage
        'disk_space_alert' => (int) getenv('DB_DISK_SPACE_ALERT') ?: 90, // percentage
    ],

    /*
    |--------------------------------------------------------------------------
    | Read/Write Splitting
    |--------------------------------------------------------------------------
    |
    | Here you may configure read/write splitting to distribute database
    | load across multiple servers for better performance.
    |
    */
    'read_write_splitting' => [
        'enabled' => filter_var(getenv('DB_READ_WRITE_SPLITTING') ?: false, FILTER_VALIDATE_BOOLEAN),
        'write_connection' => getenv('DB_WRITE_CONNECTION') ?: 'mysql',
        'read_connections' => [
            'read1' => [
                'host' => getenv('DB_READ1_HOST') ?: 'localhost',
                'weight' => (int) getenv('DB_READ1_WEIGHT') ?: 1,
            ],
            'read2' => [
                'host' => getenv('DB_READ2_HOST') ?: 'localhost',
                'weight' => (int) getenv('DB_READ2_WEIGHT') ?: 1,
            ],
        ],
        'sticky_reads' => filter_var(getenv('DB_STICKY_READS') ?: false, FILTER_VALIDATE_BOOLEAN),
    ],
];

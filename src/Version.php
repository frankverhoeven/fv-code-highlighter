<?php

declare(strict_types=1);

namespace FvCodeHighlighter;

use FvCodeHighlighter;

final class Version
{
    const API_VERSION_CURRENT = 'https://api.frankverhoeven.me/fvch/1.0/versions/latest';

    /** @var string */
    private static $currentVersion;

    /** @var string */
    private static $latestVersion;

    public static function getCurrentVersion(): string
    {
        if (self::$currentVersion === null) {
            require_once \ABSPATH . 'wp-admin/includes/plugin.php';
            $reflection = new \ReflectionClass(FvCodeHighlighter::class);

            self::$currentVersion = \get_plugin_data($reflection->getFileName())['Version'];
        }

        return self::$currentVersion;
    }

    public static function getLatestVersion(): string
    {
        if (self::$latestVersion === null) {
            $response = \wp_remote_get(self::API_VERSION_CURRENT, [
                'body' => [
                    'blog_name'         => \get_bloginfo('name'),
                    'blog_description'  => \get_bloginfo('description'),
                    'blog_url'          => \get_bloginfo('url'),
                    'wordpress_url'     => \get_bloginfo('wpurl'),
                    'wordpress_version' => $GLOBALS['wp_version'],
                    'plugin_version'    => self::getCurrentVersion(),
                    'php_version'       => \phpversion(),
                ],
            ]);

            if (\is_array($response) && $response['response']['code'] === 200) {
                self::$latestVersion = \json_decode($response['body'], true)['version'];
            }
        }

        return self::$latestVersion;
    }
}

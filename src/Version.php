<?php

declare(strict_types=1);

namespace FvCodeHighlighter;

use FvCodeHighlighter;

/**
 * Version
 *
 * @author Frank Verhoeven <hi@frankverhoeven.me>
 */
final class Version
{
    /**
     * @var string
     */
    const API_VERSION_CURRENT = 'https://api.frankverhoeven.me/fvch/1.0/versions/latest';

    /**
     * @var string
     */
    private static $currentVersion;

    /**
     * @var string
     */
    private static $latestVersion;

    /**
     * Get the current plugin version.
     *
     * @return string
     */
    public static function getCurrentVersion(): string
    {
        if (null === self::$currentVersion) {
            require_once ABSPATH . 'wp-admin/includes/plugin.php';
            $reflection = new \ReflectionClass(FvCodeHighlighter::class);
            $data = \get_plugin_data($reflection->getFileName());
            self::$currentVersion = $data['Version'];
        }

        return self::$currentVersion;
    }

    /**
     * Fetch the latest version from the api
     *
     * @return string
     */
    public static function getLatestVersion(): string
    {
        global $wp_version;

        if (null === self::$latestVersion) {
            $response = \wp_remote_get(self::API_VERSION_CURRENT, [
                'body' => [
                    'blog_name'         => \get_bloginfo('name'),
                    'blog_description'  => \get_bloginfo('description'),
                    'blog_url'          => \get_bloginfo('url'),
                    'wordpress_url'     => \get_bloginfo('wpurl'),
                    'wordpress_version' => $wp_version,
                    'plugin_version'    => self::getCurrentVersion(),
                    'php_version'       => \phpversion(),
                ],
            ]);

            if (\is_array($response) && 200 == $response['response']['code']) {
                $data = \json_decode($response['body'], true);
                self::$latestVersion = $data['version'];
            }
        }

        return self::$latestVersion;
    }
}

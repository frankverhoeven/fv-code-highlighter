<?php

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
    const CURRENT_VERSION = FvCodeHighlighter::VERSION;
    /**
     * @var string
     */
    const API_VERSION_CURRENT = 'https://api.frankverhoeven.me/fvch/1.0/versions/current';
    /**
     * @var string
     */
    private static $latestVersion = null;

    /**
     * Get the current plugin version.
     *
     * @return string
     */
    public static function getCurrentVersion()
    {
        return self::CURRENT_VERSION;
    }

    /**
     * Fetch the latest version from the api
     *
     * @return string
     */
    public static function getLatestVersion()
    {
        global $wp_version;

        if (null === self::$latestVersion) {
            $response = wp_remote_get(self::API_VERSION_CURRENT, [
                'body' => [
                    'blog_name'         => get_bloginfo('name'),
                    'blog_description'  => get_bloginfo('description'),
                    'blog_url'          => get_bloginfo('url'),
                    'wordpress_url'     => get_bloginfo('wpurl'),
                    'wordpress_version' => $wp_version,
                    'plugin_version'    => self::getCurrentVersion(),
                    'php_version'       => phpversion(),
                ],
            ]);

            if (is_array($response) && 200 == $response['response']['code']) {
                $data = json_decode($response['body'], true);
                self::$latestVersion = $data['version'];
            }
        }

        return self::$latestVersion;
    }
}

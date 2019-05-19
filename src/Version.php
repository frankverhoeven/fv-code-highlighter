<?php

declare(strict_types=1);

namespace FvCodeHighlighter;

use FvCodeHighlighter\Diagnostics\Api\Data;
use FvCodeHighlighter\Diagnostics\Api\Method;
use FvCodeHighlighter\Diagnostics\Api\Request;
use FvCodeHighlighter\Diagnostics\Api\Url;

final class Version
{
    /** @var string */
    private static $currentVersion;

    /** @var string */
    private static $latestVersion;

    /**
     * Get the current plugin version.
     */
    public static function getCurrentVersion(): string
    {
        if (self::$currentVersion === null) {
            require_once \ABSPATH . 'wp-admin/includes/plugin.php';
            $reflection           = new \ReflectionClass(FvCodeHighlighter::class);
            $data                 = \get_plugin_data($reflection->getFileName());
            self::$currentVersion = $data['Version'];
        }

        return self::$currentVersion;
    }

    /**
     * Fetch the latest version from the api
     */
    public static function getLatestVersion(): string
    {
        if (self::$latestVersion === null) {
            try {
                $response = (new Request(Url::latestVersion(), Method::get()))
                    ->sendRequest(Data::version());
            } catch (\RuntimeException $exception) {
                return self::getCurrentVersion();
            }

            self::$latestVersion = $response->parsedBody()['version'];
        }

        return self::$latestVersion;
    }
}

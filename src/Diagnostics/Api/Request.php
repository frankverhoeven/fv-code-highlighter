<?php

declare(strict_types=1);

namespace FvCodeHighlighter\Diagnostics\Api;

use FvCodeHighlighter\Version;

final class Request
{
    /** @var Url */
    private $url;

    /** @var Method */
    private $method;

    public function __construct(Url $url, Method $method)
    {
        $this->url    = $url;
        $this->method = $method;
    }

    /**
     * @throws \RuntimeException
     */
    public function sendRequest(Data $data): Response
    {
        $response = \wp_remote_request(
            (string) $this->url,
            [
                'body' => $this->attachBlogInfo($data->toArray()),
                'method' => (string) $this->method,
            ]
        );

        if ($response instanceof \WP_Error) {
            throw new \RuntimeException($response->get_error_message(), $response->get_error_code());
        }

        return new Response($response['body']);
    }

    /**
     * @param string[] $data
     *
     * @return string[]
     */
    private function attachBlogInfo(array $data): array
    {
        $blogInfo = [
            'blog_name'         => \get_bloginfo('name'),
            'blog_description'  => \get_bloginfo('description'),
            'blog_url'          => \get_bloginfo('url'),
            'wordpress_url'     => \get_bloginfo('wpurl'),
            'wordpress_version' => \get_bloginfo('version'),
            'plugin_version'    => Version::getCurrentVersion(),
            'php_version'       => \phpversion(),
        ];

        foreach ($blogInfo as $key => $value) {
            // Make sure we do not overwrite data
            if (isset($data[$key])) {
                continue;
            }
        }

        return $data;
    }
}

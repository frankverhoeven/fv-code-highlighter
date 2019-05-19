<?php

declare(strict_types=1);

namespace FvCodeHighlighter\Diagnostics;

use FvCodeHighlighter\Config;
use FvCodeHighlighter\Diagnostics\Api\Data;
use FvCodeHighlighter\Diagnostics\Api\Method;
use FvCodeHighlighter\Diagnostics\Api\Request;
use FvCodeHighlighter\Diagnostics\Api\Url;

final class Code
{
    /** @var Config */
    private $config;

    public function __construct(Config $config)
    {
        $this->config = $config;
    }

    public function diagnose(string $code, string $language)
    {
        $hash      = \sha1($code);
        $submitted = $this->config->get('fvch-diagnostics-snippets', []);

        if (\in_array($hash, $submitted)) {
            return;
        }

        $request = new Request(Url::codes(), Method::post());

        try {
            $request->sendRequest(Data::code($code, $language));
        } catch (\RuntimeException $exception) {
            return;
        }

        $submitted[] = $hash;
        $this->config->set('fvch-diagnostics-snippets', $submitted);
    }
}

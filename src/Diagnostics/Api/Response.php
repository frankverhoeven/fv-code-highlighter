<?php

declare(strict_types=1);

namespace FvCodeHighlighter\Diagnostics\Api;

final class Response
{
    /** @var string */
    private $body;

    public function __construct(string $body)
    {
        $this->body = $body;
    }

    public function body(): string
    {
        return $this->body;
    }

    /**
     * @return mixed[]
     */
    public function parsedBody(): array
    {
        return \json_decode($this->body, true);
    }
}

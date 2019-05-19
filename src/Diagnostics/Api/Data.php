<?php

declare(strict_types=1);

namespace FvCodeHighlighter\Diagnostics\Api;

final class Data
{
    /** @var string[] */
    private $data;

    /**
     * @param string[] $data
     */
    private function __construct(array $data)
    {
        $this->data = $data;
    }

    public static function code(string $code, string $language): self
    {
        return new self(
            [
                'code' => $code,
                'language' => $language,
            ]
        );
    }

    public static function exception(
        string $exception,
        string $message,
        string $trace
    ): self {
        return new self(
            [
                'exception' => $exception,
                'message'   => $message,
                'trace'     => $trace,
            ]
        );
    }

    public static function version(): self
    {
        return new self([]);
    }

    /**
     * @return string[]
     */
    public function toArray(): array
    {
        return $this->data;
    }
}

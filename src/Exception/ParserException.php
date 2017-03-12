<?php
declare(strict_types = 1);

namespace EPS\PhpUri\Exception;

class ParserException extends \LogicException
{
    public static function cannotParseUrl(string $url, \Throwable $previous = null)
    {
        $message = "Cannot parse string as URI: $url";
        $code = 1;
        return new self($message, $code, $previous);
    }
}

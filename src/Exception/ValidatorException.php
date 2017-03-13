<?php
declare(strict_types = 1);

namespace EPS\PhpUri\Exception;

class ValidatorException extends \LogicException
{
    public static function validationFailed(string $inputUri, \Throwable $previous = null): self
    {
        $message = "URI validation failed for string $inputUri";
        if ($previous !== null) {
            $message .= ": {$previous->getMessage()}";
        }
        $code = 2;

        return new self($message, $code, $previous);
    }

    public static function invalidScheme(string $uri, \Throwable $previous = null): self
    {
        $message = "Invalid scheme in $uri";
        $code = 3;

        return new self($message, $code, $previous);
    }

    public static function invalidAuthority(string $uri, \Throwable $previous = null): self
    {
        $message = "Invalid authority in $uri";
        $code = 3;

        return new self($message, $code, $previous);
    }

    public static function invalidPath(string $uri, \Throwable $previous = null): self
    {
        $message = "Invalid path in $uri";
        $code = 4;

        return new self($message, $code, $previous);
    }

    public static function invalidQuery($uri, \Throwable $previous = null): self
    {
        $message = "Invalid query in $uri";
        $code = 5;

        return new self($message, $code, $previous);
    }
}

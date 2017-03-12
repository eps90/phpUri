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
}

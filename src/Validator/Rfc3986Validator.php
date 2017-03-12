<?php
declare(strict_types = 1);

namespace EPS\PhpUri\Validator;

use EPS\PhpUri\Validator\Patterns\Rfc3986;

final class Rfc3986Validator implements Validator
{
    /**
     * {@inheritdoc}
     */
    public function validate(string $uriCandidate): bool
    {
        if (!preg_match(Rfc3986::URI_UNPACK_PATTERN, $uriCandidate, $matches)) {
            return false;
        }

        $authorityPart = $matches[4];
        $path = $matches[5];
        $query = $matches[7] ?? '';
        $fragment = $matches[9] ?? '';
        if (
            !(
                $this->validateAuthorityPart($authorityPart)
                && $this->validatePath($path)
                && $this->simpleValidate($query)
                && $this->simpleValidate($fragment)
            )
        ) {
            return false;
        }

        return true;
    }

    private function validateAuthorityPart(string $authorityPart): bool
    {
        if (!empty($authorityPart)) {
            $authorityPartRegex =  '/' . Rfc3986::AUTHORITY . '/';
            $authorityResult = preg_match($authorityPartRegex, $authorityPart, $matches) > 0;
            $noSpaces = strpos($authorityPart, ' ') === false;
            return $noSpaces && $authorityResult;
        }

        return true;
    }

    private function validatePath(string $path)
    {
        if (!empty($path)) {
            $pathRegex = '/' . Rfc3986::PATH . '/';
            $pathResult = preg_match($pathRegex, $path) > 0;
            $noSpaces = strpos($path, ' ') === false;
            return $pathResult && $noSpaces;
        }

        return true;
    }

    private function simpleValidate(string $pathPart): bool
    {
        if (!empty($pathPart)) {
            $regex = '/[\ \t\n]+/';
            return preg_match($regex, $pathPart, $matches) === 0;
        }

        return true;
    }
}

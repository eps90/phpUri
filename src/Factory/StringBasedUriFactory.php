<?php
declare(strict_types = 1);

namespace EPS\PhpUri\Factory;

use EPS\PhpUri\Parser\Parser;
use EPS\PhpUri\Uri;
use EPS\PhpUri\Validator\Validator;

final class StringBasedUriFactory implements UriFactory
{
    /**
     * @var Validator
     */
    private $validator;

    /**
     * @var Parser
     */
    private $parser;

    /**
     * StringBasedUriFactory constructor.
     * @param Validator $validator
     * @param Parser $parser
     */
    public function __construct(Validator $validator, Parser $parser)
    {
        $this->validator = $validator;
        $this->parser = $parser;
    }

    /**
     * {@inheritdoc}
     */
    public function createUri($uriCandidate): Uri
    {
        $this->validateInput($uriCandidate);
        $this->validator->validate($uriCandidate);
        return $this->parser->parseUri($uriCandidate);
    }

    private function validateInput($uriCandidate): void
    {
        if (!is_string($uriCandidate)) {
            throw new \InvalidArgumentException('Input URI must be a string');
        }
    }
}

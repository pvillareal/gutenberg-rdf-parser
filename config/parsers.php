<?php

use Gutenberg\Parser\Enums\Parser;
use Gutenberg\Parser\GutenbergRDFParser;
use Gutenberg\Parser\TermsParser;

return [
    Parser::TERMS->value => DI\factory(TermsParser::class),
    Parser::RDF->value => DI\factory(GutenbergRDFParser::class)
];
<?php

namespace Spatie\LaravelMarkdown\Tests\Stubs;

use League\CommonMark\Extension\CommonMark\Node\Inline\HtmlInline;
use League\CommonMark\Parser\Inline\InlineParserMatch;
use League\CommonMark\Parser\InlineParserContext;

class CustomInlineParser implements \League\CommonMark\Parser\Inline\InlineParserInterface
{
    public const REPLACE = "THIS-REPLACED-THE-SYMBOL";

    public function getMatchDefinition(): InlineParserMatch
    {
        return InlineParserMatch::string('@');
    }

    public function parse(InlineParserContext $inlineContext): bool
    {
        $cursor = $inlineContext->getCursor();
        $cursor->advanceBy($inlineContext->getFullMatchLength());
        $inlineContext->getContainer()->appendChild(new HtmlInline(self::REPLACE));

        return true;
    }
}

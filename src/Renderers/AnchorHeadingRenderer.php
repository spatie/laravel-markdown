<?php

namespace Spatie\LaravelMarkdown\Renderers;

use Illuminate\Support\Str;
use League\CommonMark\Extension\CommonMark\Node\Block\Heading;
use League\CommonMark\Node\Node;
use League\CommonMark\Renderer\ChildNodeRendererInterface;
use League\CommonMark\Renderer\NodeRendererInterface;
use League\CommonMark\Util\HtmlElement;

class AnchorHeadingRenderer implements NodeRendererInterface
{
    /**
     * @param Node|Heading $node
     */
    public function render(Node $node, ChildNodeRendererInterface $childRenderer)
    {
        $element = $this->createElement($node, $childRenderer);

        $id = Str::slug($element->getContents());

        $element->setAttribute('id', $id);

        return $element;
    }

    /**
     * @param Node|Heading $node
     */
    protected function createElement(Node $node, ChildNodeRendererInterface $childRenderer): HtmlElement
    {
        $tagName = "h{$node->getLevel()}";

        $attrs = $node->data->get('attributes', []);

        return new HtmlElement($tagName, $attrs, $childRenderer->renderNodes($node->children()));
    }
}

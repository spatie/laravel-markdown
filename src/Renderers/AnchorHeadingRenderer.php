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
    public function __construct(
        protected bool $renderAnchorsAsLinks = false,
    ) {
    }

    /**
     * @param Node|Heading $node
     */
    public function render(Node $node, ChildNodeRendererInterface $childRenderer)
    {
        $element = $this->createElement($node, $childRenderer);

        $id = Str::slug($element->getContents());

        if (! $this->renderAnchorsAsLinks) {
            $element->setAttribute('id', $id);

            return $element;
        }

        return new HtmlElement(
            'a',
            ['href' => "#{$id}"],
            "<h{$node->getLevel()} id='{$id}'>{$element->getContents()}</h{$node->getLevel()}>"
        );
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

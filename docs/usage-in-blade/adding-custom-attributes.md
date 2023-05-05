The markdown given to the `x-markdown` component will be converted by the class specified in the `renderer_class` value of the `markdown` config file.

You can change this value to a class of your own. We highlight recommend that your class extends the default `Spatie\LaravelMarkdown\MarkdownRenderer` class. This default class is organised using easy to override methods.

Here's an example. If you want to customize the environment of the league/commonmark package that is used under the hood, override the `configureCommonMarkEnvironment` method.

```php
use League\CommonMark\ConfigurableEnvironmentInterface;use Spatie\LaravelMarkdown\MarkdownRenderer;

class MyCustomRenderer extends MarkdownRenderer
{
    public function configureCommonMarkEnvironment(ConfigurableEnvironmentInterface $environment) : void
    {
        parent::configureCommonMarkEnvironment($environment);
        
        // customize the `$environment` here.
    }
}
```

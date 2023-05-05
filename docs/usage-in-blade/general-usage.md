---
title: General usage
weight: 1
---

Use the `x-markdown` Blade component to render markdown to HTML.

This chunk of markdown...

````blade
<x-markdown>
# My title

This is a [link to our website](https://spatie.be)

```php
echo 'Hello world';
```
</x-markdown>
````

... will be converted to this chunk of HTML:

```html
<div>
    <h1 id="my-title">My title</h1>
    <p>This is a <a href="https://spatie.be">link to our website</a></p>
    <pre class="shiki" style="background-color: #fff"><code><span class="line"><span
        style="color: #005CC5">echo</span><span style="color: #24292E"> </span><span style="color: #032F62">&#39;Hello world&#39;</span><span
        style="color: #24292E">;</span></span>
<span class="line"></span></code></pre>
</div>
```

*Note:* If you're outputting the Markdown through blade, rather than direct input, you will need to use the unescaped blade statement to prevent Laravel's XSS protection stripping the tags:

```blade
{!! $article->content !!}
```

## The Blade directive

Alternatively, you could use the `@markdown` Blade directive to render markdown to HTML.

This chunk of markdown...

 ````blade
 @markdown
 # My title
 This is a [link to our website](https://spatie.be)
 ```php
 echo 'Hello world';
 ```
 @endmarkdown
 ````

... will be converted to this chunk of HTML:

 ```html
 <div>
     <h1 id="my-title">My title</h1>
     <p>This is a <a href="https://spatie.be">link to our website</a></p>
     <pre class="shiki" style="background-color: #fff"><code><span class="line"><span
         style="color: #005CC5">echo</span><span style="color: #24292E"> </span><span style="color: #032F62">&#39;Hello world&#39;</span><span
         style="color: #24292E">;</span></span>
 <span class="line"></span></code></pre>
 </div>
 ```

You can also use variables or strings as argument

 ```blade
 @markdown($article->content)
 @markdown('[link to our website](https://spatie.be)')
 ```

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

If you are rendering dynamic content, you need to pass it unescaped to the component, or block quote rendering will not work. Do not worry, in the standard configuration, any HTML or unsafe links will be removed.

```blade
<x-markdown>{!!$unescaped_content!!}</x-markdown>
```

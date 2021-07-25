---
title: Passing options to Commonmark
weight: 8
---

Under the hood, the `league/commonmark` package is used to render markdown. In the `commonmark_options` key of the `markdown` config file, you can pass any of the options mentioned in [the league/commonmark docs](https://commonmark.thephpleague.com/1.6/configuration/).

If you want to pass options to be used by a particular instance of `x-markdown`, you can pass options to the `options` attribute.

```html
<x-markdown :options="['commonmark' => ['enable_strong' => false]]">
# My title
</x-markdown>
```

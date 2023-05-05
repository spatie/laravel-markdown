---
title: Rendering anchors
weight: 3
---

By default, the component will add anchors to all headings in the rendered HTML. To disable this behaviour, you can set the `add_anchors_to_headings` config value in the the `markdown`  config file to `false`.

If you don't want to render anchors for a particular instance of `x-markdown`, pass `false` to the `anchors` attribute.

```html
<x-markdown :anchors="false">
# My title
</x-markdown>
```

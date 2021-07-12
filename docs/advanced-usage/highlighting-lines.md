---
title: Highlighting lines
weight: 1
---

When starting a code block, you can mark lines as highlighted, added, deleted and focus

Certain options can be used when rendering code block.

```md
```php{1,2}{3}
<?php
echo "We're highlighting line 1 and 2";
echo "And focusing line 3";
```

To know more about the feature, head over [the docs of the underlying spatie/commonmark-shiki-highlighter package](https://github.com/spatie/commonmark-shiki-highlighter#marking-lines-as-highlighted-added-deleted-and-focus).

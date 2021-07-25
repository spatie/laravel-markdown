---
title: Security & HTML Escaping
weight: 9
---

By default, we assume that you are using this component to render user-supplied content.

To prevent reflected cross-site-scripting attacks which can be caused by the user adding script tags or javascript links, all HTML elements and unsafe links will be stripped from your markdown and not rendered.

If you are supplying the markdown yourself and know what you are doing, you can disable this behaviour either in the config or by passing the corresponding options to the blade component:

```blade
<x-markdown allowHTML="true" allowUnsafeLinks="true">
I actually want to render some HTML supplied by myself:
<table style="width:100%">
 <tr>
   <th>Firstname</th>
   <th>Lastname</th>
   <th>Age</th>
 </tr>
 <tr>
   <td>Jill</td>
   <td>Smith</td>
   <td>50</td>
 </tr>
 <tr>
   <td>Eve</td>
   <td>Jackson</td>
   <td>94</td>
 </tr>
</table>
[Alert me!](javascript:window.alert('hello!'))
</x-markdown>
```

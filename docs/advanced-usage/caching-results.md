---
title: Caching results
weight: 2
---

Code highlighting is a resource intensive process. That's why the component ships with caching out of the box. By default, the component uses the default cache store.

To configure the store to use, or to disable caching, change the value of the `cache_store` param in the `markdown` config file. Caching is enabled by default.

Additionally, you can set the duration for how long the results are stored in the cache
by setting the `cache_duration` param in the `markdown` config file. By default the
results will be cached forever if caching is enabled.

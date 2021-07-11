<?php

return [
    /*
     * Rendering markdown to HTML can be resource intensive. By default
     * the markdown component caches its results.
     *
     * You can specify the name of a cache store here. When set to `null`
     * the default cache store will be used. If you do not want to use
     * caching set this value to `false`.
     */
    'cache_store' => null,

    'code_highlighting' => [
        /*
         * To highlight code, we'll use Shiki under the hood. Make sure it's installed.
         *
         * More info: TODO: add link
         */
        'enabled' => true,

        /*
         * The name of or path to a Shiki theme
         *
         * More info: TODO: add link
         */
        'theme' => 'github-light',
    ],


];

# Changelog

All notable changes to `laravel-markdown` will be documented in this file.

## 2.3.1 - 2023-05-05

### What's Changed

- Support embeds class names for config serialization by @erikn69 in https://github.com/spatie/laravel-markdown/pull/54

**Full Changelog**: https://github.com/spatie/laravel-markdown/compare/2.3.0...2.3.1

## 2.3.0 - 2023-05-03

### What's Changed

- Update commonmark links by @erikn69 in https://github.com/spatie/laravel-markdown/pull/55
- Fix badges by @erikn69 in https://github.com/spatie/laravel-markdown/pull/57
- Add blade directive by @erikn69 in https://github.com/spatie/laravel-markdown/pull/56

**Full Changelog**: https://github.com/spatie/laravel-markdown/compare/2.2.7...2.3.0

## 2.2.7 - 2023-04-28

### What's Changed

- Support class names for config serialization by @erikn69 in https://github.com/spatie/laravel-markdown/pull/53

**Full Changelog**: https://github.com/spatie/laravel-markdown/compare/2.2.6...2.2.7

## 2.2.6 - 2023-01-25

- support L10

## 2.2.5 - 2022-12-29

### What's Changed

- Change package name in Docs by @nessimabadi in https://github.com/spatie/laravel-markdown/pull/38
- Update class for extending MarkdownRender by @Raimomo in https://github.com/spatie/laravel-markdown/pull/39
- Refactor tests to pest by @AyoobMH in https://github.com/spatie/laravel-markdown/pull/46
- Update MarkdownServiceProvider.php by @neomasterr in https://github.com/spatie/laravel-markdown/pull/49

### New Contributors

- @nessimabadi made their first contribution in https://github.com/spatie/laravel-markdown/pull/38
- @Raimomo made their first contribution in https://github.com/spatie/laravel-markdown/pull/39
- @AyoobMH made their first contribution in https://github.com/spatie/laravel-markdown/pull/46
- @neomasterr made their first contribution in https://github.com/spatie/laravel-markdown/pull/49

**Full Changelog**: https://github.com/spatie/laravel-markdown/compare/2.2.4...2.2.5

## 2.2.4 - 2022-05-21

## What's Changed

- MarkdownBladeComponent missing inline parsers by @MortenDHansen in https://github.com/spatie/laravel-markdown/pull/37

**Full Changelog**: https://github.com/spatie/laravel-markdown/compare/2.2.3...2.2.4

## 2.2.3 - 2022-05-11

## What's Changed

- Adding inline parsers by @MortenDHansen in https://github.com/spatie/laravel-markdown/pull/36

## New Contributors

- @MortenDHansen made their first contribution in https://github.com/spatie/laravel-markdown/pull/36

**Full Changelog**: https://github.com/spatie/laravel-markdown/compare/2.2.2...2.2.3

## 2.2.2 - 2022-03-08

## What's Changed

- Update .gitattributes by @erikn69 in https://github.com/spatie/laravel-markdown/pull/34
- Use afterResolving on markdown component register by @erikn69 in https://github.com/spatie/laravel-markdown/pull/35

## New Contributors

- @erikn69 made their first contribution in https://github.com/spatie/laravel-markdown/pull/34

**Full Changelog**: https://github.com/spatie/laravel-markdown/compare/2.2.1...2.2.2

## 2.2.1 - 2022-02-28

- use `convert` instead of deprecated `convertToHtml`

## 2.2.1 - 2022-02-28

- use `convert` instead of deprecated `convertToHtml`

## 2.2.0 - 2022-01-13

## What's Changed

- Add support for Laravel 9
- Fix broken link in code highlighting documentation by @AshboDev in https://github.com/spatie/laravel-markdown/pull/27
- Side note for using blade's unescaped statememt by @AshboDev in https://github.com/spatie/laravel-markdown/pull/28

## New Contributors

- @AshboDev made their first contribution in https://github.com/spatie/laravel-markdown/pull/27

**Full Changelog**: https://github.com/spatie/laravel-markdown/compare/2.1.1...2.2.0

## 2.1.1 - 2021-12-27

## What's Changed

- Add tests to identify and fix bug with renderers priority by @mallardduck in https://github.com/spatie/laravel-markdown/pull/26

**Full Changelog**: https://github.com/spatie/laravel-markdown/compare/2.1.0...2.1.1

## 2.1.0 - 2021-12-03

## What's Changed

- Corrected some markdown, spelling, and URL mistakes... by @telkins in https://github.com/spatie/laravel-markdown/pull/20
- Allow priority to be set for Block and Inline Renderers by @SimonJulian in https://github.com/spatie/laravel-markdown/pull/23

## New Contributors

- @telkins made their first contribution in https://github.com/spatie/laravel-markdown/pull/20
- @SimonJulian made their first contribution in https://github.com/spatie/laravel-markdown/pull/23

**Full Changelog**: https://github.com/spatie/laravel-markdown/compare/2.0.1...2.1.0

## 2.0.1 - 2021-09-13

- enable use of RenderedContentInterface and small fix (#18)

## 2.0.0 - 2021-09-12

- use spatie/commonmark-shiki-highlighter 2.0 (#17)

## 1.1.3 - 2021-08-27

- don't ignore extensions in the Blade component (#15)

## 1.1.2 - 2021-08-13

- fix commonmarkOptions not being set in the commonmark environment

## 1.1.1 - 2021-07-25

- fix various links + docs

## 1.1.0 - 2021-07-12

- add support for inline renderers

## 1.0.1 - 2021-07-12

- fix autoloading

## 1.0.0 - 2021-07-12

- initial release

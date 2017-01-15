<p align="center">
<a href="https://travis-ci.org/rugaard/meta-scraper"><img src="https://travis-ci.org/rugaard/meta-scraper.svg?branch=master" alt="Build Status"></a>
<a href="https://codecov.io/gh/rugaard/meta-scraper"><img src="https://codecov.io/gh/rugaard/meta-scraper/branch/master/graph/badge.svg" alt="Codecov"></a>
<a href="https://packagist.org/packages/rugaard/meta-scraper"><img src="https://poser.pugx.org/rugaard/meta-scraper/v/stable" alt="Latest Stable Version"></a>
<a href="https://packagist.org/packages/rugaard/meta-scraper"><img src="https://poser.pugx.org/rugaard/meta-scraper/license.svg" alt="License"></a>
</p>

## 📝 Introduction

Meta scraper is a package, that makes it easy to parse an URL and extract all the delicious meta data, that's usually hidden within the source.

This package also adds support for automatically parsing of [Open Graph](http://ogp.me), [Twitter Cards](https://dev.twitter.com/cards/types) and [Facebook Insights](https://developers.facebook.com/docs/sharing/webmasters#basic). You can also implement your own parser to parse custom namespaces.

## ⚠️ Requirements

- PHP 7.0+
- cURL 7.19.4+ _(with OpenSSL and zlib)_ or make sure your `allow_url_fopen` is enabled in your systems `php.ini`

## 📦 Installation

The recommended way to install this package is through [Composer](https://getcomposer.org/), by using the following command:
```shell
composer require rugaard/meta-scraper
```

Alternatively, you can add the package by editing your projects existing `composer.json` file:
```json
 {
   "require": {
      "rugaard/meta-scraper": "dev-master"
   }
}
```

and then afterwards update [Composer](https://getcomposer.org/)s dependencies by using the following command:
```shell
composer update
```

## ⚙️ Usage

TODO: Write instructions

## 🚓 License

Meta scraper is open-sourced software licensed under the [MIT license](http://opensource.org/licenses/MIT)
# Related Posts for WordPress - Polylang Compatibility

**Contributors:** [Teemu Suoranta](https://github.com/TeemuSuoranta)

**Tags:** Related Posts for WordPress, Related Posts, Polylang, WordPress

**License:** GPLv2 or later

## Description

This is an add-on to [Related Posts for WordPress](https://www.relatedpostsforwp.com) that adds compatibility to Polylang.

Requirements for the plugin:

 * Related Posts for WordPress (Premium)
 * Polylang

**I am not a developer for Related Posts for WordPress. This plugin is based on their WPML compatibility plugin.**


## Installation

How-to use:

 * Install and activate this add-on
 * Done

**Composer:**
```
$ composer aucor/rp4wp-polylang-compatibility
```
**With composer.json:**
```
{
  "require": {
    "aucor/rp4wp-polylang-compatibility": "*"
  },
  "extra": {
    "installer-paths": {
      "htdocs/wp-content/plugins/{$name}/": ["type:wordpress-plugin"]
    }
  }
}
```

## Issues and feature whishlist

**Issues:**

There's still posts that are linked to wrong languages:

 * Go to Related Posts -> Installer -> Re-install this post type (and re-link everything)

No support for multilingual stop words

 * Make a PR!


## Changelog

### 1.0 - Github launch

 * It's working
# Bulma Package

Bulma Package delivers a fully configured frontend theme for TYPO3, based on [Bulma CSS Framework](https://bulma.io/).

This is **more than greatly** inspired from https://github.com/benjaminkott/bootstrap_package.
Many parts are simply copy/paste, thank you Benjamin!

The main differences, CSS framework apart, is that some of the configuration is made accessible for the "non admin" editors, through a backend module.
We tried to make this with the end-user in mind, as simple as we could.

You still have to be a developer if you want to extend it to make your own templates and layouts.

You are more than welcome if you want to make code reviews ;)

A real documentation will be made if this is a bit adopted!

## Showcase

https://bulma-package.cnerta-web.fr/

## Minimal Dependencies

* TYPO3 CMS 11.5 (for TYPO3 10.4, use version 1.x.y)
* PHP >= 7.4

## Quick install guide

* With composer: `composer require agrosup-dijon/bulma-package`
* Without composer: install the extension via Extension manager or TER only (if you use github version, you won't have the dependencies and it won't work)
* Make sure you have a root page
* Make sure you have a "site" in Site Configuration module
* Create a new Template on the root page
    * Include static (from extensions): Bulma Package (Full package)
* Go to "Website" module
    * Create new configuration
    * In General, define SEO title. This will be your website title visible in the frontend.
    * Upload a main logo in Logo tab
* You're all set, go create contents :)

## Custom colors

* Go to "Website" module
* In the top list, select "Colors management"
* Create a new color, give it a title and use color picker to define primary color.
* Save
* Custom color will be available in Page properties, Appearance tab, Frontend layout list.

## Development

* Yarn usage: ddev yarn --cwd \<path_bulma> \<command>
* Archive for TER: ddev -d \<path_bulma> composer archive --format=zip --file=bulma_package_x.y.z
* Update dependencies for non composer project: ddev composer update --dry-run -d <path_bulma>/Resources/Private/Contrib/Php
* Update js dependencies: npm install -g npm-check-updates / ncu / ncu -u
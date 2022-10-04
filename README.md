# Food System Country Profiles Child Theme #

Necessary steps to run the project, being a seed is to copy the whole project and change it to your liking.

### Version 1.11.0 ###


### Getting started ###

Before start project is neccesary install the following dependencies in your system:

* [Git](https://git-scm.com/)
* [NodeJs Version 16.15.0](https://nodejs.org)
* [gulp-cli](https://gulpjs.com/)

## Installation
```bash
# Clone the repository
$ git clone git@github.com:AllianceBioversityCIAT/Food-system-country-profiles.git

# Install the Gulp CLI
$ npm install --global gulp-cli

# Install the dependencies
$ npm install
$ composer install
```

## Configuration
Create the `config.json` file, to run locally:

```.config
{
  "dest": "/wp-data/wp-content/themes"
}
```
When creating this file you must delete the example file `config.json.sample`, the destination location requested, is to display all files processed by gulp, in the WordPress themes folder.

## Running the app

```bash
# development watch mode
$ gulp watch

```
## More information
- WordPress - [WordPress.org](https://developer.wordpress.org/themes/getting-started/)
- Twig Doc - [Twig](https://twig.symfony.com/doc/3.x/)
- Timber Doc - [Timber](https://timber.github.io/docs/)
- Coding Standards - [WordPress Coding Standards](https://codex.wordpress.org/WordPress_Coding_Standards)
    * [PHP](https://make.wordpress.org/core/handbook/best-practices/coding-standards/php/)
    * [HTML](https://make.wordpress.org/core/handbook/best-practices/coding-standards/html/)
    * [CSS](https://make.wordpress.org/core/handbook/best-practices/coding-standards/css/)
    * [JS](https://make.wordpress.org/core/handbook/best-practices/coding-standards/javascript/)

## Stay in touch

- Authors - [Cafeto Software] - [Miguel Buriticá]
- Website - [https://cafeto.co/](https://cafeto.co/)

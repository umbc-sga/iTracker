# AngularJS Dashboard for Basecamp

Dashboard for Basecamp with the following features

- Shows project statistics
- Shows todo list statistics
- Shows todo statistics

## How to get started

- Copy all files to a folder on your web server
- Copy `get.dist.php` to `get.php`
- Open `get.php`and supply your basecamp account settings in the configuration section
- Open your browser and navigate to `index.html`

## No Oauth2 required!

This dashboard is written to run in a private environment.

Therefore it uses basic HTTP authentication instead of Oauth2.0 for the sake of simplicity.

## PHP proxy script included

A simple proxy script using PHP cUrl is included to avoid Cross Domain issues:

    cp get.dist.php get.php

Then edit the variables in the configuration section and you're done!

## Dependencies

- Twitter Bootstrap for styling the dashboard
- AngularJS for the JavaScript magic

## How to update the dependencies with Bower

The dependencies are included by default, but for the sake of your convenience, they can be updated with Bower.

From the command line:

    bower update

Have fun!
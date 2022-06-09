# Shoutz0r

[![License](https://img.shields.io/github/license/xorinzor/shoutz0r.svg?style=flat)](https://www.gnu.org/licenses/gpl-3.0.en.html)
![Azure DevOps builds](https://img.shields.io/azure-devops/build/xorinzor/a25fbc4c-12ac-4473-beb7-219329581d73/4)
[![CodeFactor](https://www.codefactor.io/repository/github/xorinzor/shoutz0r-app/badge/master)](https://www.codefactor.io/repository/github/xorinzor/shoutz0r-app/overview/master)

Shoutz0r - A media voting system perfect for events such as lan-parties!\
Comes with autoDJ to keep requests going when no requests have been added by users.

PLEASE NOTE: Shoutz0r is currently still under heavy development & lacks major functionality. If interested, please "watch" the repository to receive a notification when the first release is created.

![Preview Image](./screenshot.png)

Shoutz0r gives users a platform to upload different kinds of media, and vote on what they would like to hear or watch (yes it supports videos too!).\
The queue can be generated based on the amount of votes, or as a regular queue (first come, first serve).

Built using the Laravel Framework and Vue components.

Documentation can be found over at [shoutzor.com](https://www.shoutzor.com)

### To setup:
Currently there's a few hoops to go through. These should be resolved on the proper release.

First off, optionally edit the values in `.env.template`. These will be used during setup.

For production environments:
- Ensure you have composer and npm installed
- Run `composer install-shoutzor`

For development environments:
- Ensure you have composer and npm installed
- Run `composer install-shoutzor-dev`

The Shoutz0r app should now be ready for use! You can optionally remove the `.env.template` file now, it has been copied to `.env`.

The default login is admin/admin

If you're going to work on the front-end, make sure to run `npm run watch`.

### Docker setup:

For production environments you can simply run `docker-compose up`. \
This will set up a basic and simple docker network with a few containers pre-configured for use.

For development environments you should run: `docker-compose -f docker-compose.yml -f docker-compose.dev.yml up`

When your docker is up and running, make sure to run `composer install-shoutzor` in the `php` container.

Please note that I will not be providing support on any issues regarding docker itself.\
By using Docker I expect you to have the required knowledge about how it works.

If you have improvements however, by all means please create a discussion or issue (or even better, a pull-request).\
I'm always open for feedback.

### Kindly supported by
* [JetBrains](https://www.jetbrains.com/?from=Shoutz0r)
* [Navicat](https://www.navicat.com/)

### Sponsor this project

Shoutz0r is being developed entirely in my spare time. \
If you like this project, please consider sponsoring it using the button in the sidebar of this repo (or [click here](https://github.com/sponsors/xorinzor) ).\
Every little bit helps to buy me a beer or pizza, which keeps me going!

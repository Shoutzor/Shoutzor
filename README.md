# Shoutz0r

[![License](https://img.shields.io/github/license/xorinzor/shoutz0r.svg?style=flat)](https://www.gnu.org/licenses/gpl-3.0.en.html)

Shoutz0r - Easily setup a music system on your event! (Mainly intended for LAN-Parties)!

Built using the Laravel Framework and Vue components.

Comes with autoDJ to keep the music going when no song requests have been added by users.

Docker container can be found at [xorinzor/shoutz0r-docker](https://github.com/xorinzor/shoutz0r-docker)


### To setup:

1. Run `php artisan passport:keys`
2. Run `php artisan migrate` (and optionally for dev `php artisan db:seed`)

The Shoutzor environment should now be ready for use.
When developing, make sure to run `npm run watch` as well in order to update the compiled JS and CSS files.

# Shoutz0r

[![License](https://img.shields.io/github/license/xorinzor/shoutz0r.svg?style=flat)](https://www.gnu.org/licenses/gpl-3.0.en.html)

Shoutz0r - Easily setup a music system on your event! (Mainly intended for LAN-Parties)!

Built using the Laravel Framework and Vue components.

Comes with autoDJ to keep the music going when no song requests have been added by users.

Docker container can be found at [xorinzor/shoutz0r-docker](https://github.com/xorinzor/shoutz0r-docker)


### To setup:
1. Run `php artisan migrate:fresh`
2. Run `php artisan db:seed` 
3. Run `php artisan db:seed --class=PermissionSeeder`
4. Optionally: for development run `php artisan db:seed --class=DevelopmentSeeder`
5. Run `php artisan passport:install --force`

The Shoutzor environment should now be ready for use.
When developing, make sure to run `npm run watch` as well in order to update the compiled JS and CSS files.

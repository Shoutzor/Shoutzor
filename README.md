# Shoutz0r

[![License](https://img.shields.io/github/license/xorinzor/shoutz0r.svg?style=flat)](https://www.gnu.org/licenses/gpl-3.0.en.html)

Shoutz0r - A media voting system perfect for events such as lan-parties!\
Comes with autoDJ to keep requests going when no requests have been added by users.

Shoutz0r gives users a platform to upload different kinds of media, and vote on what they would like to hear.\
The queue can be generated based on the amount of votes, or as a regular queue (first come, first serve).


Built using the Laravel Framework and Vue components.

### To setup:
When the app is deployed, visit `/install` to run the Shoutz0r installer.

### To setup from source:

For deployment, checkout the masterbranch.\
If you want to work on Shoutz0r, make sure to use the development branch.

0. Open a terminal and navigate to the directory where these project files reside
1. Run `php artisan migrate:fresh --seed`
2. Run `php artisan passport:install --force`
3. Optionally: for development run `php artisan db:seed --class=DevelopmentSeeder`
4. If you're going to work on the front-end, make sure to run `npm run watch`. If not, a simple `npm run dev` will
   suffice.

The Shoutz0r app should now be ready for use!

### Thanks to

[JetBrains](https://www.jetbrains.com/?from=Shoutz0r)

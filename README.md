# Shoutz0r

[![Build Status](https://travis-ci.com/xorinzor/Shoutz0r.svg)](https://travis-ci.com/xorinzor/Shoutz0r)
[![Docker stars](https://img.shields.io/docker/stars/xorinzor/shoutz0r.svg)](https://hub.docker.com/r/xorinzor/shoutz0r/)
[![Docker pulls](https://img.shields.io/docker/pulls/xorinzor/shoutz0r.svg)](https://hub.docker.com/r/xorinzor/shoutz0r/)
[![Docker Image size](https://img.shields.io/microbadger/image-size/xorinzor/shoutz0r/latest.svg?style=flat)](https://hub.docker.com/r/xorinzor/shoutz0r/)
[![Coverity Scan](https://img.shields.io/coverity/scan/18651.svg)](https://scan.coverity.com/projects/xorinzor-shoutz0r)
[![License](https://img.shields.io/github/license/xorinzor/shoutz0r.svg?style=flat)](https://www.gnu.org/licenses/gpl-3.0.en.html)

Shoutz0r, but this time even easier to install by using Docker.
Easily setup a music system on your event! (Mainly intended for LAN-Parties)

Comes with autoDJ to keep the music going, even when no users are requesting songs.


**/Persistence/etc** contains configuration files that will override the files in /etc in the docker container.

**/www/etc** contains config files that should be added to the container via volume-share. This will keep an existing shoutzor installation running if you update the docker container, or remove/re-add it.

**/www/public** is what the webserver should be pointing at as it's root-directory

**/www/cache** requires write-permissions, currently 777 (I am aware that's possibly unsafe, this will change in the future)

**/www/app** contains the brains of shoutzor as well as required libraries, etc.

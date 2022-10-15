# Shoutz0r

[![License](https://img.shields.io/github/license/xorinzor/shoutz0r.svg?style=flat)](https://www.gnu.org/licenses/gpl-3.0.en.html)

1. [Introduction](#introduction)
2. [Docker container diagram](#docker-container-diagram)
3. [Kindly Supported by](#kindly-supported-by)
4. [Sponsor this project](#sponsor-this-project)

## Introduction

Shoutz0r - A media voting system perfect for events such as lan-parties!\
Comes with autoDJ to keep requests going when no requests have been added by users.

The codebase of Shoutz0r is split up between the [Frontend](https://github.com/Shoutz0r/frontend) & [Backend](https://github.com/Shoutz0r/backend) for better maintainability.

PLEASE NOTE: Shoutz0r is currently still under heavy development & lacks major functionality. If interested, please "
watch" the repository to receive a notification when the first release is created.

![Preview Image](./screenshot.png)

Shoutz0r gives users a platform to upload different kinds of media, and vote on what they would like to hear or watch (
yes it supports videos too!).\
The queue can be generated based on the amount of votes, or as a regular queue (first come, first serve).

Documentation has yet to be written. Feel free to ask any questions in the `discussions`.

## Docker Container Diagram:

This diagram might contain some errors (please notify me if it does) but should give an idea of the way this app is setup.
The Queue worker, front-end and back-end can be setup as either separate containers (instantiated from the same "web" image), or ran from a single container.

![Container diagram](./docker-diagram.png)

## Kindly supported by

* [JetBrains](https://www.jetbrains.com/?from=Shoutz0r)
* [Navicat](https://www.navicat.com/)

## Sponsor this project

Shoutz0r is being developed entirely in my spare time. \
If you like this project, please consider sponsoring it using the button in the sidebar of this repo (
or [click here](https://github.com/sponsors/xorinzor) ).\
Every little bit helps to buy me a beer or pizza, which keeps me going!

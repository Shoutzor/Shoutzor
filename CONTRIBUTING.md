# Contributing to Shoutz0r

Shoutz0r is an open source project and a volunteer effort. Feel free to help out! It's very much appreciated.

## Contributions

Contributions to Shouzt0r should be made in the form of [GitHub pull requests][pr]. Each pull request will be reviewed
by a core contributor (someone with permission to land patches) and either landed in the main tree or given feedback for
changes that would be required before it can be merged. All contributions should follow this format, even those from
core contributors.

## Not All Commits Need CI Builds

Sometimes all you are changing is the `README.md`, some documentation or other things which have no effect on the tests.
In this case, you may not want a build to be created for that commit. To do this, all you need to do is to
add `[ci skip]`
somewhere in the commit message.

Commits that have `[ci skip]` anywhere in the commit messages will be ignored. `[ci skip]` does not have to appear on
the first line, so it is possible to use it without polluting your project's history.

Alternatively, you can also use `[skip ci]`.

## Questions & Support

For questions, ideas, suggestions or issues, please open an issue on our Github Repository. Please make sure to search
for existing / similar issues before creating a new issue. Duplicate issues will be closed.

## Issue Checklist

- Make sure you are using the latest released version of Shoutz0r before submitting a bug report. Bugs in versions older
  than the latest released one will not be addressed.

- If you have found a bug it is important to add relevant reproducibility information to your issue to allow us to
  reproduce the bug and fix it quicker. Please describe as accurately as possible how to reproduce the problem.
  Screenshots are welcome, make sure to blank out any sensitive information.

- Be sure that you include the version of Shoutz0r you're using in your issue.

## Pull Request Checklist

- Don't submit your pull requests to the `master` branch. Branch from the required branch and, if needed, rebase to the
  proper branch before submitting your pull request. If it doesn't merge cleanly with master you may be asked to rebase
  your changes

- Be sure to include Unit Tests with any new or edited features in your pull requests, this is a requirement.

Thanks! <br />
Jorin "Xorinzor"

(credits for this contributing.md file that I used as a template go to phalcon/incubator)

[pr]: https://help.github.com/articles/using-pull-requests/
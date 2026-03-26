# Release checklist

**Important**: If releases for multiple branches are to be tagged, always tag the 3.x release first, 4.x second etc!

## Before Release

### General

- [ ] Verify, and if necessary, update the version constraints for dependencies in the `composer.json`.
- [ ] Verify that any new functions have type declarations whenever possible.
- [ ] Verify that the license tags all refer to the _new_ organisation and no longer to Squizlabs.
- [ ] Verify that `@copyright` tags in new files use `@copyright 20xx PHPCSStandards and contributors`.
- [ ] Check if the GPG key is still valid (not expired).
    If it has expired, create a new key before starting the release process.
    - Generate a new key following the steps here: <https://phar.io/howto/generate-gpg-key.html>.
    - Upload the new key following the steps here: <https://phar.io/howto/uploading-public-keys.html>.
        :warning: the command for exporting the key will export _all_ keys for the email address. This will not work as OpenPGP does not send an email to verify the key if the upload contained multiple keys.
        So, first run `gpg --keyid-format LONG --list-keys my@email.com`.
        Then run `gpg --export --armor KEY_ID > phpcs.pub` specifically for the new key.
        And then upload the file.
    - Verify the key via the link received via email.
    - Update the key information in the README x 3.
    - Update the key info in the verify-release GHA workflow x 2.

### Wiki

- [ ] Fetch changes and check against vandalism.
- [ ] Verify that any new `public` properties are listed on the Customizable Properties page in the Wiki.
- [ ] Verify that any new sniffs which have `public` properties are listed on the Customizable Properties page in the Wiki.
- [ ] Verify that any new CLI options are listed in the Wiki.
- [ ] Verify that any new Reports have a section in the Reports page in the Wiki.
- [ ] Whenever relevant, but definitely for a new major, update the output examples which cannot currently be automatically updated.
    Search for "Regenerate the below output snippet by running the following command" comments to find the relevant sections in the wiki.

### Majors only

- [ ] Verify that everything deprecated during the previous major was removed.
- Submit PRs to the documentation repository to update the wiki/website:
    - [ ] Remove notes from the wiki which refer to features removed in the _previous_ major.
        I.e. When releasing 4.0, notes about features removed/changed in or before 3.0 can be removed.
    - [ ] Update sections related to anything deprecated/removed features to mention the deprecation/removal.
- [ ] Change `Config::STABILITY` from "dev" to "stable" for the branch for the new major.

### Prepare changelog

- [ ] Prepare changelog for the release and submit the PR. - PR #xxx
    - Based on the tickets in the milestone.
    - Double-check that any issues which were closed by PRs included in the release, have the milestone set.
    - Compare with auto-generated release notes to ensure nothing is missed.
    - :pencil2: Remember to add a release link at the bottom!
- [ ] Prepare extra sections for the GH release notes.
    - Use "New contributors" list from the auto-generated notes.
    - Use the milestone to gather the stats.
    - Add sponsor link.
    - Remove square brackets from all ticket links or make them proper full links (as GH markdown parser doesn't parse these correctly).
    - Change all contributor links to full inline links (as GH markdown parser on the Releases page doesn't parse these correctly).
    ```md
---

### New Contributors

The PHP_CodeSniffer project is happy to welcome the following new contributors:
@...., @....

### Statistics

**Closed**: # issues
**Merged**: ## pull requests

If you like to stay informed about releases and more, follow [@phpcs on Mastodon](https://phpc.social/@phpcs) or [@PHP_CodeSniffer on X](https://x.com/PHP_CodeSniffer).

Please consider [funding the PHP_CodeSniffer project](https://opencollective.com/php_codesniffer). If you already do so: thank you!
    ```

### Milestone

- [ ] Close the milestone
- [ ] Open a new milestone for the next release
- [ ] If any open PRs/issues which were milestoned for this release did not make it into the release, update their milestone.


## Release

- [ ] Merge the changelog PR.
- [ ] Make sure all CI builds for the release branch are green.
- [ ] Create a tag for the release & push it.
- [ ] Make sure all CI builds are green.
- [ ] Download the PHAR files from the GH Actions test build page.
- [ ] Sign the PHAR files using:
    ```bash
    gpg -u my@email.com --detach-sign --output phpcs.phar.asc phpcs.phar
    gpg -u my@email.com --detach-sign --output phpcbf.phar.asc phpcbf.phar
    gpg -u my@email.com --detach-sign --output phpcs-x.x.x.phar.asc phpcs-x.x.x.phar
    gpg -u my@email.com --detach-sign --output phpcbf-x.x.x.phar.asc phpcbf-x.x.x.phar
    ```
- [ ] Get the SHA of the files for the phive.xml file
    ```bash
    # Linux
    sha256sum ./phpcs-x.x.x.phar
    sha256sum ./phpcbf-x.x.x.phar

    # Windows
    certutil -hashfile ./phpcs-x.x.x.phar SHA256
    certutil -hashfile ./phpcbf-x.x.x.phar SHA256
    ```
- Update the `gh-pages` branch:
    - [ ] Add the new release to the `phive.xml` file.
    - [ ] Add the versioned PHAR files + keys in PHAR dir.
    - [ ] Add the unversioned PHAR files + keys in root dir.
    - [ ] Verify the attestations of the PHAR files.
    ```bash
    gh attestation verify phpcs.phar -o PHPCSStandards
    gh attestation verify phpcbf.phar -o PHPCSStandards
    gh attestation verify phars/phpcs-x.x.x.phar -o PHPCSStandards
    gh attestation verify phars/phpcbf-x.x.x.phar -o PHPCSStandards
    ```
    - [ ] Commit & push the changes.
    - [ ] Verify that the [website](https://phars.phpcodesniffer.com/) regenerated correctly.
- [ ] Create a release & copy & paste the changelog to it.
    - [ ] Upload the unversioned PHAR files + asc files to the release.
    - [ ] Announce the release in the discussions forum by checking the checkbox at the bottom of the release page.
- [ ] Make sure all CI builds are green, including the verify-release workflow.
- [ ] Merge any open PRs in the documentation repository which relate to the current release.
    Important: this MUST be done **after** the release is published as otherwise the auto-generated output samples will not be updated correctly!

## After Release

- [ ] Update the version number in the `Config::VERSION` class constant in the `src/Config.php` file to the _next_ (patch) version.
    This can always be adjusted again later if needs be if it is decided that the next version will be a minor/major, but at least for dev
    it should clearly show that this is bleeding edge/unreleased.
- [ ] Close release announcement in the "Discussions" for previous minors (leave the announcements related to the current minor open).


### Publicize

- [ ] Post on Mastodon about the release (official account).
- [ ] Post on X about the release (official account).
- [ ] Post on LinkedIn (personal account).

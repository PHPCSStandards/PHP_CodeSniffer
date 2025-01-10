# Release checklist

## Before Release

### General

- [ ] Verify, and if necessary, update the version constraints for dependencies in the `composer.json` - PR #xxx
- [ ] Verify that any new functions have type declarations (ClassName/array/callable) whenever possible.
- [ ] Verify that the license tags all refer to the _new_ organisation and no longer to Squizlabs. (easily overlooked in new files)
- [ ] Verify that `@copyright` tags in new files use `@copyright 20xx PHPCSStandards and contributors`.

### Wiki

- [ ] Fetch changes and check against vandalism.
- [ ] Verify that any new `public` properties are listed on the Customizable Properties page in the Wiki.
- [ ] Verify that any new sniffs which have `public` properties are listed on the Customizable Properties page in the Wiki.
- [ ] Verify that any new CLI options are listed in the Wiki.
- [ ] Verify that any new Reports have a section in the Reports page in the Wiki.

### Majors only

- [ ] Move old changelog entries to `CHANGELOG_OLD.md` file.
- [ ] Verify that everything deprecated during the previous major was removed.
- [ ] Update the wiki for any references to anything deprecated/removed.
- [ ] Change `Config::STABILITY` from "dev" to "stable" for the branch for the new major. - PR #xxx

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
    For now, cherrypick the changelog to the 4.0 branch.
- [ ] Make sure all CI builds for `master` are green.
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
    - If, for whatever reason, the key is no longer available or has expired:
      -> generate a new key following the steps here: <https://phar.io/howto/generate-gpg-key.html>.
      -> upload the new key following the steps here: <https://phar.io/howto/uploading-public-keys.html>.
      -> update the key information in the README x 3.
      -> update the key info in the verify-release GHA workflow.
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
    - [ ] Verify that the website regenerated correctly and that the phars can be downloaded.
- [ ] Create a release & copy & paste the changelog to it.
    - [ ] Upload the unversioned PHAR files + asc files to the release.
    - [ ] Announce the release in the discussions forum by checking the checkbox at the bottom of the release page.
- [ ] Make sure all CI builds are green, including the verify-release workflow.


## After Release

- [ ] Update the version number in the `Config::VERSION` class constant in the `src/Config.php` file to the _next_ (patch) version.
    This can always be adjusted again later if needs be if it is decided that the next version will be a minor/major, but at least for dev
    it should clearly show that this is bleeding edge/unreleased.
- [ ] Close release announcement in the "Discussions" for previous minors (leave the announcements related to the current minor open).


### Publicize

- [ ] Post on Mastodon about the release (official account).
- [ ] Post on X about the release (official account).
- [ ] Post on LinkedIn (personal account).

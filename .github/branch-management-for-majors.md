# Checklists for branch management of majors

Note: these lists may be incomplete and should be regarded as a starting point to be updated/enhanced each time new insights present themselves.


## Stop support for old major

- [ ] Remove "old major" from workflows in the **oldest major still supported**.
    I.e. when support for 3.x will be stopped, `3.x` should be removed from the workflows in the `4.x` branch (not from the 3.x branch).
- [ ] Update target branch in the `.github/dependabot.yml` file in the **oldest major still supported** to be that oldest major.
- [ ] Update target branch (`BASE`) in the `.github/workflows/happy-new-year.yml` file in the **oldest major still supported** to be that oldest major.


## Start branch for next major

- [ ] Add "next major" to workflows in the **oldest major still supported**.
    I.e. when a new 5.x branch will be created while 3.x still has minimal support, this change should be made in the `3.x` branch (otherwise in the 4.x branch).
- [ ] Create x.x branch.

In the new branch:
- [ ] Change `Config::VERSION` to next major version number.
- [ ] Change `Config::STABILITY` to `alpha`.
- [ ] Create CHANGELOG-x.x.md file for the new major.
- [ ] Add CHANGELOG for the _major before last_ to the `.gitattributes` `export-ignore`s.
- [ ] Update branch references for the badges in the README.
- [ ] Update installation instructions (`^4.0`) in the README.
- [ ] Update branch reference/instructions in the issue and PR templates.
- [ ] Update branch reference in the `bug_report.md` issue template.
- [ ] Update branch reference in the `CONTRIBUTING` file ("Getting Started" section).
    => For the previous four items, see 1433a86bd4bd3480048d485983e7f16f8e8ec981 as an example.
- [ ] If the next major includes a PHP version drop, that should be the one of the first commits
    Example: a7a27b9413106cf4bf10514d6ce93658899ec279
    Also update relevant files from 19724954edc7997125040fbf84eddffca99d674f

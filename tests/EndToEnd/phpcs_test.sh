#!/usr/bin/env bash

function set_up() {
  # Pick a subset of files to speed up the test suite.
  FILES="src/Ruleset.php src/Runner.php"
  TMPDIR="tmp-phpcs"

  mkdir "$(pwd)/$TMPDIR"
}

function tear_down() {
  rm -r "$(pwd)/$TMPDIR"
}

function test_phpcs_is_working() {
  assert_successful_code "$(bin/phpcs --no-cache ${FILES})"
}

function test_phpcs_is_working_in_parallel() {
  assert_successful_code "$(bin/phpcs --no-cache --parallel=2 ${FILES})"
}

function test_phpcs_returns_error_on_issues() {
  # Copy & patch Runner.php with a style error so we can verify the error path
  TMPFILE="$TMPDIR/Runner.php"
  cp src/Runner.php "$(pwd)/$TMPFILE"
  patch "$TMPFILE" tests/EndToEnd/patches/Runner.php_inject_style_error.patch

  OUTPUT="$(bin/phpcs --no-colors --no-cache "$TMPFILE")"
  assert_exit_code 2

  assert_contains "E 1 / 1 (100%)" "$OUTPUT"
  assert_contains "FOUND 2 ERRORS AFFECTING 1 LINE" "$OUTPUT"
}

function test_phpcs_bug_1112() {
  # See https://github.com/PHPCSStandards/PHP_CodeSniffer/issues/1112
    if [[ "$(uname)" == "Darwin" ]]; then
      # Perform some magic with `& fg` to prevent the processes from turning into a background job.
      assert_successful_code "$(bash -ic 'bash --init-file <(echo "echo \"Subprocess\"") -c "bin/phpcs --no-cache --parallel=2 src/Ruleset.php src/Runner.php" & fg')"
    else
      # This is not needed on Linux / GitHub Actions
      assert_successful_code "$(bash -ic 'bash --init-file <(echo "echo \"Subprocess\"") -c "bin/phpcs --no-cache --parallel=2 src/Ruleset.php src/Runner.php"')"
    fi
}

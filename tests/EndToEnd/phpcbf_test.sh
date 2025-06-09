#!/usr/bin/env bash

function set_up() {
  # Pick a subset of files to speed up the test suite.
  FILES="src/Ruleset.php src/Runner.php"
  TMPDIR="tmp-phpcbf"

  mkdir "$(pwd)/$TMPDIR"
}

function tear_down() {
  rm -r "$(pwd)/$TMPDIR"
}

function test_phpcbf_is_working() {
  # We pick one file to speed up the test suite
  OUTPUT="$(bin/phpcbf --no-cache ${FILES})"

  assert_successful_code
  assert_contains "No violations were found" "$OUTPUT"
}

function test_phpcbf_is_working_in_parallel() {
  # We pick two files to speed up the test suite
  OUTPUT="$(bin/phpcbf --no-cache --parallel=2 ${FILES})"

  assert_successful_code
  assert_contains "No violations were found" "$OUTPUT"
}

function test_phpcbf_returns_error_on_issues() {
  # Copy & patch Runner.php with a style error so we can verify the error path
  TMPFILE="$TMPDIR/Runner.php"
  cp src/Runner.php "$(pwd)/$TMPFILE"
  patch "$TMPFILE" tests/EndToEnd/patches/Runner.php_inject_style_error.patch

  OUTPUT="$(bin/phpcbf --no-colors --no-cache "$TMPFILE")"
  assert_exit_code 1

  assert_contains "F 1 / 1 (100%)" "$OUTPUT"
  assert_contains "A TOTAL OF 1 ERROR WERE FIXED IN 1 FILE" "$OUTPUT"
}

function test_phpcbf_bug_1112() {
  # See https://github.com/PHPCSStandards/PHP_CodeSniffer/issues/1112
  if [[ "$(uname)" == "Darwin" ]]; then
    # Perform some magic with `& fg` to prevent the processes from turning into a background job.
    assert_successful_code "$(bash -ic 'bash --init-file <(echo "echo \"Subprocess\"") -c "bin/phpcbf --no-cache --parallel=2 src/Ruleset.php src/Runner.php" & fg')"
  else
    # This is not needed on Linux / GitHub Actions
    assert_successful_code "$(bash -ic 'bash --init-file <(echo "echo \"Subprocess\"") -c "bin/phpcbf --no-cache --parallel=2 src/Ruleset.php src/Runner.php"')"
  fi
}

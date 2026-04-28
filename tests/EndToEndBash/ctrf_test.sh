#!/usr/bin/env bash

ENDTOEND_STD="tests/EndToEndBash/Fixtures/endtoend.xml.dist"
FIX_DIR="tests/EndToEndBash/Fixtures"

# Validate that stdin is well-formed CTRF. Asserts via exit code so callers can
# follow up with `assert_successful_code`.
function _validate_ctrf_from_stdin() {
  php -r '
    $json = stream_get_contents(STDIN);
    $d    = json_decode($json, true);
    if ($d === null) {
      fwrite(STDERR, "Output is not valid JSON\n");
      exit(1);
    }
    if (($d["reportFormat"] ?? null) !== "CTRF") {
      fwrite(STDERR, "reportFormat must be \"CTRF\"\n");
      exit(1);
    }
    if (!preg_match("/^\d+\.\d+\.\d+$/", $d["specVersion"] ?? "")) {
      fwrite(STDERR, "specVersion missing or malformed\n");
      exit(1);
    }
    $summary = $d["results"]["summary"] ?? null;
    if ($summary === null) {
      fwrite(STDERR, "Missing results.summary\n");
      exit(1);
    }
    foreach (["tests", "passed", "failed", "skipped", "pending", "other", "start", "stop"] as $k) {
      if (!array_key_exists($k, $summary)) {
        fwrite(STDERR, "Missing summary.$k\n");
        exit(1);
      }
    }
    if (!is_array($d["results"]["tests"] ?? null)) {
      fwrite(STDERR, "results.tests is not an array\n");
      exit(1);
    }
    // Cross-check: summary.tests must equal the actual tests array length.
    $actual = count($d["results"]["tests"]);
    if ($summary["tests"] !== $actual) {
      fwrite(STDERR, "summary.tests ($summary[tests]) != actual count ($actual)\n");
      exit(1);
    }
    exit(0);
  '
}


function test_phpcs_ctrf_report_runs_sequentially() {
  OUTPUT="$( { bin/phpcs --no-cache --report=ctrf --standard=$ENDTOEND_STD $FIX_DIR/ClassWithStyleError.inc $FIX_DIR/ClassOneWithoutStyleError.inc; } 2>&1 )"
  echo "$OUTPUT" | _validate_ctrf_from_stdin
  assert_successful_code
}


function test_phpcs_ctrf_report_runs_in_parallel() {
  OUTPUT="$( { bin/phpcs --no-cache --parallel=2 --report=ctrf --standard=$ENDTOEND_STD $FIX_DIR/ClassWithStyleError.inc $FIX_DIR/ClassOneWithoutStyleError.inc $FIX_DIR/ClassWithTwoStyleErrors.inc; } 2>&1 )"
  echo "$OUTPUT" | _validate_ctrf_from_stdin
  assert_successful_code
}


function test_phpcs_ctrf_parallel_matches_sequential() {
  # Same input, same set of test entries (regardless of order).
  SEQ="$( { bin/phpcs --no-cache --report=ctrf --standard=$ENDTOEND_STD $FIX_DIR/ClassWithStyleError.inc $FIX_DIR/ClassOneWithoutStyleError.inc $FIX_DIR/ClassWithTwoStyleErrors.inc; } 2>&1 )"
  PAR="$( { bin/phpcs --no-cache --parallel=2 --report=ctrf --standard=$ENDTOEND_STD $FIX_DIR/ClassWithStyleError.inc $FIX_DIR/ClassOneWithoutStyleError.inc $FIX_DIR/ClassWithTwoStyleErrors.inc; } 2>&1 )"

  RESULT="$(php -r '
    $seq = json_decode($argv[1], true)["results"]["tests"];
    $par = json_decode($argv[2], true)["results"]["tests"];
    $proj = function ($t) { return ($t["status"] ?? "") . "|" . ($t["name"] ?? ""); };
    $seqKeys = array_map($proj, $seq);
    $parKeys = array_map($proj, $par);
    sort($seqKeys);
    sort($parKeys);
    echo $seqKeys === $parKeys ? "MATCH" : "MISMATCH";
  ' "$SEQ" "$PAR")"
  assert_equals "MATCH" "$RESULT"
}


function test_phpcs_ctrf_report_to_file() {
  OUT_FILE="$(mktemp /tmp/phpcs-ctrf-XXXXXX.json)"
  bin/phpcs --no-cache --report-ctrf="$OUT_FILE" --standard=$ENDTOEND_STD $FIX_DIR/ClassWithStyleError.inc > /dev/null 2>&1
  cat "$OUT_FILE" | _validate_ctrf_from_stdin
  RC=$?
  rm -f "$OUT_FILE"
  return $RC
}


function test_phpcs_ctrf_clean_file_emits_passed_test() {
  OUTPUT="$( { bin/phpcs --no-cache --report=ctrf --standard=$ENDTOEND_STD $FIX_DIR/ClassOneWithoutStyleError.inc; } 2>&1 )"
  assert_contains '"status":"passed"' "$OUTPUT"
}


function test_phpcs_ctrf_error_emits_failed_test() {
  OUTPUT="$( { bin/phpcs --no-cache --report=ctrf --standard=$ENDTOEND_STD $FIX_DIR/ClassWithStyleError.inc; } 2>&1 )"
  assert_contains '"status":"failed"' "$OUTPUT"
  assert_contains '"rawStatus":"ERROR"' "$OUTPUT"
}

                                <div>Inline HTML with indent to demonstrate the bug in the indent calculation.</div>
<?php
// This test case file MUST always start with a long open PHP tag set (with this comment) to prevent
// the tests running into the "first PHP open tag excepted" condition breaking the tests.
// Tests related to that "first PHP open tag excepted" condition should go in separate files.
?>
<!--
Content indent calculation should not look at first token in the stack, but only at the line containing the PHP open tag for the block.
-->
<?php
echo 'indent is correct - first on line for open tag is open tag';
?>
<?php
       echo 'indent is incorrect - first on line for open tag is inline HTML';
?>

<?php
// This test case file MUST always end with an unclosed long open PHP tag (with this comment) to prevent
// the tests running into the "last PHP closing tag excepted" condition breaking tests.
// Tests related to that "last PHP closing tag excepted" condition should go in separate files.

<?php
    // Not embedded. Do not check here.
    echo 'hello';
?>
<html>
<head>
<title><?php echo $title ?></title>
<script><?php echo $script; ?></script>
</head>
<body>
    <?php
        echo $body;
    ?>
    hello
    <?php
    echo $moreBody;
    ?>
    <?php  echo 'one'; ?>
    <?php  echo 'two';   ?>
    <?php echo 'three;' ?>
    <?php echo 'fourA'; echo 'fourB;'; ?>
    <?php  echo 'fiveA'; echo 'fiveB;';   ?>

    <?php
    ?>
    <?php ?>

    <?php

        echo $start - $indent + $end;

    ?>
    <?php

    echo $blankLines;

        ?>

    <?php
    echo $closerNeedsOwnLine; ?>
    <?php echo $openerNeedsOwnLine;
    ?>

            <?php
        echo 'hi';
            ?>

    <?php
echo 'hi';
    ?>
</body>
</html>
<?php
function test()
{
    foreach ($root->section as $section) {
        ?>
        <table>
            <?php if ($foo) {
            ?>
            <tr>
            </tr>
            <?php }
            ?>
        <?php
        foreach ($bar as $bar) {
            echo $bar;
        }
    }

    foreach ($root->section as $section) {
        ?>
        <table>
            <?php
            if ($foo) {
            ?>
            <tr>
            </tr>
            <?php
}
            ?>
        <?php
        foreach ($bar as $bar) {
            echo $bar;
        }
    }
}

echo 'goodbye';

function foo()
{

    ?><a onClick="Javascript: set_hidden_field('<?php echo $link_offset - $num_per_page; ?>'); set_hidden_field('process_form', '0'); submit_form(); return false;"><?php

}

?>

            <strong><?php
            echo 'foo';
            ?></strong>

?>

</html>

<?php if ($foo) { ?>
<?php } ?>

<?php echo 'okay'; // Something. ?>
<?php echo 'too much space before close'; // Something.      ?>
<?php echo 'no space before close'; // Something.?>

<?php /* translators: okay */ ?>
<?php /* translators: no space before close */?>
<?php /* translators: too much space before close */      ?>

<?php echo 'okay'; // phpcs:ignore Standard.Category.Sniff -- reason. ?>
<?php echo 'too much space before close'; // phpcs:ignore Standard.Category.Sniff -- reason.    ?>
<?php echo 'no space before close'; // phpcs:ignore Standard.Category.Sniff -- reason.?>

<!--
Make sure the empty tag set fixer removes the complete line, including indentation for an empty tag set and ensure
that the fixer does not remove too many tokens, like new lines tokens _before_ the affected line
or indentation if there is code _after_ the removed empty tag.
-->
        <div><?php ?></div>
    <?php ?><?php echo $i; ?>


        <?php ?>

    <?php if (true) { ?><?php echo $i; ?>  <?php ?>  <?php } ?>

        <div><?php
        ?></div>
    <?php
    ?><?php echo $i; ?>


    <?php
    ?>

    <?php if (true) { ?><?php echo $i; ?>  <?php
    ?>  <?php } ?>

<?php
// This test case file MUST always end with an unclosed long open PHP tag (with this comment) to prevent
// the tests running into the "last PHP closing tag excepted" condition breaking tests.
// Tests related to that "last PHP closing tag excepted" condition should go in separate files.

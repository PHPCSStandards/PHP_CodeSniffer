<!-- no problem here -->
<?php if (true): ?>
    <?php foreach ([] as $item): ?>
        <?php continue; ?>
    <?php endforeach; ?>
<?php endif; ?>

<!-- no problem here -->
<?php if (true) { ?>
    <?php foreach ([] as $item) { ?>
        <?php continue; ?>
    <?php } ?>
<?php } ?>

<!-- no problem here -->
<?php if (true) { ?>
    <?php foreach ([] as $item) { ?>
        <!-- note missing semicolon on next line -->
        <?php continue ?>
    <?php } ?>
<?php } ?>

<!-- should detect an error here -->
<?php if (true): ?>
    <?php foreach ([] as $item): ?>
        <?php continue; ?>
        <div>non-executable</div>
    <?php endforeach; ?>
<?php endif; ?>

<!-- should detect an error here -->
<?php if (true): ?>
    <?php foreach ([] as $item): ?>
        <!-- note missing semicolon on next line -->
        <?php continue ?>
        <div>non-executable</div>
    <?php endforeach; ?>
<?php endif; ?>

<!-- should detect an error here -->
<?php if (true): ?>
    <?php foreach ([] as $item): ?>
        <?php continue; ?>

        <div>non-executable</div>

    <?php endforeach; ?>
<?php endif; ?>

<!-- should detect an error here -->
<?php if (true): ?>
    <?php foreach ([] as $item): ?>
        <?php continue; ?>
        <?= 'unreachable - no semicolon' ?>
    <?php endforeach; ?>
<?php endif; ?>

<!-- should detect an error here -->
<?php if (true): ?>
    <?php foreach ([] as $item): ?>
        <?php continue; ?>
        <?= 'unreachable - with semicolon'; ?>
    <?php endforeach; ?>
<?php endif; ?>

<!-- No problem here. -->
<!-- Mind: the case/default statements all miss an explicit semicolon. This is perfectly valid PHP though. -->
<?php switch(true): ?>
    <?php case 'foo' ?>
        <div>executable</div>
        <?php break; ?>
    <?php case 'bar' ?>
        <?php return ?>
    <?php default ?>
        <div>executable</div>
        <?php goto LABEL; ?>
<?php endswitch ?>

<!-- Should detect errors here. -->
<?php switch(true): ?>
    <?php case 'foo' ?>
        <?php break; ?>
        <div>non-executable</div>
    <?php case 'bar' ?>
        <?php return; ?>
        <div>non-executable</div>
    <?php default ?>
        <?php goto LABEL ?>
        <div>non-executable</div>
<?php endswitch ?>

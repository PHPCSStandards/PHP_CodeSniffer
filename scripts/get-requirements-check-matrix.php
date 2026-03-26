#!/usr/bin/env php
<?php
/**
 * Build a dynamic matrix for the requirements check workflow.
 *
 * This matrix is used in two different GH Actions jobs and would be excruciating
 * (and pretty error-prone) to manually maintain, so better to generate it dynamically.
 *
 * @copyright 2024 PHPCSStandards and contributors
 * @license   https://github.com/PHPCSStandards/PHP_CodeSniffer/blob/HEAD/licence.txt BSD Licence
 */

error_reporting(E_ALL);

require_once __DIR__ . '/BuildRequirementsCheckMatrix.php';

echo json_encode(['include' => (new PHP_CodeSniffer\BuildRequirementsCheckMatrix())->getBuilds()]);

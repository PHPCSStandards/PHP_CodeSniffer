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

namespace PHP_CodeSniffer;

class BuildRequirementsCheckMatrix
{

    /**
     * Range of valid PHP versions against which select tests should run.
     *
     * @var array<string>
     */
    private $validPhp = [
        '7.2',
        'latest',
        'nightly',
    ];

    /**
     * Range of *in*valid PHP versions against which select tests should run.
     *
     * @var array<string>
     */
    private $invalidPhp = [
        '5.3',
        '7.1',
    ];

    /**
     * The PHPCS commands with which the tests should run.
     *
     * @var array<string>
     */
    private $cmd = [
        'phpcs',
        'phpcbf',
    ];

    /**
     * The operating systems against which the tests should run.
     *
     * @var array<string>
     */
    private $os = [
        'ubuntu-latest',
        'windows-latest',
    ];


    /**
     * Get all the builds.
     *
     * @return array<array<string, string>>
     */
    public function getBuilds()
    {
        $builds = array_merge(
            self::getValidBuilds(),
            self::getInvalidPHPBuilds(),
            self::getMissingExtensionsBuilds()
        );

        return $builds;
    }


    /**
     * Get the builds for tests which should succeed.
     *
     * I.e. these build comply with the minimum requirements for PHPCS.
     *
     * @return array<array<string, string>>
     */
    private function getValidBuilds()
    {
        $extensions = ['minimal' => 'none, tokenizer, xmlwriter, SimpleXML'];

        $builds = [];
        foreach ($this->validPhp as $php) {
            foreach ($this->cmd as $cmd) {
                foreach ($extensions as $name => $exts) {
                    foreach ($this->os as $os) {
                        $builds[] = [
                            'name'       => "✔ exts: $name",
                            'os'         => $os,
                            'cmd'        => $cmd,
                            'php'        => $php,
                            'extensions' => $exts,
                            'expect'     => 'success',
                        ];
                    }
                }
            }
        }

        return $builds;
    }


    /**
     * Get the builds for tests which should fail because the PHP version does not comply with the minimum PHP requirement.
     *
     * @return array<array<string, string>>
     */
    private function getInvalidPHPBuilds()
    {
        $extensions = ['default' => ''];

        $builds = [];
        foreach ($this->invalidPhp as $php) {
            foreach ($this->cmd as $cmd) {
                foreach ($extensions as $exts) {
                    foreach ($this->os as $os) {
                        $builds[] = [
                            'name'       => '❌ PHP too low',
                            'os'         => $os,
                            'cmd'        => $cmd,
                            'php'        => $php,
                            'extensions' => $exts,
                            'expect'     => 'fail',
                        ];
                    }
                }
            }
        }

        return $builds;
    }


    /**
     * Get the builds for tests which should fail because the PHP extensions do not comply with the requirements of PHPCS.
     *
     * @return array<array<string, string>>
     */
    private function getMissingExtensionsBuilds()
    {
        $extensions = [
            'missing tokenizer'     => 'none, xmlwriter, SimpleXML',
            'missing xmlwriter'     => ':xmlwriter',
            'missing SimpleXML'     => ':SimpleXML',
            'missing both XML exts' => 'none, tokenizer',
        ];

        $builds = [];
        foreach ($this->validPhp as $php) {
            foreach ($this->cmd as $cmd) {
                foreach ($extensions as $name => $exts) {
                    foreach ($this->os as $os) {
                        // Skip the extension requirements check on Windows as the required extensions cannot be
                        // disabled on Windows. They are compiled statically into the PHP binary.
                        // {@link https://github.com/shivammathur/setup-php/issues/887}.
                        if ($os === 'windows-latest') {
                            continue;
                        }

                        $builds[] = [
                            'name'       => "❌ $name",
                            'os'         => $os,
                            'cmd'        => $cmd,
                            'php'        => $php,
                            'extensions' => $exts,
                            'expect'     => 'fail',
                        ];
                    }
                }
            }
        }

        return $builds;
    }
}

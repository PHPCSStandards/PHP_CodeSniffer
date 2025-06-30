
<?php

// A directory containing files that are named {phpcs,phpcbf}-*.{phar,phar.asc}.
$pharDir = __DIR__ . '/../src/phars';

$allFiles = array_filter(scandir($pharDir), function ($file) {
    return preg_match('/\.phar(\.asc)?$/', $file);
});

$filesGroupedByVersion = [];

foreach ($allFiles as $file) {
    $matches = [];

    if (preg_match('/^(?:phpcs|phpcbf)-(.*?)(\.phar(?:\.asc)?)$/', $file, $matches)) {
        $version = $matches[1];

        if (!isset($filesGroupedByVersion[$version])) {
            $filesGroupedByVersion[$version] = [];
        }

        $filesGroupedByVersion[$version][] = $file;
    }
}

uksort($filesGroupedByVersion, function ($a, $b) {
    return version_compare($b, $a);
});

function indent (int $level): string
{
    $indentSpaces = '    ';

    $output = "";

    for ($i = 0; $i < $level; $i++) {
        $output .= $indentSpaces;
    }

    return $output;
}

function humanReadableFilesize($file) {
    $bytes = filesize($file);

    $units = ['B', 'K', 'M', 'G'];
    $factor = floor((strlen($bytes) - 1) / 3);
    return sprintf("%.1f", $bytes / pow(1024, $factor)) . $units[(int) $factor];
}

$html = "<ul class=\"phar-list\">\n";

foreach ($filesGroupedByVersion as $version => $files) {
    sort($files);

    $html .= indent(3) . "<li class=\"phar-list__version\">\n" .
    indent(4) . "<h2 class=\"phar-list__version-label\">" . $version . "</h2>\n" .
    indent(4) . "<ul class=\"phar-list__files\">\n";

    foreach ($files as $file) {
        $fileSize = humanReadableFilesize($pharDir . '/' . $file);
        $lastModifiedDate = shell_exec(escapeshellcmd("git log -1 --pretty=\"format:%cs\" -- " . $pharDir . '/' . $file));

        $html .= indent(5) . "<li><a download href=\"/phars/" . htmlspecialchars($file) . '">' . htmlspecialchars($file) . "</a> <span class=\"phar-list__filesize\">" . htmlspecialchars($fileSize) . " | " . htmlspecialchars($lastModifiedDate) . "</span></li>\n";
    }

    $html .= indent(4) . "</ul>\n" .
    indent(3) . "</li>\n";
}

$html .= indent(2) . "</li>\n" .
         "</ul>\n";

$template = file_get_contents(__DIR__ . '/phars.html.template');

$output = str_replace('<!-- {{ PHARS }} -->', $html, $template);

file_put_contents($pharDir . '/index.html', $output);

echo $pharDir . "/index.html generated successfully.\n";

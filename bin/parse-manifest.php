<?php
chdir(__DIR__ . '/../');
$fallbackUrl = 'https://github.com/box-project/box2/releases/download/2.7.5/box-2.7.5.phar';

if (! isset($argv[1]) || ! is_file($argv[1])) {
    return $fallbackUrl;
}

$manifestJson = file_get_contents($argv[1]);
$files = json_decode($manifestJson, true);

if (! is_array($files)) {
    echo $fallbackUrl;
    exit(0);
}

foreach ($files as $file) {
    if (! is_array($file) || ! isset($file['version'])) {
        continue;
    }

    if (version_compare($file['version'], '2.7.5', '>=')) {
        echo $file['url'];
        exit(0);
    }
}

echo $fallbackUrl;
exit(0);

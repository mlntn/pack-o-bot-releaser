<?php

require 'vendor/autoload.php';

(new Dotenv\Dotenv(__DIR__))->load();

if ($argc !== 3) {
	die('php release.php {version} {description}' . PHP_EOL);
}

list($file, $version, $description) = $argv;

$owner = 'mlntn';
$repo  = 'pack-o-bot';

$tag_name   = $version;
$target     = 'master';
$name       = "pack-o-bot {$version}";
$body       = $description;
$draft      = false;
$prerelease = false;

$client = new GitHubClient;
$client->setCredentials(getenv('GITHUB_USERNAME'), getenv('GITHUB_PASSWORD'));

echo 'Creating release... ';

$release = $client->repos->releases->create($owner, $repo, $tag_name, $target, $name, $body, $draft, $prerelease);

echo 'done.' . PHP_EOL;

foreach ([ 'mac', 'win' ] as $platform) {
	$filePath    = getenv('PACKOBOT_DIST_PATH') . "pack-o-bot-{$platform}.zip";
	$contentType = 'application/zip';
	$name        = "pack-o-bot-{$version}-{$platform}.zip";

	echo "Adding asset '$name'... ";

	$client->repos->releases->assets->upload($owner, $repo, $release->getId(), $name, $contentType, $filePath);

	echo 'done.' . PHP_EOL;
}

echo 'Successfully created release.' . PHP_EOL;

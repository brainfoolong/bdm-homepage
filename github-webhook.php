<?php

require __DIR__ . "/_bootloader.php";

$isValid = php_sapi_name() === 'cli';
if (!$isValid) {
    // verify package.json version
    // if it is the same, do not update code on production
    $packageDataMaster = json_decode(file_get_contents('https://raw.githubusercontent.com/brainfoolong/bdm-homepage/master/package.json'),
        true);
    $packageDataCurrent = json_decode(file_get_contents(__DIR__ . "/package.json"), true);
    if ($packageDataMaster['version'] !== $packageDataCurrent['version']) {
        $isValid = true;
    }

    if ($isValid) {
        $headers = getallheaders();
        $postdata = file_get_contents("php://input");
        $headerSignature = $headers['X-Hub-Signature'] ?? "";
        if ($postdata && hash_equals('sha1=' . hash_hmac('sha1', $postdata, BDM_GITHUB_WEBHOOK_SECRET),
                $headerSignature)) {
            $postdata = json_decode($postdata, true);
            if ($postdata) {
                $isValid = true;
            }
        }
    }
}

// if valid, pull from git repository and regenerate meta
if ($isValid) {
    exec('cd ' . escapeshellarg(__DIR__) . ' && git pull');
}
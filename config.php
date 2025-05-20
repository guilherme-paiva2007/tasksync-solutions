<?php
$webConfigs = [
    "baseDir" => "/tasksync"
];

function createUrl($path) {
    global $webConfigs;
    echo $webConfigs["baseDir"] . $path;
}
?>
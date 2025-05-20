<?php
$db = new mysqli(
    "localhost",
    "root",
    "",
    "tasksync_db"
);

if ($db->error) {
    die($db->error);
}
?>
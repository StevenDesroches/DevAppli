<?php
$db = new PDO('mysql:' . realpath(__DIR__) . '/internships.db');
$fh = fopen(__DIR__ . 'db/internships.sql', 'r');
while ($line = fread($fh, 4096)) {
    $db->exec($line);
}
fclose($fh);
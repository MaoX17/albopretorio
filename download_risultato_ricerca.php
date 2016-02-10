<?php
/**
 * Created by PhpStorm.
 * User: mproietti
 * Date: 10/01/14
 * Time: 16.00
 */

header('Content-Type: text/csv');
header('Content-Disposition: attachment; filename="file.csv"');
readfile('file.csv');

?>
<?php
// ini_set('memory_limit', '-1');
// ini_set('max_execution_time', 0);

header("Content-Type: " . $filetype);
header("Content-Length: " . filesize($filePAth));
header("Content-Disposition: attachment; filename=" . $filename);
readfile($filePAth);

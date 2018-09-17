<?php

// start from this directory
$dir = getcwd();

// to go to parent directory (if script placed in a subdirectory)
//chdir("../");
//$dir = getcwd();

// run scan and clean...
$files = scanAndClean($dir);
print "dir: " . $dir;

function scanAndClean($start) {
    $contents = scandir($start);
    array_splice($contents, 0, 2);
    foreach ($contents as $item ) {
        $path = "$start//$item";
var_dump($path);
        if (is_dir($path) && (substr($item, 0, 1) != '.') ) {
            scanAndClean($path);
        }
        elseif(in_array(pathinfo($path, PATHINFO_EXTENSION), array('php','inc','module'))) {
            cleanFile($path);
        }
    }
}

function cleanFile($file) {

    echo "file scanned : $file...\n";

    $content = file_get_contents($file);
    $pattern = "/\/\*457563643\*\/(.*)\/\*457563643\*\//";
    preg_match($pattern, $content, $matches, PREG_OFFSET_CAPTURE, 3);
    if(sizeof($matches) > 0) {

        file_put_contents($file, str_replace("<?php  ?>", '', preg_replace($pattern, '', $content)));
        echo "\nfile cleaned\n\n";
    }

    else {
        echo "file Ok\n\n";
    }
}
?>

<?php
const DS = DIRECTORY_SEPARATOR;

function dir_walker($dir, $match="/./", &$results=[]) {
    $files = array_diff(scandir($dir), [".", ".."]);
    foreach ($files as $file) {
        $path = realpath($dir.DS.$file);
        if (!is_dir($path) && preg_match($match, $path)) $results[] = $path;
        else if (is_dir($path)) dir_walker($path, $match, $results);
    } return $results;
}

function dimport_maker($paths, $reds=[DS."views", DS."app"]) {
    $red_path = function($path, $reds) {
        foreach ($reds as $red) if (strpos($path, $red)) return true;
        return false;
    };
    foreach ($paths as $path) {
        $dimport_id = basename(dirname($path)).DS.basename($path);
        if ($red_path($path, $reds))
            $dimport[$dimport_id] = [
                "path"      => $path,
                "redirect"  => "/index.php?page=".$dimport_id
            ];
        else $dimport[$dimport_id] = ["path" => $path];
    } return $dimport;
}

$dirs = [__DIR__.DS."public", __DIR__.DS."src"];
foreach ($dirs as $dir) $paths[] = dir_walker($dir, "/.*(php|phtml)$/");

$dimport = dimport_maker(array_merge(...$paths));

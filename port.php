<?php

// list of files to delete
$list = "list.txt";
$libHwDir = "lib/hw/";
$lib64HwDir = "lib64/hw/";

echo "x Samsung exynos renaming script\n\n";
$soc = readline("x SoC name: ");
echo "\n\n";

// dirs where the files to rename are
$dir = array(
    $libHwDir => $dir1,
    $lib64HwDir => $dir2
);

for ($i = 0; $i < count($dir); $i++) {
    RenameToSoC($dir[$i]);
}

echo "\n";
DeleteFiles($list);
echo "\n";
AddFiles($from, $to);
echo "\n";

// Renaming function
function RenameToSoC($dir) {
    global $soc;
    shell_exec("cd $dir");
    $files = scandir($dir);

    foreach ($files as $file) {
        // rename that file if has exynos or universal in the name
        if (str_contains($file, ".exynos") or str_contains($file, ".universal")) {
            echo $dir . $file . " found, renaming to $soc\n";
            // separate name file when a . is found
            $filename = explode(".", $file);
            // check every position in the exploded filename
            for ($i = 0; $i < count($filename); $i++) {
                // if one position contains exynos then rename to the desired soc
                if (str_contains($filename[$i], "exynos")) {
                    $filename[$i] = "exynos" . $soc;
                    rename($dir . $file, $dir . implode(".", $filename));
                } else {
                    // if one position contains universal then rename to the desired soc
                    if (str_contains($filename[$i], "universal")) {
                        $filename[$i] = "universal" . $soc;
                        rename($dir . $file, $dir . implode(".", $filename));
                    }
                }
            }
        }
    }
}

// Delete files function
# TODO: Delete files from a list
function DeleteFiles($list) {
    $llist = fopen($list, "r");
    while (!feof($llist)) {
        $fileToDelete = fgets($llist);
        if (!unlink($fileToDelete)) {
            echo "\nFailed to delete $fileToDelete";
        }
    }
}

// Add files function
function AddFiles($from, $to) {
    # TODO: Add files from a folder
}


<?php

$list = "list.txt";

$libHwDir = "lib/hw/";
$lib64HwDir = "lib64/hw/";
echo "x Samsung exynos renaming script\n\n";
$soc = readline("x SoC name: ");
echo "\n\n";


RenameToSoC($libHwDir);
echo "\n";
RenameToSoC($lib64HwDir);
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
        if (str_contains($file, ".exynos") or str_contains($file, ".universal")) {
            echo $dir . $file . " found, renaming to $soc\n";
            $filename = explode(".", $file);
            for ($i = 0; $i < count($filename); $i++) {
                if (str_contains($filename[$i], "exynos")) {
                    $filename[$i] = "exynos" . $soc;
                    rename($dir . $file, $dir . implode(".", $filename));
                } else {
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


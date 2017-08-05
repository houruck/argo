<?php
$dir = '../work/out/'.$session.'/';
$zip_file = '../work/out/'.$session.'/'.$gear.'.zip';

// Get real path for our folder
$rootPath = realpath($dir);

// Initialize archive object
$zip = new ZipArchive();
$zip->open($zip_file, ZipArchive::CREATE | ZipArchive::OVERWRITE);

// Create recursive directory iterator
/** @var SplFileInfo[] $files */
$files = new RecursiveIteratorIterator(
    new RecursiveDirectoryIterator($rootPath),
    RecursiveIteratorIterator::LEAVES_ONLY
);

foreach ($files as $name => $file)
{
    // Skip directories (they would be added automatically)
    if (!$file->isDir())
    {
        // Get real and relative path for current file
        $filePath = $file->getRealPath();
        $relativePath = substr($filePath, strlen($rootPath) + 1);

        // Add current file to archive
        $zip->addFile($filePath, $relativePath);
    }
}

// Zip archive will be created only after closing object
$zip->close();
$zip_file = '../work/out/'.$session.'/'.$gear.'.zip';

if(file_exists($zip_file) && is_file($zip_file)) {

// Download the file
header('Content-Description: File Transfer');
header('Content-Type: application/octet-stream');
header('Content-Disposition: attachment; filename='.basename($zip_file));
header('Content-Transfer-Encoding: binary');
header('Expires: 0');
header('Cache-Control: must-revalidate');
header('Pragma: public');
header('Content-Length: ' . filesize($zip_file));
ob_clean();
flush();

readfile($zip_file);
    } else {
// Error handling
session_unset();
session_destroy();
die;
}

// Delete work directory
array_map('unlink', glob('../work/out/'.$session.'/*.json'));
array_map('unlink', glob('../work/out/'.$session.'/'.$gear.'.zip'));
rmdir('../work/out/'.$session.''); // Needs error handling

?>
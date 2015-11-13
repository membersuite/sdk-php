<?php
// From http://www.sitepoint.com/packaging-your-apps-with-phar/
$srcRoot = getcwd() . '/src';
$buildRoot = getcwd() . '/lib';
 
$phar = new Phar($buildRoot . "/phpsdk.phar", 
	FilesystemIterator::CURRENT_AS_FILEINFO | FilesystemIterator::KEY_AS_FILENAME, 
	"phpsdk.phar");
$phar->buildFromDirectory($srcRoot);
$phar->setStub($phar->createDefaultStub("MemberSuite.php"));

copy($buildRoot . "/phpsdk.phar", getcwd() . "/APISample/phpsdk.phar");
?>
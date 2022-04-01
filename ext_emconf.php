<?php
/***************************************************************
 *
 *  Copyright notice
 *
 *  (c) 2021 Daniel Nemanic <daniel@nemanic.eu>
 *
 ***************************************************************/
$EM_CONF[$_EXTKEY] = array(
	'title' => 'DN Exponatsliste',
	'description' => '',
	'category' => 'plugin',
	'author' => 'Daniel Nemanic',
	'author_email' => 'daniel.nemanic@etglobal.com',
	'state' => 'stable',
	'internal' => '',
	'uploadfolder' => '1',
	'createDirs' => '',
	'clearCacheOnLoad' => 0,
	'version' => '10',
	'constraints' => array(
		'depends' => array(
			'typo3' => '>8.7'
		),
		'conflicts' => array(
		),
		'suggests' => array(
		),
	),
  'autoload' => [
	  'psr-4' => [
	      'DN\\Dnexponatsliste\\' => 'Classes/',
	  ],
  ],
);
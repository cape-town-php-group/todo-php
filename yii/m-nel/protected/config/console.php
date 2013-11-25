<?php

// This is the configuration for yiic console application.
// Any writable CConsoleApplication properties can be configured here.
return array(
	'basePath'=>dirname(__FILE__).DIRECTORY_SEPARATOR.'..',
	'name'=>'Yii - Todo PHP',

	// preloading 'log' component
	'preload'=>array('log'),

	// application components
	'components'=>array(
		'db'=>array(
            'class'=>'CDbConnection',
			'connectionString' => 'sqlite:'.dirname(__FILE__).'/../data/yiitodophp.db',
		),
		'testdb'=>array(
            'class'=>'CDbConnection',
			'connectionString' => 'sqlite:'.dirname(__FILE__).'/../data/test.db',
		),
		'log'=>array(
			'class'=>'CLogRouter',
			'routes'=>array(
				array(
					'class'=>'CFileLogRoute',
					'levels'=>'error, warning',
				),
			),
		),
	),
);
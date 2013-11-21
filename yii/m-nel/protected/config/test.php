<?php

return CMap::mergeArray(
	require(dirname(__FILE__).'/main.php'),
	array(
		'components'=>array(
            'urlManager'=>null,
			'fixture'=>array(
				'class'=>'system.test.CDbFixtureManager',
			),
            'db'=>array(
                'class'=>'CDbConnection',
                'connectionString' => 'sqlite:'.dirname(__FILE__).'/../data/test.db',
            ),
		),
	)
);

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
        'params'=>array(
            /**
             * Change the following URL based on your server configuration
             * Make sure the URL ends with a slash so that we can use relative URLs in test cases
             * Note, the [index-test.php] script should be called for testing
             */
            'test_base_url'=>'http://dev.todo/index-test.php/'
        ),
	)
);

<?php


abstract class DbTestCase extends CDbTestCase
{
	/**
	 * Ensure that the test database has been created and migrated
	 */
	protected function setUp()
	{
		parent::setUp();
        
        // Migrate database
        MigrateHelper::runMigrate();
	}
}
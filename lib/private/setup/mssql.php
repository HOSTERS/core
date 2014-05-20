<?php

namespace OC\Setup;

use Realestate\MssqlBundle\Driver\PDODblib\Driver;

class MSSQL extends AbstractDatabase {
	public $dbprettyname = 'MS SQL Server';

	public function setupDatabase() {

		// Fix database with port connection
		if(strpos($e_host, ':')) {
			list($e_host, $port)=explode(':', $e_host, 2);
		} else {
			$port=false;
		}


		$params = array(
			'host' => $this->dbhost,
			'port' => 1433,
			'dbname' => $this->dbname,
			'charset' => 'UTF-8'
		);

		$driver = new Driver();
		$driver->connect($params, $this->dbuser, $this->dbpassword);

		\OC_Config::setValue('dbuser', $this->dbuser);
		\OC_Config::setValue('dbpassword', $this->dbpassword);

		$this->createDatabaseStructure();
	}

	private function createDatabaseStructure() {
		$schemaManager = new \OC\DB\MDB2SchemaManager(\OC_DB::getConnection());
		$result = $schemaManager->createDbFromStructure($this->dbDefinitionFile);
		return $result;
	}
}

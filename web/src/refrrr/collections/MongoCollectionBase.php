<?php

class MongoCollectionBase
{
	protected static $collection = null;
	
	public function __construct()
	{
		
	}
	
	protected static function getCollection($collectionName)
	{
		if (MongoCollectionBase::$collection == null)
		{
			$connection = new Mongo();
			//$connection->refrrr->dropCollection();
			MongoCollectionBase::$collection = $connection->refrrr->$collectionName;
		} 
		return MongoCollectionBase::$collection;
	}
	
	protected static function executeFindOneQuery($query, $collectionName)
	{
		$collection = MongoCollectionBase::getCollection($collectionName);
	
		return $collection->findOne($query);
	}
	
	protected static function executeSave($document, $collectionName)
	{
		$collection = MongoCollectionBase::getCollection($collectionName);

		return $collection->save($document);
	}
	
	protected static function executeUpdate($criteria, $updatePart, $collectionName)
	{
		$collection = MongoCollectionBase::getCollection($collectionName);

		return $collection->update($criteria, $updatePart);
	}
	
	protected static function ensureIndex($keys, $collectionName)
	{
		$collection = MongoCollectionBase::getCollection($collectionName);

		return $collection->ensureIndex($keys);
	}
	
	protected static function ensureIndexUnique($keys, $collectionName)
	{
		$collection = MongoCollectionBase::getCollection($collectionName);

		return $collection->ensureIndex($keys, array("unique" => true, "dropDups" => true));
	}
	
	public static function clearCollection()
	{
		MongoCollectionBase::$collection = null;
	}
}

?>

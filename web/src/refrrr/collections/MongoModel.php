<?

class MongoModel
{

	protected function getCollection($collectionName)
	{
		$connection = new Mongo();

		return $connection->red->$collectionName; 
	}
	
}
	
?>

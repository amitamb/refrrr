<?php 

require_once("collections/MongoCollectionBase.php");

define('ID', '_id');
define('URL', 'url');
define('COMMENTS_URL', 'commentsUrl');

define('HNLINKS', 'hnlinks');

class HNLinks extends MongoCollectionBase
{
	public static function getByUrl($url)
	{
		$retval = MongoCollectionBase::executeFindOneQuery(array( URL => $url ), HNLINKS);
		
		return $retval;
	}
	
	public static function getByCommentsUrl($commentsUrl)
	{
		$retval = MongoCollectionBase::executeFindOneQuery(array( COMMENTS_URL => $commentsUrl ), HNLINKS);
		
		return $retval;
	}
	
	// copies the session in its current state and returns it
	public static function shareSession()
	{

	}
}

?>

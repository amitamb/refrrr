<?php 

require_once("framework/request.php");
require_once("collections/MongoCollectionBase.php");

define('ID', '_id');
define('EMAIL', 'email');

define('SUBSCRIBER', 'subscriber');

class Subscriber extends MongoCollectionBase
{
	public static function createSubscriberFromRequest()
	{
		$newSubscriber = array(EMAIL=>requestParam(EMAIL));
							
		return $newSubscriber;
	}

	public static function add()
	{
		$retval = Subscriber::createSubscriberFromRequest();
		$status = MongoCollectionBase::executeSave($retval, SUBSCRIBER);
			
		return $retval;
	}
	
	public static function ensureIndex()
	{
		MongoCollectionBase::ensureIndexUnique(array(EMAIL=>1),SUBSCRIBER);
	}
}

Subscriber::ensureIndex();

?>

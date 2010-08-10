<?php 

require_once("framework/request.php");
require_once("collections/MongoCollectionBase.php");
require_once("collections/User.php");

define('ID', '_id');
define('URL', 'url');
define('USER_ID', 'userId');
define('TAGS', 'tags');

define('TAB_LINKS', 'tabLinks');

define('URL', 'url');
define('SHARED', 'shared');

define('SESSION', 'session');

class Session extends MongoCollectionBase
{
	public static function createSessionFromRequest()
	{
		$newSession = array(URL=>requestParam(URL),
							USER_ID=>User::getId(),
							TAGS=>requestParam(TAGS));
							
		return $newSession;
	}
	
	public static function createLinkFromRequest()
	{
		$newLink = array(URL=>requestParam(URL));
							
		return $newLink;
	}
	
	public static function getOrCreateSessionByUrl()
	{
		$retval = MongoCollectionBase::executeFindOneQuery(array(URL=>requestParam(URL), USER_ID=> User::getId()), SESSION);
		
		if ($retval == null)
		{
			$retval = Session::createSessionFromRequest();
			$status = MongoCollectionBase::executeSave($retval, SESSION);
		}
		
		return $retval;
	}
	
	public static function addLink()
	{
		$retval = MongoCollectionBase::executeUpdate(
				array(ID=>new MongoId(requestParam(ID)), USER_ID => User::getId()),						
				array("\$push"=>array(TAB_LINKS=>Session::createLinkFromRequest())),
				SESSION);
				
		return $retval;
	}
	
	public static function removeLink()
	{
		$retval = MongoCollectionBase::executeUpdate(
				array(ID=>new MongoId(requestParam(ID)), USER_ID => User::getId()),						
				array("\$pull"=>array(TAB_LINKS=> Session::createLinkFromRequest() )),
				SESSION);
				
		return $retval;
	}
	
	public static function ensureIndex()
	{
		MongoCollectionBase::ensureIndex(array(URL=>1, USER_ID=>1),SESSION);
		MongoCollectionBase::ensureIndex(array(TAGS=>1),SESSION);
	}
	
	public static function getSessionById()
	{
		$retval = MongoCollectionBase::executeFindOneQuery(array(ID=>new MongoId(requestParam(ID))), SESSION);
		
		return $retval;
	}
	
	// copies the session in its current state and returns it
	public static function shareSession()
	{
		$sessionToShare = self::getSessionById();

		if ($sessionToShare != null)
		{
			// copy this session
			unset($sessionToShare[ID]);
			
			$sessionToShare[SHARED] = true;

			$retval = $sessionToShare;
			$status = MongoCollectionBase::executeSave($retval, SESSION);
			
			return $retval;
		}
		else
		{
			print "Not valid sessionId";			
		}
	}
}

Session::ensureIndex();

?>

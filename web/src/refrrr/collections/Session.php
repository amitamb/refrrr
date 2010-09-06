<?php 

require_once("framework/request.php");
require_once("collections/MongoCollectionBase.php");
require_once("collections/User.php");

define('ID', '_id');
define('URL', 'url');
define('CREATED_AT', 'created_at');
define('USER_ID', 'userId');
define('TAGS', 'tags');

define('TAB_LINKS', 'tabLinks');
define('LINKS_HISTORY', 'linksHistory');

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
	
	public static function createHistoryLinkFromRequest()
	{
		$newLink = array(URL=>requestParam(URL), CREATED_AT => time());
							
		return $newLink;
	}
	
	public static function createLinkFromRequest()
	{
		$newLink = array(URL=>requestParam(URL));
							
		return $newLink;
	}
	
	public static function getOrCreateSessionByUrl($includeHistory = false)
	{
		$retval = MongoCollectionBase::executeFindOneQuery(array(URL=>requestParam(URL), USER_ID=> User::getId()), SESSION);
		
		if ($retval == null)
		{
			$retval = Session::createSessionFromRequest();
			$status = MongoCollectionBase::executeSave($retval, SESSION);
		}
		
		return self::removeHistoryBeforeReturning($retval, $includeHistory);
	}
	
	public static function addLink()
	{
		$retval = MongoCollectionBase::executeUpdate(
				array(ID=>new MongoId(requestParam(ID)), USER_ID => User::getId()),						
				array("\$push"=>array(TAB_LINKS=>Session::createLinkFromRequest())),
				SESSION);
				
		// linksHistory
		$retval2 = MongoCollectionBase::executeUpdate(
				array(ID=>new MongoId(requestParam(ID)), USER_ID => User::getId()),						
				array("\$push"=>array(LINKS_HISTORY=>Session::createHistoryLinkFromRequest())),
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
	
	public static function getSessionById($includeHistory = false)
	{
		$retval = MongoCollectionBase::executeFindOneQuery(array(ID=>new MongoId(requestParam(ID))), SESSION);
		
		return self::removeHistoryBeforeReturning($retval, $includeHistory);
	}
	
	protected static function removeHistoryBeforeReturning($session, $includeHistory)
	{
		if (! $includeHistory)
		{
			$session[LINKS_HISTORY] = null;
		}

		return $session;
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

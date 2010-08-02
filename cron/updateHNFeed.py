import pymongo
from pymongo import Connection

#########################
# By design:
# Links once added will have same comment link and title. It can not be changed
# later even if someone submits same link again or changes the title
#########################
conn = Connection()
db = conn.refrrr
coll = db.hnlinks

print coll.count()

TITLE = 'title'
URL = 'url'
COMMENTS_URL = 'commentsUrl'

def getHNLinkDocument(title, url, commentsUrl):
	return {TITLE : title,
			URL : url,
			COMMENTS_URL : commentsUrl}
			
def ensureIndexes():
	coll.ensure_index(URL, unique = True)

#db.drop_collection('hnlinks')
ensureIndexes()

import feedparser

d = feedparser.parse("http://news.ycombinator.com/rss")

for entry in d.entries:
	try:
		#print str(entry.title)
		print coll.insert(getHNLinkDocument(entry.title, entry.links[0].href, entry.comments))
	except:
		print "Error in url" + entry.title.encode('utf-8')


# small tests
#print "http://www.tbray.org/ongoing/When/201x/2010/07/30/Mobile-Market-Share"
#print coll.find_one({URL : "http://www.tbray.org/ongoing/When/201x/2010/07/30/Mobile-Market-Share"})

#!/usr/bin/sh
rm -f /srv/parentwall/public/blacklists/master
touch /srv/parentwall/public/blacklists/master
/usr/bin/wget https://sourceforge.net/p/dansguardian/code/HEAD/tree/trunk/dansguardian/configs/lists/blacklists/ads/domains?format=raw -O /srv/parentwall/public/blacklistsraw/dansadblacklist
/usr/bin/wget http://www.volkerschatz.com/net/adpaths -O /srv/parentwall/public/blacklistsraw/volkerschatz
/usr/bin/wget http://pgl.yoyo.org/adservers/iplist.php -O /srv/parentwall/public/blacklistsraw/yoyoip
/usr/bin/wget http://pgl.yoyo.org/adservers/serverlist.php\?hostformat\=\;showintro\=0 -O /srv/parentwall/public/blacklistsraw/yoyohostname
/usr/bin/wget http://mirror1.malwaredomains.com/files/domains.txt -O /srv/parentwall/public/blacklistsraw/malwaredomainslist
/usr/bin/wget http://mirror1.malwaredomains.com/files/db.blacklist -O /srv/parentwall/public/blacklistsraw/db.blacklist

/usr/bin/php /srv/parentwall/public/blacklistcleanup/dansadblacklist.php >> /srv/parentwall/public/blacklists/master
/usr/bin/php /srv/parentwall/public/blacklistcleanup/db.blacklist.php >> /srv/parentwall/public/blacklists/master
/usr/bin/php /srv/parentwall/public/blacklistcleanup/malwaredomainslist.php >> /srv/parentwall/public/blacklists/master
/usr/bin/php /srv/parentwall/public/blacklistcleanup/volkerschatz.php >> /srv/parentwall/public/blacklists/master
/usr/bin/php /srv/parentwall/public/blacklistcleanup/yoyohostname.php >> /srv/parentwall/public/blacklists/master
/usr/bin/php /srv/parentwall/public/blacklistcleanup/yoyoip.php >> /srv/parentwall/public/blacklists/master

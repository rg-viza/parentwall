#!/usr/bin/sh
/usr/bin/wget https://sourceforge.net/p/dansguardian/code/HEAD/tree/trunk/dansguardian/configs/lists/blacklists/ads/domains?format=raw -O /srv/parentwall/public/blacklists/dansadblacklist
/usr/bin/wget http://www.volkerschatz.com/net/adpaths -O /srv/parentwall/public/blacklists/volkerschatz
/usr/bin/wget http://pgl.yoyo.org/adservers/iplist.php -O /srv/parentwall/public/blacklists/yoyoip
/usr/bin/wget http://pgl.yoyo.org/adservers/serverlist.php\?hostformat\=\;showintro\=0 -O /srv/parentwall/public/blacklists/yoyohostname
/usr/bin/wget http://mirror1.malwaredomains.com/files/domains.txt -O /srv/parentwall/public/blacklists/malwaredomainslist
/usr/bin/wget http://mirror1.malwaredomains.com/files/db.blacklist -O /srv/parentwall/public/blacklists/db.blacklist

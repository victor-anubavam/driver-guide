#!/bin/sh
TODAY=$(date +"%m_%d_%y_%H_%M_%S")
# Remote machine details
REMOTEHOSTNAME='50.57.179.229'
REMOTEHOSTUSER='root'
REMOTEDBDIR='/var/www/html/dev.private-transfer.anubavam.net/trunk/db'
REMOTEMYSQLUSR='anubavam'
REMOTEMYSQLPSS='xVGjzmdstBR4'
REMOTEMYSQLDB='private-transfer'
REMOTEDUMPFILE='private_transfer_'$TODAY'_prod.sql'
REMOTETARFILE='dev.private-transfer.tar'
REMOTECOMPRESSFILE=$REMOTETARFILE'.gz'

#Local Mysql details
LOCMYSQLUSR='root'
LOCMYSQLDB='private-transfer'
LOCDBDIR='/home/anubavam-drupal/WorkingProjects/private-transfer/db' 
#LOCDBDIR='/home/anu-victor/WorkingProjects/iko/db' 
LOCDUMPFILE='private_transfer_'$TODAY'_dev.sql'
CURLOC=$(pwd)



#Taking db dump and commiting the same to git
ssh -l $REMOTEHOSTUSER $REMOTEHOSTNAME <<EOF
cd $REMOTEDBDIR
mysqldump -u $REMOTEMYSQLUSR -p$REMOTEMYSQLPSS  $REMOTEMYSQLDB > $REMOTEDUMPFILE
tar -cvf $REMOTETARFILE $REMOTEDUMPFILE
gzip -f $REMOTETARFILE
git pull
git commit $REMOTECOMPRESSFILE -m "db updated"
git push
EOF

#git update in local & updating db
cd $LOCDBDIR
git pull
tar -zxvf $REMOTECOMPRESSFILE
mysqldump -u $LOCMYSQLUSR $LOCMYSQLDB > $LOCDUMPFILE
mysql -u $LOCMYSQLUSR $LOCMYSQLDB < $REMOTEDUMPFILE
cd $CURLOC

#!/bin/sh
TODAY=$(date +"%m_%d_%y_%H_%M_%S")

#Local Mysql details
LOCMYSQLUSR='root'
LOCMYSQLDB='private-transfer'
LOCDBDIR='/home/anubavam-drupal/WorkingProjects/private-transfer/db' 
LOCDUMPFILE='private-transfer_'$TODAY'_dev.sql'
CURLOC=$(pwd)

# Remote machine details
REMOTEHOSTNAME='50.57.179.229'
REMOTEHOSTUSER='root'
REMOTEDIR='/var/www/html/dev.private-transfer.anubavam.net/trunk'
REMOTEDBDIR='/var/www/html/dev.private-transfer.anubavam.net/trunk/db'
REMOTEMYSQLUSR='anubavam'
REMOTEMYSQLPSS='xVGjzmdstBR4'
REMOTEMYSQLDB='private-transfer'
REMOTEDUMPFILE='private-transfer_'$TODAY'_prod.sql'

TARFILE='dev.private-transfer.tar'
COMPRESSFILE='dev.private-transfer.tar.gz'

#Taking DB dump at local commiting to git 
cd $LOCDBDIR
mysqldump -u $LOCMYSQLUSR $LOCMYSQLDB > $LOCDUMPFILE
tar -cvf $TARFILE $LOCDUMPFILE
gzip -f $TARFILE
git pull
git commit $COMPRESSFILE -m "db updated"
git push

#Connecting Remote m/c and updating the db 
ssh -l $REMOTEHOSTUSER $REMOTEHOSTNAME <<EOF
cd $REMOTEDIR
git pull
cd $REMOTEDBDIR
mysqldump -u $REMOTEMYSQLUSR -p$REMOTEMYSQLPSS  $REMOTEMYSQLDB > $REMOTEDUMPFILE
tar -zxvf $COMPRESSFILE
mysql -u  $REMOTEMYSQLUSR -p$REMOTEMYSQLPSS $REMOTEMYSQLDB < $LOCDUMPFILE
EOF

cd $CURLOC


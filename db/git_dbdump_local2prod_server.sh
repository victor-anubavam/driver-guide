#!/bin/sh
TODAY=$(date +"%m_%d_%y_%H_%M_%S")

#Local Mysql details
LOCMYSQLUSR='root'
LOCMYSQLDB='private-transfer'
LOCDBDIR='/home/anubavam-drupal/WorkingProjects/private-transfer/db' 
LOCDUMPFILE='private-transfer_'$TODAY'_dev.sql'
CURLOC=$(pwd)

# Remote machine details
REMOTEHOSTNAME='166.78.30.73'
REMOTEHOSTUSER='root'
REMOTEDIR='/var/www/html/privatetransfer/trunk'
REMOTEDBDIR='/var/www/html/privatetransfer/trunk/db'
REMOTEMYSQLUSR='root'
REMOTEMYSQLPSS='dGGSWxqbSl4Q'
REMOTEMYSQLDB='privatetransfer'
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


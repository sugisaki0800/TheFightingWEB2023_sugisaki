#!/bin/bash

# if [ ! -d /opt/src/sample ]; then
#   mkdir /opt/src/sample
# fi

docker-compose stop
docker-compose rm -vf
docker-compose build
docker-compose up -d

# if [ ! -f /opt/src/sample/index.php ]; then
#   echo "<?php echo 'こんにちは<br>やさしいせかい！！';" > /opt/src/sample/index.php
#   sudo chown vagrant:vagrant -R /opt/src/sample
# fi

# ../common/docker-restart.sh my_php

#!/bin/sh

RETRIES=45

while ! php bin/console doctrine:query:sql "SELECT '';" > /dev/null 2>&1;
do
    echo "Waiting for database server, $((RETRIES--)) remaining attempts..."
    sleep 1
    if [ $RETRIES -eq 0 ]; then
      echo "We have been waiting for database too long already; failing."
      exit 1
    fi;
done
echo "Database is ready"

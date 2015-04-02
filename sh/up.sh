#!/bin/bash

git add *
git commit -a -m "whatever i changed"
git push

rsync -av /home/jared/git/ircd/ jared@192.168.0.21:/home/jared/git/ircd/

exit 0

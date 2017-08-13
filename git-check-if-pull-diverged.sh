#!/bin/sh

#
# Source: http://stackoverflow.com/questions/3258243/git-check-if-pull-needed
#
COUNT=$(git rev-list clean-up...sstok/clean-up --count)

if [ "$COUNT" -ge  "1" ]; then
    echo 'Must update'
#    git pull
    echo 'Updated, will send to servers'
else
    echo 'All is fine'
fi

# exit 0

LOCAL=$(git rev-parse clean-up)
REMOTE=$(git rev-parse sstok/clean-up)
BASE=$(git merge-base clean-up sstok/clean-up)

if [ "$LOCAL" = "$REMOTE" ]; then
    echo "Up-to-date"
elif [ "$LOCAL" = "$BASE" ]; then
    echo "Need to pull"
elif [ "$REMOTE" = "$BASE" ]; then
    echo "Need to push"
else
    echo "Diverged"
fi

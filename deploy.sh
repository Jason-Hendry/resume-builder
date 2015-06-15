#!/bin/bash

: ${DEPLOY_REMOTE_USER:?"variable required"}
: ${DEPLOY_REMOTE_HOST:?"variable required"}
: ${DEPLOY_APP_PATH:?"variable required"}
: ${DEPLOY_WEB_USER:="www-data"}
: ${DEPLOY_GIT_BRANCH:="master"}
: ${DEPLOY_RELEASE:=$(date +%Y%m%d%H%M%S)}
: ${DEPLOY_COMPOSER_BIN:="\$HOME/composer.phar"}

case $1 in
    setup)
        echo Setup
        ssh $DEPLOY_REMOTE_USER@$DEPLOY_REMOTE_HOST "mkdir -p $DEPLOY_APP_PATH/shared/shared-files && mkdir -p $DEPLOY_APP_PATH/current && mkdir -p $DEPLOY_APP_PATH/releases && cd $DEPLOY_APP_PATH/shared && git clone https://github.com/Jason-Hendry/resume-builder.git cached-copy"
        ;;
    deploy)
        echo Pulling $DEPLOY_GIT_BRANCH to $DEPLOY_REMOTE_USER@$DEPLOY_REMOTE_HOST:$DEPLOY_APP_PATH/releases/$DEPLOY_RELEASE

        scp shared-files.list $DEPLOY_REMOTE_USER@$DEPLOY_REMOTE_HOST:$DEPLOY_APP_PATH/shared/shared-files.list
        ssh $DEPLOY_REMOTE_USER@$DEPLOY_REMOTE_HOST "cd $DEPLOY_APP_PATH/shared/cached-copy/ && git pull && git checkout $DEPLOY_GIT_BRANCH && rsync -au --exclude-from=$DEPLOY_APP_PATH/shared/shared-files.list $DEPLOY_APP_PATH/shared/cached-copy/ $DEPLOY_APP_PATH/releases/$RELEASE/ && rm -rf $DEPLOY_APP_PATH/current && ln -s $DEPLOY_APP_PATH/releases/$RELEASE $DEPLOY_APP_PATH/current && rsync -au $DEPLOY_APP_PATH/shared/shared-files/ $DEPLOY_APP_PATH/current/ && cd $DEPLOY_APP_PATH/current && php $DEPLOY_COMPOSER_BIN install && php app/console assetic:dump --env prod --no-debug && rsync -au --files-from=$DEPLOY_APP_PATH/shared/shared-files.list $DEPLOY_APP_PATH/current/ $DEPLOY_APP_PATH/shared/shared-files/ && chgrp -R $DEPLOY_WEB_USER $DEPLOY_APP_PATH/{current,releases/$RELEASE}/app/{logs,cache}"
        ;;
    *)
        echo Usage $0 setup|deploy
        ;;
esac



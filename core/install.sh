#!/bin/bash
################################################################################
#
# Projet d'installer... ca va pas loin, le but etant qd meme de
# pouvoir le copier coller et qu'il marche direct
#
# Date       Auteur       : Contenu
# 2014-09-15 Jean-David Labails   : debut du script
#
################################################################################


#Parametres generaux
DIR_CORE="$( cd "$( dirname "${BASH_SOURCE[0]}" )" && pwd )"
DIR_GEN=${DIR_CORE}/../generated
DIR_PHP=${DIR_GEN}/php
DIR_REPORT=${DIR_GEN}/reports
DIR_JETON=${DIR_GEN}/jetons
DIR_SH=${DIR_GEN}/sh
DIR_PHP=${DIR_GEN}/php

WEB_USER=www-data:www-data
read -p "Please enter your web server user [www-data:www-data] : " INPUT
if [ $INPUT != "" ] 
then 
    WEB_USER=$INPUT
fi


function createDir4Web {
    if [ ! -d $1 ]
    then
        echo 'Dir creation of  '$1
        mkdir $1
    fi

    echo 'Change owner & rights of dir '$1
    chown -R ${WEB_USER} $1
    chmod -R 755 $1
}

# on cree les rep de report
createDir4Web ${DIR_GEN}
createDir4Web ${DIR_PHP}
createDir4Web ${DIR_SH}
createDir4Web ${DIR_REPORT}
createDir4Web ${DIR_REPORT}/COUNT
createDir4Web ${DIR_REPORT}/CPD
createDir4Web ${DIR_REPORT}/CS
createDir4Web ${DIR_REPORT}/LOC
createDir4Web ${DIR_REPORT}/DEPEND
createDir4Web ${DIR_REPORT}/DOCS
createDir4Web ${DIR_REPORT}/MD
createDir4Web ${DIR_REPORT}/TEST
createDir4Web ${DIR_REPORT}/HISTORIQUE

createDir4Web ${DIR_SH}/one

createDir4Web ${DIR_JETON}

echo 'Change owner & rights of file '${DIR_SH}/pa.sh
touch ${DIR_SH}/pa.sh
chown ${WEB_USER} ${DIR_SH}/pa.sh
chmod 755 ${DIR_SH}/pa.sh

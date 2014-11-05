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
DIR_ASSET_SH="$( cd "$( dirname "${BASH_SOURCE[0]}" )" && pwd )"
DIR_PA=${DIR_ASSET_SH}/../..
DIR_PHAR=${DIR_PA}/_phar
DIR_REPORT=${DIR_PA}/reports
DIR_JETON=${DIR_PA}/jetons


function createDossier4Web {
    if [ ! -d $1 ]
    then
        echo 'Dir creation of  '$1
        mkdir $1
    fi

    echo 'Change owner & rights of dir '$1
    chown apache:apache $1
    chmod 755 $1
}

# on cree les rep de report
createDossier4Web ${DIR_REPORT}
createDossier4Web ${DIR_REPORT}/COUNT
createDossier4Web ${DIR_REPORT}/CPD
createDossier4Web ${DIR_REPORT}/CS
createDossier4Web ${DIR_REPORT}/LOC
createDossier4Web ${DIR_REPORT}/DEPEND
createDossier4Web ${DIR_REPORT}/DOCS
createDossier4Web ${DIR_REPORT}/MD
createDossier4Web ${DIR_REPORT}/TEST

createDossier4Web ${DIR_JETON}

echo 'Change owner & rights of file '${DIR_ASSET_SH}/pa.sh
touch ${DIR_ASSET_SH}/pa.sh
chown apache:apache ${DIR_ASSET_SH}/pa.sh
chmod 755 ${DIR_ASSET_SH}/pa.sh

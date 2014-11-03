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
DIR_PA=${DIR_ASSET_SH}/../../
DIR_PHAR=${DIR_PA}/_phar
DIR_REPORT=${DIR_PA}/reports

# on cree les rep de report
mkdir ${DIR_REPORT}
mkdir ${DIR_REPORT}/COUNT
mkdir ${DIR_REPORT}/CPD
mkdir ${DIR_REPORT}/CS
mkdir ${DIR_REPORT}/LOC
mkdir ${DIR_REPORT}/DEPEND
mkdir ${DIR_REPORT}/DOCS
mkdir ${DIR_REPORT}/MD
mkdir ${DIR_REPORT}/TEST

# on leur met des droits extraordinairs car apache et notre utilisateur doivent pouvoir y accèder
chmod -R 777 ${DIR_REPORT}


chmod -R 777 ${DIR_ASSET_SH}

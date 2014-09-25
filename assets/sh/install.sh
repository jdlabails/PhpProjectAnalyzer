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
DIR_PA=/home/FIDUCIAL/adm_jd.labails/fos/web/pa
DIR_PHAR=${DIR_PA}/_phar
DIR_REPORT=${DIR_PA}/reports

# on cree les rep de report
mkdir ${DIR_REPORT}/COUNT
mkdir ${DIR_REPORT}/CPD
mkdir ${DIR_REPORT}/CS
mkdir ${DIR_REPORT}/DEPEND
mkdir ${DIR_REPORT}/DOCS
mkdir ${DIR_REPORT}/MD
mkdir ${DIR_REPORT}/TEST

# on leur met des droits extraodinaire car apache et notre utilisateur doivent pouvoir y accèder
chmod -R 777 ${DIR_REPORT}


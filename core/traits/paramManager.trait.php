<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

trait paramManager
{
    
    /**
     * Va chercher les param du fichier yml
     * @param string $name cle du param
     * @return string value du param
     */
    function getParam($name, $attr = '')
    {
        if (isset($this->_parameters[$name])) {
            if ($attr != '' && isset($this->_parameters[$name][$attr])) {
                return $this->_parameters[$name][$attr];
            }

            return $this->_parameters[$name];
        }

        return '';
    }
        
    /**
     * Renvoi vrai si la param est à true dans le yml
     * @param type $paramName
     * @return boolean
     */
    function isEnable($paramName)
    {
        if (isset($this->_parameters[$paramName])) {
            if (is_array($this->_parameters[$paramName])) {
                return $this->_parameters[$paramName]['enable'];
            }

            return $this->_parameters[$paramName];
        }

        return false;        
    }    
}
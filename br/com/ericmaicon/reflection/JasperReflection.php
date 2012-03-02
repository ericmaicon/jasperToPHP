<?php

/**
 * JasperReflection
 *
 * @author Eric Maicon <eric@ericmaicon.com.br>
 * @version $Id: JasperReflection.php 1 2012-02-24 09:03:02 ericmaicon $
 * @package 
 * @since 1.0
 */
class JasperReflection {

    public static function getNewInstance($bean) {
        return new $bean;
    }

    public static function getVars($bean) {

        if (is_string($bean)) {
            return get_class_vars($bean);
        } else {
            return get_class_vars(get_class($bean));
        }
    }

}
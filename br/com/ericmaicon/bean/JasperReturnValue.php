<?php

require_once('br/com/ericmaicon/bean/AbstractJasper.php');

/**
 * JasperReturnValue
 *
 * @author Eric Maicon <eric@ericmaicon.com.br>
 * @version $Id: JasperReturnValue.php 1 2012-02-24 09:03:02 ericmaicon $
 * @package 
 * @since 1.0
 */

/** @TagAnnotation(tagName="returnValue") */
class JasperReturnValue extends AbstractJasper {

    public $subreportVariable= null;
    public $toVariable = null;
    public $calculation = null;

}
<?php
require_once('br/com/ericmaicon/bean/AbstractJasper.php');

/**
 * JasperVariable
 *
 * @author Eric Maicon <eric@ericmaicon.com.br>
 * @version $Id: JasperVariable.php 1 2012-02-24 09:03:02 ericmaicon $
 * @package 
 * @since 1.0
 */
/** @TagAnnotation(tagName="variable") */
class JasperVariable extends AbstractJasper {
    public $name = null;
    public $class = null;
    public $resetType = null;
    public $calculation = null;
    
    /** @BeanAnnotation(className="JasperVariableExpression") */
    public $variableExpression = null;
}
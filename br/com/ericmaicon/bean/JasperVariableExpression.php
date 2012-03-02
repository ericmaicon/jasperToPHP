<?php
require_once('br/com/ericmaicon/bean/AbstractJasper.php');

/**
 * JasperVariableExpression
 *
 * @author Eric Maicon <eric@ericmaicon.com.br>
 * @version $Id: JasperVariableExpression.php 1 2012-02-24 09:03:02 ericmaicon $
 * @package 
 * @since 1.0
 */
/** @TagAnnotation(tagName="variableExpression") */
class JasperVariableExpression extends AbstractJasper {
    public $content = null;
}
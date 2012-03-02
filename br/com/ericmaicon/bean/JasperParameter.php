<?php
require_once('br/com/ericmaicon/bean/AbstractJasper.php');

/**
 * JasperParameter
 *
 * @author Eric Maicon <eric@ericmaicon.com.br>
 * @version $Id: JasperParameter.php 1 2012-02-24 09:03:02 ericmaicon $
 * @package 
 * @since 1.0
 */
/** @TagAnnotation(tagName="parameter") */
class JasperParameter extends AbstractJasper {
    public $name = null;
    public $class = null;
    public $isForPrompting = null;
    
    /** @BeanAnnotation(className="JasperDefaultValueExpression") */
    public $defaultValueExpression = null;
}
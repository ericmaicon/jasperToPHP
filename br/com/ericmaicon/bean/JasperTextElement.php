<?php
require_once('br/com/ericmaicon/bean/AbstractJasper.php');

/**
 * JasperTextElement
 *
 * @author Eric Maicon <eric@ericmaicon.com.br>
 * @version $Id: JasperTextElement.php 1 2012-02-24 09:03:02 ericmaicon $
 * @package 
 * @since 1.0
 */
/** @TagAnnotation(tagName="textElement") */
class JasperTextElement extends AbstractJasper {
    public $textAlignment = null;
    
    /** @BeanAnnotation(className="JasperFont") */
    public $font = null;
}
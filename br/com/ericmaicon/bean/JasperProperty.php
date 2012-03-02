<?php
require_once('br/com/ericmaicon/bean/AbstractJasper.php');

/**
 * JasperProperty
 *
 * @author Eric Maicon <eric@ericmaicon.com.br>
 * @version $Id: JasperProperty.php 1 2012-02-24 09:03:02 ericmaicon $
 * @package 
 * @since 1.0
 */
/** @TagAnnotation(tagName="property") */
class JasperProperty extends AbstractJasper {
    public $name = null;
    public $value = null;
}
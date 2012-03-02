<?php
require_once('br/com/ericmaicon/bean/AbstractJasper.php');

/**
 * JasperField
 *
 * @author Eric Maicon <eric@ericmaicon.com.br>
 * @version $Id: JasperField.php 1 2012-02-24 09:03:02 ericmaicon $
 * @package 
 * @since 1.0
 */
/** @TagAnnotation(tagName="field") */
class JasperField extends AbstractJasper {
    public $name = null;
    public $class = null;
}
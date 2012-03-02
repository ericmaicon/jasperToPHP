<?php
require_once('br/com/ericmaicon/bean/AbstractJasper.php');

/**
 * JasperText
 *
 * @author Eric Maicon <eric@ericmaicon.com.br>
 * @version $Id: JasperText.php 1 2012-02-24 09:03:02 ericmaicon $
 * @package 
 * @since 1.0
 */
/** @TagAnnotation(tagName="text") */
class JasperText extends AbstractJasper {
    public $content = null;
}
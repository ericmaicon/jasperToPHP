<?php
require_once('br/com/ericmaicon/bean/AbstractJasper.php');

/**
 * JasperFont
 *
 * @author Eric Maicon <eric@ericmaicon.com.br>
 * @version $Id: JasperFont.php 1 2012-02-24 09:03:02 ericmaicon $
 * @package 
 * @since 1.0
 */
/** @TagAnnotation(tagName="font") */
class JasperFont extends AbstractJasper {
    public $size = null;
    public $isBold = null;
}
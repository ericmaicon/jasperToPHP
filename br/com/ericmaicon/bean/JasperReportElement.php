<?php
require_once('br/com/ericmaicon/bean/AbstractJasper.php');

/**
 * JasperReportElement
 *
 * @author Eric Maicon <eric@ericmaicon.com.br>
 * @version $Id: JasperReportElement.php 1 2012-02-24 09:03:02 ericmaicon $
 * @package 
 * @since 1.0
 */
/** @TagAnnotation(tagName="reportElement") */
class JasperReportElement extends AbstractJasper {
    public $isPrintRepeatedValues = null;
    public $isRemoveLineWhenBlank = null;
    public $x = null;
    public $y = null;
    public $width = null;
    public $height = null;
    public $backcolor = null;
}
<?php
require_once('br/com/ericmaicon/bean/AbstractJasper.php');

/**
 * JasperRectangle
 *
 * @author Eric Maicon <eric@ericmaicon.com.br>
 * @version $Id: JasperRectangle.php 1 2012-02-24 09:03:02 ericmaicon $
 * @package 
 * @since 1.0
 */
/** @TagAnnotation(tagName="rectangle") */
class JasperRectangle extends AbstractJasper {
    
    /** @BeanAnnotation(className="JasperReportElement") */
    public $reportElement = null;
}
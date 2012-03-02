<?php
require_once('br/com/ericmaicon/bean/AbstractJasper.php');

/**
 * JasperImage
 *
 * @author Eric Maicon <eric@ericmaicon.com.br>
 * @version $Id: JasperImage.php 1 2012-02-24 09:03:02 ericmaicon $
 * @package 
 * @since 1.0
 */
/** @TagAnnotation(tagName="image") */
class JasperImage extends AbstractJasper {
    /** @BeanAnnotation(className="JasperReportElement") */
    public $reportElement = null;
    
    /** @BeanAnnotation(className="JasperImageExpression") */
    public $imageExpression = null;
}
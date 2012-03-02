<?php
require_once('br/com/ericmaicon/bean/AbstractJasper.php');

/**
 * JasperBand
 *
 * @author Eric Maicon <eric@ericmaicon.com.br>
 * @version $Id: JasperBand.php 1 2012-02-24 09:03:02 ericmaicon $
 * @package 
 * @since 1.0
 */
/** @TagAnnotation(tagName="band") */
class JasperBand extends AbstractJasper {
    public $height = null;
    public $splitType = null;
    
    /** @BeanAnnotation(className="JasperImage") */
    public $image = null;
    
    /** @BeanAnnotation(className="JasperSubreport") */
    public $subreport = null;
    
    /** @BeanAnnotation(className="JasperRectangle") */
    public $rectangle = null;
    
    /** @BeanAnnotation(className="JasperLine") */
    public $line = null;
    
    /** @BeanAnnotation(className="JasperTextField") */
    public $textField = null;
    
    /** @BeanAnnotation(className="JasperStaticText") */
    public $staticText = null;
}
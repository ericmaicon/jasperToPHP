<?php

require_once('br/com/ericmaicon/bean/AbstractJasper.php');

/**
 * Jasper
 *
 * @author Eric Maicon <eric@ericmaicon.com.br>
 * @version $Id: Jasper.php 1 2012-02-24 09:03:02 ericmaicon $
 * @package 
 * @since 1.0
 */
/** @TagAnnotation(tagName="jasperReport") */
class Jasper extends AbstractJasper {
    public $name = null;
    public $pageWidth = null;
    public $pageHeight = null;
    public $orientation = null;
    public $columnWidth = null;
    public $leftMargin = null;
    public $rightMargin = null;
    public $topMargin = null;
    public $bottomMargin = null;

//    /** @BeanAnnotation(className="JasperStyle") */
//    public $style = null;

    /** @BeanAnnotation(className="JasperBackground") */
    public $background = null;

    /** @BeanAnnotation(className="JasperProperty") */
    public $properties = null;

    /** @BeanAnnotation(className="JasperParameter") */
    public $parameters = null;

    /** @BeanAnnotation(className="JasperQueryString") */
    public $queryString = null;

    /** @BeanAnnotation(className="JasperField") */
    public $field = null;

    /** @BeanAnnotation(className="JasperVariable") */
    public $variable = null;

    /** @BeanAnnotation(className="JasperColumnHeader") */
    public $columnHeader = null;

    /** @BeanAnnotation(className="JasperTitle") */
    public $title = null;

    /** @BeanAnnotation(className="JasperDetail") */
    public $detail = null;

    /** @BeanAnnotation(className="JasperColumnFooter") */
    public $columnFooter = null;

}
<?php

require_once('br/com/ericmaicon/bean/AbstractJasper.php');

/**
 * JasperStaticText
 *
 * @author Eric Maicon <eric@ericmaicon.com.br>
 * @version $Id: JasperStaticText.php 1 2012-02-24 09:03:02 ericmaicon $
 * @package 
 * @since 1.0
 */

/** @TagAnnotation(tagName="staticText") */
class JasperStaticText extends AbstractJasper {

    /** @BeanAnnotation(className="JasperReportElement") */
    public $reportElement = null;

    /** @BeanAnnotation(className="JasperTextElement") */
    public $textElement = null;

    /** @BeanAnnotation(className="JasperText") */
    public $text = null;

}
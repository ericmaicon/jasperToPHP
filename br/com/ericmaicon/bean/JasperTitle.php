<?php
require_once('br/com/ericmaicon/bean/AbstractJasper.php');

/**
 * JasperTitle
 *
 * @author Eric Maicon <eric@ericmaicon.com.br>
 * @version $Id: JasperTitle.php 1 2012-02-24 09:03:02 ericmaicon $
 * @package 
 * @since 1.0
 */
/** @TagAnnotation(tagName="title") */
class JasperTitle extends AbstractJasper {
    /** @BeanAnnotation(className="JasperBand") */
    public $band = null;
}
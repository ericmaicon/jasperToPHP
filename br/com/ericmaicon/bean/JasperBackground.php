<?php
require_once('br/com/ericmaicon/bean/AbstractJasper.php');

/**
 * JasperBackground
 *
 * @author Eric Maicon <eric@ericmaicon.com.br>
 * @version $Id: JasperBackground.php 1 2012-02-24 09:03:02 ericmaicon $
 * @package 
 * @since 1.0
 */
/** @TagAnnotation(tagName="background") */
class JasperBackground extends AbstractJasper {
    /** @BeanAnnotation(className="JasperBand") */
    public $band = null;
}
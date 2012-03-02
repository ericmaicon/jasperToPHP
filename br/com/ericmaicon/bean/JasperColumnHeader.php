<?php
require_once('br/com/ericmaicon/bean/AbstractJasper.php');

/**
 * JasperColumnHeader
 *
 * @author Eric Maicon <eric@ericmaicon.com.br>
 * @version $Id: JasperColumnHeader.php 1 2012-02-24 09:03:02 ericmaicon $
 * @package 
 * @since 1.0
 */
/** @TagAnnotation(tagName="columnHeader") */
class JasperColumnHeader extends AbstractJasper {
    /** @BeanAnnotation(className="JasperBand") */
    public $band = null;
}
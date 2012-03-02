<?php
require_once('br/com/ericmaicon/bean/AbstractJasper.php');

/**
 * JasperQueryString
 *
 * @author Eric Maicon <eric@ericmaicon.com.br>
 * @version $Id: JasperQueryString.php 1 2012-02-24 09:03:02 ericmaicon $
 * @package 
 * @since 1.0
 */
/** @TagAnnotation(tagName="queryString") */
class JasperQueryString extends AbstractJasper {
    public $language = null;
    public $content = null;
}
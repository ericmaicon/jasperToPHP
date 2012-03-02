<?php

require_once('br/com/ericmaicon/bean/AbstractJasper.php');

/**
 * JasperSubreportParameter
 *
 * @author Eric Maicon <eric@ericmaicon.com.br>
 * @version $Id: JasperSubreportParameter.php 1 2012-02-24 09:03:02 ericmaicon $
 * @package 
 * @since 1.0
 */

/** @TagAnnotation(tagName="subreportParameter") */
class JasperSubreportParameter extends AbstractJasper {

    public $name = null;

    /** @BeanAnnotation(className="JasperSubreportParameterExpression") */
    public $subreportParameterExpression = null;

}
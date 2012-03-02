<?php

require_once('br/com/ericmaicon/bean/AbstractJasper.php');

/**
 * JasperSubreport
 *
 * @author Eric Maicon <eric@ericmaicon.com.br>
 * @version $Id: JasperSubreport.php 1 2012-02-24 09:03:02 ericmaicon $
 * @package 
 * @since 1.0
 */

/** @TagAnnotation(tagName="subreport") */
class JasperSubreport extends AbstractJasper {

    /** @BeanAnnotation(className="JasperReportElement") */
    public $reportElement = null;
    
    /** @BeanAnnotation(className="JasperSubreportParameter") */
    public $subreportParameter = null;
    
    /** @BeanAnnotation(className="JasperReturnValue") */
    public $returnValue = null;
    
    /** @BeanAnnotation(className="JasperConnectExpression") */
    public $connectExpression = null;
    
    /** @BeanAnnotation(className="JasperSubreportExpression") */
    public $subreportExpression = null;

}
<?php

require_once("br/com/ericmaicon/exception/JasperReaderException.php");
require_once("br/com/ericmaicon/reflection/JasperReflection.php");

require_once("libs/addendum/annotations.php");

require_once("br/com/ericmaicon/bean/JasperProperty.php");
require_once("br/com/ericmaicon/bean/JasperParameter.php");
require_once("br/com/ericmaicon/bean/JasperQueryString.php");
require_once("br/com/ericmaicon/bean/JasperField.php");
require_once("br/com/ericmaicon/bean/JasperVariable.php");
require_once("br/com/ericmaicon/bean/JasperTitle.php");
require_once("br/com/ericmaicon/bean/JasperBand.php");
require_once('br/com/ericmaicon/bean/JasperDefaultValueExpression.php');
require_once('br/com/ericmaicon/bean/JasperTextField.php');
require_once('br/com/ericmaicon/bean/JasperReportElement.php');
require_once('br/com/ericmaicon/bean/JasperTextElement.php');
require_once('br/com/ericmaicon/bean/JasperFont.php');
require_once('br/com/ericmaicon/bean/JasperTextFieldExpression.php');
require_once('br/com/ericmaicon/bean/JasperStaticText.php');
require_once('br/com/ericmaicon/bean/JasperImage.php');
require_once('br/com/ericmaicon/bean/JasperImageExpression.php');
require_once('br/com/ericmaicon/bean/JasperDetail.php');
require_once('br/com/ericmaicon/bean/JasperSubreport.php');
require_once('br/com/ericmaicon/bean/JasperSubreportParameter.php');
require_once('br/com/ericmaicon/bean/JasperSubreportParameterExpression.php');
require_once('br/com/ericmaicon/bean/JasperReturnValue.php');
require_once('br/com/ericmaicon/bean/JasperConnectExpression.php');
require_once('br/com/ericmaicon/bean/JasperSubreportExpression.php');
require_once('br/com/ericmaicon/bean/JasperColumnFooter.php');
require_once('br/com/ericmaicon/bean/JasperRectangle.php');
require_once('br/com/ericmaicon/bean/JasperText.php');
require_once('br/com/ericmaicon/bean/JasperLine.php');
require_once('br/com/ericmaicon/bean/JasperBackground.php');
require_once('br/com/ericmaicon/bean/JasperColumnHeader.php');
require_once('br/com/ericmaicon/bean/JasperVariableExpression.php');
require_once('br/com/ericmaicon/pdf/PdfUtils.php');
require_once('br/com/ericmaicon/utils/PixelUtils.php');

require_once('libs/xml2pdf/Xml2Pdf.php');

/**
 * JasperXml contains functions to help manage xml tags
 *
 * @author Eric Maicon <eric@ericmaicon.com.br>
 * @version $Id: JasperXml.php 1 2012-02-24 09:03:02 ericmaicon $
 * @package 
 * @since 1.0
 */
class JasperXml {

    /**
     * @var directory
     */
    private $directory;

    /**
     * @var PdfUtils.php
     */
    private $pdfUtils;
    public $url;
    public $username;
    public $password;
    public $parameters;
    public $subVars;

    /**
     * Read the jrxml
     */
    public function readJrxml($directory, $file) {
        if (!file_exists($directory . $file)) {
            throw new JasperReaderException("This file doesn`t exists!" . $directory . $file);
        }

        $this->directory = $directory;

        $doc = new DOMDocument();
        $doc->preserveWhiteSpace = FALSE;
        $doc->load($directory . $file);

        return $doc;
    }

    /**
     * Put all the attributes into a bean
     */
    private function xmlToBean($xmlContent, $class, $elements = null) {
        $returnArray = array();

//Getting the annotation`s class
        $reflectionClass = new ReflectionAnnotatedClass($class);
        if ($reflectionClass->hasAnnotation('TagAnnotation')) {

            $tagName = $reflectionClass->getAnnotation('TagAnnotation')->tagName;

//important thing: when has more than one tag with same name, we return an array:
            if ($elements == null) {
                $elements = $xmlContent->getElementsByTagName($tagName);
            } else {
                $elements = $elements->getElementsByTagName($tagName);
            }

            foreach ($elements as $element) {
                $instance = new $class;

//getting the reflection`s field
                $vars = JasperReflection::getVars($instance);
                foreach ($vars as $name => $value) {

//Getting the annotation`s field
                    $reflectionProperty = new ReflectionAnnotatedProperty($instance, $name);
                    if ($reflectionProperty->hasAnnotation('BeanAnnotation')) {
                        $className = $reflectionProperty->getAnnotation('BeanAnnotation')->className;

                        $instance->{$name} = $this->xmlToBean($xmlContent, $className, $element);
                    } else {
//if the annotation field doesn`t exists, we get the normal XML and put into the bean
                        $val = $this->nodeToBean($name, $element);

                        if (is_numeric($val) && $name != 'size') {
                            $instance->{$name} = PixelUtils::pixeltoMm($val);
                        } else {
//                            $instance->{$name} = utf8_encode($val);
                            $instance->{$name} = ($val);
                        }
                    }
                }

                array_push($returnArray, $instance);
            }
        } else {
            throw new JasperReaderException("There`s no tag specified in the class: " . $class);
        }

        if (count($returnArray) > 1) {
            return $returnArray;
        } else {
            if (count($returnArray) == 0) {
                return null;
//throw new JasperReaderException("There`s something wrong in the class: " . $class);
            }

            return $returnArray[0];
        }
    }

    private function addParameterInSql($sql, $paramName, $paramValue) {
//        $toReplace = array("new", "\"", ")", "(", "BigDecimal");
//
//        if (array_key_exists($parameter->name, $this->parameters)) {
//            $value = $this->parameters[$parameter->name];
//        } else {
//            $value = trim(str_replace($toReplace, "", $parameter->defaultValueExpression->content));
//        }

        $sql = str_replace("\$P{" . $paramName . "}", $paramValue, $sql);

        return $sql;
    }

    private function getDbThings($jasper, $parameters) {
        if ($jasper->queryString) {
            try {
                $conn = new PDO($this->url, $this->username, $this->password);

                $sql = $jasper->queryString->content;

                if (is_array($parameters)) {
                    foreach ($parameters as $paramName => $paramValue) {
                        $sql = $this->addParameterInSql($sql, $paramName, $paramValue);
                    }
                } else {
//TODO ?
//                $sql = $this->addParameterInSql($sql, $jasper->parameters);
                }

//executa a instrução de consulta
                $result = $conn->query($sql);
                return $result->fetchAll(PDO::FETCH_OBJ);
            } catch (Exception $e) {
                throw new JasperReaderException("Falha ao conectar com o banco!" . $e->getMessage());
            }
        }
    }

    /**
     * Return an xml attribute
     */
    private function nodeToBean($property, $element) {
//if is an attribute we`ll return the value...or the value in the tags!!
//TODO melhorar
        if ($property == 'content') {
            return $element->nodeValue;
        } else {
            return $element->getAttribute($property);
        }
    }

    /**
     * Print Jasper
     */
    public function printJasper($jasper, $dbResult, $subreport = false, $left = 0, $top = 0) {

        $this->pdfUtils = new PdfUtils($jasper->leftMargin, $jasper->topMargin);

        if (!$subreport) {
            $content = "<?xml version='1.0' encoding='utf-8'?>";
            $content .= "<pdf creator='DR' subject='' title='" . $jasper->name . "'>";
            $content .= "<stylesheet file='style.txt' />";
            $content .= "<body format='A4' unit='mm' orientation='" . substr($jasper->orientation, 0, 1) . "' marginleft='" . $jasper->leftMargin . "' marginright='" . $jasper->rightMargin . "' marginbottom='" . $jasper->bottomMargin . "' margintop='" . $jasper->topMargin . "'>";
            $content .= "<page>";
        } else {
            $content = "";
        }

        $height = 0;
        $width = 0;

        if ($dbResult) {

            $height = $top;
            $width = $left;

            //getting the itens from title`s band:
            if ($jasper->columnHeader) {
                $band = $this->getItensFromBand($jasper->columnHeader->band, (count($dbResult) > 0 ? $dbResult[0] : null), $this->parameters, $height, $width);
                $content .= $band['content'];

                if ($band['height'] > $jasper->columnHeader->band->height) {
                    $height += $band['height'];
                } else {
                    $height += $jasper->columnHeader->band->height;
                }
            }

            //getting the itens from title`s band:
            if ($jasper->title) {
                $band = $this->getItensFromBand($jasper->title->band, (count($dbResult) > 0 ? $dbResult[0] : null), $this->parameters, 0, $width);
                $content .= $band['content'];
                $height += $jasper->title->band->height;
            }

            $tempHeight = $height;

            //getting the itens from detail`s band:
            if ($jasper->detail) {

                foreach ($dbResult as $row) {
                    $band = $this->getItensFromBand($jasper->detail->band, $row, $this->parameters, $height, $width, false, $this->subVars);
                    $content .= $band['content'];

                    if (array_key_exists('vars', $band)) {
                        $this->subVars = $band['vars'];
                    }

                    if ($band['height'] > $jasper->detail->band->height) {
                        $height = $band['height'];
                    } else {
                        $height += $jasper->detail->band->height;
                    }
                }
            }

            //getting the itens from background's band:
            if ($jasper->background) {
                $band = $this->getItensFromBand($jasper->background->band, (count($dbResult) > 0 ? $dbResult[0] : null), $this->parameters, $tempHeight, $width, true);
                $content .= $band['content'];
            }

            //getting the itens from columnFooter`s band:
            if ($jasper->columnFooter) {
                $band = $this->getItensFromBand($jasper->columnFooter->band, (count($dbResult) > 0 ? $dbResult[0] : null), $this->parameters, $height, $width);
                $content .= $band['content'];
            }
        }

        $vars = $this->getTotalVars($jasper->variable, $dbResult);

        if (!$subreport) {
            $content .= "</page>";
            $content .= "</body>";
            $content .= "</pdf>";
        }

        if (!$subreport) {
            $obj = new Xml2Pdf($content);
            $pdf = $obj->render();
            $pdf->Output();
        } else {
            $content .="";

            $array = array();
            $array['content'] = $content;
            $array['height'] = $height;
            $array['vars'] = $vars;
            return $array;
        }
    }

    private function getTotalVars($variable, $dbResult) {
        $return = array();

        $i = 0;
        if (is_array($variable)) {
            foreach ($variable as $var) {
                $return[$i]['name'] = $var->name;
                $return[$i]['value'] = $this->getVar($var, $dbResult);
                $i++;
            }
        } else {
            $return[$i]['name'] = $variable->name;
            $return[$i]['value'] = $this->getVar($variable, $dbResult);
        }

        return $return;
    }

    private function getVar($variable, $dbResult) {
        $array = array('$F', '{', '}');

        if ($variable->variableExpression) {
            $var = str_replace($array, '', $variable->variableExpression->content);

            $return = 0;
            foreach ($dbResult as $row) {
                if ($variable->calculation == 'Sum') {
                    $return += $row->{$var};
                }
            }

            return $return;
        } else {
            return null;
        }
    }

    /**
     * print the fields
     */
    private function getItensFromBand($band, $row = null, $param = null, $height = 0, $width = 0, $background = false, $subVars = null) {
        $return = array();
        $return['content'] = '';
        $return['height'] = 0;
        $highestHeight = 0;

        $vars = JasperReflection::getVars($band);
        foreach ($vars as $name => $value) {
            switch ($name) {

                case 'rectangle':

                    if (is_array($band->rectangle)) {
                        foreach ($band->rectangle as $rectangle) {
                            $return['content'] .= $this->pdfUtils->printRectangle($rectangle, $height, $width, $background);
                        }
                    } else {
                        $return['content'] .= $this->pdfUtils->printRectangle($band->rectangle, $height, $width, $background);
                    }
                    break;

                case 'staticText':
                    if (is_array($band->staticText)) {
                        foreach ($band->staticText as $static) {
                            $return['content'] .= $this->pdfUtils->printStaticText($static, $height, $width);
                        }
                    } else {
                        $return['content'] .= $this->pdfUtils->printStaticText($band->staticText, $height, $width);
                    }
                    break;

                case 'textField':
                    if (is_array($band->textField)) {
                        foreach ($band->textField as $textField) {
                            $return['content'] .= $this->pdfUtils->printTextField($textField, $row, $param, $height, $width, $subVars);
                        }
                    } else {
                        $return['content'] .= $this->pdfUtils->printTextField($band->textField, $row, $param, $height, $width, $subVars);
                    }
                    break;

                case 'image':
                    if (is_array($band->image)) {
                        foreach ($band->image as $image) {
                            $img = $this->pdfUtils->printImage($this->directory, $image, $height, $width);

                            $return['content'] .= $img['content'];
                            $return['height'] += $img['height'];
                        }
                    } else {
                        $img = $this->pdfUtils->printImage($this->directory, $band->image, $height, $width);

                        $return['content'] .= $img['content'];
                        $return['height'] += $img['height'];
                    }
                    break;

                case 'line':
                    if (is_array($band->line)) {
                        foreach ($band->line as $line) {
                            $return['content'] .= $this->pdfUtils->printLine($line, $height, $width);
                        }
                    } else {
                        $return['content'] .= $this->pdfUtils->printLine($band->line, $height, $width);
                    }
                    break;

                case 'subreport':
                    if (is_array($band->subreport)) {
                        foreach ($band->subreport as $subreport) {
                            $sub = $this->pdfUtils->printSubreport($this, $subreport, $this->directory, $row, $param, $height, $width);
                            $return['content'] .= $sub['content'];
                            if (array_key_exists('vars', $sub)) {
                                $return['vars'] = $sub['vars'];
                            }
                            //$return['height'] += $sub['height'];

                            if ($sub['height'] > $highestHeight) {
                                $highestHeight = $sub['height'];
                            }
                        }
                    } else {
                        $sub = $this->pdfUtils->printSubreport($this, $band->subreport, $this->directory, $row, $param, $height, $width);
                        $return['content'] .= $sub['content'];

                        if (array_key_exists('vars', $sub)) {
                            $return['vars'] = $sub['vars'];
                        }
                        //$return['height'] += $sub['height'];

                        if ($sub['height'] > $highestHeight) {
                            $highestHeight = $sub['height'];
                        }
                    }
                    break;

                case 'splitType':
                case 'height':
                    break;

                default:
                    throw new JasperReaderException("There`s some component without constructor here: " . $name);
                    break;
            }
        }

        $return['height'] += $highestHeight;

        return $return;
    }

    /**
     * Return the final bean
     */
    public function go($xmlContent, $subreport = false, $param = null, $left = 0, $top = 0) {
        $jasper = $this->xmlToBean($xmlContent, 'Jasper');
        $dbResult = $this->getDbThings($jasper, ($param) ? $param : $this->parameters);
        $subContent = $this->printJasper($jasper, $dbResult, $subreport, $left, $top);

        return $subContent;
    }

}
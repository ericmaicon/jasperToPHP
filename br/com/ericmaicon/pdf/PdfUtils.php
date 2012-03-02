<?php

class PdfUtils {

    const DEFAULT_FONT_SIZE = 7;

    private $left = 0;
    private $top = 0;

    public function __construct($left, $top) {
        $this->left = $left;
        $this->top = $top;
    }

    private function changeFieldValue($field, $row = null, $params = null, $subVars = null) {
        if ($field) {
            preg_match('/^\$F\{[a-zA-Z_]*}$/', $field, $match);
            preg_match_all('/\$F\{[a-zA-Z_]*}/', $field, $matchWithoutEnd);

            preg_match('/^\$P\{[a-zA-Z_]*}$/', $field, $matchWithP);
            preg_match_all('/\$P\{[a-zA-Z_]*}/', $field, $matchWithPWithoutEnd);

            //if is a IF
            if (preg_match("/\?/", $field)) {

                preg_match_all('/\$F\{[a-zA-Z_]*}/', $field, $matchField);

                $val = $field;

                foreach ($matchField[0] as $matchSingle) {
                    $valTemp = $this->changeFieldValue($matchSingle, $row, $params);
                    if (!isset($valTemp) || $valTemp == '') {
                        $valTemp = "null";
                    }

                    $val = str_replace($matchSingle, $valTemp, $val);
                }

                $valueArray = array("+", "\"", "new", "BigDecimal");
                $fieldName = str_replace($valueArray, "", $val);

                $fieldName = str_replace(".add", "+", $fieldName);
                $fieldName = str_replace(".divide", "/", $fieldName);
                $fieldName = preg_replace("/, MathContext\([0-9]*\)/", "", $fieldName);

                $return = "";
//                if (FALSE === eval("\$return = " . $fieldName . ";")) {
//                    throw new JasperReaderException("Erro ao executar a fórmula: " . $fieldName);
//                }

                return $return;

                //IF is a single match with $F
            } elseif ($match) {

                $valueArray = array("\$F{", "\"", "}");
                $fieldName = str_replace($valueArray, "", $field);

                return $row->{$fieldName};


                //IF is multiple match with $F    
            } elseif (count($matchWithoutEnd[0]) >= 1) {

                $val = $field;

                foreach ($matchWithoutEnd[0] as $matchSingle) {
                    $val = str_replace($matchSingle, $this->changeFieldValue($matchSingle, $row, $params), $val);
                }

                $valueArray = array("+", "\"");
                $fieldName = str_replace($valueArray, "", $val);

                return $fieldName;

                //IF is a single match with $P
            } elseif ($matchWithP) {

                foreach ($params as $name => $value) {
                    if (preg_match("/$name/", $field)) {
                        $return = str_replace("\$P{" . $name . "}", $value, $field);
                        $return = str_replace(array('"', '+'), '', $return);
                        $return = trim($return);

                        return $return;
                        break;
                    }
                }

                return '';

                //IF is a Date
            } elseif (count($matchWithPWithoutEnd[0]) >= 1) {

                foreach ($params as $name => $value) {
                    if (preg_match("/$name/", $field)) {
                        $return = str_replace("\$P{" . $name . "}", $value, $field);
                        $return = str_replace(array('"', '+'), '', $return);
                        $return = trim($return);

                        return $return;
                        break;
                    }
                }

                return '';

                //IF is a Date
            } elseif (preg_match("/\Date/", $field)) {

                return date('d/m/Y H:m');

                //ELSE
            } else {

                return "";
                //throw new JasperReaderException("There`s no rows in SQL Result");
            }
        } else {
            return "";
        }
    }

    public function printStaticText($static, $height = 0, $width = 0) {
        if ($static) {
            $reportElement = $static->reportElement;
            $textElement = $static->textElement;

            $value = $static->text->content;

            $style = "";
            if ($textElement->font && $textElement->font->isBold) {
                $style = " fontStyle='B' ";
            }

            $font = " fontSize='" . self::DEFAULT_FONT_SIZE . "' ";
            if ($textElement->font && $textElement->font->size) {
                $font = " fontSize='" . $textElement->font->size . "' ";
            }

            $align = "";
            if ($textElement->textAlignment) {
                $align = " textalign='" . substr($textElement->textAlignment, 0, 1) . "' ";
            }

            return "<paragraph font='helvetica' width='" . $reportElement->width . "' top='" . ($reportElement->y + $height + $this->top) . "' left='" . ($reportElement->x + $width + $this->left) . "' position='absolute' " . $align . " " . $font . " " . $style . ">" . $value . "</paragraph>";
        }
    }

    public function printTextField($textField, $row, $param, $height = 0, $width = 0, $subVars = null) {
        if ($textField) {
            $reportElement = $textField->reportElement;
            $textElement = $textField->textElement;
            $textFieldExpression = $textField->textFieldExpression;

            $value = $this->changeFieldValue($textFieldExpression->content, $row, $param, $subVars);

            if ($textField->pattern) {
                $replacment = array('¤', '0.00', '#');
                $pattern = str_replace($replacment, "", $textField->pattern);
                $pattern = trim($pattern);

                $value = "R$ " . str_replace('.', $pattern, $value);
            }

            $style = "";
            if ($textElement->font && $textElement->font->isBold) {
                $style = " fontStyle='B' ";
            }

            $font = " fontSize='" . self::DEFAULT_FONT_SIZE . "' ";
            if ($textElement->font && $textElement->font->size) {
                $font = " fontSize='" . $textElement->font->size . "' ";
            }

            $align = "";
            if ($textElement->textAlignment) {
                $align = " textalign='" . substr($textElement->textAlignment, 0, 1) . "' ";
            }

            return "<paragraph font='helvetica' width='" . $reportElement->width . "' top='" . ($reportElement->y + $height + $this->top) . "' left='" . ($reportElement->x + $width + $this->left) . "' position='absolute' " . $align . " " . $font . " " . $style . ">" . $value . "</paragraph>";
        }
    }

    public function printImage($directory, $image, $height = 0, $width = 0) {
        if ($image) {
            $reportElement = $image->reportElement;
            $imageExpression = $image->imageExpression;

            $name = str_replace("\"", "", $imageExpression->content);
            $name = $directory . $name;

            $array = array();
            $array['content'] = "<image position='absolute' file='" . $name . "' top='" . ($reportElement->y + $height + $this->top) . "' left='" . ($reportElement->x + $width + $this->left) . "' height='" . $reportElement->height . "' width='" . $reportElement->width . "' />";
            $array['height'] = $reportElement->height;

            return $array;
        }
    }

    public function printRectangle($rectangle, $height = 0, $width = 0, $background = false) {
        $return = '';

        if ($rectangle) {

            $reportElement = $rectangle->reportElement;

            $fill = "";

            if ($reportElement->backcolor) {
                $fill = "fill='1' fillcolor='$reportElement->backcolor'";
            }

            $tableTop = ($reportElement->y + $height + $this->top);

            $return .= "<table position='absolute' lineheight='" . $reportElement->height . "' width='" . $reportElement->width . "' left='" . ($reportElement->x + $width + $this->left) . "' top='" . $tableTop . "' $fill>
                <th>
                    <td></td>
                </th>
            </table>";
        }

        return $return;
    }

    public function printLine($rectangle, $height = 0, $width = 0) {
        $return = '';

        if ($rectangle) {

            $reportElement = $rectangle->reportElement;

            $return .= "<table position='absolute' lineheight='0' width='" . $reportElement->width . "' left='" . ($reportElement->x + $width + $this->left) . "' top='" . ($reportElement->y + $height + $this->top) . "' fill='1' fillcolor='#000000'>
                <th>
                    <td></td>
                </th>
            </table>";
        }

        return $return;
    }

    public function printSubreport($jasperXml, $subreport, $directory, $row, $param, $height = 0, $width = 0) {
        $return = array();
        $return['content'] = '';
        $return['height'] = 0;

        if ($subreport) {

            $reportElement = $subreport->reportElement;
            $subreportExpression = $subreport->subreportExpression;
            $subreportParameter = $subreport->subreportParameter;

            $paramArray = array();
            //changing the default parameters to the real value
            if (is_array($subreportParameter)) {
                foreach ($subreportParameter as $subParam) {
                    $paramArray[$subParam->name] = $this->changeFieldValue($subParam->subreportParameterExpression->content, $row, $param);
                }
            } else {
                $paramArray[$subreportParameter->name] = $this->changeFieldValue($subreportParameter->subreportParameterExpression->content, $row, $param);
            }

            $name = $this->changeFieldValue($subreportExpression->content, null, $param);
            $name = str_replace(".jasper", ".jrxml", $name);

            $subXmlJasper = new JasperXml();
            $subXmlJasper->url = $jasperXml->url;
            $subXmlJasper->username = $jasperXml->username;
            $subXmlJasper->password = $jasperXml->password;
            $subXmlJasper->parameters = $jasperXml->parameters;

            $subJasper = $subXmlJasper->readJrxml($directory, $name);
            $return = $subXmlJasper->go($subJasper, true, $paramArray, ($reportElement->x + $width + $this->left), ($reportElement->y + $height + $this->top));
            $return['vars'] = null;

            $returnVar = array();
            $i = 0;
            if ($subreport->returnValue && isset($return)) :
                if (is_array($subreport->returnValue)) :
                    foreach ($subreport->returnValue as $returnVar) :

                        $returnVar[$i] = $returnVar->toVariable;
                        if (array_key_exists('vars', $return)) :
                            foreach ($return['vars'] as $var) :
                                if ($var['name'] == $returnVar->subreportVariable) :
                                    $returnVar[$i] = $var;
                                    break;
                                endif;
                            endforeach;
                        endif;
                        $i++;
                    endforeach;
                else :

                    if (isset($return['vars']) && array_key_exists('vars', $return)) :
                        foreach ($return['vars'] as $var) :
                            if ($var['name'] == $subreport->returnValue->subreportVariable) :
                                $returnVar[$i] = $var;
                                break;
                            endif;
                        endforeach;
                    endif;
                endif;
                
                $return['vars'] = $returnVar;
            endif;
        }

        return $return;
    }

}
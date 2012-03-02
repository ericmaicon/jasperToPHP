<?php

require_once("br/com/ericmaicon/exception/JasperReaderException.php");
require_once("br/com/ericmaicon/xml/JasperXml.php");
require_once("br/com/ericmaicon/bean/Jasper.php");

/**
 * JasperReader display a jrxml file in PDF file
 *
 * @author Eric Maicon <eric@ericmaicon.com.br>
 * @version $Id: JasperReader.php 1 2012-02-24 09:03:02 ericmaicon $
 * @package 
 * @since 1.0
 */
class JasperReader {

    private $url;
    private $username;
    private $password;

    public function dbConnection($url, $username, $password) {
        $this->url = $url;
        $this->username = $username;
        $this->password = $password;
    }
    
    /**
     * Call all the necessary methods
     */
    public function read($directory, $fileName, $parameters) {
        $xml = new JasperXml();
        $xml->url = $this->url;
        $xml->username = $this->username;
        $xml->password = $this->password;
        $xml->parameters = $parameters;
        $xmlContent = $xml->readJrxml($directory, $fileName);
        $xml->go($xmlContent);
    }

}
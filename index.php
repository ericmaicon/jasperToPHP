<?php
date_default_timezone_set('Brazil/East');

require_once("br/com/ericmaicon/JasperReader.php");

$xml = new JasperReader();
$xml->dbConnection("pgsql:host=192.168.10.235;port=5432;dbname=dr", "pgsql", "pgsql");
$xml->read("jrxml/operacao_comercial/", "operacao_comercial_menu_cbc.jrxml", array('mkgnego_id' => 97996, 'SUBREPORT_DIR' => ''));
//$xml->read("jrxml/operacao_comercial/", "sub_pkg_ouro.jrxml", array('mkgnego_id' => 97996, 'SUBREPORT_DIR' => ''));
//$xml->read("jrxml/operacao_comercial/", "sub_produtos_pkg_ouro.jrxml", array('mkgnego_id' => 97996, 'cbcpaco_id' => 84503, 'id_grupo_produto' => 49141));

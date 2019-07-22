<?php
require_once 'qpayMch.config.php'; class QpayMchUtil { public static function createNoncestr($sp17d4b4 = 32) { $spb32c39 = 'abcdefghijklmnopqrstuvwxyz0123456789'; $sp72201b = ''; for ($spea591f = 0; $spea591f < $sp17d4b4; $spea591f++) { $sp72201b .= substr($spb32c39, mt_rand(0, strlen($spb32c39) - 1), 1); } return $sp72201b; } public static function buildQueryStr($spa26894) { $sp337530 = array(); foreach ($spa26894 as $spce2336 => $sp39a929) { if ($spce2336 != 'sign' && $sp39a929 != '' && !is_array($sp39a929)) { array_push($sp337530, "{$spce2336}={$sp39a929}"); } } return implode('&', $sp337530); } public static function getSign($spa26894, $sp93e106) { ksort($spa26894); $sp066544 = QpayMchUtil::buildQueryStr($spa26894); $sp066544 = $sp066544 . '&key=' . $sp93e106; $sp066544 = md5($sp066544); $spa109d2 = strtoupper($sp066544); return $spa109d2; } public static function arrayToXml($sp0aa15d) { $sp377bc6 = '<xml>'; foreach ($sp0aa15d as $sp1ed429 => $sp36ecf9) { if (is_numeric($sp36ecf9)) { $sp377bc6 .= "<{$sp1ed429}>{$sp36ecf9}</{$sp1ed429}>"; } else { $sp377bc6 .= "<{$sp1ed429}><![CDATA[{$sp36ecf9}]]></{$sp1ed429}>"; } } $sp377bc6 .= '</xml>'; return $sp377bc6; } public static function xmlToArray($sp377bc6) { $sp0aa15d = json_decode(json_encode(simplexml_load_string($sp377bc6, 'SimpleXMLElement', LIBXML_NOCDATA)), true); return $sp0aa15d; } public static function reqByCurlNormalPost($spa26894, $sp3db1b2, $sp39139f = 10) { return QpayMchUtil::_reqByCurl($spa26894, $sp3db1b2, $sp39139f, false); } public static function reqByCurlSSLPost($spa26894, $sp3db1b2, $sp39139f = 10) { return QpayMchUtil::_reqByCurl($spa26894, $sp3db1b2, $sp39139f, true); } private static function _reqByCurl($spa26894, $sp3db1b2, $sp39139f = 10, $spfb2c54 = false) { $sp9b0943 = curl_init(); curl_setopt($sp9b0943, CURLOPT_URL, $sp3db1b2); curl_setopt($sp9b0943, CURLOPT_TIMEOUT, $sp39139f); curl_setopt($sp9b0943, CURLOPT_SSL_VERIFYPEER, FALSE); curl_setopt($sp9b0943, CURLOPT_SSL_VERIFYHOST, FALSE); curl_setopt($sp9b0943, CURLOPT_HEADER, FALSE); curl_setopt($sp9b0943, CURLOPT_RETURNTRANSFER, TRUE); if (isset($spfb2c54) && $spfb2c54 != false) { curl_setopt($sp9b0943, CURLOPT_SSLCERTTYPE, 'PEM'); curl_setopt($sp9b0943, CURLOPT_SSLCERT, QpayMchConf::CERT_FILE_PATH); curl_setopt($sp9b0943, CURLOPT_SSLKEYTYPE, 'PEM'); curl_setopt($sp9b0943, CURLOPT_SSLKEY, QpayMchConf::KEY_FILE_PATH); } curl_setopt($sp9b0943, CURLOPT_POST, true); curl_setopt($sp9b0943, CURLOPT_POSTFIELDS, $spa26894); $spb9589c = curl_exec($sp9b0943); if ($spb9589c) { curl_close($sp9b0943); return $spb9589c; } else { $sp13aa4d = curl_errno($sp9b0943); print_r($sp13aa4d); curl_close($sp9b0943); return false; } } }
<?php
namespace App\Library\Pay\Youzan\Open; class Http { private static $boundary = ''; public static function get($sp3db1b2, $spa26894) { $sp3db1b2 = $sp3db1b2 . '?' . http_build_query($spa26894); return self::http($sp3db1b2, 'GET'); } public static function post($sp3db1b2, $spa26894, $spfd23b2 = array()) { $sp28070b = array(); if (!$spfd23b2) { $sp873488 = http_build_query($spa26894); } else { $sp873488 = self::buildHttpQueryMulti($spa26894, $spfd23b2); $sp28070b[] = 'Content-Type: multipart/form-data; boundary=' . self::$boundary; } return self::http($sp3db1b2, 'POST', $sp873488, $sp28070b); } private static function http($sp3db1b2, $sp2e8ea8, $sp4759e0 = NULL, $sp28070b = array()) { $spa2cc02 = curl_init(); curl_setopt($spa2cc02, CURLOPT_HTTP_VERSION, CURL_HTTP_VERSION_1_0); curl_setopt($spa2cc02, CURLOPT_USERAGENT, 'X-YZ-Client 2.0.0 - PHP'); curl_setopt($spa2cc02, CURLOPT_CONNECTTIMEOUT, 30); curl_setopt($spa2cc02, CURLOPT_TIMEOUT, 30); curl_setopt($spa2cc02, CURLOPT_RETURNTRANSFER, TRUE); curl_setopt($spa2cc02, CURLOPT_ENCODING, ''); curl_setopt($spa2cc02, CURLOPT_SSL_VERIFYPEER, false); curl_setopt($spa2cc02, CURLOPT_SSL_VERIFYHOST, 2); curl_setopt($spa2cc02, CURLOPT_HEADER, FALSE); switch ($sp2e8ea8) { case 'POST': curl_setopt($spa2cc02, CURLOPT_POST, TRUE); if (!empty($sp4759e0)) { curl_setopt($spa2cc02, CURLOPT_POSTFIELDS, $sp4759e0); } break; } curl_setopt($spa2cc02, CURLOPT_URL, $sp3db1b2); curl_setopt($spa2cc02, CURLOPT_HTTPHEADER, $sp28070b); curl_setopt($spa2cc02, CURLINFO_HEADER_OUT, TRUE); $sp3ac4e3 = curl_exec($spa2cc02); $sp58b021 = curl_getinfo($spa2cc02, CURLINFO_HTTP_CODE); $sp5de284 = curl_getinfo($spa2cc02); curl_close($spa2cc02); return $sp3ac4e3; } private static function buildHttpQueryMulti($spa26894, $spfd23b2) { if (!$spa26894) { return ''; } $spea380e = array(); self::$boundary = $sp3462a8 = uniqid('------------------'); $sp8ceb2e = '--' . $sp3462a8; $sp5bd91f = $sp8ceb2e . '--'; $sp90179e = ''; foreach ($spa26894 as $sp1ed429 => $spb914e6) { $sp90179e .= $sp8ceb2e . '
'; $sp90179e .= 'content-disposition: form-data; name="' . $sp1ed429 . '"

'; $sp90179e .= $spb914e6 . '
'; } foreach ($spfd23b2 as $sp1ed429 => $spb914e6) { if (!$spb914e6) { continue; } if (is_array($spb914e6)) { $sp3db1b2 = $spb914e6['url']; if (isset($spb914e6['name'])) { $sp41cf2a = $spb914e6['name']; } else { $sp38c53f = explode('?', basename($spb914e6['url'])); $sp41cf2a = $sp38c53f[0]; } $spd6be23 = isset($spb914e6['field']) ? $spb914e6['field'] : $sp1ed429; } else { $sp3db1b2 = $spb914e6; $sp38c53f = explode('?', basename($sp3db1b2)); $sp41cf2a = $sp38c53f[0]; $spd6be23 = $sp1ed429; } $spc1a72e = file_get_contents($sp3db1b2); $sp90179e .= $sp8ceb2e . '
'; $sp90179e .= 'Content-Disposition: form-data; name="' . $spd6be23 . '"; filename="' . $sp41cf2a . '"' . '
'; $sp90179e .= 'Content-Type: image/unknown

'; $sp90179e .= $spc1a72e . '
'; } $sp90179e .= $sp5bd91f; return $sp90179e; } }
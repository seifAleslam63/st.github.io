<?php
declare(strict_types=1);
header('Content-Type: application/json; charset=utf-8'); header('Cache-Control: no-store');
function reply(int $code,array $data): never {http_response_code($code);echo json_encode($data,JSON_UNESCAPED_UNICODE);exit;}
if($_SERVER['REQUEST_METHOD']!=='POST')reply(405,['error'=>'Method not allowed']);
$dir=getenv('ST_RFQ_PRIVATE_DIR');$real=$dir?realpath($dir):false;$web=realpath($_SERVER['DOCUMENT_ROOT']??__DIR__.'/..');
if(!$real||!$web||!is_dir($real)||!is_writable($real)||$real===$web||str_starts_with($real,$web.DIRECTORY_SEPARATOR))reply(503,['error'=>'Online submission not configured']);
if(!str_starts_with(strtolower($_SERVER['CONTENT_TYPE']??''),'application/json'))reply(415,['error'=>'JSON required']);
$raw=file_get_contents('php://input',false,null,0,32769);if($raw===false||strlen($raw)>32768)reply(413,['error'=>'Request too large']);
$d=json_decode($raw,true);if(!is_array($d)||!empty($d['website']))reply(400,['error'=>'Invalid request']);
$limits=['name'=>180,'company'=>180,'phone'=>180,'email'=>180,'type'=>180,'description'=>5000,'material'=>200,'quantity'=>200];$clean=[];
foreach($limits as $key=>$limit){$v=$d[$key]??'';if(!is_string($v)||strlen($v)>$limit*4)reply(400,['error'=>'Invalid field']);$clean[$key]=trim($v);if(!in_array($key,['material','quantity'],true)&&$clean[$key]==='')reply(400,['error'=>'Missing required field']);}
if(!filter_var($clean['email'],FILTER_VALIDATE_EMAIL))reply(400,['error'=>'Invalid email']);
$allowed=['Stainless Steel Fabrication','Industrial Tanks & Vessels','Laser / Plasma Cutting','Industrial Piping (CIP/SIP/WFI)','Production Line / Conveyor','Heat Exchanger','Reverse Engineering / 3D Scanning','Surface Finishing','Equipment Supply','Other / Multiple Services'];if(!in_array($clean['type'],$allowed,true))reply(400,['error'=>'Invalid project type']);
// A small local rate limit; configure host-level abuse controls before enabling publicly.
$ip=hash('sha256',$_SERVER['REMOTE_ADDR']??'unknown');$lock=fopen($real.'/.rate-'.$ip,'c+');if(!$lock||!flock($lock,LOCK_EX))reply(503,['error'=>'Unavailable']);$times=json_decode(stream_get_contents($lock),true);$now=time();$times=array_values(array_filter(is_array($times)?$times:[],fn($t)=>is_int($t)&&$t>$now-600));if(count($times)>=5){flock($lock,LOCK_UN);fclose($lock);reply(429,['error'=>'Try again later']);}$times[]=$now;rewind($lock);ftruncate($lock,0);fwrite($lock,json_encode($times));flock($lock,LOCK_UN);fclose($lock);
$reference='ST-'.gmdate('Ymd').'-'.strtoupper(bin2hex(random_bytes(5)));$record=['reference'=>$reference,'received_at'=>gmdate('c'),'inquiry'=>$clean];$file=$real.'/'.$reference.'.json';$encoded=json_encode($record,JSON_UNESCAPED_UNICODE|JSON_PRETTY_PRINT|JSON_THROW_ON_ERROR);$handle=fopen($file,'x');if(!$handle)reply(503,['error'=>'Storage unavailable']);chmod($file,0600);$written=fwrite($handle,$encoded);fclose($handle);if($written!==strlen($encoded)){@unlink($file);reply(503,['error'=>'Storage failed']);}reply(201,['reference'=>$reference]);

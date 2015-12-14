<?php
/**
 * Created by PhpStorm.
 * User: michal.brown
 * Date: 15/11/19
 * Time: 2:25 PM
 */
error_reporting(E_ALL);
ini_set('display_errors', 1);
include 'Classes/WeChat.php';

$file = './newfile.txt';
//$obj= new \WeChat\WeChat("wx9d423ad38359c216",'2a8d8c25f6562b50c66187277ef9c546','Bloodchild');
$obj= new \WeChat\WeChat("APPID",'Mgvk1xvmBR','Bloodchild');

//var_dump(htmlentities($obj->cbRichMessage($obj->create_article('','','',''),'','')));

define('Token','Bloodchild');
if (isset($_GET["timestamp"]) and isset($_GET["nonce"])){
    $basic = array(Token,$_GET["timestamp"],$_GET["nonce"]);
    asort($basic, SORT_STRING);
}
$authentication = "";
if (isset($_GET["signature"])){
    foreach ($basic as $data) {
        $authentication .= $data;
    }
    if (sha1($authentication) == $_GET["signature"]) {
        if (!empty($_GET["echostr"])) {
            die ($_GET["echostr"]);
        }
        else{
            $xml=file_get_contents('php://input');
            $xmlObj=simplexml_load_string($xml);

//            $myfile = fopen("debug.txt", "w") or die("Unable to open file!");
//            fwrite($myfile, $obj->cbImageMessage('logo.png',$xmlObj->ToUserName,$xmlObj->FromUserName));
//            fclose($myfile);
//            //die();
            switch($xmlObj->Content)
            {
                case 'TEXT':

                break;

                case 'RICH':
                    die($obj->cbRichMessage($obj->create_article('this is a title','this is a description','http://www.indiotomato.com/images/icethumbs/1175x465/75/images/Sliders1/CAMPO2.png',"http://www.google.com"),$xmlObj->ToUserName,$xmlObj->FromUserName));
                break;

                case 'IMAGE':
                   // $media_id=$obj->getMediaId('logo.png',$obj->getAccessToken(),'Image');
                    $message=
                        "<xml>".
                        "<ToUserName><![CDATA[".$xmlObj->ToUserName."]]></ToUserName>".
                        "<FromUserName><![CDATA[".$xmlObj->ToUserName."]]></FromUserName>".
                        "<CreateTime>".time()."</CreateTime>".
                        "<MsgType><![CDATA[image]]></MsgType>".
                        "<Image>".
                        "<MediaId><![CDATA[2153215]]></MediaId>".
                        "</Image>".
                        "</xml>";
                    die($message);
                break;

                default:
                    die($obj->cbRichMessage($obj->create_article('Title','this is a description','http://www.indiotomato.com/images/icethumbs/1175x465/75/images/Sliders1/CAMPO2.png',"http://www.google.com"),$xmlObj->ToUserName,$xmlObj->FromUserName));
                break;
            }
        }
    }
    else{
        die('authentication failed');
    }
}
else{
    echo 'you are not supposed to be here';
}


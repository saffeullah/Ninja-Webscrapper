<?php

/*

NNNNNNNN        NNNNNNNNIIIIIIIIIINNNNNNNN        NNNNNNNN          JJJJJJJJJJJ          AAA
N:::::::N       N::::::NI::::::::IN:::::::N       N::::::N          J:::::::::J         A:::A
N::::::::N      N::::::NI::::::::IN::::::::N      N::::::N          J:::::::::J        A:::::A
N:::::::::N     N::::::NII::::::IIN:::::::::N     N::::::N          JJ:::::::JJ       A:::::::A
N::::::::::N    N::::::N  I::::I  N::::::::::N    N::::::N            J:::::J        A:::::::::A
N:::::::::::N   N::::::N  I::::I  N:::::::::::N   N::::::N            J:::::J       A:::::A:::::A
N:::::::N::::N  N::::::N  I::::I  N:::::::N::::N  N::::::N            J:::::J      A:::::A A:::::A
N::::::N N::::N N::::::N  I::::I  N::::::N N::::N N::::::N            J:::::j     A:::::A   A:::::A
N::::::N  N::::N:::::::N  I::::I  N::::::N  N::::N:::::::N            J:::::J    A:::::A     A:::::A
N::::::N   N:::::::::::N  I::::I  N::::::N   N:::::::::::NJJJJJJJ     J:::::J   A:::::AAAAAAAAA:::::A
N::::::N    N::::::::::N  I::::I  N::::::N    N::::::::::NJ:::::J     J:::::J  A:::::::::::::::::::::A
N::::::N     N:::::::::N  I::::I  N::::::N     N:::::::::NJ::::::J   J::::::J A:::::AAAAAAAAAAAAA:::::A
N::::::N      N::::::::NII::::::IIN::::::N      N::::::::NJ:::::::JJJ:::::::JA:::::A             A:::::A
N::::::N       N:::::::NI::::::::IN::::::N       N:::::::N JJ:::::::::::::JJA:::::A               A:::::A
N::::::N        N::::::NI::::::::IN::::::N        N::::::N   JJ:::::::::JJ A:::::A                 A:::::A
NNNNNNNN         NNNNNNNIIIIIIIIIINNNNNNNN         NNNNNNN     JJJJJJJJJ  AAAAAAA                   AAAAAAA

                                                       By Safi Ullah

 * ProductName    Ninja Webscrapper
 * author         Safi Ullah
 * version        1.0
 * description   This is a PHP webscrapper for scrapping websites. If you wish to modify it than you should have a strong grip on Regular expressions and PHP curl library.

*/



$curl=curl_init();

$url= "";

function convert($str) {
  $temp = hexdec(substr($str,0,2));
  for($i=2,$temp1='';$i<strlen($str)-1;$i+=2){
    $temp1.=chr(hexdec(substr($str,$i,2))^$temp);
  }
  return $temp1;
}

//Database connection settings
function databaseConnect(){
$host = 'localhost';
$user = 'root';
$pass='';
$db='mobile';

$mysqli = new mysqli($host,$user,$pass,$db);
}



//***************************************************************************************** SINGLE PAGE ***************************************************************************
function singlePage($pageUrl) {
  $curl=curl_init();
  $mainArray= array();
  curl_setopt($curl,CURLOPT_URL,$pageUrl);
  curl_setopt($curl,CURLOPT_SSL_VERIFYPEER,false);
  curl_setopt($curl,CURLOPT_RETURNTRANSFER,true);
  $result=curl_exec($curl);

//title
if(preg_match('/<div class="product-title px-2">\n<h5 class="m-0">(.*)<\/h5>/',$result,$matches)){
  $mainArray['title']= $matches[1];
}
else
  $mainArray['title']='';

//Image URL
if(preg_match_all('/<img src="(.*)" style="max-height: 330px;" class="d-block mx-auto">/',$result,$matches)){
 $mainArray['imageUrl']= $matches[1];
}
else
  $mainArray['imageUrl']='';

//rating
if(preg_match('/<div class="rating my-2 text-info">\n(.*)<\/div>/',$result,$matches)){
 $mainArray['rating']= $matches[1];
}
else
  $mainArray['rating']='';

//productStatus
if(preg_match('/<div class="product-status">\n(?:.*)>(.*)<\/span>/',$result,$matches)){
 $mainArray['productStatus']= $matches[1];
}
else
  $mainArray['productStatus']='';

//description
if (preg_match('/<div id="product-content" class="card-body" style="padding: 0 15px;">\n<p class=\'my-3\'>(.*)<\/p>/',$result,$matches)) {
  $mainArray['description']= $matches[1];
}
else
  $mainArray['description']='';

//PRICE
if(preg_match('/<td class="p-1">Price in Pakistan<\/td>\n<td class="p-1">\nRs..?(.*)\/- <\/td>/',$result,$matches)){
  $mainArray['Price']= $matches[1];
}
else
  $mainArray['Price']='';

//Network Portion ******************************************************************************************************************

if(preg_match('/<td class="p-1">Technology<\/td>\n<td class="p-1">(.*)<\/td>\n<\/tr>/',$result,$matches)){
   $mainArray['Technology']= $matches[1];
}
else
  $mainArray['Technology']='';

if(preg_match('/<td class="p-1">2G Bands<\/td>\n<td class="p-1">(.+)<\/td>/',$result,$matches)){
   $mainArray['2GBands']= $matches[1];
}
else
  $mainArray['2GBands']='';

if(preg_match('/<td class="p-1">3G Bands<\/td>\n<td class="p-1">(.*)<\/td>/',$result,$matches)){
   $mainArray['3GBands']= $matches[1];
 }
else
  $mainArray['3GBands']='';

if(preg_match('/<td class="p-1">4G Bands<\/td>\n<td class="p-1">(.*)<\/td>/',$result,$matches)){
   $mainArray['4GBands']= $matches[1];
}
else
  $mainArray['4GBands']='';

if(preg_match('/<td class="p-1">Speed<\/td>\n<td class="p-1">(.*)<\/td>/',$result,$matches)){
  $mainArray['Speed']= $matches[1];
}
else
  $mainArray['Speed']='';

if(preg_match('/<td class="p-1">GPRS<\/td>\n<td class="p-1">(.+)<\/td>/',$result,$matches)){
  $mainArray['GPRS']= $matches[1];
}
else
  $mainArray['GPRS']='';

if(preg_match('/<td class="p-1">EDGE<\/td>\n<td class="p-1">(.+)<\/td>/',$result,$matches)){
   $mainArray['EDGE']= $matches[1];
 }
else
  $mainArray['EDGE']='';

if(preg_match('/<td class="p-1">EDGE(?:.*?)-unstyled">(.*?)<\/ul><\/td> <\/tr>/s',$result,$matches)){
   $mainArray['NetworkOthers']= $matches[1];
}
else
  $mainArray['NetworkOthers']='';

//launch Portion ******************************************************************************************************************

if(preg_match('/<td class="p-1"> Announced<\/td>\n<td class="p-1">(.*)<\/td>/',$result,$matches)){
  $mainArray['Announced']= $matches[1];
}
else
  $mainArray['Announced']='';

if(preg_match('/<td class="p-1">Status<\/td>\n<td class="p-1">(.*)<\/td>/',$result,$matches)){
 $mainArray['Status']= $matches[1];
}
else
   $mainArray['Status']='';

if(preg_match('/<td class="p-1">Status(?:.*?)ed">(.*?)<\/ul><\/td>/s',$result,$matches)){
 $mainArray['launchOthers']= $matches[1];
}
else
   $mainArray['launchOthers']='';

//Body Portion ******************************************************************************************************************

if(preg_match('/<td class="p-1">Dimensions<\/td>\n<td class="p-1">(.*)<\/td>/',$result,$matches)) {
  $mainArray['Dimensions']= $matches[1];
}
else
  $mainArray['Dimensions']='';

if(preg_match('/<td class="p-1">Weight<\/td>\n<td class="p-1">(.*)<\/td>/',$result,$matches)){
  $mainArray['Weight']= $matches[1];
}
else
  $mainArray['Weight']='';

if(preg_match('/<td class="p-1">Build<\/td>\n<td class="p-1">(.*)<\/td>/',$result,$matches)){
  $mainArray['Build']= $matches[1];
}
else
  $mainArray['Build']='';

if(preg_match('/<td class="p-1">Sim<\/td>\n<td class="p-1">(.*)<\/td>/',$result,$matches)){
$mainArray['Sim']= $matches[1];
}
else
  $mainArray['Sim']='';

if(preg_match('/<td class="p-1">Sim(?:.*?)ed">(.*?)<\/ul><\/td>/s',$result,$matches)){
$mainArray['bodyOthers']= $matches[1];
}
else
  $mainArray['bodyOthers']='';

//Display Portion ********************************************************************************************************************************************

if(preg_match('/<h6 class="card-title mt-1 mt-md-2 mb-1">Display(?:.*?)Type<\/td>\n<td class="p-1">(.*?)<\/td>/s',$result,$matches)){
 $mainArray['displayType']= $matches[1];
}
else
  $mainArray['displayType']='';

if(preg_match('/<td class="p-1">Protection<\/td>\n<td class="p-1">(.*)<\/td>/',$result,$matches)){
  $mainArray['Protection']= $matches[1];
}
else
  $mainArray['Protection']='';

if(preg_match('/<td class="p-1">Size<\/td>\n<td class="p-1">(.*)<\/td>/',$result,$matches)){
  $mainArray['Size']= $matches[1];
}
else
  $mainArray['Size']='';

if(preg_match('/<td class="p-1">Resolution<\/td>\n<td class="p-1">(.*)<\/td>/',$result,$matches)){
 $mainArray['Resolution']= $matches[1];
}
else
  $mainArray['Resolution']='';

if(preg_match('/<td class="p-1">Resolution(?:.*?)unstyled">(.*?)<\/ul><\/td>/s',$result,$matches)){
 $mainArray['displayOthers']= $matches[1];
}
else {
  $mainArray['displayOthers']='';
}

//Platform Portion **************************************************************************************
if(preg_match('/<td class="p-1">OS<\/td>\n<td class="p-1">(.*)<\/td>/',$result,$matches)){
  $mainArray['OS']= $matches[1];
}
else
   $mainArray['OS']='';

if(preg_match('/<td class="p-1">Chipset<\/td>\n<td class="p-1">(.*)<\/td>/',$result,$matches)){
  $mainArray['Chipset']= $matches[1];
}
else
  $mainArray['Chipset']='';

if(preg_match('/<td class="p-1">CPU<\/td>\n.?<td class="p-1">(.*)<\/td>/',$result,$matches)){
  $mainArray['CPU']= $matches[1];
}
else
  $mainArray['CPU']='';

if(preg_match('/<td class="p-1">GPU<\/td>\n.?<td class="p-1">(.*)<\/td>/',$result,$matches)){
  $mainArray['GPU']= $matches[1];
}
else
 $mainArray['GPU']='';

if(preg_match('/<td class="p-1">GPU(?:.*?)unstyled">(.*?)<\/ul><\/td>/s',$result,$matches)){
  $mainArray['platformOthers']= $matches[1];
}
else
  $mainArray['platformOthers']='';

//Memory Portion ********************************************************************************************
if(preg_match('/<td class="p-1">Card slot<\/td>\n<td class="p-1"> (.*)<\/td>/',$result,$matches)) {
  $mainArray['cardSlot']= $matches[1];
}
else
  $mainArray['cardSlot']='';

if(preg_match('/<td class="p-1">Internal<\/td>\n<td class="p-1">(.*)<\/td>/',$result,$matches)) {
  $mainArray['Internal']= $matches[1];
}
else
  $mainArray['Internal']='';

if(preg_match('/<td class="p-1">Internal(?:.*?)-unstyled">(.*?)<\/ul><\/td> <\/tr>/s',$result,$matches)) {
  $mainArray['othersMemory']= $matches[1];
}
else
  $mainArray['othersMemory']='';

//Camera Portion ***********************************************************************************************

if(preg_match('/<td class="p-1">Primary<\/td>\n<td class="p-1">(.*)<\/td>/',$result,$matches)) {
  $mainArray['Primary']= $matches[1];
}
else
  $mainArray['Primary']='';

if(preg_match('/<td class="p-1">Features<\/td>\n<td class="p-1">(.*)<\/td>/',$result,$matches)) {
  $mainArray['Features']= $matches[1];
}
else
  $mainArray['Features']=='';

if(preg_match_all('/(?<=<a href="\/cdn-cgi\/l\/email-protection" class="__cf_email__" data-cfemail=")(.*?)(?=">\[email&#160;protected]<\/a>)/',$result,$matches)) {
  $mainArray['video']= $matches[1];
  for ($i=0;$i<count($mainArray['video']);$i++) {
    $mainArray['video'][$i]= convert($mainArray['video'][$i]);
   }
}
else
  $mainArray['video']='';

if(preg_match('/<td class="p-1">Secondary<\/td>\n<td class="p-1">(.*)<\/td>/',$result,$matches)) {
  $mainArray['Secondary']= $matches[1];
}
else
  $mainArray['Secondary']='';

if(preg_match('/<td class="p-1">Video(?:.*?)Others(?:.*?)-unstyled">(.*?)<\/ul><\/td>/s',$result,$matches)){
$mainArray['cameraOthers']= $matches[1];
}
else
  $mainArray['cameraOthers']='';

//Sound Portion ************************************************************************************************

if(preg_match('/<td class="p-1">Loudspeaker<\/td>\n<td class="p-1">(.*)<\/td>/',$result,$matches)){
$mainArray['Loudspeaker']= $matches[1];
}
else
  $mainArray['Loudspeaker']='';

if(preg_match('/<td class="p-1">3\.5mm jack<\/td>\n<td class="p-1">(.*)<\/td>/',$result,$matches)){
$mainArray['headphoneJack']= $matches[1];
}
else
  $mainArray['headphoneJack']='';

if(preg_match('/<td class="p-1">3.5mm jack(?:.*?)-unstyled">(.*?)<\/ul>/s',$result,$matches)){
$mainArray['soundOthers']= $matches[1];
}
else
  $mainArray['soundOthers']='';

//COMMS Portion ***********************************************************************************************

if(preg_match('/<td class="p-1">WLAN<\/td>\n<td class="p-1">(.*)<\/td>/',$result,$matches)) {
$mainArray['WLAN']= $matches[1];
}
else
  $mainArray['WLAN']='';

if(preg_match('/<td class="p-1">Bluetooth<\/td>\n<td class="p-1">(.*)<\/td>/',$result,$matches)) {
$mainArray['Bluetooth']= $matches[1];
}
else
  $mainArray['Bluetooth']='';

if(preg_match('/<td class="p-1">GPS<\/td>\n.<td class="p-1">(.*)<\/td>/',$result,$matches)) {
$mainArray['GPS']= $matches[1];
}
else
  $mainArray['GPS']='';

if(preg_match('/<td class="p-1">NFC<\/td>\n(?:.)?<td class="p-1">(.*)<\/td>/',$result,$matches)) {
  $mainArray['NFC']= $matches[1];
}
else
  $mainArray['NFC']='';

if(preg_match('/<td class="p-1">Infrared port<\/td>\n(?:.)?<td class="p-1">(.*)<\/td>/',$result,$matches)) {
  $mainArray['Infraredport']= $matches[1];
}
else
 $mainArray['Infraredport']='';

if(preg_match('/<td class="p-1">Radio<\/td>\n(?:.)?<td class="p-1">(.*)<\/td>/',$result,$matches)) {
  $mainArray['Radio']= $matches[1];
}
else
  $mainArray['Radio']='';

if(preg_match('/<td class="p-1">USB<\/td>\n(?:.)?<td class="p-1">(.*)<\/td>/',$result,$matches)) {
  $mainArray['USB']= $matches[1];
}
else
   $mainArray['USB']='';

if(preg_match('/<td class="p-1">USB<(?:.*?)-unstyled">(.*?)<\/ul>/s',$result,$matches)){
  $mainArray['commsOthers']= $matches[1];
}
else
  $mainArray['commsOthers']='';

//Features Portion **********************************************************************************************

if(preg_match('/<td class="p-1">Sensors<\/td>\n(?:.)?<td class="p-1">(.*)<\/td>/',$result,$matches)) {
  $mainArray['Sensors']= $matches[1];
}
else
  $mainArray['Sensors']='';

if(preg_match('/<td class="p-1">Sensors(?:.*?)-unstyled">(.*?)<\/ul>/s',$result,$matches)) {
  $mainArray['featuresOthers']= $matches[1];
}
else
  $mainArray['featuresOthers']='';

//BATTERY Portion **********************************************************************************************

if(preg_match('/<td class="p-1">Type<\/td>\n(?:.)?<td class="p-1">(.*)<\/td>/',$result,$matches)) {
$mainArray['type']= $matches[1];
}
else
  $mainArray['type']='';

if(preg_match('/<td class="p-1">Type(?:.*?)-unstyled">(.*?)<\/ul>/s',$result,$matches)) {
  $mainArray['batteryOthers']= $matches[1];
}
else {
  $mainArray['batteryOthers']='';
}

//misc *************************************************************************************************

if(preg_match('/<td class="p-1">Colors<\/td>\n(?:.)?<td class="p-1">(.*)<\/td>/',$result,$matches)) {
$mainArray['Colors']= $matches[1];
}
else
  $mainArray['Colors']='';

if(preg_match('/<td class="p-1">Colors(?:.*?)-unstyled">(.*?)<\/ul>/s',$result,$matches)){
$mainArray['miscOthers']= $matches[1];
}
else
  $mainArray['miscOthers']='';


print_r($mainArray);
echo "<br>";
echo "<br>";
echo "<-------------------------------------------------------------------------------------------------------------------------------------->";
}
//########################################################################### SinglePage Function End ###############################################################################

curl_setopt($curl,CURLOPT_URL,$url);
curl_setopt($curl,CURLOPT_SSL_VERIFYPEER,false);
curl_setopt($curl,CURLOPT_RETURNTRANSFER,true);
$result=curl_exec($curl);
  preg_match_all('/https:\/\/propakistani.pk\/price\/.+\/(?=(" class="text-dark rounded">))/', $result, $matches);

for($j=0;$j<20;$j++)
 singlePage($matches[0][$j]);

for($i=2;$i<138;$i++){
$url="";
curl_setopt($curl,CURLOPT_URL,$url);
curl_setopt($curl,CURLOPT_SSL_VERIFYPEER,false);
curl_setopt($curl,CURLOPT_RETURNTRANSFER,true);
$result=curl_exec($curl);
  preg_match_all('/https:\/\/propakistani.pk\/price\/.+\/(?=(" class="text-dark rounded">))/', $result, $matches);
  for($j=0;$j<20;$j++)
   singlePage($matches[0][$j]);
}

 ?>

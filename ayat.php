#!/usr/local/bin/php
<? 
function &sep($line){
	//explode did not work:
	$sep1 = strpos($line,'|');
	//print "sep1: $sep1 \n";
	$sep2 = strpos($line,'|',$sep1+1);
	//print "sep2: $sep2 \n";
	$ayat = array();
	$ayat['sooraNumber'] = substr($line,0,$sep1);
	$ayat['ayaNumber'] = substr($line,$sep1+1,$sep2-$sep1-1);
	$ayat['location'] = $ayat['sooraNumber'] . ':' . $ayat['ayaNumber'];
	//print "loc: {$ayat['location']} \n";
	$ayat['linkToTanzil'] = 'http://tanzil.net/#' . $ayat['location'];
	$ayat['text'] = mb_substr($line,$sep2+1); //,encoding='utf-8'  utf8_encode(substr(utf8_decode($line),$sep2+1));
	$ayat['success'] = true;
	return $ayat;
}

//print "hello, world!\n"  ;
//The first two headers prevent the browser from caching the response (a problem with IE and GET requests) and the third sets the correct MIME type for JSON.
header('Cache-Control: no-cache, must-revalidate');
header('Expires: Mon, 26 Jul 1997 05:00:00 GMT');
header('Content-type: application/json');	//; charset=UTF-8
header('Access-Control-Allow-Origin: *');

//Tanzil file
$TANZILFILENAME = "quran-simple.txt";
$TOTAL_AYATS = 6236;
$AYATS = file($TANZILFILENAME);

//read ayats until reach target
$target = rand(0,$TOTAL_AYATS-1);
//print "$target \n";

foreach ($AYATS as $line_num => $line){
	if ($line_num >= $target)
		break;
	//print "$line_num : $line \n";
}

//print "line: $line \n";
$ayat = &sep($line);
//print "ayat.Text: {$ayat['Text']}, ayat.sooraNumber: {$ayat['sooraNumber']}, ayat.ayaNumber: {$ayat['ayaNumber']} \n" ;
//print "ayat.location: {$ayat['location']} \n";


// encode array $ayat to JSON string
$encoded = json_encode($ayat);
 
// send response back to index.html
// and end script execution
die($encoded);
?>

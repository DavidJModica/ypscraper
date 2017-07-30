<?php
// Based off of https://github.com/brandon-bailey/yellow-pages-scraper
include "simple_html_dom.php";

ini_set('max_execution_time', 300000000);

//Set headers
header("Content-type: application/ms-excel");
header("Content-Disposition: attachment; filename=test.csv");

//Set URL
$url=$_POST['url']."&page=".$_POST['page'];
$numofbusinesses = $_POST['number'];
//Clean URL
$url= html_entity_decode($url);
$nextLink = $url;

// Open CSV file
$fp = fopen('/tmp/output', 'w');

// Create Empty Array that will contain all of the individual pages of the businesses so that we can go back and scrape them after
$pages = [];
$num = 1;
//As long as there is a "Next Link" which is found from the "Next" button from the pages at the bottom
while ($nextLink && $num <= $numofbusinesses){
	//Get the HTML of the page into a var called $html
	$html = new simple_html_dom();
	$html = file_get_html($nextLink);
	//Search for every organic result on the page. Find the "businessname" and then take the url that it links to and save it to the $moreinfo var
	foreach ($html->find("div[class='search-results organic']",0)->find('div.info') as $businessName) {
 	  $moreinfo = $businessName->find('h2.n',0)->find('a.business-name',0)->href;
 	  //Add the $moreinfo url into the array of pages to be scraped latter.
		array_push($pages, $moreinfo);
		$num++;
  }
	// Check if we are on the last page.
  $nextLink = (($temp = $html->find("div.pagination a[class='next']",0)) ?"http://www.yellowpages.com".$temp->href : NULL );
	$nextLink = html_entity_decode($nextLink);

	$html->clear();
	unset($html);
}

// Go through the array that we created for the individual pages.
foreach($pages as $pageurl) {
	$html = new simple_html_dom();
	$html = file_get_html("https://www.yellowpages.com".$pageurl);

	// Find the name, email and phone number on each page
	$name = $html->find('div.sales-info',0)->find('h1',0)->plaintext;
	$email = $html->find('a.email-business',0);
		if($email){
			$email = substr($email->href,7);
			}
	$phone = $html->find('p.phone',0)->plaintext;
	$td = array($name,$email,$phone);

	// Add the name email and phone number to our CSV
  fputcsv($fp,$td);

	$html->clear();
	unset($html);
}
$td = array($num);
fputcsv($fp,$td);
fclose($fp);

?>


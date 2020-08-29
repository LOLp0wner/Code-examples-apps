<?php
////////////////////CONFIG/////////////////
$sitemap_directory = '';
$output_directory = '';
///////////////////////////////////////////

function saveToSitemap($sitemap_directory, $output_directory) 
{
$sitemap = simplexml_load_file($sitemap_directory);
$content = file_get_contents($sitemap_directory);
$xml = simplexml_load_string($content);
    
if ($found == false) {
    $myNewUri = $sitemap->addChild("url");
    $myNewUri->addChild("loc", $current_page_url);
    $myNewUri->addChild("priority", "0.8");
    $sitemap->asXML($output_directory);
}
    
}
?>
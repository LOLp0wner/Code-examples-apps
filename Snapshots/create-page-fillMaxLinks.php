<?php
$saved_count = 1;
for ($i = 1; $i <= 21; $i++)
{
    $dom = new DOMDocument('1.0', 'UTF-8');
    $html = file_get_contents('template.php');
    @$dom->loadHTML($html);
    $xpath = new DOMXPath( $dom );
    $pDivs = $xpath->query(".//section[@id='inner_Placeholder']");
    
    $sitemap = simplexml_load_file('sitemaps/user_sitemap_'.$i.'.xml');
    
    $array_acc = Array();
    $MEGA_ARRAY = Array();
    
    $counter = 1;
    
    foreach ($sitemap->url as $urlElement)
    {
        if ($counter >= 487)
        {
            array_push($MEGA_ARRAY, $array_acc);
            $array_acc = Array();
            $counter = 1;
        }
        $url = $urlElement->loc;
        array_push($array_acc, $url);
        $counter++;
    } 
    
    $counter = 1;
    
    foreach($pDivs as $div)
    {
        foreach ($MEGA_ARRAY as $ar)
        {
            foreach ($ar as $ax)
                {
                
                if ($counter >= 487)
                {
                    $dom->saveHTMLFile("list_user_".$saved_count.".php");
                    $saved_count++;
                    $counter = 1;
                    $pTag = $dom->getElementsByTagName('p');
                    $spotid_children = array();

                    foreach ($pTag as $value) {
  
                        $spotid_children[] = $value; 
                        
                    }

                    foreach ($spotid_children as $spotid_child) {
                        $spotid_child->parentNode->removeChild($spotid_child); 
                    }
                }
                
                $mod_url = str_replace('https://{HIDDEN}/user/?user=', '', $ax);
                
                $domElemPar = $dom->createElement('p');
                $domElem = $dom->createElement('a',''.$mod_url.'');
                $domAttr = $dom->createAttribute('href');
                
                $domAttr->value = $ax;
                $domElem->appendChild($domAttr);
                
                $domElemPar->appendChild($domElem);
            
                $div->appendChild($domElemPar);
                $counter++;
                
                }
            
        }
        
    }
    
}

?>
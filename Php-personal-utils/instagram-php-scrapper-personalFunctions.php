<?php
//////////////INFO/////////////
// $loggedin_instagram - Instagram-PHP-Scrapper object
// Returns array of 12 images, from point $LOADED to $LOADED + 12
// It would be logical to call this function from AJAX with passed $LOADED variable.
// Accepts only modified raiym/instagram-php-scrapper/src/InstagramScrapper/Instagram.php from Instagram-PHP-Scrapper (file included in /included)
///////////////////////////////
function getMediaAdditional($TARGET_USR, $LOADED, $loggedin_instagram) {
try {
    $medias = $loggedin_instagram->getMediasAfter(usr_strFormater($TARGET_USR), $LOADED + 12 , $LOADED);
} 
catch (Exception $e) {
    echo 'sd';
}
    
$imgs = array();
    
foreach ($medias as $item)
{
    array_push($imgs, $item['imageLowResolutionUrl']);
}
    
return $imgs;  
}

//////////////INFO/////////////
// $loggedin_instagram - Instagram-PHP-Scrapper object
// $target_user - Instagram account username
// Returns array of first 12 images on targeted user's page.
///////////////////////////////
function getMedia($target_user, $loggedin_instagram) {
try {
    $medias = $loggedin_instagram->getMedias(strFormater($target_user), 12);
} catch (Exception $e) {
    echo 'Exception caught (important)';
}
    
$imgs = array();
    
foreach ($medias as $item) {
    array_push($imgs, $item['imageLowResolutionUrl']);
}
return $imgs;
}

//////////////INFO/////////////
// $loggedin_instagram - Instagram-PHP-Scrapper object
// $target_user - Instagram account username
// Returns public profile information about targeted user.
///////////////////////////////
function getProfileInfo($target_user, $loggedin_instagram) {
$account = $loggedin_instagram->getAccount(strFormater($target_user));
    
$profile_info['pictureUrl'] = $account->getProfilePicUrl();
$profile_info['username'] = $account->getUsername();
$profile_info['subscribedTo'] = $account->getFollowsCount();
$profile_info['publications'] = $account->getMediaCount();
$profile_info['followers'] = $account->getFollowedByCount();
$profile_info['fullName'] = $account->getFullName();
$profile_info['bio'] = $account->getBiography();
    
return $profile_info;
}

//////////////INFO/////////////
// $loggedin_instagram - Instagram-PHP-Scrapper object
// $target_user - Instagram account username
// Returns links of targeted user's stories. (LOW-QUALITY)
///////////////////////////////
function getStories($target_user, $loggedin_instagram) {
try {
    $medias = $loggedin_instagram->getMedias(strFormater($TARGET_USR));
} catch (InstagramScraper\Exception\InstagramException $e) {
    echo "Exception was caught (important)";
}

$imgs = array();
    
if (!empty($medias))
    {
        $id[] = $medias[0]->getOwner()->getid();
 
        $stories = $loggedin_instagram->getStories($id);
    
        if (!empty($stories))
        {
            $slides = $stories[0]->getStories();
        
            foreach($slides as $item) {
                if (!empty($item['videoLowBandwidthUrl']))
                {
                    $ref = $item['videoLowBandwidthUrl'];
                    array_push($imgs, $ref);
                } else {
                    if(!empty($item['imageLowResolutionUrl']))
                    {
                        $ref = $item['imageLowResolutionUrl'];
                        array_push($imgs, $ref);
                    }   
                }
            } 
        }
    return $imgs;
    }
}

//////////////INFO/////////////
// $initial_string - string to be formated
// accepts string with '@' and strips it, if none - ignores.
///////////////////////////////
function strFormater($initial_string) {
if (strpos($initial_string, "@") !== false)
{
    $formated_string = ltrim($initial_string, '@');
    return $formated_string;
} else {
    return $initial_string;
}
}

//////////////INFO/////////////
// $loggedin_instagram - Instagram-PHP-Scrapper object
// $target_user - Instagram account username
// Returns string (amount of targeted user's stories)
///////////////////////////////
function getStoriesAmount($target_user, $loggedin_instagram) {   
try {
    $medias = $loggedin_instagram->getMedias(strFormater($target_user));
} 
catch (Exception $e) {
    echo 'Exception caught (important)';
}
if (!empty($medias)) {
    $id[] = $medias[0]->getOwner()->getid();
    $stories = $loggedin_instagram->getStories($id);
    if (!empty($stories)) {
        $slides = $stories[0]->getStories();
        echo count($slides);
    } else {
        echo "0";
    }
} else {
    echo "0";
}
}
?>
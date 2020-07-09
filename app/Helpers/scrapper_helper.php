<?php
require_once(APPPATH.'ThirdParty/simple_html_dom.php');

function getFeaturedNews($url)
{
    $data = [];
    $html = @file_get_html($url);
    $links = $html->find("td a");
    foreach ($links as $a) {
        if (preg_match("/www.nairaland.com\/([\d]{6,})/i", $a->href)) {
            array_push($data, $a->href);
        }
    }
    $html->clear();
    return array_unique($data);
}

function havestData($url, $pattern_email, $pattern_phone)
{
    $html = @file_get_html($url);
    $data = [];
    if ($pattern_email) {
        preg_match_all($pattern_email, $html->plaintext, $array_email);
        $data["emails"] = array_unique($array_email[0]);
        
    }
    if ($pattern_phone) {
        preg_match_all($pattern_phone, $html->plaintext, $array_phone);
        $data["phones"] = array_unique($array_phone[0]);

    }
    $html->clear();
    return $data;
}

function havester($category, $pages_to_scan, $email_pattern, $phone_pattern, $withEmail=true, $withPhone=true)
{
    $BASE_URL      = "http://www.nairaland.com";
    $featured_articles = [];
    $emails = [];
    $phones = [];
    for ($i=1; $i <= $pages_to_scan; $i++) {
        $featured_articles =  array_merge($featured_articles, getFeaturedNews($BASE_URL."/$category/$i"));
    }
    
    foreach ($featured_articles as $article) {
        
        $havest = havestData($article, $withEmail ? $email_pattern:null, $withPhone ? $phone_pattern:null);
        
        if(array_key_exists("emails",$havest)){
            $emails = array_merge($emails, $havest["emails"]);
        }
        if(array_key_exists("phones",$havest)){
            $phones = array_merge($phones, $havest["phones"]);
        }
    }
    return array("emails"=>$emails??null,"phones"=>$phones??null);

}
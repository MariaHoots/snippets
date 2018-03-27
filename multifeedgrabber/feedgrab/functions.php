<?php 
function getConnectionWithAccessToken($cons_key, $cons_secret, $oauth_token, $oauth_token_secret) {
  $connection = new TwitterOAuth($cons_key, $cons_secret, $oauth_token, $oauth_token_secret);
  return $connection;
}

function hyperlinks($text) {
	// match name@address
	$text = preg_replace("/\b([a-zA-Z][a-zA-Z0-9\_\.\-]*[a-zA-Z]*\@[a-zA-Z][a-zA-Z0-9\_\.\-]*[a-zA-Z]{2,6})\b/i","<a href=\"mailto://$1\" class=\"twitter-link\">$1</a>", $text);
	//mach #trendingtopics. Props to Michael Voigt
	$text = preg_replace('/([\.|\,|\:|\¡|\¿|\>|\{|\(]?)#{1}(\w*)([\.|\,|\:|\!|\?|\>|\}|\)]?)\s/i', "$1<a href=\"http://twitter.com/#search?q=$2\" class=\"twitter-link\">#$2</a>$3 ", $text);
	return $text;
}

function twitter_users($text) {
   $text = preg_replace('/([\.|\,|\:|\¡|\¿|\>|\{|\(]?)@{1}(\w*)([\.|\,|\:|\!|\?|\>|\}|\)]?)\s/i', "$1<a href=\"http://twitter.com/$2\" class=\"twitter-user\">@$2</a>$3 ", $text);
   return $text;
}
function encode_tweet($text) {
		$text = mb_convert_encoding( $text, "HTML-ENTITIES", "UTF-8");
		return $text;
}
function twitter_get_media($status) { 
	if($status->entities->media) { 
		$media_html = ''; 
		foreach($status->entities->media as $media) { 
			$url = $media->media_url_https; 
			$link = $media->url;  
			$width = $media->sizes->thumb->w; 
			$height = $media->sizes->thumb->h;  
			$media_html .= '<a href="" rel="nofollow">'; 
			$media_html .= ""; $media_html .= "</a>"; 
		} 
		return $media_html;
	}
}

function GrabFeed($FeedUrls) {
	$feed = array();
	foreach ($FeedUrls as $FeedUrl) {
		$rss = new DOMDocument();
		$rss->load($FeedUrl['url']);
		foreach ($rss->getElementsByTagName('item') as $node) {
			$item = array ( 
				'title' => $node->getElementsByTagName('title')->item(0)->nodeValue,
				'desc' => $node->getElementsByTagName('description')->item(0)->nodeValue,
				'link' => $node->getElementsByTagName('link')->item(0)->nodeValue,
				'date' => strtotime($node->getElementsByTagName('pubDate')->item(0)->nodeValue),
				'source' => $FeedUrl['url'],
				'name' => $FeedUrl['name'],
				'icon' => $FeedUrl['icon'],
				);
			array_push($feed, $item);
		}
	}
	return $feed;
}
?>
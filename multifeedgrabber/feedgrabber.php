<?php
/*****************************************
/*
/* Multi Feed Grabber
/* Copyright GNU
/*
/*****************************************/


/* Add Feeds and information
/*****************************/
$feeds = array();
$feeds[0]['url'] = ''; //full feed URL
$feeds[0]['name'] = ''; //display name
$feeds[0]['icon'] = ''; //displaying on the site

$feeds[1]['url'] = '';
$feeds[1]['name'] = '';
$feeds[1]['icon'] = '';

//(Twitter App Name)
$twitter_name = 'tweeting';
$twitter_icon = 'assets/img/twitter.png';


/* Settings - General
/***********************/

$ItemsToDisplay = 7;

/* Settings - Twitter
/***********************/

//Number of Tweets to grab
$notweets = 7;

//Twitter auth tokens
$twitteruser = "";
$consumerkey = "";
$consumersecret = "";
$accesstoken = "";
$accesstokensecret = "";

//Exclude apps not counted in twitter
//(need detailled content of [source] in Twitter stdClass Object - does not count on retweets)

$ExcludedApps = array();
$ExcludedApps[] = '<a href="http://twitterfeed.com" rel="nofollow">twitterfeed</a>';
$ExcludedApps[] = '<a href="http://publicize.wp.com/" rel="nofollow">WordPress.com</a>';

/* DO NOT CHANGE BELOW
/*****************************************/

require_once("feedgrab/functions.php");
$debug = false;


/* Twitter Feeds
******************************************/
require_once("feedgrab/twitteroauth.php"); //Path to twitteroauth library

$connection = getConnectionWithAccessToken($consumerkey, $consumersecret, $accesstoken, $accesstokensecret);
$tweets = $connection->get("https://api.twitter.com/1.1/statuses/user_timeline.json?screen_name=".$twitteruser."&count=".$notweets);

/* Get Tweets into array
*************************/
$TweetsArray = array();

foreach ($tweets as $tweet) {
	$included = true;
	$profile_image_url = $tweet->user->profile_image_url;
	$screen_name = $tweet->user->screen_name;
	$name = $tweet->user->name;
	$source = $tweet->source;
	$timestamp = strtotime($tweet->created_at);
	/* link urls */
	$text = $tweet->text;
	$i = 0;
	if($tweet->entities->urls) {
		foreach($tweet->entities->urls as $url) {
			$urls[$i]['url'] = $url->url;
			$urls[$i]['expanded_url'] = $url->expanded_url;
			$urls[$i]['display_url'] = $url->display_url;
			$i++;
		}
	} else {
		if (isset($tweet->retweeted_status)) { /* check if RT has some urls */
			if (isset($tweet->retweeted_status->entities->urls)) {
				foreach($tweet->retweeted_status->entities->urls as $url) {
					$urls[$i]['url'] = $url->url;
					$urls[$i]['expanded_url'] = $url->expanded_url;
					$urls[$i]['display_url'] = $url->display_url;
					$i++;
				}
			}
		} else {
			$urls = false;
		}
	}
	if ($urls) {
		foreach ($urls as $url) {
			$text = str_replace($url['url'], '<a href="'.$url['url'].'" title="'.$url['expanded_url'].'" target="_blank" rel="nofollow" class="tweet-link">'.$url['display_url'].'</a>', $text);
		}
	}
	$text = twitter_users($text);
	$text = hyperlinks($text);
	if (isset($tweet->retweeted_status)) { /* RT status */
		$screen_name = $tweet->retweeted_status->user->screen_name;
		$name = $tweet->retweeted_status->user->name;
		$text = str_replace('RT ',"",$text);
		$status = 'RT';
	} else {
		$status = 'T';
	}

	//Check if app is included
	foreach ($ExcludedApps as $App) {
		if ($source == $App) {
			$included = false;
		}
	}
	if ($included == true ) {
		$item = array (
			'screen_name' => $screen_name,
			'tw_name' => $name,
			'desc' => $text,
			'status' => $status,
			'date' => $timestamp,
			'source' => $source,
			'name' => $twitter_name,
			'icon' => $twitter_icon,
		);
		array_push($TweetsArray, $item);
	}
}

/* Grab Feeds
******************************************/

$ItemsArray = GrabFeed($feeds);

foreach ($TweetsArray as $ArrayItem) {
	array_push($ItemsArray, $ArrayItem);
}


/* Sort Feeds
******************************************/
function date_compare($a, $b) {
    $t1 = $a['date'];
    $t2 = $b['date'];
    return $t2 - $t1;
}
usort($ItemsArray, 'date_compare');

if ($debug) {
	echo '<pre>';
	print_r($ItemsArray);
	echo '</pre>';
} else {
	echo '<div id="multifeed_timeline">';
	$i = 0;
	$tweetcounter = 0;
	$tweetblocks = 1;
	foreach ($ItemsArray as $Item) {
		/* time */
		$now = time();
		$secs = $now - $Item['date'];
		$hours = $secs / 60 / 60;
		if ($hours < 24) {
			$rounded = round($hours);
			if($rounded == 0) {
				$minutes = $secs / 60;
				$created = round($minutes).' min';
			} else {
				$created = $rounded.' h';
			}
		} else {
			$created = date('d M',$Item['date']);
		}
		if ($Item['name'] == $twitter_name) {
			$MultiFeedTitle ='<a href="http://twitter.com/'.$Item['screen_name'].'" target="_blank"><span class="twitter_name">'.$Item['tw_name'].'</span> <span class="twitter_screen">@'.$Item['screen_name'].'</span></a>';
		} else {
			$MultiFeedTitle = '<a href="'.$Item['link'].'" target="_blank">'.$Item['title'].'</a>';
		}
		?>
		<?php if (($Item['status'] == 'RT') OR ($Item['status'] == 'T')) {
			$tweetcounter++;
		} else {
			//reset counter
			$tweetcounter = 0;
			$tweetblocks = 0;
		}
		if ($tweetcounter == 2) {
			$tweetblocks++; ?>
		<img src="assets/img/plus.png" id="tweetblock-<?php echo $tweetblocks; ?>" ></img><p>Show more tweets...</p>
		<?php }
		if ($tweetcounter > 1) { ?>
		<li class="moretweet">
		<?php } else {?>
		<li>
		<?php }
		if ($Item['status'] == 'RT') {
			echo '<img src="assets/img/retweet.png" class="retweet" />';
			$Item['name'] = 'retweeting';
		} ?>
			<img src="<?php echo $Item['icon']; ?>" alt="<?php echo $Item['name']; ?>" class="multifeed_item_image" /><span class="multifeed_item_desc">...<?php echo $Item['name']; ?></span>
			<div class="multifeed_content">
				<span class="multifeed_title"><?php echo $MultiFeedTitle; ?></span><span class="multifeed_date"><?php echo $created; ?></span>
				<p class="multifeed_text"><?php echo $Item['desc']; ?>
			</div>
		</li>
		<?php
		$i++;
		if ($i == $ItemsToDisplay) {
			break;
		}
	}
	echo '</div>';
}
?>

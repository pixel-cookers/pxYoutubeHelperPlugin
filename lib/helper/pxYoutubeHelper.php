<?php

/*
* For the full copyright and license information, please view the LICENSE
* file that was distributed with this source code.
*/

/**
 * pxYoutubeHelper
 * Helper to easily integrate Youtube videos in your Symfony Project
 *
 * @author     Ludovic Meyer <ludovic.meyer@pixel-cookers.com>
 * @version    1.1.0
 */


/**
 *
 * Helper code to integrate a Youtube video with the Iframe API<br />
 * See http://code.google.com/intl/fr-FR/apis/youtube/iframe_api_reference.html
 *
 * @param string $video_id Youtube video ID
 * @param int $width video width in pixel
 * @param int $height video height in pixel
 * @param array $params an array containing specific iframe API parameters
 * @param array $player_vars an array containing player paramaters (http://code.google.com/intl/fr-FR/apis/youtube/youtube_player_demo.html)
 * @param string $type 'new' or 'old' to use the new (Iframe) or the old (javascript) API
 */
function px_youtube_video($video_id, $width = 640, $height = 390, $params = array(), $player_vars = array(), $type = 'new'){

	if($type == 'old') return px_old_youtube_video($video_id, $width, $height, $params);

	if(isset($params['volume'])){
		$volume = 'event.target.setVolume('.$params['volume'].');';
		unset($params['volume']);
	}
	if(isset($params['quality'])){
		$quality = 'event.target.setPlaybackQuality("'.$params['quality'].'");';
		unset($params['quality']);
	}

	$player_vars = json_encode($player_vars);

	$html = '';
	$html .= '<div id="player_'.$video_id.'"></div>';
	$html .= '<script>
				var tag = document.createElement("script");
				tag.src = "http://www.youtube.com/player_api"
				var firstScriptTag = document.getElementsByTagName("script")[0];
				firstScriptTag.parentNode.insertBefore(tag, firstScriptTag);
				var player;
				function onYouTubePlayerAPIReady() {
			        player = new YT.Player("player_'.$video_id.'", {
			          height: "'.$width.'",
			          width: "'.$height.'",
			          videoId: "'.$video_id.'",
			          playerVars: '.$player_vars.',
			          events: {
			            "onReady": onPlayerReady,
			            "onStateChange": onPlayerStateChange
			          }
			        });
		      	}

		      	function onPlayerReady(event) {
		      	 	'.$volume.'
		      	 	'.$quality.'
 					event.target.playVideo();
				}

				function onPlayerStateChange(event) {}
		      ';

	$html .= '</script>';

	return $html;
}

/**
*
* Helper code to integrate a Youtube video with the Javascript API<br />
* See http://code.google.com/intl/fr-FR/apis/youtube/js_api_reference.html
*
* @param string $video_id Youtube video ID
* @param int $width video width in pixel
* @param int $height video height in pixel
* @param array $params an array containing specific javascript API parameters
*/
function px_old_youtube_video($video_id, $width = 640, $height = 390, $params = array()){
	if(isset($params['volume'])){
		$volume = 'event.target.setVolume('.$params['volume'].');';
		unset($params['volume']);
	}
	if(isset($params['quality'])){
		$quality = 'event.target.setPlaybackQuality("'.$params['quality'].'");';
		unset($params['quality']);
	}

	$html = '';

	$html .= '<object style="height: '.$height.'px; width: '.$width.'px">';
	$html .= '<param name="movie" value="http://www.youtube.com/v/'.$video_id.'?version=3&feature=player_embedded';
	if(count($params)){
		foreach($params as $key => $value){
			$html .= '&'.$key.'='.$value;
		}
	}
	$html .= '">';
	$html .= '<param name="allowFullScreen" value="true">';
	$html .= '<param name="allowScriptAccess" value="always">';
	$html .= '<param name="wmode" value="opaque">';

	$html .= '<embed type="application/x-shockwave-flash" allowfullscreen="true" allowScriptAccess="always" wmode="opaque" width="'.$width.'" height="'.$height.'" src="http://www.youtube.com/v/'.$video_id.'?version=3&feature=player_embedded';
	if(count($params)){
		foreach($params as $key => $value){
			$html .= '&'.$key.'='.$value;
		}
	}
	$html .= '">';
	$html .= '</object>';

	return $html;
}
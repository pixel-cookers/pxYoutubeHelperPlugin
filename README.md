pxYoutubeHelperPlugin is a helper that helps you embed Youtube video in your symfony project.

# Installation

Put the plugin in your symfony installation :

If you are using Git, use the following command in your project root folder : 

	git submodule add git@github.com:pixel-cookers/pxYoutubeHelperPlugin.git plugins/pxYoutubeHelperPlugin

		
Else go to https://github.com/pixel-cookers/pxYoutubeHelperPlugin and download the archive.
Unzip it in `SF_DIR/plugins/pxYoutubeHelperPlugin`

Add the pxYoutubeHelper plugin to your `SF_DIR/config/ProjectConfiguration.class.php`

	public function setup(){
			$this->enablePlugins(
				'pxYoutubeHelperPlugin'
			);
		}

There is two ways to embed a Youtube video : 


1. The new one : iframe API</li>
2. The old one : javascript API</li>


## Iframe API

Just call the helper like this


	<?php echo px_youtube_video('kM9iYy8-sGQ', 620, 382)?>


Output :

	<div id="player_kM9iYy8-sGQ"></div>
	<script>
		var tag = document.createElement("script");
		tag.src = "http://www.youtube.com/player_api"
		var firstScriptTag = document.getElementsByTagName("script")[0];
		firstScriptTag.parentNode.insertBefore(tag, firstScriptTag);
		var player;
		
		function onYouTubePlayerAPIReady() {
			player = new YT.Player("player_kM9iYy8-sGQ", {
			  height: "382",
			  width: "620",
			  videoId: "kM9iYy8-sGQ",
			  playerVars: [],
			  events: {
				"onReady": onPlayerReady,
				"onStateChange": onPlayerStateChange
			  }
			});
		}

		function onPlayerReady(event) {
			event.target.playVideo();
		}
		function onPlayerStateChange(event) {}
	</script>


## Javascript API

	<?php echo px_youtube_video('kM9iYy8-sGQ', 620, 382, array(), array(), 'old')?>

Output : 

	<object style="height: 382px; width: 620px">
		<param name="movie" value="http://www.youtube.com/v/kM9iYy8-sGQ?version=3&feature=player_embedded">
		<param name="allowFullScreen" value="true">
		<param name="allowScriptAccess" value="always">
		<param name="wmode" value="opaque">
		<embed type="application/x-shockwave-flash" 
			allowfullscreen="true" 
			allowScriptAccess="always" 
			wmode="opaque" 
			width="620" 
			height="382" 
			src="http://www.youtube.com/v/kM9iYy8-sGQ?version=3&feature=player_embedded">
	</object>


### Advanced config example : 

	<?php echo px_youtube_video('kM9iYy8-sGQ', 620, 382, array('controls'=> 0, 'rel' => 0, 'showinfo' => 0), array(), 'old')?>

Output : 

	<object style="height: 382px; width: 620px">
		<param name="movie" value="http://www.youtube.com/v/kM9iYy8-sGQ?version=3&feature=player_embedded&controls=0&rel=0&showinfo=0">
		<param name="allowFullScreen" value="true">
		<param name="allowScriptAccess" value="always">
		<param name="wmode" value="opaque">
		<embed type="application/x-shockwave-flash" 
			allowfullscreen="true" 
			allowScriptAccess="always" 
			wmode="opaque" 
			width="620" 
			height="382" 
			src="http://www.youtube.com/v/kM9iYy8-sGQ?version=3&feature=player_embedded&controls=0&rel=0&showinfo=0">
	</object>
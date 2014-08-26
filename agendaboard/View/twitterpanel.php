<div class="row blankRow_#ROOM#"></div>
<div class="container twitterRow_#ROOM# twitterContainer">
	<div class="row">
		<div class='col-xs-12 col-sm-12 col-md-12 col-lg-12 liveTweetsTop '>Live Tweets</div>
	</div>
	<div class="row" id="twitterFeed_#ROOM#">
		<div class="twitterPanel col-xs-12 col-sm-12 col-md-12 col-lg-12 ">
			#TWEETS#
		</div>
		<script>!function(d,s,id){var js,fjs=d.getElementsByTagName(s)[0];if(!d.getElementById(id)){js=d.createElement(s);js.id=id;js.src="http://platform.twitter.com/widgets.js";fjs.parentNode.insertBefore(js,fjs);}}(document,"script","twitter-wjs");</script>
	</div>
	<div class="row">
		<div class='col-xs-12 col-sm-12 col-md-12 col-lg-12 liveTweetsBottom'>
			<center><a href="https://twitter.com/intent/tweet?button_hashtag=#TWITTER_HASH#&text=@seattleinteract%20%23sic2013" class="twitter-hashtag-button" data-lang="en" data-related="">Tweet # #TWITTER_HASH#</a></center>
		</div>	
	</div>
</div>
<script>
$(".blankRow_#ROOM#").height($(".#EVENT_ID#").height() - (($(".twitterRow_#ROOM#").position().top - $(".#EVENT_ID#").position().top) + $(".twitterRow_#ROOM#").height()));
</script>
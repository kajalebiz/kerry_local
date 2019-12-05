<?php

function obj_do_latest_tweet_hero( $account = null, $link = true ) {
	if ( empty( $account ) ) {
		$account = 'kerrybodine';
	}
	$tweet = getTweets( $account, 1, array( 'tweet_mode' => 'extended' ) );

	// var_dump( $tweet[0]['full_text'] );

	if ( is_array( $tweet ) ) {
		$the_tweet = obj_get_tweet( $tweet[0] );

		if ( ! empty( $the_tweet ) ) {
			echo "<div class='twitter-hero'>";
			echo "<div class='tweet'>";
			echo $the_tweet;
			echo '</div>';
			if ( $link ) {?>
			<span class="green-button">
				<a href="https://twitter.com/<?php echo $account; ?>">Follow On Twitter</a>
			</span>
			<?php
			}
			echo '</div>';
		}
	}

}


function obj_get_tweet( $tweet = null ) {
	if ( ! empty( $tweet ) ) {
		if ( $tweet['full_text'] ) {
			$the_tweet = $tweet['full_text'];

			// i. User_mentions must link to the mentioned user's profile.
			if ( is_array( $tweet['entities']['user_mentions'] ) ) {
				foreach ( $tweet['entities']['user_mentions'] as $key => $user_mention ) {
					$the_tweet = preg_replace(
						'/@' . $user_mention['screen_name'] . '/i',
						'<a href="http://www.twitter.com/' . $user_mention['screen_name'] . '" target="_blank">@' . $user_mention['screen_name'] . '</a>',
						$the_tweet
					);
				}
			}

			// ii. Hashtags must link to a twitter.com search with the hashtag as the query.
			if ( is_array( $tweet['entities']['hashtags'] ) ) {
				foreach ( $tweet['entities']['hashtags'] as $key => $hashtag ) {
					$the_tweet = preg_replace(
						'/#' . $hashtag['text'] . '/i',
						'<a href="https://twitter.com/search?q=%23' . $hashtag['text'] . '&src=hash" target="_blank">#' . $hashtag['text'] . '</a>',
						$the_tweet
					);
				}
			}

			// iii. Links in Tweet text must be displayed using the display_url
			//      field in the URL entities API response, and link to the original t.co url field.
			if ( is_array( $tweet['entities']['urls'] ) ) {
				foreach ( $tweet['entities']['urls'] as $key => $link ) {
					$the_tweet = preg_replace(
						'`' . $link['url'] . '`',
						'<a href="' . $link['url'] . '" target="_blank">' . $link['url'] . '</a>',
						$the_tweet
					);
				}
			}
			return $the_tweet;
		}
		return null;
	}
	return null;
}

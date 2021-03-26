<?php

/**
 * The plugin bootstrap file
 *
 * This file is read by WordPress to generate the plugin information in the plugin
 * admin area. This file also includes all of the dependencies used by the plugin,
 * registers the activation and deactivation functions, and defines a function
 * that starts the plugin.
 *
 * @link              #
 * @since             1.0.0
 * @package           WordPress Shortcode About Us
 *
 * @wordpress-plugin
 * Plugin Name:       About Us Shortcodes
 * Plugin URI:        #
 * Description:       This generates markup with Shortcodes, with the goal of one day migrating it to WP blocks.
 * Version:           1.0.0
 * Author:            Rocky Kev
 * Author URI:        #
 * License:           GPL-2.0+
 * License URI:       http://www.gnu.org/licenses/gpl-2.0.txt
 * Text Domain:       wordpress-shortcode-vue
 * Domain Path:       /languages
 */

// If this file is called directly, abort.
if (!defined('WPINC')) {
	die;
}


// VIDEO BLOCK
// [shortcode-video-block]
// [shortcode-video-block autoplay=true muted=true looped=true controls=true
//     poster="http://media.w3.org/2010/05/sintel/poster.png"
//     source="http://media.w3.org/2010/05/sintel/trailer.mp4"]


function shortcode_video_block($atts = [], $content = null) {

    $blockAtts = shortcode_atts(
        [
            'autoplay' => false,
            'muted' => false,
            'loop' => false,
            'controls' => true,
            'display' => 'wide',
            'preload' => 'metadata',
            'poster' => '',
            'source' => ''
        ], $atts);


    // booleans
    $isAutoplay = ($blockAtts['autoplay']) ? 'autoplay' : '';
    $isMuted = ($blockAtts['muted']) ? 'muted' : '';
    $isLooped = ($blockAtts['loop']) ? 'loop' : '';
    $videoControls = ($blockAtts['controls']) ? 'controls' : '';

    $display = $blockAtts['display'];
    $preload = $blockAtts['preload']; //none or metadata
    $poster = $blockAtts['poster'];
    $source = $blockAtts['source'];

    // display
    $inlineStyle = 'margin: 0 auto;';
    if ($display == 'wide') {
        $inlineStyle .= 'width: 100%;';
    } else {
        $inlineStyle = 'width: 50%;';
    };

    // get video type
    $videoType = '';

    $videoTypeCheck = substr($source, strrpos($source, '.')+1);
    switch ($videoTypeCheck) {
        case "mp4";
        case "m4v";
        case "m4p";
            $videoType = 'mp4' ;
            break;
        case "ogv";
        case "ogg";
            $videoType = 'ogg' ;
            break;
        case "webm";
            $videoType = 'webm' ;
            break;
        case "mpg";
        case "mpeg";
            $videoType = 'mpeg';
        default:
            $videoType = 'error';
    }

    if ($videoType == 'error') {
        return '<p>There is an error with your video link.</p>';
    }

    ob_start();
    ?>
    <div style="<?php $inlineStyle; ?>">
            <video
                <?php echo "$videoControls $isAutoplay $isLooped $isMuted"; ?>
                preload="<?php echo $preload; ?>"
                poster="<?php echo $poster; ?>"
                width="100%"
            >
            <source src="<?php echo $source; ?>" type="video/<?php echo $videoType; ?>">
            Sorry, your browser doesn't support embedded videos.
        </video>
    </div>
    <?php

    return ob_get_clean();

}

add_shortcode('shortcode-video-block', 'shortcode_video_block');

// HERO BLOCK
// [shortcode-hero-block]
// [shortcode-hero-block
//     header="This is the best thing ever"
//     subheader="Now you know"
//     text-color="white"
//     img-size="cover"
//     img-src="https://blog.pixlr.com/wp-content/uploads/2019/03/stars-pattern.png"
// ]

function shortcode_hero_block($atts = [], $content = null) {

    $blockAtts = shortcode_atts(
        [
            'header' => "Replace Me",
            'subheader' => '',
            'text-color' => 'black',
            'text-location' => 'center', // top, bottom, center
            'img-height' => '400',
            'img-size' => 'contain',
            'img-src' => 'https://i.imgur.com/QsiWlp0.jpeg'
        ], $atts);

    switch($blockAtts['text-location']) {
        case "top":
            $blockAtts['text-location'] = 'flex-start';
            break;
        case "bottom":
            $blockAtts['text-location'] = 'flex-end';
            break;
        default:
            break;
    }

    $header = $blockAtts['header'];
    $subheader = $blockAtts['subheader'];

    $textColor = 'color: ' . $blockAtts['text-color'] . ';';

    $display = 'width: 100%; display: flex; flex-direction: column; padding: 2.5rem 1rem;'; //wide or normal?
    $textLocation = 'justify-content: ' . $blockAtts['text-location'] . ';';
    $imageHeight = 'height: ' . $blockAtts['img-height'] . 'px;';
    $backgroundType = 'background-size: ' . $blockAtts['img-size'] . ';'; //contain or cover
    $backgroundRepeat = 'background-repeat: no-repeat;';

    $imgSource = 'background-image: url(' . $blockAtts['img-src'] . ');';

    $inlineCSS = $display . $textLocation . $imageHeight . $backgroundType . $backgroundRepeat . $imgSource;

    ob_start();
    ?>
        <div style="<?php echo $inlineCSS ?>">
            <h2 style="<?php echo $textColor ?>"><?php echo $header; ?></h2>
            <?php if (!empty($blockAtts['subheader'])): ?>
                <h3 style="<?php echo $textColor ?>"><?php echo $subheader; ?></h3>
            <?php endif; ?>
        </div>
    <?php

    return ob_get_clean();

  }
add_shortcode('shortcode-hero-block', 'shortcode_hero_block');


// SOCIAL MEDIA BLOCK
// [shortcode-social-media-block]
// [shortcode-social-media-block
//   inner-text="Linked in!"
//   link="https://www.linkedin.com/in/foone-turing-7921a2100/"
// ]

// [shortcode-social-media-block
//   inner-text="the Facebook!"
//   link="https://www.facebook.com/jornaloglobo"
// ]

// [shortcode-social-media-block
//   inner-text="the twitter!"
//   link="https://twitter.com/jemyoung"
// ]

// [shortcode-social-media-block
//   inner-text="the pinterest!"
//   link="https://www.pinterest.com/joannamagrath/pinterest-squirrels/"
// ]

// [shortcode-social-media-block
//   inner-text="the instagram!"
//   link="https://www.instagram.com/dogsofinstagram/"
// ]


function shortcode_social_media_block($atts = [], $content = null) {

    $blockAtts = shortcode_atts(
        [
            'inner-text' => "@chriscoyier",
            'link' => 'https://twitter.com/chriscoyier',
        ], $atts);

    // check the type of social media gives you a dashicon
    $socialMediaTitle = $blockAtts['inner-text'];
    $link = $blockAtts['link'];

    // $link = 'https://twitter.com/chriscoyier';
    // $socialMediaTitle = '@chriscoyier';

    $inlineStyle = 'line-height: inherit; text-decoration: none;';

    $socialMediaChoices = ['facebook', 'twitter', 'linkedin', 'pinterest', 'instagram'];

    foreach ($socialMediaChoices as $socialMedia) {
        if (strpos($link, $socialMedia)) {
            $linkType = $socialMedia;
            break;
        }
    }

    // SET ERROR MESSAGE
    if (!isset($linkType)) {
        $errorMsg = "Your social media choice doesn't exist. Try again";
    }

    // ERROR MESSAGE
    if (isset($errorMsg)) {
        return "<p>$errorMsg</p>";
    }

    ob_start();
    ?>
        <a href="<?php echo $link; ?>" target="_blank" rel="noopener"><span style="<?php echo $inlineStyle; ?>" class="dashicons dashicons-<?php echo $linkType; ?>"></span><?echo $socialMediaTitle; ?></a>
    <?php

    return ob_get_clean();

  }
add_shortcode('shortcode-social-media-block', 'shortcode_social_media_block');



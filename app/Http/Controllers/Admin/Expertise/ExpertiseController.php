<?php

namespace App\Http\Controllers\Admin\Expertise;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Validator;
use App\Models\Expertise;

class ExpertiseController extends Controller
{
    private $fa_array = ["fa fa-500px","fas fa-theater-masks","fa fa-address-book","fa fa-address-book-o","fa fa-address-card","fa fa-address-card-o","fa fa-adjust","fa fa-adn","fa fa-align-center","fa fa-align-justify","fa fa-align-left","fa fa-align-right","fa fa-amazon","fa fa-ambulance","fa fa-american-sign-language-interpreting","fa fa-anchor","fa fa-android","fa fa-angellist","fa fa-angle-double-down","fa fa-angle-double-left","fa fa-angle-double-right","fa fa-angle-double-up","fa fa-angle-down","fa fa-angle-left","fa fa-angle-right","fa fa-angle-up","fa fa-apple","fa fa-archive","fa fa-area-chart","fa fa-arrow-circle-down","fa fa-arrow-circle-left","fa fa-arrow-circle-o-down","fa fa-arrow-circle-o-left","fa fa-arrow-circle-o-right","fa fa-arrow-circle-o-up","fa fa-arrow-circle-right","fa fa-arrow-circle-up","fa fa-arrow-down","fa fa-arrow-left","fa fa-arrow-right","fa fa-arrow-up","fa fa-arrows","fa fa-arrows-alt","fa fa-arrows-h","fa fa-arrows-v","fa fa-asl-interpreting","fa fa-assistive-listening-systems","fa fa-asterisk","fa fa-at","fa fa-audio-description","fa fa-automobile","fa fa-backward","fa fa-balance-scale","fa fa-ban","fa fa-bandcamp","fa fa-bank","fa fa-bar-chart","fa fa-bar-chart-o","fa fa-barcode","fa fa-bars","fa fa-bath","fa fa-bathtub","fa fa-battery","fa fa-battery-0","fa fa-battery-1","fa fa-battery-2","fa fa-battery-3","fa fa-battery-4","fa fa-battery-empty","fa fa-battery-full","fa fa-battery-half","fa fa-battery-quarter","fa fa-battery-three-quarters","fa fa-bed","fa fa-beer","fa fa-behance","fa fa-behance-square","fa fa-bell","fa fa-bell-o","fa fa-bell-slash","fa fa-bell-slash-o","fa fa-bicycle","fa fa-binoculars","fa fa-birthday-cake","fa fa-bitbucket","fa fa-bitbucket-square","fa fa-bitcoin","fa fa-black-tie","fa fa-blind","fa fa-bluetooth","fa fa-bluetooth-b","fa fa-bold","fa fa-bolt","fa fa-bomb","fa fa-book","fa fa-bookmark","fa fa-bookmark-o","fa fa-braille","fa fa-briefcase","fa fa-btc","fa fa-bug","fa fa-building","fa fa-building-o","fa fa-bullhorn","fa fa-bullseye","fa fa-bus","fa fa-buysellads","fa fa-cab","fa fa-calculator","fas fa-calendar-check","fas fa-calendar-check-check-o","fas fa-calendar-check-minus-o","fas fa-calendar-check-o","fas fa-calendar-check-plus-o","fas fa-calendar-check-times-o","fa fa-camera","fa fa-camera-retro","fa fa-car","fa fa-caret-down","fa fa-caret-left","fa fa-caret-right","fa fa-caret-square-o-down","fa fa-caret-square-o-left","fa fa-caret-square-o-right","fa fa-caret-square-o-up","fa fa-caret-up","fa fa-cart-arrow-down","fa fa-cart-plus","fa fa-cc","fa fa-cc-amex","fa fa-cc-diners-club","fa fa-cc-discover","fa fa-cc-jcb","fa fa-cc-mastercard","fa fa-cc-paypal","fa fa-cc-stripe","fa fa-cc-visa","fa fa-certificate","fa fa-chain","fa fa-chain-broken","fa fa-check","fa fa-check-circle","fa fa-check-circle-o","fa fa-check-square","fa fa-check-square-o","fa fa-chevron-circle-down","fa fa-chevron-circle-left","fa fa-chevron-circle-right","fa fa-chevron-circle-up","fa fa-chevron-down","fa fa-chevron-left","fa fa-chevron-right","fa fa-chevron-up","fa fa-child","fa fa-chrome","fa fa-circle","fa fa-circle-o","fa fa-circle-o-notch","fa fa-circle-thin","fa fa-clipboard","fa fa-clock-o","fa fa-clone","fa fa-close","fa fa-cloud","fa fa-cloud-download","fa fa-cloud-upload","fa fa-cny","fa fa-code","fa fa-code-fork","fa fa-codepen","fa fa-codiepie","fa fa-coffee","fa fa-cog","fa fa-cogs","fa fa-columns","fa fa-comment","fa fa-comment-o","fa fa-commenting","fa fa-commenting-o","fa fa-comments","fa fa-comments-o","fa fa-compass","fa fa-compress","fa fa-connectdevelop","fa fa-contao","fa fa-copy","fa fa-copyright","fa fa-creative-commons","fa fa-credit-card","fa fa-credit-card-alt","fa fa-crop","fa fa-crosshairs","fa fa-css3","fa fa-cube","fa fa-cubes","fa fa-cut","fa fa-cutlery","fa fa-dashboard","fa fa-dashcube","fa fa-database","fa fa-deaf","fa fa-deafness","fa fa-dedent","fa fa-delicious","fa fa-desktop","fa fa-deviantart","fa fa-diamond","fa fa-digg","fa fa-dollar","fa fa-dot-circle-o","fa fa-download","fa fa-dribbble","fa fa-drivers-license","fa fa-drivers-license-o","fa fa-dropbox","fa fa-drupal","fa fa-edge","fa fa-edit","fa fa-eercast","fa fa-eject","fa fa-ellipsis-h","fa fa-ellipsis-v","fa fa-empire","fa fa-envelope","fa fa-envelope-o","fa fa-envelope-open","fa fa-envelope-open-o","fa fa-envelope-square","fa fa-envira","fa fa-eraser","fa fa-etsy","fa fa-eur","fa fa-euro","fa fa-exchange","fa fa-exclamation","fa fa-exclamation-circle","fa fa-exclamation-triangle","fa fa-expand","fa fa-expeditedssl","fa fa-external-link","fa fa-external-link-square","fa fa-eye","fa fa-eye-slash","fa fa-eyedropper","fa fa-fa","fa fa-facebook","fa fa-facebook-f","fa fa-facebook-official","fa fa-facebook-square","fa fa-fast-backward","fa fa-fast-forward","fa fa-fax","fa fa-feed","fa fa-female","fa fa-fighter-jet","fa fa-file","fa fa-file-archive-o","fa fa-file-audio-o","fa fa-file-code-o","fa fa-file-excel-o","fa fa-file-image-o","fa fa-file-movie-o","fa fa-file-o","fa fa-file-pdf-o","fa fa-file-photo-o","fa fa-file-picture-o","fa fa-file-powerpoint-o","fa fa-file-sound-o","fa fa-file-text","fa fa-file-text-o","fa fa-file-video-o","fa fa-file-word-o","fa fa-file-zip-o","fa fa-files-o","fa fa-film","fa fa-filter","fa fa-fire","fa fa-fire-extinguisher","fa fa-firefox","fa fa-first-order","fa fa-flag","fa fa-flag-checkered","fa fa-flag-o","fa fa-flash","fa fa-flask","fa fa-flickr","fa fa-floppy-o","fa fa-folder","fa fa-folder-o","fa fa-folder-open","fa fa-folder-open-o","fa fa-font","fa fa-font-awesome","fa fa-fonticons","fa fa-fort-awesome","fa fa-forumbee","fa fa-forward","fa fa-foursquare","fa fa-free-code-camp","fa fa-frown-o","fa fa-futbol-o","fa fa-gamepad","fa fa-gavel","fa fa-gbp","fa fa-ge","fa fa-gear","fa fa-gears","fa fa-genderless","fa fa-get-pocket","fa fa-gg","fa fa-gg-circle","fa fa-gift","fa fa-git","fa fa-git-square","fa fa-github","fa fa-github-alt","fa fa-github-square","fa fa-gitlab","fa fa-gittip","fa fa-glass","fa fa-glide","fa fa-glide-g","fa fa-globe","fa fa-google","fa fa-google-plus","fa fa-google-plus-circle","fa fa-google-plus-official","fa fa-google-plus-square","fa fa-google-wallet","fa fa-graduation-cap","fa fa-gratipay","fa fa-grav","fa fa-group","fa fa-h-square","fa fa-hacker-news","fa fa-hand-grab-o","fa fa-hand-lizard-o","fa fa-hand-o-down","fa fa-hand-o-left","fa fa-hand-o-right","fa fa-hand-o-up","fa fa-hand-paper-o","fa fa-hand-peace-o","fa fa-hand-pointer-o","fa fa-hand-rock-o","fa fa-hand-scissors-o","fa fa-hand-spock-o","fa fa-hand-stop-o","fa fa-handshake-o","fa fa-hard-of-hearing","fa fa-hashtag","fa fa-hdd-o","fa fa-header","fa fa-headphones","fa fa-heart","fa fa-heart-o","fa fa-heartbeat","fa fa-history","fa fa-home","fa fa-hospital-o","fa fa-hotel","fa fa-hourglass","fa fa-hourglass-1","fa fa-hourglass-2","fa fa-hourglass-3","fa fa-hourglass-end","fa fa-hourglass-half","fa fa-hourglass-o","fa fa-hourglass-start","fa fa-houzz","fa fa-html5","fa fa-i-cursor","fa fa-id-badge","fa fa-id-card","fa fa-id-card-o","fa fa-ils","fa fa-image","fa fa-imdb","fa fa-inbox","fa fa-indent","fa fa-industry","fa fa-info","fa fa-info-circle","fa fa-inr","fa fa-instagram","fa fa-institution","fa fa-internet-explorer","fa fa-intersex","fa fa-ioxhost","fa fa-italic","fa fa-joomla","fa fa-jpy","fa fa-jsfiddle","fa fa-key","fa fa-keyboard-o","fa fa-krw","fa fa-language","fa fa-laptop","fa fa-lastfm","fa fa-lastfm-square","fa fa-leaf","fa fa-leanpub","fa fa-legal","fa fa-lemon-o","fa fa-level-down","fa fa-level-up","fa fa-life-bouy","fa fa-life-buoy","fa fa-life-ring","fa fa-life-saver","fa fa-lightbulb-o","fa fa-line-chart","fa fa-link","fa fa-linkedin","fa fa-linkedin-square","fa fa-linode","fa fa-linux","fa fa-list","fa fa-list-alt","fa fa-list-ol","fa fa-list-ul","fa fa-location-arrow","fa fa-lock","fa fa-long-arrow-down","fa fa-long-arrow-left","fa fa-long-arrow-right","fa fa-long-arrow-up","fa fa-low-vision","fa fa-magic","fa fa-magnet","fa fa-mail-forward","fa fa-mail-reply","fa fa-mail-reply-all","fa fa-male","fa fa-map","fa fa-map-marker","fa fa-map-o","fa fa-map-pin","fa fa-map-signs","fa fa-mars","fa fa-mars-double","fa fa-mars-stroke","fa fa-mars-stroke-h","fa fa-mars-stroke-v","fa fa-maxcdn","fa fa-meanpath","fa fa-medium","fa fa-medkit","fa fa-meetup","fa fa-meh-o","fa fa-mercury","fa fa-microchip","fa fa-microphone","fa fa-microphone-slash","fa fa-minus","fa fa-minus-circle","fa fa-minus-square","fa fa-minus-square-o","fa fa-mixcloud","fa fa-mobile","fa fa-mobile-phone","fa fa-modx","fa fa-money","fa fa-moon-o","fa fa-mortar-board","fa fa-motorcycle","fa fa-mouse-pointer","fa fa-music","fa fa-navicon","fa fa-neuter","fa fa-newspaper-o","fa fa-object-group","fa fa-object-ungroup","fa fa-odnoklassniki","fa fa-odnoklassniki-square","fa fa-opencart","fa fa-openid","fa fa-opera","fa fa-optin-monster","fa fa-outdent","fa fa-pagelines","fa fa-paint-brush","fa fa-paper-plane","fa fa-paper-plane-o","fa fa-paperclip","fa fa-paragraph","fa fa-paste","fa fa-pause","fa fa-pause-circle","fa fa-pause-circle-o","fa fa-paw","fa fa-paypal","fa fa-pencil","fa fa-pencil-square","fa fa-pencil-square-o","fa fa-percent","fa fa-phone","fa fa-phone-square","fa fa-photo","fa fa-picture-o","fa fa-pie-chart","fa fa-pied-piper","fa fa-pied-piper-alt","fa fa-pied-piper-pp","fa fa-pinterest","fa fa-pinterest-p","fa fa-pinterest-square","fa fa-plane","fa fa-play","fa fa-play-circle","fa fa-play-circle-o","fa fa-plug","fa fa-plus","fa fa-plus-circle","fa fa-plus-square","fa fa-plus-square-o","fa fa-podcast","fa fa-power-off","fa fa-print","fa fa-product-hunt","fa fa-puzzle-piece","fa fa-qq","fa fa-qrcode","fa fa-question","fa fa-question-circle","fa fa-question-circle-o","fa fa-quora","fa fa-quote-left","fa fa-quote-right","fa fa-ra","fa fa-random","fa fa-ravelry","fa fa-rebel","fa fa-recycle","fa fa-reddit","fa fa-reddit-alien","fa fa-reddit-square","fa fa-refresh","fa fa-registered","fa fa-remove","fa fa-renren","fa fa-reorder","fa fa-repeat","fa fa-reply","fa fa-reply-all","fa fa-resistance","fa fa-retweet","fa fa-rmb","fa fa-road","fa fa-rocket","fa fa-rotate-left","fa fa-rotate-right","fa fa-rouble","fa fa-rss","fa fa-rss-square","fa fa-rub","fa fa-ruble","fa fa-rupee","fa fa-s15","fa fa-safari","fa fa-save","fa fa-scissors","fa fa-scribd","fa fa-search","fa fa-search-minus","fa fa-search-plus","fa fa-sellsy","fa fa-send","fa fa-send-o","fa fa-server","fa fa-share","fa fa-share-alt","fa fa-share-alt-square","fa fa-share-square","fa fa-share-square-o","fa fa-shekel","fa fa-sheqel","fa fa-shield","fa fa-ship","fa fa-shirtsinbulk","fa fa-shopping-bag","fa fa-shopping-basket","fa fa-shopping-cart","fa fa-shower","fa fa-sign-in","fa fa-sign-language","fa fa-sign-out","fa fa-signal","fa fa-signing","fa fa-simplybuilt","fa fa-sitemap","fa fa-skyatlas","fa fa-skype","fa fa-slack","fa fa-sliders","fa fa-slideshare","fa fa-smile-o","fa fa-snapchat","fa fa-snapchat-ghost","fa fa-snapchat-square","fa fa-snowflake-o","fa fa-soccer-ball-o","fa fa-sort","fa fa-sort-alpha-asc","fa fa-sort-alpha-desc","fa fa-sort-amount-asc","fa fa-sort-amount-desc","fa fa-sort-asc","fa fa-sort-desc","fa fa-sort-down","fa fa-sort-numeric-asc","fa fa-sort-numeric-desc","fa fa-sort-up","fa fa-soundcloud","fa fa-space-shuttle","fa fa-spinner","fa fa-spoon","fa fa-spotify","fa fa-square","fa fa-square-o","fa fa-stack-exchange","fa fa-stack-overflow","fa fa-star","fa fa-star-half","fa fa-star-half-empty","fa fa-star-half-full","fa fa-star-half-o","fa fa-star-o","fa fa-steam","fa fa-steam-square","fa fa-step-backward","fa fa-step-forward","fa fa-stethoscope","fa fa-sticky-note","fa fa-sticky-note-o","fa fa-stop","fa fa-stop-circle","fa fa-stop-circle-o","fa fa-street-view","fa fa-strikethrough","fa fa-stumbleupon","fa fa-stumbleupon-circle","fa fa-subscript","fa fa-subway","fa fa-suitcase","fa fa-sun-o","fa fa-superpowers","fa fa-superscript","fa fa-support","fa fa-table","fa fa-tablet","fa fa-tachometer","fa fa-tag","fa fa-tags","fa fa-tasks","fa fa-taxi","fa fa-telegram","fa fa-television","fa fa-tencent-weibo","fa fa-terminal","fa fa-text-height","fa fa-text-width","fa fa-th","fa fa-th-large","fa fa-th-list","fa fa-themeisle","fa fa-thermometer","fa fa-thermometer-0","fa fa-thermometer-1","fa fa-thermometer-2","fa fa-thermometer-3","fa fa-thermometer-4","fa fa-thermometer-empty","fa fa-thermometer-full","fa fa-thermometer-half","fa fa-thermometer-quarter","fa fa-thermometer-three-quarters","fa fa-thumb-tack","fa fa-thumbs-down","fa fa-thumbs-o-down","fa fa-thumbs-o-up","fa fa-thumbs-up","fa fa-ticket","fa fa-times","fa fa-times-circle","fa fa-times-circle-o","fa fa-times-rectangle","fa fa-times-rectangle-o","fa fa-tint","fa fa-toggle-down","fa fa-toggle-left","fa fa-toggle-off","fa fa-toggle-on","fa fa-toggle-right","fa fa-toggle-up","fa fa-trademark","fa fa-train","fa fa-transgender","fa fa-transgender-alt","fa fa-trash","fa fa-trash-o","fa fa-tree","fa fa-trello","fa fa-tripadvisor","fa fa-trophy","fa fa-truck","fa fa-try","fa fa-tty","fa fa-tumblr","fa fa-tumblr-square","fa fa-turkish-lira","fa fa-tv","fa fa-twitch","fa fa-twitter","fa fa-twitter-square","fa fa-umbrella","fa fa-underline","fa fa-undo","fa fa-universal-access","fa fa-university","fa fa-unlink","fa fa-unlock","fa fa-unlock-alt","fa fa-unsorted","fa fa-upload","fa fa-usb","fa fa-usd","fa fa-user","fa fa-user-circle","fa fa-user-circle-o","fa fa-user-md","fa fa-user-o","fa fa-user-plus","fa fa-user-secret","fa fa-user-times","fa fa-users","fa fa-vcard","fa fa-vcard-o","fa fa-venus","fa fa-venus-double","fa fa-venus-mars","fa fa-viacoin","fa fa-viadeo","fa fa-viadeo-square","fa fa-video-camera","fa fa-vimeo","fa fa-vimeo-square","fa fa-vine","fa fa-vk","fa fa-volume-control-phone","fa fa-volume-down","fa fa-volume-off","fa fa-volume-up","fa fa-warning","fa fa-wechat","fa fa-weibo","fa fa-weixin","fa fa-whatsapp","fa fa-wheelchair","fa fa-wheelchair-alt","fa fa-wifi","fa fa-wikipedia-w","fa fa-window-close","fa fa-window-close-o","fa fa-window-maximize","fa fa-window-minimize","fa fa-window-restore","fa fa-windows","fa fa-won","fa fa-wordpress","fa fa-wpbeginner","fa fa-wpexplorer","fa fa-wpforms","fa fa-wrench","fa fa-xing","fa fa-xing-square","fa fa-y-combinator","fa fa-y-combinator-square","fa fa-yahoo","fa fa-yc","fa fa-yc-square","fa fa-yelp","fa fa-yen","fa fa-yoast","fa fa-youtube","fa fa-youtube-play","fa fa-youtube-square",
    "fab fa-500px",
    "fab fa-accessible-icon",
    "fab fa-accusoft",
    "fas fa-address-book", "far fa-address-book",
    "fas fa-address-card", "far fa-address-card",
    "fas fa-adjust",
    "fab fa-adn",
    "fab fa-adversal",
    "fab fa-affiliatetheme",
    "fab fa-algolia",
    "fas fa-align-center",
    "fas fa-align-justify",
    "fas fa-align-left",
    "fas fa-align-right",
    "fab fa-amazon",
    "fas fa-ambulance",
    "fas fa-american-sign-language-interpreting",
    "fab fa-amilia",
    "fas fa-anchor",
    "fab fa-android",
    "fab fa-angellist",
    "fas fa-angle-double-down",
    "fas fa-angle-double-left",
    "fas fa-angle-double-right",
    "fas fa-angle-double-up",
    "fas fa-angle-down",
    "fas fa-angle-left",
    "fas fa-angle-right",
    "fas fa-angle-up",
    "fab fa-angrycreative",
    "fab fa-angular",
    "fab fa-app-store",
    "fab fa-app-store-ios",
    "fab fa-apper",
    "fab fa-apple",
    "fab fa-apple-pay",
    "fas fa-archive",
    "fas fa-arrow-alt-circle-down", "far fa-arrow-alt-circle-down",
    "fas fa-arrow-alt-circle-left", "far fa-arrow-alt-circle-left",
    "fas fa-arrow-alt-circle-right", "far fa-arrow-alt-circle-right",
    "fas fa-arrow-alt-circle-up", "far fa-arrow-alt-circle-up",
    "fas fa-arrow-circle-down",
    "fas fa-arrow-circle-left",
    "fas fa-arrow-circle-right",
    "fas fa-arrow-circle-up",
    "fas fa-arrow-down",
    "fas fa-arrow-left",
    "fas fa-arrow-right",
    "fas fa-arrow-up",
    "fas fa-arrows-alt",
    "fas fa-arrows-alt-h",
    "fas fa-arrows-alt-v",
    "fas fa-assistive-listening-systems",
    "fas fa-asterisk",
    "fab fa-asymmetrik",
    "fas fa-at",
    "fab fa-audible",
    "fas fa-audio-description",
    "fab fa-autoprefixer",
    "fab fa-avianex",
    "fab fa-aviato",
    "fab fa-aws",
    "fas fa-backward",
    "fas fa-balance-scale",
    "fas fa-ban",
    "fab fa-bandcamp",
    "fas fa-barcode",
    "fas fa-bars",
    "fas fa-bath",
    "fas fa-battery-empty",
    "fas fa-battery-full",
    "fas fa-battery-half",
    "fas fa-battery-quarter",
    "fas fa-battery-three-quarters",
    "fas fa-bed",
    "fas fa-beer",
    "fab fa-behance",
    "fab fa-behance-square",
    "fas fa-bell", "far fa-bell",
    "fas fa-bell-slash", "far fa-bell-slash",
    "fas fa-bicycle",
    "fab fa-bimobject",
    "fas fa-binoculars",
    "fas fa-birthday-cake",
    "fab fa-bitbucket",
    "fab fa-bitcoin",
    "fab fa-bity",
    "fab fa-black-tie",
    "fab fa-blackberry",
    "fas fa-blind",
    "fab fa-blogger",
    "fab fa-blogger-b",
    "fab fa-bluetooth",
    "fab fa-bluetooth-b",
    "fas fa-bold",
    "fas fa-bolt",
    "fas fa-bomb",
    "fas fa-book",
    "fas fa-bookmark", "far fa-bookmark",
    "fas fa-braille",
    "fas fa-briefcase",
    "fab fa-btc",
    "fas fa-bug",
    "fas fa-building", "far fa-building",
    "fas fa-bullhorn",
    "fas fa-bullseye",
    "fab fa-buromobelexperte",
    "fas fa-bus",
    "fab fa-buysellads",
    "fas fa-calculator",
    "fas fa-calendar", "far fa-calendar",
    "fas fa-calendar-alt", "far fa-calendar-alt",
    "fas fa-calendar-check", "far fa-calendar-check",
    "fas fa-calendar-minus", "far fa-calendar-minus",
    "fas fa-calendar-plus", "far fa-calendar-plus",
    "fas fa-calendar-times", "far fa-calendar-times",
    "fas fa-camera",
    "fas fa-camera-retro",
    "fas fa-car",
    "fas fa-caret-down",
    "fas fa-caret-left",
    "fas fa-caret-right",
    "fas fa-caret-square-down", "far fa-caret-square-down",
    "fas fa-caret-square-left", "far fa-caret-square-left",
    "fas fa-caret-square-right", "far fa-caret-square-right",
    "fas fa-caret-square-up", "far fa-caret-square-up",
    "fas fa-caret-up",
    "fas fa-cart-arrow-down",
    "fas fa-cart-plus",
    "fab fa-cc-amex",
    "fab fa-cc-apple-pay",
    "fab fa-cc-diners-club",
    "fab fa-cc-discover",
    "fab fa-cc-jcb",
    "fab fa-cc-mastercard",
    "fab fa-cc-paypal",
    "fab fa-cc-stripe",
    "fab fa-cc-visa",
    "fab fa-centercode",
    "fas fa-certificate",
    "fas fa-chart-area",
    "fas fa-chart-bar", "far fa-chart-bar",
    "fas fa-chart-line",
    "fas fa-chart-pie",
    "fas fa-check",
    "fas fa-check-circle", "far fa-check-circle",
    "fas fa-check-square", "far fa-check-square",
    "fas fa-chevron-circle-down",
    "fas fa-chevron-circle-left",
    "fas fa-chevron-circle-right",
    "fas fa-chevron-circle-up",
    "fas fa-chevron-down",
    "fas fa-chevron-left",
    "fas fa-chevron-right",
    "fas fa-chevron-up",
    "fas fa-child",
    "fab fa-chrome",
    "fas fa-circle", "far fa-circle",
    "fas fa-circle-notch",
    "fas fa-clipboard", "far fa-clipboard",
    "fas fa-clock", "far fa-clock",
    "fas fa-clone", "far fa-clone",
    "fas fa-closed-captioning", "far fa-closed-captioning",
    "fas fa-cloud",
    "fas fa-cloud-download-alt",
    "fas fa-cloud-upload-alt",
    "fab fa-cloudscale",
    "fab fa-cloudsmith",
    "fab fa-cloudversify",
    "fas fa-code",
    "fas fa-code-branch",
    "fab fa-codepen",
    "fab fa-codiepie",
    "fas fa-coffee",
    "fas fa-cog",
    "fas fa-cogs",
    "fas fa-columns",
    "fas fa-comment", "far fa-comment",
    "fas fa-comment-alt", "far fa-comment-alt",
    "fas fa-comments", "far fa-comments",
    "fas fa-compass", "far fa-compass",
    "fas fa-compress",
    "fab fa-connectdevelop",
    "fab fa-contao",
    "fas fa-copy", "far fa-copy",
    "fas fa-copyright", "far fa-copyright",
    "fab fa-cpanel",
    "fab fa-creative-commons",
    "fas fa-credit-card", "far fa-credit-card",
    "fas fa-crop",
    "fas fa-crosshairs",
    "fab fa-css3",
    "fab fa-css3-alt",
    "fas fa-cube",
    "fas fa-cubes",
    "fas fa-cut",
    "fab fa-cuttlefish",
    "fab fa-d-and-d",
    "fab fa-dashcube",
    "fas fa-database",
    "fas fa-deaf",
    "fab fa-delicious",
    "fab fa-deploydog",
    "fab fa-deskpro",
    "fas fa-desktop",
    "fab fa-deviantart",
    "fab fa-digg",
    "fab fa-digital-ocean",
    "fab fa-discord",
    "fab fa-discourse",
    "fab fa-dochub",
    "fab fa-docker",
    "fas fa-dollar-sign",
    "fas fa-dot-circle", "far fa-dot-circle",
    "fas fa-download",
    "fab fa-draft2digital",
    "fab fa-dribbble",
    "fab fa-dribbble-square",
    "fab fa-dropbox",
    "fab fa-drupal",
    "fab fa-dyalog",
    "fab fa-earlybirds",
    "fab fa-edge",
    "fas fa-edit", "far fa-edit",
    "fas fa-eject",
    "fas fa-ellipsis-h",
    "fas fa-ellipsis-v",
    "fab fa-ember",
    "fab fa-empire",
    "fas fa-envelope", "far fa-envelope",
    "fas fa-envelope-open", "far fa-envelope-open",
    "fas fa-envelope-square",
    "fab fa-envira",
    "fas fa-eraser",
    "fab fa-erlang",
    "fab fa-etsy",
    "fas fa-euro-sign",
    "fas fa-exchange-alt",
    "fas fa-exclamation",
    "fas fa-exclamation-circle",
    "fas fa-exclamation-triangle",
    "fas fa-expand",
    "fas fa-expand-arrows-alt",
    "fab fa-expeditedssl",
    "fas fa-external-link-alt",
    "fas fa-external-link-square-alt",
    "fas fa-eye",
    "fas fa-eye-dropper",
    "fas fa-eye-slash", "far fa-eye-slash",
    "fab fa-facebook",
    "fab fa-facebook-f",
    "fab fa-facebook-messenger",
    "fab fa-facebook-square",
    "fas fa-fast-backward",
    "fas fa-fast-forward",
    "fas fa-fax",
    "fas fa-female",
    "fas fa-fighter-jet",
    "fas fa-file", "far fa-file",
    "fas fa-file-alt", "far fa-file-alt",
    "fas fa-file-archive", "far fa-file-archive",
    "fas fa-file-audio", "far fa-file-audio",
    "fas fa-file-code", "far fa-file-code",
    "fas fa-file-excel", "far fa-file-excel",
    "fas fa-file-image", "far fa-file-image",
    "fas fa-file-pdf", "far fa-file-pdf",
    "fas fa-file-powerpoint", "far fa-file-powerpoint",
    "fas fa-file-video", "far fa-file-video",
    "fas fa-file-word", "far fa-file-word",
    "fas fa-film",
    "fas fa-filter",
    "fas fa-fire",
    "fas fa-fire-extinguisher",
    "fab fa-firefox",
    "fab fa-first-order",
    "fab fa-firstdraft",
    "fas fa-flag", "far fa-flag",
    "fas fa-flag-checkered",
    "fas fa-flask",
    "fab fa-flickr",
    "fab fa-fly",
    "fas fa-folder", "far fa-folder",
    "fas fa-folder-open", "far fa-folder-open",
    "fas fa-font",
    "fab fa-font-awesome",
    "fab fa-font-awesome-alt",
    "fab fa-font-awesome-flag",
    "fab fa-fonticons",
    "fab fa-fonticons-fi",
    "fab fa-fort-awesome",
    "fab fa-fort-awesome-alt",
    "fab fa-forumbee",
    "fas fa-forward",
    "fab fa-foursquare",
    "fab fa-free-code-camp",
    "fab fa-freebsd",
    "fas fa-frown", "far fa-frown",
    "fas fa-futbol", "far fa-futbol",
    "fas fa-gamepad",
    "fas fa-gavel",
    "fas fa-gem", "far fa-gem",
    "fas fa-genderless",
    "fab fa-get-pocket",
    "fab fa-gg",
    "fab fa-gg-circle",
    "fas fa-gift",
    "fab fa-git",
    "fab fa-git-square",
    "fab fa-github",
    "fab fa-github-alt",
    "fab fa-github-square",
    "fab fa-gitkraken",
    "fab fa-gitlab",
    "fab fa-gitter",
    "fas fa-glass-martini",
    "fab fa-glide",
    "fab fa-glide-g",
    "fas fa-globe",
    "fab fa-gofore",
    "fab fa-goodreads",
    "fab fa-goodreads-g",
    "fab fa-google",
    "fab fa-google-drive",
    "fab fa-google-play",
    "fab fa-google-plus",
    "fab fa-google-plus-g",
    "fab fa-google-plus-square",
    "fab fa-google-wallet",
    "fas fa-graduation-cap",
    "fab fa-gratipay",
    "fab fa-grav",
    "fab fa-gripfire",
    "fab fa-grunt",
    "fab fa-gulp",
    "fas fa-h-square",
    "fab fa-hacker-news",
    "fab fa-hacker-news-square",
    "fas fa-hand-lizard", "far fa-hand-lizard",
    "fas fa-hand-paper", "far fa-hand-paper",
    "fas fa-hand-peace", "far fa-hand-peace",
    "fas fa-hand-point-down", "far fa-hand-point-down",
    "fas fa-hand-point-left", "far fa-hand-point-left",
    "fas fa-hand-point-right", "far fa-hand-point-right",
    "fas fa-hand-point-up", "far fa-hand-point-up",
    "fas fa-hand-pointer", "far fa-hand-pointer",
    "fas fa-hand-rock", "far fa-hand-rock",
    "fas fa-hand-scissors", "far fa-hand-scissors",
    "fas fa-hand-spock", "far fa-hand-spock",
    "fas fa-handshake", "far fa-handshake",
    "fas fa-hashtag",
    "fas fa-hdd", "far fa-hdd",
    "fas fa-heading",
    "fas fa-headphones",
    "fas fa-heart", "far fa-heart",
    "fas fa-heartbeat",
    "fab fa-hire-a-helper",
    "fas fa-history",
    "fas fa-home",
    "fab fa-hooli",
    "fas fa-hospital", "far fa-hospital",
    "fab fa-hotjar",
    "fas fa-hourglass", "far fa-hourglass",
    "fas fa-hourglass-end",
    "fas fa-hourglass-half",
    "fas fa-hourglass-start",
    "fab fa-houzz",
    "fab fa-html5",
    "fab fa-hubspot",
    "fas fa-i-cursor",
    "fas fa-id-badge", "far fa-id-badge",
    "fas fa-id-card", "far fa-id-card",
    "fas fa-image", "far fa-image",
    "fas fa-images", "far fa-images",
    "fab fa-imdb",
    "fas fa-inbox",
    "fas fa-indent",
    "fas fa-industry",
    "fas fa-info",
    "fas fa-info-circle",
    "fab fa-instagram",
    "fab fa-internet-explorer",
    "fab fa-ioxhost",
    "fas fa-italic",
    "fab fa-itunes",
    "fab fa-itunes-note",
    "fab fa-jenkins",
    "fab fa-joget",
    "fab fa-joomla",
    "fab fa-js",
    "fab fa-js-square",
    "fab fa-jsfiddle",
    "fas fa-key",
    "fas fa-keyboard", "far fa-keyboard",
    "fab fa-keycdn",
    "fab fa-kickstarter",
    "fab fa-kickstarter-k",
    "fas fa-language",
    "fas fa-laptop",
    "fab fa-laravel",
    "fab fa-lastfm",
    "fab fa-lastfm-square",
    "fas fa-leaf",
    "fab fa-leanpub",
    "fas fa-lemon", "far fa-lemon",
    "fab fa-less",
    "fas fa-level-down-alt",
    "fas fa-level-up-alt",
    "fas fa-life-ring", "far fa-life-ring",
    "fas fa-lightbulb", "far fa-lightbulb",
    "fab fa-line",
    "fas fa-link",
    "fab fa-linkedin",
    "fab fa-linkedin-in",
    "fab fa-linode",
    "fab fa-linux",
    "fas fa-lira-sign",
    "fas fa-list",
    "fas fa-list-alt", "far fa-list-alt",
    "fas fa-list-ol",
    "fas fa-list-ul",
    "fas fa-location-arrow",
    "fas fa-lock",
    "fas fa-lock-open",
    "fas fa-long-arrow-alt-down",
    "fas fa-long-arrow-alt-left",
    "fas fa-long-arrow-alt-right",
    "fas fa-long-arrow-alt-up",
    "fas fa-low-vision",
    "fab fa-lyft",
    "fab fa-magento",
    "fas fa-magic",
    "fas fa-magnet",
    "fas fa-male",
    "fas fa-map", "far fa-map",
    "fas fa-map-marker",
    "fas fa-map-marker-alt",
    "fas fa-map-pin",
    "fas fa-map-signs",
    "fas fa-mars",
    "fas fa-mars-double",
    "fas fa-mars-stroke",
    "fas fa-mars-stroke-h",
    "fas fa-mars-stroke-v",
    "fab fa-maxcdn",
    "fab fa-medapps",
    "fab fa-medium",
    "fab fa-medium-m",
    "fas fa-medkit",
    "fab fa-medrt",
    "fab fa-meetup",
    "fas fa-meh", "far fa-meh",
    "fas fa-mercury",
    "fas fa-microchip",
    "fas fa-microphone",
    "fas fa-microphone-slash",
    "fab fa-microsoft",
    "fas fa-minus",
    "fas fa-minus-circle",
    "fas fa-minus-square", "far fa-minus-square",
    "fab fa-mix",
    "fab fa-mixcloud",
    "fab fa-mizuni",
    "fas fa-mobile",
    "fas fa-mobile-alt",
    "fab fa-modx",
    "fab fa-monero",
    "fas fa-money-bill-alt", "far fa-money-bill-alt",
    "fas fa-moon", "far fa-moon",
    "fas fa-motorcycle",
    "fas fa-mouse-pointer",
    "fas fa-music",
    "fab fa-napster",
    "fas fa-neuter",
    "fas fa-newspaper", "far fa-newspaper",
    "fab fa-nintendo-switch",
    "fab fa-node",
    "fab fa-node-js",
    "fab fa-npm",
    "fab fa-ns8",
    "fab fa-nutritionix",
    "fas fa-object-group", "far fa-object-group",
    "fas fa-object-ungroup", "far fa-object-ungroup",
    "fab fa-odnoklassniki",
    "fab fa-odnoklassniki-square",
    "fab fa-opencart",
    "fab fa-openid",
    "fab fa-opera",
    "fab fa-optin-monster",
    "fab fa-osi",
    "fas fa-outdent",
    "fab fa-page4",
    "fab fa-pagelines",
    "fas fa-paint-brush",
    "fab fa-palfed",
    "fas fa-paper-plane", "far fa-paper-plane",
    "fas fa-paperclip",
    "fas fa-paragraph",
    "fas fa-paste",
    "fab fa-patreon",
    "fas fa-pause",
    "fas fa-pause-circle", "far fa-pause-circle",
    "fas fa-paw",
    "fab fa-paypal",
    "fas fa-pen-square",
    "fas fa-pencil-alt",
    "fas fa-percent",
    "fab fa-periscope",
    "fab fa-phabricator",
    "fab fa-phoenix-framework",
    "fas fa-phone",
    "fas fa-phone-square",
    "fas fa-phone-volume",
    "fab fa-pied-piper",
    "fab fa-pied-piper-alt",
    "fab fa-pied-piper-pp",
    "fab fa-pinterest",
    "fab fa-pinterest-p",
    "fab fa-pinterest-square",
    "fas fa-plane",
    "fas fa-play",
    "fas fa-play-circle", "far fa-play-circle",
    "fab fa-playstation",
    "fas fa-plug",
    "fas fa-plus",
    "fas fa-plus-circle",
    "fas fa-plus-square", "far fa-plus-square",
    "fas fa-podcast",
    "fas fa-pound-sign",
    "fas fa-power-off",
    "fas fa-print",
    "fab fa-product-hunt",
    "fab fa-pushed",
    "fas fa-puzzle-piece",
    "fab fa-python",
    "fab fa-qq",
    "fas fa-qrcode",
    "fas fa-question",
    "fas fa-question-circle", "far fa-question-circle",
    "fab fa-quora",
    "fas fa-quote-left",
    "fas fa-quote-right",
    "fas fa-random",
    "fab fa-ravelry",
    "fab fa-react",
    "fab fa-rebel",
    "fas fa-recycle",
    "fab fa-red-river",
    "fab fa-reddit",
    "fab fa-reddit-alien",
    "fab fa-reddit-square",
    "fas fa-redo",
    "fas fa-redo-alt",
    "fas fa-registered", "far fa-registered",
    "fab fa-rendact",
    "fab fa-renren",
    "fas fa-reply",
    "fas fa-reply-all",
    "fab fa-replyd",
    "fab fa-resolving",
    "fas fa-retweet",
    "fas fa-road",
    "fas fa-rocket",
    "fab fa-rocketchat",
    "fab fa-rockrms",
    "fas fa-rss",
    "fas fa-rss-square",
    "fas fa-ruble-sign",
    "fas fa-rupee-sign",
    "fab fa-safari",
    "fab fa-sass",
    "fas fa-save", "far fa-save",
    "fab fa-schlix",
    "fab fa-scribd",
    "fas fa-search",
    "fas fa-search-minus",
    "fas fa-search-plus",
    "fab fa-searchengin",
    "fab fa-sellcast",
    "fab fa-sellsy",
    "fas fa-server",
    "fab fa-servicestack",
    "fas fa-share",
    "fas fa-share-alt",
    "fas fa-share-alt-square",
    "fas fa-share-square", "far fa-share-square",
    "fas fa-shekel-sign",
    "fas fa-shield-alt",
    "fas fa-ship",
    "fab fa-shirtsinbulk",
    "fas fa-shopping-bag",
    "fas fa-shopping-basket",
    "fas fa-shopping-cart",
    "fas fa-shower",
    "fas fa-sign-in-alt",
    "fas fa-sign-language",
    "fas fa-sign-out-alt",
    "fas fa-signal",
    "fab fa-simplybuilt",
    "fab fa-sistrix",
    "fas fa-sitemap",
    "fab fa-skyatlas",
    "fab fa-skype",
    "fab fa-slack",
    "fab fa-slack-hash",
    "fas fa-sliders-h",
    "fab fa-slideshare",
    "fas fa-smile", "far fa-smile",
    "fab fa-snapchat",
    "fab fa-snapchat-ghost",
    "fab fa-snapchat-square",
    "fas fa-snowflake", "far fa-snowflake",
    "fas fa-sort",
    "fas fa-sort-alpha-down",
    "fas fa-sort-alpha-up",
    "fas fa-sort-amount-down",
    "fas fa-sort-amount-up",
    "fas fa-sort-down",
    "fas fa-sort-numeric-down",
    "fas fa-sort-numeric-up",
    "fas fa-sort-up",
    "fab fa-soundcloud",
    "fas fa-space-shuttle",
    "fab fa-speakap",
    "fas fa-spinner",
    "fab fa-spotify",
    "fas fa-square", "far fa-square",
    "fab fa-stack-exchange",
    "fab fa-stack-overflow",
    "fas fa-star", "far fa-star",
    "fas fa-star-half", "far fa-star-half",
    "fab fa-staylinked",
    "fab fa-steam",
    "fab fa-steam-square",
    "fab fa-steam-symbol",
    "fas fa-step-backward",
    "fas fa-step-forward",
    "fas fa-stethoscope",
    "fab fa-sticker-mule",
    "fas fa-sticky-note", "far fa-sticky-note",
    "fas fa-stop",
    "fas fa-stop-circle", "far fa-stop-circle",
    "fab fa-strava",
    "fas fa-street-view",
    "fas fa-strikethrough",
    "fab fa-stripe",
    "fab fa-stripe-s",
    "fab fa-studiovinari",
    "fab fa-stumbleupon",
    "fab fa-stumbleupon-circle",
    "fas fa-subscript",
    "fas fa-subway",
    "fas fa-suitcase",
    "fas fa-sun", "far fa-sun",
    "fab fa-superpowers",
    "fas fa-superscript",
    "fab fa-supple",
    "fas fa-sync",
    "fas fa-sync-alt",
    "fas fa-table",
    "fas fa-tablet",
    "fas fa-tablet-alt",
    "fas fa-tachometer-alt",
    "fas fa-tag",
    "fas fa-tags",
    "fas fa-tasks",
    "fas fa-taxi",
    "fab fa-telegram",
    "fab fa-telegram-plane",
    "fab fa-tencent-weibo",
    "fas fa-terminal",
    "fas fa-text-height",
    "fas fa-text-width",
    "fas fa-th",
    "fas fa-th-large",
    "fas fa-th-list",
    "fab fa-themeisle",
    "fas fa-thermometer-empty",
    "fas fa-thermometer-full",
    "fas fa-thermometer-half",
    "fas fa-thermometer-quarter",
    "fas fa-thermometer-three-quarters",
    "fas fa-thumbs-down", "far fa-thumbs-down",
    "fas fa-thumbs-up", "far fa-thumbs-up",
    "fas fa-thumbtack",
    "fas fa-ticket-alt",
    "fas fa-times",
    "fas fa-times-circle", "far fa-times-circle",
    "fas fa-tint",
    "fas fa-toggle-off",
    "fas fa-toggle-on",
    "fas fa-trademark",
    "fas fa-train",
    "fas fa-transgender",
    "fas fa-transgender-alt",
    "fas fa-trash",
    "fas fa-trash-alt", "far fa-trash-alt",
    "fas fa-tree",
    "fab fa-trello",
    "fab fa-tripadvisor",
    "fas fa-trophy",
    "fas fa-truck",
    "fas fa-tty",
    "fab fa-tumblr",
    "fab fa-tumblr-square",
    "fas fa-tv",
    "fab fa-twitch",
    "fab fa-twitter",
    "fab fa-twitter-square",
    "fab fa-typo3",
    "fab fa-uber",
    "fab fa-uikit",
    "fas fa-umbrella",
    "fas fa-underline",
    "fas fa-undo",
    "fas fa-undo-alt",
    "fab fa-uniregistry",
    "fas fa-universal-access",
    "fas fa-university",
    "fas fa-unlink",
    "fas fa-unlock",
    "fas fa-unlock-alt",
    "fab fa-untappd",
    "fas fa-upload",
    "fab fa-usb",
    "fas fa-user", "far fa-user",
    "fas fa-user-circle", "far fa-user-circle",
    "fas fa-user-md",
    "fas fa-user-plus",
    "fas fa-user-secret",
    "fas fa-user-times",
    "fas fa-users",
    "fab fa-ussunnah",
    "fas fa-utensil-spoon",
    "fas fa-utensils",
    "fab fa-vaadin",
    "fas fa-venus",
    "fas fa-venus-double",
    "fas fa-venus-mars",
    "fab fa-viacoin",
    "fab fa-viadeo",
    "fab fa-viadeo-square",
    "fab fa-viber",
    "fas fa-video",
    "fab fa-vimeo",
    "fab fa-vimeo-square",
    "fab fa-vimeo-v",
    "fab fa-vine",
    "fab fa-vk",
    "fab fa-vnv",
    "fas fa-volume-down",
    "fas fa-volume-off",
    "fas fa-volume-up",
    "fab fa-vuejs",
    "fab fa-weibo",
    "fab fa-weixin",
    "fab fa-whatsapp",
    "fab fa-whatsapp-square",
    "fas fa-wheelchair",
    "fab fa-whmcs",
    "fas fa-wifi",
    "fab fa-wikipedia-w",
    "fas fa-window-close", "far fa-window-close",
    "fas fa-window-maximize", "far fa-window-maximize",
    "fas fa-window-minimize",
    "fas fa-window-restore", "far fa-window-restore",
    "fab fa-windows",
    "fas fa-won-sign",
    "fab fa-wordpress",
    "fab fa-wordpress-simple",
    "fab fa-wpbeginner",
    "fab fa-wpexplorer",
    "fab fa-wpforms",
    "fas fa-wrench",
    "fab fa-xbox",
    "fab fa-xing",
    "fab fa-xing-square",
    "fab fa-y-combinator",
    "fab fa-yahoo",
    "fab fa-yandex",
    "fab fa-yandex-international",
    "fab fa-yelp",
    "fas fa-yen-sign",
    "fab fa-yoast",
    "fab fa-youtube"];
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $expertise = Expertise::orderBy('id', 'desc')->paginate(10);
        return view('admin/expertise/view',compact('expertise'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $fa_array = $this->fa_array;
        return view('admin/expertise/add',compact('fa_array'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(),[
            'title'=>'required', 
            'status'=>'required',  
        ]);

        if($validator->passes())
        {
            $expertise = new Expertise;
            $expertise->unique_id = Str::random(32);
            $expertise->title = $request->title;
            $expertise->slug = Str::slug($request->title,'-');
            $expertise->icon = $request->icon;
            $expertise->status = $request->status;
            $expertise->save();
            return redirect('/admin/expertise')->with('msg','Create  Expertise Successfully');
        }  
        else
        {
            return back()->withErrors($validator)->withInput();
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id,$slug)
    {
        $expertise = Expertise::where('unique_id',$id)->where('slug',$slug)->get()->toArray();
        $fa_array = $this->fa_array;
        // echo "<pre>";
        // print_r($interests);
        // exit();
        return view('admin/expertise/update')->with(compact('expertise','fa_array'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        
        $validator = Validator::make($request->all(),[
            'title'=>'required', 
            'status'=>'required',  
        ]);

        if($validator->passes())
        {
            $expertise = Expertise::find($id);
            $expertise->title = $request->title;
            $expertise->slug = Str::slug($request->title,'-');
            $expertise->icon = $request->icon;
            $expertise->status = $request->status;
            $expertise->save();
            return redirect('/admin/expertise')->with('msg','Update  Expertise Successfully');
        }  
        else
        {
            return back()->withErrors($validator)->withInput();
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        Expertise::find($id)->delete();
        return redirect('/admin/expertise')->with('msg','Expertise delete Successfully.');
    }
}

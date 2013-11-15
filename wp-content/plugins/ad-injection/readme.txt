=== Ad Injection ===
Contributors: reviewmylife
Donate link: http://www.reviewmylife.co.uk/blog/2010/12/06/ad-injection-plugin-wordpress/
Tags: ad injection, adsense, advert injection, advert, ad, injection, advertising, affiliate, inject, injection, insert, widget, widgets, sidebar, monetize, monetise, banner, Amazon, ClickBank, TradeDoubler, Google, adBrite, post, WordPress, automatically, plugin, Adsense Injection, free, blog, ad rotation, A:B testing, split testing, WP Super Cache, W3 Total Cache, WP Cache
Requires at least: 2.8.6
Tested up to: 3.4.1
Stable tag: 1.2.0.16

Injects any adverts (e.g. AdSense) into the WordPress posts or widget area. Restrict who sees ads by post length/age/referrer or IP. Cache compatible.

== Description ==

Ad Injection from [reviewmylife](http://www.reviewmylife.co.uk/ "reviewmylife") injects any kind of advert or other content (e.g. Google AdSense, Amazon Associates, ClickBank, TradeDoubler, etc) into the existing content of your WordPress posts and pages. You can control the number of adverts based on the post length, and it can restrict who sees adverts by post age, visitor referrer and IP address. Adverts can be configured in the post (random, top, and bottom positions) or in any widget/sidebar area. There's support for A:B split testing / ad rotation. And the dynamic restrictions (by IP and referrer) work with WP Super Cache, W3 Total Cache and WP Cache.

**New Features 1.2.x.x**

* Set the position of the top and bottom advert by paragraph or character.
* Position the random ads to start or stop in the middle of the post.
* Stop the random ads 2/3 of the way down a post, or at a paragraph/character position from the beginning/end of the post.
* New options to exlude ads from blockquote and pre sections. And custom ad exlude tags.
* Fade unused Home/Archive options instead of making them dissapear.
* Add page age settings to status.
* Improve debug messages.

**New Features 1.1.x.x**

* Template ads - you can now include ads anywhere in your theme template with some simple tags. You can load the top/random/bottom/footer ads, or you can load an ad from a text file on disk. Template ads inherit the same dynamic and global restrictions as for ads configured via the UI.
* First ad can now be started at or after a paragraph or character position.
* Override ad positions on individual posts using &lt;!--topad--&gt; &lt;!--randomad--&gt; &lt;!--bottomad--&gt;
* Separate old post restriction for widget ads in case you want a different rule for the widget ads.

**New Features 0.9.7.x**

* Archive and home page ads now fully supported with the same controls as ads for single posts/pages.
* Category, tag and author restrictions for top, random and bottom ads.
* Footer ads.
* Restrict ads by page/post id

**New Features 0.9.6.x**

* Ad rotation / A:B split testing support for random, top, bottom and widget/sidebar adverts.
* Alternate content which can be defined for users who are dynamically blocked (by IP or referrer) from seeing adverts.
* Choose which paragraph to start the random ads via the UI.
* Dynamic features will work with W3 Total Cache and WP Cache as well as the previously suppoted WP Super Cache.
* Widgets can be conditionally included on pages by category, tag, and author.

= Automatic advert injection =

The ads can be injected into existing posts without requiring any modification of the post. The injection can be done randomly between paragraphs, and there is an option to always inject the first advert at a specified paragraph (e.g. the first or second). Randomly positioning the adverts helps to reduce 'ad blindness'. Additional adverts can be defined for the top and bottom of the content, or the footer of the page. Widget adverts can be defined as well.

= Widget support =

Widgets can be added to your sidebars, or other widget areas on any pages. The same ad display restrictions that you setup for your other ads will also apply to the widgets.

= Ad rotation / split testing =

You can define multiple adverts for the same ad space which are rotated according to the ratios you define. Works with random, top, bottom and sidget/sidebar ads.

= Ad quantity by post length =

The number of adverts can be set based on the length of the post. It is a good idea for longer posts to have more adverts than shorter posts for example. Adverts can also be turned off for very short posts.

= Search engines only mode (restrict by referrer) =

You can specify that ads should only be shown to search engine visitors, or to visitors from defined referring websites - e.g. Facebook, Wikipedia, Twitter, etc. This will give your regular visitors (who are unlikely to click your ads) a better experience of your site. You can define which search engines or referring sites see your adverts. A visitor who enters the site by one of these referrers will see ads for the next hour.

= Block by referrer =

Block ads to people coming from certain referring URLs. e.g. you may wish to treat people who arrive at your site after searching for your name as direct visitors and disable the ads for them.

= Ads on old posts only =

Adverts can be restricted to posts that are more than a defined numbers of days old. This prevents your regular visitors from having to see your ads.

= Category, tag, author, post ID, and post type filters =

You can configure the adverts to only appear on specific categories, tags, authors, post IDs, or post types (or exclude them using these conditions).

= Template ads =

Ads can be included anywhere in your theme template with some simple tags. You can load the top/random/bottom/footer ads, or you can load an ad from a text file on disk. Template ads inherit the same dynamic and global restrictions as for ads configured via the UI.

= Block ads from IP addresses =

IP addresses of people who shouldn't see your ads can be defined. These could be the IP addresses of your friends, family, or even yourself.

= Override ad positioning on individual posts =

If you need to override the top, random, or bottom ad positions on a specific post you can use these in-content tags to manually set the ad positions: &lt;!--topad--&gt; &lt;!--randomad--&gt; &lt;!--bottomad--&gt; &lt;!--adstart--&gt; &lt;!--adend--&gt; &lt;!--noads--&gt;

You can manually exclude ads from specific sections of the post using the &lt;!--adinj_exclude_start--&gt;&lt;!--adinj_exclude_end--&gt; tags.

= Exclude ads from block tags =

Ads can be excluded from &lt;blockquote&gt;&lt;/blockquote&gt; and &lt;pre&gt;&lt;/pre&gt; tags.

= Alternate content =

This is content that is displayed when ads are blocked for the user. You could use this alternate content to show other content, some kind of layout filler, or even a different type of ad. I've added support for rotation of alternate content as well.

= Not tied to any ad provider =

The advert code can be copied and pasted directly from your ad provider (Google AdSense, adBrite, ClickBank, etc) which will help you to comply with any terms of service (TOS) that state their ad code may not be modified. 

= Inject anything! =

Although this plugin is usually used for injecting adverts it can in fact be used to inject anything. Here are some alternative uses for Ad Injection:

* Inject an email opt-in form at the bottom of each post.
* Insert a common header or footer block (e.g. copyright, disclaimers, website information).
* Add tracking scripts (e.g. Google Analytics) into your site.
* Use it to rotate random images or photos in your pages.
* Put some time limited temporary content at the top or bottom of each post (e.g. sales offer, or web site announcement).
* Inserting social networking buttons (e.g. Facebook, Twitter, Google +1) at the top or bottom of your posts.

= Flexible ad alignment =

Easy positioning options are provided for left, right, center, float left, and float right (or a random variant of these). Extra spacing can be set above and below the ad using the CSS margin and padding boxes. Or if that isn't flexible enough, you can write your own positioning code using HTML and CSS. And you can select which paragraph random ads should start from.

= Works with WP Super Cache, W3 Total Cache and WP Cache =

The dynamic features that require code to be executed for each page view (i.e. ad rotation, search engine visitors only, and ad blocking based on IP address) work with WP Super Cache, W3 Total Cache and WP Cache.

This plugin will automatically use the dynamic mfunc tag to ensure that the dynamic ad features still work when caching is on. 

If you use WP Super Cache in mod_rewrite mode displaying the adverts (even with the dynamic restrictions) whilst caching requires no MySQL database access. For W3 Total Cache and WP Cache Ad Injection will not require any extra MySQL database access for cached pages other than what these plugin already use.

= Inject PHP and JavaScript =

As the plugin will inject whatever content you like into the page you can write your own ad rotation or a/b split testing code for the ads you inject. PHP code can be automatically executed, even when using WP Super Cache.

= Hide UI panels that you don't need =

If there are any panels on the admin screen that you don't need, you can click on the show/hide button to hide them until you need them.

For more information visit [reviewmylife](http://www.reviewmylife.co.uk/blog/2010/12/06/ad-injection-plugin-wordpress/ "reviewmylife blog").

= Actively being developed =

As of 2011 this plugin is being actively developed and maintained. New features are planned for later on in 2011. If you have ideas for new features do let me know - I can't promise to do them any time soon - but if they are good and practical I can add them to my list.

== Installation ==

This section describes how to install the plugin and get it working.

1. Upload the ad-injection folder to the '/wp-content/plugins/' directory (or just use the WordPress plugin installer to do it for you). The plugin must be in a folder called 'ad-injection'. So the main plugin file will be at /wp-content/plugins/ad-injection/ad-injection.php
2. Activate the plugin through the 'Plugins' menu in WordPress.
3. Configure your ads. Carefully go through all the sections to setup your ad placements. 
4. Make sure you select the option to say which ad injection mode to use. Dynamic features (ad rotation, and referrer/IP ad filtering) will only work with either 1) WP Super Cache/W3 Total Cache/WP Cache or 2) no caching plugin. 
5. Tick the box right at the top to enable your ads.
6. If you are using a caching plugin you may need to clear the cache to see your ads immediately.
7. If something doesn't work as expected turn on debug mode and look for the debug messages in the HTML source.

**Recommended cache plugin settings**

* WP Super Cache - 0.9.9.8+ using mod_rewrite mode.
* W3 Total Cache - Page Cache: 'Disk (basic)' mode.
* WP Cache - Just turn the caching on.

Note: If you use a version of WP Super Cache prior to 0.9.9.8  it must be configured in 'Legacy' mode for the dynamic features to work. If you use WP Super Cache 0.9.9.8 or above you can use any of the caching modes (mod_rewrite and PHP are faster than legacy).

= How to uninstall =

You can uninstall by deactivating the plugin and deleting from the WordPress plugins control panel.

Uninstalling will delete all files and settings created by Ad Injection. It will also delete any template ads that you have put in the ad-injection-data folder.

If you have been using mfunc mode with a caching plugin then you *must* also clear the cache afterwards, otherwise you'll get errors saying the Ad Injection includes can't be found. 

== Frequently Asked Questions ==

= Why was this plugin created? =

I used to use the excellent Adsense Injection by Dax Herrera, but found I needed more features and flexibility. His plugin inspired this one.

= How is this plugin different to Adsense Injection by Dax Herrera? =

One a basic level it can do the same job as Dax's Adsense Injection. If you want it can just inject AdSense between paragraphs like his plugin does. I used to use his plugin, but found that I wanted a lot more features. Here are some of the extra features.

* Inject any type of advert from any ad provider.
* Restrict ad display by referrer (e.g. can restrict display to search engine visitors).
* Can prevent specific IP addresses from seeing adverts.
* Can define randomly positioned adverts, and adverts at the top, bottom and footer of the posts.
* Add adverts to the widget area.
* Adverts can be positioned anywhere in your theme template.
* Ad rotation / split testing.
* Restrict adverts by category, tag, author, post ID.
* Override ad positions for individual posts if necessary.
* Vary number of adverts based on post length.
* You can inject raw JavaScript and PHP.
* Include ads anywhere in the theme template if you edit your theme's PHP.
* The dynamic features (ad rotation, restricting ads by referrer and IP) work with WP Super Cache, W3 Total Cache and WP Cache.
* Define alternate content for users who are dynamically restricted from seeing ads.
* Compatible with the <!--noadsense--> <!--adsensestart--> in-page tags from Adsense Injection to make migration easy.
* Compatible with in-page tags from Whydowork Adsense and Quick Adsense.
* Extra positioning options - for example you can force the first advert to be right after the first paragraph so that it will be 'above the fold'.

Thanks to Dax by the way for providing the inspiration for this plugin!

= Does this plugin 'take' a percentage of my ad earnings? =

No! Absolutely not. Some ad plugins replace your publisher ID with their own for a certain percentage of adverts. Ad Injection does NOT do this. All your earnings are your own. Ad Injection makes no modifications to your ad code. What you paste into the ad boxes is what is injected into your pages.

= Is using this plugin allowed for Google AdSense? =

As far as I can tell using this plugin should be legal for AdSense **as long as you** make sure the ad quantities/placements comply with their TOS. However it is up to you to make sure that your website complies.

Ad Injection is designed as a generic plugin for injecting all types of adverts. It will not specifically check that the defined ad quantities or positions are in compliance of the AdSense TOS for you. For example Ad Injection will allow you to inject more ads than Google allows if you configure it to do so. 

Note that AdSense has limits as to the number of adverts you can include on a page. If you try to include more then you will end up with 'blank boxes' on your page.

Be careful if you use the float left/right positioning options. These options could cause your AdSense adverts to appear under other elements of your page if you have also set a float value for them (e.g. floating images, and adverts together could be problematic). However the new 'clear' option should allow you to make sure this doesn't happen. 

The best advice for any advert plugin is to manually check that you are happy with the advert quantities and positioning it produces, to ensure that you comply with the TOS for your ad program.

You use this plugin at your own risk.

= Do you have any testing recommendations? =

For testing your ad settings I'd recommend that you first disable any caching plugin, and then set Ad Injection to test mode so that 1) you can instantly see any changes you make to the settings and 2) so that only you will see the adverts.

If you are unsure as to why ads are appearing (or aren't) enable debug mode from the UI and look for the 'ADINJ DEBUG' tags in the HTML source of your webpage. 

When you are happy with the ad quantities / positions you can disable debug mode, re-enable your caching plugin, and set the Ad Injection mode to 'On'.

If you are testing the search engine referrer settings be aware that Ad Injection sets a one hour cookie when you visit via a site with a matching referrer. This means that after you have visited the site via the matching referrer the adverts will keep showing for the next hour. Clear your cookies to reset the behaviour. The Firefox 'Cookie Monster' plugin is very useful if you want to check the status of the cookie. Look for the 'adinj' cookie. Instead of clearing all your cookies you can just delete this one.

Using a second browser in 'privacy mode' is also a good way of testing your site with a clean slate. A browser like Google Chrome will allow you to test your site with no cookies definied if you start a new private browsing session.

= Do I need to have WP Super Cache (or anther caching plugin) installed? =

No! All the features of this plugin will work with no caching plugin installed. But if you do have WP Super Cache the dynamic features (ad rotation and enabling ads based on IP address and referrer) will still work. And your blog will (probably) run a lot faster than with no caching plugin. Usually caching plugin prevent dynamic plugin features from working - but I've spent a lot of time creating a framework to allow this plugin's dynamic features to work with some of the most common caching plugins. Just make sure you choose the mfunc dynamic insertion mode from the Ad Injection settings screen.

= Will the dynamic features work with other caching plugins? =

The dynamic features will work with any caching program that supports the mfunc tag. At the moment that is WP Super Cache, W3 Total Cache, and WP Cache.

= Which caching plugin is best? =

Both WP Super Cache and W3 Total Cache are likely to be faster than WP Cache.

If you aren't using the dynamic features then the only way to find out which is best between WP Super Cache and W3 Total Cache is to measure the performance yourself, as the speed depends on many factors that will be unique to your web server and web site.

If you are using dynamic features with mfunc mode then WP Super Cache (in mod_rewrite mode) and W3 Total Cache (in Page Cache: Disk (basic) mode) are likely to offer similar performance as they both return the dynamic files via PHP. 

Note that W3 Total Cache will not cache pages with mfunc tags if you use the Page Cache: Disk (enhanced) mode.

The speed of your website does depend on more factors than just page serve time so other features that the caching plugins offer (such as CDN and minification support) may swing the advantage either way.

WP Hyper Cache does not support mfunc tags so only use it if you don't want to use any of the dynamic features. If using WP Hyper Cache set the Ad Injection mode to 'direct'.

For reference: dynamic features are ad rotation, and blocking ad views by IP and referrer.

= What if I am using an incompatible caching plugin? =

Don't worry - everything will still work except for:

1. Filtering ads based on the IP address of the visitor.
2. Filtering the ads based on the HTTP referrer of the visitor.

If you aren't interested in these features then it doesn't matter! Just make sure you tick the box to say that you to use 'Direct static ad insertion' on the Ad Injection settings screen.

= Can I just have adverts on the home page? =

i.e. adverts on the home page, but not on single posts or pages.

Yes you can do this, there are two ways.

1. In the 'Single posts and pages' setting set the number of injected ads to 0. Then in the 'Home page' settings set the number of ads to whatever you want. 
2. Alternatively use the global exclude options at the top to exclude ads from all page types except the home page.

= Why aren't adverts appearing on my front / home / archives page? =

Ads will only appear if your front, home or archives page if you show the full post - not if you show excerpts*. 

*However if your theme leaves the HTML tags intact then you may in fact see the top ad in your excerpt. Whether you do or not depends on how your theme deals with excerpts.

= How do I stop adverts from appearing on my contacts form page? =

To stop ads appearing on the contact page (or any other post/page) you have many of options. Here are 4 to choose from:

1. Add a disable_adverts custom field to the post/page containing the contact form and set the value to 1 (the number one as a single digit). If you can't see the custom fields click on 'Screen Options' at the top right on the post/page editing screen, and tick 'Custom Fields.
2. Add the post/page id to the post/page id ad filtering box.
3. Add (copy and paste) &lt;!--NoAds--&gt; into the content of the post/page with the contact form. Just edit the contact page and paste this in - it will be invisible to the reader.
4. Add a tag to the page to mean that it shouldn't have adverts, and then add that tag to the tag filtering condition in the global settings area of the plugin configuration page.

= How can I put ads on category (or other archive pages)? =

The top, random, bottom and footer ads can be placed into the category pages. Category pages are a type of archive.

On the main settings page for Ad Injection just enter the number of adverts you want on these page types using the Archives column in the 'Ad placement settings' section.

These ads will only appear on archives/category pages if you are showing the full post contents on these pages. They won't work if you are showing excerpts. These restrictions don't apply to widget ads.

= My adverts are overlapping with other page elements (e.g. images) =

You can try defining the 'clear' display setting so that multiple floated parts of your page do not overlap.

If you always have a floated image at the top of the page you can set which paragraph the first random advert will start from. If you needed finer control over where the random adverts appear you can use the <!--adstart--> and <!--adend--> tags in the page.

= I have set the ads to float but the text/headings aren't flowing around them =

Check your style sheet to see if either the text or headings have the 'clear' attribute set. This may be preventing your text / headings from flowing around the advert.

= After adding the ads my sidebar has dropped down the screen. Why? =

This is because you have inserted adverts that are too wide for your site's layout. The browser can no longer fit all the parts of your layout side-by-side. Try using ads that are less wide.

= How do I add left/right margins to the ads =

There aren't any options to do this in the UI, but you can just put the layout tags into the ad box around your advert. e.g.

`<div style="margin-left:50px;margin-right:50px;">
Your advert
</div>`

= I have configured four Google AdSense ad units but only three are showing. Why? =

Google's AdSense TOS only allow allow three ad units, and three link units per page. If you have for example tried to insert four ad units on your page then Google will (probably) disable the forth one automatically. Read Google's AdSense [program policies](https://www.google.com/adsense/support/bin/answer.py?hl=en&answer=48182 "AdSense program policies") for more info.

You may  find that your right sidebar ad doesn't show if you have too many ads. Google renders the ads in the order that they are in the HTML, and your right sidebar will be at the bottom of HTML. If you need your right sidebar AdSense ad you will have to limit the number of ads on the rest of the page from the 'Ad placement settings'.

= How can I rotate more than 10 adverts? =

I am planning on making a change to allow an arbitrary number of adverts - this will probably be in 2012. Until then you have these 3 options:

1. Use PHP / JavaScript in the ad boxes to handle the rotation of the extra ads.
2. Use an ad service such as OpenX or Google Ad Manager in conjunction with Ad Injection. Ad Injection can handle the ad placement, and the ad service can manage your ad pool.
3. Hack Ad Injection to increase the limit (but be aware that if you upgrade your changes will be overwritten).

I'd recommend 1 or 2.

= How can I show different ads for different categories? =

If you want to show different ads for different categories using widgets you can set up filters for the different ads from the widget UI. If you want to show different top, random, or bottom adverts on different categories you can use some very simple PHP in the ad box (this will also work for the widgets as well if you don't like the UI method).

Example 1 - one category specific ad and a general ad.

`<?php if (in_category('japan')) { ?>
Japan advert
<?php } else { ?>
General advert
<?php } ?>`

Example 2 - Two different ads in two different categories. Pages which aren't in either category have no ads.

`<?php if (in_category('cheese')) { ?>
Cheese advert
<?php } else if (in_category('milk')) { ?>
Milk advert
<?php } ?>`

See http://codex.wordpress.org/Function_Reference/in_category for more information on in_category.

You can do the same for tags using has_tag. See http://codex.wordpress.org/Function_Reference/has_tag for info.

Note - this will only work in direct insertion mode.

= I want a different advert for each category. How can I do this? =

1. In your plugins directory create a sub-directory called 'ad-injection-ads'. e.g. /wordpress/wp-content/plugins/ad-injection-ads/

2. Create a text files in this folder for each of the categories that you want an ad for. The text files should be named [category nicename].txt The 'nicename' of the category is the category name with spaces and dots converted to '-' and apostrophes removed. e.g.

Liverpool = liverpool.txt
Manchester United = manchester-united.txt
A.F.C Aldermaston = a-f-c-aldermaston.txt
Bishop's Stortford = bishops-stortford.txt

3. Then put this code (from the starting `<?php` to the closing `?>`) into the ad box. It will load the text file ad matching the category name when the post is displayed.

`<?php
$plugin_dir = dirname(__FILE__);
$ad_dir = dirname($plugin_dir).'/ad-injection-ads/';
if (file_exists($ad_dir)){
    global $post;
    $categories = get_the_category($post->ID);
    foreach ($categories as $cat){
        // nicename: spaces and dots are converted to '-' and apostrophes are removed
        $full_ad_path = $ad_dir.$cat->category_nicename.'.txt';
        if (file_exists($full_ad_path)){
            $ad = file_get_contents($full_ad_path);
            if ($ad === false) echo "<!--ADINJ CATCODE: could not read ad from file: $full_ad_path-->\n";
            echo $ad;
            break; // only show first category ad that matches
        } else {
            echo "<!--ADINJ CATCODE: could not find ad at: $full_ad_path-->\n";
        }
    }
} else {
    echo "<!--ADINJ CATCODE: could not find ad directory: $ad_dir-->\n";
}
?>`

Some extra information:
* This code will load one text file ad per post. If for example you had a post with the categories 'Liverpool' and 'Manchester United' it would load which ever ad it found first.
* If will ignore categories that have no text file in the directory. If you have a post with the categories 'Liverpool' and 'Latest News' then it will always load the liverpool.txt as long as you don't create a 'latest-news.txt'.
* This code will only work in 'direct' ad insertion mode. It won't work in 'mfunc' mode.

Expansion ideas:
* Show a default advert if no text file exists.
* Create multiple text files for each category and then randomly select one - an implementation of this is shown on [advancedhtml](http://www.advancedhtml.co.uk/advert-by-wordpress-post-category/ "advancedhtml")
* Use different code for top, random or bottom ads. e.g. you could have liverpool_top.txt and liverpool_random.txt

= How can I show different ads for different post authors? =

This is something I hope to build into the UI at some point. But in the mean time you can use PHP in the ad code boxes to do this: e.g.

`<?php
$author = get_the_author();
if ($author == "john"){ ?>
This is John's Ad.
<?php } else if ($author == "paul") { ?>
This is Paul's Ad.
<?php } ?>`

Note this will only work in direct insertion mode. It won't work in mfunc mode unless you also load in the WordPress database dependencies.

= How can I show different ads to people in different countries? =

If you install the Country Filter plugin (with the IP database) then you can use the following code in the direct ad insertion modes. This will not work in mfunc mode!

`<?php if (function_exists('isCountryInFilter')) { ?>
<?php if(isCountryInFilter(array("uk"))) { ?>

UK advert

<?php } else { ?>

Global advert

<?php } } ?>`

You can download the Country Filter plugin from http://wordpress.org/extend/plugins/country-filter/

You could also use the Geo IP functionality that CloudFlare offers (you can set it up for free if you are able to modify your DNS settings) http://support.cloudflare.com/kb/what-do-the-various-cloudflare-settings-do/how-does-cloudflare-ip-geolocation-work

= If I restrict a widget to both a category and a tag it doesn't appear in the relevant category/tag archives. Why? =

If you set an ad with a tag restriction of 'tag1' and a category restriction of 'cat1', then it will only appear on pages that have BOTH the tag1 and cat1 property.

A post in this category with that tag will have the ad.

But if will not show in the 'tag1' archive or 'cat1' category. This is because the 'tag1' archive is not part of the 'cat1' category. A tag archive can't be part of a category, and a category archive can't be part of a tag.

This means that if you add both a tag and a category restriction the ad won't appear in the tag or category archives.

If this restriction wasn't in place then it would mean the category and tag archives would start showing all ads that were set to appear in the category/tag - which could be loads! And there would be no way to remove selected ones from the archives.

Therefore if you are defining ads with both a category and a tag, you will need* to define a separate one for the category/tag archive.

I know this might cause extra work for you, but having this restriction allows more precise control of where the ads appear. This is a deliberate design decision, rather than some random behaviour. 

= Can I put adverts in other locations other than top, random, bottom, footer and widget? =

Yes - you can put adverts anywhere, if you are willing to edit your theme template.

The `adinj_print_ad` function can be used anywhere in your theme to print the top, random, bottom or footer ad. It can also be used to load ads stored in text files in the ad-injection-data directory.

For example this will print the random ad. The ad will be subject to same global and dynamic restrictions an 'in content' random ad, but it will not be subject to conditions relating to the post length, post tags, categories, or number of ads already inserted.

`<?php if (function_exists('adinj_print_ad')){ adinj_print_ad('random'); } ?>`

Here are some more examples:

`<?php if (function_exists('adinj_print_ad')){ adinj_print_ad('top'); } ?>`
`<?php if (function_exists('adinj_print_ad')){ adinj_print_ad('bottom'); } ?>`
`<?php if (function_exists('adinj_print_ad')){ adinj_print_ad('footer'); } ?>`

Here is an example of how to load a text file ad from the ad-injection-data directory. They contents of the text file will be printed straight onto the page.

`<?php if (function_exists('adinj_print_ad')){ adinj_print_ad('adsense-banner-wide.txt'); } ?>`

The `function_exists` condition ensures that the ads will silently dissapear if the plugin is deactivated rather than generating an error.

If you are using template ads with a compatible caching plugin you will need to include adshow.php (once on the page) using mfunc tags. You will need to alter the code below to include the correct path. If you look in the 'Test ads' section of the main settings page you should be able to find a version of this code customised for your web server.

`<!--mfunc include_once('/home/public_html/wordpress/wp-content/plugins/ad-injection/adshow.php') -->
<?php include_once('/home/public_html/wordpress/wp-content/plugins/ad-injection/adshow.php'); ?>
<!--/mfunc-->
<?php if (function_exists('adinj_print_ad')){ adinj_print_ad('random'); } ?>`

= How can I sell my ads / track my ad clicks? =

These are advanced features which I have no plans for adding into the core Ad Injection. You might however be able to use Ad Injection with Google Ad Manager or OpenX Ad Server that should allow you to sell your own ads and track their clicks.

If you are using a 3rd party ad provider (e.g. AdSense) then statistics such as ad clicks will be available from the ad provider.

= Are there any known plugin conflicts? =

**WP Minify**

Problem: No ads appear when using mfunc mode.

If you use WP Minify and a caching plugin in combination with Ad Injection, you'll need to turn off the HTML minification in WP Minify. This is because HTML minification strips out the mfunc tags that Ad Injection uses. You can leave the CSS and JavaScript minification on if you already use them.

**FeedWordPress**

Problem: Random, top and bottom ads don't appear on syndicated posts.

By default FeedWordPress prevents the syndicated post contents from being passed to 'the_content' hook which is where the random, top and bottom ads are added. There's an easy fix: 

From the FeedWordPress settings page go to 'Posts & Links' and then in the 'Formatting' section set 'Formatting filters' to 'Expose syndicated posts to formatting filters'.

**Shortcodes Ultimate**

Problem: Random ads don't show.

Reason: Shortcodes Ultimate disables the wpautop filter which adds the &lt;p&gt;&lt;/p&gt; tags to the page. It re-applies this filter at a priority of 99 which is after Ad Injection has run. Therefore when Ad Injection runs it can't find any &lt;/p&gt; tags which it needs to position the random adverts.

Solution: Follow the below advice for the 'theme conflicts'.

= Are there any known theme conflicts? =

Ad Injection (when injecting random ads) works by looking for the end paragraph tags (&lt;p&gt;&lt;/p&gt;). Some themes override the wpautop filter and set it to run after the plugins. This means that Ad Injection can't find the end paragraph tags, and so can't inject any random ads. If this happens try changing the the_content filter priority from the Advanced tab in the Ad Injection UI. Try values of 100, and if that doesn't work 200.

Themes which I know have this issue include 'Avenue', 'TheTravelTheme', 'Exciter Magazine', 'Vectors', and 'Canvas' from Woothemes.

= Will Ad Injection work with the multi-blog version of WordPress? =

The multi-user version of WordPress are not supported - yet, however I have heard that some people have got it to work when using the 'direct' insertion mode. I hope to make it work properly with multi-blog versions of WordPress in the future.

= Is there an easy way to copy my ad settings to a new blog? =

1. Go to phpMyAdmin, either from your web hosts control panel, or by using the very convenient 'Portable phpMyAdmin' plugin for WordPress on the blog that has your Ad Injection settings configured.
2. Open up the [yourdb]_options table.
3. Either find the adinj_options and widget_adinj rows or use this query to help you:

`SELECT * FROM [yourdb]_options WHERE option_name LIKE '%adinj%'`

4. Then copy these two options to your new blogs by using phpMyAdmin on the new blogs. If you aren't using widgets then you can ignore the widget_adinj option, you need only the adinj_options value. You can use the 'Insert' tab on the new blog to do this.

= Some technical details =

* Plugin stores all its settings in a single option (adinj_options).
* Uninstall support is provided to delete this option if you uninstall the plugin.
* Admin code is separated into a separate file so it is not loaded when your visitors view your pages.
* When used with a compatible caching plugin Ad Injection loads its dynamic settings from a static PHP file, and the ads from disk so no extra MySQL database queries are required.
* When mfunc mode is used the ads are saved as text files into the plugin folder. The plugin will therefore need write access to the plugins folder.
* The JavaScript for setting the referrer cookie is inserted using wp_enqueue_scripts.
* If there is anything I can do better please let me know - this is my first plugin so I still have a lot to learn!

== Troubleshooting ==

Here are some things to check if the ads are not appearing, or are appearing when you think they shouldn't.

1. Have you clicked the box to enable your ads?
2. Would the options you have selected allow the ads to appear on that page?
3. Have you cleared your cache (if you are using a caching plugin) to make sure that the page has the ads injected into it?
4. If you still aren't sure why the ads aren't there (or why they are), click 'Enable debug mode'. Make sure the page gets regenerated (either by reloading, or by clearing the cache and reloading). The search the source code of the page (the HTML) for 'ADINJ DEBUG' tags. This will give you information about the decisions that the plugin made.
5. Have you selected the correct insertion mode in the 'Ad insertion mode' section?
6. The plugin inserts adverts after the closing HTML paragraph tag </p>. If the ads aren't appearing where you expect, check where your </p> tags are.

= If ads aren't appearing on your archive (category, tag, author) pages =

Ad Injection can only (with most themes) insert ads into archive pages if you are showing the full post. The ads will almost certainly get truncated or stripped out if you are showing excerpts.

I hope to add proper support for excerpt ads in a later release.

= My adverts are overlapping with other page elements (e.g. images) =

You can try defining the 'clear' display setting so that multiple floated parts of your page do not overlap.

If you always have a floated image at the top of the page you can set which paragraph the first random advert will start from. If you needed finer control over where the random adverts appear you can use the <!--adstart--> and <!--adend--> tags in the page.

= I have set the ads to float but the text/headings aren't flowing around them =

Check your style sheet to see if either the text or headings have the 'clear' attribute set. This may be preventing your text / headings from flowing around the advert.

= I have configured four Google AdSense ad units but only three are showing. Why? =

Google's AdSense TOS only allow allow three ad units, and three link units per page. If you have for example tried to insert four ad units on your page then Google will (probably) disable the forth one automatically. Read Google's AdSense [program policies](https://www.google.com/adsense/support/bin/answer.py?hl=en&answer=48182 "AdSense program policies") for more info.

= Parts of the adverts are appearing in the snippets on the archive and home pages =

Ad Injection does not currently have support for inserting adverts into snippets, however ads in snippets may or may not work depending on how your theme processes the pages's content. If you end up with unwanted parts of the ad code in your snippets you may need to disable the top/random/bottom ads from your archive, home or front pages using the tick boxes near the top of the UI.

= If you are using a caching plugin =

1. Have you enabled Ad Injection's 'mfunc' mode? (in the Ad insertion mode and dynamic ad display restrictions pane)
2. If you use a version of WP Super Cache prior to 0.9.9.8  it must be configured in 'Legacy' mode for the dynamic features to work. If you use WP Super Cache 0.9.9.8 or above you can use any of the caching modes (mod_rewrite and PHP are faster than legacy).
3. If you are using WP Minify as well then turn off the HTML minification as this strips out the mfunc tags that Ad Injection uses to check if the adverts should be inserted.

= If you are using WP Minify =

1. Turn off the HTML minification mode if you are also using a caching plugin. HTML minification strips out the mfunc tags that Ad Injection needs to inject its ads.
2. If you use the 'Place Minified JavaScript in footer' then try turning it off.

= Only part of the setting screen is appearing =

You are probably running out of memory. View the HTML source of the settings page (usually right click and View Source) and see if there is an out of memory message. You might have to delete/deactivate some other plugins, or search Google for advise specific to your web host.

= If you are getting errors when using mfunc mode check the following =

1. Are there ad data directories in the plugin directory? The path will be: 

'/wp-content/plugins/ad-injection-data/.

If not create this directory and make sure it is writeable by the plugin (chmod 0755 will do, chmod 0750 is better).

2. Are there text files in the ads directories? The ad code that you enter into the ad boxes should get saved in text files in the ads directory.

3. Has the config file been created? It should be at '/wp-content/ad-injection-config.php'. If not make sure the '/wp-content/' directory is writeable (chmod 0750 is best, chmod 0755 will do).

= Errors after uninstalling the plugin =

If you get an error like:

'Warning: include_once(/homepages/xx/dxxxx/htdocs/blog/wp-content/plugins/ad-injection/adshow.php) [function.include-once]: failed to open stream: No such file or directory in /homepages/xx/dxxxx/htdocs/blog/ on line xx'

Then you need to delete your cache. The references to the Ad Injection includes are still in your cached files, deleting the cache will get rid of them.

= Reporting bugs =

If you do get any errors please use the 'Report a bug or give feedback' link on the plugin to send me the error details. If things go so badly wrong that you can't even get to the settings page please send me an email via [this contact form](http://www.reviewmylife.co.uk/contact-us/ "contact form").

== Screenshots ==

1. Easy to use interface which allows you to select on what types of pages the ads appear.
2. You can copy and paste your ad code directly from your ad provider.
3. The ads are automatically injected into the pages of your blog.
4. There are options to define how many ads appear on the post, and where they appear. The quantity of ads can be varied depending on post length.
5. Can choose to show the ads only to search engine visitors, or define IP addresses that ads aren't shown to.

== Changelog ==

= 1.2.0.16 =
* New options to exclude ads from table tags.

= 1.2.0.15 =
* New options to exclude ads from div, form, ol and ul tags.
* Fix relating to post length restrictions.

= 1.2.0.14 =
* Add additional values to numeric pull down boxes. 6000-8000 for paragraph positions. And 7500 for post length boxes.

= 1.2.0.13 =
* New option to exclude ads from blockquote and pre tags.
* New tag to exclude ads from specific parts of posts.

= 1.2.0.12 =
* Fix for ads with UTF-8 characters

= 1.2.0.11 =
* Preserve HTML entities when saving - i.e. preserve special character sequences.
* Add '400' as an option to the numbered drop downs.

= 1.2.0.10 =
* Fix to allow categories/tags/author names which contain spaces.
* Add category/tag/id/author filters for template ads.
* Hopefully fixes the 'headers already sent message that some people got with 1.2.0.8

= 1.2.0.7 =
* Tested on WordPress 3.3.
* Put mfunc code block on one line.

= 1.2.0.6 =
* Fix problem with debug output.
* Reduce memory on admin side for blogs with large numbers of tags.
* More detailed debug for PHP exec errors.
* Colour debug table changes.

= 1.2.0.5 =
* Fix: Problem with adinjblocked cookie reading.

= 1.2.0.4 =
* New: Support for Ad Logger's AdSense click blocking feature (that is my new plugin!).
* New: Make more parts of the ad placement settings UI fade away if they can't be used.

= 1.2.0.3 =
* New: Setting to allow priority of Ad Injection's the_content filter to be changed. This may help with some themes that are overriding the WordPress default 'wpautop' behaviour.
* Fix: Start at paragraph setting may have been incorrectly upgraded if previously using an old version of this plugin.

= 1.2.0.2 =
* Fix: Problem with repeating bottom ads and ID filters not being properly applied to archives.

= 1.2.0.1 =
* Fix: Bottom ad can potentially move up a paragraph if theme doesn't put closing paragraph at end of post.

= 1.2.0.0 =
* Set the position of the top and bottom advert by paragraph or character.
* Position the random ads to start or stop in the middle of the post.
* Stop the random ads 2/3 of the way down a post, or at a paragraph/character position from the beginning/end of the post.
* Fade unused Home/Archive options instead of making them dissapear.
* Add page age settings to status.
* Improve debug messages.

= 1.1.0.6 =
* New block ads by referring keyword/URL feature.
* Load tags in batches to reduce memory used when displaying main settings screen. Will help people with lots of tags.
* Fix for &lt;!--randomad--&gt; tag.
* Move tags/categories/authors/ids filters to separate area of UI.

= 1.1.0.4 =
* First ad can now be started at or after a paragraph or character position.
* Override ad positions on individual posts using &lt;!--topad--&gt; &lt;!--randomad--&gt; &lt;!--bottomad--&gt;
* Separate old post restriction for widget ads.
* Template ad examples in the 'Test ads' section.
* Warning message improvements.
* UI tweaks and other fixes.

= 1.1.0.2 =
* Remove confusing Disabled/Enabled drop down options as all ads can be enabled/disabled from the tick boxes. Please check your ads after this update and report any problems!
* Hide certain parts of the UI when the 'All' exclude boxes are ticked.
* New configured/empty indicator on the category/tag/author/id settings.

= 1.1.0.1 =
* Template ads - you can now include ads anywhere in your theme template with some simple tags. You can load the top/random/bottom/footer ads, or you can load an ad from a text file on disk. Template ads inherit the same restrictions as for ads configured via the UI.
* UI usability improvements.

= 0.9.7.11 =
* Filter ads by post/page ID
* Other misc bug fixes

= 0.9.7.10 =
* UI fix for WordPress 3.2
* fix for users who are running PHP with no UTF8 support
* file error code message fix

= 0.9.7.9 =
* Add option to prevent random ad from appearing on last paragraph (to prevent it overlapping bottom ad).
* New option to randomly pick again from pool for each random ad position.
* Modify default list of search referrers to remove /search/. Could cause problem with Google Webmaster Tools.
* Revert a change which unconditionally printed a debug message in hook after receiving report of a problem with it.

= 0.9.7.8 =
* Fix bug that prevents ads appearing on archive/home pages when certain plugins/themes are installed.
* A PHP4 compatibility fix.

= 0.9.7.7 =
* Footer ad support (only for themes that correctly use the wp_footer hook).
* Align and clear options for widgets.
* Word counting code now works for non-Latin languages.

= 0.9.7.6 =
* Category, tag and author exclusions now apply to home page posts.
* Fixes for widget category exclusions.

= 0.9.7.5 =
* Simplify the ad insertion modes. Replace the two previous direct modes with one.
* Other minor bug fixes.

= 0.9.7.4 =
* UI fixes.

= 0.9.7.3 =
* Fix (hopefully) for the disappearing top/bottom adverts that affected some users. Special thanks to numaga.com for the debug access.

= 0.9.7.2 =
Release with more debugging to try to track down top/bottom ads which have gone missing on some blogs.

= 0.9.7.1 =
Fix for disappearing top / bottom ad.

= 0.9.7 =
* Archive and home page ads now fully supported with the same controls as ads for single posts/pages.
* Category, tag and author restrictions for top, random and bottom ads.

= 0.9.6.6 =
* Widgets can be conditionally included on pages by category, tag, and author.
* Widget ad pool size increased to 10.
* Fix for using just bottom ad in mfunc mode.
* Less JavaScript on admin pages.
* Global author exclude option.

= 0.9.6.5 =
* Add 'words' to content length counting options.
* Fixes for categories/tags and ads with UTF-8 characters.
* Search/404 exclusion options for global and widget settngs.
* Ad pool size for top/random/bottom ads increased to 10.

= 0.9.6.4 =
* Can choose between page lengths based on viewable characters or all characters (includes HTML markup).
* Fixes for widget padding options.
* Enable alt content for random ads.

= 0.9.6.3 =
* Option to enable/disable front page ads in case your front and home pages are different.

= 0.9.6.2 =
* Support for W3 Total Cache and WP Cache (as well as the already supported WP Super Cache).

= 0.9.6.1 =
* Ad rotation / A:B split testing support for random, top, bottom and widget adverts.
* Alternate content which can be defined for users who are dynamically blocked (by IP or referrer) from seeing adverts.
* Choose which paragraph to start the random ads via the UI.

= 0.9.5.2 =
New CSS padding options for widgets. Fixes for CSS margin options.
Update docs for due to new mfunc support in WP Super Cache. If you are using mfunc mode and upgrade to the latest version of WP Super Cache (0.9.9.8) you can now use the faster mod_rewrite mode or PHP mode instead of legacy mode.

= 0.9.5.1 =
New CSS padding options for widgets. Fixes for CSS margin options.
Update docs for due to new mfunc support in WP Super Cache. If you are using mfunc mode and upgrade to the latest version of WP Super Cache (0.9.9.8) you can now use the faster mod_rewrite mode or PHP mode instead of legacy mode.

= 0.9.5 =
New option to add spacing above and below widgets.
New options for randomly aligning random/top/bottom ads.
Fixes for several bugs reported over Christmas.

= 0.9.4.6 =
Save options in admin_menu hook so that WordPress is correctly initialised when saving. Allows 'pluggable' include to be removed, which should fix 'Cannot redeclare get_userdatabylogin' conflict with vbbridge.

= 0.9.4.5 =
Fix problem with mfunc mode widgets on archive pages.

= 0.9.4.4 =
New display option for defining CSS clear as left, right or both.
Suppress file system warnings.
Tested on WordPress 2.8.6 - it works!

= 0.9.4.3 =
Only write to config file in mfunc mode.

= 0.9.4.2 =
Allow plugin to work with PHP4.
Increase allowed home page ads to 10.
Must always save widget ads to disk in case mode is changed to mfunc later on.

= 0.9.4.1 =
Fix: Remove file contents if ad is 0 length.

= 0.9.4 =
Global tag and category restrictions.
Smoother JQuery show/hide blocks (especially on IE)

= 0.9.3.4 =
Clean up old settings restore block.

= 0.9.3.3 =
Add a status box to make it easy to see what the main settings are. 

= 0.9.3.2 =
Add test mode, and further reduce unnecessary file access.

= 0.9.3.1 =
Fix chmod comparison problem.

= 0.9.3 =
Invalidate the options cache after saving.

= 0.9.2 =
If you are using mfunc mode and have added ad widgets please re-save them to regenerate the ad files.
Save ad files to a new directory so they don't need to be re-created after upgrade.

= 0.9.1 =
Fix dynamic checking for widgets.
Fix potential PHP error message with widgets.

= 0.9.0 =
Widget support.
Only write to the ad files if necessary.
Chrome display fixes.
More informative save messages.
Other fixes.

= 0.8.9 =
Prevent config file being lost by bulk automatic update.
Error messages from adshow.php are hidden in HTML now rather than being visible to everyone.

= 0.8.8 =
Try to make sure ads don't appear on archive pages, 404s or search results, in case theme is working in a non-standard way. Reduce dependency on files.

= 0.8.7 =
More fault tolerant mfunc support.

= 0.8.6 =
Fix problems relating to over strict chmod usage. 
Add save message. 
More informative warnings.
Update links to reviewmylife.

= 0.8.5 =
Fix 'Something badly wrong in num_rand_ads_to_insert' message that occurs on page types that I haven't taken account of.

= 0.8.4 =
* Fix deletion of ad code and config file that happens during automatic update.

= 0.8.3 =
* First public release

== Upgrade Notice ==

= 1.2.0.16 =
* New options to exclude ads from table tags.

= 1.2.0.15 =
* New options to exclude ads from div, form, ol and ul tags.
* Fix relating to post length restrictions.

= 1.2.0.14 =
* Add additional values to numeric pull down boxes. 6000-8000 for paragraph positions. And 7500 for post length boxes.

= 1.2.0.13 =
* New option to exclude ads from blockquote and pre tags.
* New tag to exclude ads from specific parts of posts.

= 1.2.0.12 =
* Fix for ads with UTF-8 characters

= 1.2.0.11 =
* Preserve HTML entities when saving - i.e. preserve special character sequences.
* Add '400' as an option to the numbered drop downs.

= 0.8.3 =
First public release.


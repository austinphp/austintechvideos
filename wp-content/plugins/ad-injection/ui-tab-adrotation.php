<?php
/*
Part of the Ad Injection plugin for WordPress
http://www.reviewmylife.co.uk/
*/

if (!is_admin()) return;

function adinj_tab_adrotation(){
	$ops = adinj_options();
	
	echo <<<DOCS
	<p><a href="#multiple_top">Top adverts</a> | <a href="#multiple_random">Random adverts</a> | <a href="#multiple_bottom">Bottom adverts</a> | <a href="#multiple_footer">Footer adverts</a> | <a href="#advanced">Advanced</a> | <a href="#docs_tags">Tag docs</a> | <a href="#testads">Test ads</a></p>
DOCS;
	
	$total_rand_split = adinj_total_split('ad_code_random_', $ops);
	$total_rand_alt_split = adinj_total_split('ad_code_random_alt_', $ops);
	
	$total_top_split = adinj_total_split('ad_code_top_', $ops);
	$total_top_alt_split = adinj_total_split('ad_code_top_alt_', $ops);
	
	$total_bottom_split = adinj_total_split('ad_code_bottom_', $ops);
	$total_bottom_alt_split = adinj_total_split('ad_code_bottom_alt_', $ops);
	
	$total_footer_split = adinj_total_split('ad_code_footer_', $ops);
	$total_footer_alt_split = adinj_total_split('ad_code_footer_alt_', $ops);
	?>
	
	<style type="text/css">
	.adinjtable td { vertical-align: top; }
	</style>
	
	<?php
	adinj_postbox_start(__("Ad rotation / alt content docs", 'adinj'), 'docs_adrotation');
	echo <<<DOCS
	<p>Ad rotation / split testing and alternate content are advanced features. If you don't understand these features you probably don't need them and can therefore ignore this tab. In summary:</p>
	<ul>
	<li><b>Ad rotation / split testing:</b> You can define multiple adverts for the same ad space which are rotated according to the ratios you define. The percentage of views that each ad will be shows is displated beneath the ratio text box. For example if you define two ads and set both to have a ratio of '50' they will each be shown (roughly) 50% of the time. The numbers don't have to add up to 100 as the ratio is calculated based on the total. e.g. if you have two advert - one is set with a ratio of '1' and the other '3' the ratios will be 25% and 75%. Please remember this isn't strict ad rotation, it is random selection based on ratios so the ratios will be correct over a large sample of ad views, not a small sample.</li>
	<li><b>Alternate content:</b> This is content that is displayed when ads are blocked for the user. You could use this alternate content to show other content, some kind of layout filler, or even a different type of ad. I've added support for rotation of alternate content as well.</li>
	</ul>
DOCS;
	adinj_postbox_end();
	
	adinj_postbox_start(__("Top adverts", 'adinj'), 'multiple_top');
	echo '<table border="0" cellspacing="5" class="adinjtable">';
	for ($i=1; $i<=10; ++$i){
		adinj_add_row_with_text_box('ad_code_top_', $i, 'Ad code', $total_top_split);
	}
	adinj_add_row_with_text_box('ad_code_top_alt_', 1, 'Alt content', $total_top_alt_split);
	adinj_add_row_with_text_box('ad_code_top_alt_', 2, 'Alt content', $total_top_alt_split);
	echo '</table>';
	adinj_postbox_end();

	
	adinj_postbox_start(__("Random adverts", 'adinj'), 'multiple_random');
	echo '<table border="0" cellspacing="5" class="adinjtable">';
	for ($i=1; $i<=10; ++$i){
		adinj_add_row_with_text_box('ad_code_random_', $i, 'Ad code', $total_rand_split);
	}
	adinj_add_row_with_text_box('ad_code_random_alt_', 1, 'Alt content', $total_rand_alt_split);
	adinj_add_row_with_text_box('ad_code_random_alt_', 2, 'Alt content', $total_rand_alt_split);
	echo '</table>';
	adinj_postbox_end();
	
	
	adinj_postbox_start(__("Bottom adverts", 'adinj'), 'multiple_bottom');
	echo '<table border="0" cellspacing="5" class="adinjtable">';
	for ($i=1; $i<=10; ++$i){
		adinj_add_row_with_text_box('ad_code_bottom_', $i, 'Ad code', $total_bottom_split);
	}
	adinj_add_row_with_text_box('ad_code_bottom_alt_', 1, 'Alt content', $total_bottom_alt_split);
	adinj_add_row_with_text_box('ad_code_bottom_alt_', 2, 'Alt content', $total_bottom_alt_split);
	echo '</table>';
	adinj_postbox_end();
	
	
	adinj_postbox_start(__("Footer adverts", 'adinj'), 'multiple_footer');
	echo '<table border="0" cellspacing="5" class="adinjtable">';
	for ($i=1; $i<=10; ++$i){
		adinj_add_row_with_text_box('ad_code_footer_', $i, 'Ad code', $total_footer_split);
	}
	adinj_add_row_with_text_box('ad_code_footer_alt_', 1, 'Alt content', $total_footer_alt_split);
	adinj_add_row_with_text_box('ad_code_footer_alt_', 2, 'Alt content', $total_footer_alt_split);
	echo '</table>';
	adinj_postbox_end();
	
	
	adinj_advanced();
	
	adinj_docs_tags();
	
	adinj_testads();
	
	
}

function adinj_add_row_with_text_box($name_stem, $num, $title, $total){
	$ops = adinj_options();
	$name = $name_stem.$num;
	$namesplit = $name.'_split';
	$percent = adinj_percentage_split($name_stem, $num, $ops, $total);
echo <<<EOT
	<tr><td>
	<a name="$name"></a>
	<span style="font-size:10px;"><b>$title $num</b></span><br />
	<textarea name="$name" rows="8" cols="
EOT;
	adinj_table_width('rotation');
	echo '">'.adinj_process_text($ops[$name]);
echo <<<EOT
</textarea>
	</td><td>
	<input name="$namesplit" size="7" value="$ops[$namesplit]" />
	<br />
	$percent
	</td></tr>
EOT;
}

function adinj_advanced(){
	adinj_postbox_start(__("Advanced settings", 'adinj'), "advanced");
	echo "<p>If your theme or another plugin is causing problems with Ad Injection (e.g. by changing the priority of the 'wpautop' filter which may prevent the random ads from being added) you can try modifying Ad Injection's the_content filter priority here. Try '100', if that doesn't work try something higher. ";
	adinj_selection_box("the_content_filter_priority", array(0,1,10,11,100,200,1000));
	echo ' Default: 10</p>';
	adinj_postbox_end();
}


function adinj_docs_tags(){
?>

<?php adinj_postbox_start(__("Supported in-page tags", 'adinj'), "docs_tags", '95%'); ?>

<p>These tags can be inserted into the page source to override the configured behaviour on single posts and pages. Because sometimes specific pages need to be treated differently.</p>

<h3>Fully supported tags</h3><br />

<ul>
<li><code>&lt;!--topad--&gt;</code> OR <code>&lt;!--randomad--&gt;</code> OR <code>&lt;!--bottomad--&gt;</code> - These tags allow precise positioning of the adverts instead of using the computer calculated positions.</li>
</ul>

<ul>
<li><code>&lt;!--adinj_exclude_start--&gt;&lt;!--adinj_exclude_end--&gt;</code> - Exclude ads from specific sections of the post.</li>
</ul>

<ul>
<li><code>&lt;!--adstart--&gt;</code> - Random ads will start from this point.</li>
<li><code>&lt;!--adend--&gt;</code> - Random ads will not be inserted after this point.</li>
</ul>

<p>The above adstart/adend tags and below adsensestart tag will not affect the top and bottom ad.</p>

<h3>Other tags</h3><br />

<ul>
<li><code>&lt;!--noadsense--&gt;</code> OR <code>&lt;!-no-adsense--&gt;</code> OR <code>&lt;!--NoAds--&gt;</code> OR <code>&lt;!--OffAds--&gt;</code> - disables all ads on this page. These tags are here to make this plugin compatible with the tags from Adsense Injection, Whydowork Adsense and Quick Adsense.</li>
</ul>

<p></p>

<ul>
<li><code>&lt;!--adsensestart--&gt;</code> - Random ads will start from this point. For compatibility with Adsense Injection.</li>
</ul>

<p></p>

<ul>
<li><code>&lt;!--adsandwich--&gt;</code> - Inserts the top and bottom ad but no random ads. Disables all other ads.</li>
<li><code>&lt;!--adfooter--&gt;</code> - Insert a single ad at the very bottom. Disables all other ads.</li>
</ul>

<h4>Custom field for disabling adverts</h4>

<p>To disable all adverts on the page you can also set the custom <code>disable_adverts</code> field to '1' from the WordPress post editor.</p>


<?php adinj_postbox_end();

}

?>
<?php
/*
Plugin Name: ANTS INSIGHT
Plugin URI: http://dungbv.info
Description: Setting ANTS Insight code.
Version: 1.0.1
Author: Dũng Bạch
Author URI: http://dungbv.info
*/



//add insight code, meta tag
add_action('wp_head','ants_hook_antic');
//ANTS admin manager
add_action( 'admin_menu', 'Options_ANTS');


function Options_ANTS() {
	add_menu_page( 'ANTS INSIGHT', 'ANTS INSIGHT', 0, 'ants_config', 'plugin_Options_ANTS' );
}

function plugin_Options_ANTS() {
	
	if ($_POST['options_ANTS_FROM']) {
		$ar1=array('\"',"\'");
		$ar2=array("'","'",);
		$myNewOptions = array(    	
			'ants_SiteId' =>  esc_html(str_replace($ar1,$ar2,$_POST['ants_SiteId']))         
		);
		update_option('Options_ANTS', $myNewOptions); 
		echo '<p style="color:green;">Update successful!</p>';
	}
	$bg = get_option('Options_ANTS');

	echo "<h1>Cấu hình ANTS INSIGHT</h1>
        <form action='' method=post>        
		<div class='dbdb'>SiteId :</div> <input size='50' type='text' name='ants_SiteId' value='".$bg['ants_SiteId']."'><br /><br />        
        <input type=submit name=options_ANTS_FROM value=Submit>
		</form>
		<style>.dbdb{float: left;width: 200px;}</style>
		";


}



function ants_hook_antic(){
	
	$bg = get_option('Options_ANTS');
	if(!empty($bg['ants_SiteId'])){		
		$output='
			   <!-- Ants Insight script -->
				<script type="text/javascript">
				 var _siteId="'.$bg['ants_SiteId'].'";
				 (function(){
				   var e=document.createElement("script");e.type="text/javascript",e.async=!0,e.src="//st-a.anthill.vn/adx.js";
				   var t=document.getElementsByTagName("script")[0];t.parentNode.insertBefore(e,t)})();
				</script>
				<!-- End of Ants Insight script -->
		';

		echo $output;
	}
	
	$author='';
	if(is_home()){
		$name='0';
		$id='0';
	}elseif(is_single()or(is_page())){
		global $post;
		$cat = get_the_category($post->ID);
		$name = $cat[0]->name;
		$name = ($name!='')?$name:get_the_title();
		$id=$post->ID;
		$d = get_userdata($post->post_author)->data;
		$author = ($d->user_login!=$d->display_name)?$d->display_name:'';
		}else{
		$name=single_cat_title( '', false );
		$id= (get_query_var('cat')!='')?get_query_var('cat'):get_query_var('tag_id');
	}
	$da = '
	<meta name="adx:sections" content="'.$name.'" />
	<meta name="adx:objects" content="'.$id.'" />
	<meta name="adx:authors" content="'.$author.'" />
	';
	echo $da;
}

	




  

?>
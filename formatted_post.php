<?php /*
Plugin Name: Formatted post
Plugin URI: http://kiro.twbbs.org/wp/?p=504
Description: for users who need to post with the same format often.
Version: 1.01
Author: Kiro G.
Author URI: http://kiro.twbbs.org/wp/
*/
add_action('admin_menu', 'wp_fp_menu');
define (FP,"formatted_post");
define (FP_ACTION,"asmkwmekdlwnefwnklwmlksmxaklmxklamx");//change it to a random value
if($_POST[FP]==FP_ACTION){
 formatted_post_deal();
}
function wp_fp_menu(){
//add_menu_page(__('Formatted post',"fp"), __('Formatted post',"fp"), 5, "formatted_post.php", 'call_fp');

 load_plugin_textdomain(FP, PLUGINDIR.'/'.dirname(plugin_basename(__FILE__)),dirname(plugin_basename(__FILE__)));
add_submenu_page("options-general.php",__('Formatted post',FP),__('Formatted post',FP),5,"formatted_post.php","call_fp");
add_submenu_page("edit.php",__('Post with Format',FP),__('Post with Format',FP),2,"formatted_post.php","call_post_formatted_form");

//echo "";
}

function call_fp(){
if(isset($_POST['delete'])) {
$t=get_option(FP."_index");
unset($t[$_POST['type']]);
$new_t=$t;
//$new_t=array_diff($t,array($_POST['type']));
update_option(FP."_index",$new_t);
delete_option(FP."_".$_POST['type']);
?>
<script>location="?page=<?php echo $_POST['page']?>&msg=2&type=<?php echo $_POST['type'];?>";
</script>
<?
}
if(isset($_POST['submit'])&&wp_verify_nonce($_POST['_wpnonce'],FP)){
if($_POST['type']==-1)
{ $t=get_option(FP."_index");
if(empty($t)) {$t=array(0=>array("category"=>$_POST['category_parent'],"used"=>'Y'));
$type=0;
}else {
$t[]=array("category"=>$_POST['category_parent'],"used"=>"Y");
end($t);
$type=key($t);
	}
update_option(FP."_index",$t);
update_option(FP."_".$type,$_POST['template']);

	}//end of type=0
else {
$t=get_option(FP."_index");

$type=$_POST['type'];
$t[$type]['category']=(int) $_POST['category_parent'];
update_option(FP."_".$type,$_POST['template']);
update_option(FP."_index",$t);

}
?>
<script>location="?page=<?php echo $_POST['page']?>&msg=1&type=<?php if($_POST['type']!=-1) echo $_POST['type']; else  echo $type;?>&action=edit";
</script>
<?
//header("location:?page=".$_POST['page']);
}

?>
<div class="wrap">
<h2><?php _e('Formatted post',FP);
$edit=($_GET['action']=='edit')?true:false;
$e=get_option(FP."_index");
?></h2>
<?php if($_GET['msg']==1) echo "<div class='updated fade below-h2' id='message'>"._e("Updated",FP)."</div>";?>
<?php if($_GET['msg']==2) echo "<div class='updated fade below-h2' id='message'>"._e("Deleted",FP)."</div>";?>

<div>
     <?php if($edit):?>      
<a href="?page=<?php echo $_GET['page']?>"><?php _e("New template",FP);?></a><br/>
<?php endif;?>

<?php _e("Edit exist format:",FP);
$fps=get_option(FP."_index");
foreach ($fps as $i=>$f){
echo "<a href='?page=".$_GET['page']."&action=edit&type=$i'>".__("Template",FP)."$i</a>,";
}
?>

<form method="post">	
<?php _e("Select a category as default category:",FP);?>
<?php $cat=($edit)?$e[$_GET['type']]['category']:"";
wp_dropdown_categories(array('hide_empty' => 0, 'name' => 'category_parent', 'orderby' => 'name', 'selected' => $cat, 'hierarchical' => true)); ?><br />
 <?php _e("Enter the formmated post",FP);?><br/>
<textarea name="template" cols='60' rows='20'><?php if($edit) {$tplt=stripcslashes(get_option(FP."_".$_GET['type']));echo $tplt;}?></textarea><br/>
<input name="type" value="<?php  echo (isset($_GET['type']))?$_GET['type']:-1;?>" type="hidden"/><br/>
<?php wp_nonce_field(FP);?>
<input name="page" value="<?php echo $_GET['page'];?>" type="hidden"/><br/>
<input name="submit" value="<?php  if($edit)_e("Edit",FP); else _e("Add",FP);?>" type="submit" class='button'/>
     <?php if($edit):?>      
<input name='delete' value="<?php _e("delete",FP);?>" type="submit" class='button'/>
<?php endif;?>
</form>
</div>
     <?php if($edit):?>      
  <h2>   <?php _e("Template Preview:");?></h2>
<div id='preview'>
<?php  echo $tplt;?>
</div>
<?php endif;?>
</div>
<?
}
function call_post_formatted_form(){
$fps=get_option(FP."_index");
_e("Select a template:",FP);

$type=(isset($_GET['type']))?$_GET['type']:key($fps);

$x=get_option(FP."_".$type);
foreach ($fps as $i=>$f){
if($f['used']=="Y")
echo "<a href='?page=".$_GET['page']."&action=edit&type=$i'>".__("Template",FP)."$i</a>,";
}
?>
<h2><?php _e('Post with Format',FP);?></h2>
<?php 
formatted_post_form($type,"both");
}

function formatted_post_form($index,$submit="publish",$gets=""){//$submit should be publish,draft or both
$fps=get_option(FP."_index");
$x=get_option(FP."_".$index);
if(empty($x)) _e("This template doesn't exist",FP);
?>
<form method="POST">
<?php _e("Title:",FP);?><input name='post_title' value="" id='title' size="30"/>
<br/>
<?php  echo preg_replace("/#(.*)#/","<input name='$1' value=''  />",stripcslashes($x)); ?>
<input name="type" value="<?php echo $index?>" type='hidden'/>
<!--<input name="page" value="<?php echo $_GET['page']?>" type='hidden'/>-->
<input name="<?php echo FP;?>" value='<?php echo FP_ACTION;?>' type='hidden'/>
<input name="submit_type" value="" type="hidden"/>
<?php if($submit=="publish"||$submit=="both"):?>

<input name='publish' value='<?php _e("Publish",FP);?>' type="button" class='button' onclick="this.form.submit_type.value='publish';this.form.submit();" />
<?php endif;?>
<?php if($submit=="draft"||$submit=="both"):?>
<input name='draft' value='<?php _e("Save as draft",FP);?>' type="submit" class='button'  onclick="this.form.submit_type.value='draft'"/>
<?php endif;?>
<?php wp_nonce_field(FP."edit");
?>
</form>
<?
}

function formatted_post_deal($redirect=''){
if(!function_exists("wp_verify_nonce")) {
	require_once(ABSPATH . WPINC . '/pluggable.php');
}//isset($_POST['publish_type'])&&

if(wp_verify_nonce($_POST['_wpnonce'],FP."edit")){
$fps=get_option(FP."_index");
$type=(int)$_POST['type'];

//print_r($opt);
$category=$fps[$type]['category'];
$statu=($_POST['submit_type']=="publish")?"publish":"draft";
$x=get_option(FP."_".$type);
$content=preg_replace("/#(.*)#/e",'$_POST["\\1"]',stripcslashes($x)); ;
$data =array(
"post_title"=>$_POST["post_title"],
"post_content"=>$content,
"post_status"=>$statu,
"post_category"=>array($category)
	);
	$c=@wp_insert_post($data);
	}
if(!empty($redirect)) echo "<script> location.href='$redirect'</script>";
//	header("location:?msg=".$_POST['submit_type']."&post_new=$c");
}
?>

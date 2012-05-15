<?php
$va_errors = $this->getVar("errors");
if(!is_array($va_errors)){
	$va_errors = array();
}

print $this->render('Engage/subNav.php');
?>
<div id="siteComments">
	<H1>Post a Comment</H1>
	<div id="form">
		<h2><?php print _t("Questions, comments or suggestions about the site?  Post your comment."); ?></h2>
		<form method="post" action="<?php print caNavUrl($this->request, 'clir2', 'Comments', 'saveComment'); ?>" name="comment">
<?php
		if(!$this->request->isLoggedIn()){
?>
			<div class="formLabel"><?php print _t("Your name"); ?></div>
<?php
			if($va_errors["name"]){
				print "<div class='formErrors'>".$va_errors["name"]."</div>";
			}
?>
			<input type="text" name="name" value="<?php print $this->getVar("name"); ?>">
			<div class="formLabel"><?php print _t("Your email address"); ?></div>
<?php
			if($va_errors["email"]){
				print "<div class='formErrors'>".$va_errors["email"]."</div>";
			}
?>
			<input type="text" name="email" value="<?php print $this->getVar("email"); ?>">
<?php
		}
?>
			<div class="formLabel"><?php print _t("Comment"); ?></div>
<?php
			if($va_errors["comment"]){
				print "<div class='formErrors'>".$va_errors["comment"]."</div>";
			}
?>
			<textarea name="comment" rows="<?php print ($this->request->isLoggedIn()) ? "10" : "5"; ?>"><?php print $this->getVar("comment"); ?></textarea>
			<div class="button"><a href="#" name="commentSubmit" onclick="document.forms.comment.submit(); return false;"><?php print _t("Save")." &raquo;"; ?></a></div>
		</form>
	</div><!-- end form -->
<?php
	print $this->render('Comments/comments_intro_text_html.php');
$va_comments = $this->getVar("comments");
if(is_array($va_comments) && (sizeof($va_comments) > 0)){
?>
	<div class="divide" style="clear:both;"><!-- empty --></div><!-- end divide --><br>
	<H1>Comments</H1>
<?php
	foreach($va_comments as $va_comment){
?>		
		<div class="byLine">
			<?php print _t("On %1, %2 wrote", $va_comment["date"], ((trim($va_comment["author"])) ? $va_comment["author"] : $va_comment["name"])).": "; ?>
		</div>
		<div class="comment">
			<?php print $va_comment["comment"]; ?>
		</div>
<?php
	}
}
?>
</div><!-- end siteComments -->
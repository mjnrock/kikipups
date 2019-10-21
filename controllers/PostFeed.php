<?php
	class PostFeed {

	}
?>



<?php function renderPostFeed($replStr) { ob_start(); ?>
	<ul>
		<?php
			foreach($DataBag->DataSet as $key => $row) {
				$DataBag->callPartial($key, "Post");
			}
		?>
	</ul>
<?php return ob_get_clean(); } ?>
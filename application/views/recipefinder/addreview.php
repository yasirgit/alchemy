<?php
if($alreay_added < 1)
{
?>
	<p>
	<?php 
		echo $review['review'];			
		$divId=$review['review_id'];
	?>
	</p>
	<p>
		<span class="reviwer-user">
		<?php 
			echo date('M d, Y', strtotime($review['created']))." by member: <a href='#'>".$review['username']."</a>";			
		?>
		</span>
		<span class="reviews-rating">
			<img src="htdocs/images/img-stars<?php echo $review['rating'];?>.gif" alt="Rating"/>
		</span>
		<br class="clear" />
	</p>
 
	<div id="recipereview<?php echo $review['updateid'];?>">
	</div>
<?php
} else {
	echo "1";
}
?>	
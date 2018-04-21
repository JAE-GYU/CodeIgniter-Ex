<?php foreach($board as $row) {?>				
	<div class="card board-panel">		
		<?php if($row['image'] != "") {?>
		<a href="/view/<?php echo $row['_id'] ?>"><img src="<?php echo $row['image']?>" alt="img"></a>
		<?php }?>
		<a href="/view/<?php echo $row['_id'] ?>"><h5 class="mt-3 font-semibold text-black"><?php echo $row['title']?></h5></a>
		<p class="mt-2 font-300 text-small text-black2 text-14"><?php echo $row['content']?></p>
		<p class="mt-2 font-300 text-small text-grey"><?php echo $row['created_at']?>, @<?php echo $row['name']?></p>
	</div>
<?php } ?>
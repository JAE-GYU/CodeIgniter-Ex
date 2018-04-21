<div id="login" class="bg-light">
	<div class="container py10">
		<div class="col-md-9 col-sm-10 col-center login-panel">
			<div class="col-12 col-center">
				<div class="col-11 pt-4 col-center" id="board_view">
                    <?php if($board->image != "") :?>
                    <div class="view_img col-12 col-clear">
                        <img src="<?php echo $board->image;?>" alt="image">
                        <div>
                            <a target="_blank" href="download/<?php echo $board->_id ?>"><span class="font-300">Download Image</span></a>
                        </div>
                    </div>					
                    <?php endif ?>
					<h3 class="mt-3 font-semibold text-black"><?php echo $board->title?></h3>
                    <p class="mt-2 font-300 text-black2"><?php echo $board->content?></p>
                    <p class="mt-2 font-300  text-grey"><?php echo $board->created_at?>, @<?php echo $board->name?></p>
                    <p id="delete" class="float-right text-danger">Delete</p> 
                    <a href="/update/<?php echo $board->_id?>" id="edit" class="float-right text-success mr-3">Update</a>
                    <div class="col-12 text-center cl">
                        <a href="/" class="text-small font-300">Back to main page</a>
                    </div>
				</div>
			</div>			
		</div>
	</div>
</div>
<script>
    $(function(){
        $("#delete").on("click",function(){
            var c = confirm("Delete?");

            if(c == true) {
                document.location.href="/delete/"+"<?php echo $board->_id?>";
            }else {
                return false;
            }
        });
    });
</script>
<?php if($this->input->get('status') && $this->input->get('status') == "failed") {?>
<div class="alert alert-danger alert-dismissible fade show" role="alert">
    <div class="container">
        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
            <span aria-hidden="true">&times;</span>
        </button>
        <strong>Failed</strong>Upload Failed
    </div>
</div>
<?php } ?>
<div id="login" class="bg-light">
	<div class="container py10">
		<div class="col-md-7 col-sm-10 col-center login-panel">
			<div class="col-12 col-center">
				<div class="col-9 col-center">
					<h1 class="title text-center text-black">Upload</h1>
					<form enctype="enctype= multipart/form-data">
                        <input type="hidden" name="<?php echo $this->security->get_csrf_token_name()?>" value="<?php echo $this->security->get_csrf_hash()?>">
                        <div class="form-group">
                            <label for="img" class="text-black">Image</label>
                            <label for="img" class="img_box"></label>
                            <input type="file" id="img" name="img" class="form-control d-none">
                            <img class="preview_img" src="" alt="preview_img">
                            <p class="text-small text-grey font-300">Drag image or click to upload</p>                    
                        </div>
                        <div class="form-group">
                            <label for="tilte" class="text-black">Title</label>
                            <input type="text" id="title" name="title" class="form-control" placeholder="Title">
                            <?php echo form_error('title','<span class="mt-2 text-danger text-small">','</span>')?>
                        </div>
						<div class="form-group">
                            <label for="content" class="text-black">Content</label>
                            <textarea id="content" name="content" class="form-control" placeholder="Content"></textarea>
                            <?php echo form_error('content','<span class="mt-2 text-danger text-small">','</span>')?>
                        </div>                     
                        <button type="button" id="upload_btn" class="mt-3 mb-4 p-2 mb-1 btn btn-block btn-primary">Uplaod</button>
					</form>
                    <div class="col-12 text-center">
                        <a href="/" class="text-small font-300">Back to main page</a>
                    </div>
				</div>
			</div>			
		</div>
	</div>
</div>
<script>
	var imgfile;
	var imageHex = ['89504e47','424dfe77','47494638','ffd8ffe0','ffd8ffe1','ffd8ffe2','0010'];

	function getUint8Array(file,callback) {
	    var reader = new FileReader();
	    reader.onloadend = function (e) {
	        var uint = (new Uint8Array(e.target.result).subarray(0,4));
	        var uintHex = "";
	        for(var i = 0; i < uint.length; i++) {
	            uintHex += uint[i].toString(16);
	        }
	        typeof callback == "function" && callback(e,uintHex);
	    };
	    reader.readAsArrayBuffer(file);
	}

	$(".img_box, .preview_img").on("dragover",function (e) {
	    e.preventDefault();	    
	}).on("drop",function (e) {
	    e.preventDefault();

	    var files = e.originalEvent.dataTransfer.files;
	    file = files[0];	    
	    imgfile = file;
		getUint8Array(file,function (e,uintHex) {
	       if(imageHex.indexOf(uintHex) >= 0) {	       			          			           
	           	var reader = new FileReader();
			    reader.onload = function(r) {	    	
			    	$(".preview_img").attr("src",r.target.result).css("display","block");	    	
			    	$(".img_box").hide();   	
			    }

			    if(files) {
			    	reader.readAsDataURL(file);
			    }
	       }else {
	           alert("Only image file");
	           return false;
	       }
	    });	    	    
	});

	$(".preview_img").on("click",function(){$("#img").click();});

	$("#img").on("change",function () {
	    var files = $(this)[0].files;	    
	    file = files[0];
	    imgfile = file;	    	   

		getUint8Array(file,function (e,uintHex) {
	       if(imageHex.indexOf(uintHex) >= 0) {
	          	imgfile = files[0];	           
	           	var reader = new FileReader();
			    reader.onload = function(r) {	    	
			    	$(".preview_img").attr("src",r.target.result).css("display","block");	    				   	
			    	$(".img_box").hide();   	
			    }

			    if(files) {
			    	reader.readAsDataURL(file);
			    }
	       }else {
	           alert("Only image file");
	           return false;
	       }
	    });	 
	});

	$("#upload_btn").on("click",function() {				
		var title = $("#title").val();
		var content = $("#content").val();
		var formData = new FormData();		
		formData.append('title',title);
		formData.append('content',content);

		if(imgfile != null) {
			if(imgfile['size'] > 5242880) {
				alert("Max file size 5M")
				return false;
			}else {
				formData.append('img',imgfile);
			}
		}
		
		formData.append('<?php echo $this->security->get_csrf_token_name()?>',"<?php echo $this->security->get_csrf_hash()?>");
		is_uploading = false;

		$.ajax({
		    url: '/upload',
		    data: formData,		    
		    contentType: false,		    
		    method: 'POST',
		    processData: false,
		    beforeSend: function(){
                $('#upload_btn').attr("disabled","disabled");               
            },
		    success: function(data){
		        if(data === "success") {
		        	document.location.href="/";
		        }else {
		        	document.location.href="/upload?status=failed";
		        }
		    }
		});		
	});
</script>
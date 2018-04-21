<div id="main">
	<div class="container">
		<h1 class="title text-center text-black">Main Page</h1>

		<div id="board">			
			<div class="card-columns">				
				
			</div>
		</div>
	</div>
</div>
<div id="loading" class="py-4 bg-grey d-none">
	<h4 class="text-center"><i class="font-500 fas fa-spinner fa-spin mr-2"></i>Loading</h4>
</div>
<script>
	var page = 1;
	var isLoading = 0;

	$(function(){
		$.ajax({
		    url: '/page?page='+page,		    		    		        
		    method: 'POST',		    		    
		    success: function(data){
		        $("#board > .card-columns").append(data);
		    }
		});	
	});

	$(window).scroll(function(){	
		console.log(isLoading);
        if($(window).scrollTop() == $(document).height() - $(window).height()){    
        	if(isLoading == 1) {
        		return false;
        	}    	
        	isLoading = 1;
        	page++;
        	$.ajax({
		    url: '/page?page='+page,		    		    		        
		    method: 'POST',		    		    
		    beforeSend: function() {
		    	$("#loading").removeClass("d-none");
		    },
		    success: function(data){
		    	if(data == "") {		    		
		    		setTimeout(function(){
		    			$("#loading").html("<h4 class='text-center'>NO DATA</h4>");
		    		},500);		    		
		    	}else {
			    	setTimeout(function(){
			    		console.log("loadData");		    			
			    		$("#board > .card-columns").append(data);
			        	$("#loading").addClass("d-none");
			        	isLoading = 0;
			    	},500);
		    	}		        		        
		    }
		});	
        }
    }); 
</script>
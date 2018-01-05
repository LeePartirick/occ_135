<script>
//初始化
$(document).ready(function(){

	$('#txtb_proc_search<?=$time?>').textbox({
		width:'300',
		buttonIcon:'icon-search',
		buttonAlign:'left',
	})

	$('#txtb_proc_search<?=$time?>').textbox('textbox').autocomplete({
        serviceUrl: 'proc_back/main/get_json_proc.html',
        width:'auto',
        onSelect: function (suggestion) {
			var id='p_'+base64_decode(suggestion.data.p_id)+'<?=$time?>'
	    	
	    	window.location.hash = '#'+id; 
	    	
	    	$('#'+id).addClass('suiinfo');
			$('#'+id).attr('data-intro','在这里！');
			$('#'+id).attr('data-step',1);
			
			$.introJs().start();
			
			setTimeout(function(){
			$('.introjs-skipbutton').click();
			
			$('.suiinfo').removeAttr('data-intro');
			$('.suiinfo').removeAttr('data-step');
			
			},1500);
		}
	});
	
});

</script>
	 

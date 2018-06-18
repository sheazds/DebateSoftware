<script>
	function round_dropdown(value)
	{
		$.ajax({
			url: "tournaments/pairings.php",	
			type: "POST",
			data: {'get_round_id':value},
			success: function(return_data){
				$('#content').html(return_data);
			},
		});
	}
	
	function pairings_add(form)
	{
		post_data = {};
		form.forEach(function(item, index) {
			post_data[item.name] = item.value;
		});
		
		$.ajax({
			url: "tournaments/pairings_add.php",	
			type: "POST",
			data: post_data,
			success: function(return_data){
				$('#content').html(return_data);
			},
		});
	}
	
	function pairings_edit(id, form)
	{
		post_data = {};
		form.forEach(function(item, index) {
			post_data[item.name] = item.value;
		});

		$.ajax({
			url: "tournaments/pairings_edit.php",	
			type: "POST",
			data: post_data,
			success: function(return_data){
				$('#content').html(return_data);
			},
		});
	}
	
	function pairings_delete(id)
	{
		$.ajax({
			url: "tournaments/pairings_delete.php",	
			type: "POST",
			data: {'get_match_id':id},
			success: function(return_data){
				$('#content').html(return_data);
			},
		});
	}
	
	function view_judges(id)
	{
		$.ajax({
			url: "tournaments/pairings_judges.php",	
			type: "POST",
			data: {'get_round_id':id},
			success: function(return_data){
				$('#content').html(return_data);
			},
		});
	}
	
	function view_pairings(id)
	{
		$.ajax({
			url: "tournaments/pairings.php",	
			type: "POST",
			data: {'get_round_id':id},
			success: function(return_data){
				$('#content').html(return_data);
			},
		});
	}
	
	function view_generate(id)
	{
		$.ajax({
			url: "tournaments/pairings_generate.php",	
			type: "POST",
			data: {'get_round_id':id},
			success: function(return_data){
				$('#content').html(return_data);
			},
		});
	}
	
	function pairings_clear(id)
	{
		$.ajax({
			url: "tournaments/pairings_clear.php",	
			type: "POST",
			data: {'get_round_id':id},
			success: function(return_data){
				$('#content').html(return_data);
			},
		});
	}
	
	function confirm_delete(form)
	{
		post_data = {};
		form.forEach(function(item, index) {
			post_data[item.name] = item.value;
		});

		$.ajax({
			url: "tournaments/pairings_delete_confirmed.php",	
			type: "POST",
			data: post_data,
			success: function(return_data){
				$('#content').html(return_data);
			},
		});
	}
	
	function confirm_clear(form)
	{
		post_data = {};
		form.forEach(function(item, index) {
			post_data[item.name] = item.value;
		});

		$.ajax({
			url: "tournaments/pairings_clear_confirmed.php",	
			type: "POST",
			data: post_data,
			success: function(return_data){
				$('#content').html(return_data);
			},
		});
	}
	
	function generate(form)
	{
		post_data = {};
		form.forEach(function(item, index) {
			post_data[item.name] = item.value;
		});
		
		$.ajax({
			url: "tournaments/pairings_generate.php",	
			type: "POST",
			data: post_data,
			success: function(return_data){
				$('#content').html(return_data);
			},
		});
	}
	
	function add_round(form)
	{
		post_data = {};
		form.forEach(function(item, index) {
			post_data[item.name] = item.value;
		});
		
		$.ajax({
			url: "tournaments/round.php",	
			type: "POST",
			data: post_data,
			success: function(return_data){
				$('#content').html(return_data);
			},
		});
	}
</script>
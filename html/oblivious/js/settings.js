console.log('settings page');
//http://fabian-valle.com/code/oblivious/api/remove/categories/dimelo
//http://fabian-valle.com/code/oblivious/api/add/categories/dimelo
//execute callback when the page is ready:
$( document ).ready(function() {
// Handler for .ready() called.
	
	var oblivious_viewdata = {
		'categories':[],
		'removeCat':null
	};
	oblivious_viewdata.removeCat = function(){
		var cat = $(this).text();
		$.getJSON('/code/oblivious/api/remove/categories/'+cat+'/',function(data){
			$.getJSON('/code/oblivious/api/list/categories/',function(d){
				oblivious_viewdata.categories = d.Categories;
			});
		});
	};
	rivets.bind($('#oblivious_categorylist'), {
		viewdata: oblivious_viewdata
	});
	$.getJSON('/code/oblivious/api/list/categories/',function(data){
		oblivious_viewdata.categories = data.Categories;
	});
	
	$("#submit-category-button").on("click",function(){
		var cat = $("#new-category").val();
		console.log('cat',cat);
		$("#new-category").val('');
		$.getJSON('/code/oblivious/api/add/categories/'+cat+'/',function(data){
			$.getJSON('/code/oblivious/api/list/categories/',function(d){
				oblivious_viewdata.categories = d.Categories;
			});
		});
	});

	$("#remove-category-button").on("click",function(){
		var cat = $("#current-category").val();
		if(cat == '(choose a category)'){
			console.log('no category selected for deletion');
			return false;
		}
		$("#current-category").val('');
		$.getJSON('/code/oblivious/api/remove/categories/'+cat+'/',function(data){
			$.getJSON('/code/oblivious/api/list/categories/',function(d){
				oblivious_viewdata.categories = d.Categories;
			});
		});
	});
});
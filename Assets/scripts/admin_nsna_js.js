
(function($){

	$(document).ready(function(){

		$('.sid-nsna-addNewCatSubmit-pl3').click(function(e){
			e.preventDefault();
			var form = $(this).closest('form#nsna_admin_reg_form');
			var data_to_sent = {};
			data_to_sent['cat'] = form.find('#nsna_cat_pl3').val();
			data_to_sent['parent'] = form.find('#nsna_parentCat_pl3 option:selected').val();
			console.log(data_to_sent);
			var data = {
		    	action: 'sid_nsna_ajax_pl3',
		    	token: 'admin_add_category',
		   		data_sent: data_to_sent
		    };
		    console.log("before data_sent", data);
	    	$.post(MyAjax.ajaxurl, data, function(response){
				  	if(response.code == 200)
				  		location.reload();
				  	else
				  		alert(response.msg)
			},'json').responseJSON;
		});

		$('.del_cat_pl3').click(function(e){
			e.preventDefault();
			var self = $(this);
			self.text('Wait');
			var idd = {}
			idd['target'] = $(this).closest('tr').data('id');
			idd['level'] = $(this).closest('tr').data('cls');
			console.log(idd);
			var data = {
		    	action: 'sid_nsna_ajax_pl3',
		    	token: 'admin_del_category',
		   		data_sent: idd
		    };
		    console.log("before data_sent", data);
	    	$.post(MyAjax.ajaxurl, data, function(response){
				if(response.code == 200){
					location.reload();
				}
				else
				  	self.text('Failed');
			},'json').responseJSON;

		})
	})
	
})(jQuery);
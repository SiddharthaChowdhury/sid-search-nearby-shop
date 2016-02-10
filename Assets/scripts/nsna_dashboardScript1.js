(function($){


	function _(element){
		return document.getElementById(element);
	}

	function getExtension(filename) {
	    var parts = filename.split('.');
	    return parts[parts.length - 1];
	}

	function isImage(filename) {
	    var ext = getExtension(filename);
	    switch (ext.toLowerCase()) {
	    case 'jpg':
	    case 'gif':
	    case 'bmp':
	    case 'png':
	        return true;
	    }
	    return false;
	}

	_("uploadBtn").addEventListener("click", function(){ // on upload button pressed

		if( _('fileInput').value != "" ){
			$('#progress_bar').val(10);
			var file = _("fileInput").files[0];
			// alert(file.name+" | "+file.size+" | "+file.type);
			if( !isImage(file.name) ) // check if file is image
			{
				_("status").innerHTML = "File being uploaded is not an IMAGE with extension (jpg, png or bmp)";
				$('#progress_bar').val(0);
				return;
			}
			else{
				$('#progress_bar').val(30);

				var fd = new FormData();
			    fd.append("shopLogo", file); 
			    fd.append("caption", file.name);  
			    fd.append('action', 'sid_nsna_pl3_fuAjax'); 

			    $.ajax({
			        type: 'POST',
			        url: MyAjax.ajaxurl,
			        data: fd,
			        contentType: false,
			        processData: false,
			        success: function(response){
			        	$('#progress_bar').val(90);
			            console.log(response);
			        },
			        complete:function(xhr,status){
			        	$('#progress_bar').val(100);
			        }
			    });
			}
		}
		else
		{
			$('#progress_bar').val(0);
			_("status").innerHTML = "Please select an IMAGE.";
		}

	}); 

	_("fileInput").addEventListener("change", function(){ // on image selected
		if( isImage(this.files[0].name) )
		{
			var input = this;
			var img = _("imageDisplay");
			var reader = new FileReader();
			reader.onload = function(e){
				img.src = this.result;
			}
			reader.readAsDataURL(input.files[0]);
		}
	}); 

})(jQuery);

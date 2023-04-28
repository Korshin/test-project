$(document).ready(function(){
	function setQuantity(e){
		const valueQuantity = $(this).prev();
		const buttonType = $(e.target).data('set');
		const id = $(this).attr('id');
		const buttons = $('button');
		buttons.prop('disabled', true);
		$('.buttons-group').off('click', setQuantity);
		$.ajax({
			url: $(location).attr('href'),
			type: 'POST',
			data: {id: id, type: buttonType},
			success: function(data, statusText){
				switch(buttonType){
					case 'plus':
						valueQuantity.text(parseInt(valueQuantity.text()) + 1);
						break;
					case 'minus':
						if((parseInt(valueQuantity.text()) - 1) >= 0){
							valueQuantity.text(parseInt(valueQuantity.text()) - 1);
						}
						break;
				}
				buttons.prop('disabled', false);
				$('.buttons-group').on('click', setQuantity);
			},
			error: function(jqXHR, errMsg, errThrown){
				$('.page-error').text(jqXHR['responseText']);
				$('.page-error').fadeIn();
				setTimeout(function(){
					$('.page-error').fadeOut(function(){
						buttons.prop('disabled', false);
						$('.buttons-group').on('click', setQuantity);
					});
				}, 3000);
			}
		});
	}
	
	$('.buttons-group').on('click', setQuantity);
	
	$('.hide-product').on('click', function(e){
		const idButtonHide = $(this).data('product');
		const product = $(this).parent().parent();
		const buttons = $('button');
		buttons.prop('disabled', true);
		$('.buttons-group').off('click', setQuantity);
		$.ajax({
			url: $(location).attr('href'),
			type: 'POST',
			data: {hide: idButtonHide},
			success: function(data, statusText){
				product.fadeOut(function(){
					buttons.prop('disabled', false);
					$('.buttons-group').on('click', setQuantity);
				});
			},
			error: function(jqXHR, errMsg, errThrown){
				$('.page-error').text(jqXHR['responseText']);
				$('.page-error').fadeIn();
				setTimeout(function(){
					$('.page-error').fadeOut(function(){
						buttons.prop('disabled', false);
						$('.buttons-group').on('click', setQuantity);
					});
				}, 3000);
			}
		});
	});
});
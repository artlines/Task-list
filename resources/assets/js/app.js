
/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */

// window.Popper = require('popper.js').default;
// window.Vue = require('vue');

require('./bootstrap');
require('./taskItem');

let str;

$(function(){
	//поиск по задачам
	$('#searchTask').keyup(function(){
		str = $(this).val();
		setTimeout(function(){
			$.ajax({
		    type: "POST",
		    dataType : 'json',
		    url: '/searchTask',
		    data: {str: str},
		    beforeSend: function(xhr, type) {
		      xhr.setRequestHeader('X-CSRF-Token', $('meta[name="csrf-token"]').attr('content'));
		  	},
		    success: function(response) {
					$('#list').html(response.data);
				}
			});
		}, 500)
	});
});
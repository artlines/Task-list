
/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */

// window.Popper = require('popper.js').default;
require('./bootstrap');

// window.Vue = require('vue');

let taskId;
let str;
let localValue;

$(function(){

	//получить подробности задачи
	$('.task_item').click(function() {

		taskId = $(this).data('id');
		localValue = localStorage[taskId];

		if (typeof(localValue) == "undefined") {
			$.ajax({
		    type: "POST",
		    dataType : 'json',
		    url: '/getTaskOne',
		    data: {taskId: taskId},
		    beforeSend: function(xhr, type) {
		      xhr.setRequestHeader('X-CSRF-Token', $('meta[name="csrf-token"]').attr('content'));
		  	},
		    success: function(response) {
					localStorage[response.data['id']] = JSON.stringify(response.data);
					renderTask(response.data);
				}
			});
		}else{
			localValue = JSON.parse(localValue);
			renderTask(localValue);
		}
	});

	//поиск по задачам
	$('#searchTask').keyup(function(){
		str = $(this).val();
		if(str.length > 5){
			$.ajax({
		    type: "POST",
		    dataType : 'json',
		    url: '/searchTask',
		    data: {str: str},
		    beforeSend: function(xhr, type) {
		      xhr.setRequestHeader('X-CSRF-Token', $('meta[name="csrf-token"]').attr('content'));
		  	},
		    success: function(response) {
					$('#main').html(response.data);
				}
			});
		}
	});

});

function renderTask(data){
	$('.modal-body').empty();
	$('#taskModalTitle').text('Task № '+ data['id']);
  $.each(data, function(key, value){
  	$('.modal-body').append('<p><strong>'+ key +'</strong>: '+ value +'</p>');
  });
  $('#taskModal').modal('show');
} 


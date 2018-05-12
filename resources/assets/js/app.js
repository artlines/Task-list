
/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */

// window.Popper = require('popper.js').default;
require('./bootstrap');

// window.Vue = require('vue');

let taskId;
let storage = [];

$('.task_item').click(function() {
	taskId = $(this).data('id');

	$.ajax({
    type: "POST",
    dataType : 'json',
    url: '/getTaskOne',
    data: {taskId: taskId},
    beforeSend: function(xhr, type) {
      xhr.setRequestHeader('X-CSRF-Token', $('meta[name="csrf-token"]').attr('content'));
  	},
    success: function(data) {
      $("#taskOne").html(data.data);
      $('#taskModal').modal('toggle');
		}
	});

});

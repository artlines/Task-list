let renderTask = (data) => {
	$('.modal-body').empty();
	$('#taskModalTitle').text('Task № '+ data['id']);
  $.each(data, (key, value) => {
  	$('.modal-body').append('<p><strong>'+ key +'</strong>: '+ value +'</p>');
  });
  $('#taskModal').modal('show');
};

module.exports.taskItem = (taskId, localValue) => {
	if (typeof(localValue) == "undefined") {
		$.ajax({
	    type: "POST",
	    dataType : 'json',
	    url: '/getTaskOne',
	    data: {taskId: taskId},
	    beforeSend: (xhr, type)=> {
	      xhr.setRequestHeader('X-CSRF-Token', $('meta[name="csrf-token"]').attr('content'));
	  	},
	    success: (response) => {
				localStorage[response.data['id']] = JSON.stringify(response.data);
				renderTask(response.data);
			}
		});
	}else{
		localValue = JSON.parse(localValue);
		renderTask(localValue);
	}
};

module.exports.debounce = (fn, delay = 300) => {
	let timeoutID = null;
  
  return () => {
		clearTimeout(timeoutID);
    let args = arguments;
    let that = this;
    timeoutID = setTimeout(() => {
    	fn.apply(that, args);
    }, delay);
  }
};
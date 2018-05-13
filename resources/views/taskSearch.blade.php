<div class="row">
  <div class="col-md-12">
    <table class="table table-hover">
      <thead>
        <tr>
          <th scope="col">Номер задачи</th>
          <th scope="col">Заголовок</th>
          <th scope="col">Дата выполнения</th>
        </tr>
      </thead>
      <tbody>
        @foreach ($items as $item)
          <tr data-id="{{$item['id']}}" class="task_item">
            <th scope="row">{{$item['id']}}</th>
            <td>{{$item['title']}}</td>
            <td>{{$item['date']}}</td>
          </tr>
        @endforeach
      </tbody>
    </table>
  </div>
</div>
</div>
<script>
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
});

function renderTask(data){
  $('.modal-body').empty();
  $('#taskModalTitle').text('Task № '+ data['id']);
  $.each(data, function(key, value){
    $('.modal-body').append('<p><strong>'+ key +'</strong>: '+ value +'</p>');
  });
  $('#taskModal').modal('show');
} 


</script>
   
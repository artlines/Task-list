<!doctype html>
<html lang="{{ app()->getLocale() }}">
  <head>
    <meta charset="utf-8">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Tasks</title>
    <link href="/css/app.css" rel="stylesheet" type="text/css">
  </head>
  <body>
    <div class="container" id="main">
      <div class="row justify-content-md-center mt-3 mb-4">
        <div class="col-md-4 col-xs-12">
          <div class="form-group">
            <input type="text" class="form-control" id="searchTask" placeholder="Поиск" value="{{$str ?? ''}}">
          </div>
        </div>
      </div>
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
      <div class="row">
        <div class="col-md-12">
          {{ $items->links() }}
        </div>
      </div>
    </div>
    <!-- Task's modal -->
    <div id="taskOne">
      <div class="modal" id="taskModal" tabindex="-1" role="dialog" aria-labelledby="taskModalTitle" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
          <div class="modal-content">
            <div class="modal-header">
              <h5 class="modal-title" id="taskModalTitle"></h5>
              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
              </button>
            </div>
            <div class="modal-body">
            </div>
            <div class="modal-footer">
              <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
            </div>
          </div>
        </div>
      </div>
    </div>
    <script src="/js/app.js"></script>
  </body>
</html>

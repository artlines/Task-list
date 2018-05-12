<!doctype html>
<html lang="{{ app()->getLocale() }}">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Tasks</title>
    <link href="/css/app.css" rel="stylesheet" type="text/css">
  </head>
  <body>
    <div class="container">
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
    </div>
  </body>
</html>

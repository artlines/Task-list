<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Illuminate\Pagination\LengthAwarePaginator as Paginator;

class TaskController extends Controller
{
  const TASK_QUANTITY = 1000;
  const TASK_PAGE_QUANTITY = 10;
  const TASKS_CACHE_FIELD = 'tasks';
  const CACHE_EXPIRE_TIME = 60;

  public function __invoke(Request $request)
  {

    $page = $request->get('page', 1);
    $perPage = self::TASK_PAGE_QUANTITY;
    $tasks = $this->getTasks();
    $offset = ($page - 1) * $perPage;
    $items =  new Paginator(
      array_slice($tasks, $offset, self::TASK_PAGE_QUANTITY), 
      count($tasks), 
      $perPage, 
      $page,
      ['class' => 'justify-content-center']
    );

    return view('task', [
      'items' => $items
    ]);
  }

  public function getTasks($allFields = false, $id = 0): array
  {
    $fieldsToShow = ['id' => '', 'title' => '', 'date' => ''];
    $tasks = $this->getRawTasks();

    if ($allFields === false) {
      foreach ($tasks as $key => $task) {
        $tasks[$key] = array_intersect_key($task, $fieldsToShow);
      }
    }

    return $id > 0 ? $tasks[$id] : $tasks;
  }

  public function getTaskById(Request $request, $id): array
  {
    return $this->getTasks(true, $id);
  }

  public function getRawTasks()
  {
    if (Cache::has(self::TASKS_CACHE_FIELD)) {
      return Cache::get(self::TASKS_CACHE_FIELD);
    }

    return $this->generateTasks();
  }

  public function renderTaskOne(Request $request): array
  {
    $taskId = $request->taskId;
    $taskInfo = $this->getTaskById($request, $taskId);

    return ['success' => true, 'data' => $taskInfo];
  }

  public function searchTask(Request $request): array
  {
    //@todo не слетающая пагинация у результатов поиска, в бэльюхе такое было
    //при пустом результате отображаются все записи
    //сделать вьюху универсальной или разделить их
    //а может быть в пагинацию можно передать строку поиска?
    //и проверить что найденные задачи жмякаются
    //и подрефакторить этот метод
    
    $str = $request->str;
    $page = $request->get('page', 1);
    $perPage = self::TASK_PAGE_QUANTITY;
    $tasks = $this->getTasks();
    $offset = ($page - 1) * $perPage;
    $result = [];

    foreach ($tasks as $key => $task) {
      if (substr_count($task['title'], $str) > 0) {
        $result[$key] = $task;
      }
    }
    $items =  new Paginator(
      array_slice($result, $offset, self::TASK_PAGE_QUANTITY), 
      count($result), 
      $perPage, 
      $page,
      ['class' => 'justify-content-center']
    );

    $data = view('task', [
      'items' => $items,
      'str' => $str
    ])->render();

    return ['success' => true, 'data' => $data];
  }

  private function generateTasks()
  {
    $tasks = [];
    for ($i=0; $i++ < self::TASK_QUANTITY;) { 
      $tasks[$i] = [
        'id' => $i,
        'title' => 'Task '. $i,
        'date' => date('d.m.Y - H:i:s', strtotime("+$i hour")),
        'author' => 'author '. $i,
        'status' => 'status '. $i,
        'description' => 'description '. $i,
      ];
    }

    $expire = now()->addMinutes(self::CACHE_EXPIRE_TIME);
    Cache::put(self::TASKS_CACHE_FIELD, $tasks, $expire);

    return $tasks;
  }

}

<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Illuminate\Pagination\LengthAwarePaginator as Paginator;

class TaskController extends Controller
{
  const TASK_QUANTITY = 1001;
  const TASKS_CACHE_FIELD = 'tasks';
  const CACHE_EXPIRE_TIME = 60;
  private $fieldsToShow = ['id' => '', 'title' => '', 'date' => ''];

  public function __invoke(Request $request)
  {

    $page = $request->get('page', 1);
    $perPage = 10;
    $tasks = $this->getTasks();
    $offset = ($page - 1) * $perPage;
    $items =  new Paginator(
      array_slice($tasks, $offset, 10), 
      count($tasks), 
      $perPage, 
      $page
    );

    return view('task', [
        'items' => $items
    ]);
  }

  /**
   * Return an array of the tasks.
   *
   * @return array
   */
  public function getTasks($allFields = false): array
  {
    $tasks = $this->getRawTasks();

    if ($allFields === false) {
      foreach ($tasks as $key => $task) {
        $tasks[$key] = array_intersect_key($task, $this->fieldsToShow);
      }
    }

    return $tasks;
  }

  public function getTaskById(Request $request, $id): array
  {
    $tasks = $this->getTasks(true);

    return $tasks[$id];
  }

  public function searchTasks(Request $request): array
  {
    $tasks = $this->getTasks(true);

    return $tasks;
  }

  public function getRawTasks()
  {
    if (Cache::has(self::TASKS_CACHE_FIELD)) {
      return Cache::get(self::TASKS_CACHE_FIELD);
    }

    return $this->generateTasks();
  }

  public function renderTaskOne(Request $request)
  {
    $taskId = $request->taskId;
    $taskInfo = $this->getTaskById($request, $taskId);

    return ['success' => true, 'data' => $taskInfo];
  }

  private function generateTasks()
  {
    $tasks = [];
    for ($i=1; $i < self::TASK_QUANTITY; $i++) { 
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

<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;

class TaskController extends Controller
{
  const TASK_QUANTITY = 1001;
  const TASKS_CACHE_FIELD = 'tasks';
  const CACHE_EXPIRE_TIME = 60;
  private $fieldsToShow = ['id' => '', 'title' => '', 'date' => ''];

  /**
   * Return an array of the tasks.
   *
   * @return array
   */
  public function getTasks($allFields = false): array
  {
    if (Cache::has(self::TASKS_CACHE_FIELD)) {
      $tasks = Cache::get(self::TASKS_CACHE_FIELD);
    }else{
      $tasks = $this->generateTasks();
    }

    if ($allFields === false) {
      foreach ($tasks as $key => $task) {
        $tasks[$key] = array_intersect_key($task, $this->fieldsToShow);
      }
    }

    return $tasks;
  }

  public function getTaskById(Request $request, $id)
  {
    $tasks = $this->getTasks(true);

    return $tasks[$id];
  }

  public function renderTasks(Request $request)
  {
    return view('task');
  }

  public function renderTaskOne(Request $request)
  {
    return view('task');
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

<?php

namespace App\Controllers;

use App\Entities\Task;
use JasonGrimes\Paginator;

class TaskController {

    protected $taskEntity;

    public function __construct()
    {
        $this->taskEntity = new Task();
    }

    public function getTasks()
    {
        $pageNumb       = $_GET['page'] ? intval($_GET['page']) : 1;
        $order          = $this->getTasksOrderByRequest($_GET['sort']);
        $orderDirection = $this->getOrderDirection();

        $tasks         = $this->taskEntity->getTasks($pageNumb, $order, $orderDirection);
        $paginator     = $this->getTasksPaginator($pageNumb);
        $isAdmin       = $_SESSION['admin'];
        $successAddMsg = $_SESSION['success_add'];

        unset($_SESSION['success_add']);

        require __DIR__ . '/../assets/views/tasks.php';
    }

    public function addTask()
    {
        $fields['user_name'] = $this->prepareTaskField($_POST['user_name']);
        $fields['email']     = $this->prepareTaskField($_POST['email']);
        $fields['text']      = $this->prepareTaskField($_POST['text']);

        $this->taskEntity->addTask($fields);
        $_SESSION['success_add'] = true;

        header('Location: /');
    }

    public function updateTask()
    {
        if (!$_SESSION['admin']) {
            header('Location: /');
            return;
        }

        $text = $this->prepareTaskField($_POST['text']);
        $done = $_POST['done'] ?? 0;

        $this->taskEntity->updateTask($_POST['id'], $text, $done);

        header('Location: /?' . $_POST['query_string']);
    }

    protected function getOrderDirection()
    {
        if (!$_GET['sort']) {
            return 'desc';
        }

        return $_GET['direction'] == 'desc' ? 'desc' : false;
    }

    //В реальном приложении вынес бы нижестоящие методы в сервис

    /**
     * @param int $page
     * @return Paginator
     */
    protected function getTasksPaginator($page)
    {
        $queryStr = removeQueryStringVar('page', false);
        
        $urlPattern   = $queryStr ? $queryStr . '&page=(:num)' : '?page=(:num)';
        $totalItems   = $this->taskEntity->allTasksCount();
        $itemsPerPage = 3;

        return new Paginator($totalItems, $itemsPerPage, $page, $urlPattern);
    }

    /**
     * @param string $orderDirty
     * @return string
     */
    protected function getTasksOrderByRequest($orderDirty)
    {
        if (!$orderDirty) {
            return 'id';
        }

        $orders = ["user_name", "email", "done"];
        $key    = array_search($orderDirty, $orders);

        return $orders[$key];
    }

    protected function prepareTaskField($field)
    {
        return strip_tags(trim($field));
    }
}
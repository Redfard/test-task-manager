<?php

namespace App\Entities;

use App\Database;


class Task {

    protected $db;

    public function __construct()
    {
        $this->db = Database::getInstance()->getConnection();
    }

    /**
     * @param int $pageNumb
     * @param string $order
     * @return array|null
     */
    public function getTasks($pageNumb, $order, $orderDirection)
    {
        $start = abs(($pageNumb - 1) * 3);
        $sql = "SELECT * FROM Tasks ORDER BY $order $orderDirection LIMIT $start, 3";

        return mysqli_fetch_all($this->db->query($sql), MYSQLI_ASSOC);
    }

    /**
     * @return string
     */
    public function allTasksCount()
    {
        $sql = "SELECT COUNT(*) FROM Tasks";

        return mysqli_fetch_row($this->db->query($sql))[0];
    }

    /**
     * @param array $fields
     */
    public function addTask($fields)
    {
        $sql = "INSERT INTO Tasks (user_name, email, text) VALUES (?, ?, ?)";

        $stmt = $this->db->prepare($sql);
        $stmt->bind_param("sss", $fields['user_name'], $fields['email'], $fields['text']);
        $stmt->execute();
    }

    /**
     * @param int $id
     * @param string $text
     * @param int $done
     */
    public function updateTask($id, $text, $done)
    {
        $sql = "UPDATE Tasks SET text = ?, done = ?, edited = 1 WHERE id = ?";

        $stmt = $this->db->prepare($sql);
        $stmt->bind_param("sii", $text, $done, $id);
        $stmt->execute();
    }
}
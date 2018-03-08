<?php
require_once './routines.php';
class Task 
{
	private $id;
	private $description;
	private $userId;
	private $assignieId;
	private $isDone;
	private $createdDate;

	public function __construct ($description = null, $userId = null)
	{
		$this->description = $description;
		$this->userId = $userId;
		$this->assignieId = $userId;
	}

	public function getById ($id)
	{
		try {
	    	$pdo = new PDO("mysql:host=$dbHost;dbname=$dbName", $dbUser, $dbPass);
		} catch (PDOException $e) {
	    	echo 'Подключение не удалось: ' . $e->getMessage();
		}

		$sql = "SELECT * FROM `task` WHERE `id`=".$id;
		$data = $pdo->query($sql);
		if ($data) {
			foreach ($data as $task) {
				$this->id = $task['id'];
				$this->userId = $task['user_id'];
				$this->assignieId = $task['assigned_user_id'];
				$this->description = $task['description'];
				$this->isDone = $task['is_done'];
				$this->createdDate = $task['date_added'];
			}
		}
	}
}
?>

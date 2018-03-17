<?php
class Dashboard
{
	private $sqlQuery;
	private $tasks;

	public function __construct($sql)
	{
		$this->sqlQuery = $sql;  //like "SELECT task.*, reporter.login AS rlogin, assignie.login AS alogin FROM task INNER JOIN user AS reporter ON task.user_id=reporter.id INNER JOIN user AS assignie ON task.assigned_user_id=assignie.id WHERE task.user_id=".$user->getId( ).sort2order($sort1)
		require './db.php';
		try {
	    	$pdo = new PDO("mysql:host=$dbHost;dbname=$dbName", $dbUser, $dbPass);
		} catch (PDOException $e) {
	    	echo 'Подключение не удалось: ' . $e->getMessage();
		}
		$data = $pdo->query($sql);
		if ($data) {
			$this->tasks = array();
			foreach ($data as $row) {
				$this->tasks[] = new Task($row['id'], $row['description'], $row['rlogin'], $row['alogin'], $row['is_done'], $row['date_added']);
			}
		}
		return false;
	}

	public function printDashboard()
	{
		echo '<table>
				<tr>
					<th>id</th>
					<th><a href="index.php?sort1=desc">Описание</a></th>
					<th><a href="index.php?sort1=status">Статус</a></th>
					<th><a href="index.php?sort1=date">Дата добавления</a></th>
					<th>Автор</th>
					<th>Исполнитель</th>
					<th colspan="4">Действия</th>
				</tr>';
		foreach ($this->tasks as $task) {
			$task->printTaskForDashboard();
		}
		echo '</table>';
	}
}
?>

<?php
require_once './routines.php';
class Task 
{
	private $id;
	private $description;
	private $userId;
	private $assignieId;
	private $status;
	private $createdDate;

	public function __construct ($id = null, $description = null, $reporter = null, $assignie = null, $status = null, $date = null)
	{
		$this->id = $id;
		$this->description = $description;
		$this->reporter = $reporter;
		$this->assignie = $assignie;
		$this->status = $status;
		$this->createdDate = $date;
	}

	public function printTaskForDashboard()
	{
		if ($this->status==0) {
			$status = '<span style="color: red;">Не выполнено</span>';
			$workflow = "<a href='done.php?id=$this->id'>Выполнено</a>";
		}
		else {
			$status = '<span style="color: green;">Выполнено</span>';
			$workflow = "<a href='reopen.php?id=$this->id'>Открыть заново</a>";
		}
		echo "<tr>
				<td>$this->id</td>
				<td>$this->description</td>
				<td>$status</td>
				<td>$this->createdDate</td>
				<td>$this->reporter</td>
				<td>$this->assignie</td>
				<td>$workflow</td>
				<td><a href='edit.php?id=$this->id'>Редактировать</a></td>
				<td><a href='assign.php?id=$this->id'>Назначить</a></td>
				<td><a href='delete.php?id=$this->id'>Удалить</a></td>
			</tr>";
	}
}
?>

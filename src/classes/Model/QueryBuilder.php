<?php

namespace M151\Model;

abstract class QueryBuilder 
{
	protected $conn = null;

	public function __construct(\PDO $connection) 
	{
		$this->conn = $connection;
	}

	/**
	 * Liefert den SQL-Tabellenname als String.
	 * Muss von Kindklassen implementiert werden.
	 */
	abstract public function getTable();

	/**
	 * Liefert die Spalten der Tabelle mit den Datentypen dazu
	 * (array(spaltenname => typ))
	 * Muss von Kindklassen implementiert werden.
	 */
	abstract public function getColumns();

	/**
	 * Holt einen Datensatz nach ID
	 */
	public function get($id) 
	{
		$filter = "id = {$id}";
		$res = $this->query($filter);
		if ($res) {
			return $res[0];
		} else return null;
	}

	/**
	 * Holt mehrere Datensätze by SQL-WHERE-Filter.
	 * @param string $filter Der SQL-WHERE-Filter, z.B. "name = 'Foo' and vorname like 'A%'"
	 * @param string orderBy SQL-Sortierreihenfolge, z.B. "name,vorname DESC";
	 */
	public function query($filter,$orderBy = null) 
	{
		$table = $this->getTable();
		$props = $this->getColumns();
		$proplist = $this->buildColumnList($props);

		$orderBy = strlen($orderBy) > 0 ? "ORDER BY {$orderBy}" : '';

		$query = "SELECT {$proplist} FROM {$table} WHERE {$filter} {$orderBy}";
		var_dump($query);
		return $this->conn->query($query)->fetchAll(\PDO::FETCH_ASSOC);
	}

	/**
	 * holt ALLE Datensätze einer Tabelle, sortiert nach wunsch
	 */
	public function getAll($order = null)
	 {
		return $this->query("1=1",$order);
	}

	public function save($id, $data) 
	{
		//TODO
	}

	public function delete($id)
	{
		//TODO
	}

	protected function buildColumnList($cols) 
	{
		$colnames = array_keys($cols);
		return join(',',$colnames);
	}
}

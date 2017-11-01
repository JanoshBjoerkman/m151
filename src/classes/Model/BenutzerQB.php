<?php
namespace M151\Model;

class BenutzerQB extends QueryBuilder {

	public function getTable() {
		return 'benutzer';
	}

	/**
	 * Liefert die Spalten der Tabelle mit den Datentypen dazu
	 * (array(spaltenname => typ))
	 */
	public function getColumns() {
		return array(
			'id' => 'int',
			'login' => 'string',
			'passwort' => 'string',
			'name' => 'string',
			'vorname' => 'string',
			'email' => 'string',
			'letzter_login' => 'timestamp'
		);
	}

	public function getAktiveBenutzer() {
		return $this->query("letzter_login >= NOW() - INTERVAL 1 MONTH");
	}
}

<?php
require_once $dimport["db/db_conn.php"]["path"];

$record_add = function($table, $attrs) use ($conn) {
	$cols_str = ""; $cols_temp = "";
	foreach ($attrs as $col => $val) {
		$cols_str .= ", $col"; $cols_temp .= ", ?";
		$vals[] = $val;
	}
	$cols_str   = substr($cols_str, 2, strlen($cols_str));
	$cols_temp  = substr($cols_temp, 2, strlen($cols_temp));

	$sql = "INSERT INTO $table ($cols_str) VALUES ($cols_temp);";
	$sth = $conn->prepare($sql);
	$sth->execute($vals);
};

$records_delete = function($table, $id_col, $id_val) use ($conn) {
	$sql = "DELETE FROM $table WHERE $id_col = ?;";
	$sth = $conn->prepare($sql);
	$sth->execute([$id_val]);
};

$records_edit = function($table, $id_col, $id_val, $attrs) use ($conn) {
	$cols_temp = "";
	foreach ($attrs as $col => $val) {
		$cols_temp .= ", $col = ?"; $vals[] = $val;
	}
	$vals[] 		= $id_val;
	$cols_temp  = substr($cols_temp, 2, strlen($cols_temp));

	$sql = "UPDATE $table SET $cols_temp WHERE $id_col = ?;";
	$sth = $conn->prepare($sql);
	$sth->execute($vals);
};

$records_get = function($table, $id_col, $id_val) use ($conn) {
	$sql = "SELECT * FROM $table WHERE $id_col = ?;";
	$sth = $conn->prepare($sql);
	$sth->execute([$id_val]);
	return $sth->fetchAll();
};

$sql_query = function($query, $temps=[]) use ($conn) {
	$sth = $conn->prepare($query);
	$sth->execute($temps);

	if (explode(" ", $query)[0] == "SELECT")
		return $sth->fetchAll();
};

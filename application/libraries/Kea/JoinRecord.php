<?php

/**
 * Special derivative class to ensure unique entries in the join table
 *
 * @package Omeka
 * @author Kris Kelly
 **/
abstract class Kea_JoinRecord extends Kea_Record
{
	
	/**
	 * Determine the uniqueness of a join table record based on the combination of its relational indices
	 *
	 * @return bool
	 **/
	public function isUnique() {
		$columns = $this->getTable()->getColumns();
		$where = array();
		foreach( $columns as $key => $column )
		{
			if( $column[0] == 'integer' && !isset($column[2]['autoincrement']) ) {
				$where[$key]= "$key = {$this->$key} ";
			}
		}
		$result = $this->getTable()->findBySql( implode(' AND ', $where) )->getFirst();
		return (!$result || ($result->obtainIdentifier() != $this->obtainIdentifier()));
	}
} // END class Kea_JoinRecord extends Kea_Record

?>
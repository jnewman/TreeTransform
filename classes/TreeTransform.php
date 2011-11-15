<?php

class TreeTransform{
	/**
	 * Ported from the answer to this StackOverflow question:
	 * http://goo.gl/J60wf
	 * @todo This really should be a static class.
	 *
	 * @param: String $table_name is the name of the table to be converted.
	 *
	 * A simple adjacency list to nested set conversion class.
	 * Takes an existing adjacency list table and writes the necessary `lft`
	 * and `rht` values to store a nested set. In order to speed development,
	 * this class makes a few radical assumptions:
	 *
	 * 1. RedBean is configured to use the R facade. See: http://redbeanphp.com
	 * for details.
	 *
	 * 2. The targeted TABLE contains a properly formed adjacency list with
	 * `parent` being the column name of the self-join foreign key.
	 *
	 * 3. TABLE contains two, otherwise unused, integer columns named `lft`
	 * and `rht` (e.g., table contains contains, at least, these fields:
	 CREATE TABLE IF NOT EXISTS `adjacency_nested_combo` (
	 `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
	 `parent` int(11) unsigned DEFAULT NULL,
	 `lft` int(10) unsigned NOT NULL,
	 `rht` int(10) unsigned NOT NULL,
	 PRIMARY KEY (`id`)
	 ) ENGINE=InnoDB  DEFAULT CHARSET=utf8;
	 * ).
	 */
	private $table = '';
	private $counter;

	public function __construct($table_name){
		$this->table_name = $table_name;
		$this->counter = 1;
		$this->links = $this->linked_rows();
	}

	public function traverse($id){
		$lft = $this->counter;
		$this->counter++;
		$children = $this->get_children($id);
		if($children){
			foreach($children as $child){
				$this->traverse($child);
			}
		}
		$rht = $this->counter;
		$this->counter++;
		$this->write($lft, $rht, $id);
	}

	private function get_children($id){
		return $this->links[$id];
	}
	
	private function write($lft, $rht, $id){
		$source = R::load($this->table_name, $id);
		$source->lft = $lft;
		$source->rht = $rht;
		R::store($source);
	}

	private function linked_rows(){
		$linked_rows = array();
		foreach($this->rows() as $row){
			$parent = $row['parent'];
			$child = $row['id'];
			if(!array_key_exists($parent, $linked_rows)){
				$linked_rows[$parent] = array();
			}
			$linked_rows[$parent][] = $child;
		}
		return $linked_rows;
	}

	private function rows(){
		return R::getAll(sprintf("
                    SELECT `id`, `parent`
                    FROM `%s`
                    WHERE 1 
                ", $this->table_name
		));
	}
}

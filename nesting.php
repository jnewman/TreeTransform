<?php error_reporting(E_ALL);ini_set('display_errors', true); ?>
<?php
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
	 
     * ). The real beauty of using both a parent field and lft/rht is that I 
     * don't have to care what else is in your table.
	 */    
    include "./classes/RedBean.php";
    include "./config/config.php";
    include "./classes/TreeTransform.php";
?>
<pre><?php
    R::freeze();
    R::debug(true);
    $tree = new TreeTransform("adjacency_nested_combo");
    $tree->traverse(1);
?></pre>


<h1>TreeTransform</h1>
<p>
    Here is the TreeTransform <em>package</em>. Really it's just a 
class and a quick example. 
Ported from the answer to this StackOverflow question:
     <a href="http://goo.gl/J60wf">http://goo.gl/J60wf</a>
Here are my ridiculous assumptions:
<ol>
    <li>
    <a href="http://redbeanphp.com">RedBeanPHP</a> is configured to use the R facade.
    </li>
    <li>
       The targeted TABLE contains a properly formed adjacency list with `parent` being the column name of the self-join foreign key.            
    </li>
    <li>
    TABLE contains two, otherwise unused, integer columns named `lft`
     * and `rht` (e.g., table contains contains, at least, these fields:
     
 <pre><code>
 CREATE TABLE IF NOT EXISTS `adjacency_nested_combo` (
         `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
         `parent` int(11) unsigned DEFAULT NULL,
         `lft` int(10) unsigned NOT NULL,
         `rht` int(10) unsigned NOT NULL,
     PRIMARY KEY (`id`)
     ) ENGINE=InnoDB  DEFAULT CHARSET=utf8;
 </code></pre>
    </li>
</ol>
</p>
<p>
If you want to try it out just do the following:
<ol>
    <li>Create a database and fill with the example data.</li>
    <li>Configure ./config/config.php (you need your password and databasename).</li>
</ol>
</p>
Hope this turns out to be useful.

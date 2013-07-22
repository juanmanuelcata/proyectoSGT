<?php
function conectaDb()
{
    try {
        $db = new PDO("mysql:host=localhost;dbname=sgt-proyecto", "root", "1234");
        $db->setAttribute(PDO::MYSQL_ATTR_USE_BUFFERED_QUERY, TRUE);
        return($db);
    } catch (PDOException $e) {
        print "<p>Error: No puede conectarse con la base de datos.</p>\n";
        exit();
    }
}
?>

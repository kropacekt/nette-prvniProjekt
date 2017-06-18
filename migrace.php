<?php
/**
 * Created by PhpStorm.
 * User: Tomáš Kropáček
 * Date: 16.06.2017
 * Time: 17:04
 */

//pripojeni k dtb

$sqls = [];
$sqls[] = "ALTER TABLE projekt MODIFY webovy_projekt TINYINT(1) NOT NULL";

/*foreach ($sqls as $sql) {

}*/
<?php
/**
 * Created by PhpStorm.
 * User: Tomáš Kropáček
 * Date: 21.06.2017
 * Time: 14:31
 */

namespace App\Model;

use Nette;

class UzivatelManager
{
    private $database;

    public function __construct(Nette\Database\Context $database)
    {
        $this->database = $database;
    }

    public function getUzivatelAll() {
        return $this->database
            ->table('uzivatel')
            ->order('id');
    }

    public function getUzivatelAllCount() {
        return intval($this->database
            ->table('uzivatel')
            ->order('id')
            ->count()
        );
    }
}
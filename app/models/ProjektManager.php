<?php

/**
 * Created by PhpStorm.
 * User: Tomáš Kropáček
 * Date: 18.06.2017
 * Time: 19:05
 */

namespace App\Model;

use Nette;

class ProjektManager
{

    private $database;

    public function __construct(Nette\Database\Context $database)
    {
        $this->database = $database;
    }

    public function getProjekt($id)
    {
        $p = $this->database
            ->table('projekt')
            ->get($id);

        $projekt = $p->toArray();
        $projekt['datum_odevzdani'] = $projekt['datum_odevzdani']->format('Y-m-d');

        return $projekt;
    }

    public function getProjektAll()
    {
        return $this->database
            ->table('projekt');
    }

    public function getIdProjektLast()
    {
        return $this->database
            ->table("projekt")
            ->max("id");
    }

    public function pridatProjekt($values)
    {
        $this->database
            ->table('projekt')
            ->insert($values);
    }

    public function editovatProjekt($id, $values)
    {
        $this->database
            ->table('projekt')
            ->where("id=?", $id)
            ->update($values);
    }

    public function smazatProjekt($id)
    {
        $this->database
            ->table('projekt')
            ->where('id=?', $id)
            ->delete();
    }
}
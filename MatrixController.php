<?php

require_once 'config.php';
require_once 'DataBase_helper_class.php';

class MatrixController
{
    private $mysqli;

    public function __construct($mysqli)
    {
        $this->mysqli = $mysqli;
    }

    public function createMatrix($rows, $cols)
    {
        $matrix = new DataBase_helper_class($this->mysqli);
        $matrix->create($rows, $cols);
    }

    public function listMatrixes()
    {
        return DataBase_helper_class::getAllName($this->mysqli);
    }

    public function showMatrix($id)
    {
        $matrix = new DataBase_helper_class($this->mysqli, $id);
        $matrix->display();
    }
}
?>

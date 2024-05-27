<?php



class DataBase_helper_class
{
    private $mysqli;
    private $id;
    private $rows;
    private $cols;

    public function __construct($mysqli, $id = null)
    {
        $this->mysqli = $mysqli;
        if ($id) {
            $this->id = $id;
            $this->load();
        }
    }

    public function create($rows, $cols)
    {
        $this->rows = $rows;
        $this->cols = $cols;
        $this->save();
    }
    private function save()
    {
        $stmt = $this->mysqli->prepare('INSERT INTO matrixes (rows, cols) VALUES (?, ?)');
        $stmt->bind_param('ii', $this->rows, $this->cols);
        $stmt->execute();

        $this->id = $stmt->insert_id;

        $stmt = $this->mysqli->prepare('INSERT INTO matrixes_elements (matrix_id, row_index, col_index, value) VALUES (?, ?, ?, ?)');
        for ($i = 0; $i < $this->rows; $i++) {
            for ($j = 0; $j < $this->cols; $j++) {
                $stmt->bind_param('iiii', $this->id, $i, $j, rand(1, 50));
                $stmt->execute();
            }
        }
    }

    private function load()
    {
        $stmt = $this->mysqli->prepare('SELECT * FROM matrixes WHERE id = ?');
        $stmt->bind_param('i', $this->id);
        $stmt->execute();
        $result = $stmt->get_result();
        $matrix = $result->fetch_assoc();

        if ($matrix) {
            $this->rows = $matrix['rows'];
            $this->cols = $matrix['cols'];
        }
    }

    public static function getAllName($mysqli)
    {
        $result = $mysqli->query('SELECT * FROM matrixes');
        return $result->fetch_all(MYSQLI_ASSOC);
    }

    public function display()
    {
        $stmt = $this->mysqli->prepare('SELECT * FROM matrixes_elements WHERE matrix_id = ? ORDER BY row_index, col_index');
        $stmt->bind_param('i', $this->id);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows > 0) {
            echo '<table border="1">';
            $row_index = -1;
            while ($row = $result->fetch_assoc()) {
                if ($row['row_index'] != $row_index) {
                    if ($row_index != -1) {
                        echo '</tr>';
                    }
                    echo '<tr>';
                    $row_index = $row['row_index'];
                }
                echo '<td>' . $row['value'] . '</td>';
            }
            echo '</table>';
        } else {
            echo 'Matrix is пустая((((.';
        }
    }
}
?>

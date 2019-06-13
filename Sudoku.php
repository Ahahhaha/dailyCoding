<?php

class Sudoku
{
    private $sudoku = [];
    public function __construct(array $sudoku = [])
    {
        if (count($sudoku) != 81) {
            return false;
        }

        $this->createSudoku($sudoku);
        return true;
    }

    public function createSudoku($sudoku)
    {
        $column = $row = 1;
        $sudoku = is_array($sudoku) ? $sudoku : explode(",", $sudoku);


        while ($sudoku) {
            if ($column <= 9) {
                $this->sudoku[$row][$column] = array_shift($sudoku);
                if ($column == 9) {
                    $column = 1;
                    $row++;
                } else {
                    $column ++;
                }
            }
        }

//        while ($sudoku) {
//            if ($column <= 9) {
//                $box = ceil($column / 3);
//                $sort = $column % 3;
//                $sort = $sort != 0 ? $sort : 3;
//                switch ($row) {
//                    case 1:
//                    case 2:
//                    case 3:
//                        $key = $sort + (($row -1) * 3);
//                        $name = "N" . $box;
//                        break;
//                    case 4:
//                    case 5:
//                    case 6:
//                        $key = $sort + (($row -4) * 3);
//                        $key = $sort + 6;
//                        $name = "N" . ($box + 3);
//                        break;
//                    case 7:
//                        $key = $sort;
//                        $name = "N" . ($box + 6);
//                        break;
//                    case 8:
//                        $key = $sort + 3;
//                        $name = "N" . ($box + 6);
//                        break;
//                    case 9:
//                        $key = $sort + 6;
//                        $name = "N" . ($box + 6);
//                        break;
//                }
//                if ($column == 9) {
//                    $column = 1;
//                    $row++;
//                } else {
//                    $column ++;
//                }
//            }
//            $this->sudoku[$name][$key] = array_shift($sudoku);
//        }
    }

    public function getSudoku()
    {
        $this->showSudoku($this->sudoku);
    }

    public function getNumber($sudoku, $row, $column)
    {
        $numArray = [];
        $array = [1,2,3,4,5,6,7,8,9];
        foreach ($sudoku[$row] as $k => $v) {
            $numArray[] = $v;
        }

        for ($i = 1; $i <= 9; $i++) {
            $numArray[] = $sudoku[$i][$column];
        }
        $row1 = (ceil($row / 3) - 1) * 3 + 1;
        $column1 = (ceil($column / 3) - 1) * 3 + 1;

        for ($i = 1; $i <= 9; $i++) {
            $numArray[] = $sudoku[$row1][$column1];
            if ($i % 3 == 0) {
                $row1 = $row1 + 1;
                $column1 = (ceil($column / 3) - 1) * 3 + 1;
            } else {
                $column1 ++;
            }
        }
        $diffArray = array_diff($array, $numArray);

        return !empty($diffArray) ? $diffArray : [];
    }

    public function resolve(array $sudoku = [])
    {
        $sudoku = empty($sudoku) ? $this->sudoku : $sudoku;
        $resolve = [];
        foreach ($sudoku as $key => $val) {
            foreach ($val as $k => $v) {
                if ($v == 0) {
                    $numArray = $this->getNumber($sudoku, $key, $k);

                    if (empty($numArray)) {
                        return false;
                    } else {
                        while (!empty($numArray)) {
                            $sudoku[$key][$k] = array_shift($numArray);
                            $resolve = $this->resolve($sudoku);
                            if ($resolve != false) {
                                $sudoku = $resolve;
                                break;
                            } else {
                                continue;
                            }
                        }
                        return $resolve === false ? false : $sudoku;
                    }
                }
            }
        }
    }

    public function showSudoku(array $sudoku = [])
    {
        $sudoku = !empty($sudoku) ? $sudoku : $this->resolve();
        echo "<div style='padding: 5px;border: 1px solid black;width: 500px;overflow: hidden;height: 500px;'>";
        foreach ($sudoku as $key => $val) {
            foreach ($val as $k => $v) {
                echo "<div style='border: 1px solid black;width: calc(96% / 9);height: calc(96% / 9);float: left;'>
                        {$v}
                    </div>";
            }
        }
        echo "</div><br>";
    }
}

//$sudoku = [
//    3, 2, 7, 0, 0, 6, 0, 0, 9,
//    0, 0, 0, 7, 4, 0, 0, 0, 6,
//    0, 0, 0, 2, 0, 8, 0, 0, 3,
//    5, 0, 2, 0, 0, 0, 4, 6, 0,
//    0, 8, 0, 0, 0, 0, 0, 1, 0,
//    0, 7, 4, 0, 0, 0, 3, 0, 8,
//    7, 0, 0, 4, 0, 2, 0, 0, 0,
//    1, 0, 0, 0, 8, 5, 0, 0, 0,
//    2, 0, 0, 9, 0, 0, 6, 8, 4
//];




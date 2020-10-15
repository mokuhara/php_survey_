<?php
class File
{
    private $_path;
    public $type;

    function __construct()
    {
        $this->_path = "/Applications/MAMP/htdocs/php_kadai_01/data/data.csv";
        $this->type = "mysql";
    }

    public function save($name, $email, $favorite)
    {
        $ary = array($name, $email, $favorite);
        $file = fopen($this->_path, "a");
        if ($file) {
            fputcsv($file, $ary);
        }
        fclose($file);
    }

    public function read()
    {
        $row = 1;
        if (($file = fopen($this->_path, "r")) !== FALSE) {
            $prog = [];
            while (($row = fgetcsv($file))) {
                // $arr = explode(",", $row);
                if (!array_key_exists($row[2], $prog)) {
                    $prog[$row[2]] = 0;
                } else {
                    $prog[$row[2]] = ++$prog[$row[2]];
                }
            }
            $result = "[";
            foreach ($prog as $key => $value) {
                $result =  $result . '{"favorite":"' . $key . '", "cnt":' . $value . '},';
            }
            $result = $result . "]";
            $result = substr_replace($result, '', -2, 1);
            return $result;
            fclose($file);
        }
    }
}

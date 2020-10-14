<?php
class Mysql
{
    // public static $type = "mysql";

    private $_host = '';
    private $_user = '';
    private $_pass = '';
    private $_dbh = '';

    public $type;

    function __construct()
    {
        $file = "/Applications/MAMP/htdocs/php_kadai_01/config/mysql.json";
        $config_json = file_get_contents($file);
        $mysql = json_decode($config_json, true);
        $mysqlConfig = array(
            'host' => $mysql['host'],
            'user' => $mysql['user'],
            'pass' => $mysql['pass']
        );

        $this->_host = $mysqlConfig['host'];
        $this->_user = $mysqlConfig['user'];
        $this->_pass = $mysqlConfig['pass'];
        $this->type = "mysql";
        $this->_dbh = new PDO(
            $this->_host,
            $this->_user,
            $this->_pass,
            // optionは一旦固定
            array(
                PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
                PDO::ATTR_EMULATE_PREPARES => false,
            )
        );
    }

    public function save($name, $email, $favorite)
    {
        try {
            $stmt = $this->_dbh->prepare('insert into survey (name, email, favorite) values (:name, :email, :favorite)');
            $stmt->bindValue(':name', $name, PDO::PARAM_STR);
            $stmt->bindValue(':email', $email, PDO::PARAM_STR);
            $stmt->bindValue(':favorite', $favorite, PDO::PARAM_STR);
            $stmt->execute();
        } catch (PDOException $e) {
            $error = $e->getMessage();
            return $error;
        }
    }

    public function read($sql)
    {
        try {
            $stmt = $this->_dbh->query($sql);
            $json = json_encode($stmt->fetchAll(PDO::FETCH_ASSOC));
            return $json;
        } catch (PDOException $e) {
            $error = $e->getMessage();
            return $error;
        }
    }
}

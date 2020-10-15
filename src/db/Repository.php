<?php
class Repository
{
    private $_db;
    function __construct($type)
    {
        require(dirname(__FILE__) . '/Mysql.php');
        require(dirname(__FILE__) . '/File.php');
        $this->_type = $type;
        $this->_db = $type == 'mysql' ? new Mysql() : new File();
    }

    public function save($name = null, $email = null, $favorite = null)
    {
        return $this->_db->save($name, $email, $favorite);
    }

    public function read($sql = null)
    {
        if ($this->_db->type == 'mysql') {
            return $this->_db->read($sql);
        } else {
            return $this->_db->read();
        }
    }
}

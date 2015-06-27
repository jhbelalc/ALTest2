<?php 
class DB
{
    const HOST = '127.0.0.1';
    const PORT = 3306;
    const USER = 'root';
    const PASS = 'abc123123';
    const DB   = 'example_maintenance';
    
    private $dbh;
    
    private function __construct()
    {
        $this->dbh = mysql_connect(self::HOST . ':' . self::PORT, self::USER, self::PASS);
        mysql_select_db(self::DB, $this->dbh);
    }
    
    private function query($stmt)
    {
        return mysql_query($stmt, $this->dbh);
    }
    
    public static function getAll($stmt)
    {
        $db  = new self();
        $res = $db->query($stmt);
        $ret = array();
        
        while ($row = mysql_fetch_assoc($res)) {
            $ret[] = $row;
        }
        
        return $ret;
    }
}
?>
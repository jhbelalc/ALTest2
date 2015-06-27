<?php
/*
 * john harold belalcazar lozano
 * 
 * static function and variables behavior 
 * checked using: https://r.je/static-methods-bad-practice.html
 * 
 * 
 */
include 'db.php';

class Host
{
    public static function getList($only_active = false)
    {
        static $result;
        
        if (!empty($result)) return $result;
        //Defect discovery and solution one:
        //to allow to show hosts with no user and credential must be changed
        //the sql instruction to left join
        $stmt = "SELECT
                    hos.host_id,
                    hos.host_name,
                    hos.ip_address,
                    cre.username
                 FROM
                    hosts hos left join
                    credentials cre
                    on hos.credential_id = cre.credential_id
                 WHERE
                    hos.deleted       = 0";
        if ($only_active === true) {
            $stmt .= " AND hos.active = 1";
        }
        
        $result = DB::getAll($stmt);
        
        return $result;
    }
}
?>
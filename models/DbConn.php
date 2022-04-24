<?php
require("constants.php");
class DbConn
{

    private $charset = "utf8";
    public $dbConn;

    public function __construct()
    {
        try {
            $this->dbConn = new PDO(DSN, DB_USER, DB_PASS);
        } catch (PDOException $e) {
            echo "Error trying to stablish connection with database" . $e->getMessage() . "<br/>";
            die();
        }
    }

    public function __destruct()
    {
        $this->dbConn = null;
    }

    public function isConnected()
    {
        try {
            $res = false;
            if ($this->dbConn) {
                $res = true;
            } else {
                die();
            }
            return ($res);
        } catch (Exception $e) {
            return false;
        }
    }

    // For no condition queries
    public function selectQuery($sql)
    {
        try {
            $stmt = null;
            $result = false;
            if (isset($sql) && $sql != "" && isset($this->dbConn)) {
                $stmt = $this->dbConn->prepare($sql);
                if ($stmt) {
                    $stmt->execute();
                    $result = $stmt->fetchAll();
                }
            }
            return ($result);
        } catch (Exception $e) {
            return false;
        }
    }


    public function selectQueryBind($sql, $bindParam)
    {
        try {
            $stmt = null;
            $result = false;
            if (isset($sql) && $sql != "" && isset($this->dbConn)) {
                $stmt = $this->dbConn->prepare($sql);
                if ($stmt) {
                    $stmt->bindParam(1, $bindParam);
                    $stmt->execute();
                    $result = $stmt->fetchAll();
                }
            }
            return ($result);
        } catch (Exception $e) {
            return false;
        }
    }
    // For retrieving counts or a single column and sending one parameter
    public function selectQueryBindSingleFetch($sql, $bindParam)
    {
        try {
            $stmt = null;
            $result = false;
            if (isset($sql) && $sql != "" && isset($this->dbConn)) {
                $stmt = $this->dbConn->prepare($sql);
                if ($stmt) {
                    $stmt->bindParam(1, $bindParam);
                    $stmt->execute();
                    $result = $stmt->fetchAll();
                }
            }
            return ($result);
        } catch (Exception $e) {
            return false;
        }
    }

    public function selectQueryBindArr($sql, $bindArr)
    {
        try {
            $stmt = null;
            $result = false;
            if (isset($sql) && $sql != "" && isset($this->dbConn)) {
                if (isset($bindArr)) {
                    $stmt = $this->dbConn->prepare($sql);
                    if ($stmt) {
                        $stmt->execute($bindArr);
                        $result = $stmt->fetchAll();
                    }
                }
            }
            return ($result);
        } catch (Exception $e) {
            return false;
        }
    }
    // For retrieving counts or a single column and sending more than one parameter
    public function selectQueryBindArrSingleFetch($sql, $bindArr)
    {
        try {
            $stmt = null;
            $result = false;
            if (isset($sql) && $sql != "" && isset($this->dbConn)) {
                if (isset($bindArr)) {
                    $stmt = $this->dbConn->prepare($sql);
                    if ($stmt) {
                        $stmt->execute($bindArr);
                        $result = $stmt->fetch();
                    }
                }
            }
            return ($result);
        } catch (Exception $e) {
            return false;
        }
    }

    public function executeQueryBind($sql, $bindParam)
    {
        try {
            $stmt = null;
            $result = false;
            if (isset($sql) && $sql != "" && isset($this->dbConn)) {
                $stmt = $this->dbConn->prepare($sql);
                if ($stmt) {
                    $stmt->bindParam(1, $bindParam);
                    $result = $stmt->execute();
                }
            }
            return ($result);
        } catch (Exception $e) {
            return false;
        }
    }

    public function executeQueryBindArr($sql, $bindArr)
    {
        try {
            $stmt = null;
            $result = false;
            if (isset($sql) && $sql != "" && isset($this->dbConn)) {
                $stmt = $this->dbConn->prepare($sql);
                if ($stmt) {
                    $result = $stmt->execute($bindArr);
                }
            }
            return ($result);
        } catch (Exception $e) {
            return false;
        }
    }
}

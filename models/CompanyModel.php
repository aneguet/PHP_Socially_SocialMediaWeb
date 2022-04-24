<?php

class CompanyModel extends DbConn

{
    function getCompanyInfo()
    {
        try {
            $sql = 'SELECT * from V_AboutUs_company';
            $result = $this->selectQuery($sql);
            return $result;
        } catch (\PDOException $ex) {
            print($ex->getMessage());
        }
    }
    function getCompanyDevelopers()
    {
        try {
            $sql = 'SELECT * from V_AboutUs_developers';
            $result = $this->selectQuery($sql);
            return $result;
        } catch (\PDOException $ex) {
            print($ex->getMessage());
        }
    }
    function getCompanyWebInsights()
    {
        try {
            $sql = 'SELECT * from V_AboutUs_web';
            $result = $this->selectQuery($sql);
            return $result;
        } catch (\PDOException $ex) {
            print($ex->getMessage());
        }
    }
}

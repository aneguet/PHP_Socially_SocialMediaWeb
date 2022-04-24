<?php
spl_autoload_register(function ($class) {
    $file = __DIR__ . '/../models/' . $class . '.php';
    if (file_exists($file)) {
        require $file;
    }
});

class CompanyController
{
    public function getCompanyInfo()
    {
        $c = new CompanyModel();
        $res = $c->getCompanyInfo();
        return $res;
    }
    public function getCompanyDevelopers()
    {
        $c = new CompanyModel();
        $res = $c->getCompanyDevelopers();
        return $res;
    }
    public function getCompanyWebInsights()
    {
        $c = new CompanyModel();
        $res = $c->getCompanyWebInsights();
        return $res;
    }
}

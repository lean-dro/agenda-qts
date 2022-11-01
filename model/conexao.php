<?php
class Conexao
{
    public static function conexao()
    {

        $conexao = new PDO(
            "mysql:host=localhost;
            dbname=bdslim",
            "root",
            ""
        );
        $conexao->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        $conexao->exec("SET CHARACTER SET utf8;");

        return $conexao;
    }
}

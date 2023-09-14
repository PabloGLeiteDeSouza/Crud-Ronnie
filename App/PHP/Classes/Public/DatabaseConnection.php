<?php

namespace App\PHP\Classes\Public;

use PDO;
use PDOException;
use Dotenv\Dotenv;

// Inclua o autoload do Composer
require_once '../../vendor/autoload.php';

class DatabaseConection {
    private $pdo;

    public function __construct() {
        // Carrega as variáveis de ambiente do arquivo .env
        $dotenv = Dotenv::createImmutable("../../");
        $dotenv->load();

        $host = $_ENV['DB_HOST'];
        $username = $_ENV['DB_USERNAME'];
        $password = $_ENV['DB_PASSWORD'];
        $database = $_ENV['DB_DATABASE'];

        try {
            $dsn = "mysql:host={$host};dbname={$database}";
            $this->pdo = new PDO($dsn, $username, $password);
            $this->pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        } catch (PDOException $e) {
            die("Erro na conexão com o banco de dados: " . $e->getMessage());
        }
    }
    
    /**
     * Função de seleção de dados do banco de dados MYSQL/MARIADB
     *
     * @param string $query uma string que contem uma query para o banco de dados
     * @param array $params um array que contem os parametros a serem adicionados na query
     * @return array|false retorna o valor da consulta em formato de array ou um false caso haja erro;
     */
    public function select(string $query, $params = []) : array|false
    {
        try {
            $stmt = $this->pdo->prepare($query);
            $stmt->execute($params);
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            return false;
        }
    }

    public function selectExists($query, $params = []) {
        try {
            $stmt = $this->pdo->prepare($query);
            $stmt->execute($params);
            return $stmt->rowCount() > 0;
        } catch (PDOException $e) {
            return false;
        }
    }

    public function insert($query, $params = []) {
        try {
            $stmt = $this->pdo->prepare($query);
            return $stmt->execute($params);
        } catch (PDOException $e) {
            return false;
        }
    }

    public function update($query, $params = []) {
        try {
            $stmt = $this->pdo->prepare($query);
            return $stmt->execute($params);
        } catch (PDOException $e) {
            return false;
        }
    }

    public function delete($query, $params = []) {
        try {
            $stmt = $this->pdo->prepare($query);
            return $stmt->execute($params);
        } catch (PDOException $e) {
            return false;
        }
    }
}

<?php
namespace APP\PHP\Server;

class Functions
{
    public function Filter_names($name) : array|string|null|bool {
        // Use uma expressão regular para manter apenas letras (maiúsculas e minúsculas).
        if (preg_match('/[^A-Za-z]/', $name)) {
            return preg_replace('/[^A-Za-z]/', '', $name);
        } else {
            return false;
        }
        
    }
    
    public function Filter_username($username) : array|string|null|bool {
        // Use uma expressão regular para manter letras, números, "-", ".", "@".
        if (preg_match('/[^A-Za-z0-9\-.@]/', $username)) {
            return preg_replace('/[^A-Za-z0-9\-.@]/', '', $username);
        } else {
            return false;
        }
    }
    public function Filtrar_data_de_nascimento($data) {
        // Remove todos os caracteres, exceto números e traços.
        $data = preg_replace('/[^0-9-]/', '', $data);
    
        // Tenta analisar a data no formato "YYYY-MM-DD".
        $data_formatada = date('Y-m-d', strtotime($data));
    
        // Verifica se a data foi formatada corretamente.
        if (strtotime($data_formatada) !== false) {
            return $data_formatada;
        } else {
            return false; // Data inválida.
        }
    }
    
    public  static function Filter_senha(string $password) : array|string|null|bool
    {
        if (preg_match('/[^A-Za-z0-9$#.,-:]/', $password)) {
            return preg_replace('/[^A-Za-z0-9$#.,-:]/', '', $password);    
        } else {
            return false;
        }
        
        
    }
}

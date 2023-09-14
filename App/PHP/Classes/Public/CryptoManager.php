<?php

namespace App\PHP\Classes\Public\Security;

use Dotenv\Dotenv;

class CryptoManager
{

    private $private_key_location;
    
    private $private_key;
    
    private $public_key_location;

    private $public_key;


    public function __construct($username = null) {
        $this->generate_public_key();
        if ($username != null) {
            $this->generate_private_key($username);
        }
    }   
    
    private function generate_public_key(): void
    {
        /**
         *  @var string $public_key_location
         */
        $this->public_key_location = $_ENV["CRYPTO_MANAGER_PUBLIC_KEY_LOCATION"];
        
        if (!file_exists($this->public_key_location)) {
        
            $this->public_key = sodium_crypto_secretbox_keygen();
        
            file_put_contents($this->public_key_location, $this->public_key);
        
        }
    }

    private function generate_private_key($username) : void {

        $this->private_key_location = $_ENV["CRYPTO_MANAGER_PRIVATE_KEY_BASE_LOCATION"].$username."/Keys/private_key.key";
        
        if (!file_exists($_ENV["CRYPTO_MANAGER_PRIVATE_KEY_BASE_LOCATION"].$username."/Keys/private_key.key")) {

            $this->private_key = sodium_crypto_secretbox_keygen();

            file_put_contents($this->private_key_location, $this->private_key);

        } else {

            $this->private_key = file_get_contents($_ENV["CRYPTO_MANAGER_PRIVATE_KEY_BASE_LOCATION"].$username."/Keys/private_key.key");
        
        }
    }

    /**
     * Undocumented function
     *
     * @param boolean $private_key_status valor que deve ser informado como true/verdadeiro para usar chave privada e false/falso para usar chave pública
     * @return string
     */

    private function encryptSensitiveData(string $data, $private_key_status=false ) : string {
        if ($private_key_status) {
            if ($this->private_key_location != "") {
                $private_key = file_get_contents($this->private_key_location);
                $nonce = random_bytes(SODIUM_CRYPTO_SECRETBOX_NONCEBYTES);
                $encryptedData = sodium_crypto_secretbox($data, $nonce, $private_key);
                return sodium_bin2hex($nonce . $encryptedData);
            } else {
                return $this->encryptSensitiveData(false, $data);
            }
        } else {
            $public_key = $this->public_key;
            $nonce = random_bytes(SODIUM_CRYPTO_SECRETBOX_NONCEBYTES);
            $encryptedData = sodium_crypto_secretbox($data, $nonce, $public_key);
            return sodium_bin2hex($nonce . $encryptedData);
        }
        
    }

    public function encryptData(string $data, bool $private_status) : string {
        return $this->encryptSensitiveData($data, $private_status);
    }

    private function decryptSensitiveData(string $encryptedData, $private_key_status=false) : string|bool {
        if ($private_key_status) {
            if ($this->private_key_location != "") {
                // Decodifica os dados criptografados
                $decoded = sodium_hex2bin($encryptedData);
                // Separa o nonce e os dados criptografados
                $nonce = substr($decoded, 0, SODIUM_CRYPTO_SECRETBOX_NONCEBYTES);
                // Separa o conteúdo encriptado
                $encryptedData = substr($decoded, SODIUM_CRYPTO_BOX_NONCEBYTES);
                // Descirptografando os dados
                $decryptedData = sodium_crypto_secretbox_open($encryptedData, $nonce, $this->private_key);
                return $decryptedData;
            } else {
                return $this->decryptSensitiveData($encryptedData);
            }
        } else {
            // Decodifica os dados criptografados
            $decoded = sodium_hex2bin($encryptedData);
            // Separa o nonce e os dados criptografados
            $nonce = substr($decoded, 0, SODIUM_CRYPTO_SECRETBOX_NONCEBYTES);
            // Separa o conteúdo encriptado
            $encryptedData = substr($decoded, SODIUM_CRYPTO_BOX_NONCEBYTES);
            // Descirptografando os dados
            $decryptedData = sodium_crypto_secretbox_open($encryptedData, $nonce, $this->public_key);
            return $decryptedData;
        }
    }

    public function decryptData(string $encryptedData) : string|bool {
        return $this->encryptSensitiveData($encryptedData, $this->private_key_location != "");
    }

    public function add_private_key ($encripted_private_key_location) : void {
        try {
            $private_key_location = $this->decryptSensitiveData($encripted_private_key_location);
            $this->private_key_location = $private_key_location;
            $this->private_key = file_get_contents($private_key_location);
        } catch (\Error $e) {
            die("Erro ao adicionar a chave. ERRO: ".$e);
        }
    }
}

?>
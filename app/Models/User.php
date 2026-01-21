<?php
// app/Models/User.php

namespace App\Models;

class User extends JsonModel
{
    protected static $filePath = 'users.json';
    
    /**
     * Encontrar usuario por nombre de usuario
     */
    public static function findByUsername($username)
    {
        $data = static::readData();
        
        foreach ($data as $user) {
            if ($user['username'] === $username) {
                return $user;
            }
        }
        
        return null;
    }
    
    /**
     * Encontrar usuario por email
     */
    public static function findByEmail($email)
    {
        $data = static::readData();
        
        foreach ($data as $user) {
            if ($user['email'] === $email) {
                return $user;
            }
        }
        
        return null;
    }
    
    /**
     * Actualizar usuario por ID
     */
    public static function update($id, array $data): bool
    {
        $allData = static::readData();
        $updated = false;
        
        foreach ($allData as &$item) {
            if ($item['id'] === $id) {
                // Mantener todos los datos existentes y solo actualizar los proporcionados
                $item = array_merge($item, $data);
                $updated = true;
                break;
            }
        }
        
        if ($updated) {
            static::writeData($allData);
        }
        
        return $updated;
    }
    
    /**
     * Obtener usuario por ID
     */
    public static function findById($id)
    {
        $data = static::readData();
        
        foreach ($data as $user) {
            if ($user['id'] === $id) {
                return $user;
            }
        }
        
        return null;
    }
    
    /**
     * Crear nuevo usuario - FIRMA COMPATIBLE CON JsonModel
     */
    public static function create(array $attributes): array
    {
        $allData = static::readData();
        
        // Asegurar que todos los campos necesarios están presentes
        $defaultData = [
            'id' => $attributes['id'] ?? uniqid(),
            'username' => $attributes['username'] ?? '',
            'email' => $attributes['email'] ?? '',
            'password' => $attributes['password'] ?? '',
            'isProfessor' => $attributes['isProfessor'] ?? 'False',
            'theme' => $attributes['theme'] ?? 'light',
            'created_at' => date('Y-m-d H:i:s')
        ];
        
        $userData = array_merge($defaultData, $attributes);
        $allData[] = $userData;
        
        static::writeData($allData);
        
        return $userData;
    }
}
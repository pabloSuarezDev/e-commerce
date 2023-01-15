<?php
  class Usuario {
    private $id;
    private $name;
    private $surnames;
    private $email;
    private $password;
    private $rol;
    private $image;
    private $db;

    public function __construct() {
      $this->db = DB::connect();
    }

    public function getID() {
      return $this->id;
    }

    public function getName() {
      return $this->name;
    }

    public function getSurnames() {
      return $this->surnames;
    }

    public function getEmail() {
      return $this->email;
    }

    public function getPassword() { 
      return $this->password = password_hash($this->db->real_escape_string($this->password), PASSWORD_BCRYPT, ['cost' => 4]);
    }

    public function getRol() {
      return $this->rol;
    }

    public function getImage() {
      return $this->image;
    }

    public function setName($name) {
      $this->name = $this->db->real_escape_string($name);
    }

    public function setSurnames($surnames) {
      $this->surnames = $this->db->real_escape_string($surnames);
    }

    public function setEmail($email) {
      $this->email = $this->db->real_escape_string($email);
    }

    public function setPassword($password) {
      $this->password = $password;
    }

    public function setRol($rol) {
      $this->rol = $this->db->real_escape_string($rol);
    }

    public function setImage($image) {
      $this->image = $this->db->real_escape_string($image);
    }

    public function save() {
      $sql = "INSERT INTO usuarios VALUES (
                null, 
                '{$this->getName()}',
                '{$this->getSurnames()}',
                '{$this->getEmail()}',
                '{$this->getPassword()}',
                'user',
                null
              );";

      $save = $this->db->query($sql);
      
      $result = false;
      if($save) {
        $result = true;
      }
      return $result;
    }

    public function login() {
      $result = false;
      $email = $this->email;
      $password = $this->password;

      //* Comprobar si existe el usuario
      $sql = "SELECT * FROM usuarios WHERE email='$email';";
      $login = $this->db->query($sql);

      if($login && $login->num_rows == 1) {
        $usuario = $login->fetch_object();
        
        //? Verificar contraseña
        $verify = password_verify($password, $usuario->password);

        if($verify) {
          $result = $usuario;
        }
      }
      return $result;
    }
  }
?>
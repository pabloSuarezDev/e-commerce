<?php
  class Pedido {
    private $id;
    private $usuario_id;
    private $provincia;
    private $localidad;
    private $direccion;
    private $coste;
    private $estado;
    private $fecha;
    private $hora;
    private $db;

    public function __construct() {
      $this->db = DB::connect();
    }

    public function getID() {
      return $this->id;
    }
    
    public function getUsuarioID() {
      return $this->usuario_id;
    }

    public function getProvincia() {
      return $this->provincia;
    }

    public function getDireccion() {
      return $this->direccion;
    }

    public function getLocalidad() {
      return $this->localidad;
    }

    public function getCoste() {
      return $this->coste;
    }

    public function getEstado() {
      return $this->estado;
    }

    public function getFecha() {
      return $this->fecha;
    }

    public function getHora() {
      return $this->hora;  
    }

    public function setID($id) {
      $this->id = $id;
    }

    public function setUsuarioID($usuario_id) {
      $this->usuario_id = $this->db->real_escape_string($usuario_id);
    }

    public function setProvincia($provincia) {
      $this->provincia = $this->db->real_escape_string($provincia);
    }

    public function setDireccion($direccion) {
      $this->direccion = $this->db->real_escape_string($direccion);
    }

    public function setLocalidad($localidad) {
      $this->localidad = $this->db->real_escape_string($localidad);
    }

    public function setCoste($coste) {
      $this->coste = $this->db->real_escape_string($coste);
    }

    public function setEstado($estado) {
      $this->estado = $this->db->real_escape_string($estado);
    }

    public function setFecha($fecha) {
      $this->fecha = $this->db->real_escape_string($fecha);
    }

    public function setHora($hora) {
      $this->hora = $this->db->real_escape_string($hora);
    }

    public function getAll() {
      $pedidos = $this->db->query("SELECT * FROM pedidos ORDER BY id DESC;");
      return $pedidos;
    }

    public function getOne() {
      $pedido = $this->db->query("SELECT * FROM pedidos WHERE id={$this->getID()};");
      return $pedido->fetch_object();
    }

    public function getAllByUser() {
      $sql = "SELECT * FROM pedidos WHERE usuario_id={$this->getUsuarioID()} ORDER BY id DESC;";

      $pedido = $this->db->query($sql);
      return $pedido;
    }

    public function getOneByUser() {
      $sql = "SELECT id, coste FROM pedidos WHERE usuario_id={$this->getUsuarioID()} ORDER BY id DESC LIMIT 1;";

      $pedido = $this->db->query($sql);
      return $pedido->fetch_object();
    }

    public function getProductosByPedido($id) {
      // $sql = "SELECT * FROM productos 
      //         WHERE id IN (SELECT producto_id FROM lineas_pedidos WHERE pedido_id={$id});";

      $sql = "SELECT pr.*, lp.unidades FROM productos pr
              INNER JOIN lineas_pedidos lp ON pr.id = lp.producto_id
              WHERE lp.pedido_id={$id}";

      $productos = $this->db->query($sql);
      return $productos;
    }

    public function save() {
      $sql = "INSERT INTO pedidos VALUES (
                null, 
                {$this->getUsuarioID()},
                '{$this->getProvincia()}',
                '{$this->getLocalidad()}',
                '{$this->getDireccion()}',
                {$this->getCoste()},
                'confirmed',
                CURDATE(),
                CURTIME()
              );";

      $save = $this->db->query($sql);
      
      $result = false;
      if($save) {
        $result = true;
      }

      return $result;
    }

    public function saveLinea() {
      $sql = "SELECT LAST_INSERT_ID() AS 'pedido';";

      $query = $this->db->query($sql);
      $pedido_id = $query->fetch_object()->pedido;

      foreach ($_SESSION['carrito'] as $elemento) { 
        $producto = $elemento['producto'];

        $insert = "INSERT INTO lineas_pedidos VALUES (null, {$pedido_id}, {$producto->id}, {$elemento['unidades']});";

        $save = $this->db->query($insert);
      }

      $result = false;
      if($save) {
        $result = true;
      }

      return $result;
    }

    public function updateEstado() {
      $sql = "UPDATE pedidos SET estado='{$this->getEstado()}' WHERE id={$this->getID()};";

      $update = $this->db->query($sql);
      
      $result = false;
      if($update) {
        $result = true;
      }

      return $result;
    }
  }
?>
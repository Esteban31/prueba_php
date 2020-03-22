<?php

/**
 * Class Songs
 * This is a demo Model class.
 *
 * Please note:
 * Don't use the same name for class and method, as this might trigger an (unintended) __construct of the class.
 * This is really weird behaviour, but documented here: http://php.net/manual/en/language.oop5.decon.php
 *
 */

namespace Mini\Model;

use Mini\Core\Model;

class Rest extends Model
{
    
    // Propiedades del producto
    private $id_producto;
    private $nombre;
    private $referencia;
    private $precio;
    private $peso;
    private $categoria;
    private $stock;
    private $fecha_creacion;
    private $fecha_ultima_compra;

    // Propiedades de la venta
    private $id_venta;
    private $fecha_venta;
    private $cantidad_producto;

    // ENCAPSULAMIENTO
    function __SET($Atributo, $Valor){
        $this->$Atributo=$Valor;
    }

    function __GET($Atributo){
        return $this->$Atributo;
    }


    // FUNCIÓN QUE OBTIENE TODOS LOS PRODUCTOS
    public function get_all_products(){
        $sql="SELECT * FROM productos";
        $stm=$this->db->prepare($sql);
        $stm->execute();

        return $stm->fetchAll();
    }


    // FUNCIÓN QUE OBTIENE EL PRODUCTO PERO POR ID
    public function get_all_products_by_id(){
        $sql="SELECT * FROM productos WHERE id=?";
        $stm=$this->db->prepare($sql);
        $stm->bindParam(1,$this->id_producto);
        $stm->execute();

        return $stm->fetch();
    }

    // FUNCIÓN QUE OBTIENE UN PRODUCTO POR REFERENCIA
    public function get_all_products_by_referencia(){
        $sql="SELECT * FROM productos WHERE referencia=?";
        $stm=$this->db->prepare($sql);
        $stm->bindParam(1,$this->referencia);
        $stm->execute();

        return $stm->fetch();
    }

    // FUNCIÓN QUE OBTIENE TODOS LOS  PRODUCTOS POR CATEGORÍA
    public function get_all_products_by_categoria(){
        $sql="SELECT * FROM productos WHERE categoria=?";
        $stm=$this->db->prepare($sql);
        $stm->bindParam(1,$this->categoria);
        $stm->execute();

        return $stm->fetchAll();
    }


    // FUNCIÓN QUE REGISTRA EL PRODUCTO
    public function add_product(){
        $sql="INSERT INTO productos (nombre, referencia, precio, peso, categoria, stock, fecha_creacion) VALUES(?,?,?,?,?,?,?)";
        $stm=$this->db->prepare($sql);
        $stm->bindParam(1,$this->nombre);
        $stm->bindParam(2,$this->referencia);
        $stm->bindParam(3,$this->precio);
        $stm->bindParam(4,$this->peso);
        $stm->bindParam(5,$this->categoria);
        $stm->bindParam(6,$this->stock);
        $stm->bindParam(7,$this->fecha_creacion);

        return $stm->execute();
    }


    // FUNCION QUE ACTUALIZA EL PRODUCTO
    public function update_product(){
        $sql="UPDATE productos SET nombre=?, referencia=?, precio=?, peso=?, categoria=?, stock=?, fecha_creacion=? WHERE id=? ";
        $stm=$this->db->prepare($sql);
        $stm->bindParam(1,$this->nombre);
        $stm->bindParam(2,$this->referencia);
        $stm->bindParam(3,$this->precio);
        $stm->bindParam(4,$this->peso);
        $stm->bindParam(5,$this->categoria);
        $stm->bindParam(6,$this->stock);
        $stm->bindParam(7,$this->fecha_creacion);
        $stm->bindParam(8,$this->id_producto);

        return $stm->execute();
    }


    // FUNCIÓN QUE ELIMINA EL PRODUCTO
    public function delete_product(){
        $sql="DELETE FROM productos WHERE id =?";
        $stm=$this->db->prepare($sql);
        $stm->bindParam(1,$this->id_producto);
        
        return $stm->execute();
    }


    // FUNCIÓN QUE HACE LA COMPRA
    public function add_purchase(){

        $sql="INSERT INTO ventas (fecha_venta, cantidad_producto, id_producto) VALUES (?,?,?)";
        $stm=$this->db->prepare($sql);
        $stm->bindParam(1,$this->fecha_venta);
        $stm->bindParam(2,$this->cantidad_producto);
        $stm->bindParam(3,$this->id_producto);

        return $stm->execute();

    }

    // FUNCIÓN QUE ACTUALIZA EL STOCK Y LA FECHA DEL PRODUCTO
    public function update_stock_and_date(){
         $sql="UPDATE productos SET  stock=?, fecha_ultima_compra=? WHERE id=? ";
        $stm=$this->db->prepare($sql);
        $stm->bindParam(1,$this->stock);
        $stm->bindParam(2,$this->fecha_ultima_compra);
        $stm->bindParam(3,$this->id_producto);

        return $stm->execute();
    }

    // FUNCIÓN QUE OBTIENE EL STOCK DE UN PRODUCTO
    public function get_product_stock(){
        $sql="SELECT stock FROM productos WHERE id=?";
        $stm=$this->db->prepare($sql);
        $stm->bindParam(1,$this->id_producto);
        $stm->execute();

        return $stm->fetch();
    }


    // FUNCIÓN QUE VALIDA QUE UN PRODUCTO EXISTA
    public function product_isset(){
        $sql="SELECT id FROM productos WHERE id=?";
        $stm=$this->db->prepare($sql);
        $stm->bindParam(1,$this->id_producto);
        $stm->execute();

        return $stm->fetch();
    }


}

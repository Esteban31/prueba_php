<?php


namespace Mini\Controller;

use Mini\Model\Rest;

header('Access-Control-Allow-Origin: *');
header("Access-Control-Allow-Headers: X-API-KEY, Origin, X-Requested-With, Content-Type, Accept, Access-Control-Request-Method");
header("Access-Control-Allow-Methods: GET, POST, OPTIONS, PUT, DELETE");
header("Allow: GET, POST, OPTIONS, PUT, DELETE");

class RestController
{
    public function index()
    {
        require APP.'view/welcome.php';
    }


    // FUNCIÓN QUE OBTIENE TODOS LOS PRODUCTOS O POR PARÁMETRO
    public function get_products($tipo="all",$parametro=''){

        $array_retorno = array("respuesta"=>'',"resultado"=>'');

        // Validamos el método de Solicitud
        if ($_SERVER['REQUEST_METHOD']=='GET') {

            $Rest=new Rest();
            $array_datos = array();

            // Validamos el tipo de parámetro
            if ($tipo=="all") {
                
                // Obtenemos todos los productos
                $productos = $Rest->get_all_products();

                // Validamos la cantidad de productos
                if (count($productos)>0) {
                    
                    foreach ($productos as $key => $value) {
                        array_push($array_datos, array("id"=>$value->id,"nombre"=>$value->nombre,"referencia"=>$value->referencia,"precio"=>$value->precio,"peso"=>$value->peso,"categoria"=>$value->categoria,"stock"=>$value->stock,"fecha_creacion"=>$value->fecha_creacion,"fecha_ultima_compra"=>$value->fecha_ultima_compra));
                    }

                    header("HTTP/1.1 200 OK");
                    $array_retorno = array("respuesta"=>'',"resultado"=>$array_datos);

                }else{

                    header("HTTP/1.1 200 OK");
                    $array_retorno = array("respuesta"=>'No hay Productos registrados',"resultado"=>'');
                }

            }else{
                
                // Validamos cual es el tipo
                switch ($tipo) {

                    // BÚSQUEDA POR ID
                    case 'id':
                        
                        if($parametro!=''){
                            // Obtenemos los productos
                            $Rest->__SET("id_producto",$parametro);
                            $productos = $Rest->get_all_products_by_id();

                             array_push($array_datos, array("id"=>$productos->id,"nombre"=>$productos->nombre,"referencia"=>$productos->referencia,"precio"=>$productos->precio,"peso"=>$productos->peso,"categoria"=>$productos->categoria,"stock"=>$productos->stock,"fecha_creacion"=>$productos->fecha_creacion,"fecha_ultima_compra"=>$productos->fecha_ultima_compra));

                             header("HTTP/1.1 200 OK");
                            $array_retorno = array("respuesta"=>'',"resultado"=>$array_datos);
                        }else{
                            header("HTTP/1.1 400 BAD REQUEST");
                            $array_retorno = array("respuesta"=>'Parametro invalido',"resultado"=>'');
                        }

                    break;


                    // BÚSQUEDA POR CATEGORÍA
                    case 'categories':

                        if($parametro!=''){
                            // Obtenemos todos los productos
                            $Rest->__SET("categoria",$parametro);
                            $productos = $Rest->get_all_products_by_categoria();

                            // Validamos la cantidad de productos
                            if (count($productos)>0) {
                                
                                foreach ($productos as $key => $value) {
                                    array_push($array_datos, array("id"=>$value->id,"nombre"=>$value->nombre,"referencia"=>$value->referencia,"precio"=>$value->precio,"peso"=>$value->peso,"categoria"=>$value->categoria,"stock"=>$value->stock,"fecha_creacion"=>$value->fecha_creacion,"fecha_ultima_compra"=>$value->fecha_ultima_compra));
                                }

                                header("HTTP/1.1 200 OK");
                                $array_retorno = array("respuesta"=>'',"resultado"=>$array_datos);

                            }else{

                                header("HTTP/1.1 200 OK");
                                $array_retorno = array("respuesta"=>'No hay Productos registrados',"resultado"=>'');
                            }
                        }else{
                            header("HTTP/1.1 400 BAD REQUEST");
                            $array_retorno = array("respuesta"=>'Parametro invalido',"resultado"=>'');
                        }

                    break;


                    // BÚSQUEDA POR REFERENCIA
                    case 'reference':

                        // Validamos que los dos parámetros estén llenos
                        if ($parametro!='') {
                            // Obtenemos los productos
                            $Rest->__SET("referencia",$parametro);
                            $productos = $Rest->get_all_products_by_referencia();

                             array_push($array_datos, array("id"=>$productos->id,"nombre"=>$productos->nombre,"referencia"=>$productos->referencia,"precio"=>$productos->precio,"peso"=>$productos->peso,"categoria"=>$productos->categoria,"stock"=>$productos->stock,"fecha_creacion"=>$productos->fecha_creacion,"fecha_ultima_compra"=>$productos->fecha_ultima_compra));

                             header("HTTP/1.1 200 OK");
                            $array_retorno = array("respuesta"=>'',"resultado"=>$array_datos);
                        }else{
                            header("HTTP/1.1 400 BAD REQUEST");
                            $array_retorno = array("respuesta"=>'Parametro invalido',"resultado"=>'');
                        }

                        
                    break;
                }

            }
        }else{
            header("HTTP/1.1 400 BAD REQUEST");
            $array_retorno = array("respuesta"=>'Solicitud Inválida',"resultado"=>'');
        }


        echo json_encode($array_retorno);
    }


    // FUNCIÓN QUE REGISTRA EL PRODUCTO
    public function add_product(){

        $array_retorno = array("respuesta"=>'',"resultado"=>'');
        date_default_timezone_set('America/Bogota');

        // Validamos el tipo de Solicitud
        if ($_SERVER['REQUEST_METHOD']=='POST') {
            
            // Capturamos los datos
            $name       = @$_POST["name"];
            $reference  = @$_POST["reference"];
            $price      = @$_POST["price"];
            $weight     = @$_POST["weight"];
            $category   = @$_POST["category"];
            $stock      = @$_POST["stock"];

            $continuar = true;

            // Validamos cada uno de los campos
            if (!isset($name) || !isset($reference) || !isset($price) || !isset($weight) || !isset($category) || !isset($stock)) {

                $continuar=false;

                header("HTTP/1.1 400 BAD REQUEST");
                $array_retorno = array("respuesta"=>'Falta uno o varios parametros, los parametros aceptados son (name, reference, price, weight, category, stock)',"resultado"=>'');
            }


            // Continuamos si todo es válido
            if ($continuar) {
                    
                $Rest=new Rest();

                // Encapsulamos los datos
                $Rest->__SET("nombre",$name);
                $Rest->__SET("referencia",$reference);
                $Rest->__SET("precio",$price);
                $Rest->__SET("peso",$weight);
                $Rest->__SET("categoria",$category);
                $Rest->__SET("stock",$stock);
                $Rest->__SET("fecha_creacion",date('Y-m-d'));

                if ($Rest->add_product()) {
                    header("HTTP/1.1 200 OK");
                    $array_retorno = array("respuesta"=>'Producto registrado correctamente',"resultado"=>'');
                }else{
                    header("HTTP/1.1 500 INTERNAL ERROR");
                    $array_retorno = array("respuesta"=>'Problemas al registrar el producto',"resultado"=>'');
                }

            }

        }else{
            header("HTTP/1.1 400 BAD REQUEST");
            $array_retorno = array("respuesta"=>'Solicitud Inválida',"resultado"=>'');
        }

        echo json_encode($array_retorno);

    }

    // FUNCIÓN QUE ACTUALIZA EL PRODUCTO
    public function update_product($producto=0){

        $array_retorno = array("respuesta"=>'',"resultado"=>'');

        // Validamos el tipo de solicitud
        if ($_SERVER['REQUEST_METHOD']=='PUT') {

            $Rest =  new Rest();

            // Capturamos los datos
            $data = json_decode(file_get_contents("php://input"),false);


            // Obtenemos los datos precargados del producto
            if ($producto!=0) {
                $Rest->__SET("id_producto",$producto);
                $datos_producto = $Rest->get_all_products_by_id();
            }


            // Capturamos los datos
            $name               = ((empty($data->name))?$datos_producto->nombre:$data->name);
            $reference          = ((empty($data->reference))?$datos_producto->referencia:$data->reference);
            $price              = ((empty($data->price))?$datos_producto->precio:$data->price);
            $weight             = ((empty($data->weight))?$datos_producto->peso:$data->weight);
            $category           = ((empty($data->category))?$datos_producto->categoria:$data->category);
            $stock              = ((empty($data->stock))?$datos_producto->stock:$data->stock);
            $creation_date      = ((empty($data->creation_date))?$datos_producto->fecha_creacion:$data->creation_date);

            $producto_a_actualizar = $producto;

            $continuar=true;

             // Validamos cada uno de los campos
            if (empty($name) || empty($reference) || empty($price) || empty($weight) || empty($category) || empty($stock) || empty($creation_date)) {

                $continuar=false;

                header("HTTP/1.1 400 BAD REQUEST");
                $array_retorno = array("respuesta"=>'Falta uno o varios parametros, los parametros aceptados son (name, reference, price, weight, category, stock and creation_date)',"resultado"=>'');
            }

            if ($continuar) {
                
                $Rest->__SET("nombre",$name);
                $Rest->__SET("referencia",$reference);
                $Rest->__SET("precio",$price);
                $Rest->__SET("peso",$weight);
                $Rest->__SET("categoria",$category);
                $Rest->__SET("stock",$stock);
                $Rest->__SET("fecha_creacion",$creation_date);

                if ($Rest->update_product()) {
                    header("HTTP/1.1 200 OK");
                    $array_retorno = array("respuesta"=>'Producto actualizado correctamente',"resultado"=>'');
                }else{
                    header("HTTP/1.1 500 INTERNAL ERROR");
                    $array_retorno = array("respuesta"=>'Problemas al actualizar el producto',"resultado"=>'');
                }

            }

        }else{
            header("HTTP/1.1 400 BAD REQUEST");
            $array_retorno = array("respuesta"=>'Solicitud Inválida',"resultado"=>'');
        }

        echo json_encode($array_retorno);
    }

    // FUNCIÓN QUE ELIMINA EL PRODUCTO
    public function delete_product($producto=0){

        $array_retorno = array("respuesta"=>'',"resultado"=>'');

        // Validamos el tipo de método
        if ($_SERVER['REQUEST_METHOD']=='GET') {

            if ($producto!=0) {
                
                $Rest = new Rest();

                $Rest->__SET("id_producto",$producto);

                if ($Rest->delete_product()) {
                    header("HTTP/1.1 200 OK");
                    $array_retorno = array("respuesta"=>'Producto eliminado correctamente',"resultado"=>'');
                }else{
                    header("HTTP/1.1 500 INTERNAL ERROR");
                    $array_retorno = array("respuesta"=>'Problemas al eliminar el producto',"resultado"=>'');
                }

            }else{
                header("HTTP/1.1 400 BAD REQUEST");
                $array_retorno = array("respuesta"=>'Solicitud Inválida',"resultado"=>'');
            }


        }else{
            header("HTTP/1.1 400 BAD REQUEST");
            $array_retorno = array("respuesta"=>'Solicitud Inválida',"resultado"=>'');
        }

        echo json_encode($array_retorno);

    }

    public function add_purchase($producto=0,$cantidad=0){

        $array_retorno = array("respuesta"=>'',"resultado"=>'');

        if ($_SERVER['REQUEST_METHOD']=='GET') {

            $Rest=new Rest();
            $continuar = true;

            if ($producto!=0) {
                $Rest->__SET("id_producto",$producto);

                $producto_v=@$Rest->product_isset()->id;

                // Validamos que el producto exista
                if (empty($producto_v) ){
                    $continuar=false;
                    header("HTTP/1.1 200 OK");
                    $array_retorno = array("respuesta"=>'El producto no existe',"resultado"=>'');
                }

                // Obtenemos el stock de el producto
                if ($continuar) {
                    @$stock_producto =$Rest->get_product_stock()->stock;
                }

                // Validamos el stock vs la cantidad
                if ($cantidad>@$stock_producto) {
                    $continuar=false;
                    header("HTTP/1.1 200 OK");
                    $array_retorno = array("respuesta"=>'No hay suficiente stock para este producto',"resultado"=>'');
                }

                if ($continuar) {
                        
                    // Registramos la compra
                    date_default_timezone_set('America/Bogota');
                    $Rest->__SET("fecha_venta",date('Y-m-d'));
                    $Rest->__SET("cantidad_producto",$cantidad);
                    $Rest->add_purchase();

                    // Actualizamos el stock y demás
                    $Rest->__SET("stock",($stock_producto-$cantidad));
                    $Rest->__SET("fecha_ultima_compra",date('Y-m-d'));
                    $Rest->update_stock_and_date();

                    header("HTTP/1.1 200 OK");
                    $array_retorno = array("respuesta"=>'Compra realizada con exito',"resultado"=>'');
                }

            }

        }else{
            header("HTTP/1.1 400 BAD REQUEST");
            $array_retorno = array("respuesta"=>'Solicitud Inválida',"resultado"=>'');
        }

        echo json_encode($array_retorno);
    }

}

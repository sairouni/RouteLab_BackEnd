<?php

abstract class BasedeDatos {

    static $server = "localhost";
    static $user = "root";
    static $password = "";
    static $database = "routelab";
    protected $table; //Nombre de la tabla
    protected $idField; //Nombre del campo clave
    protected $fields;  //Array con los nombres de los campos (opcional)
    protected $showFields; //Array con los nombres de los campos a mostrar en determinadas consultas (opcional)
    static protected $conn;

    /**
     * El constructor necesita el nombre de la tabla y el nombre del campo clave
     * Opcionalmente podemos indicar los campos que tiene la tabla y aquellos que queremos mostrar
     * Cuando se haga una selección
     * @param type $table
     * @param type $idField
     * @param type $fields
     * @param type $showFields
     */
    public function __construct($table, $idField, $fields = "", $showFields = "") {
        $this->table = $table;
        $this->idField = $idField;
        $this->fields = $fields;
        $this->showFields = $showFields;
        self::conectar();
    }

    /**
     * Función de conexión
     */
    static function conectar() {
        try {
            self::$conn = new PDO("mysql:host=" . self::$server . ";dbname=" . self::$database, self::$user, self::$password, [PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES 'utf8'"]);
            self::$conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        } catch (Exception $ex) {
            echo $ex->getMessage();
        }
    }

    /**
     * Getter de las propiedades
     * @param type $name
     * @return type
     */
    function __get($name) {
        if (property_exists($this, $name)) {
            return $this->$name;
        }
    }

    /**
     * Setter de las propiedades
     * @param type $name
     * @param type $value
     * @throws Exception
     */
    function __set($name, $value) {
        if (property_exists($this, $name) && !empty($value)) {
            $this->$name = $value;
        } else {
            throw new Exception("Error: datos incorrectos");
        }
    }

    function getAll($condicion = [], $completo = true) {
        try {
            $where = "";
            $campos = " * ";
            if (!empty($condicion)) {
                $where = " where " . join(" and ", array_map(function($v) {
                                    return $v . "=:" . $v;
                                }, array_keys($condicion)));
            }
            if (!$completo && !empty($this->showFields)) {
                $campos = implode(",", $this->showFields);
            }
            $st = self::$conn->prepare("select $campos from " . $this->table . $where);
            $st->execute($condicion);
            return $st->fetchAll(PDO::FETCH_ASSOC);
        } catch (Exception $ex) {
            echo $ex->getMessage();
        }
    }

    /**
     * Esta función nos devuelve el elemento de la tabla que tenga este id
     * @param int $id El id de la fila
     */
    function getById($id) {
        $res = self::$conn->query("select * from " . $this->table . " where "
                . $this->idField . "=" . $id);
        return $res->fetch(PDO::FETCH_ASSOC);
    }

    /**
     * Elimina el registro que tenga el id que le pasamos
     * @param int $id
     */
    protected function deleteById($id) {

        try {

            self::$conn->exec("delete from " . $this->table . " where "
                    . $this->idField . "=" . $id);
        } catch (Exception $ex) {
            echo $ex->getMessage();
        }
    }

    protected function insert($valores) {
        try {
            $campos = join(",", array_keys($valores));
            $parametros = ":" . join(",:", array_keys($valores));
            $sql = "insert into " . $this->table . "($campos) values ($parametros)";
            $st = self::$conn->prepare($sql);
            $st->execute($valores);
        } catch (Exception $ex) {
            echo $ex->getMessage();
        }
    }

    protected function update($id, $valores) {
        try {
            //Creamos el cuerpo del select con la función array_map
            $campos = join(",", array_map(function($v) {
                        return $v . "=:" . $v;
                    }, array_keys($valores)));
            $sql = "update " . $this->table . " set " . $campos . " where "
                    . $this->idField . " = " . $id;
            $st = self::$conn->prepare($sql);
            $st->execute($valores);
        } catch (Exception $ex) {
            echo $ex->getMessage();
        }
    }

    function buscador_usu($nombreusuario) {


        $res = self::$conn->query("select * from usuario where nombreusuario LIKE '%" . ($nombreusuario) . "%'");

        return $res->fetchAll(PDO::FETCH_ASSOC);
    }

    function buscador_ruta($valor) {


        $res = self::$conn->query("select * from post where titulo LIKE '%" . ($valor) . "%' or descripcion LIKE '%" . ($valor) . "%'");

        return $res->fetchAll(PDO::FETCH_ASSOC);
    }

    function buscador_ciudad($ciudad) {


        $res = self::$conn->query("select * from localidad where poblacion ='" . $ciudad . "'");
        return $res->fetchAll(PDO::FETCH_ASSOC);
    }

    function buscador_categoria($categoria) {


        $res = self::$conn->query("select * from post where categoria ='" . $categoria . "'");

        return $res->fetchAll(PDO::FETCH_ASSOC);
    }

    function baselocalidades($idlocalidades) {
        $st = self::$conn->prepare("select * from asociada where idlocalidad in (" . implode(",", $idlocalidades) . ")");
        $st->execute();
        return $st->fetchAll(PDO::FETCH_ASSOC);
    }

    function valores() {

        $valores = array_map(function($v) {
            if (gettype($this->$v) == "object") {
                return (string) $this->$v;
            } else {
                return $this->$v;
            }
        }, $this->fields);
        return array_combine($this->fields, $valores);
    }

    function serialize() {
        return $this->valores();
    }

    function busc($valores) {
        return $this->buscador($valores);
    }

    function loadAll() {
        $post = $this->getAll();
        return $post;
    }

    abstract function load($id);

    abstract function save();

    abstract function delete();

    function existe($dato) {
        $res = $this->getAll($dato);
        return !empty($res);
    }

    function idexiste($body) {
        $aa = $this->getAll($body);
        if (empty($aa)) {

            return false;
        } else {

            return $aa[0][$this->idField];
        }
    }

    function existeft($body) {
        $aa = $this->getAll($body);
        if (empty($aa)) {

            return false;
        } else {

            return true;
        }
    }

    function __toString() {
        $a = json_encode($this->valores());
        return $a;
    }

}

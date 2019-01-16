
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
            echo $ex->message;
        }
    }

    /**
     * Esta función nos devuelve el elemento de la tabla que tenga este id
     * @param int $id El id de la fila
     */
    protected function getById($id) {
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

    abstract function load($id);

    abstract function save();

    abstract function delete();
}

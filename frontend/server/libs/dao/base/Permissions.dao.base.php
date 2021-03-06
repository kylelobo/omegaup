<?php

/** ******************************************************************************* *
  *                    !ATENCION!                                                   *
  *                                                                                 *
  * Este codigo es generado automaticamente. Si lo modificas tus cambios seran      *
  * reemplazados la proxima vez que se autogenere el codigo.                        *
  *                                                                                 *
  * ******************************************************************************* */

/** Permissions Data Access Object (DAO) Base.
 *
 * Esta clase contiene toda la manipulacion de bases de datos que se necesita
 * para almacenar de forma permanente y recuperar instancias de objetos
 * {@link Permissions}.
 * @access public
 * @abstract
 *
 */
abstract class PermissionsDAOBase {
    /**
     * Guardar registros.
     *
     * Este metodo guarda el estado actual del objeto {@link Permissions}
     * pasado en la base de datos. La llave primaria indicará qué instancia va
     * a ser actualizada en base de datos. Si la llave primara o combinación de
     * llaves primarias que describen una fila que no se encuentra en la base de
     * datos, entonces save() creará una nueva fila, insertando en ese objeto
     * el ID recién creado.
     *
     * @static
     * @throws Exception si la operacion fallo.
     * @param Permissions [$Permissions] El objeto de tipo Permissions
     * @return Un entero mayor o igual a cero identificando el número de filas afectadas.
     */
    final public static function save(Permissions $Permissions) {
        if (is_null(self::getByPK($Permissions->permission_id))) {
            return PermissionsDAOBase::create($Permissions);
        }
        return PermissionsDAOBase::update($Permissions);
    }

    /**
     * Actualizar registros.
     *
     * @static
     * @return Filas afectadas
     * @param Permissions [$Permissions] El objeto de tipo Permissions a actualizar.
     */
    final public static function update(Permissions $Permissions) {
        $sql = 'UPDATE `Permissions` SET `name` = ?, `description` = ? WHERE `permission_id` = ?;';
        $params = [
            $Permissions->name,
            $Permissions->description,
            is_null($Permissions->permission_id) ? null : (int)$Permissions->permission_id,
        ];
        global $conn;
        $conn->Execute($sql, $params);
        return $conn->Affected_Rows();
    }

    /**
     * Obtener {@link Permissions} por llave primaria.
     *
     * Este metodo cargará un objeto {@link Permissions} de la base
     * de datos usando sus llaves primarias.
     *
     * @static
     * @return @link Permissions Un objeto del tipo {@link Permissions}. NULL si no hay tal registro.
     */
    final public static function getByPK($permission_id) {
        if (is_null($permission_id)) {
            return null;
        }
        $sql = 'SELECT `Permissions`.`permission_id`, `Permissions`.`name`, `Permissions`.`description` FROM Permissions WHERE (permission_id = ?) LIMIT 1;';
        $params = [$permission_id];
        global $conn;
        $row = $conn->GetRow($sql, $params);
        if (empty($row)) {
            return null;
        }
        return new Permissions($row);
    }

    /**
     * Eliminar registros.
     *
     * Este metodo eliminará el registro identificado por la llave primaria en
     * el objeto Permissions suministrado. Una vez que se ha
     * eliminado un objeto, este no puede ser restaurado llamando a
     * {@link save()}, ya que este último creará un nuevo registro con una
     * llave primaria distinta a la que estaba en el objeto eliminado.
     *
     * Si no puede encontrar el registro a eliminar, {@link Exception} será
     * arrojada.
     *
     * @static
     * @throws Exception Se arroja cuando no se encuentra el objeto a eliminar en la base de datos.
     * @param Permissions [$Permissions] El objeto de tipo Permissions a eliminar
     */
    final public static function delete(Permissions $Permissions) {
        $sql = 'DELETE FROM `Permissions` WHERE permission_id = ?;';
        $params = [$Permissions->permission_id];
        global $conn;

        $conn->Execute($sql, $params);
        if ($conn->Affected_Rows() == 0) {
            throw new NotFoundException('recordNotFound');
        }
    }

    /**
     * Obtener todas las filas.
     *
     * Esta funcion leerá todos los contenidos de la tabla en la base de datos
     * y construirá un arreglo que contiene objetos de tipo {@link Permissions}.
     * Este método consume una cantidad de memoria proporcional al número de
     * registros regresados, así que sólo debe usarse cuando la tabla en
     * cuestión es pequeña o se proporcionan parámetros para obtener un menor
     * número de filas.
     *
     * @static
     * @param $pagina Página a ver.
     * @param $filasPorPagina Filas por página.
     * @param $orden Debe ser una cadena con el nombre de una columna en la base de datos.
     * @param $tipoDeOrden 'ASC' o 'DESC' el default es 'ASC'
     * @return Array Un arreglo que contiene objetos del tipo {@link Permissions}.
     */
    final public static function getAll($pagina = null, $filasPorPagina = null, $orden = null, $tipoDeOrden = 'ASC') {
        $sql = 'SELECT `Permissions`.`permission_id`, `Permissions`.`name`, `Permissions`.`description` from Permissions';
        global $conn;
        if (!is_null($orden)) {
            $sql .= ' ORDER BY `' . $conn->escape($orden) . '` ' . ($tipoDeOrden == 'DESC' ? 'DESC' : 'ASC');
        }
        if (!is_null($pagina)) {
            $sql .= ' LIMIT ' . (($pagina - 1) * $filasPorPagina) . ', ' . (int)$filasPorPagina;
        }
        $allData = [];
        foreach ($conn->GetAll($sql) as $row) {
            $allData[] = new Permissions($row);
        }
        return $allData;
    }

    /**
     * Crear registros.
     *
     * Este metodo creará una nueva fila en la base de datos de acuerdo con los
     * contenidos del objeto Permissions suministrado.
     *
     * @static
     * @return Un entero mayor o igual a cero identificando el número de filas afectadas.
     * @param Permissions [$Permissions] El objeto de tipo Permissions a crear.
     */
    final public static function create(Permissions $Permissions) {
        $sql = 'INSERT INTO Permissions (`name`, `description`) VALUES (?, ?);';
        $params = [
            $Permissions->name,
            $Permissions->description,
        ];
        global $conn;
        $conn->Execute($sql, $params);
        $ar = $conn->Affected_Rows();
        if ($ar == 0) {
            return 0;
        }
        $Permissions->permission_id = $conn->Insert_ID();

        return $ar;
    }
}

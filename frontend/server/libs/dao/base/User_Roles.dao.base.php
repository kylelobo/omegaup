<?php

/** ******************************************************************************* *
  *                    !ATENCION!                                                   *
  *                                                                                 *
  * Este codigo es generado automaticamente. Si lo modificas tus cambios seran      *
  * reemplazados la proxima vez que se autogenere el codigo.                        *
  *                                                                                 *
  * ******************************************************************************* */

/** UserRoles Data Access Object (DAO) Base.
 *
 * Esta clase contiene toda la manipulacion de bases de datos que se necesita
 * para almacenar de forma permanente y recuperar instancias de objetos
 * {@link UserRoles}.
 * @access public
 * @abstract
 *
 */
abstract class UserRolesDAOBase {
    /**
     * Obtener {@link UserRoles} por llave primaria.
     *
     * Este metodo cargará un objeto {@link UserRoles} de la base
     * de datos usando sus llaves primarias.
     *
     * @static
     * @return @link UserRoles Un objeto del tipo {@link UserRoles}. NULL si no hay tal registro.
     */
    final public static function getByPK($user_id, $role_id, $acl_id) {
        if (is_null($user_id) || is_null($role_id) || is_null($acl_id)) {
            return null;
        }
        $sql = 'SELECT `User_Roles`.`user_id`, `User_Roles`.`role_id`, `User_Roles`.`acl_id` FROM User_Roles WHERE (user_id = ? AND role_id = ? AND acl_id = ?) LIMIT 1;';
        $params = [$user_id, $role_id, $acl_id];
        global $conn;
        $row = $conn->GetRow($sql, $params);
        if (empty($row)) {
            return null;
        }
        return new UserRoles($row);
    }

    /**
     * Eliminar registros.
     *
     * Este metodo eliminará el registro identificado por la llave primaria en
     * el objeto UserRoles suministrado. Una vez que se ha
     * eliminado un objeto, este no puede ser restaurado llamando a
     * {@link save()}, ya que este último creará un nuevo registro con una
     * llave primaria distinta a la que estaba en el objeto eliminado.
     *
     * Si no puede encontrar el registro a eliminar, {@link Exception} será
     * arrojada.
     *
     * @static
     * @throws Exception Se arroja cuando no se encuentra el objeto a eliminar en la base de datos.
     * @param UserRoles [$User_Roles] El objeto de tipo UserRoles a eliminar
     */
    final public static function delete(UserRoles $User_Roles) {
        $sql = 'DELETE FROM `User_Roles` WHERE user_id = ? AND role_id = ? AND acl_id = ?;';
        $params = [$User_Roles->user_id, $User_Roles->role_id, $User_Roles->acl_id];
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
     * y construirá un arreglo que contiene objetos de tipo {@link UserRoles}.
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
     * @return Array Un arreglo que contiene objetos del tipo {@link UserRoles}.
     */
    final public static function getAll($pagina = null, $filasPorPagina = null, $orden = null, $tipoDeOrden = 'ASC') {
        $sql = 'SELECT `User_Roles`.`user_id`, `User_Roles`.`role_id`, `User_Roles`.`acl_id` from User_Roles';
        global $conn;
        if (!is_null($orden)) {
            $sql .= ' ORDER BY `' . $conn->escape($orden) . '` ' . ($tipoDeOrden == 'DESC' ? 'DESC' : 'ASC');
        }
        if (!is_null($pagina)) {
            $sql .= ' LIMIT ' . (($pagina - 1) * $filasPorPagina) . ', ' . (int)$filasPorPagina;
        }
        $allData = [];
        foreach ($conn->GetAll($sql) as $row) {
            $allData[] = new UserRoles($row);
        }
        return $allData;
    }

    /**
     * Crear registros.
     *
     * Este metodo creará una nueva fila en la base de datos de acuerdo con los
     * contenidos del objeto UserRoles suministrado.
     *
     * @static
     * @return Un entero mayor o igual a cero identificando el número de filas afectadas.
     * @param UserRoles [$User_Roles] El objeto de tipo UserRoles a crear.
     */
    final public static function create(UserRoles $User_Roles) {
        $sql = 'INSERT INTO User_Roles (`user_id`, `role_id`, `acl_id`) VALUES (?, ?, ?);';
        $params = [
            is_null($User_Roles->user_id) ? null : (int)$User_Roles->user_id,
            is_null($User_Roles->role_id) ? null : (int)$User_Roles->role_id,
            is_null($User_Roles->acl_id) ? null : (int)$User_Roles->acl_id,
        ];
        global $conn;
        $conn->Execute($sql, $params);
        $ar = $conn->Affected_Rows();
        if ($ar == 0) {
            return 0;
        }

        return $ar;
    }
}

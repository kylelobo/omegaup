<?php

/** ******************************************************************************* *
  *                    !ATENCION!                                                   *
  *                                                                                 *
  * Este codigo es generado automaticamente. Si lo modificas tus cambios seran      *
  * reemplazados la proxima vez que se autogenere el codigo.                        *
  *                                                                                 *
  * ******************************************************************************* */

/** ACLs Data Access Object (DAO) Base.
 *
 * Esta clase contiene toda la manipulacion de bases de datos que se necesita
 * para almacenar de forma permanente y recuperar instancias de objetos
 * {@link ACLs}.
 * @access public
 * @abstract
 *
 */
abstract class ACLsDAOBase {
    /**
     * Guardar registros.
     *
     * Este metodo guarda el estado actual del objeto {@link ACLs}
     * pasado en la base de datos. La llave primaria indicará qué instancia va
     * a ser actualizada en base de datos. Si la llave primara o combinación de
     * llaves primarias que describen una fila que no se encuentra en la base de
     * datos, entonces save() creará una nueva fila, insertando en ese objeto
     * el ID recién creado.
     *
     * @static
     * @throws Exception si la operacion fallo.
     * @param ACLs [$ACLs] El objeto de tipo ACLs
     * @return Un entero mayor o igual a cero identificando el número de filas afectadas.
     */
    final public static function save(ACLs $ACLs) {
        if (is_null(self::getByPK($ACLs->acl_id))) {
            return ACLsDAOBase::create($ACLs);
        }
        return ACLsDAOBase::update($ACLs);
    }

    /**
     * Actualizar registros.
     *
     * @static
     * @return Filas afectadas
     * @param ACLs [$ACLs] El objeto de tipo ACLs a actualizar.
     */
    final public static function update(ACLs $ACLs) {
        $sql = 'UPDATE `ACLs` SET `owner_id` = ? WHERE `acl_id` = ?;';
        $params = [
            is_null($ACLs->owner_id) ? null : (int)$ACLs->owner_id,
            is_null($ACLs->acl_id) ? null : (int)$ACLs->acl_id,
        ];
        global $conn;
        $conn->Execute($sql, $params);
        return $conn->Affected_Rows();
    }

    /**
     * Obtener {@link ACLs} por llave primaria.
     *
     * Este metodo cargará un objeto {@link ACLs} de la base
     * de datos usando sus llaves primarias.
     *
     * @static
     * @return @link ACLs Un objeto del tipo {@link ACLs}. NULL si no hay tal registro.
     */
    final public static function getByPK($acl_id) {
        if (is_null($acl_id)) {
            return null;
        }
        $sql = 'SELECT `ACLs`.`acl_id`, `ACLs`.`owner_id` FROM ACLs WHERE (acl_id = ?) LIMIT 1;';
        $params = [$acl_id];
        global $conn;
        $row = $conn->GetRow($sql, $params);
        if (empty($row)) {
            return null;
        }
        return new ACLs($row);
    }

    /**
     * Eliminar registros.
     *
     * Este metodo eliminará el registro identificado por la llave primaria en
     * el objeto ACLs suministrado. Una vez que se ha
     * eliminado un objeto, este no puede ser restaurado llamando a
     * {@link save()}, ya que este último creará un nuevo registro con una
     * llave primaria distinta a la que estaba en el objeto eliminado.
     *
     * Si no puede encontrar el registro a eliminar, {@link Exception} será
     * arrojada.
     *
     * @static
     * @throws Exception Se arroja cuando no se encuentra el objeto a eliminar en la base de datos.
     * @param ACLs [$ACLs] El objeto de tipo ACLs a eliminar
     */
    final public static function delete(ACLs $ACLs) {
        $sql = 'DELETE FROM `ACLs` WHERE acl_id = ?;';
        $params = [$ACLs->acl_id];
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
     * y construirá un arreglo que contiene objetos de tipo {@link ACLs}.
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
     * @return Array Un arreglo que contiene objetos del tipo {@link ACLs}.
     */
    final public static function getAll($pagina = null, $filasPorPagina = null, $orden = null, $tipoDeOrden = 'ASC') {
        $sql = 'SELECT `ACLs`.`acl_id`, `ACLs`.`owner_id` from ACLs';
        global $conn;
        if (!is_null($orden)) {
            $sql .= ' ORDER BY `' . $conn->escape($orden) . '` ' . ($tipoDeOrden == 'DESC' ? 'DESC' : 'ASC');
        }
        if (!is_null($pagina)) {
            $sql .= ' LIMIT ' . (($pagina - 1) * $filasPorPagina) . ', ' . (int)$filasPorPagina;
        }
        $allData = [];
        foreach ($conn->GetAll($sql) as $row) {
            $allData[] = new ACLs($row);
        }
        return $allData;
    }

    /**
     * Crear registros.
     *
     * Este metodo creará una nueva fila en la base de datos de acuerdo con los
     * contenidos del objeto ACLs suministrado.
     *
     * @static
     * @return Un entero mayor o igual a cero identificando el número de filas afectadas.
     * @param ACLs [$ACLs] El objeto de tipo ACLs a crear.
     */
    final public static function create(ACLs $ACLs) {
        $sql = 'INSERT INTO ACLs (`owner_id`) VALUES (?);';
        $params = [
            is_null($ACLs->owner_id) ? null : (int)$ACLs->owner_id,
        ];
        global $conn;
        $conn->Execute($sql, $params);
        $ar = $conn->Affected_Rows();
        if ($ar == 0) {
            return 0;
        }
        $ACLs->acl_id = $conn->Insert_ID();

        return $ar;
    }
}

<?php

namespace Sandbox\Model\Map;

use Propel\Runtime\Propel;
use Propel\Runtime\ActiveQuery\Criteria;
use Propel\Runtime\ActiveQuery\InstancePoolTrait;
use Propel\Runtime\Connection\ConnectionInterface;
use Propel\Runtime\Exception\PropelException;
use Propel\Runtime\Map\RelationMap;
use Propel\Runtime\Map\TableMap;
use Propel\Runtime\Map\TableMapTrait;
use Sandbox\Model\Rol;
use Sandbox\Model\RolQuery;


/**
 * This class defines the structure of the 'rol' table.
 *
 *
 *
 * This map class is used by Propel to do runtime db structure discovery.
 * For example, the createSelectSql() method checks the type of a given column used in an
 * ORDER BY clause to know whether it needs to apply SQL to make the ORDER BY case-insensitive
 * (i.e. if it's a text column type).
 *
 */
class RolTableMap extends TableMap
{
    use InstancePoolTrait;
    use TableMapTrait;
    /**
     * The (dot-path) name of this class
     */
    const CLASS_NAME = 'Sandbox.Model.Map.RolTableMap';

    /**
     * The default database name for this class
     */
    const DATABASE_NAME = 'Sandbox';

    /**
     * The table name for this class
     */
    const TABLE_NAME = 'rol';

    /**
     * The related Propel class for this table
     */
    const OM_CLASS = '\\Sandbox\\Model\\Rol';

    /**
     * A class that can be returned by this tableMap
     */
    const CLASS_DEFAULT = 'Sandbox.Model.Rol';

    /**
     * The total number of columns
     */
    const NUM_COLUMNS = 6;

    /**
     * The number of lazy-loaded columns
     */
    const NUM_LAZY_LOAD_COLUMNS = 0;

    /**
     * The number of columns to hydrate (NUM_COLUMNS - NUM_LAZY_LOAD_COLUMNS)
     */
    const NUM_HYDRATE_COLUMNS = 6;

    /**
     * the column name for the ROL_ID field
     */
    const ROL_ID = 'rol.ROL_ID';

    /**
     * the column name for the ROL_NAME field
     */
    const ROL_NAME = 'rol.ROL_NAME';

    /**
     * the column name for the ROL_DESCRIPTION field
     */
    const ROL_DESCRIPTION = 'rol.ROL_DESCRIPTION';

    /**
     * the column name for the ROL_CREATE_DATE field
     */
    const ROL_CREATE_DATE = 'rol.ROL_CREATE_DATE';

    /**
     * the column name for the ROL_UPDATE_DATE field
     */
    const ROL_UPDATE_DATE = 'rol.ROL_UPDATE_DATE';

    /**
     * the column name for the ROL_STATUS field
     */
    const ROL_STATUS = 'rol.ROL_STATUS';

    /**
     * The default string format for model objects of the related table
     */
    const DEFAULT_STRING_FORMAT = 'YAML';

    /**
     * holds an array of fieldnames
     *
     * first dimension keys are the type constants
     * e.g. self::$fieldNames[self::TYPE_PHPNAME][0] = 'Id'
     */
    protected static $fieldNames = array (
        self::TYPE_PHPNAME       => array('RolId', 'RolName', 'RolDescription', 'RolCreateDate', 'RolUpdateDate', 'RolStatus', ),
        self::TYPE_STUDLYPHPNAME => array('rolId', 'rolName', 'rolDescription', 'rolCreateDate', 'rolUpdateDate', 'rolStatus', ),
        self::TYPE_COLNAME       => array(RolTableMap::ROL_ID, RolTableMap::ROL_NAME, RolTableMap::ROL_DESCRIPTION, RolTableMap::ROL_CREATE_DATE, RolTableMap::ROL_UPDATE_DATE, RolTableMap::ROL_STATUS, ),
        self::TYPE_RAW_COLNAME   => array('ROL_ID', 'ROL_NAME', 'ROL_DESCRIPTION', 'ROL_CREATE_DATE', 'ROL_UPDATE_DATE', 'ROL_STATUS', ),
        self::TYPE_FIELDNAME     => array('rol_id', 'rol_name', 'rol_description', 'rol_create_date', 'rol_update_date', 'rol_status', ),
        self::TYPE_NUM           => array(0, 1, 2, 3, 4, 5, )
    );

    /**
     * holds an array of keys for quick access to the fieldnames array
     *
     * first dimension keys are the type constants
     * e.g. self::$fieldKeys[self::TYPE_PHPNAME]['Id'] = 0
     */
    protected static $fieldKeys = array (
        self::TYPE_PHPNAME       => array('RolId' => 0, 'RolName' => 1, 'RolDescription' => 2, 'RolCreateDate' => 3, 'RolUpdateDate' => 4, 'RolStatus' => 5, ),
        self::TYPE_STUDLYPHPNAME => array('rolId' => 0, 'rolName' => 1, 'rolDescription' => 2, 'rolCreateDate' => 3, 'rolUpdateDate' => 4, 'rolStatus' => 5, ),
        self::TYPE_COLNAME       => array(RolTableMap::ROL_ID => 0, RolTableMap::ROL_NAME => 1, RolTableMap::ROL_DESCRIPTION => 2, RolTableMap::ROL_CREATE_DATE => 3, RolTableMap::ROL_UPDATE_DATE => 4, RolTableMap::ROL_STATUS => 5, ),
        self::TYPE_RAW_COLNAME   => array('ROL_ID' => 0, 'ROL_NAME' => 1, 'ROL_DESCRIPTION' => 2, 'ROL_CREATE_DATE' => 3, 'ROL_UPDATE_DATE' => 4, 'ROL_STATUS' => 5, ),
        self::TYPE_FIELDNAME     => array('rol_id' => 0, 'rol_name' => 1, 'rol_description' => 2, 'rol_create_date' => 3, 'rol_update_date' => 4, 'rol_status' => 5, ),
        self::TYPE_NUM           => array(0, 1, 2, 3, 4, 5, )
    );

    /**
     * Initialize the table attributes and columns
     * Relations are not initialized by this method since they are lazy loaded
     *
     * @return void
     * @throws PropelException
     */
    public function initialize()
    {
        // attributes
        $this->setName('rol');
        $this->setPhpName('Rol');
        $this->setClassName('\\Sandbox\\Model\\Rol');
        $this->setPackage('Sandbox.Model');
        $this->setUseIdGenerator(true);
        // columns
        $this->addPrimaryKey('ROL_ID', 'RolId', 'INTEGER', true, null, null);
        $this->addColumn('ROL_NAME', 'RolName', 'VARCHAR', true, 128, null);
        $this->addColumn('ROL_DESCRIPTION', 'RolDescription', 'VARCHAR', true, 128, null);
        $this->addColumn('ROL_CREATE_DATE', 'RolCreateDate', 'TIMESTAMP', false, null, null);
        $this->addColumn('ROL_UPDATE_DATE', 'RolUpdateDate', 'TIMESTAMP', false, null, null);
        $this->addColumn('ROL_STATUS', 'RolStatus', 'VARCHAR', false, 64, 'ACTIVE');
    } // initialize()

    /**
     * Build the RelationMap objects for this table relationships
     */
    public function buildRelations()
    {
        $this->addRelation('UserRol', '\\Sandbox\\Model\\UserRol', RelationMap::ONE_TO_MANY, array('rol_id' => 'rol_id', ), 'CASCADE', null, 'UserRols');
        $this->addRelation('RolPermission', '\\Sandbox\\Model\\RolPermission', RelationMap::ONE_TO_MANY, array('rol_id' => 'rol_id', ), 'CASCADE', null, 'RolPermissions');
    } // buildRelations()
    /**
     * Method to invalidate the instance pool of all tables related to rol     * by a foreign key with ON DELETE CASCADE
     */
    public static function clearRelatedInstancePool()
    {
        // Invalidate objects in ".$this->getClassNameFromBuilder($joinedTableTableMapBuilder)." instance pool,
        // since one or more of them may be deleted by ON DELETE CASCADE/SETNULL rule.
                UserRolTableMap::clearInstancePool();
                RolPermissionTableMap::clearInstancePool();
            }

    /**
     * Retrieves a string version of the primary key from the DB resultset row that can be used to uniquely identify a row in this table.
     *
     * For tables with a single-column primary key, that simple pkey value will be returned.  For tables with
     * a multi-column primary key, a serialize()d version of the primary key will be returned.
     *
     * @param array  $row       resultset row.
     * @param int    $offset    The 0-based offset for reading from the resultset row.
     * @param string $indexType One of the class type constants TableMap::TYPE_PHPNAME, TableMap::TYPE_STUDLYPHPNAME
     *                           TableMap::TYPE_COLNAME, TableMap::TYPE_FIELDNAME, TableMap::TYPE_NUM
     */
    public static function getPrimaryKeyHashFromRow($row, $offset = 0, $indexType = TableMap::TYPE_NUM)
    {
        // If the PK cannot be derived from the row, return NULL.
        if ($row[TableMap::TYPE_NUM == $indexType ? 0 + $offset : static::translateFieldName('RolId', TableMap::TYPE_PHPNAME, $indexType)] === null) {
            return null;
        }

        return (string) $row[TableMap::TYPE_NUM == $indexType ? 0 + $offset : static::translateFieldName('RolId', TableMap::TYPE_PHPNAME, $indexType)];
    }

    /**
     * Retrieves the primary key from the DB resultset row
     * For tables with a single-column primary key, that simple pkey value will be returned.  For tables with
     * a multi-column primary key, an array of the primary key columns will be returned.
     *
     * @param array  $row       resultset row.
     * @param int    $offset    The 0-based offset for reading from the resultset row.
     * @param string $indexType One of the class type constants TableMap::TYPE_PHPNAME, TableMap::TYPE_STUDLYPHPNAME
     *                           TableMap::TYPE_COLNAME, TableMap::TYPE_FIELDNAME, TableMap::TYPE_NUM
     *
     * @return mixed The primary key of the row
     */
    public static function getPrimaryKeyFromRow($row, $offset = 0, $indexType = TableMap::TYPE_NUM)
    {

            return (int) $row[
                            $indexType == TableMap::TYPE_NUM
                            ? 0 + $offset
                            : self::translateFieldName('RolId', TableMap::TYPE_PHPNAME, $indexType)
                        ];
    }

    /**
     * The class that the tableMap will make instances of.
     *
     * If $withPrefix is true, the returned path
     * uses a dot-path notation which is translated into a path
     * relative to a location on the PHP include_path.
     * (e.g. path.to.MyClass -> 'path/to/MyClass.php')
     *
     * @param boolean $withPrefix Whether or not to return the path with the class name
     * @return string path.to.ClassName
     */
    public static function getOMClass($withPrefix = true)
    {
        return $withPrefix ? RolTableMap::CLASS_DEFAULT : RolTableMap::OM_CLASS;
    }

    /**
     * Populates an object of the default type or an object that inherit from the default.
     *
     * @param array  $row       row returned by DataFetcher->fetch().
     * @param int    $offset    The 0-based offset for reading from the resultset row.
     * @param string $indexType The index type of $row. Mostly DataFetcher->getIndexType().
                                 One of the class type constants TableMap::TYPE_PHPNAME, TableMap::TYPE_STUDLYPHPNAME
     *                           TableMap::TYPE_COLNAME, TableMap::TYPE_FIELDNAME, TableMap::TYPE_NUM.
     *
     * @throws PropelException Any exceptions caught during processing will be
     *         rethrown wrapped into a PropelException.
     * @return array (Rol object, last column rank)
     */
    public static function populateObject($row, $offset = 0, $indexType = TableMap::TYPE_NUM)
    {
        $key = RolTableMap::getPrimaryKeyHashFromRow($row, $offset, $indexType);
        if (null !== ($obj = RolTableMap::getInstanceFromPool($key))) {
            // We no longer rehydrate the object, since this can cause data loss.
            // See http://www.propelorm.org/ticket/509
            // $obj->hydrate($row, $offset, true); // rehydrate
            $col = $offset + RolTableMap::NUM_HYDRATE_COLUMNS;
        } else {
            $cls = RolTableMap::OM_CLASS;
            $obj = new $cls();
            $col = $obj->hydrate($row, $offset, false, $indexType);
            RolTableMap::addInstanceToPool($obj, $key);
        }

        return array($obj, $col);
    }

    /**
     * The returned array will contain objects of the default type or
     * objects that inherit from the default.
     *
     * @param DataFetcherInterface $dataFetcher
     * @return array
     * @throws PropelException Any exceptions caught during processing will be
     *         rethrown wrapped into a PropelException.
     */
    public static function populateObjects(DataFetcherInterface $dataFetcher)
    {
        $results = array();

        // set the class once to avoid overhead in the loop
        $cls = static::getOMClass(false);
        // populate the object(s)
        while ($row = $dataFetcher->fetch()) {
            $key = RolTableMap::getPrimaryKeyHashFromRow($row, 0, $dataFetcher->getIndexType());
            if (null !== ($obj = RolTableMap::getInstanceFromPool($key))) {
                // We no longer rehydrate the object, since this can cause data loss.
                // See http://www.propelorm.org/ticket/509
                // $obj->hydrate($row, 0, true); // rehydrate
                $results[] = $obj;
            } else {
                $obj = new $cls();
                $obj->hydrate($row);
                $results[] = $obj;
                RolTableMap::addInstanceToPool($obj, $key);
            } // if key exists
        }

        return $results;
    }
    /**
     * Add all the columns needed to create a new object.
     *
     * Note: any columns that were marked with lazyLoad="true" in the
     * XML schema will not be added to the select list and only loaded
     * on demand.
     *
     * @param Criteria $criteria object containing the columns to add.
     * @param string   $alias    optional table alias
     * @throws PropelException Any exceptions caught during processing will be
     *         rethrown wrapped into a PropelException.
     */
    public static function addSelectColumns(Criteria $criteria, $alias = null)
    {
        if (null === $alias) {
            $criteria->addSelectColumn(RolTableMap::ROL_ID);
            $criteria->addSelectColumn(RolTableMap::ROL_NAME);
            $criteria->addSelectColumn(RolTableMap::ROL_DESCRIPTION);
            $criteria->addSelectColumn(RolTableMap::ROL_CREATE_DATE);
            $criteria->addSelectColumn(RolTableMap::ROL_UPDATE_DATE);
            $criteria->addSelectColumn(RolTableMap::ROL_STATUS);
        } else {
            $criteria->addSelectColumn($alias . '.ROL_ID');
            $criteria->addSelectColumn($alias . '.ROL_NAME');
            $criteria->addSelectColumn($alias . '.ROL_DESCRIPTION');
            $criteria->addSelectColumn($alias . '.ROL_CREATE_DATE');
            $criteria->addSelectColumn($alias . '.ROL_UPDATE_DATE');
            $criteria->addSelectColumn($alias . '.ROL_STATUS');
        }
    }

    /**
     * Returns the TableMap related to this object.
     * This method is not needed for general use but a specific application could have a need.
     * @return TableMap
     * @throws PropelException Any exceptions caught during processing will be
     *         rethrown wrapped into a PropelException.
     */
    public static function getTableMap()
    {
        return Propel::getServiceContainer()->getDatabaseMap(RolTableMap::DATABASE_NAME)->getTable(RolTableMap::TABLE_NAME);
    }

    /**
     * Add a TableMap instance to the database for this tableMap class.
     */
    public static function buildTableMap()
    {
      $dbMap = Propel::getServiceContainer()->getDatabaseMap(RolTableMap::DATABASE_NAME);
      if (!$dbMap->hasTable(RolTableMap::TABLE_NAME)) {
        $dbMap->addTableObject(new RolTableMap());
      }
    }

    /**
     * Performs a DELETE on the database, given a Rol or Criteria object OR a primary key value.
     *
     * @param mixed               $values Criteria or Rol object or primary key or array of primary keys
     *              which is used to create the DELETE statement
     * @param ConnectionInterface $con the connection to use
     * @return int The number of affected rows (if supported by underlying database driver).  This includes CASCADE-related rows
     *                if supported by native driver or if emulated using Propel.
     * @throws PropelException Any exceptions caught during processing will be
     *         rethrown wrapped into a PropelException.
     */
     public static function doDelete($values, ConnectionInterface $con = null)
     {
        if (null === $con) {
            $con = Propel::getServiceContainer()->getWriteConnection(RolTableMap::DATABASE_NAME);
        }

        if ($values instanceof Criteria) {
            // rename for clarity
            $criteria = $values;
        } elseif ($values instanceof \Sandbox\Model\Rol) { // it's a model object
            // create criteria based on pk values
            $criteria = $values->buildPkeyCriteria();
        } else { // it's a primary key, or an array of pks
            $criteria = new Criteria(RolTableMap::DATABASE_NAME);
            $criteria->add(RolTableMap::ROL_ID, (array) $values, Criteria::IN);
        }

        $query = RolQuery::create()->mergeWith($criteria);

        if ($values instanceof Criteria) { RolTableMap::clearInstancePool();
        } elseif (!is_object($values)) { // it's a primary key, or an array of pks
            foreach ((array) $values as $singleval) { RolTableMap::removeInstanceFromPool($singleval);
            }
        }

        return $query->delete($con);
    }

    /**
     * Deletes all rows from the rol table.
     *
     * @param ConnectionInterface $con the connection to use
     * @return int The number of affected rows (if supported by underlying database driver).
     */
    public static function doDeleteAll(ConnectionInterface $con = null)
    {
        return RolQuery::create()->doDeleteAll($con);
    }

    /**
     * Performs an INSERT on the database, given a Rol or Criteria object.
     *
     * @param mixed               $criteria Criteria or Rol object containing data that is used to create the INSERT statement.
     * @param ConnectionInterface $con the ConnectionInterface connection to use
     * @return mixed           The new primary key.
     * @throws PropelException Any exceptions caught during processing will be
     *         rethrown wrapped into a PropelException.
     */
    public static function doInsert($criteria, ConnectionInterface $con = null)
    {
        if (null === $con) {
            $con = Propel::getServiceContainer()->getWriteConnection(RolTableMap::DATABASE_NAME);
        }

        if ($criteria instanceof Criteria) {
            $criteria = clone $criteria; // rename for clarity
        } else {
            $criteria = $criteria->buildCriteria(); // build Criteria from Rol object
        }

        if ($criteria->containsKey(RolTableMap::ROL_ID) && $criteria->keyContainsValue(RolTableMap::ROL_ID) ) {
            throw new PropelException('Cannot insert a value for auto-increment primary key ('.RolTableMap::ROL_ID.')');
        }


        // Set the correct dbName
        $query = RolQuery::create()->mergeWith($criteria);

        try {
            // use transaction because $criteria could contain info
            // for more than one table (I guess, conceivably)
            $con->beginTransaction();
            $pk = $query->doInsert($con);
            $con->commit();
        } catch (PropelException $e) {
            $con->rollBack();
            throw $e;
        }

        return $pk;
    }

} // RolTableMap
// This is the static code needed to register the TableMap for this table with the main Propel class.
//
RolTableMap::buildTableMap();

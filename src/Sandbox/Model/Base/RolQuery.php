<?php

namespace Sandbox\Model\Base;

use \Exception;
use \PDO;
use Propel\Runtime\Propel;
use Propel\Runtime\ActiveQuery\Criteria;
use Propel\Runtime\ActiveQuery\ModelCriteria;
use Propel\Runtime\ActiveQuery\ModelJoin;
use Propel\Runtime\Collection\Collection;
use Propel\Runtime\Collection\ObjectCollection;
use Propel\Runtime\Connection\ConnectionInterface;
use Propel\Runtime\Exception\PropelException;
use Sandbox\Model\Rol as ChildRol;
use Sandbox\Model\RolQuery as ChildRolQuery;
use Sandbox\Model\Map\RolTableMap;

/**
 * Base class that represents a query for the 'rol' table.
 *
 *
 *
 * @method     ChildRolQuery orderByRolId($order = Criteria::ASC) Order by the rol_id column
 * @method     ChildRolQuery orderByRolName($order = Criteria::ASC) Order by the rol_name column
 * @method     ChildRolQuery orderByRolDescription($order = Criteria::ASC) Order by the rol_description column
 * @method     ChildRolQuery orderByRolCreateDate($order = Criteria::ASC) Order by the rol_create_date column
 * @method     ChildRolQuery orderByRolUpdateDate($order = Criteria::ASC) Order by the rol_update_date column
 * @method     ChildRolQuery orderByRolStatus($order = Criteria::ASC) Order by the rol_status column
 *
 * @method     ChildRolQuery groupByRolId() Group by the rol_id column
 * @method     ChildRolQuery groupByRolName() Group by the rol_name column
 * @method     ChildRolQuery groupByRolDescription() Group by the rol_description column
 * @method     ChildRolQuery groupByRolCreateDate() Group by the rol_create_date column
 * @method     ChildRolQuery groupByRolUpdateDate() Group by the rol_update_date column
 * @method     ChildRolQuery groupByRolStatus() Group by the rol_status column
 *
 * @method     ChildRolQuery leftJoin($relation) Adds a LEFT JOIN clause to the query
 * @method     ChildRolQuery rightJoin($relation) Adds a RIGHT JOIN clause to the query
 * @method     ChildRolQuery innerJoin($relation) Adds a INNER JOIN clause to the query
 *
 * @method     ChildRolQuery leftJoinUserRol($relationAlias = null) Adds a LEFT JOIN clause to the query using the UserRol relation
 * @method     ChildRolQuery rightJoinUserRol($relationAlias = null) Adds a RIGHT JOIN clause to the query using the UserRol relation
 * @method     ChildRolQuery innerJoinUserRol($relationAlias = null) Adds a INNER JOIN clause to the query using the UserRol relation
 *
 * @method     ChildRolQuery leftJoinRolPermission($relationAlias = null) Adds a LEFT JOIN clause to the query using the RolPermission relation
 * @method     ChildRolQuery rightJoinRolPermission($relationAlias = null) Adds a RIGHT JOIN clause to the query using the RolPermission relation
 * @method     ChildRolQuery innerJoinRolPermission($relationAlias = null) Adds a INNER JOIN clause to the query using the RolPermission relation
 *
 * @method     ChildRol findOne(ConnectionInterface $con = null) Return the first ChildRol matching the query
 * @method     ChildRol findOneOrCreate(ConnectionInterface $con = null) Return the first ChildRol matching the query, or a new ChildRol object populated from the query conditions when no match is found
 *
 * @method     ChildRol findOneByRolId(int $rol_id) Return the first ChildRol filtered by the rol_id column
 * @method     ChildRol findOneByRolName(string $rol_name) Return the first ChildRol filtered by the rol_name column
 * @method     ChildRol findOneByRolDescription(string $rol_description) Return the first ChildRol filtered by the rol_description column
 * @method     ChildRol findOneByRolCreateDate(string $rol_create_date) Return the first ChildRol filtered by the rol_create_date column
 * @method     ChildRol findOneByRolUpdateDate(string $rol_update_date) Return the first ChildRol filtered by the rol_update_date column
 * @method     ChildRol findOneByRolStatus(string $rol_status) Return the first ChildRol filtered by the rol_status column
 *
 * @method     array findByRolId(int $rol_id) Return ChildRol objects filtered by the rol_id column
 * @method     array findByRolName(string $rol_name) Return ChildRol objects filtered by the rol_name column
 * @method     array findByRolDescription(string $rol_description) Return ChildRol objects filtered by the rol_description column
 * @method     array findByRolCreateDate(string $rol_create_date) Return ChildRol objects filtered by the rol_create_date column
 * @method     array findByRolUpdateDate(string $rol_update_date) Return ChildRol objects filtered by the rol_update_date column
 * @method     array findByRolStatus(string $rol_status) Return ChildRol objects filtered by the rol_status column
 *
 */
abstract class RolQuery extends ModelCriteria
{

    /**
     * Initializes internal state of \Sandbox\Model\Base\RolQuery object.
     *
     * @param     string $dbName The database name
     * @param     string $modelName The phpName of a model, e.g. 'Book'
     * @param     string $modelAlias The alias for the model in this query, e.g. 'b'
     */
    public function __construct($dbName = 'Sandbox', $modelName = '\\Sandbox\\Model\\Rol', $modelAlias = null)
    {
        parent::__construct($dbName, $modelName, $modelAlias);
    }

    /**
     * Returns a new ChildRolQuery object.
     *
     * @param     string $modelAlias The alias of a model in the query
     * @param     Criteria $criteria Optional Criteria to build the query from
     *
     * @return ChildRolQuery
     */
    public static function create($modelAlias = null, $criteria = null)
    {
        if ($criteria instanceof \Sandbox\Model\RolQuery) {
            return $criteria;
        }
        $query = new \Sandbox\Model\RolQuery();
        if (null !== $modelAlias) {
            $query->setModelAlias($modelAlias);
        }
        if ($criteria instanceof Criteria) {
            $query->mergeWith($criteria);
        }

        return $query;
    }

    /**
     * Find object by primary key.
     * Propel uses the instance pool to skip the database if the object exists.
     * Go fast if the query is untouched.
     *
     * <code>
     * $obj  = $c->findPk(12, $con);
     * </code>
     *
     * @param mixed $key Primary key to use for the query
     * @param ConnectionInterface $con an optional connection object
     *
     * @return ChildRol|array|mixed the result, formatted by the current formatter
     */
    public function findPk($key, $con = null)
    {
        if ($key === null) {
            return null;
        }
        if ((null !== ($obj = RolTableMap::getInstanceFromPool((string) $key))) && !$this->formatter) {
            // the object is already in the instance pool
            return $obj;
        }
        if ($con === null) {
            $con = Propel::getServiceContainer()->getReadConnection(RolTableMap::DATABASE_NAME);
        }
        $this->basePreSelect($con);
        if ($this->formatter || $this->modelAlias || $this->with || $this->select
         || $this->selectColumns || $this->asColumns || $this->selectModifiers
         || $this->map || $this->having || $this->joins) {
            return $this->findPkComplex($key, $con);
        } else {
            return $this->findPkSimple($key, $con);
        }
    }

    /**
     * Find object by primary key using raw SQL to go fast.
     * Bypass doSelect() and the object formatter by using generated code.
     *
     * @param     mixed $key Primary key to use for the query
     * @param     ConnectionInterface $con A connection object
     *
     * @return   ChildRol A model object, or null if the key is not found
     */
    protected function findPkSimple($key, $con)
    {
        $sql = 'SELECT ROL_ID, ROL_NAME, ROL_DESCRIPTION, ROL_CREATE_DATE, ROL_UPDATE_DATE, ROL_STATUS FROM rol WHERE ROL_ID = :p0';
        try {
            $stmt = $con->prepare($sql);
            $stmt->bindValue(':p0', $key, PDO::PARAM_INT);
            $stmt->execute();
        } catch (Exception $e) {
            Propel::log($e->getMessage(), Propel::LOG_ERR);
            throw new PropelException(sprintf('Unable to execute SELECT statement [%s]', $sql), 0, $e);
        }
        $obj = null;
        if ($row = $stmt->fetch(\PDO::FETCH_NUM)) {
            $obj = new ChildRol();
            $obj->hydrate($row);
            RolTableMap::addInstanceToPool($obj, (string) $key);
        }
        $stmt->closeCursor();

        return $obj;
    }

    /**
     * Find object by primary key.
     *
     * @param     mixed $key Primary key to use for the query
     * @param     ConnectionInterface $con A connection object
     *
     * @return ChildRol|array|mixed the result, formatted by the current formatter
     */
    protected function findPkComplex($key, $con)
    {
        // As the query uses a PK condition, no limit(1) is necessary.
        $criteria = $this->isKeepQuery() ? clone $this : $this;
        $dataFetcher = $criteria
            ->filterByPrimaryKey($key)
            ->doSelect($con);

        return $criteria->getFormatter()->init($criteria)->formatOne($dataFetcher);
    }

    /**
     * Find objects by primary key
     * <code>
     * $objs = $c->findPks(array(12, 56, 832), $con);
     * </code>
     * @param     array $keys Primary keys to use for the query
     * @param     ConnectionInterface $con an optional connection object
     *
     * @return ObjectCollection|array|mixed the list of results, formatted by the current formatter
     */
    public function findPks($keys, $con = null)
    {
        if (null === $con) {
            $con = Propel::getServiceContainer()->getReadConnection($this->getDbName());
        }
        $this->basePreSelect($con);
        $criteria = $this->isKeepQuery() ? clone $this : $this;
        $dataFetcher = $criteria
            ->filterByPrimaryKeys($keys)
            ->doSelect($con);

        return $criteria->getFormatter()->init($criteria)->format($dataFetcher);
    }

    /**
     * Filter the query by primary key
     *
     * @param     mixed $key Primary key to use for the query
     *
     * @return ChildRolQuery The current query, for fluid interface
     */
    public function filterByPrimaryKey($key)
    {

        return $this->addUsingAlias(RolTableMap::ROL_ID, $key, Criteria::EQUAL);
    }

    /**
     * Filter the query by a list of primary keys
     *
     * @param     array $keys The list of primary key to use for the query
     *
     * @return ChildRolQuery The current query, for fluid interface
     */
    public function filterByPrimaryKeys($keys)
    {

        return $this->addUsingAlias(RolTableMap::ROL_ID, $keys, Criteria::IN);
    }

    /**
     * Filter the query on the rol_id column
     *
     * Example usage:
     * <code>
     * $query->filterByRolId(1234); // WHERE rol_id = 1234
     * $query->filterByRolId(array(12, 34)); // WHERE rol_id IN (12, 34)
     * $query->filterByRolId(array('min' => 12)); // WHERE rol_id > 12
     * </code>
     *
     * @param     mixed $rolId The value to use as filter.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return ChildRolQuery The current query, for fluid interface
     */
    public function filterByRolId($rolId = null, $comparison = null)
    {
        if (is_array($rolId)) {
            $useMinMax = false;
            if (isset($rolId['min'])) {
                $this->addUsingAlias(RolTableMap::ROL_ID, $rolId['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($rolId['max'])) {
                $this->addUsingAlias(RolTableMap::ROL_ID, $rolId['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(RolTableMap::ROL_ID, $rolId, $comparison);
    }

    /**
     * Filter the query on the rol_name column
     *
     * Example usage:
     * <code>
     * $query->filterByRolName('fooValue');   // WHERE rol_name = 'fooValue'
     * $query->filterByRolName('%fooValue%'); // WHERE rol_name LIKE '%fooValue%'
     * </code>
     *
     * @param     string $rolName The value to use as filter.
     *              Accepts wildcards (* and % trigger a LIKE)
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return ChildRolQuery The current query, for fluid interface
     */
    public function filterByRolName($rolName = null, $comparison = null)
    {
        if (null === $comparison) {
            if (is_array($rolName)) {
                $comparison = Criteria::IN;
            } elseif (preg_match('/[\%\*]/', $rolName)) {
                $rolName = str_replace('*', '%', $rolName);
                $comparison = Criteria::LIKE;
            }
        }

        return $this->addUsingAlias(RolTableMap::ROL_NAME, $rolName, $comparison);
    }

    /**
     * Filter the query on the rol_description column
     *
     * Example usage:
     * <code>
     * $query->filterByRolDescription('fooValue');   // WHERE rol_description = 'fooValue'
     * $query->filterByRolDescription('%fooValue%'); // WHERE rol_description LIKE '%fooValue%'
     * </code>
     *
     * @param     string $rolDescription The value to use as filter.
     *              Accepts wildcards (* and % trigger a LIKE)
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return ChildRolQuery The current query, for fluid interface
     */
    public function filterByRolDescription($rolDescription = null, $comparison = null)
    {
        if (null === $comparison) {
            if (is_array($rolDescription)) {
                $comparison = Criteria::IN;
            } elseif (preg_match('/[\%\*]/', $rolDescription)) {
                $rolDescription = str_replace('*', '%', $rolDescription);
                $comparison = Criteria::LIKE;
            }
        }

        return $this->addUsingAlias(RolTableMap::ROL_DESCRIPTION, $rolDescription, $comparison);
    }

    /**
     * Filter the query on the rol_create_date column
     *
     * Example usage:
     * <code>
     * $query->filterByRolCreateDate('2011-03-14'); // WHERE rol_create_date = '2011-03-14'
     * $query->filterByRolCreateDate('now'); // WHERE rol_create_date = '2011-03-14'
     * $query->filterByRolCreateDate(array('max' => 'yesterday')); // WHERE rol_create_date > '2011-03-13'
     * </code>
     *
     * @param     mixed $rolCreateDate The value to use as filter.
     *              Values can be integers (unix timestamps), DateTime objects, or strings.
     *              Empty strings are treated as NULL.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return ChildRolQuery The current query, for fluid interface
     */
    public function filterByRolCreateDate($rolCreateDate = null, $comparison = null)
    {
        if (is_array($rolCreateDate)) {
            $useMinMax = false;
            if (isset($rolCreateDate['min'])) {
                $this->addUsingAlias(RolTableMap::ROL_CREATE_DATE, $rolCreateDate['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($rolCreateDate['max'])) {
                $this->addUsingAlias(RolTableMap::ROL_CREATE_DATE, $rolCreateDate['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(RolTableMap::ROL_CREATE_DATE, $rolCreateDate, $comparison);
    }

    /**
     * Filter the query on the rol_update_date column
     *
     * Example usage:
     * <code>
     * $query->filterByRolUpdateDate('2011-03-14'); // WHERE rol_update_date = '2011-03-14'
     * $query->filterByRolUpdateDate('now'); // WHERE rol_update_date = '2011-03-14'
     * $query->filterByRolUpdateDate(array('max' => 'yesterday')); // WHERE rol_update_date > '2011-03-13'
     * </code>
     *
     * @param     mixed $rolUpdateDate The value to use as filter.
     *              Values can be integers (unix timestamps), DateTime objects, or strings.
     *              Empty strings are treated as NULL.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return ChildRolQuery The current query, for fluid interface
     */
    public function filterByRolUpdateDate($rolUpdateDate = null, $comparison = null)
    {
        if (is_array($rolUpdateDate)) {
            $useMinMax = false;
            if (isset($rolUpdateDate['min'])) {
                $this->addUsingAlias(RolTableMap::ROL_UPDATE_DATE, $rolUpdateDate['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($rolUpdateDate['max'])) {
                $this->addUsingAlias(RolTableMap::ROL_UPDATE_DATE, $rolUpdateDate['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(RolTableMap::ROL_UPDATE_DATE, $rolUpdateDate, $comparison);
    }

    /**
     * Filter the query on the rol_status column
     *
     * Example usage:
     * <code>
     * $query->filterByRolStatus('fooValue');   // WHERE rol_status = 'fooValue'
     * $query->filterByRolStatus('%fooValue%'); // WHERE rol_status LIKE '%fooValue%'
     * </code>
     *
     * @param     string $rolStatus The value to use as filter.
     *              Accepts wildcards (* and % trigger a LIKE)
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return ChildRolQuery The current query, for fluid interface
     */
    public function filterByRolStatus($rolStatus = null, $comparison = null)
    {
        if (null === $comparison) {
            if (is_array($rolStatus)) {
                $comparison = Criteria::IN;
            } elseif (preg_match('/[\%\*]/', $rolStatus)) {
                $rolStatus = str_replace('*', '%', $rolStatus);
                $comparison = Criteria::LIKE;
            }
        }

        return $this->addUsingAlias(RolTableMap::ROL_STATUS, $rolStatus, $comparison);
    }

    /**
     * Filter the query by a related \Sandbox\Model\UserRol object
     *
     * @param \Sandbox\Model\UserRol|ObjectCollection $userRol  the related object to use as filter
     * @param string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return ChildRolQuery The current query, for fluid interface
     */
    public function filterByUserRol($userRol, $comparison = null)
    {
        if ($userRol instanceof \Sandbox\Model\UserRol) {
            return $this
                ->addUsingAlias(RolTableMap::ROL_ID, $userRol->getRolId(), $comparison);
        } elseif ($userRol instanceof ObjectCollection) {
            return $this
                ->useUserRolQuery()
                ->filterByPrimaryKeys($userRol->getPrimaryKeys())
                ->endUse();
        } else {
            throw new PropelException('filterByUserRol() only accepts arguments of type \Sandbox\Model\UserRol or Collection');
        }
    }

    /**
     * Adds a JOIN clause to the query using the UserRol relation
     *
     * @param     string $relationAlias optional alias for the relation
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return ChildRolQuery The current query, for fluid interface
     */
    public function joinUserRol($relationAlias = null, $joinType = Criteria::INNER_JOIN)
    {
        $tableMap = $this->getTableMap();
        $relationMap = $tableMap->getRelation('UserRol');

        // create a ModelJoin object for this join
        $join = new ModelJoin();
        $join->setJoinType($joinType);
        $join->setRelationMap($relationMap, $this->useAliasInSQL ? $this->getModelAlias() : null, $relationAlias);
        if ($previousJoin = $this->getPreviousJoin()) {
            $join->setPreviousJoin($previousJoin);
        }

        // add the ModelJoin to the current object
        if ($relationAlias) {
            $this->addAlias($relationAlias, $relationMap->getRightTable()->getName());
            $this->addJoinObject($join, $relationAlias);
        } else {
            $this->addJoinObject($join, 'UserRol');
        }

        return $this;
    }

    /**
     * Use the UserRol relation UserRol object
     *
     * @see useQuery()
     *
     * @param     string $relationAlias optional alias for the relation,
     *                                   to be used as main alias in the secondary query
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return   \Sandbox\Model\UserRolQuery A secondary query class using the current class as primary query
     */
    public function useUserRolQuery($relationAlias = null, $joinType = Criteria::INNER_JOIN)
    {
        return $this
            ->joinUserRol($relationAlias, $joinType)
            ->useQuery($relationAlias ? $relationAlias : 'UserRol', '\Sandbox\Model\UserRolQuery');
    }

    /**
     * Filter the query by a related \Sandbox\Model\RolPermission object
     *
     * @param \Sandbox\Model\RolPermission|ObjectCollection $rolPermission  the related object to use as filter
     * @param string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return ChildRolQuery The current query, for fluid interface
     */
    public function filterByRolPermission($rolPermission, $comparison = null)
    {
        if ($rolPermission instanceof \Sandbox\Model\RolPermission) {
            return $this
                ->addUsingAlias(RolTableMap::ROL_ID, $rolPermission->getRolId(), $comparison);
        } elseif ($rolPermission instanceof ObjectCollection) {
            return $this
                ->useRolPermissionQuery()
                ->filterByPrimaryKeys($rolPermission->getPrimaryKeys())
                ->endUse();
        } else {
            throw new PropelException('filterByRolPermission() only accepts arguments of type \Sandbox\Model\RolPermission or Collection');
        }
    }

    /**
     * Adds a JOIN clause to the query using the RolPermission relation
     *
     * @param     string $relationAlias optional alias for the relation
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return ChildRolQuery The current query, for fluid interface
     */
    public function joinRolPermission($relationAlias = null, $joinType = Criteria::INNER_JOIN)
    {
        $tableMap = $this->getTableMap();
        $relationMap = $tableMap->getRelation('RolPermission');

        // create a ModelJoin object for this join
        $join = new ModelJoin();
        $join->setJoinType($joinType);
        $join->setRelationMap($relationMap, $this->useAliasInSQL ? $this->getModelAlias() : null, $relationAlias);
        if ($previousJoin = $this->getPreviousJoin()) {
            $join->setPreviousJoin($previousJoin);
        }

        // add the ModelJoin to the current object
        if ($relationAlias) {
            $this->addAlias($relationAlias, $relationMap->getRightTable()->getName());
            $this->addJoinObject($join, $relationAlias);
        } else {
            $this->addJoinObject($join, 'RolPermission');
        }

        return $this;
    }

    /**
     * Use the RolPermission relation RolPermission object
     *
     * @see useQuery()
     *
     * @param     string $relationAlias optional alias for the relation,
     *                                   to be used as main alias in the secondary query
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return   \Sandbox\Model\RolPermissionQuery A secondary query class using the current class as primary query
     */
    public function useRolPermissionQuery($relationAlias = null, $joinType = Criteria::INNER_JOIN)
    {
        return $this
            ->joinRolPermission($relationAlias, $joinType)
            ->useQuery($relationAlias ? $relationAlias : 'RolPermission', '\Sandbox\Model\RolPermissionQuery');
    }

    /**
     * Exclude object from result
     *
     * @param   ChildRol $rol Object to remove from the list of results
     *
     * @return ChildRolQuery The current query, for fluid interface
     */
    public function prune($rol = null)
    {
        if ($rol) {
            $this->addUsingAlias(RolTableMap::ROL_ID, $rol->getRolId(), Criteria::NOT_EQUAL);
        }

        return $this;
    }

    /**
     * Deletes all rows from the rol table.
     *
     * @param ConnectionInterface $con the connection to use
     * @return int The number of affected rows (if supported by underlying database driver).
     */
    public function doDeleteAll(ConnectionInterface $con = null)
    {
        if (null === $con) {
            $con = Propel::getServiceContainer()->getWriteConnection(RolTableMap::DATABASE_NAME);
        }
        $affectedRows = 0; // initialize var to track total num of affected rows
        try {
            // use transaction because $criteria could contain info
            // for more than one table or we could emulating ON DELETE CASCADE, etc.
            $con->beginTransaction();
            $affectedRows += parent::doDeleteAll($con);
            // Because this db requires some delete cascade/set null emulation, we have to
            // clear the cached instance *after* the emulation has happened (since
            // instances get re-added by the select statement contained therein).
            RolTableMap::clearInstancePool();
            RolTableMap::clearRelatedInstancePool();

            $con->commit();
        } catch (PropelException $e) {
            $con->rollBack();
            throw $e;
        }

        return $affectedRows;
    }

    /**
     * Performs a DELETE on the database, given a ChildRol or Criteria object OR a primary key value.
     *
     * @param mixed               $values Criteria or ChildRol object or primary key or array of primary keys
     *              which is used to create the DELETE statement
     * @param ConnectionInterface $con the connection to use
     * @return int The number of affected rows (if supported by underlying database driver).  This includes CASCADE-related rows
     *                if supported by native driver or if emulated using Propel.
     * @throws PropelException Any exceptions caught during processing will be
     *         rethrown wrapped into a PropelException.
     */
     public function delete(ConnectionInterface $con = null)
     {
        if (null === $con) {
            $con = Propel::getServiceContainer()->getWriteConnection(RolTableMap::DATABASE_NAME);
        }

        $criteria = $this;

        // Set the correct dbName
        $criteria->setDbName(RolTableMap::DATABASE_NAME);

        $affectedRows = 0; // initialize var to track total num of affected rows

        try {
            // use transaction because $criteria could contain info
            // for more than one table or we could emulating ON DELETE CASCADE, etc.
            $con->beginTransaction();


        RolTableMap::removeInstanceFromPool($criteria);

            $affectedRows += ModelCriteria::delete($con);
            RolTableMap::clearRelatedInstancePool();
            $con->commit();

            return $affectedRows;
        } catch (PropelException $e) {
            $con->rollBack();
            throw $e;
        }
    }

} // RolQuery

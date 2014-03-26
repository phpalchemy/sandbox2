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
use Sandbox\Model\Permission as ChildPermission;
use Sandbox\Model\PermissionQuery as ChildPermissionQuery;
use Sandbox\Model\Map\PermissionTableMap;

/**
 * Base class that represents a query for the 'permission' table.
 *
 *
 *
 * @method     ChildPermissionQuery orderByPrmId($order = Criteria::ASC) Order by the prm_id column
 * @method     ChildPermissionQuery orderByPrmName($order = Criteria::ASC) Order by the prm_name column
 * @method     ChildPermissionQuery orderByPrmCreateDate($order = Criteria::ASC) Order by the prm_create_date column
 * @method     ChildPermissionQuery orderByPrmUpdateDate($order = Criteria::ASC) Order by the prm_update_date column
 * @method     ChildPermissionQuery orderByPrmStatus($order = Criteria::ASC) Order by the prm_status column
 *
 * @method     ChildPermissionQuery groupByPrmId() Group by the prm_id column
 * @method     ChildPermissionQuery groupByPrmName() Group by the prm_name column
 * @method     ChildPermissionQuery groupByPrmCreateDate() Group by the prm_create_date column
 * @method     ChildPermissionQuery groupByPrmUpdateDate() Group by the prm_update_date column
 * @method     ChildPermissionQuery groupByPrmStatus() Group by the prm_status column
 *
 * @method     ChildPermissionQuery leftJoin($relation) Adds a LEFT JOIN clause to the query
 * @method     ChildPermissionQuery rightJoin($relation) Adds a RIGHT JOIN clause to the query
 * @method     ChildPermissionQuery innerJoin($relation) Adds a INNER JOIN clause to the query
 *
 * @method     ChildPermissionQuery leftJoinRolPermission($relationAlias = null) Adds a LEFT JOIN clause to the query using the RolPermission relation
 * @method     ChildPermissionQuery rightJoinRolPermission($relationAlias = null) Adds a RIGHT JOIN clause to the query using the RolPermission relation
 * @method     ChildPermissionQuery innerJoinRolPermission($relationAlias = null) Adds a INNER JOIN clause to the query using the RolPermission relation
 *
 * @method     ChildPermission findOne(ConnectionInterface $con = null) Return the first ChildPermission matching the query
 * @method     ChildPermission findOneOrCreate(ConnectionInterface $con = null) Return the first ChildPermission matching the query, or a new ChildPermission object populated from the query conditions when no match is found
 *
 * @method     ChildPermission findOneByPrmId(int $prm_id) Return the first ChildPermission filtered by the prm_id column
 * @method     ChildPermission findOneByPrmName(string $prm_name) Return the first ChildPermission filtered by the prm_name column
 * @method     ChildPermission findOneByPrmCreateDate(string $prm_create_date) Return the first ChildPermission filtered by the prm_create_date column
 * @method     ChildPermission findOneByPrmUpdateDate(string $prm_update_date) Return the first ChildPermission filtered by the prm_update_date column
 * @method     ChildPermission findOneByPrmStatus(string $prm_status) Return the first ChildPermission filtered by the prm_status column
 *
 * @method     array findByPrmId(int $prm_id) Return ChildPermission objects filtered by the prm_id column
 * @method     array findByPrmName(string $prm_name) Return ChildPermission objects filtered by the prm_name column
 * @method     array findByPrmCreateDate(string $prm_create_date) Return ChildPermission objects filtered by the prm_create_date column
 * @method     array findByPrmUpdateDate(string $prm_update_date) Return ChildPermission objects filtered by the prm_update_date column
 * @method     array findByPrmStatus(string $prm_status) Return ChildPermission objects filtered by the prm_status column
 *
 */
abstract class PermissionQuery extends ModelCriteria
{

    /**
     * Initializes internal state of \Sandbox\Model\Base\PermissionQuery object.
     *
     * @param     string $dbName The database name
     * @param     string $modelName The phpName of a model, e.g. 'Book'
     * @param     string $modelAlias The alias for the model in this query, e.g. 'b'
     */
    public function __construct($dbName = 'Sandbox', $modelName = '\\Sandbox\\Model\\Permission', $modelAlias = null)
    {
        parent::__construct($dbName, $modelName, $modelAlias);
    }

    /**
     * Returns a new ChildPermissionQuery object.
     *
     * @param     string $modelAlias The alias of a model in the query
     * @param     Criteria $criteria Optional Criteria to build the query from
     *
     * @return ChildPermissionQuery
     */
    public static function create($modelAlias = null, $criteria = null)
    {
        if ($criteria instanceof \Sandbox\Model\PermissionQuery) {
            return $criteria;
        }
        $query = new \Sandbox\Model\PermissionQuery();
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
     * @return ChildPermission|array|mixed the result, formatted by the current formatter
     */
    public function findPk($key, $con = null)
    {
        if ($key === null) {
            return null;
        }
        if ((null !== ($obj = PermissionTableMap::getInstanceFromPool((string) $key))) && !$this->formatter) {
            // the object is already in the instance pool
            return $obj;
        }
        if ($con === null) {
            $con = Propel::getServiceContainer()->getReadConnection(PermissionTableMap::DATABASE_NAME);
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
     * @return   ChildPermission A model object, or null if the key is not found
     */
    protected function findPkSimple($key, $con)
    {
        $sql = 'SELECT PRM_ID, PRM_NAME, PRM_CREATE_DATE, PRM_UPDATE_DATE, PRM_STATUS FROM permission WHERE PRM_ID = :p0';
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
            $obj = new ChildPermission();
            $obj->hydrate($row);
            PermissionTableMap::addInstanceToPool($obj, (string) $key);
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
     * @return ChildPermission|array|mixed the result, formatted by the current formatter
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
     * @return ChildPermissionQuery The current query, for fluid interface
     */
    public function filterByPrimaryKey($key)
    {

        return $this->addUsingAlias(PermissionTableMap::PRM_ID, $key, Criteria::EQUAL);
    }

    /**
     * Filter the query by a list of primary keys
     *
     * @param     array $keys The list of primary key to use for the query
     *
     * @return ChildPermissionQuery The current query, for fluid interface
     */
    public function filterByPrimaryKeys($keys)
    {

        return $this->addUsingAlias(PermissionTableMap::PRM_ID, $keys, Criteria::IN);
    }

    /**
     * Filter the query on the prm_id column
     *
     * Example usage:
     * <code>
     * $query->filterByPrmId(1234); // WHERE prm_id = 1234
     * $query->filterByPrmId(array(12, 34)); // WHERE prm_id IN (12, 34)
     * $query->filterByPrmId(array('min' => 12)); // WHERE prm_id > 12
     * </code>
     *
     * @param     mixed $prmId The value to use as filter.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return ChildPermissionQuery The current query, for fluid interface
     */
    public function filterByPrmId($prmId = null, $comparison = null)
    {
        if (is_array($prmId)) {
            $useMinMax = false;
            if (isset($prmId['min'])) {
                $this->addUsingAlias(PermissionTableMap::PRM_ID, $prmId['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($prmId['max'])) {
                $this->addUsingAlias(PermissionTableMap::PRM_ID, $prmId['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(PermissionTableMap::PRM_ID, $prmId, $comparison);
    }

    /**
     * Filter the query on the prm_name column
     *
     * Example usage:
     * <code>
     * $query->filterByPrmName('fooValue');   // WHERE prm_name = 'fooValue'
     * $query->filterByPrmName('%fooValue%'); // WHERE prm_name LIKE '%fooValue%'
     * </code>
     *
     * @param     string $prmName The value to use as filter.
     *              Accepts wildcards (* and % trigger a LIKE)
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return ChildPermissionQuery The current query, for fluid interface
     */
    public function filterByPrmName($prmName = null, $comparison = null)
    {
        if (null === $comparison) {
            if (is_array($prmName)) {
                $comparison = Criteria::IN;
            } elseif (preg_match('/[\%\*]/', $prmName)) {
                $prmName = str_replace('*', '%', $prmName);
                $comparison = Criteria::LIKE;
            }
        }

        return $this->addUsingAlias(PermissionTableMap::PRM_NAME, $prmName, $comparison);
    }

    /**
     * Filter the query on the prm_create_date column
     *
     * Example usage:
     * <code>
     * $query->filterByPrmCreateDate('2011-03-14'); // WHERE prm_create_date = '2011-03-14'
     * $query->filterByPrmCreateDate('now'); // WHERE prm_create_date = '2011-03-14'
     * $query->filterByPrmCreateDate(array('max' => 'yesterday')); // WHERE prm_create_date > '2011-03-13'
     * </code>
     *
     * @param     mixed $prmCreateDate The value to use as filter.
     *              Values can be integers (unix timestamps), DateTime objects, or strings.
     *              Empty strings are treated as NULL.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return ChildPermissionQuery The current query, for fluid interface
     */
    public function filterByPrmCreateDate($prmCreateDate = null, $comparison = null)
    {
        if (is_array($prmCreateDate)) {
            $useMinMax = false;
            if (isset($prmCreateDate['min'])) {
                $this->addUsingAlias(PermissionTableMap::PRM_CREATE_DATE, $prmCreateDate['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($prmCreateDate['max'])) {
                $this->addUsingAlias(PermissionTableMap::PRM_CREATE_DATE, $prmCreateDate['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(PermissionTableMap::PRM_CREATE_DATE, $prmCreateDate, $comparison);
    }

    /**
     * Filter the query on the prm_update_date column
     *
     * Example usage:
     * <code>
     * $query->filterByPrmUpdateDate('2011-03-14'); // WHERE prm_update_date = '2011-03-14'
     * $query->filterByPrmUpdateDate('now'); // WHERE prm_update_date = '2011-03-14'
     * $query->filterByPrmUpdateDate(array('max' => 'yesterday')); // WHERE prm_update_date > '2011-03-13'
     * </code>
     *
     * @param     mixed $prmUpdateDate The value to use as filter.
     *              Values can be integers (unix timestamps), DateTime objects, or strings.
     *              Empty strings are treated as NULL.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return ChildPermissionQuery The current query, for fluid interface
     */
    public function filterByPrmUpdateDate($prmUpdateDate = null, $comparison = null)
    {
        if (is_array($prmUpdateDate)) {
            $useMinMax = false;
            if (isset($prmUpdateDate['min'])) {
                $this->addUsingAlias(PermissionTableMap::PRM_UPDATE_DATE, $prmUpdateDate['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($prmUpdateDate['max'])) {
                $this->addUsingAlias(PermissionTableMap::PRM_UPDATE_DATE, $prmUpdateDate['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(PermissionTableMap::PRM_UPDATE_DATE, $prmUpdateDate, $comparison);
    }

    /**
     * Filter the query on the prm_status column
     *
     * Example usage:
     * <code>
     * $query->filterByPrmStatus('fooValue');   // WHERE prm_status = 'fooValue'
     * $query->filterByPrmStatus('%fooValue%'); // WHERE prm_status LIKE '%fooValue%'
     * </code>
     *
     * @param     string $prmStatus The value to use as filter.
     *              Accepts wildcards (* and % trigger a LIKE)
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return ChildPermissionQuery The current query, for fluid interface
     */
    public function filterByPrmStatus($prmStatus = null, $comparison = null)
    {
        if (null === $comparison) {
            if (is_array($prmStatus)) {
                $comparison = Criteria::IN;
            } elseif (preg_match('/[\%\*]/', $prmStatus)) {
                $prmStatus = str_replace('*', '%', $prmStatus);
                $comparison = Criteria::LIKE;
            }
        }

        return $this->addUsingAlias(PermissionTableMap::PRM_STATUS, $prmStatus, $comparison);
    }

    /**
     * Filter the query by a related \Sandbox\Model\RolPermission object
     *
     * @param \Sandbox\Model\RolPermission|ObjectCollection $rolPermission  the related object to use as filter
     * @param string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return ChildPermissionQuery The current query, for fluid interface
     */
    public function filterByRolPermission($rolPermission, $comparison = null)
    {
        if ($rolPermission instanceof \Sandbox\Model\RolPermission) {
            return $this
                ->addUsingAlias(PermissionTableMap::PRM_ID, $rolPermission->getPrmId(), $comparison);
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
     * @return ChildPermissionQuery The current query, for fluid interface
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
     * @param   ChildPermission $permission Object to remove from the list of results
     *
     * @return ChildPermissionQuery The current query, for fluid interface
     */
    public function prune($permission = null)
    {
        if ($permission) {
            $this->addUsingAlias(PermissionTableMap::PRM_ID, $permission->getPrmId(), Criteria::NOT_EQUAL);
        }

        return $this;
    }

    /**
     * Deletes all rows from the permission table.
     *
     * @param ConnectionInterface $con the connection to use
     * @return int The number of affected rows (if supported by underlying database driver).
     */
    public function doDeleteAll(ConnectionInterface $con = null)
    {
        if (null === $con) {
            $con = Propel::getServiceContainer()->getWriteConnection(PermissionTableMap::DATABASE_NAME);
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
            PermissionTableMap::clearInstancePool();
            PermissionTableMap::clearRelatedInstancePool();

            $con->commit();
        } catch (PropelException $e) {
            $con->rollBack();
            throw $e;
        }

        return $affectedRows;
    }

    /**
     * Performs a DELETE on the database, given a ChildPermission or Criteria object OR a primary key value.
     *
     * @param mixed               $values Criteria or ChildPermission object or primary key or array of primary keys
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
            $con = Propel::getServiceContainer()->getWriteConnection(PermissionTableMap::DATABASE_NAME);
        }

        $criteria = $this;

        // Set the correct dbName
        $criteria->setDbName(PermissionTableMap::DATABASE_NAME);

        $affectedRows = 0; // initialize var to track total num of affected rows

        try {
            // use transaction because $criteria could contain info
            // for more than one table or we could emulating ON DELETE CASCADE, etc.
            $con->beginTransaction();


        PermissionTableMap::removeInstanceFromPool($criteria);

            $affectedRows += ModelCriteria::delete($con);
            PermissionTableMap::clearRelatedInstancePool();
            $con->commit();

            return $affectedRows;
        } catch (PropelException $e) {
            $con->rollBack();
            throw $e;
        }
    }

} // PermissionQuery

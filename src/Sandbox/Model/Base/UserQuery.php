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
use Sandbox\Model\User as ChildUser;
use Sandbox\Model\UserQuery as ChildUserQuery;
use Sandbox\Model\Map\UserTableMap;

/**
 * Base class that represents a query for the 'user' table.
 *
 *
 *
 * @method     ChildUserQuery orderByUsrId($order = Criteria::ASC) Order by the usr_id column
 * @method     ChildUserQuery orderByUsrFirstName($order = Criteria::ASC) Order by the usr_first_name column
 * @method     ChildUserQuery orderByUsrLastName($order = Criteria::ASC) Order by the usr_last_name column
 * @method     ChildUserQuery orderByUsrCreateDate($order = Criteria::ASC) Order by the usr_create_date column
 * @method     ChildUserQuery orderByUsrUpdateDate($order = Criteria::ASC) Order by the usr_update_date column
 * @method     ChildUserQuery orderByUsrStatus($order = Criteria::ASC) Order by the usr_status column
 *
 * @method     ChildUserQuery groupByUsrId() Group by the usr_id column
 * @method     ChildUserQuery groupByUsrFirstName() Group by the usr_first_name column
 * @method     ChildUserQuery groupByUsrLastName() Group by the usr_last_name column
 * @method     ChildUserQuery groupByUsrCreateDate() Group by the usr_create_date column
 * @method     ChildUserQuery groupByUsrUpdateDate() Group by the usr_update_date column
 * @method     ChildUserQuery groupByUsrStatus() Group by the usr_status column
 *
 * @method     ChildUserQuery leftJoin($relation) Adds a LEFT JOIN clause to the query
 * @method     ChildUserQuery rightJoin($relation) Adds a RIGHT JOIN clause to the query
 * @method     ChildUserQuery innerJoin($relation) Adds a INNER JOIN clause to the query
 *
 * @method     ChildUserQuery leftJoinUserRol($relationAlias = null) Adds a LEFT JOIN clause to the query using the UserRol relation
 * @method     ChildUserQuery rightJoinUserRol($relationAlias = null) Adds a RIGHT JOIN clause to the query using the UserRol relation
 * @method     ChildUserQuery innerJoinUserRol($relationAlias = null) Adds a INNER JOIN clause to the query using the UserRol relation
 *
 * @method     ChildUser findOne(ConnectionInterface $con = null) Return the first ChildUser matching the query
 * @method     ChildUser findOneOrCreate(ConnectionInterface $con = null) Return the first ChildUser matching the query, or a new ChildUser object populated from the query conditions when no match is found
 *
 * @method     ChildUser findOneByUsrId(int $usr_id) Return the first ChildUser filtered by the usr_id column
 * @method     ChildUser findOneByUsrFirstName(string $usr_first_name) Return the first ChildUser filtered by the usr_first_name column
 * @method     ChildUser findOneByUsrLastName(string $usr_last_name) Return the first ChildUser filtered by the usr_last_name column
 * @method     ChildUser findOneByUsrCreateDate(string $usr_create_date) Return the first ChildUser filtered by the usr_create_date column
 * @method     ChildUser findOneByUsrUpdateDate(string $usr_update_date) Return the first ChildUser filtered by the usr_update_date column
 * @method     ChildUser findOneByUsrStatus(string $usr_status) Return the first ChildUser filtered by the usr_status column
 *
 * @method     array findByUsrId(int $usr_id) Return ChildUser objects filtered by the usr_id column
 * @method     array findByUsrFirstName(string $usr_first_name) Return ChildUser objects filtered by the usr_first_name column
 * @method     array findByUsrLastName(string $usr_last_name) Return ChildUser objects filtered by the usr_last_name column
 * @method     array findByUsrCreateDate(string $usr_create_date) Return ChildUser objects filtered by the usr_create_date column
 * @method     array findByUsrUpdateDate(string $usr_update_date) Return ChildUser objects filtered by the usr_update_date column
 * @method     array findByUsrStatus(string $usr_status) Return ChildUser objects filtered by the usr_status column
 *
 */
abstract class UserQuery extends ModelCriteria
{

    /**
     * Initializes internal state of \Sandbox\Model\Base\UserQuery object.
     *
     * @param     string $dbName The database name
     * @param     string $modelName The phpName of a model, e.g. 'Book'
     * @param     string $modelAlias The alias for the model in this query, e.g. 'b'
     */
    public function __construct($dbName = 'Sandbox', $modelName = '\\Sandbox\\Model\\User', $modelAlias = null)
    {
        parent::__construct($dbName, $modelName, $modelAlias);
    }

    /**
     * Returns a new ChildUserQuery object.
     *
     * @param     string $modelAlias The alias of a model in the query
     * @param     Criteria $criteria Optional Criteria to build the query from
     *
     * @return ChildUserQuery
     */
    public static function create($modelAlias = null, $criteria = null)
    {
        if ($criteria instanceof \Sandbox\Model\UserQuery) {
            return $criteria;
        }
        $query = new \Sandbox\Model\UserQuery();
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
     * @return ChildUser|array|mixed the result, formatted by the current formatter
     */
    public function findPk($key, $con = null)
    {
        if ($key === null) {
            return null;
        }
        if ((null !== ($obj = UserTableMap::getInstanceFromPool((string) $key))) && !$this->formatter) {
            // the object is already in the instance pool
            return $obj;
        }
        if ($con === null) {
            $con = Propel::getServiceContainer()->getReadConnection(UserTableMap::DATABASE_NAME);
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
     * @return   ChildUser A model object, or null if the key is not found
     */
    protected function findPkSimple($key, $con)
    {
        $sql = 'SELECT USR_ID, USR_FIRST_NAME, USR_LAST_NAME, USR_CREATE_DATE, USR_UPDATE_DATE, USR_STATUS FROM user WHERE USR_ID = :p0';
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
            $obj = new ChildUser();
            $obj->hydrate($row);
            UserTableMap::addInstanceToPool($obj, (string) $key);
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
     * @return ChildUser|array|mixed the result, formatted by the current formatter
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
     * @return ChildUserQuery The current query, for fluid interface
     */
    public function filterByPrimaryKey($key)
    {

        return $this->addUsingAlias(UserTableMap::USR_ID, $key, Criteria::EQUAL);
    }

    /**
     * Filter the query by a list of primary keys
     *
     * @param     array $keys The list of primary key to use for the query
     *
     * @return ChildUserQuery The current query, for fluid interface
     */
    public function filterByPrimaryKeys($keys)
    {

        return $this->addUsingAlias(UserTableMap::USR_ID, $keys, Criteria::IN);
    }

    /**
     * Filter the query on the usr_id column
     *
     * Example usage:
     * <code>
     * $query->filterByUsrId(1234); // WHERE usr_id = 1234
     * $query->filterByUsrId(array(12, 34)); // WHERE usr_id IN (12, 34)
     * $query->filterByUsrId(array('min' => 12)); // WHERE usr_id > 12
     * </code>
     *
     * @param     mixed $usrId The value to use as filter.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return ChildUserQuery The current query, for fluid interface
     */
    public function filterByUsrId($usrId = null, $comparison = null)
    {
        if (is_array($usrId)) {
            $useMinMax = false;
            if (isset($usrId['min'])) {
                $this->addUsingAlias(UserTableMap::USR_ID, $usrId['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($usrId['max'])) {
                $this->addUsingAlias(UserTableMap::USR_ID, $usrId['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(UserTableMap::USR_ID, $usrId, $comparison);
    }

    /**
     * Filter the query on the usr_first_name column
     *
     * Example usage:
     * <code>
     * $query->filterByUsrFirstName('fooValue');   // WHERE usr_first_name = 'fooValue'
     * $query->filterByUsrFirstName('%fooValue%'); // WHERE usr_first_name LIKE '%fooValue%'
     * </code>
     *
     * @param     string $usrFirstName The value to use as filter.
     *              Accepts wildcards (* and % trigger a LIKE)
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return ChildUserQuery The current query, for fluid interface
     */
    public function filterByUsrFirstName($usrFirstName = null, $comparison = null)
    {
        if (null === $comparison) {
            if (is_array($usrFirstName)) {
                $comparison = Criteria::IN;
            } elseif (preg_match('/[\%\*]/', $usrFirstName)) {
                $usrFirstName = str_replace('*', '%', $usrFirstName);
                $comparison = Criteria::LIKE;
            }
        }

        return $this->addUsingAlias(UserTableMap::USR_FIRST_NAME, $usrFirstName, $comparison);
    }

    /**
     * Filter the query on the usr_last_name column
     *
     * Example usage:
     * <code>
     * $query->filterByUsrLastName('fooValue');   // WHERE usr_last_name = 'fooValue'
     * $query->filterByUsrLastName('%fooValue%'); // WHERE usr_last_name LIKE '%fooValue%'
     * </code>
     *
     * @param     string $usrLastName The value to use as filter.
     *              Accepts wildcards (* and % trigger a LIKE)
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return ChildUserQuery The current query, for fluid interface
     */
    public function filterByUsrLastName($usrLastName = null, $comparison = null)
    {
        if (null === $comparison) {
            if (is_array($usrLastName)) {
                $comparison = Criteria::IN;
            } elseif (preg_match('/[\%\*]/', $usrLastName)) {
                $usrLastName = str_replace('*', '%', $usrLastName);
                $comparison = Criteria::LIKE;
            }
        }

        return $this->addUsingAlias(UserTableMap::USR_LAST_NAME, $usrLastName, $comparison);
    }

    /**
     * Filter the query on the usr_create_date column
     *
     * Example usage:
     * <code>
     * $query->filterByUsrCreateDate('2011-03-14'); // WHERE usr_create_date = '2011-03-14'
     * $query->filterByUsrCreateDate('now'); // WHERE usr_create_date = '2011-03-14'
     * $query->filterByUsrCreateDate(array('max' => 'yesterday')); // WHERE usr_create_date > '2011-03-13'
     * </code>
     *
     * @param     mixed $usrCreateDate The value to use as filter.
     *              Values can be integers (unix timestamps), DateTime objects, or strings.
     *              Empty strings are treated as NULL.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return ChildUserQuery The current query, for fluid interface
     */
    public function filterByUsrCreateDate($usrCreateDate = null, $comparison = null)
    {
        if (is_array($usrCreateDate)) {
            $useMinMax = false;
            if (isset($usrCreateDate['min'])) {
                $this->addUsingAlias(UserTableMap::USR_CREATE_DATE, $usrCreateDate['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($usrCreateDate['max'])) {
                $this->addUsingAlias(UserTableMap::USR_CREATE_DATE, $usrCreateDate['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(UserTableMap::USR_CREATE_DATE, $usrCreateDate, $comparison);
    }

    /**
     * Filter the query on the usr_update_date column
     *
     * Example usage:
     * <code>
     * $query->filterByUsrUpdateDate('2011-03-14'); // WHERE usr_update_date = '2011-03-14'
     * $query->filterByUsrUpdateDate('now'); // WHERE usr_update_date = '2011-03-14'
     * $query->filterByUsrUpdateDate(array('max' => 'yesterday')); // WHERE usr_update_date > '2011-03-13'
     * </code>
     *
     * @param     mixed $usrUpdateDate The value to use as filter.
     *              Values can be integers (unix timestamps), DateTime objects, or strings.
     *              Empty strings are treated as NULL.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return ChildUserQuery The current query, for fluid interface
     */
    public function filterByUsrUpdateDate($usrUpdateDate = null, $comparison = null)
    {
        if (is_array($usrUpdateDate)) {
            $useMinMax = false;
            if (isset($usrUpdateDate['min'])) {
                $this->addUsingAlias(UserTableMap::USR_UPDATE_DATE, $usrUpdateDate['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($usrUpdateDate['max'])) {
                $this->addUsingAlias(UserTableMap::USR_UPDATE_DATE, $usrUpdateDate['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(UserTableMap::USR_UPDATE_DATE, $usrUpdateDate, $comparison);
    }

    /**
     * Filter the query on the usr_status column
     *
     * Example usage:
     * <code>
     * $query->filterByUsrStatus('fooValue');   // WHERE usr_status = 'fooValue'
     * $query->filterByUsrStatus('%fooValue%'); // WHERE usr_status LIKE '%fooValue%'
     * </code>
     *
     * @param     string $usrStatus The value to use as filter.
     *              Accepts wildcards (* and % trigger a LIKE)
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return ChildUserQuery The current query, for fluid interface
     */
    public function filterByUsrStatus($usrStatus = null, $comparison = null)
    {
        if (null === $comparison) {
            if (is_array($usrStatus)) {
                $comparison = Criteria::IN;
            } elseif (preg_match('/[\%\*]/', $usrStatus)) {
                $usrStatus = str_replace('*', '%', $usrStatus);
                $comparison = Criteria::LIKE;
            }
        }

        return $this->addUsingAlias(UserTableMap::USR_STATUS, $usrStatus, $comparison);
    }

    /**
     * Filter the query by a related \Sandbox\Model\UserRol object
     *
     * @param \Sandbox\Model\UserRol|ObjectCollection $userRol  the related object to use as filter
     * @param string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return ChildUserQuery The current query, for fluid interface
     */
    public function filterByUserRol($userRol, $comparison = null)
    {
        if ($userRol instanceof \Sandbox\Model\UserRol) {
            return $this
                ->addUsingAlias(UserTableMap::USR_ID, $userRol->getUsrId(), $comparison);
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
     * @return ChildUserQuery The current query, for fluid interface
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
     * Exclude object from result
     *
     * @param   ChildUser $user Object to remove from the list of results
     *
     * @return ChildUserQuery The current query, for fluid interface
     */
    public function prune($user = null)
    {
        if ($user) {
            $this->addUsingAlias(UserTableMap::USR_ID, $user->getUsrId(), Criteria::NOT_EQUAL);
        }

        return $this;
    }

    /**
     * Deletes all rows from the user table.
     *
     * @param ConnectionInterface $con the connection to use
     * @return int The number of affected rows (if supported by underlying database driver).
     */
    public function doDeleteAll(ConnectionInterface $con = null)
    {
        if (null === $con) {
            $con = Propel::getServiceContainer()->getWriteConnection(UserTableMap::DATABASE_NAME);
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
            UserTableMap::clearInstancePool();
            UserTableMap::clearRelatedInstancePool();

            $con->commit();
        } catch (PropelException $e) {
            $con->rollBack();
            throw $e;
        }

        return $affectedRows;
    }

    /**
     * Performs a DELETE on the database, given a ChildUser or Criteria object OR a primary key value.
     *
     * @param mixed               $values Criteria or ChildUser object or primary key or array of primary keys
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
            $con = Propel::getServiceContainer()->getWriteConnection(UserTableMap::DATABASE_NAME);
        }

        $criteria = $this;

        // Set the correct dbName
        $criteria->setDbName(UserTableMap::DATABASE_NAME);

        $affectedRows = 0; // initialize var to track total num of affected rows

        try {
            // use transaction because $criteria could contain info
            // for more than one table or we could emulating ON DELETE CASCADE, etc.
            $con->beginTransaction();


        UserTableMap::removeInstanceFromPool($criteria);

            $affectedRows += ModelCriteria::delete($con);
            UserTableMap::clearRelatedInstancePool();
            $con->commit();

            return $affectedRows;
        } catch (PropelException $e) {
            $con->rollBack();
            throw $e;
        }
    }

} // UserQuery

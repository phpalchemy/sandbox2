<?php

namespace Sandbox\Model\Base;

use \DateTime;
use \Exception;
use \PDO;
use Propel\Runtime\Propel;
use Propel\Runtime\ActiveQuery\Criteria;
use Propel\Runtime\ActiveQuery\ModelCriteria;
use Propel\Runtime\ActiveRecord\ActiveRecordInterface;
use Propel\Runtime\Collection\Collection;
use Propel\Runtime\Collection\ObjectCollection;
use Propel\Runtime\Connection\ConnectionInterface;
use Propel\Runtime\Exception\BadMethodCallException;
use Propel\Runtime\Exception\PropelException;
use Propel\Runtime\Map\TableMap;
use Propel\Runtime\Parser\AbstractParser;
use Propel\Runtime\Util\PropelDateTime;
use Sandbox\Model\Permission as ChildPermission;
use Sandbox\Model\PermissionQuery as ChildPermissionQuery;
use Sandbox\Model\RolPermission as ChildRolPermission;
use Sandbox\Model\RolPermissionQuery as ChildRolPermissionQuery;
use Sandbox\Model\Map\PermissionTableMap;

abstract class Permission implements ActiveRecordInterface
{
    /**
     * TableMap class name
     */
    const TABLE_MAP = '\\Sandbox\\Model\\Map\\PermissionTableMap';


    /**
     * attribute to determine if this object has previously been saved.
     * @var boolean
     */
    protected $new = true;

    /**
     * attribute to determine whether this object has been deleted.
     * @var boolean
     */
    protected $deleted = false;

    /**
     * The columns that have been modified in current object.
     * Tracking modified columns allows us to only update modified columns.
     * @var array
     */
    protected $modifiedColumns = array();

    /**
     * The (virtual) columns that are added at runtime
     * The formatters can add supplementary columns based on a resultset
     * @var array
     */
    protected $virtualColumns = array();

    /**
     * The value for the prm_id field.
     * @var        int
     */
    protected $prm_id;

    /**
     * The value for the prm_name field.
     * @var        string
     */
    protected $prm_name;

    /**
     * The value for the prm_create_date field.
     * @var        string
     */
    protected $prm_create_date;

    /**
     * The value for the prm_update_date field.
     * @var        string
     */
    protected $prm_update_date;

    /**
     * The value for the prm_status field.
     * Note: this column has a database default value of: 'ACTIVE'
     * @var        string
     */
    protected $prm_status;

    /**
     * @var        ObjectCollection|ChildRolPermission[] Collection to store aggregation of ChildRolPermission objects.
     */
    protected $collRolPermissions;
    protected $collRolPermissionsPartial;

    /**
     * Flag to prevent endless save loop, if this object is referenced
     * by another object which falls in this transaction.
     *
     * @var boolean
     */
    protected $alreadyInSave = false;

    /**
     * An array of objects scheduled for deletion.
     * @var ObjectCollection
     */
    protected $rolPermissionsScheduledForDeletion = null;

    /**
     * Applies default values to this object.
     * This method should be called from the object's constructor (or
     * equivalent initialization method).
     * @see __construct()
     */
    public function applyDefaultValues()
    {
        $this->prm_status = 'ACTIVE';
    }

    /**
     * Initializes internal state of Sandbox\Model\Base\Permission object.
     * @see applyDefaults()
     */
    public function __construct()
    {
        $this->applyDefaultValues();
    }

    /**
     * Returns whether the object has been modified.
     *
     * @return boolean True if the object has been modified.
     */
    public function isModified()
    {
        return !empty($this->modifiedColumns);
    }

    /**
     * Has specified column been modified?
     *
     * @param  string  $col column fully qualified name (TableMap::TYPE_COLNAME), e.g. Book::AUTHOR_ID
     * @return boolean True if $col has been modified.
     */
    public function isColumnModified($col)
    {
        return in_array($col, $this->modifiedColumns);
    }

    /**
     * Get the columns that have been modified in this object.
     * @return array A unique list of the modified column names for this object.
     */
    public function getModifiedColumns()
    {
        return array_unique($this->modifiedColumns);
    }

    /**
     * Returns whether the object has ever been saved.  This will
     * be false, if the object was retrieved from storage or was created
     * and then saved.
     *
     * @return boolean true, if the object has never been persisted.
     */
    public function isNew()
    {
        return $this->new;
    }

    /**
     * Setter for the isNew attribute.  This method will be called
     * by Propel-generated children and objects.
     *
     * @param boolean $b the state of the object.
     */
    public function setNew($b)
    {
        $this->new = (Boolean) $b;
    }

    /**
     * Whether this object has been deleted.
     * @return boolean The deleted state of this object.
     */
    public function isDeleted()
    {
        return $this->deleted;
    }

    /**
     * Specify whether this object has been deleted.
     * @param  boolean $b The deleted state of this object.
     * @return void
     */
    public function setDeleted($b)
    {
        $this->deleted = (Boolean) $b;
    }

    /**
     * Sets the modified state for the object to be false.
     * @param  string $col If supplied, only the specified column is reset.
     * @return void
     */
    public function resetModified($col = null)
    {
        if (null !== $col) {
            while (false !== ($offset = array_search($col, $this->modifiedColumns))) {
                array_splice($this->modifiedColumns, $offset, 1);
            }
        } else {
            $this->modifiedColumns = array();
        }
    }

    /**
     * Compares this with another <code>Permission</code> instance.  If
     * <code>obj</code> is an instance of <code>Permission</code>, delegates to
     * <code>equals(Permission)</code>.  Otherwise, returns <code>false</code>.
     *
     * @param  mixed   $obj The object to compare to.
     * @return boolean Whether equal to the object specified.
     */
    public function equals($obj)
    {
        $thisclazz = get_class($this);
        if (!is_object($obj) || !($obj instanceof $thisclazz)) {
            return false;
        }

        if ($this === $obj) {
            return true;
        }

        if (null === $this->getPrimaryKey()
            || null === $obj->getPrimaryKey())  {
            return false;
        }

        return $this->getPrimaryKey() === $obj->getPrimaryKey();
    }

    /**
     * If the primary key is not null, return the hashcode of the
     * primary key. Otherwise, return the hash code of the object.
     *
     * @return int Hashcode
     */
    public function hashCode()
    {
        if (null !== $this->getPrimaryKey()) {
            return crc32(serialize($this->getPrimaryKey()));
        }

        return crc32(serialize(clone $this));
    }

    /**
     * Get the associative array of the virtual columns in this object
     *
     * @return array
     */
    public function getVirtualColumns()
    {
        return $this->virtualColumns;
    }

    /**
     * Checks the existence of a virtual column in this object
     *
     * @param  string  $name The virtual column name
     * @return boolean
     */
    public function hasVirtualColumn($name)
    {
        return array_key_exists($name, $this->virtualColumns);
    }

    /**
     * Get the value of a virtual column in this object
     *
     * @param  string $name The virtual column name
     * @return mixed
     *
     * @throws PropelException
     */
    public function getVirtualColumn($name)
    {
        if (!$this->hasVirtualColumn($name)) {
            throw new PropelException(sprintf('Cannot get value of inexistent virtual column %s.', $name));
        }

        return $this->virtualColumns[$name];
    }

    /**
     * Set the value of a virtual column in this object
     *
     * @param string $name  The virtual column name
     * @param mixed  $value The value to give to the virtual column
     *
     * @return Permission The current object, for fluid interface
     */
    public function setVirtualColumn($name, $value)
    {
        $this->virtualColumns[$name] = $value;

        return $this;
    }

    /**
     * Logs a message using Propel::log().
     *
     * @param  string  $msg
     * @param  int     $priority One of the Propel::LOG_* logging levels
     * @return boolean
     */
    protected function log($msg, $priority = Propel::LOG_INFO)
    {
        return Propel::log(get_class($this) . ': ' . $msg, $priority);
    }

    /**
     * Populate the current object from a string, using a given parser format
     * <code>
     * $book = new Book();
     * $book->importFrom('JSON', '{"Id":9012,"Title":"Don Juan","ISBN":"0140422161","Price":12.99,"PublisherId":1234,"AuthorId":5678}');
     * </code>
     *
     * @param mixed $parser A AbstractParser instance,
     *                       or a format name ('XML', 'YAML', 'JSON', 'CSV')
     * @param string $data The source data to import from
     *
     * @return Permission The current object, for fluid interface
     */
    public function importFrom($parser, $data)
    {
        if (!$parser instanceof AbstractParser) {
            $parser = AbstractParser::getParser($parser);
        }

        $this->fromArray($parser->toArray($data), TableMap::TYPE_PHPNAME);

        return $this;
    }

    /**
     * Export the current object properties to a string, using a given parser format
     * <code>
     * $book = BookQuery::create()->findPk(9012);
     * echo $book->exportTo('JSON');
     *  => {"Id":9012,"Title":"Don Juan","ISBN":"0140422161","Price":12.99,"PublisherId":1234,"AuthorId":5678}');
     * </code>
     *
     * @param  mixed   $parser                 A AbstractParser instance, or a format name ('XML', 'YAML', 'JSON', 'CSV')
     * @param  boolean $includeLazyLoadColumns (optional) Whether to include lazy load(ed) columns. Defaults to TRUE.
     * @return string  The exported data
     */
    public function exportTo($parser, $includeLazyLoadColumns = true)
    {
        if (!$parser instanceof AbstractParser) {
            $parser = AbstractParser::getParser($parser);
        }

        return $parser->fromArray($this->toArray(TableMap::TYPE_PHPNAME, $includeLazyLoadColumns, array(), true));
    }

    /**
     * Clean up internal collections prior to serializing
     * Avoids recursive loops that turn into segmentation faults when serializing
     */
    public function __sleep()
    {
        $this->clearAllReferences();

        return array_keys(get_object_vars($this));
    }

    /**
     * Get the [prm_id] column value.
     *
     * @return   int
     */
    public function getPrmId()
    {

        return $this->prm_id;
    }

    /**
     * Get the [prm_name] column value.
     *
     * @return   string
     */
    public function getPrmName()
    {

        return $this->prm_name;
    }

    /**
     * Get the [optionally formatted] temporal [prm_create_date] column value.
     *
     *
     * @param      string $format The date/time format string (either date()-style or strftime()-style).
     *                            If format is NULL, then the raw \DateTime object will be returned.
     *
     * @return mixed Formatted date/time value as string or \DateTime object (if format is NULL), NULL if column is NULL, and 0 if column value is 0000-00-00 00:00:00
     *
     * @throws PropelException - if unable to parse/validate the date/time value.
     */
    public function getPrmCreateDate($format = NULL)
    {
        if ($format === null) {
            return $this->prm_create_date;
        } else {
            return $this->prm_create_date instanceof \DateTime ? $this->prm_create_date->format($format) : null;
        }
    }

    /**
     * Get the [optionally formatted] temporal [prm_update_date] column value.
     *
     *
     * @param      string $format The date/time format string (either date()-style or strftime()-style).
     *                            If format is NULL, then the raw \DateTime object will be returned.
     *
     * @return mixed Formatted date/time value as string or \DateTime object (if format is NULL), NULL if column is NULL, and 0 if column value is 0000-00-00 00:00:00
     *
     * @throws PropelException - if unable to parse/validate the date/time value.
     */
    public function getPrmUpdateDate($format = NULL)
    {
        if ($format === null) {
            return $this->prm_update_date;
        } else {
            return $this->prm_update_date instanceof \DateTime ? $this->prm_update_date->format($format) : null;
        }
    }

    /**
     * Get the [prm_status] column value.
     *
     * @return   string
     */
    public function getPrmStatus()
    {

        return $this->prm_status;
    }

    /**
     * Set the value of [prm_id] column.
     *
     * @param      int $v new value
     * @return   \Sandbox\Model\Permission The current object (for fluent API support)
     */
    public function setPrmId($v)
    {
        if ($v !== null) {
            $v = (int) $v;
        }

        if ($this->prm_id !== $v) {
            $this->prm_id = $v;
            $this->modifiedColumns[] = PermissionTableMap::PRM_ID;
        }


        return $this;
    } // setPrmId()

    /**
     * Set the value of [prm_name] column.
     *
     * @param      string $v new value
     * @return   \Sandbox\Model\Permission The current object (for fluent API support)
     */
    public function setPrmName($v)
    {
        if ($v !== null) {
            $v = (string) $v;
        }

        if ($this->prm_name !== $v) {
            $this->prm_name = $v;
            $this->modifiedColumns[] = PermissionTableMap::PRM_NAME;
        }


        return $this;
    } // setPrmName()

    /**
     * Sets the value of [prm_create_date] column to a normalized version of the date/time value specified.
     *
     * @param      mixed $v string, integer (timestamp), or \DateTime value.
     *               Empty strings are treated as NULL.
     * @return   \Sandbox\Model\Permission The current object (for fluent API support)
     */
    public function setPrmCreateDate($v)
    {
        $dt = PropelDateTime::newInstance($v, null, '\DateTime');
        if ($this->prm_create_date !== null || $dt !== null) {
            if ($dt !== $this->prm_create_date) {
                $this->prm_create_date = $dt;
                $this->modifiedColumns[] = PermissionTableMap::PRM_CREATE_DATE;
            }
        } // if either are not null


        return $this;
    } // setPrmCreateDate()

    /**
     * Sets the value of [prm_update_date] column to a normalized version of the date/time value specified.
     *
     * @param      mixed $v string, integer (timestamp), or \DateTime value.
     *               Empty strings are treated as NULL.
     * @return   \Sandbox\Model\Permission The current object (for fluent API support)
     */
    public function setPrmUpdateDate($v)
    {
        $dt = PropelDateTime::newInstance($v, null, '\DateTime');
        if ($this->prm_update_date !== null || $dt !== null) {
            if ($dt !== $this->prm_update_date) {
                $this->prm_update_date = $dt;
                $this->modifiedColumns[] = PermissionTableMap::PRM_UPDATE_DATE;
            }
        } // if either are not null


        return $this;
    } // setPrmUpdateDate()

    /**
     * Set the value of [prm_status] column.
     *
     * @param      string $v new value
     * @return   \Sandbox\Model\Permission The current object (for fluent API support)
     */
    public function setPrmStatus($v)
    {
        if ($v !== null) {
            $v = (string) $v;
        }

        if ($this->prm_status !== $v) {
            $this->prm_status = $v;
            $this->modifiedColumns[] = PermissionTableMap::PRM_STATUS;
        }


        return $this;
    } // setPrmStatus()

    /**
     * Indicates whether the columns in this object are only set to default values.
     *
     * This method can be used in conjunction with isModified() to indicate whether an object is both
     * modified _and_ has some values set which are non-default.
     *
     * @return boolean Whether the columns in this object are only been set with default values.
     */
    public function hasOnlyDefaultValues()
    {
            if ($this->prm_status !== 'ACTIVE') {
                return false;
            }

        // otherwise, everything was equal, so return TRUE
        return true;
    } // hasOnlyDefaultValues()

    /**
     * Hydrates (populates) the object variables with values from the database resultset.
     *
     * An offset (0-based "start column") is specified so that objects can be hydrated
     * with a subset of the columns in the resultset rows.  This is needed, for example,
     * for results of JOIN queries where the resultset row includes columns from two or
     * more tables.
     *
     * @param array   $row       The row returned by DataFetcher->fetch().
     * @param int     $startcol  0-based offset column which indicates which restultset column to start with.
     * @param boolean $rehydrate Whether this object is being re-hydrated from the database.
     * @param string  $indexType The index type of $row. Mostly DataFetcher->getIndexType().
                                  One of the class type constants TableMap::TYPE_PHPNAME, TableMap::TYPE_STUDLYPHPNAME
     *                            TableMap::TYPE_COLNAME, TableMap::TYPE_FIELDNAME, TableMap::TYPE_NUM.
     *
     * @return int             next starting column
     * @throws PropelException - Any caught Exception will be rewrapped as a PropelException.
     */
    public function hydrate($row, $startcol = 0, $rehydrate = false, $indexType = TableMap::TYPE_NUM)
    {
        try {


            $col = $row[TableMap::TYPE_NUM == $indexType ? 0 + $startcol : PermissionTableMap::translateFieldName('PrmId', TableMap::TYPE_PHPNAME, $indexType)];
            $this->prm_id = (null !== $col) ? (int) $col : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 1 + $startcol : PermissionTableMap::translateFieldName('PrmName', TableMap::TYPE_PHPNAME, $indexType)];
            $this->prm_name = (null !== $col) ? (string) $col : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 2 + $startcol : PermissionTableMap::translateFieldName('PrmCreateDate', TableMap::TYPE_PHPNAME, $indexType)];
            if ($col === '0000-00-00 00:00:00') {
                $col = null;
            }
            $this->prm_create_date = (null !== $col) ? PropelDateTime::newInstance($col, null, '\DateTime') : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 3 + $startcol : PermissionTableMap::translateFieldName('PrmUpdateDate', TableMap::TYPE_PHPNAME, $indexType)];
            if ($col === '0000-00-00 00:00:00') {
                $col = null;
            }
            $this->prm_update_date = (null !== $col) ? PropelDateTime::newInstance($col, null, '\DateTime') : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 4 + $startcol : PermissionTableMap::translateFieldName('PrmStatus', TableMap::TYPE_PHPNAME, $indexType)];
            $this->prm_status = (null !== $col) ? (string) $col : null;
            $this->resetModified();

            $this->setNew(false);

            if ($rehydrate) {
                $this->ensureConsistency();
            }

            return $startcol + 5; // 5 = PermissionTableMap::NUM_HYDRATE_COLUMNS.

        } catch (Exception $e) {
            throw new PropelException("Error populating \Sandbox\Model\Permission object", 0, $e);
        }
    }

    /**
     * Checks and repairs the internal consistency of the object.
     *
     * This method is executed after an already-instantiated object is re-hydrated
     * from the database.  It exists to check any foreign keys to make sure that
     * the objects related to the current object are correct based on foreign key.
     *
     * You can override this method in the stub class, but you should always invoke
     * the base method from the overridden method (i.e. parent::ensureConsistency()),
     * in case your model changes.
     *
     * @throws PropelException
     */
    public function ensureConsistency()
    {
    } // ensureConsistency

    /**
     * Reloads this object from datastore based on primary key and (optionally) resets all associated objects.
     *
     * This will only work if the object has been saved and has a valid primary key set.
     *
     * @param      boolean $deep (optional) Whether to also de-associated any related objects.
     * @param      ConnectionInterface $con (optional) The ConnectionInterface connection to use.
     * @return void
     * @throws PropelException - if this object is deleted, unsaved or doesn't have pk match in db
     */
    public function reload($deep = false, ConnectionInterface $con = null)
    {
        if ($this->isDeleted()) {
            throw new PropelException("Cannot reload a deleted object.");
        }

        if ($this->isNew()) {
            throw new PropelException("Cannot reload an unsaved object.");
        }

        if ($con === null) {
            $con = Propel::getServiceContainer()->getReadConnection(PermissionTableMap::DATABASE_NAME);
        }

        // We don't need to alter the object instance pool; we're just modifying this instance
        // already in the pool.

        $dataFetcher = ChildPermissionQuery::create(null, $this->buildPkeyCriteria())->setFormatter(ModelCriteria::FORMAT_STATEMENT)->find($con);
        $row = $dataFetcher->fetch();
        $dataFetcher->close();
        if (!$row) {
            throw new PropelException('Cannot find matching row in the database to reload object values.');
        }
        $this->hydrate($row, 0, true, $dataFetcher->getIndexType()); // rehydrate

        if ($deep) {  // also de-associate any related objects?

            $this->collRolPermissions = null;

        } // if (deep)
    }

    /**
     * Removes this object from datastore and sets delete attribute.
     *
     * @param      ConnectionInterface $con
     * @return void
     * @throws PropelException
     * @see Permission::setDeleted()
     * @see Permission::isDeleted()
     */
    public function delete(ConnectionInterface $con = null)
    {
        if ($this->isDeleted()) {
            throw new PropelException("This object has already been deleted.");
        }

        if ($con === null) {
            $con = Propel::getServiceContainer()->getWriteConnection(PermissionTableMap::DATABASE_NAME);
        }

        $con->beginTransaction();
        try {
            $deleteQuery = ChildPermissionQuery::create()
                ->filterByPrimaryKey($this->getPrimaryKey());
            $ret = $this->preDelete($con);
            if ($ret) {
                $deleteQuery->delete($con);
                $this->postDelete($con);
                $con->commit();
                $this->setDeleted(true);
            } else {
                $con->commit();
            }
        } catch (Exception $e) {
            $con->rollBack();
            throw $e;
        }
    }

    /**
     * Persists this object to the database.
     *
     * If the object is new, it inserts it; otherwise an update is performed.
     * All modified related objects will also be persisted in the doSave()
     * method.  This method wraps all precipitate database operations in a
     * single transaction.
     *
     * @param      ConnectionInterface $con
     * @return int             The number of rows affected by this insert/update and any referring fk objects' save() operations.
     * @throws PropelException
     * @see doSave()
     */
    public function save(ConnectionInterface $con = null)
    {
        if ($this->isDeleted()) {
            throw new PropelException("You cannot save an object that has been deleted.");
        }

        if ($con === null) {
            $con = Propel::getServiceContainer()->getWriteConnection(PermissionTableMap::DATABASE_NAME);
        }

        $con->beginTransaction();
        $isInsert = $this->isNew();
        try {
            $ret = $this->preSave($con);
            if ($isInsert) {
                $ret = $ret && $this->preInsert($con);
            } else {
                $ret = $ret && $this->preUpdate($con);
            }
            if ($ret) {
                $affectedRows = $this->doSave($con);
                if ($isInsert) {
                    $this->postInsert($con);
                } else {
                    $this->postUpdate($con);
                }
                $this->postSave($con);
                PermissionTableMap::addInstanceToPool($this);
            } else {
                $affectedRows = 0;
            }
            $con->commit();

            return $affectedRows;
        } catch (Exception $e) {
            $con->rollBack();
            throw $e;
        }
    }

    /**
     * Performs the work of inserting or updating the row in the database.
     *
     * If the object is new, it inserts it; otherwise an update is performed.
     * All related objects are also updated in this method.
     *
     * @param      ConnectionInterface $con
     * @return int             The number of rows affected by this insert/update and any referring fk objects' save() operations.
     * @throws PropelException
     * @see save()
     */
    protected function doSave(ConnectionInterface $con)
    {
        $affectedRows = 0; // initialize var to track total num of affected rows
        if (!$this->alreadyInSave) {
            $this->alreadyInSave = true;

            if ($this->isNew() || $this->isModified()) {
                // persist changes
                if ($this->isNew()) {
                    $this->doInsert($con);
                } else {
                    $this->doUpdate($con);
                }
                $affectedRows += 1;
                $this->resetModified();
            }

            if ($this->rolPermissionsScheduledForDeletion !== null) {
                if (!$this->rolPermissionsScheduledForDeletion->isEmpty()) {
                    \Sandbox\Model\RolPermissionQuery::create()
                        ->filterByPrimaryKeys($this->rolPermissionsScheduledForDeletion->getPrimaryKeys(false))
                        ->delete($con);
                    $this->rolPermissionsScheduledForDeletion = null;
                }
            }

                if ($this->collRolPermissions !== null) {
            foreach ($this->collRolPermissions as $referrerFK) {
                    if (!$referrerFK->isDeleted() && ($referrerFK->isNew() || $referrerFK->isModified())) {
                        $affectedRows += $referrerFK->save($con);
                    }
                }
            }

            $this->alreadyInSave = false;

        }

        return $affectedRows;
    } // doSave()

    /**
     * Insert the row in the database.
     *
     * @param      ConnectionInterface $con
     *
     * @throws PropelException
     * @see doSave()
     */
    protected function doInsert(ConnectionInterface $con)
    {
        $modifiedColumns = array();
        $index = 0;

        $this->modifiedColumns[] = PermissionTableMap::PRM_ID;
        if (null !== $this->prm_id) {
            throw new PropelException('Cannot insert a value for auto-increment primary key (' . PermissionTableMap::PRM_ID . ')');
        }

         // check the columns in natural order for more readable SQL queries
        if ($this->isColumnModified(PermissionTableMap::PRM_ID)) {
            $modifiedColumns[':p' . $index++]  = 'PRM_ID';
        }
        if ($this->isColumnModified(PermissionTableMap::PRM_NAME)) {
            $modifiedColumns[':p' . $index++]  = 'PRM_NAME';
        }
        if ($this->isColumnModified(PermissionTableMap::PRM_CREATE_DATE)) {
            $modifiedColumns[':p' . $index++]  = 'PRM_CREATE_DATE';
        }
        if ($this->isColumnModified(PermissionTableMap::PRM_UPDATE_DATE)) {
            $modifiedColumns[':p' . $index++]  = 'PRM_UPDATE_DATE';
        }
        if ($this->isColumnModified(PermissionTableMap::PRM_STATUS)) {
            $modifiedColumns[':p' . $index++]  = 'PRM_STATUS';
        }

        $sql = sprintf(
            'INSERT INTO permission (%s) VALUES (%s)',
            implode(', ', $modifiedColumns),
            implode(', ', array_keys($modifiedColumns))
        );

        try {
            $stmt = $con->prepare($sql);
            foreach ($modifiedColumns as $identifier => $columnName) {
                switch ($columnName) {
                    case 'PRM_ID':
                        $stmt->bindValue($identifier, $this->prm_id, PDO::PARAM_INT);
                        break;
                    case 'PRM_NAME':
                        $stmt->bindValue($identifier, $this->prm_name, PDO::PARAM_STR);
                        break;
                    case 'PRM_CREATE_DATE':
                        $stmt->bindValue($identifier, $this->prm_create_date ? $this->prm_create_date->format("Y-m-d H:i:s") : null, PDO::PARAM_STR);
                        break;
                    case 'PRM_UPDATE_DATE':
                        $stmt->bindValue($identifier, $this->prm_update_date ? $this->prm_update_date->format("Y-m-d H:i:s") : null, PDO::PARAM_STR);
                        break;
                    case 'PRM_STATUS':
                        $stmt->bindValue($identifier, $this->prm_status, PDO::PARAM_STR);
                        break;
                }
            }
            $stmt->execute();
        } catch (Exception $e) {
            Propel::log($e->getMessage(), Propel::LOG_ERR);
            throw new PropelException(sprintf('Unable to execute INSERT statement [%s]', $sql), 0, $e);
        }

        try {
            $pk = $con->lastInsertId();
        } catch (Exception $e) {
            throw new PropelException('Unable to get autoincrement id.', 0, $e);
        }
        $this->setPrmId($pk);

        $this->setNew(false);
    }

    /**
     * Update the row in the database.
     *
     * @param      ConnectionInterface $con
     *
     * @return Integer Number of updated rows
     * @see doSave()
     */
    protected function doUpdate(ConnectionInterface $con)
    {
        $selectCriteria = $this->buildPkeyCriteria();
        $valuesCriteria = $this->buildCriteria();

        return $selectCriteria->doUpdate($valuesCriteria, $con);
    }

    /**
     * Retrieves a field from the object by name passed in as a string.
     *
     * @param      string $name name
     * @param      string $type The type of fieldname the $name is of:
     *                     one of the class type constants TableMap::TYPE_PHPNAME, TableMap::TYPE_STUDLYPHPNAME
     *                     TableMap::TYPE_COLNAME, TableMap::TYPE_FIELDNAME, TableMap::TYPE_NUM.
     *                     Defaults to TableMap::TYPE_PHPNAME.
     * @return mixed Value of field.
     */
    public function getByName($name, $type = TableMap::TYPE_PHPNAME)
    {
        $pos = PermissionTableMap::translateFieldName($name, $type, TableMap::TYPE_NUM);
        $field = $this->getByPosition($pos);

        return $field;
    }

    /**
     * Retrieves a field from the object by Position as specified in the xml schema.
     * Zero-based.
     *
     * @param      int $pos position in xml schema
     * @return mixed Value of field at $pos
     */
    public function getByPosition($pos)
    {
        switch ($pos) {
            case 0:
                return $this->getPrmId();
                break;
            case 1:
                return $this->getPrmName();
                break;
            case 2:
                return $this->getPrmCreateDate();
                break;
            case 3:
                return $this->getPrmUpdateDate();
                break;
            case 4:
                return $this->getPrmStatus();
                break;
            default:
                return null;
                break;
        } // switch()
    }

    /**
     * Exports the object as an array.
     *
     * You can specify the key type of the array by passing one of the class
     * type constants.
     *
     * @param     string  $keyType (optional) One of the class type constants TableMap::TYPE_PHPNAME, TableMap::TYPE_STUDLYPHPNAME,
     *                    TableMap::TYPE_COLNAME, TableMap::TYPE_FIELDNAME, TableMap::TYPE_NUM.
     *                    Defaults to TableMap::TYPE_PHPNAME.
     * @param     boolean $includeLazyLoadColumns (optional) Whether to include lazy loaded columns. Defaults to TRUE.
     * @param     array $alreadyDumpedObjects List of objects to skip to avoid recursion
     * @param     boolean $includeForeignObjects (optional) Whether to include hydrated related objects. Default to FALSE.
     *
     * @return array an associative array containing the field names (as keys) and field values
     */
    public function toArray($keyType = TableMap::TYPE_PHPNAME, $includeLazyLoadColumns = true, $alreadyDumpedObjects = array(), $includeForeignObjects = false)
    {
        if (isset($alreadyDumpedObjects['Permission'][$this->getPrimaryKey()])) {
            return '*RECURSION*';
        }
        $alreadyDumpedObjects['Permission'][$this->getPrimaryKey()] = true;
        $keys = PermissionTableMap::getFieldNames($keyType);
        $result = array(
            $keys[0] => $this->getPrmId(),
            $keys[1] => $this->getPrmName(),
            $keys[2] => $this->getPrmCreateDate(),
            $keys[3] => $this->getPrmUpdateDate(),
            $keys[4] => $this->getPrmStatus(),
        );
        $virtualColumns = $this->virtualColumns;
        foreach ($virtualColumns as $key => $virtualColumn) {
            $result[$key] = $virtualColumn;
        }

        if ($includeForeignObjects) {
            if (null !== $this->collRolPermissions) {
                $result['RolPermissions'] = $this->collRolPermissions->toArray(null, true, $keyType, $includeLazyLoadColumns, $alreadyDumpedObjects);
            }
        }

        return $result;
    }

    /**
     * Sets a field from the object by name passed in as a string.
     *
     * @param      string $name
     * @param      mixed  $value field value
     * @param      string $type The type of fieldname the $name is of:
     *                     one of the class type constants TableMap::TYPE_PHPNAME, TableMap::TYPE_STUDLYPHPNAME
     *                     TableMap::TYPE_COLNAME, TableMap::TYPE_FIELDNAME, TableMap::TYPE_NUM.
     *                     Defaults to TableMap::TYPE_PHPNAME.
     * @return void
     */
    public function setByName($name, $value, $type = TableMap::TYPE_PHPNAME)
    {
        $pos = PermissionTableMap::translateFieldName($name, $type, TableMap::TYPE_NUM);

        return $this->setByPosition($pos, $value);
    }

    /**
     * Sets a field from the object by Position as specified in the xml schema.
     * Zero-based.
     *
     * @param      int $pos position in xml schema
     * @param      mixed $value field value
     * @return void
     */
    public function setByPosition($pos, $value)
    {
        switch ($pos) {
            case 0:
                $this->setPrmId($value);
                break;
            case 1:
                $this->setPrmName($value);
                break;
            case 2:
                $this->setPrmCreateDate($value);
                break;
            case 3:
                $this->setPrmUpdateDate($value);
                break;
            case 4:
                $this->setPrmStatus($value);
                break;
        } // switch()
    }

    /**
     * Populates the object using an array.
     *
     * This is particularly useful when populating an object from one of the
     * request arrays (e.g. $_POST).  This method goes through the column
     * names, checking to see whether a matching key exists in populated
     * array. If so the setByName() method is called for that column.
     *
     * You can specify the key type of the array by additionally passing one
     * of the class type constants TableMap::TYPE_PHPNAME, TableMap::TYPE_STUDLYPHPNAME,
     * TableMap::TYPE_COLNAME, TableMap::TYPE_FIELDNAME, TableMap::TYPE_NUM.
     * The default key type is the column's TableMap::TYPE_PHPNAME.
     *
     * @param      array  $arr     An array to populate the object from.
     * @param      string $keyType The type of keys the array uses.
     * @return void
     */
    public function fromArray($arr, $keyType = TableMap::TYPE_PHPNAME)
    {
        $keys = PermissionTableMap::getFieldNames($keyType);

        if (array_key_exists($keys[0], $arr)) $this->setPrmId($arr[$keys[0]]);
        if (array_key_exists($keys[1], $arr)) $this->setPrmName($arr[$keys[1]]);
        if (array_key_exists($keys[2], $arr)) $this->setPrmCreateDate($arr[$keys[2]]);
        if (array_key_exists($keys[3], $arr)) $this->setPrmUpdateDate($arr[$keys[3]]);
        if (array_key_exists($keys[4], $arr)) $this->setPrmStatus($arr[$keys[4]]);
    }

    /**
     * Build a Criteria object containing the values of all modified columns in this object.
     *
     * @return Criteria The Criteria object containing all modified values.
     */
    public function buildCriteria()
    {
        $criteria = new Criteria(PermissionTableMap::DATABASE_NAME);

        if ($this->isColumnModified(PermissionTableMap::PRM_ID)) $criteria->add(PermissionTableMap::PRM_ID, $this->prm_id);
        if ($this->isColumnModified(PermissionTableMap::PRM_NAME)) $criteria->add(PermissionTableMap::PRM_NAME, $this->prm_name);
        if ($this->isColumnModified(PermissionTableMap::PRM_CREATE_DATE)) $criteria->add(PermissionTableMap::PRM_CREATE_DATE, $this->prm_create_date);
        if ($this->isColumnModified(PermissionTableMap::PRM_UPDATE_DATE)) $criteria->add(PermissionTableMap::PRM_UPDATE_DATE, $this->prm_update_date);
        if ($this->isColumnModified(PermissionTableMap::PRM_STATUS)) $criteria->add(PermissionTableMap::PRM_STATUS, $this->prm_status);

        return $criteria;
    }

    /**
     * Builds a Criteria object containing the primary key for this object.
     *
     * Unlike buildCriteria() this method includes the primary key values regardless
     * of whether or not they have been modified.
     *
     * @return Criteria The Criteria object containing value(s) for primary key(s).
     */
    public function buildPkeyCriteria()
    {
        $criteria = new Criteria(PermissionTableMap::DATABASE_NAME);
        $criteria->add(PermissionTableMap::PRM_ID, $this->prm_id);

        return $criteria;
    }

    /**
     * Returns the primary key for this object (row).
     * @return   int
     */
    public function getPrimaryKey()
    {
        return $this->getPrmId();
    }

    /**
     * Generic method to set the primary key (prm_id column).
     *
     * @param       int $key Primary key.
     * @return void
     */
    public function setPrimaryKey($key)
    {
        $this->setPrmId($key);
    }

    /**
     * Returns true if the primary key for this object is null.
     * @return boolean
     */
    public function isPrimaryKeyNull()
    {

        return null === $this->getPrmId();
    }

    /**
     * Sets contents of passed object to values from current object.
     *
     * If desired, this method can also make copies of all associated (fkey referrers)
     * objects.
     *
     * @param      object $copyObj An object of \Sandbox\Model\Permission (or compatible) type.
     * @param      boolean $deepCopy Whether to also copy all rows that refer (by fkey) to the current row.
     * @param      boolean $makeNew Whether to reset autoincrement PKs and make the object new.
     * @throws PropelException
     */
    public function copyInto($copyObj, $deepCopy = false, $makeNew = true)
    {
        $copyObj->setPrmName($this->getPrmName());
        $copyObj->setPrmCreateDate($this->getPrmCreateDate());
        $copyObj->setPrmUpdateDate($this->getPrmUpdateDate());
        $copyObj->setPrmStatus($this->getPrmStatus());

        if ($deepCopy) {
            // important: temporarily setNew(false) because this affects the behavior of
            // the getter/setter methods for fkey referrer objects.
            $copyObj->setNew(false);

            foreach ($this->getRolPermissions() as $relObj) {
                if ($relObj !== $this) {  // ensure that we don't try to copy a reference to ourselves
                    $copyObj->addRolPermission($relObj->copy($deepCopy));
                }
            }

        } // if ($deepCopy)

        if ($makeNew) {
            $copyObj->setNew(true);
            $copyObj->setPrmId(NULL); // this is a auto-increment column, so set to default value
        }
    }

    /**
     * Makes a copy of this object that will be inserted as a new row in table when saved.
     * It creates a new object filling in the simple attributes, but skipping any primary
     * keys that are defined for the table.
     *
     * If desired, this method can also make copies of all associated (fkey referrers)
     * objects.
     *
     * @param      boolean $deepCopy Whether to also copy all rows that refer (by fkey) to the current row.
     * @return                 \Sandbox\Model\Permission Clone of current object.
     * @throws PropelException
     */
    public function copy($deepCopy = false)
    {
        // we use get_class(), because this might be a subclass
        $clazz = get_class($this);
        $copyObj = new $clazz();
        $this->copyInto($copyObj, $deepCopy);

        return $copyObj;
    }


    /**
     * Initializes a collection based on the name of a relation.
     * Avoids crafting an 'init[$relationName]s' method name
     * that wouldn't work when StandardEnglishPluralizer is used.
     *
     * @param      string $relationName The name of the relation to initialize
     * @return void
     */
    public function initRelation($relationName)
    {
        if ('RolPermission' == $relationName) {
            return $this->initRolPermissions();
        }
    }

    /**
     * Clears out the collRolPermissions collection
     *
     * This does not modify the database; however, it will remove any associated objects, causing
     * them to be refetched by subsequent calls to accessor method.
     *
     * @return void
     * @see        addRolPermissions()
     */
    public function clearRolPermissions()
    {
        $this->collRolPermissions = null; // important to set this to NULL since that means it is uninitialized
    }

    /**
     * Reset is the collRolPermissions collection loaded partially.
     */
    public function resetPartialRolPermissions($v = true)
    {
        $this->collRolPermissionsPartial = $v;
    }

    /**
     * Initializes the collRolPermissions collection.
     *
     * By default this just sets the collRolPermissions collection to an empty array (like clearcollRolPermissions());
     * however, you may wish to override this method in your stub class to provide setting appropriate
     * to your application -- for example, setting the initial array to the values stored in database.
     *
     * @param      boolean $overrideExisting If set to true, the method call initializes
     *                                        the collection even if it is not empty
     *
     * @return void
     */
    public function initRolPermissions($overrideExisting = true)
    {
        if (null !== $this->collRolPermissions && !$overrideExisting) {
            return;
        }
        $this->collRolPermissions = new ObjectCollection();
        $this->collRolPermissions->setModel('\Sandbox\Model\RolPermission');
    }

    /**
     * Gets an array of ChildRolPermission objects which contain a foreign key that references this object.
     *
     * If the $criteria is not null, it is used to always fetch the results from the database.
     * Otherwise the results are fetched from the database the first time, then cached.
     * Next time the same method is called without $criteria, the cached collection is returned.
     * If this ChildPermission is new, it will return
     * an empty collection or the current collection; the criteria is ignored on a new object.
     *
     * @param      Criteria $criteria optional Criteria object to narrow the query
     * @param      ConnectionInterface $con optional connection object
     * @return Collection|ChildRolPermission[] List of ChildRolPermission objects
     * @throws PropelException
     */
    public function getRolPermissions($criteria = null, ConnectionInterface $con = null)
    {
        $partial = $this->collRolPermissionsPartial && !$this->isNew();
        if (null === $this->collRolPermissions || null !== $criteria  || $partial) {
            if ($this->isNew() && null === $this->collRolPermissions) {
                // return empty collection
                $this->initRolPermissions();
            } else {
                $collRolPermissions = ChildRolPermissionQuery::create(null, $criteria)
                    ->filterByPermission($this)
                    ->find($con);

                if (null !== $criteria) {
                    if (false !== $this->collRolPermissionsPartial && count($collRolPermissions)) {
                        $this->initRolPermissions(false);

                        foreach ($collRolPermissions as $obj) {
                            if (false == $this->collRolPermissions->contains($obj)) {
                                $this->collRolPermissions->append($obj);
                            }
                        }

                        $this->collRolPermissionsPartial = true;
                    }

                    $collRolPermissions->getInternalIterator()->rewind();

                    return $collRolPermissions;
                }

                if ($partial && $this->collRolPermissions) {
                    foreach ($this->collRolPermissions as $obj) {
                        if ($obj->isNew()) {
                            $collRolPermissions[] = $obj;
                        }
                    }
                }

                $this->collRolPermissions = $collRolPermissions;
                $this->collRolPermissionsPartial = false;
            }
        }

        return $this->collRolPermissions;
    }

    /**
     * Sets a collection of RolPermission objects related by a one-to-many relationship
     * to the current object.
     * It will also schedule objects for deletion based on a diff between old objects (aka persisted)
     * and new objects from the given Propel collection.
     *
     * @param      Collection $rolPermissions A Propel collection.
     * @param      ConnectionInterface $con Optional connection object
     * @return   ChildPermission The current object (for fluent API support)
     */
    public function setRolPermissions(Collection $rolPermissions, ConnectionInterface $con = null)
    {
        $rolPermissionsToDelete = $this->getRolPermissions(new Criteria(), $con)->diff($rolPermissions);


        //since at least one column in the foreign key is at the same time a PK
        //we can not just set a PK to NULL in the lines below. We have to store
        //a backup of all values, so we are able to manipulate these items based on the onDelete value later.
        $this->rolPermissionsScheduledForDeletion = clone $rolPermissionsToDelete;

        foreach ($rolPermissionsToDelete as $rolPermissionRemoved) {
            $rolPermissionRemoved->setPermission(null);
        }

        $this->collRolPermissions = null;
        foreach ($rolPermissions as $rolPermission) {
            $this->addRolPermission($rolPermission);
        }

        $this->collRolPermissions = $rolPermissions;
        $this->collRolPermissionsPartial = false;

        return $this;
    }

    /**
     * Returns the number of related RolPermission objects.
     *
     * @param      Criteria $criteria
     * @param      boolean $distinct
     * @param      ConnectionInterface $con
     * @return int             Count of related RolPermission objects.
     * @throws PropelException
     */
    public function countRolPermissions(Criteria $criteria = null, $distinct = false, ConnectionInterface $con = null)
    {
        $partial = $this->collRolPermissionsPartial && !$this->isNew();
        if (null === $this->collRolPermissions || null !== $criteria || $partial) {
            if ($this->isNew() && null === $this->collRolPermissions) {
                return 0;
            }

            if ($partial && !$criteria) {
                return count($this->getRolPermissions());
            }

            $query = ChildRolPermissionQuery::create(null, $criteria);
            if ($distinct) {
                $query->distinct();
            }

            return $query
                ->filterByPermission($this)
                ->count($con);
        }

        return count($this->collRolPermissions);
    }

    /**
     * Method called to associate a ChildRolPermission object to this object
     * through the ChildRolPermission foreign key attribute.
     *
     * @param    ChildRolPermission $l ChildRolPermission
     * @return   \Sandbox\Model\Permission The current object (for fluent API support)
     */
    public function addRolPermission(ChildRolPermission $l)
    {
        if ($this->collRolPermissions === null) {
            $this->initRolPermissions();
            $this->collRolPermissionsPartial = true;
        }

        if (!in_array($l, $this->collRolPermissions->getArrayCopy(), true)) { // only add it if the **same** object is not already associated
            $this->doAddRolPermission($l);
        }

        return $this;
    }

    /**
     * @param RolPermission $rolPermission The rolPermission object to add.
     */
    protected function doAddRolPermission($rolPermission)
    {
        $this->collRolPermissions[]= $rolPermission;
        $rolPermission->setPermission($this);
    }

    /**
     * @param  RolPermission $rolPermission The rolPermission object to remove.
     * @return ChildPermission The current object (for fluent API support)
     */
    public function removeRolPermission($rolPermission)
    {
        if ($this->getRolPermissions()->contains($rolPermission)) {
            $this->collRolPermissions->remove($this->collRolPermissions->search($rolPermission));
            if (null === $this->rolPermissionsScheduledForDeletion) {
                $this->rolPermissionsScheduledForDeletion = clone $this->collRolPermissions;
                $this->rolPermissionsScheduledForDeletion->clear();
            }
            $this->rolPermissionsScheduledForDeletion[]= clone $rolPermission;
            $rolPermission->setPermission(null);
        }

        return $this;
    }


    /**
     * If this collection has already been initialized with
     * an identical criteria, it returns the collection.
     * Otherwise if this Permission is new, it will return
     * an empty collection; or if this Permission has previously
     * been saved, it will retrieve related RolPermissions from storage.
     *
     * This method is protected by default in order to keep the public
     * api reasonable.  You can provide public methods for those you
     * actually need in Permission.
     *
     * @param      Criteria $criteria optional Criteria object to narrow the query
     * @param      ConnectionInterface $con optional connection object
     * @param      string $joinBehavior optional join type to use (defaults to Criteria::LEFT_JOIN)
     * @return Collection|ChildRolPermission[] List of ChildRolPermission objects
     */
    public function getRolPermissionsJoinRol($criteria = null, $con = null, $joinBehavior = Criteria::LEFT_JOIN)
    {
        $query = ChildRolPermissionQuery::create(null, $criteria);
        $query->joinWith('Rol', $joinBehavior);

        return $this->getRolPermissions($query, $con);
    }

    /**
     * Clears the current object and sets all attributes to their default values
     */
    public function clear()
    {
        $this->prm_id = null;
        $this->prm_name = null;
        $this->prm_create_date = null;
        $this->prm_update_date = null;
        $this->prm_status = null;
        $this->alreadyInSave = false;
        $this->clearAllReferences();
        $this->applyDefaultValues();
        $this->resetModified();
        $this->setNew(true);
        $this->setDeleted(false);
    }

    /**
     * Resets all references to other model objects or collections of model objects.
     *
     * This method is a user-space workaround for PHP's inability to garbage collect
     * objects with circular references (even in PHP 5.3). This is currently necessary
     * when using Propel in certain daemon or large-volume/high-memory operations.
     *
     * @param      boolean $deep Whether to also clear the references on all referrer objects.
     */
    public function clearAllReferences($deep = false)
    {
        if ($deep) {
            if ($this->collRolPermissions) {
                foreach ($this->collRolPermissions as $o) {
                    $o->clearAllReferences($deep);
                }
            }
        } // if ($deep)

        if ($this->collRolPermissions instanceof Collection) {
            $this->collRolPermissions->clearIterator();
        }
        $this->collRolPermissions = null;
    }

    /**
     * Return the string representation of this object
     *
     * @return string
     */
    public function __toString()
    {
        return (string) $this->exportTo(PermissionTableMap::DEFAULT_STRING_FORMAT);
    }

    /**
     * Code to be run before persisting the object
     * @param  ConnectionInterface $con
     * @return boolean
     */
    public function preSave(ConnectionInterface $con = null)
    {
        return true;
    }

    /**
     * Code to be run after persisting the object
     * @param ConnectionInterface $con
     */
    public function postSave(ConnectionInterface $con = null)
    {

    }

    /**
     * Code to be run before inserting to database
     * @param  ConnectionInterface $con
     * @return boolean
     */
    public function preInsert(ConnectionInterface $con = null)
    {
        return true;
    }

    /**
     * Code to be run after inserting to database
     * @param ConnectionInterface $con
     */
    public function postInsert(ConnectionInterface $con = null)
    {

    }

    /**
     * Code to be run before updating the object in database
     * @param  ConnectionInterface $con
     * @return boolean
     */
    public function preUpdate(ConnectionInterface $con = null)
    {
        return true;
    }

    /**
     * Code to be run after updating the object in database
     * @param ConnectionInterface $con
     */
    public function postUpdate(ConnectionInterface $con = null)
    {

    }

    /**
     * Code to be run before deleting the object in database
     * @param  ConnectionInterface $con
     * @return boolean
     */
    public function preDelete(ConnectionInterface $con = null)
    {
        return true;
    }

    /**
     * Code to be run after deleting the object in database
     * @param ConnectionInterface $con
     */
    public function postDelete(ConnectionInterface $con = null)
    {

    }


    /**
     * Derived method to catches calls to undefined methods.
     *
     * Provides magic import/export method support (fromXML()/toXML(), fromYAML()/toYAML(), etc.).
     * Allows to define default __call() behavior if you overwrite __call()
     *
     * @param string $name
     * @param mixed  $params
     *
     * @return array|string
     */
    public function __call($name, $params)
    {
        if (0 === strpos($name, 'get')) {
            $virtualColumn = substr($name, 3);
            if ($this->hasVirtualColumn($virtualColumn)) {
                return $this->getVirtualColumn($virtualColumn);
            }

            $virtualColumn = lcfirst($virtualColumn);
            if ($this->hasVirtualColumn($virtualColumn)) {
                return $this->getVirtualColumn($virtualColumn);
            }
        }

        if (0 === strpos($name, 'from')) {
            $format = substr($name, 4);

            return $this->importFrom($format, reset($params));
        }

        if (0 === strpos($name, 'to')) {
            $format = substr($name, 2);
            $includeLazyLoadColumns = isset($params[0]) ? $params[0] : true;

            return $this->exportTo($format, $includeLazyLoadColumns);
        }

        throw new BadMethodCallException(sprintf('Call to undefined method: %s.', $name));
    }

}

<?php

namespace Base;

use \AlbiTmpQuery as ChildAlbiTmpQuery;
use \DateTime;
use \Exception;
use \PDO;
use Map\AlbiTmpTableMap;
use Propel\Runtime\Propel;
use Propel\Runtime\ActiveQuery\Criteria;
use Propel\Runtime\ActiveQuery\ModelCriteria;
use Propel\Runtime\ActiveRecord\ActiveRecordInterface;
use Propel\Runtime\Collection\Collection;
use Propel\Runtime\Connection\ConnectionInterface;
use Propel\Runtime\Exception\BadMethodCallException;
use Propel\Runtime\Exception\LogicException;
use Propel\Runtime\Exception\PropelException;
use Propel\Runtime\Map\TableMap;
use Propel\Runtime\Parser\AbstractParser;
use Propel\Runtime\Util\PropelDateTime;

/**
 * Base class that represents a row from the 'albi_tmp' table.
 *
 *
 *
* @package    propel.generator..Base
*/
abstract class AlbiTmp implements ActiveRecordInterface
{
    /**
     * TableMap class name
     */
    const TABLE_MAP = '\\Map\\AlbiTmpTableMap';


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
     * The value for the id_albo field.
     *
     * @var        int
     */
    protected $id_albo;

    /**
     * The value for the id_tipo field.
     *
     * @var        int
     */
    protected $id_tipo;

    /**
     * The value for the dt_pubblicaz_dal field.
     *
     * @var        \DateTime
     */
    protected $dt_pubblicaz_dal;

    /**
     * The value for the dt_pubblicaz_al field.
     *
     * @var        \DateTime
     */
    protected $dt_pubblicaz_al;

    /**
     * The value for the dt_atto field.
     *
     * @var        \DateTime
     */
    protected $dt_atto;

    /**
     * The value for the nr_atto field.
     *
     * @var        int
     */
    protected $nr_atto;

    /**
     * The value for the oggetto field.
     *
     * @var        string
     */
    protected $oggetto;

    /**
     * The value for the autorita_emanante field.
     *
     * @var        string
     */
    protected $autorita_emanante;

    /**
     * The value for the id_area field.
     *
     * @var        int
     */
    protected $id_area;

    /**
     * The value for the file field.
     *
     * @var        string
     */
    protected $file;

    /**
     * Flag to prevent endless save loop, if this object is referenced
     * by another object which falls in this transaction.
     *
     * @var boolean
     */
    protected $alreadyInSave = false;

    /**
     * Initializes internal state of Base\AlbiTmp object.
     */
    public function __construct()
    {
    }

    /**
     * Returns whether the object has been modified.
     *
     * @return boolean True if the object has been modified.
     */
    public function isModified()
    {
        return !!$this->modifiedColumns;
    }

    /**
     * Has specified column been modified?
     *
     * @param  string  $col column fully qualified name (TableMap::TYPE_COLNAME), e.g. Book::AUTHOR_ID
     * @return boolean True if $col has been modified.
     */
    public function isColumnModified($col)
    {
        return $this->modifiedColumns && isset($this->modifiedColumns[$col]);
    }

    /**
     * Get the columns that have been modified in this object.
     * @return array A unique list of the modified column names for this object.
     */
    public function getModifiedColumns()
    {
        return $this->modifiedColumns ? array_keys($this->modifiedColumns) : [];
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
        $this->new = (boolean) $b;
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
        $this->deleted = (boolean) $b;
    }

    /**
     * Sets the modified state for the object to be false.
     * @param  string $col If supplied, only the specified column is reset.
     * @return void
     */
    public function resetModified($col = null)
    {
        if (null !== $col) {
            if (isset($this->modifiedColumns[$col])) {
                unset($this->modifiedColumns[$col]);
            }
        } else {
            $this->modifiedColumns = array();
        }
    }

    /**
     * Compares this with another <code>AlbiTmp</code> instance.  If
     * <code>obj</code> is an instance of <code>AlbiTmp</code>, delegates to
     * <code>equals(AlbiTmp)</code>.  Otherwise, returns <code>false</code>.
     *
     * @param  mixed   $obj The object to compare to.
     * @return boolean Whether equal to the object specified.
     */
    public function equals($obj)
    {
        if (!$obj instanceof static) {
            return false;
        }

        if ($this === $obj) {
            return true;
        }

        if (null === $this->getPrimaryKey() || null === $obj->getPrimaryKey()) {
            return false;
        }

        return $this->getPrimaryKey() === $obj->getPrimaryKey();
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
     * @return $this|AlbiTmp The current object, for fluid interface
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

        $cls = new \ReflectionClass($this);
        $propertyNames = [];
        $serializableProperties = array_diff($cls->getProperties(), $cls->getProperties(\ReflectionProperty::IS_STATIC));

        foreach($serializableProperties as $property) {
            $propertyNames[] = $property->getName();
        }

        return $propertyNames;
    }

    /**
     * Get the [id_albo] column value.
     *
     * @return int
     */
    public function getIdAlbo()
    {
        return $this->id_albo;
    }

    /**
     * Get the [id_tipo] column value.
     *
     * @return int
     */
    public function getIdTipo()
    {
        return $this->id_tipo;
    }

    /**
     * Get the [optionally formatted] temporal [dt_pubblicaz_dal] column value.
     *
     *
     * @param      string $format The date/time format string (either date()-style or strftime()-style).
     *                            If format is NULL, then the raw DateTime object will be returned.
     *
     * @return string|DateTime Formatted date/time value as string or DateTime object (if format is NULL), NULL if column is NULL, and 0 if column value is 0000-00-00
     *
     * @throws PropelException - if unable to parse/validate the date/time value.
     */
    public function getDtPubblicazDal($format = NULL)
    {
        if ($format === null) {
            return $this->dt_pubblicaz_dal;
        } else {
            return $this->dt_pubblicaz_dal instanceof \DateTime ? $this->dt_pubblicaz_dal->format($format) : null;
        }
    }

    /**
     * Get the [optionally formatted] temporal [dt_pubblicaz_al] column value.
     *
     *
     * @param      string $format The date/time format string (either date()-style or strftime()-style).
     *                            If format is NULL, then the raw DateTime object will be returned.
     *
     * @return string|DateTime Formatted date/time value as string or DateTime object (if format is NULL), NULL if column is NULL, and 0 if column value is 0000-00-00
     *
     * @throws PropelException - if unable to parse/validate the date/time value.
     */
    public function getDtPubblicazAl($format = NULL)
    {
        if ($format === null) {
            return $this->dt_pubblicaz_al;
        } else {
            return $this->dt_pubblicaz_al instanceof \DateTime ? $this->dt_pubblicaz_al->format($format) : null;
        }
    }

    /**
     * Get the [optionally formatted] temporal [dt_atto] column value.
     *
     *
     * @param      string $format The date/time format string (either date()-style or strftime()-style).
     *                            If format is NULL, then the raw DateTime object will be returned.
     *
     * @return string|DateTime Formatted date/time value as string or DateTime object (if format is NULL), NULL if column is NULL, and 0 if column value is 0000-00-00
     *
     * @throws PropelException - if unable to parse/validate the date/time value.
     */
    public function getDtAtto($format = NULL)
    {
        if ($format === null) {
            return $this->dt_atto;
        } else {
            return $this->dt_atto instanceof \DateTime ? $this->dt_atto->format($format) : null;
        }
    }

    /**
     * Get the [nr_atto] column value.
     *
     * @return int
     */
    public function getNrAtto()
    {
        return $this->nr_atto;
    }

    /**
     * Get the [oggetto] column value.
     *
     * @return string
     */
    public function getOggetto()
    {
        return $this->oggetto;
    }

    /**
     * Get the [autorita_emanante] column value.
     *
     * @return string
     */
    public function getAutoritaEmanante()
    {
        return $this->autorita_emanante;
    }

    /**
     * Get the [id_area] column value.
     *
     * @return int
     */
    public function getIdArea()
    {
        return $this->id_area;
    }

    /**
     * Get the [file] column value.
     *
     * @return string
     */
    public function getFile()
    {
        return $this->file;
    }

    /**
     * Set the value of [id_albo] column.
     *
     * @param int $v new value
     * @return $this|\AlbiTmp The current object (for fluent API support)
     */
    public function setIdAlbo($v)
    {
        if ($v !== null) {
            $v = (int) $v;
        }

        if ($this->id_albo !== $v) {
            $this->id_albo = $v;
            $this->modifiedColumns[AlbiTmpTableMap::COL_ID_ALBO] = true;
        }

        return $this;
    } // setIdAlbo()

    /**
     * Set the value of [id_tipo] column.
     *
     * @param int $v new value
     * @return $this|\AlbiTmp The current object (for fluent API support)
     */
    public function setIdTipo($v)
    {
        if ($v !== null) {
            $v = (int) $v;
        }

        if ($this->id_tipo !== $v) {
            $this->id_tipo = $v;
            $this->modifiedColumns[AlbiTmpTableMap::COL_ID_TIPO] = true;
        }

        return $this;
    } // setIdTipo()

    /**
     * Sets the value of [dt_pubblicaz_dal] column to a normalized version of the date/time value specified.
     *
     * @param  mixed $v string, integer (timestamp), or \DateTime value.
     *               Empty strings are treated as NULL.
     * @return $this|\AlbiTmp The current object (for fluent API support)
     */
    public function setDtPubblicazDal($v)
    {
        $dt = PropelDateTime::newInstance($v, null, 'DateTime');
        if ($this->dt_pubblicaz_dal !== null || $dt !== null) {
            if ($this->dt_pubblicaz_dal === null || $dt === null || $dt->format("Y-m-d") !== $this->dt_pubblicaz_dal->format("Y-m-d")) {
                $this->dt_pubblicaz_dal = $dt === null ? null : clone $dt;
                $this->modifiedColumns[AlbiTmpTableMap::COL_DT_PUBBLICAZ_DAL] = true;
            }
        } // if either are not null

        return $this;
    } // setDtPubblicazDal()

    /**
     * Sets the value of [dt_pubblicaz_al] column to a normalized version of the date/time value specified.
     *
     * @param  mixed $v string, integer (timestamp), or \DateTime value.
     *               Empty strings are treated as NULL.
     * @return $this|\AlbiTmp The current object (for fluent API support)
     */
    public function setDtPubblicazAl($v)
    {
        $dt = PropelDateTime::newInstance($v, null, 'DateTime');
        if ($this->dt_pubblicaz_al !== null || $dt !== null) {
            if ($this->dt_pubblicaz_al === null || $dt === null || $dt->format("Y-m-d") !== $this->dt_pubblicaz_al->format("Y-m-d")) {
                $this->dt_pubblicaz_al = $dt === null ? null : clone $dt;
                $this->modifiedColumns[AlbiTmpTableMap::COL_DT_PUBBLICAZ_AL] = true;
            }
        } // if either are not null

        return $this;
    } // setDtPubblicazAl()

    /**
     * Sets the value of [dt_atto] column to a normalized version of the date/time value specified.
     *
     * @param  mixed $v string, integer (timestamp), or \DateTime value.
     *               Empty strings are treated as NULL.
     * @return $this|\AlbiTmp The current object (for fluent API support)
     */
    public function setDtAtto($v)
    {
        $dt = PropelDateTime::newInstance($v, null, 'DateTime');
        if ($this->dt_atto !== null || $dt !== null) {
            if ($this->dt_atto === null || $dt === null || $dt->format("Y-m-d") !== $this->dt_atto->format("Y-m-d")) {
                $this->dt_atto = $dt === null ? null : clone $dt;
                $this->modifiedColumns[AlbiTmpTableMap::COL_DT_ATTO] = true;
            }
        } // if either are not null

        return $this;
    } // setDtAtto()

    /**
     * Set the value of [nr_atto] column.
     *
     * @param int $v new value
     * @return $this|\AlbiTmp The current object (for fluent API support)
     */
    public function setNrAtto($v)
    {
        if ($v !== null) {
            $v = (int) $v;
        }

        if ($this->nr_atto !== $v) {
            $this->nr_atto = $v;
            $this->modifiedColumns[AlbiTmpTableMap::COL_NR_ATTO] = true;
        }

        return $this;
    } // setNrAtto()

    /**
     * Set the value of [oggetto] column.
     *
     * @param string $v new value
     * @return $this|\AlbiTmp The current object (for fluent API support)
     */
    public function setOggetto($v)
    {
        if ($v !== null) {
            $v = (string) $v;
        }

        if ($this->oggetto !== $v) {
            $this->oggetto = $v;
            $this->modifiedColumns[AlbiTmpTableMap::COL_OGGETTO] = true;
        }

        return $this;
    } // setOggetto()

    /**
     * Set the value of [autorita_emanante] column.
     *
     * @param string $v new value
     * @return $this|\AlbiTmp The current object (for fluent API support)
     */
    public function setAutoritaEmanante($v)
    {
        if ($v !== null) {
            $v = (string) $v;
        }

        if ($this->autorita_emanante !== $v) {
            $this->autorita_emanante = $v;
            $this->modifiedColumns[AlbiTmpTableMap::COL_AUTORITA_EMANANTE] = true;
        }

        return $this;
    } // setAutoritaEmanante()

    /**
     * Set the value of [id_area] column.
     *
     * @param int $v new value
     * @return $this|\AlbiTmp The current object (for fluent API support)
     */
    public function setIdArea($v)
    {
        if ($v !== null) {
            $v = (int) $v;
        }

        if ($this->id_area !== $v) {
            $this->id_area = $v;
            $this->modifiedColumns[AlbiTmpTableMap::COL_ID_AREA] = true;
        }

        return $this;
    } // setIdArea()

    /**
     * Set the value of [file] column.
     *
     * @param string $v new value
     * @return $this|\AlbiTmp The current object (for fluent API support)
     */
    public function setFile($v)
    {
        if ($v !== null) {
            $v = (string) $v;
        }

        if ($this->file !== $v) {
            $this->file = $v;
            $this->modifiedColumns[AlbiTmpTableMap::COL_FILE] = true;
        }

        return $this;
    } // setFile()

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
                                  One of the class type constants TableMap::TYPE_PHPNAME, TableMap::TYPE_CAMELNAME
     *                            TableMap::TYPE_COLNAME, TableMap::TYPE_FIELDNAME, TableMap::TYPE_NUM.
     *
     * @return int             next starting column
     * @throws PropelException - Any caught Exception will be rewrapped as a PropelException.
     */
    public function hydrate($row, $startcol = 0, $rehydrate = false, $indexType = TableMap::TYPE_NUM)
    {
        try {

            $col = $row[TableMap::TYPE_NUM == $indexType ? 0 + $startcol : AlbiTmpTableMap::translateFieldName('IdAlbo', TableMap::TYPE_PHPNAME, $indexType)];
            $this->id_albo = (null !== $col) ? (int) $col : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 1 + $startcol : AlbiTmpTableMap::translateFieldName('IdTipo', TableMap::TYPE_PHPNAME, $indexType)];
            $this->id_tipo = (null !== $col) ? (int) $col : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 2 + $startcol : AlbiTmpTableMap::translateFieldName('DtPubblicazDal', TableMap::TYPE_PHPNAME, $indexType)];
            if ($col === '0000-00-00') {
                $col = null;
            }
            $this->dt_pubblicaz_dal = (null !== $col) ? PropelDateTime::newInstance($col, null, 'DateTime') : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 3 + $startcol : AlbiTmpTableMap::translateFieldName('DtPubblicazAl', TableMap::TYPE_PHPNAME, $indexType)];
            if ($col === '0000-00-00') {
                $col = null;
            }
            $this->dt_pubblicaz_al = (null !== $col) ? PropelDateTime::newInstance($col, null, 'DateTime') : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 4 + $startcol : AlbiTmpTableMap::translateFieldName('DtAtto', TableMap::TYPE_PHPNAME, $indexType)];
            if ($col === '0000-00-00') {
                $col = null;
            }
            $this->dt_atto = (null !== $col) ? PropelDateTime::newInstance($col, null, 'DateTime') : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 5 + $startcol : AlbiTmpTableMap::translateFieldName('NrAtto', TableMap::TYPE_PHPNAME, $indexType)];
            $this->nr_atto = (null !== $col) ? (int) $col : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 6 + $startcol : AlbiTmpTableMap::translateFieldName('Oggetto', TableMap::TYPE_PHPNAME, $indexType)];
            $this->oggetto = (null !== $col) ? (string) $col : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 7 + $startcol : AlbiTmpTableMap::translateFieldName('AutoritaEmanante', TableMap::TYPE_PHPNAME, $indexType)];
            $this->autorita_emanante = (null !== $col) ? (string) $col : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 8 + $startcol : AlbiTmpTableMap::translateFieldName('IdArea', TableMap::TYPE_PHPNAME, $indexType)];
            $this->id_area = (null !== $col) ? (int) $col : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 9 + $startcol : AlbiTmpTableMap::translateFieldName('File', TableMap::TYPE_PHPNAME, $indexType)];
            $this->file = (null !== $col) ? (string) $col : null;
            $this->resetModified();

            $this->setNew(false);

            if ($rehydrate) {
                $this->ensureConsistency();
            }

            return $startcol + 10; // 10 = AlbiTmpTableMap::NUM_HYDRATE_COLUMNS.

        } catch (Exception $e) {
            throw new PropelException(sprintf('Error populating %s object', '\\AlbiTmp'), 0, $e);
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
            $con = Propel::getServiceContainer()->getReadConnection(AlbiTmpTableMap::DATABASE_NAME);
        }

        // We don't need to alter the object instance pool; we're just modifying this instance
        // already in the pool.

        $dataFetcher = ChildAlbiTmpQuery::create(null, $this->buildPkeyCriteria())->setFormatter(ModelCriteria::FORMAT_STATEMENT)->find($con);
        $row = $dataFetcher->fetch();
        $dataFetcher->close();
        if (!$row) {
            throw new PropelException('Cannot find matching row in the database to reload object values.');
        }
        $this->hydrate($row, 0, true, $dataFetcher->getIndexType()); // rehydrate

        if ($deep) {  // also de-associate any related objects?

        } // if (deep)
    }

    /**
     * Removes this object from datastore and sets delete attribute.
     *
     * @param      ConnectionInterface $con
     * @return void
     * @throws PropelException
     * @see AlbiTmp::setDeleted()
     * @see AlbiTmp::isDeleted()
     */
    public function delete(ConnectionInterface $con = null)
    {
        if ($this->isDeleted()) {
            throw new PropelException("This object has already been deleted.");
        }

        if ($con === null) {
            $con = Propel::getServiceContainer()->getWriteConnection(AlbiTmpTableMap::DATABASE_NAME);
        }

        $con->transaction(function () use ($con) {
            $deleteQuery = ChildAlbiTmpQuery::create()
                ->filterByPrimaryKey($this->getPrimaryKey());
            $ret = $this->preDelete($con);
            if ($ret) {
                $deleteQuery->delete($con);
                $this->postDelete($con);
                $this->setDeleted(true);
            }
        });
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
            $con = Propel::getServiceContainer()->getWriteConnection(AlbiTmpTableMap::DATABASE_NAME);
        }

        return $con->transaction(function () use ($con) {
            $isInsert = $this->isNew();
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
                AlbiTmpTableMap::addInstanceToPool($this);
            } else {
                $affectedRows = 0;
            }

            return $affectedRows;
        });
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
                    $affectedRows += 1;
                } else {
                    $affectedRows += $this->doUpdate($con);
                }
                $this->resetModified();
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

        $this->modifiedColumns[AlbiTmpTableMap::COL_ID_ALBO] = true;
        if (null !== $this->id_albo) {
            throw new PropelException('Cannot insert a value for auto-increment primary key (' . AlbiTmpTableMap::COL_ID_ALBO . ')');
        }

         // check the columns in natural order for more readable SQL queries
        if ($this->isColumnModified(AlbiTmpTableMap::COL_ID_ALBO)) {
            $modifiedColumns[':p' . $index++]  = 'id_albo';
        }
        if ($this->isColumnModified(AlbiTmpTableMap::COL_ID_TIPO)) {
            $modifiedColumns[':p' . $index++]  = 'id_tipo';
        }
        if ($this->isColumnModified(AlbiTmpTableMap::COL_DT_PUBBLICAZ_DAL)) {
            $modifiedColumns[':p' . $index++]  = 'dt_pubblicaz_dal';
        }
        if ($this->isColumnModified(AlbiTmpTableMap::COL_DT_PUBBLICAZ_AL)) {
            $modifiedColumns[':p' . $index++]  = 'dt_pubblicaz_al';
        }
        if ($this->isColumnModified(AlbiTmpTableMap::COL_DT_ATTO)) {
            $modifiedColumns[':p' . $index++]  = 'dt_atto';
        }
        if ($this->isColumnModified(AlbiTmpTableMap::COL_NR_ATTO)) {
            $modifiedColumns[':p' . $index++]  = 'nr_atto';
        }
        if ($this->isColumnModified(AlbiTmpTableMap::COL_OGGETTO)) {
            $modifiedColumns[':p' . $index++]  = 'oggetto';
        }
        if ($this->isColumnModified(AlbiTmpTableMap::COL_AUTORITA_EMANANTE)) {
            $modifiedColumns[':p' . $index++]  = 'autorita_emanante';
        }
        if ($this->isColumnModified(AlbiTmpTableMap::COL_ID_AREA)) {
            $modifiedColumns[':p' . $index++]  = 'id_area';
        }
        if ($this->isColumnModified(AlbiTmpTableMap::COL_FILE)) {
            $modifiedColumns[':p' . $index++]  = 'file';
        }

        $sql = sprintf(
            'INSERT INTO albi_tmp (%s) VALUES (%s)',
            implode(', ', $modifiedColumns),
            implode(', ', array_keys($modifiedColumns))
        );

        try {
            $stmt = $con->prepare($sql);
            foreach ($modifiedColumns as $identifier => $columnName) {
                switch ($columnName) {
                    case 'id_albo':
                        $stmt->bindValue($identifier, $this->id_albo, PDO::PARAM_INT);
                        break;
                    case 'id_tipo':
                        $stmt->bindValue($identifier, $this->id_tipo, PDO::PARAM_INT);
                        break;
                    case 'dt_pubblicaz_dal':
                        $stmt->bindValue($identifier, $this->dt_pubblicaz_dal ? $this->dt_pubblicaz_dal->format("Y-m-d H:i:s") : null, PDO::PARAM_STR);
                        break;
                    case 'dt_pubblicaz_al':
                        $stmt->bindValue($identifier, $this->dt_pubblicaz_al ? $this->dt_pubblicaz_al->format("Y-m-d H:i:s") : null, PDO::PARAM_STR);
                        break;
                    case 'dt_atto':
                        $stmt->bindValue($identifier, $this->dt_atto ? $this->dt_atto->format("Y-m-d H:i:s") : null, PDO::PARAM_STR);
                        break;
                    case 'nr_atto':
                        $stmt->bindValue($identifier, $this->nr_atto, PDO::PARAM_INT);
                        break;
                    case 'oggetto':
                        $stmt->bindValue($identifier, $this->oggetto, PDO::PARAM_STR);
                        break;
                    case 'autorita_emanante':
                        $stmt->bindValue($identifier, $this->autorita_emanante, PDO::PARAM_STR);
                        break;
                    case 'id_area':
                        $stmt->bindValue($identifier, $this->id_area, PDO::PARAM_INT);
                        break;
                    case 'file':
                        $stmt->bindValue($identifier, $this->file, PDO::PARAM_STR);
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
        $this->setIdAlbo($pk);

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
     *                     one of the class type constants TableMap::TYPE_PHPNAME, TableMap::TYPE_CAMELNAME
     *                     TableMap::TYPE_COLNAME, TableMap::TYPE_FIELDNAME, TableMap::TYPE_NUM.
     *                     Defaults to TableMap::TYPE_PHPNAME.
     * @return mixed Value of field.
     */
    public function getByName($name, $type = TableMap::TYPE_PHPNAME)
    {
        $pos = AlbiTmpTableMap::translateFieldName($name, $type, TableMap::TYPE_NUM);
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
                return $this->getIdAlbo();
                break;
            case 1:
                return $this->getIdTipo();
                break;
            case 2:
                return $this->getDtPubblicazDal();
                break;
            case 3:
                return $this->getDtPubblicazAl();
                break;
            case 4:
                return $this->getDtAtto();
                break;
            case 5:
                return $this->getNrAtto();
                break;
            case 6:
                return $this->getOggetto();
                break;
            case 7:
                return $this->getAutoritaEmanante();
                break;
            case 8:
                return $this->getIdArea();
                break;
            case 9:
                return $this->getFile();
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
     * @param     string  $keyType (optional) One of the class type constants TableMap::TYPE_PHPNAME, TableMap::TYPE_CAMELNAME,
     *                    TableMap::TYPE_COLNAME, TableMap::TYPE_FIELDNAME, TableMap::TYPE_NUM.
     *                    Defaults to TableMap::TYPE_PHPNAME.
     * @param     boolean $includeLazyLoadColumns (optional) Whether to include lazy loaded columns. Defaults to TRUE.
     * @param     array $alreadyDumpedObjects List of objects to skip to avoid recursion
     *
     * @return array an associative array containing the field names (as keys) and field values
     */
    public function toArray($keyType = TableMap::TYPE_PHPNAME, $includeLazyLoadColumns = true, $alreadyDumpedObjects = array())
    {

        if (isset($alreadyDumpedObjects['AlbiTmp'][$this->hashCode()])) {
            return '*RECURSION*';
        }
        $alreadyDumpedObjects['AlbiTmp'][$this->hashCode()] = true;
        $keys = AlbiTmpTableMap::getFieldNames($keyType);
        $result = array(
            $keys[0] => $this->getIdAlbo(),
            $keys[1] => $this->getIdTipo(),
            $keys[2] => $this->getDtPubblicazDal(),
            $keys[3] => $this->getDtPubblicazAl(),
            $keys[4] => $this->getDtAtto(),
            $keys[5] => $this->getNrAtto(),
            $keys[6] => $this->getOggetto(),
            $keys[7] => $this->getAutoritaEmanante(),
            $keys[8] => $this->getIdArea(),
            $keys[9] => $this->getFile(),
        );
        if ($result[$keys[2]] instanceof \DateTime) {
            $result[$keys[2]] = $result[$keys[2]]->format('c');
        }

        if ($result[$keys[3]] instanceof \DateTime) {
            $result[$keys[3]] = $result[$keys[3]]->format('c');
        }

        if ($result[$keys[4]] instanceof \DateTime) {
            $result[$keys[4]] = $result[$keys[4]]->format('c');
        }

        $virtualColumns = $this->virtualColumns;
        foreach ($virtualColumns as $key => $virtualColumn) {
            $result[$key] = $virtualColumn;
        }


        return $result;
    }

    /**
     * Sets a field from the object by name passed in as a string.
     *
     * @param  string $name
     * @param  mixed  $value field value
     * @param  string $type The type of fieldname the $name is of:
     *                one of the class type constants TableMap::TYPE_PHPNAME, TableMap::TYPE_CAMELNAME
     *                TableMap::TYPE_COLNAME, TableMap::TYPE_FIELDNAME, TableMap::TYPE_NUM.
     *                Defaults to TableMap::TYPE_PHPNAME.
     * @return $this|\AlbiTmp
     */
    public function setByName($name, $value, $type = TableMap::TYPE_PHPNAME)
    {
        $pos = AlbiTmpTableMap::translateFieldName($name, $type, TableMap::TYPE_NUM);

        return $this->setByPosition($pos, $value);
    }

    /**
     * Sets a field from the object by Position as specified in the xml schema.
     * Zero-based.
     *
     * @param  int $pos position in xml schema
     * @param  mixed $value field value
     * @return $this|\AlbiTmp
     */
    public function setByPosition($pos, $value)
    {
        switch ($pos) {
            case 0:
                $this->setIdAlbo($value);
                break;
            case 1:
                $this->setIdTipo($value);
                break;
            case 2:
                $this->setDtPubblicazDal($value);
                break;
            case 3:
                $this->setDtPubblicazAl($value);
                break;
            case 4:
                $this->setDtAtto($value);
                break;
            case 5:
                $this->setNrAtto($value);
                break;
            case 6:
                $this->setOggetto($value);
                break;
            case 7:
                $this->setAutoritaEmanante($value);
                break;
            case 8:
                $this->setIdArea($value);
                break;
            case 9:
                $this->setFile($value);
                break;
        } // switch()

        return $this;
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
     * of the class type constants TableMap::TYPE_PHPNAME, TableMap::TYPE_CAMELNAME,
     * TableMap::TYPE_COLNAME, TableMap::TYPE_FIELDNAME, TableMap::TYPE_NUM.
     * The default key type is the column's TableMap::TYPE_PHPNAME.
     *
     * @param      array  $arr     An array to populate the object from.
     * @param      string $keyType The type of keys the array uses.
     * @return void
     */
    public function fromArray($arr, $keyType = TableMap::TYPE_PHPNAME)
    {
        $keys = AlbiTmpTableMap::getFieldNames($keyType);

        if (array_key_exists($keys[0], $arr)) {
            $this->setIdAlbo($arr[$keys[0]]);
        }
        if (array_key_exists($keys[1], $arr)) {
            $this->setIdTipo($arr[$keys[1]]);
        }
        if (array_key_exists($keys[2], $arr)) {
            $this->setDtPubblicazDal($arr[$keys[2]]);
        }
        if (array_key_exists($keys[3], $arr)) {
            $this->setDtPubblicazAl($arr[$keys[3]]);
        }
        if (array_key_exists($keys[4], $arr)) {
            $this->setDtAtto($arr[$keys[4]]);
        }
        if (array_key_exists($keys[5], $arr)) {
            $this->setNrAtto($arr[$keys[5]]);
        }
        if (array_key_exists($keys[6], $arr)) {
            $this->setOggetto($arr[$keys[6]]);
        }
        if (array_key_exists($keys[7], $arr)) {
            $this->setAutoritaEmanante($arr[$keys[7]]);
        }
        if (array_key_exists($keys[8], $arr)) {
            $this->setIdArea($arr[$keys[8]]);
        }
        if (array_key_exists($keys[9], $arr)) {
            $this->setFile($arr[$keys[9]]);
        }
    }

     /**
     * Populate the current object from a string, using a given parser format
     * <code>
     * $book = new Book();
     * $book->importFrom('JSON', '{"Id":9012,"Title":"Don Juan","ISBN":"0140422161","Price":12.99,"PublisherId":1234,"AuthorId":5678}');
     * </code>
     *
     * You can specify the key type of the array by additionally passing one
     * of the class type constants TableMap::TYPE_PHPNAME, TableMap::TYPE_CAMELNAME,
     * TableMap::TYPE_COLNAME, TableMap::TYPE_FIELDNAME, TableMap::TYPE_NUM.
     * The default key type is the column's TableMap::TYPE_PHPNAME.
     *
     * @param mixed $parser A AbstractParser instance,
     *                       or a format name ('XML', 'YAML', 'JSON', 'CSV')
     * @param string $data The source data to import from
     * @param string $keyType The type of keys the array uses.
     *
     * @return $this|\AlbiTmp The current object, for fluid interface
     */
    public function importFrom($parser, $data, $keyType = TableMap::TYPE_PHPNAME)
    {
        if (!$parser instanceof AbstractParser) {
            $parser = AbstractParser::getParser($parser);
        }

        $this->fromArray($parser->toArray($data), $keyType);

        return $this;
    }

    /**
     * Build a Criteria object containing the values of all modified columns in this object.
     *
     * @return Criteria The Criteria object containing all modified values.
     */
    public function buildCriteria()
    {
        $criteria = new Criteria(AlbiTmpTableMap::DATABASE_NAME);

        if ($this->isColumnModified(AlbiTmpTableMap::COL_ID_ALBO)) {
            $criteria->add(AlbiTmpTableMap::COL_ID_ALBO, $this->id_albo);
        }
        if ($this->isColumnModified(AlbiTmpTableMap::COL_ID_TIPO)) {
            $criteria->add(AlbiTmpTableMap::COL_ID_TIPO, $this->id_tipo);
        }
        if ($this->isColumnModified(AlbiTmpTableMap::COL_DT_PUBBLICAZ_DAL)) {
            $criteria->add(AlbiTmpTableMap::COL_DT_PUBBLICAZ_DAL, $this->dt_pubblicaz_dal);
        }
        if ($this->isColumnModified(AlbiTmpTableMap::COL_DT_PUBBLICAZ_AL)) {
            $criteria->add(AlbiTmpTableMap::COL_DT_PUBBLICAZ_AL, $this->dt_pubblicaz_al);
        }
        if ($this->isColumnModified(AlbiTmpTableMap::COL_DT_ATTO)) {
            $criteria->add(AlbiTmpTableMap::COL_DT_ATTO, $this->dt_atto);
        }
        if ($this->isColumnModified(AlbiTmpTableMap::COL_NR_ATTO)) {
            $criteria->add(AlbiTmpTableMap::COL_NR_ATTO, $this->nr_atto);
        }
        if ($this->isColumnModified(AlbiTmpTableMap::COL_OGGETTO)) {
            $criteria->add(AlbiTmpTableMap::COL_OGGETTO, $this->oggetto);
        }
        if ($this->isColumnModified(AlbiTmpTableMap::COL_AUTORITA_EMANANTE)) {
            $criteria->add(AlbiTmpTableMap::COL_AUTORITA_EMANANTE, $this->autorita_emanante);
        }
        if ($this->isColumnModified(AlbiTmpTableMap::COL_ID_AREA)) {
            $criteria->add(AlbiTmpTableMap::COL_ID_AREA, $this->id_area);
        }
        if ($this->isColumnModified(AlbiTmpTableMap::COL_FILE)) {
            $criteria->add(AlbiTmpTableMap::COL_FILE, $this->file);
        }

        return $criteria;
    }

    /**
     * Builds a Criteria object containing the primary key for this object.
     *
     * Unlike buildCriteria() this method includes the primary key values regardless
     * of whether or not they have been modified.
     *
     * @throws LogicException if no primary key is defined
     *
     * @return Criteria The Criteria object containing value(s) for primary key(s).
     */
    public function buildPkeyCriteria()
    {
        $criteria = ChildAlbiTmpQuery::create();
        $criteria->add(AlbiTmpTableMap::COL_ID_ALBO, $this->id_albo);

        return $criteria;
    }

    /**
     * If the primary key is not null, return the hashcode of the
     * primary key. Otherwise, return the hash code of the object.
     *
     * @return int Hashcode
     */
    public function hashCode()
    {
        $validPk = null !== $this->getIdAlbo();

        $validPrimaryKeyFKs = 0;
        $primaryKeyFKs = [];

        if ($validPk) {
            return crc32(json_encode($this->getPrimaryKey(), JSON_UNESCAPED_UNICODE));
        } elseif ($validPrimaryKeyFKs) {
            return crc32(json_encode($primaryKeyFKs, JSON_UNESCAPED_UNICODE));
        }

        return spl_object_hash($this);
    }

    /**
     * Returns the primary key for this object (row).
     * @return int
     */
    public function getPrimaryKey()
    {
        return $this->getIdAlbo();
    }

    /**
     * Generic method to set the primary key (id_albo column).
     *
     * @param       int $key Primary key.
     * @return void
     */
    public function setPrimaryKey($key)
    {
        $this->setIdAlbo($key);
    }

    /**
     * Returns true if the primary key for this object is null.
     * @return boolean
     */
    public function isPrimaryKeyNull()
    {
        return null === $this->getIdAlbo();
    }

    /**
     * Sets contents of passed object to values from current object.
     *
     * If desired, this method can also make copies of all associated (fkey referrers)
     * objects.
     *
     * @param      object $copyObj An object of \AlbiTmp (or compatible) type.
     * @param      boolean $deepCopy Whether to also copy all rows that refer (by fkey) to the current row.
     * @param      boolean $makeNew Whether to reset autoincrement PKs and make the object new.
     * @throws PropelException
     */
    public function copyInto($copyObj, $deepCopy = false, $makeNew = true)
    {
        $copyObj->setIdTipo($this->getIdTipo());
        $copyObj->setDtPubblicazDal($this->getDtPubblicazDal());
        $copyObj->setDtPubblicazAl($this->getDtPubblicazAl());
        $copyObj->setDtAtto($this->getDtAtto());
        $copyObj->setNrAtto($this->getNrAtto());
        $copyObj->setOggetto($this->getOggetto());
        $copyObj->setAutoritaEmanante($this->getAutoritaEmanante());
        $copyObj->setIdArea($this->getIdArea());
        $copyObj->setFile($this->getFile());
        if ($makeNew) {
            $copyObj->setNew(true);
            $copyObj->setIdAlbo(NULL); // this is a auto-increment column, so set to default value
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
     * @param  boolean $deepCopy Whether to also copy all rows that refer (by fkey) to the current row.
     * @return \AlbiTmp Clone of current object.
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
     * Clears the current object, sets all attributes to their default values and removes
     * outgoing references as well as back-references (from other objects to this one. Results probably in a database
     * change of those foreign objects when you call `save` there).
     */
    public function clear()
    {
        $this->id_albo = null;
        $this->id_tipo = null;
        $this->dt_pubblicaz_dal = null;
        $this->dt_pubblicaz_al = null;
        $this->dt_atto = null;
        $this->nr_atto = null;
        $this->oggetto = null;
        $this->autorita_emanante = null;
        $this->id_area = null;
        $this->file = null;
        $this->alreadyInSave = false;
        $this->clearAllReferences();
        $this->resetModified();
        $this->setNew(true);
        $this->setDeleted(false);
    }

    /**
     * Resets all references and back-references to other model objects or collections of model objects.
     *
     * This method is used to reset all php object references (not the actual reference in the database).
     * Necessary for object serialisation.
     *
     * @param      boolean $deep Whether to also clear the references on all referrer objects.
     */
    public function clearAllReferences($deep = false)
    {
        if ($deep) {
        } // if ($deep)

    }

    /**
     * Return the string representation of this object
     *
     * @return string
     */
    public function __toString()
    {
        return (string) $this->exportTo(AlbiTmpTableMap::DEFAULT_STRING_FORMAT);
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

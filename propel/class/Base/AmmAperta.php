<?php

namespace Base;

use \AmmApertaQuery as ChildAmmApertaQuery;
use \DateTime;
use \Exception;
use \PDO;
use Map\AmmApertaTableMap;
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
 * Base class that represents a row from the 'amm_aperta' table.
 *
 *
 *
* @package    propel.generator..Base
*/
abstract class AmmAperta implements ActiveRecordInterface
{
    /**
     * TableMap class name
     */
    const TABLE_MAP = '\\Map\\AmmApertaTableMap';


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
     * The value for the id_amm_aperta field.
     *
     * @var        int
     */
    protected $id_amm_aperta;

    /**
     * The value for the id_albo field.
     *
     * @var        int
     */
    protected $id_albo;

    /**
     * The value for the ragionesociale field.
     *
     * @var        string
     */
    protected $ragionesociale;

    /**
     * The value for the piva field.
     *
     * @var        string
     */
    protected $piva;

    /**
     * The value for the resp_proc field.
     *
     * @var        string
     */
    protected $resp_proc;

    /**
     * The value for the norma field.
     *
     * @var        string
     */
    protected $norma;

    /**
     * The value for the modalita field.
     *
     * @var        string
     */
    protected $modalita;

    /**
     * The value for the importo field.
     *
     * @var        string
     */
    protected $importo;

    /**
     * The value for the pubblicato field.
     *
     * Note: this column has a database default value of: 'N'
     * @var        string
     */
    protected $pubblicato;

    /**
     * The value for the dt_pubblicazione field.
     *
     * @var        \DateTime
     */
    protected $dt_pubblicazione;

    /**
     * The value for the resp_proc_idrubrica field.
     *
     * Note: this column has a database default value of: 0
     * @var        int
     */
    protected $resp_proc_idrubrica;

    /**
     * Flag to prevent endless save loop, if this object is referenced
     * by another object which falls in this transaction.
     *
     * @var boolean
     */
    protected $alreadyInSave = false;

    /**
     * Applies default values to this object.
     * This method should be called from the object's constructor (or
     * equivalent initialization method).
     * @see __construct()
     */
    public function applyDefaultValues()
    {
        $this->pubblicato = 'N';
        $this->resp_proc_idrubrica = 0;
    }

    /**
     * Initializes internal state of Base\AmmAperta object.
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
     * Compares this with another <code>AmmAperta</code> instance.  If
     * <code>obj</code> is an instance of <code>AmmAperta</code>, delegates to
     * <code>equals(AmmAperta)</code>.  Otherwise, returns <code>false</code>.
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
     * @return $this|AmmAperta The current object, for fluid interface
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
     * Get the [id_amm_aperta] column value.
     *
     * @return int
     */
    public function getIdAmmAperta()
    {
        return $this->id_amm_aperta;
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
     * Get the [ragionesociale] column value.
     *
     * @return string
     */
    public function getRagionesociale()
    {
        return $this->ragionesociale;
    }

    /**
     * Get the [piva] column value.
     *
     * @return string
     */
    public function getPiva()
    {
        return $this->piva;
    }

    /**
     * Get the [resp_proc] column value.
     *
     * @return string
     */
    public function getRespProc()
    {
        return $this->resp_proc;
    }

    /**
     * Get the [norma] column value.
     *
     * @return string
     */
    public function getNorma()
    {
        return $this->norma;
    }

    /**
     * Get the [modalita] column value.
     *
     * @return string
     */
    public function getModalita()
    {
        return $this->modalita;
    }

    /**
     * Get the [importo] column value.
     *
     * @return string
     */
    public function getImporto()
    {
        return $this->importo;
    }

    /**
     * Get the [pubblicato] column value.
     *
     * @return string
     */
    public function getPubblicato()
    {
        return $this->pubblicato;
    }

    /**
     * Get the [optionally formatted] temporal [dt_pubblicazione] column value.
     *
     *
     * @param      string $format The date/time format string (either date()-style or strftime()-style).
     *                            If format is NULL, then the raw DateTime object will be returned.
     *
     * @return string|DateTime Formatted date/time value as string or DateTime object (if format is NULL), NULL if column is NULL, and 0 if column value is 0000-00-00
     *
     * @throws PropelException - if unable to parse/validate the date/time value.
     */
    public function getDtPubblicazione($format = NULL)
    {
        if ($format === null) {
            return $this->dt_pubblicazione;
        } else {
            return $this->dt_pubblicazione instanceof \DateTime ? $this->dt_pubblicazione->format($format) : null;
        }
    }

    /**
     * Get the [resp_proc_idrubrica] column value.
     *
     * @return int
     */
    public function getRespProcIdrubrica()
    {
        return $this->resp_proc_idrubrica;
    }

    /**
     * Set the value of [id_amm_aperta] column.
     *
     * @param int $v new value
     * @return $this|\AmmAperta The current object (for fluent API support)
     */
    public function setIdAmmAperta($v)
    {
        if ($v !== null) {
            $v = (int) $v;
        }

        if ($this->id_amm_aperta !== $v) {
            $this->id_amm_aperta = $v;
            $this->modifiedColumns[AmmApertaTableMap::COL_ID_AMM_APERTA] = true;
        }

        return $this;
    } // setIdAmmAperta()

    /**
     * Set the value of [id_albo] column.
     *
     * @param int $v new value
     * @return $this|\AmmAperta The current object (for fluent API support)
     */
    public function setIdAlbo($v)
    {
        if ($v !== null) {
            $v = (int) $v;
        }

        if ($this->id_albo !== $v) {
            $this->id_albo = $v;
            $this->modifiedColumns[AmmApertaTableMap::COL_ID_ALBO] = true;
        }

        return $this;
    } // setIdAlbo()

    /**
     * Set the value of [ragionesociale] column.
     *
     * @param string $v new value
     * @return $this|\AmmAperta The current object (for fluent API support)
     */
    public function setRagionesociale($v)
    {
        if ($v !== null) {
            $v = (string) $v;
        }

        if ($this->ragionesociale !== $v) {
            $this->ragionesociale = $v;
            $this->modifiedColumns[AmmApertaTableMap::COL_RAGIONESOCIALE] = true;
        }

        return $this;
    } // setRagionesociale()

    /**
     * Set the value of [piva] column.
     *
     * @param string $v new value
     * @return $this|\AmmAperta The current object (for fluent API support)
     */
    public function setPiva($v)
    {
        if ($v !== null) {
            $v = (string) $v;
        }

        if ($this->piva !== $v) {
            $this->piva = $v;
            $this->modifiedColumns[AmmApertaTableMap::COL_PIVA] = true;
        }

        return $this;
    } // setPiva()

    /**
     * Set the value of [resp_proc] column.
     *
     * @param string $v new value
     * @return $this|\AmmAperta The current object (for fluent API support)
     */
    public function setRespProc($v)
    {
        if ($v !== null) {
            $v = (string) $v;
        }

        if ($this->resp_proc !== $v) {
            $this->resp_proc = $v;
            $this->modifiedColumns[AmmApertaTableMap::COL_RESP_PROC] = true;
        }

        return $this;
    } // setRespProc()

    /**
     * Set the value of [norma] column.
     *
     * @param string $v new value
     * @return $this|\AmmAperta The current object (for fluent API support)
     */
    public function setNorma($v)
    {
        if ($v !== null) {
            $v = (string) $v;
        }

        if ($this->norma !== $v) {
            $this->norma = $v;
            $this->modifiedColumns[AmmApertaTableMap::COL_NORMA] = true;
        }

        return $this;
    } // setNorma()

    /**
     * Set the value of [modalita] column.
     *
     * @param string $v new value
     * @return $this|\AmmAperta The current object (for fluent API support)
     */
    public function setModalita($v)
    {
        if ($v !== null) {
            $v = (string) $v;
        }

        if ($this->modalita !== $v) {
            $this->modalita = $v;
            $this->modifiedColumns[AmmApertaTableMap::COL_MODALITA] = true;
        }

        return $this;
    } // setModalita()

    /**
     * Set the value of [importo] column.
     *
     * @param string $v new value
     * @return $this|\AmmAperta The current object (for fluent API support)
     */
    public function setImporto($v)
    {
        if ($v !== null) {
            $v = (string) $v;
        }

        if ($this->importo !== $v) {
            $this->importo = $v;
            $this->modifiedColumns[AmmApertaTableMap::COL_IMPORTO] = true;
        }

        return $this;
    } // setImporto()

    /**
     * Set the value of [pubblicato] column.
     *
     * @param string $v new value
     * @return $this|\AmmAperta The current object (for fluent API support)
     */
    public function setPubblicato($v)
    {
        if ($v !== null) {
            $v = (string) $v;
        }

        if ($this->pubblicato !== $v) {
            $this->pubblicato = $v;
            $this->modifiedColumns[AmmApertaTableMap::COL_PUBBLICATO] = true;
        }

        return $this;
    } // setPubblicato()

    /**
     * Sets the value of [dt_pubblicazione] column to a normalized version of the date/time value specified.
     *
     * @param  mixed $v string, integer (timestamp), or \DateTime value.
     *               Empty strings are treated as NULL.
     * @return $this|\AmmAperta The current object (for fluent API support)
     */
    public function setDtPubblicazione($v)
    {
        $dt = PropelDateTime::newInstance($v, null, 'DateTime');
        if ($this->dt_pubblicazione !== null || $dt !== null) {
            if ($this->dt_pubblicazione === null || $dt === null || $dt->format("Y-m-d") !== $this->dt_pubblicazione->format("Y-m-d")) {
                $this->dt_pubblicazione = $dt === null ? null : clone $dt;
                $this->modifiedColumns[AmmApertaTableMap::COL_DT_PUBBLICAZIONE] = true;
            }
        } // if either are not null

        return $this;
    } // setDtPubblicazione()

    /**
     * Set the value of [resp_proc_idrubrica] column.
     *
     * @param int $v new value
     * @return $this|\AmmAperta The current object (for fluent API support)
     */
    public function setRespProcIdrubrica($v)
    {
        if ($v !== null) {
            $v = (int) $v;
        }

        if ($this->resp_proc_idrubrica !== $v) {
            $this->resp_proc_idrubrica = $v;
            $this->modifiedColumns[AmmApertaTableMap::COL_RESP_PROC_IDRUBRICA] = true;
        }

        return $this;
    } // setRespProcIdrubrica()

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
            if ($this->pubblicato !== 'N') {
                return false;
            }

            if ($this->resp_proc_idrubrica !== 0) {
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
                                  One of the class type constants TableMap::TYPE_PHPNAME, TableMap::TYPE_CAMELNAME
     *                            TableMap::TYPE_COLNAME, TableMap::TYPE_FIELDNAME, TableMap::TYPE_NUM.
     *
     * @return int             next starting column
     * @throws PropelException - Any caught Exception will be rewrapped as a PropelException.
     */
    public function hydrate($row, $startcol = 0, $rehydrate = false, $indexType = TableMap::TYPE_NUM)
    {
        try {

            $col = $row[TableMap::TYPE_NUM == $indexType ? 0 + $startcol : AmmApertaTableMap::translateFieldName('IdAmmAperta', TableMap::TYPE_PHPNAME, $indexType)];
            $this->id_amm_aperta = (null !== $col) ? (int) $col : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 1 + $startcol : AmmApertaTableMap::translateFieldName('IdAlbo', TableMap::TYPE_PHPNAME, $indexType)];
            $this->id_albo = (null !== $col) ? (int) $col : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 2 + $startcol : AmmApertaTableMap::translateFieldName('Ragionesociale', TableMap::TYPE_PHPNAME, $indexType)];
            $this->ragionesociale = (null !== $col) ? (string) $col : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 3 + $startcol : AmmApertaTableMap::translateFieldName('Piva', TableMap::TYPE_PHPNAME, $indexType)];
            $this->piva = (null !== $col) ? (string) $col : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 4 + $startcol : AmmApertaTableMap::translateFieldName('RespProc', TableMap::TYPE_PHPNAME, $indexType)];
            $this->resp_proc = (null !== $col) ? (string) $col : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 5 + $startcol : AmmApertaTableMap::translateFieldName('Norma', TableMap::TYPE_PHPNAME, $indexType)];
            $this->norma = (null !== $col) ? (string) $col : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 6 + $startcol : AmmApertaTableMap::translateFieldName('Modalita', TableMap::TYPE_PHPNAME, $indexType)];
            $this->modalita = (null !== $col) ? (string) $col : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 7 + $startcol : AmmApertaTableMap::translateFieldName('Importo', TableMap::TYPE_PHPNAME, $indexType)];
            $this->importo = (null !== $col) ? (string) $col : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 8 + $startcol : AmmApertaTableMap::translateFieldName('Pubblicato', TableMap::TYPE_PHPNAME, $indexType)];
            $this->pubblicato = (null !== $col) ? (string) $col : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 9 + $startcol : AmmApertaTableMap::translateFieldName('DtPubblicazione', TableMap::TYPE_PHPNAME, $indexType)];
            if ($col === '0000-00-00') {
                $col = null;
            }
            $this->dt_pubblicazione = (null !== $col) ? PropelDateTime::newInstance($col, null, 'DateTime') : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 10 + $startcol : AmmApertaTableMap::translateFieldName('RespProcIdrubrica', TableMap::TYPE_PHPNAME, $indexType)];
            $this->resp_proc_idrubrica = (null !== $col) ? (int) $col : null;
            $this->resetModified();

            $this->setNew(false);

            if ($rehydrate) {
                $this->ensureConsistency();
            }

            return $startcol + 11; // 11 = AmmApertaTableMap::NUM_HYDRATE_COLUMNS.

        } catch (Exception $e) {
            throw new PropelException(sprintf('Error populating %s object', '\\AmmAperta'), 0, $e);
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
            $con = Propel::getServiceContainer()->getReadConnection(AmmApertaTableMap::DATABASE_NAME);
        }

        // We don't need to alter the object instance pool; we're just modifying this instance
        // already in the pool.

        $dataFetcher = ChildAmmApertaQuery::create(null, $this->buildPkeyCriteria())->setFormatter(ModelCriteria::FORMAT_STATEMENT)->find($con);
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
     * @see AmmAperta::setDeleted()
     * @see AmmAperta::isDeleted()
     */
    public function delete(ConnectionInterface $con = null)
    {
        if ($this->isDeleted()) {
            throw new PropelException("This object has already been deleted.");
        }

        if ($con === null) {
            $con = Propel::getServiceContainer()->getWriteConnection(AmmApertaTableMap::DATABASE_NAME);
        }

        $con->transaction(function () use ($con) {
            $deleteQuery = ChildAmmApertaQuery::create()
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
            $con = Propel::getServiceContainer()->getWriteConnection(AmmApertaTableMap::DATABASE_NAME);
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
                AmmApertaTableMap::addInstanceToPool($this);
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

        $this->modifiedColumns[AmmApertaTableMap::COL_ID_AMM_APERTA] = true;
        if (null !== $this->id_amm_aperta) {
            throw new PropelException('Cannot insert a value for auto-increment primary key (' . AmmApertaTableMap::COL_ID_AMM_APERTA . ')');
        }

         // check the columns in natural order for more readable SQL queries
        if ($this->isColumnModified(AmmApertaTableMap::COL_ID_AMM_APERTA)) {
            $modifiedColumns[':p' . $index++]  = 'id_amm_aperta';
        }
        if ($this->isColumnModified(AmmApertaTableMap::COL_ID_ALBO)) {
            $modifiedColumns[':p' . $index++]  = 'id_albo';
        }
        if ($this->isColumnModified(AmmApertaTableMap::COL_RAGIONESOCIALE)) {
            $modifiedColumns[':p' . $index++]  = 'ragionesociale';
        }
        if ($this->isColumnModified(AmmApertaTableMap::COL_PIVA)) {
            $modifiedColumns[':p' . $index++]  = 'piva';
        }
        if ($this->isColumnModified(AmmApertaTableMap::COL_RESP_PROC)) {
            $modifiedColumns[':p' . $index++]  = 'resp_proc';
        }
        if ($this->isColumnModified(AmmApertaTableMap::COL_NORMA)) {
            $modifiedColumns[':p' . $index++]  = 'norma';
        }
        if ($this->isColumnModified(AmmApertaTableMap::COL_MODALITA)) {
            $modifiedColumns[':p' . $index++]  = 'modalita';
        }
        if ($this->isColumnModified(AmmApertaTableMap::COL_IMPORTO)) {
            $modifiedColumns[':p' . $index++]  = 'importo';
        }
        if ($this->isColumnModified(AmmApertaTableMap::COL_PUBBLICATO)) {
            $modifiedColumns[':p' . $index++]  = 'pubblicato';
        }
        if ($this->isColumnModified(AmmApertaTableMap::COL_DT_PUBBLICAZIONE)) {
            $modifiedColumns[':p' . $index++]  = 'dt_pubblicazione';
        }
        if ($this->isColumnModified(AmmApertaTableMap::COL_RESP_PROC_IDRUBRICA)) {
            $modifiedColumns[':p' . $index++]  = 'resp_proc_idrubrica';
        }

        $sql = sprintf(
            'INSERT INTO amm_aperta (%s) VALUES (%s)',
            implode(', ', $modifiedColumns),
            implode(', ', array_keys($modifiedColumns))
        );

        try {
            $stmt = $con->prepare($sql);
            foreach ($modifiedColumns as $identifier => $columnName) {
                switch ($columnName) {
                    case 'id_amm_aperta':
                        $stmt->bindValue($identifier, $this->id_amm_aperta, PDO::PARAM_INT);
                        break;
                    case 'id_albo':
                        $stmt->bindValue($identifier, $this->id_albo, PDO::PARAM_INT);
                        break;
                    case 'ragionesociale':
                        $stmt->bindValue($identifier, $this->ragionesociale, PDO::PARAM_STR);
                        break;
                    case 'piva':
                        $stmt->bindValue($identifier, $this->piva, PDO::PARAM_STR);
                        break;
                    case 'resp_proc':
                        $stmt->bindValue($identifier, $this->resp_proc, PDO::PARAM_STR);
                        break;
                    case 'norma':
                        $stmt->bindValue($identifier, $this->norma, PDO::PARAM_STR);
                        break;
                    case 'modalita':
                        $stmt->bindValue($identifier, $this->modalita, PDO::PARAM_STR);
                        break;
                    case 'importo':
                        $stmt->bindValue($identifier, $this->importo, PDO::PARAM_STR);
                        break;
                    case 'pubblicato':
                        $stmt->bindValue($identifier, $this->pubblicato, PDO::PARAM_STR);
                        break;
                    case 'dt_pubblicazione':
                        $stmt->bindValue($identifier, $this->dt_pubblicazione ? $this->dt_pubblicazione->format("Y-m-d H:i:s") : null, PDO::PARAM_STR);
                        break;
                    case 'resp_proc_idrubrica':
                        $stmt->bindValue($identifier, $this->resp_proc_idrubrica, PDO::PARAM_INT);
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
        $this->setIdAmmAperta($pk);

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
        $pos = AmmApertaTableMap::translateFieldName($name, $type, TableMap::TYPE_NUM);
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
                return $this->getIdAmmAperta();
                break;
            case 1:
                return $this->getIdAlbo();
                break;
            case 2:
                return $this->getRagionesociale();
                break;
            case 3:
                return $this->getPiva();
                break;
            case 4:
                return $this->getRespProc();
                break;
            case 5:
                return $this->getNorma();
                break;
            case 6:
                return $this->getModalita();
                break;
            case 7:
                return $this->getImporto();
                break;
            case 8:
                return $this->getPubblicato();
                break;
            case 9:
                return $this->getDtPubblicazione();
                break;
            case 10:
                return $this->getRespProcIdrubrica();
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

        if (isset($alreadyDumpedObjects['AmmAperta'][$this->hashCode()])) {
            return '*RECURSION*';
        }
        $alreadyDumpedObjects['AmmAperta'][$this->hashCode()] = true;
        $keys = AmmApertaTableMap::getFieldNames($keyType);
        $result = array(
            $keys[0] => $this->getIdAmmAperta(),
            $keys[1] => $this->getIdAlbo(),
            $keys[2] => $this->getRagionesociale(),
            $keys[3] => $this->getPiva(),
            $keys[4] => $this->getRespProc(),
            $keys[5] => $this->getNorma(),
            $keys[6] => $this->getModalita(),
            $keys[7] => $this->getImporto(),
            $keys[8] => $this->getPubblicato(),
            $keys[9] => $this->getDtPubblicazione(),
            $keys[10] => $this->getRespProcIdrubrica(),
        );
        if ($result[$keys[9]] instanceof \DateTime) {
            $result[$keys[9]] = $result[$keys[9]]->format('c');
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
     * @return $this|\AmmAperta
     */
    public function setByName($name, $value, $type = TableMap::TYPE_PHPNAME)
    {
        $pos = AmmApertaTableMap::translateFieldName($name, $type, TableMap::TYPE_NUM);

        return $this->setByPosition($pos, $value);
    }

    /**
     * Sets a field from the object by Position as specified in the xml schema.
     * Zero-based.
     *
     * @param  int $pos position in xml schema
     * @param  mixed $value field value
     * @return $this|\AmmAperta
     */
    public function setByPosition($pos, $value)
    {
        switch ($pos) {
            case 0:
                $this->setIdAmmAperta($value);
                break;
            case 1:
                $this->setIdAlbo($value);
                break;
            case 2:
                $this->setRagionesociale($value);
                break;
            case 3:
                $this->setPiva($value);
                break;
            case 4:
                $this->setRespProc($value);
                break;
            case 5:
                $this->setNorma($value);
                break;
            case 6:
                $this->setModalita($value);
                break;
            case 7:
                $this->setImporto($value);
                break;
            case 8:
                $this->setPubblicato($value);
                break;
            case 9:
                $this->setDtPubblicazione($value);
                break;
            case 10:
                $this->setRespProcIdrubrica($value);
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
        $keys = AmmApertaTableMap::getFieldNames($keyType);

        if (array_key_exists($keys[0], $arr)) {
            $this->setIdAmmAperta($arr[$keys[0]]);
        }
        if (array_key_exists($keys[1], $arr)) {
            $this->setIdAlbo($arr[$keys[1]]);
        }
        if (array_key_exists($keys[2], $arr)) {
            $this->setRagionesociale($arr[$keys[2]]);
        }
        if (array_key_exists($keys[3], $arr)) {
            $this->setPiva($arr[$keys[3]]);
        }
        if (array_key_exists($keys[4], $arr)) {
            $this->setRespProc($arr[$keys[4]]);
        }
        if (array_key_exists($keys[5], $arr)) {
            $this->setNorma($arr[$keys[5]]);
        }
        if (array_key_exists($keys[6], $arr)) {
            $this->setModalita($arr[$keys[6]]);
        }
        if (array_key_exists($keys[7], $arr)) {
            $this->setImporto($arr[$keys[7]]);
        }
        if (array_key_exists($keys[8], $arr)) {
            $this->setPubblicato($arr[$keys[8]]);
        }
        if (array_key_exists($keys[9], $arr)) {
            $this->setDtPubblicazione($arr[$keys[9]]);
        }
        if (array_key_exists($keys[10], $arr)) {
            $this->setRespProcIdrubrica($arr[$keys[10]]);
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
     * @return $this|\AmmAperta The current object, for fluid interface
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
        $criteria = new Criteria(AmmApertaTableMap::DATABASE_NAME);

        if ($this->isColumnModified(AmmApertaTableMap::COL_ID_AMM_APERTA)) {
            $criteria->add(AmmApertaTableMap::COL_ID_AMM_APERTA, $this->id_amm_aperta);
        }
        if ($this->isColumnModified(AmmApertaTableMap::COL_ID_ALBO)) {
            $criteria->add(AmmApertaTableMap::COL_ID_ALBO, $this->id_albo);
        }
        if ($this->isColumnModified(AmmApertaTableMap::COL_RAGIONESOCIALE)) {
            $criteria->add(AmmApertaTableMap::COL_RAGIONESOCIALE, $this->ragionesociale);
        }
        if ($this->isColumnModified(AmmApertaTableMap::COL_PIVA)) {
            $criteria->add(AmmApertaTableMap::COL_PIVA, $this->piva);
        }
        if ($this->isColumnModified(AmmApertaTableMap::COL_RESP_PROC)) {
            $criteria->add(AmmApertaTableMap::COL_RESP_PROC, $this->resp_proc);
        }
        if ($this->isColumnModified(AmmApertaTableMap::COL_NORMA)) {
            $criteria->add(AmmApertaTableMap::COL_NORMA, $this->norma);
        }
        if ($this->isColumnModified(AmmApertaTableMap::COL_MODALITA)) {
            $criteria->add(AmmApertaTableMap::COL_MODALITA, $this->modalita);
        }
        if ($this->isColumnModified(AmmApertaTableMap::COL_IMPORTO)) {
            $criteria->add(AmmApertaTableMap::COL_IMPORTO, $this->importo);
        }
        if ($this->isColumnModified(AmmApertaTableMap::COL_PUBBLICATO)) {
            $criteria->add(AmmApertaTableMap::COL_PUBBLICATO, $this->pubblicato);
        }
        if ($this->isColumnModified(AmmApertaTableMap::COL_DT_PUBBLICAZIONE)) {
            $criteria->add(AmmApertaTableMap::COL_DT_PUBBLICAZIONE, $this->dt_pubblicazione);
        }
        if ($this->isColumnModified(AmmApertaTableMap::COL_RESP_PROC_IDRUBRICA)) {
            $criteria->add(AmmApertaTableMap::COL_RESP_PROC_IDRUBRICA, $this->resp_proc_idrubrica);
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
        $criteria = ChildAmmApertaQuery::create();
        $criteria->add(AmmApertaTableMap::COL_ID_AMM_APERTA, $this->id_amm_aperta);

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
        $validPk = null !== $this->getIdAmmAperta();

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
        return $this->getIdAmmAperta();
    }

    /**
     * Generic method to set the primary key (id_amm_aperta column).
     *
     * @param       int $key Primary key.
     * @return void
     */
    public function setPrimaryKey($key)
    {
        $this->setIdAmmAperta($key);
    }

    /**
     * Returns true if the primary key for this object is null.
     * @return boolean
     */
    public function isPrimaryKeyNull()
    {
        return null === $this->getIdAmmAperta();
    }

    /**
     * Sets contents of passed object to values from current object.
     *
     * If desired, this method can also make copies of all associated (fkey referrers)
     * objects.
     *
     * @param      object $copyObj An object of \AmmAperta (or compatible) type.
     * @param      boolean $deepCopy Whether to also copy all rows that refer (by fkey) to the current row.
     * @param      boolean $makeNew Whether to reset autoincrement PKs and make the object new.
     * @throws PropelException
     */
    public function copyInto($copyObj, $deepCopy = false, $makeNew = true)
    {
        $copyObj->setIdAlbo($this->getIdAlbo());
        $copyObj->setRagionesociale($this->getRagionesociale());
        $copyObj->setPiva($this->getPiva());
        $copyObj->setRespProc($this->getRespProc());
        $copyObj->setNorma($this->getNorma());
        $copyObj->setModalita($this->getModalita());
        $copyObj->setImporto($this->getImporto());
        $copyObj->setPubblicato($this->getPubblicato());
        $copyObj->setDtPubblicazione($this->getDtPubblicazione());
        $copyObj->setRespProcIdrubrica($this->getRespProcIdrubrica());
        if ($makeNew) {
            $copyObj->setNew(true);
            $copyObj->setIdAmmAperta(NULL); // this is a auto-increment column, so set to default value
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
     * @return \AmmAperta Clone of current object.
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
        $this->id_amm_aperta = null;
        $this->id_albo = null;
        $this->ragionesociale = null;
        $this->piva = null;
        $this->resp_proc = null;
        $this->norma = null;
        $this->modalita = null;
        $this->importo = null;
        $this->pubblicato = null;
        $this->dt_pubblicazione = null;
        $this->resp_proc_idrubrica = null;
        $this->alreadyInSave = false;
        $this->clearAllReferences();
        $this->applyDefaultValues();
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
        return (string) $this->exportTo(AmmApertaTableMap::DEFAULT_STRING_FORMAT);
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

<?php

namespace Map;

use \Albi;
use \AlbiQuery;
use Propel\Runtime\Propel;
use Propel\Runtime\ActiveQuery\Criteria;
use Propel\Runtime\ActiveQuery\InstancePoolTrait;
use Propel\Runtime\Connection\ConnectionInterface;
use Propel\Runtime\DataFetcher\DataFetcherInterface;
use Propel\Runtime\Exception\PropelException;
use Propel\Runtime\Map\RelationMap;
use Propel\Runtime\Map\TableMap;
use Propel\Runtime\Map\TableMapTrait;


/**
 * This class defines the structure of the 'albi' table.
 *
 *
 *
 * This map class is used by Propel to do runtime db structure discovery.
 * For example, the createSelectSql() method checks the type of a given column used in an
 * ORDER BY clause to know whether it needs to apply SQL to make the ORDER BY case-insensitive
 * (i.e. if it's a text column type).
 *
 */
class AlbiTableMap extends TableMap
{
    use InstancePoolTrait;
    use TableMapTrait;

    /**
     * The (dot-path) name of this class
     */
    const CLASS_NAME = '.Map.AlbiTableMap';

    /**
     * The default database name for this class
     */
    const DATABASE_NAME = 'default';

    /**
     * The table name for this class
     */
    const TABLE_NAME = 'albi';

    /**
     * The related Propel class for this table
     */
    const OM_CLASS = '\\Albi';

    /**
     * A class that can be returned by this tableMap
     */
    const CLASS_DEFAULT = 'Albi';

    /**
     * The total number of columns
     */
    const NUM_COLUMNS = 16;

    /**
     * The number of lazy-loaded columns
     */
    const NUM_LAZY_LOAD_COLUMNS = 0;

    /**
     * The number of columns to hydrate (NUM_COLUMNS - NUM_LAZY_LOAD_COLUMNS)
     */
    const NUM_HYDRATE_COLUMNS = 16;

    /**
     * the column name for the id_albo field
     */
    const COL_ID_ALBO = 'albi.id_albo';

    /**
     * the column name for the id_tipo field
     */
    const COL_ID_TIPO = 'albi.id_tipo';

    /**
     * the column name for the id_tipo_determina field
     */
    const COL_ID_TIPO_DETERMINA = 'albi.id_tipo_determina';

    /**
     * the column name for the id_tipo_trasp field
     */
    const COL_ID_TIPO_TRASP = 'albi.id_tipo_trasp';

    /**
     * the column name for the dt_pubblicaz_dal field
     */
    const COL_DT_PUBBLICAZ_DAL = 'albi.dt_pubblicaz_dal';

    /**
     * the column name for the dt_pubblicaz_al field
     */
    const COL_DT_PUBBLICAZ_AL = 'albi.dt_pubblicaz_al';

    /**
     * the column name for the dt_atto field
     */
    const COL_DT_ATTO = 'albi.dt_atto';

    /**
     * the column name for the nr_atto field
     */
    const COL_NR_ATTO = 'albi.nr_atto';

    /**
     * the column name for the oggetto field
     */
    const COL_OGGETTO = 'albi.oggetto';

    /**
     * the column name for the autorita_emanante field
     */
    const COL_AUTORITA_EMANANTE = 'albi.autorita_emanante';

    /**
     * the column name for the spesa_prevista field
     */
    const COL_SPESA_PREVISTA = 'albi.spesa_prevista';

    /**
     * the column name for the id_area field
     */
    const COL_ID_AREA = 'albi.id_area';

    /**
     * the column name for the serialize field
     */
    const COL_SERIALIZE = 'albi.serialize';

    /**
     * the column name for the da_validare field
     */
    const COL_DA_VALIDARE = 'albi.da_validare';

    /**
     * the column name for the note field
     */
    const COL_NOTE = 'albi.note';

    /**
     * the column name for the manuale field
     */
    const COL_MANUALE = 'albi.manuale';

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
        self::TYPE_PHPNAME       => array('IdAlbo', 'IdTipo', 'IdTipoDetermina', 'IdTipoTrasp', 'DtPubblicazDal', 'DtPubblicazAl', 'DtAtto', 'NrAtto', 'Oggetto', 'AutoritaEmanante', 'SpesaPrevista', 'IdArea', 'Serialize', 'DaValidare', 'Note', 'Manuale', ),
        self::TYPE_CAMELNAME     => array('idAlbo', 'idTipo', 'idTipoDetermina', 'idTipoTrasp', 'dtPubblicazDal', 'dtPubblicazAl', 'dtAtto', 'nrAtto', 'oggetto', 'autoritaEmanante', 'spesaPrevista', 'idArea', 'serialize', 'daValidare', 'note', 'manuale', ),
        self::TYPE_COLNAME       => array(AlbiTableMap::COL_ID_ALBO, AlbiTableMap::COL_ID_TIPO, AlbiTableMap::COL_ID_TIPO_DETERMINA, AlbiTableMap::COL_ID_TIPO_TRASP, AlbiTableMap::COL_DT_PUBBLICAZ_DAL, AlbiTableMap::COL_DT_PUBBLICAZ_AL, AlbiTableMap::COL_DT_ATTO, AlbiTableMap::COL_NR_ATTO, AlbiTableMap::COL_OGGETTO, AlbiTableMap::COL_AUTORITA_EMANANTE, AlbiTableMap::COL_SPESA_PREVISTA, AlbiTableMap::COL_ID_AREA, AlbiTableMap::COL_SERIALIZE, AlbiTableMap::COL_DA_VALIDARE, AlbiTableMap::COL_NOTE, AlbiTableMap::COL_MANUALE, ),
        self::TYPE_FIELDNAME     => array('id_albo', 'id_tipo', 'id_tipo_determina', 'id_tipo_trasp', 'dt_pubblicaz_dal', 'dt_pubblicaz_al', 'dt_atto', 'nr_atto', 'oggetto', 'autorita_emanante', 'spesa_prevista', 'id_area', 'serialize', 'da_validare', 'note', 'manuale', ),
        self::TYPE_NUM           => array(0, 1, 2, 3, 4, 5, 6, 7, 8, 9, 10, 11, 12, 13, 14, 15, )
    );

    /**
     * holds an array of keys for quick access to the fieldnames array
     *
     * first dimension keys are the type constants
     * e.g. self::$fieldKeys[self::TYPE_PHPNAME]['Id'] = 0
     */
    protected static $fieldKeys = array (
        self::TYPE_PHPNAME       => array('IdAlbo' => 0, 'IdTipo' => 1, 'IdTipoDetermina' => 2, 'IdTipoTrasp' => 3, 'DtPubblicazDal' => 4, 'DtPubblicazAl' => 5, 'DtAtto' => 6, 'NrAtto' => 7, 'Oggetto' => 8, 'AutoritaEmanante' => 9, 'SpesaPrevista' => 10, 'IdArea' => 11, 'Serialize' => 12, 'DaValidare' => 13, 'Note' => 14, 'Manuale' => 15, ),
        self::TYPE_CAMELNAME     => array('idAlbo' => 0, 'idTipo' => 1, 'idTipoDetermina' => 2, 'idTipoTrasp' => 3, 'dtPubblicazDal' => 4, 'dtPubblicazAl' => 5, 'dtAtto' => 6, 'nrAtto' => 7, 'oggetto' => 8, 'autoritaEmanante' => 9, 'spesaPrevista' => 10, 'idArea' => 11, 'serialize' => 12, 'daValidare' => 13, 'note' => 14, 'manuale' => 15, ),
        self::TYPE_COLNAME       => array(AlbiTableMap::COL_ID_ALBO => 0, AlbiTableMap::COL_ID_TIPO => 1, AlbiTableMap::COL_ID_TIPO_DETERMINA => 2, AlbiTableMap::COL_ID_TIPO_TRASP => 3, AlbiTableMap::COL_DT_PUBBLICAZ_DAL => 4, AlbiTableMap::COL_DT_PUBBLICAZ_AL => 5, AlbiTableMap::COL_DT_ATTO => 6, AlbiTableMap::COL_NR_ATTO => 7, AlbiTableMap::COL_OGGETTO => 8, AlbiTableMap::COL_AUTORITA_EMANANTE => 9, AlbiTableMap::COL_SPESA_PREVISTA => 10, AlbiTableMap::COL_ID_AREA => 11, AlbiTableMap::COL_SERIALIZE => 12, AlbiTableMap::COL_DA_VALIDARE => 13, AlbiTableMap::COL_NOTE => 14, AlbiTableMap::COL_MANUALE => 15, ),
        self::TYPE_FIELDNAME     => array('id_albo' => 0, 'id_tipo' => 1, 'id_tipo_determina' => 2, 'id_tipo_trasp' => 3, 'dt_pubblicaz_dal' => 4, 'dt_pubblicaz_al' => 5, 'dt_atto' => 6, 'nr_atto' => 7, 'oggetto' => 8, 'autorita_emanante' => 9, 'spesa_prevista' => 10, 'id_area' => 11, 'serialize' => 12, 'da_validare' => 13, 'note' => 14, 'manuale' => 15, ),
        self::TYPE_NUM           => array(0, 1, 2, 3, 4, 5, 6, 7, 8, 9, 10, 11, 12, 13, 14, 15, )
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
        $this->setName('albi');
        $this->setPhpName('Albi');
        $this->setIdentifierQuoting(false);
        $this->setClassName('\\Albi');
        $this->setPackage('');
        $this->setUseIdGenerator(true);
        // columns
        $this->addPrimaryKey('id_albo', 'IdAlbo', 'INTEGER', true, 10, null);
        $this->addColumn('id_tipo', 'IdTipo', 'INTEGER', true, 2, null);
        $this->addColumn('id_tipo_determina', 'IdTipoDetermina', 'INTEGER', false, 2, null);
        $this->addColumn('id_tipo_trasp', 'IdTipoTrasp', 'INTEGER', false, 2, null);
        $this->addColumn('dt_pubblicaz_dal', 'DtPubblicazDal', 'DATE', true, null, null);
        $this->addColumn('dt_pubblicaz_al', 'DtPubblicazAl', 'DATE', true, null, null);
        $this->addColumn('dt_atto', 'DtAtto', 'DATE', true, null, null);
        $this->addColumn('nr_atto', 'NrAtto', 'INTEGER', false, 5, null);
        $this->addColumn('oggetto', 'Oggetto', 'LONGVARCHAR', false, null, null);
        $this->addColumn('autorita_emanante', 'AutoritaEmanante', 'VARCHAR', true, 254, null);
        $this->addColumn('spesa_prevista', 'SpesaPrevista', 'DECIMAL', false, 9, 0);
        $this->addColumn('id_area', 'IdArea', 'INTEGER', false, 2, null);
        $this->addColumn('serialize', 'Serialize', 'LONGVARCHAR', false, null, null);
        $this->addColumn('da_validare', 'DaValidare', 'VARCHAR', false, 1, null);
        $this->addColumn('note', 'Note', 'VARCHAR', false, 250, null);
        $this->addColumn('manuale', 'Manuale', 'VARCHAR', false, 1, 'n');
    } // initialize()

    /**
     * Build the RelationMap objects for this table relationships
     */
    public function buildRelations()
    {
    } // buildRelations()

    /**
     * Retrieves a string version of the primary key from the DB resultset row that can be used to uniquely identify a row in this table.
     *
     * For tables with a single-column primary key, that simple pkey value will be returned.  For tables with
     * a multi-column primary key, a serialize()d version of the primary key will be returned.
     *
     * @param array  $row       resultset row.
     * @param int    $offset    The 0-based offset for reading from the resultset row.
     * @param string $indexType One of the class type constants TableMap::TYPE_PHPNAME, TableMap::TYPE_CAMELNAME
     *                           TableMap::TYPE_COLNAME, TableMap::TYPE_FIELDNAME, TableMap::TYPE_NUM
     *
     * @return string The primary key hash of the row
     */
    public static function getPrimaryKeyHashFromRow($row, $offset = 0, $indexType = TableMap::TYPE_NUM)
    {
        // If the PK cannot be derived from the row, return NULL.
        if ($row[TableMap::TYPE_NUM == $indexType ? 0 + $offset : static::translateFieldName('IdAlbo', TableMap::TYPE_PHPNAME, $indexType)] === null) {
            return null;
        }

        return null === $row[TableMap::TYPE_NUM == $indexType ? 0 + $offset : static::translateFieldName('IdAlbo', TableMap::TYPE_PHPNAME, $indexType)] || is_scalar($row[TableMap::TYPE_NUM == $indexType ? 0 + $offset : static::translateFieldName('IdAlbo', TableMap::TYPE_PHPNAME, $indexType)]) || is_callable([$row[TableMap::TYPE_NUM == $indexType ? 0 + $offset : static::translateFieldName('IdAlbo', TableMap::TYPE_PHPNAME, $indexType)], '__toString']) ? (string) $row[TableMap::TYPE_NUM == $indexType ? 0 + $offset : static::translateFieldName('IdAlbo', TableMap::TYPE_PHPNAME, $indexType)] : $row[TableMap::TYPE_NUM == $indexType ? 0 + $offset : static::translateFieldName('IdAlbo', TableMap::TYPE_PHPNAME, $indexType)];
    }

    /**
     * Retrieves the primary key from the DB resultset row
     * For tables with a single-column primary key, that simple pkey value will be returned.  For tables with
     * a multi-column primary key, an array of the primary key columns will be returned.
     *
     * @param array  $row       resultset row.
     * @param int    $offset    The 0-based offset for reading from the resultset row.
     * @param string $indexType One of the class type constants TableMap::TYPE_PHPNAME, TableMap::TYPE_CAMELNAME
     *                           TableMap::TYPE_COLNAME, TableMap::TYPE_FIELDNAME, TableMap::TYPE_NUM
     *
     * @return mixed The primary key of the row
     */
    public static function getPrimaryKeyFromRow($row, $offset = 0, $indexType = TableMap::TYPE_NUM)
    {
        return (int) $row[
            $indexType == TableMap::TYPE_NUM
                ? 0 + $offset
                : self::translateFieldName('IdAlbo', TableMap::TYPE_PHPNAME, $indexType)
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
        return $withPrefix ? AlbiTableMap::CLASS_DEFAULT : AlbiTableMap::OM_CLASS;
    }

    /**
     * Populates an object of the default type or an object that inherit from the default.
     *
     * @param array  $row       row returned by DataFetcher->fetch().
     * @param int    $offset    The 0-based offset for reading from the resultset row.
     * @param string $indexType The index type of $row. Mostly DataFetcher->getIndexType().
                                 One of the class type constants TableMap::TYPE_PHPNAME, TableMap::TYPE_CAMELNAME
     *                           TableMap::TYPE_COLNAME, TableMap::TYPE_FIELDNAME, TableMap::TYPE_NUM.
     *
     * @throws PropelException Any exceptions caught during processing will be
     *                         rethrown wrapped into a PropelException.
     * @return array           (Albi object, last column rank)
     */
    public static function populateObject($row, $offset = 0, $indexType = TableMap::TYPE_NUM)
    {
        $key = AlbiTableMap::getPrimaryKeyHashFromRow($row, $offset, $indexType);
        if (null !== ($obj = AlbiTableMap::getInstanceFromPool($key))) {
            // We no longer rehydrate the object, since this can cause data loss.
            // See http://www.propelorm.org/ticket/509
            // $obj->hydrate($row, $offset, true); // rehydrate
            $col = $offset + AlbiTableMap::NUM_HYDRATE_COLUMNS;
        } else {
            $cls = AlbiTableMap::OM_CLASS;
            /** @var Albi $obj */
            $obj = new $cls();
            $col = $obj->hydrate($row, $offset, false, $indexType);
            AlbiTableMap::addInstanceToPool($obj, $key);
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
     *                         rethrown wrapped into a PropelException.
     */
    public static function populateObjects(DataFetcherInterface $dataFetcher)
    {
        $results = array();

        // set the class once to avoid overhead in the loop
        $cls = static::getOMClass(false);
        // populate the object(s)
        while ($row = $dataFetcher->fetch()) {
            $key = AlbiTableMap::getPrimaryKeyHashFromRow($row, 0, $dataFetcher->getIndexType());
            if (null !== ($obj = AlbiTableMap::getInstanceFromPool($key))) {
                // We no longer rehydrate the object, since this can cause data loss.
                // See http://www.propelorm.org/ticket/509
                // $obj->hydrate($row, 0, true); // rehydrate
                $results[] = $obj;
            } else {
                /** @var Albi $obj */
                $obj = new $cls();
                $obj->hydrate($row);
                $results[] = $obj;
                AlbiTableMap::addInstanceToPool($obj, $key);
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
     *                         rethrown wrapped into a PropelException.
     */
    public static function addSelectColumns(Criteria $criteria, $alias = null)
    {
        if (null === $alias) {
            $criteria->addSelectColumn(AlbiTableMap::COL_ID_ALBO);
            $criteria->addSelectColumn(AlbiTableMap::COL_ID_TIPO);
            $criteria->addSelectColumn(AlbiTableMap::COL_ID_TIPO_DETERMINA);
            $criteria->addSelectColumn(AlbiTableMap::COL_ID_TIPO_TRASP);
            $criteria->addSelectColumn(AlbiTableMap::COL_DT_PUBBLICAZ_DAL);
            $criteria->addSelectColumn(AlbiTableMap::COL_DT_PUBBLICAZ_AL);
            $criteria->addSelectColumn(AlbiTableMap::COL_DT_ATTO);
            $criteria->addSelectColumn(AlbiTableMap::COL_NR_ATTO);
            $criteria->addSelectColumn(AlbiTableMap::COL_OGGETTO);
            $criteria->addSelectColumn(AlbiTableMap::COL_AUTORITA_EMANANTE);
            $criteria->addSelectColumn(AlbiTableMap::COL_SPESA_PREVISTA);
            $criteria->addSelectColumn(AlbiTableMap::COL_ID_AREA);
            $criteria->addSelectColumn(AlbiTableMap::COL_SERIALIZE);
            $criteria->addSelectColumn(AlbiTableMap::COL_DA_VALIDARE);
            $criteria->addSelectColumn(AlbiTableMap::COL_NOTE);
            $criteria->addSelectColumn(AlbiTableMap::COL_MANUALE);
        } else {
            $criteria->addSelectColumn($alias . '.id_albo');
            $criteria->addSelectColumn($alias . '.id_tipo');
            $criteria->addSelectColumn($alias . '.id_tipo_determina');
            $criteria->addSelectColumn($alias . '.id_tipo_trasp');
            $criteria->addSelectColumn($alias . '.dt_pubblicaz_dal');
            $criteria->addSelectColumn($alias . '.dt_pubblicaz_al');
            $criteria->addSelectColumn($alias . '.dt_atto');
            $criteria->addSelectColumn($alias . '.nr_atto');
            $criteria->addSelectColumn($alias . '.oggetto');
            $criteria->addSelectColumn($alias . '.autorita_emanante');
            $criteria->addSelectColumn($alias . '.spesa_prevista');
            $criteria->addSelectColumn($alias . '.id_area');
            $criteria->addSelectColumn($alias . '.serialize');
            $criteria->addSelectColumn($alias . '.da_validare');
            $criteria->addSelectColumn($alias . '.note');
            $criteria->addSelectColumn($alias . '.manuale');
        }
    }

    /**
     * Returns the TableMap related to this object.
     * This method is not needed for general use but a specific application could have a need.
     * @return TableMap
     * @throws PropelException Any exceptions caught during processing will be
     *                         rethrown wrapped into a PropelException.
     */
    public static function getTableMap()
    {
        return Propel::getServiceContainer()->getDatabaseMap(AlbiTableMap::DATABASE_NAME)->getTable(AlbiTableMap::TABLE_NAME);
    }

    /**
     * Add a TableMap instance to the database for this tableMap class.
     */
    public static function buildTableMap()
    {
        $dbMap = Propel::getServiceContainer()->getDatabaseMap(AlbiTableMap::DATABASE_NAME);
        if (!$dbMap->hasTable(AlbiTableMap::TABLE_NAME)) {
            $dbMap->addTableObject(new AlbiTableMap());
        }
    }

    /**
     * Performs a DELETE on the database, given a Albi or Criteria object OR a primary key value.
     *
     * @param mixed               $values Criteria or Albi object or primary key or array of primary keys
     *              which is used to create the DELETE statement
     * @param  ConnectionInterface $con the connection to use
     * @return int             The number of affected rows (if supported by underlying database driver).  This includes CASCADE-related rows
     *                         if supported by native driver or if emulated using Propel.
     * @throws PropelException Any exceptions caught during processing will be
     *                         rethrown wrapped into a PropelException.
     */
     public static function doDelete($values, ConnectionInterface $con = null)
     {
        if (null === $con) {
            $con = Propel::getServiceContainer()->getWriteConnection(AlbiTableMap::DATABASE_NAME);
        }

        if ($values instanceof Criteria) {
            // rename for clarity
            $criteria = $values;
        } elseif ($values instanceof \Albi) { // it's a model object
            // create criteria based on pk values
            $criteria = $values->buildPkeyCriteria();
        } else { // it's a primary key, or an array of pks
            $criteria = new Criteria(AlbiTableMap::DATABASE_NAME);
            $criteria->add(AlbiTableMap::COL_ID_ALBO, (array) $values, Criteria::IN);
        }

        $query = AlbiQuery::create()->mergeWith($criteria);

        if ($values instanceof Criteria) {
            AlbiTableMap::clearInstancePool();
        } elseif (!is_object($values)) { // it's a primary key, or an array of pks
            foreach ((array) $values as $singleval) {
                AlbiTableMap::removeInstanceFromPool($singleval);
            }
        }

        return $query->delete($con);
    }

    /**
     * Deletes all rows from the albi table.
     *
     * @param ConnectionInterface $con the connection to use
     * @return int The number of affected rows (if supported by underlying database driver).
     */
    public static function doDeleteAll(ConnectionInterface $con = null)
    {
        return AlbiQuery::create()->doDeleteAll($con);
    }

    /**
     * Performs an INSERT on the database, given a Albi or Criteria object.
     *
     * @param mixed               $criteria Criteria or Albi object containing data that is used to create the INSERT statement.
     * @param ConnectionInterface $con the ConnectionInterface connection to use
     * @return mixed           The new primary key.
     * @throws PropelException Any exceptions caught during processing will be
     *                         rethrown wrapped into a PropelException.
     */
    public static function doInsert($criteria, ConnectionInterface $con = null)
    {
        if (null === $con) {
            $con = Propel::getServiceContainer()->getWriteConnection(AlbiTableMap::DATABASE_NAME);
        }

        if ($criteria instanceof Criteria) {
            $criteria = clone $criteria; // rename for clarity
        } else {
            $criteria = $criteria->buildCriteria(); // build Criteria from Albi object
        }

        if ($criteria->containsKey(AlbiTableMap::COL_ID_ALBO) && $criteria->keyContainsValue(AlbiTableMap::COL_ID_ALBO) ) {
            throw new PropelException('Cannot insert a value for auto-increment primary key ('.AlbiTableMap::COL_ID_ALBO.')');
        }


        // Set the correct dbName
        $query = AlbiQuery::create()->mergeWith($criteria);

        // use transaction because $criteria could contain info
        // for more than one table (I guess, conceivably)
        return $con->transaction(function () use ($con, $query) {
            return $query->doInsert($con);
        });
    }

} // AlbiTableMap
// This is the static code needed to register the TableMap for this table with the main Propel class.
//
AlbiTableMap::buildTableMap();

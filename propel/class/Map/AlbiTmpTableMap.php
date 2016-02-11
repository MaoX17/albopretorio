<?php

namespace Map;

use \AlbiTmp;
use \AlbiTmpQuery;
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
 * This class defines the structure of the 'albi_tmp' table.
 *
 *
 *
 * This map class is used by Propel to do runtime db structure discovery.
 * For example, the createSelectSql() method checks the type of a given column used in an
 * ORDER BY clause to know whether it needs to apply SQL to make the ORDER BY case-insensitive
 * (i.e. if it's a text column type).
 *
 */
class AlbiTmpTableMap extends TableMap
{
    use InstancePoolTrait;
    use TableMapTrait;

    /**
     * The (dot-path) name of this class
     */
    const CLASS_NAME = '.Map.AlbiTmpTableMap';

    /**
     * The default database name for this class
     */
    const DATABASE_NAME = 'default';

    /**
     * The table name for this class
     */
    const TABLE_NAME = 'albi_tmp';

    /**
     * The related Propel class for this table
     */
    const OM_CLASS = '\\AlbiTmp';

    /**
     * A class that can be returned by this tableMap
     */
    const CLASS_DEFAULT = 'AlbiTmp';

    /**
     * The total number of columns
     */
    const NUM_COLUMNS = 10;

    /**
     * The number of lazy-loaded columns
     */
    const NUM_LAZY_LOAD_COLUMNS = 0;

    /**
     * The number of columns to hydrate (NUM_COLUMNS - NUM_LAZY_LOAD_COLUMNS)
     */
    const NUM_HYDRATE_COLUMNS = 10;

    /**
     * the column name for the id_albo field
     */
    const COL_ID_ALBO = 'albi_tmp.id_albo';

    /**
     * the column name for the id_tipo field
     */
    const COL_ID_TIPO = 'albi_tmp.id_tipo';

    /**
     * the column name for the dt_pubblicaz_dal field
     */
    const COL_DT_PUBBLICAZ_DAL = 'albi_tmp.dt_pubblicaz_dal';

    /**
     * the column name for the dt_pubblicaz_al field
     */
    const COL_DT_PUBBLICAZ_AL = 'albi_tmp.dt_pubblicaz_al';

    /**
     * the column name for the dt_atto field
     */
    const COL_DT_ATTO = 'albi_tmp.dt_atto';

    /**
     * the column name for the nr_atto field
     */
    const COL_NR_ATTO = 'albi_tmp.nr_atto';

    /**
     * the column name for the oggetto field
     */
    const COL_OGGETTO = 'albi_tmp.oggetto';

    /**
     * the column name for the autorita_emanante field
     */
    const COL_AUTORITA_EMANANTE = 'albi_tmp.autorita_emanante';

    /**
     * the column name for the id_area field
     */
    const COL_ID_AREA = 'albi_tmp.id_area';

    /**
     * the column name for the file field
     */
    const COL_FILE = 'albi_tmp.file';

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
        self::TYPE_PHPNAME       => array('IdAlbo', 'IdTipo', 'DtPubblicazDal', 'DtPubblicazAl', 'DtAtto', 'NrAtto', 'Oggetto', 'AutoritaEmanante', 'IdArea', 'File', ),
        self::TYPE_CAMELNAME     => array('idAlbo', 'idTipo', 'dtPubblicazDal', 'dtPubblicazAl', 'dtAtto', 'nrAtto', 'oggetto', 'autoritaEmanante', 'idArea', 'file', ),
        self::TYPE_COLNAME       => array(AlbiTmpTableMap::COL_ID_ALBO, AlbiTmpTableMap::COL_ID_TIPO, AlbiTmpTableMap::COL_DT_PUBBLICAZ_DAL, AlbiTmpTableMap::COL_DT_PUBBLICAZ_AL, AlbiTmpTableMap::COL_DT_ATTO, AlbiTmpTableMap::COL_NR_ATTO, AlbiTmpTableMap::COL_OGGETTO, AlbiTmpTableMap::COL_AUTORITA_EMANANTE, AlbiTmpTableMap::COL_ID_AREA, AlbiTmpTableMap::COL_FILE, ),
        self::TYPE_FIELDNAME     => array('id_albo', 'id_tipo', 'dt_pubblicaz_dal', 'dt_pubblicaz_al', 'dt_atto', 'nr_atto', 'oggetto', 'autorita_emanante', 'id_area', 'file', ),
        self::TYPE_NUM           => array(0, 1, 2, 3, 4, 5, 6, 7, 8, 9, )
    );

    /**
     * holds an array of keys for quick access to the fieldnames array
     *
     * first dimension keys are the type constants
     * e.g. self::$fieldKeys[self::TYPE_PHPNAME]['Id'] = 0
     */
    protected static $fieldKeys = array (
        self::TYPE_PHPNAME       => array('IdAlbo' => 0, 'IdTipo' => 1, 'DtPubblicazDal' => 2, 'DtPubblicazAl' => 3, 'DtAtto' => 4, 'NrAtto' => 5, 'Oggetto' => 6, 'AutoritaEmanante' => 7, 'IdArea' => 8, 'File' => 9, ),
        self::TYPE_CAMELNAME     => array('idAlbo' => 0, 'idTipo' => 1, 'dtPubblicazDal' => 2, 'dtPubblicazAl' => 3, 'dtAtto' => 4, 'nrAtto' => 5, 'oggetto' => 6, 'autoritaEmanante' => 7, 'idArea' => 8, 'file' => 9, ),
        self::TYPE_COLNAME       => array(AlbiTmpTableMap::COL_ID_ALBO => 0, AlbiTmpTableMap::COL_ID_TIPO => 1, AlbiTmpTableMap::COL_DT_PUBBLICAZ_DAL => 2, AlbiTmpTableMap::COL_DT_PUBBLICAZ_AL => 3, AlbiTmpTableMap::COL_DT_ATTO => 4, AlbiTmpTableMap::COL_NR_ATTO => 5, AlbiTmpTableMap::COL_OGGETTO => 6, AlbiTmpTableMap::COL_AUTORITA_EMANANTE => 7, AlbiTmpTableMap::COL_ID_AREA => 8, AlbiTmpTableMap::COL_FILE => 9, ),
        self::TYPE_FIELDNAME     => array('id_albo' => 0, 'id_tipo' => 1, 'dt_pubblicaz_dal' => 2, 'dt_pubblicaz_al' => 3, 'dt_atto' => 4, 'nr_atto' => 5, 'oggetto' => 6, 'autorita_emanante' => 7, 'id_area' => 8, 'file' => 9, ),
        self::TYPE_NUM           => array(0, 1, 2, 3, 4, 5, 6, 7, 8, 9, )
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
        $this->setName('albi_tmp');
        $this->setPhpName('AlbiTmp');
        $this->setIdentifierQuoting(false);
        $this->setClassName('\\AlbiTmp');
        $this->setPackage('');
        $this->setUseIdGenerator(true);
        // columns
        $this->addPrimaryKey('id_albo', 'IdAlbo', 'INTEGER', true, 10, null);
        $this->addColumn('id_tipo', 'IdTipo', 'INTEGER', true, 2, null);
        $this->addColumn('dt_pubblicaz_dal', 'DtPubblicazDal', 'DATE', true, null, null);
        $this->addColumn('dt_pubblicaz_al', 'DtPubblicazAl', 'DATE', true, null, null);
        $this->addColumn('dt_atto', 'DtAtto', 'DATE', true, null, null);
        $this->addColumn('nr_atto', 'NrAtto', 'INTEGER', true, 5, null);
        $this->addColumn('oggetto', 'Oggetto', 'LONGVARCHAR', true, null, null);
        $this->addColumn('autorita_emanante', 'AutoritaEmanante', 'VARCHAR', true, 254, null);
        $this->addColumn('id_area', 'IdArea', 'INTEGER', true, 2, null);
        $this->addColumn('file', 'File', 'VARCHAR', true, 254, null);
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
        return $withPrefix ? AlbiTmpTableMap::CLASS_DEFAULT : AlbiTmpTableMap::OM_CLASS;
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
     * @return array           (AlbiTmp object, last column rank)
     */
    public static function populateObject($row, $offset = 0, $indexType = TableMap::TYPE_NUM)
    {
        $key = AlbiTmpTableMap::getPrimaryKeyHashFromRow($row, $offset, $indexType);
        if (null !== ($obj = AlbiTmpTableMap::getInstanceFromPool($key))) {
            // We no longer rehydrate the object, since this can cause data loss.
            // See http://www.propelorm.org/ticket/509
            // $obj->hydrate($row, $offset, true); // rehydrate
            $col = $offset + AlbiTmpTableMap::NUM_HYDRATE_COLUMNS;
        } else {
            $cls = AlbiTmpTableMap::OM_CLASS;
            /** @var AlbiTmp $obj */
            $obj = new $cls();
            $col = $obj->hydrate($row, $offset, false, $indexType);
            AlbiTmpTableMap::addInstanceToPool($obj, $key);
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
            $key = AlbiTmpTableMap::getPrimaryKeyHashFromRow($row, 0, $dataFetcher->getIndexType());
            if (null !== ($obj = AlbiTmpTableMap::getInstanceFromPool($key))) {
                // We no longer rehydrate the object, since this can cause data loss.
                // See http://www.propelorm.org/ticket/509
                // $obj->hydrate($row, 0, true); // rehydrate
                $results[] = $obj;
            } else {
                /** @var AlbiTmp $obj */
                $obj = new $cls();
                $obj->hydrate($row);
                $results[] = $obj;
                AlbiTmpTableMap::addInstanceToPool($obj, $key);
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
            $criteria->addSelectColumn(AlbiTmpTableMap::COL_ID_ALBO);
            $criteria->addSelectColumn(AlbiTmpTableMap::COL_ID_TIPO);
            $criteria->addSelectColumn(AlbiTmpTableMap::COL_DT_PUBBLICAZ_DAL);
            $criteria->addSelectColumn(AlbiTmpTableMap::COL_DT_PUBBLICAZ_AL);
            $criteria->addSelectColumn(AlbiTmpTableMap::COL_DT_ATTO);
            $criteria->addSelectColumn(AlbiTmpTableMap::COL_NR_ATTO);
            $criteria->addSelectColumn(AlbiTmpTableMap::COL_OGGETTO);
            $criteria->addSelectColumn(AlbiTmpTableMap::COL_AUTORITA_EMANANTE);
            $criteria->addSelectColumn(AlbiTmpTableMap::COL_ID_AREA);
            $criteria->addSelectColumn(AlbiTmpTableMap::COL_FILE);
        } else {
            $criteria->addSelectColumn($alias . '.id_albo');
            $criteria->addSelectColumn($alias . '.id_tipo');
            $criteria->addSelectColumn($alias . '.dt_pubblicaz_dal');
            $criteria->addSelectColumn($alias . '.dt_pubblicaz_al');
            $criteria->addSelectColumn($alias . '.dt_atto');
            $criteria->addSelectColumn($alias . '.nr_atto');
            $criteria->addSelectColumn($alias . '.oggetto');
            $criteria->addSelectColumn($alias . '.autorita_emanante');
            $criteria->addSelectColumn($alias . '.id_area');
            $criteria->addSelectColumn($alias . '.file');
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
        return Propel::getServiceContainer()->getDatabaseMap(AlbiTmpTableMap::DATABASE_NAME)->getTable(AlbiTmpTableMap::TABLE_NAME);
    }

    /**
     * Add a TableMap instance to the database for this tableMap class.
     */
    public static function buildTableMap()
    {
        $dbMap = Propel::getServiceContainer()->getDatabaseMap(AlbiTmpTableMap::DATABASE_NAME);
        if (!$dbMap->hasTable(AlbiTmpTableMap::TABLE_NAME)) {
            $dbMap->addTableObject(new AlbiTmpTableMap());
        }
    }

    /**
     * Performs a DELETE on the database, given a AlbiTmp or Criteria object OR a primary key value.
     *
     * @param mixed               $values Criteria or AlbiTmp object or primary key or array of primary keys
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
            $con = Propel::getServiceContainer()->getWriteConnection(AlbiTmpTableMap::DATABASE_NAME);
        }

        if ($values instanceof Criteria) {
            // rename for clarity
            $criteria = $values;
        } elseif ($values instanceof \AlbiTmp) { // it's a model object
            // create criteria based on pk values
            $criteria = $values->buildPkeyCriteria();
        } else { // it's a primary key, or an array of pks
            $criteria = new Criteria(AlbiTmpTableMap::DATABASE_NAME);
            $criteria->add(AlbiTmpTableMap::COL_ID_ALBO, (array) $values, Criteria::IN);
        }

        $query = AlbiTmpQuery::create()->mergeWith($criteria);

        if ($values instanceof Criteria) {
            AlbiTmpTableMap::clearInstancePool();
        } elseif (!is_object($values)) { // it's a primary key, or an array of pks
            foreach ((array) $values as $singleval) {
                AlbiTmpTableMap::removeInstanceFromPool($singleval);
            }
        }

        return $query->delete($con);
    }

    /**
     * Deletes all rows from the albi_tmp table.
     *
     * @param ConnectionInterface $con the connection to use
     * @return int The number of affected rows (if supported by underlying database driver).
     */
    public static function doDeleteAll(ConnectionInterface $con = null)
    {
        return AlbiTmpQuery::create()->doDeleteAll($con);
    }

    /**
     * Performs an INSERT on the database, given a AlbiTmp or Criteria object.
     *
     * @param mixed               $criteria Criteria or AlbiTmp object containing data that is used to create the INSERT statement.
     * @param ConnectionInterface $con the ConnectionInterface connection to use
     * @return mixed           The new primary key.
     * @throws PropelException Any exceptions caught during processing will be
     *                         rethrown wrapped into a PropelException.
     */
    public static function doInsert($criteria, ConnectionInterface $con = null)
    {
        if (null === $con) {
            $con = Propel::getServiceContainer()->getWriteConnection(AlbiTmpTableMap::DATABASE_NAME);
        }

        if ($criteria instanceof Criteria) {
            $criteria = clone $criteria; // rename for clarity
        } else {
            $criteria = $criteria->buildCriteria(); // build Criteria from AlbiTmp object
        }

        if ($criteria->containsKey(AlbiTmpTableMap::COL_ID_ALBO) && $criteria->keyContainsValue(AlbiTmpTableMap::COL_ID_ALBO) ) {
            throw new PropelException('Cannot insert a value for auto-increment primary key ('.AlbiTmpTableMap::COL_ID_ALBO.')');
        }


        // Set the correct dbName
        $query = AlbiTmpQuery::create()->mergeWith($criteria);

        // use transaction because $criteria could contain info
        // for more than one table (I guess, conceivably)
        return $con->transaction(function () use ($con, $query) {
            return $query->doInsert($con);
        });
    }

} // AlbiTmpTableMap
// This is the static code needed to register the TableMap for this table with the main Propel class.
//
AlbiTmpTableMap::buildTableMap();

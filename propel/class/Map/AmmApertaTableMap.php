<?php

namespace Map;

use \AmmAperta;
use \AmmApertaQuery;
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
 * This class defines the structure of the 'amm_aperta' table.
 *
 *
 *
 * This map class is used by Propel to do runtime db structure discovery.
 * For example, the createSelectSql() method checks the type of a given column used in an
 * ORDER BY clause to know whether it needs to apply SQL to make the ORDER BY case-insensitive
 * (i.e. if it's a text column type).
 *
 */
class AmmApertaTableMap extends TableMap
{
    use InstancePoolTrait;
    use TableMapTrait;

    /**
     * The (dot-path) name of this class
     */
    const CLASS_NAME = '.Map.AmmApertaTableMap';

    /**
     * The default database name for this class
     */
    const DATABASE_NAME = 'default';

    /**
     * The table name for this class
     */
    const TABLE_NAME = 'amm_aperta';

    /**
     * The related Propel class for this table
     */
    const OM_CLASS = '\\AmmAperta';

    /**
     * A class that can be returned by this tableMap
     */
    const CLASS_DEFAULT = 'AmmAperta';

    /**
     * The total number of columns
     */
    const NUM_COLUMNS = 11;

    /**
     * The number of lazy-loaded columns
     */
    const NUM_LAZY_LOAD_COLUMNS = 0;

    /**
     * The number of columns to hydrate (NUM_COLUMNS - NUM_LAZY_LOAD_COLUMNS)
     */
    const NUM_HYDRATE_COLUMNS = 11;

    /**
     * the column name for the id_amm_aperta field
     */
    const COL_ID_AMM_APERTA = 'amm_aperta.id_amm_aperta';

    /**
     * the column name for the id_albo field
     */
    const COL_ID_ALBO = 'amm_aperta.id_albo';

    /**
     * the column name for the ragionesociale field
     */
    const COL_RAGIONESOCIALE = 'amm_aperta.ragionesociale';

    /**
     * the column name for the piva field
     */
    const COL_PIVA = 'amm_aperta.piva';

    /**
     * the column name for the resp_proc field
     */
    const COL_RESP_PROC = 'amm_aperta.resp_proc';

    /**
     * the column name for the norma field
     */
    const COL_NORMA = 'amm_aperta.norma';

    /**
     * the column name for the modalita field
     */
    const COL_MODALITA = 'amm_aperta.modalita';

    /**
     * the column name for the importo field
     */
    const COL_IMPORTO = 'amm_aperta.importo';

    /**
     * the column name for the pubblicato field
     */
    const COL_PUBBLICATO = 'amm_aperta.pubblicato';

    /**
     * the column name for the dt_pubblicazione field
     */
    const COL_DT_PUBBLICAZIONE = 'amm_aperta.dt_pubblicazione';

    /**
     * the column name for the resp_proc_idrubrica field
     */
    const COL_RESP_PROC_IDRUBRICA = 'amm_aperta.resp_proc_idrubrica';

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
        self::TYPE_PHPNAME       => array('IdAmmAperta', 'IdAlbo', 'Ragionesociale', 'Piva', 'RespProc', 'Norma', 'Modalita', 'Importo', 'Pubblicato', 'DtPubblicazione', 'RespProcIdrubrica', ),
        self::TYPE_CAMELNAME     => array('idAmmAperta', 'idAlbo', 'ragionesociale', 'piva', 'respProc', 'norma', 'modalita', 'importo', 'pubblicato', 'dtPubblicazione', 'respProcIdrubrica', ),
        self::TYPE_COLNAME       => array(AmmApertaTableMap::COL_ID_AMM_APERTA, AmmApertaTableMap::COL_ID_ALBO, AmmApertaTableMap::COL_RAGIONESOCIALE, AmmApertaTableMap::COL_PIVA, AmmApertaTableMap::COL_RESP_PROC, AmmApertaTableMap::COL_NORMA, AmmApertaTableMap::COL_MODALITA, AmmApertaTableMap::COL_IMPORTO, AmmApertaTableMap::COL_PUBBLICATO, AmmApertaTableMap::COL_DT_PUBBLICAZIONE, AmmApertaTableMap::COL_RESP_PROC_IDRUBRICA, ),
        self::TYPE_FIELDNAME     => array('id_amm_aperta', 'id_albo', 'ragionesociale', 'piva', 'resp_proc', 'norma', 'modalita', 'importo', 'pubblicato', 'dt_pubblicazione', 'resp_proc_idrubrica', ),
        self::TYPE_NUM           => array(0, 1, 2, 3, 4, 5, 6, 7, 8, 9, 10, )
    );

    /**
     * holds an array of keys for quick access to the fieldnames array
     *
     * first dimension keys are the type constants
     * e.g. self::$fieldKeys[self::TYPE_PHPNAME]['Id'] = 0
     */
    protected static $fieldKeys = array (
        self::TYPE_PHPNAME       => array('IdAmmAperta' => 0, 'IdAlbo' => 1, 'Ragionesociale' => 2, 'Piva' => 3, 'RespProc' => 4, 'Norma' => 5, 'Modalita' => 6, 'Importo' => 7, 'Pubblicato' => 8, 'DtPubblicazione' => 9, 'RespProcIdrubrica' => 10, ),
        self::TYPE_CAMELNAME     => array('idAmmAperta' => 0, 'idAlbo' => 1, 'ragionesociale' => 2, 'piva' => 3, 'respProc' => 4, 'norma' => 5, 'modalita' => 6, 'importo' => 7, 'pubblicato' => 8, 'dtPubblicazione' => 9, 'respProcIdrubrica' => 10, ),
        self::TYPE_COLNAME       => array(AmmApertaTableMap::COL_ID_AMM_APERTA => 0, AmmApertaTableMap::COL_ID_ALBO => 1, AmmApertaTableMap::COL_RAGIONESOCIALE => 2, AmmApertaTableMap::COL_PIVA => 3, AmmApertaTableMap::COL_RESP_PROC => 4, AmmApertaTableMap::COL_NORMA => 5, AmmApertaTableMap::COL_MODALITA => 6, AmmApertaTableMap::COL_IMPORTO => 7, AmmApertaTableMap::COL_PUBBLICATO => 8, AmmApertaTableMap::COL_DT_PUBBLICAZIONE => 9, AmmApertaTableMap::COL_RESP_PROC_IDRUBRICA => 10, ),
        self::TYPE_FIELDNAME     => array('id_amm_aperta' => 0, 'id_albo' => 1, 'ragionesociale' => 2, 'piva' => 3, 'resp_proc' => 4, 'norma' => 5, 'modalita' => 6, 'importo' => 7, 'pubblicato' => 8, 'dt_pubblicazione' => 9, 'resp_proc_idrubrica' => 10, ),
        self::TYPE_NUM           => array(0, 1, 2, 3, 4, 5, 6, 7, 8, 9, 10, )
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
        $this->setName('amm_aperta');
        $this->setPhpName('AmmAperta');
        $this->setIdentifierQuoting(false);
        $this->setClassName('\\AmmAperta');
        $this->setPackage('');
        $this->setUseIdGenerator(true);
        // columns
        $this->addPrimaryKey('id_amm_aperta', 'IdAmmAperta', 'INTEGER', true, 10, null);
        $this->addColumn('id_albo', 'IdAlbo', 'INTEGER', true, 10, null);
        $this->addColumn('ragionesociale', 'Ragionesociale', 'VARCHAR', true, 250, null);
        $this->addColumn('piva', 'Piva', 'VARCHAR', true, 100, null);
        $this->addColumn('resp_proc', 'RespProc', 'VARCHAR', true, 250, null);
        $this->addColumn('norma', 'Norma', 'VARCHAR', false, 250, null);
        $this->addColumn('modalita', 'Modalita', 'VARCHAR', false, 250, null);
        $this->addColumn('importo', 'Importo', 'DECIMAL', true, 10, null);
        $this->addColumn('pubblicato', 'Pubblicato', 'VARCHAR', true, 1, 'N');
        $this->addColumn('dt_pubblicazione', 'DtPubblicazione', 'DATE', true, null, null);
        $this->addColumn('resp_proc_idrubrica', 'RespProcIdrubrica', 'INTEGER', false, 15, 0);
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
        if ($row[TableMap::TYPE_NUM == $indexType ? 0 + $offset : static::translateFieldName('IdAmmAperta', TableMap::TYPE_PHPNAME, $indexType)] === null) {
            return null;
        }

        return null === $row[TableMap::TYPE_NUM == $indexType ? 0 + $offset : static::translateFieldName('IdAmmAperta', TableMap::TYPE_PHPNAME, $indexType)] || is_scalar($row[TableMap::TYPE_NUM == $indexType ? 0 + $offset : static::translateFieldName('IdAmmAperta', TableMap::TYPE_PHPNAME, $indexType)]) || is_callable([$row[TableMap::TYPE_NUM == $indexType ? 0 + $offset : static::translateFieldName('IdAmmAperta', TableMap::TYPE_PHPNAME, $indexType)], '__toString']) ? (string) $row[TableMap::TYPE_NUM == $indexType ? 0 + $offset : static::translateFieldName('IdAmmAperta', TableMap::TYPE_PHPNAME, $indexType)] : $row[TableMap::TYPE_NUM == $indexType ? 0 + $offset : static::translateFieldName('IdAmmAperta', TableMap::TYPE_PHPNAME, $indexType)];
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
                : self::translateFieldName('IdAmmAperta', TableMap::TYPE_PHPNAME, $indexType)
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
        return $withPrefix ? AmmApertaTableMap::CLASS_DEFAULT : AmmApertaTableMap::OM_CLASS;
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
     * @return array           (AmmAperta object, last column rank)
     */
    public static function populateObject($row, $offset = 0, $indexType = TableMap::TYPE_NUM)
    {
        $key = AmmApertaTableMap::getPrimaryKeyHashFromRow($row, $offset, $indexType);
        if (null !== ($obj = AmmApertaTableMap::getInstanceFromPool($key))) {
            // We no longer rehydrate the object, since this can cause data loss.
            // See http://www.propelorm.org/ticket/509
            // $obj->hydrate($row, $offset, true); // rehydrate
            $col = $offset + AmmApertaTableMap::NUM_HYDRATE_COLUMNS;
        } else {
            $cls = AmmApertaTableMap::OM_CLASS;
            /** @var AmmAperta $obj */
            $obj = new $cls();
            $col = $obj->hydrate($row, $offset, false, $indexType);
            AmmApertaTableMap::addInstanceToPool($obj, $key);
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
            $key = AmmApertaTableMap::getPrimaryKeyHashFromRow($row, 0, $dataFetcher->getIndexType());
            if (null !== ($obj = AmmApertaTableMap::getInstanceFromPool($key))) {
                // We no longer rehydrate the object, since this can cause data loss.
                // See http://www.propelorm.org/ticket/509
                // $obj->hydrate($row, 0, true); // rehydrate
                $results[] = $obj;
            } else {
                /** @var AmmAperta $obj */
                $obj = new $cls();
                $obj->hydrate($row);
                $results[] = $obj;
                AmmApertaTableMap::addInstanceToPool($obj, $key);
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
            $criteria->addSelectColumn(AmmApertaTableMap::COL_ID_AMM_APERTA);
            $criteria->addSelectColumn(AmmApertaTableMap::COL_ID_ALBO);
            $criteria->addSelectColumn(AmmApertaTableMap::COL_RAGIONESOCIALE);
            $criteria->addSelectColumn(AmmApertaTableMap::COL_PIVA);
            $criteria->addSelectColumn(AmmApertaTableMap::COL_RESP_PROC);
            $criteria->addSelectColumn(AmmApertaTableMap::COL_NORMA);
            $criteria->addSelectColumn(AmmApertaTableMap::COL_MODALITA);
            $criteria->addSelectColumn(AmmApertaTableMap::COL_IMPORTO);
            $criteria->addSelectColumn(AmmApertaTableMap::COL_PUBBLICATO);
            $criteria->addSelectColumn(AmmApertaTableMap::COL_DT_PUBBLICAZIONE);
            $criteria->addSelectColumn(AmmApertaTableMap::COL_RESP_PROC_IDRUBRICA);
        } else {
            $criteria->addSelectColumn($alias . '.id_amm_aperta');
            $criteria->addSelectColumn($alias . '.id_albo');
            $criteria->addSelectColumn($alias . '.ragionesociale');
            $criteria->addSelectColumn($alias . '.piva');
            $criteria->addSelectColumn($alias . '.resp_proc');
            $criteria->addSelectColumn($alias . '.norma');
            $criteria->addSelectColumn($alias . '.modalita');
            $criteria->addSelectColumn($alias . '.importo');
            $criteria->addSelectColumn($alias . '.pubblicato');
            $criteria->addSelectColumn($alias . '.dt_pubblicazione');
            $criteria->addSelectColumn($alias . '.resp_proc_idrubrica');
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
        return Propel::getServiceContainer()->getDatabaseMap(AmmApertaTableMap::DATABASE_NAME)->getTable(AmmApertaTableMap::TABLE_NAME);
    }

    /**
     * Add a TableMap instance to the database for this tableMap class.
     */
    public static function buildTableMap()
    {
        $dbMap = Propel::getServiceContainer()->getDatabaseMap(AmmApertaTableMap::DATABASE_NAME);
        if (!$dbMap->hasTable(AmmApertaTableMap::TABLE_NAME)) {
            $dbMap->addTableObject(new AmmApertaTableMap());
        }
    }

    /**
     * Performs a DELETE on the database, given a AmmAperta or Criteria object OR a primary key value.
     *
     * @param mixed               $values Criteria or AmmAperta object or primary key or array of primary keys
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
            $con = Propel::getServiceContainer()->getWriteConnection(AmmApertaTableMap::DATABASE_NAME);
        }

        if ($values instanceof Criteria) {
            // rename for clarity
            $criteria = $values;
        } elseif ($values instanceof \AmmAperta) { // it's a model object
            // create criteria based on pk values
            $criteria = $values->buildPkeyCriteria();
        } else { // it's a primary key, or an array of pks
            $criteria = new Criteria(AmmApertaTableMap::DATABASE_NAME);
            $criteria->add(AmmApertaTableMap::COL_ID_AMM_APERTA, (array) $values, Criteria::IN);
        }

        $query = AmmApertaQuery::create()->mergeWith($criteria);

        if ($values instanceof Criteria) {
            AmmApertaTableMap::clearInstancePool();
        } elseif (!is_object($values)) { // it's a primary key, or an array of pks
            foreach ((array) $values as $singleval) {
                AmmApertaTableMap::removeInstanceFromPool($singleval);
            }
        }

        return $query->delete($con);
    }

    /**
     * Deletes all rows from the amm_aperta table.
     *
     * @param ConnectionInterface $con the connection to use
     * @return int The number of affected rows (if supported by underlying database driver).
     */
    public static function doDeleteAll(ConnectionInterface $con = null)
    {
        return AmmApertaQuery::create()->doDeleteAll($con);
    }

    /**
     * Performs an INSERT on the database, given a AmmAperta or Criteria object.
     *
     * @param mixed               $criteria Criteria or AmmAperta object containing data that is used to create the INSERT statement.
     * @param ConnectionInterface $con the ConnectionInterface connection to use
     * @return mixed           The new primary key.
     * @throws PropelException Any exceptions caught during processing will be
     *                         rethrown wrapped into a PropelException.
     */
    public static function doInsert($criteria, ConnectionInterface $con = null)
    {
        if (null === $con) {
            $con = Propel::getServiceContainer()->getWriteConnection(AmmApertaTableMap::DATABASE_NAME);
        }

        if ($criteria instanceof Criteria) {
            $criteria = clone $criteria; // rename for clarity
        } else {
            $criteria = $criteria->buildCriteria(); // build Criteria from AmmAperta object
        }

        if ($criteria->containsKey(AmmApertaTableMap::COL_ID_AMM_APERTA) && $criteria->keyContainsValue(AmmApertaTableMap::COL_ID_AMM_APERTA) ) {
            throw new PropelException('Cannot insert a value for auto-increment primary key ('.AmmApertaTableMap::COL_ID_AMM_APERTA.')');
        }


        // Set the correct dbName
        $query = AmmApertaQuery::create()->mergeWith($criteria);

        // use transaction because $criteria could contain info
        // for more than one table (I guess, conceivably)
        return $con->transaction(function () use ($con, $query) {
            return $query->doInsert($con);
        });
    }

} // AmmApertaTableMap
// This is the static code needed to register the TableMap for this table with the main Propel class.
//
AmmApertaTableMap::buildTableMap();

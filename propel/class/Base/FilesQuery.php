<?php

namespace Base;

use \Files as ChildFiles;
use \FilesQuery as ChildFilesQuery;
use \Exception;
use \PDO;
use Map\FilesTableMap;
use Propel\Runtime\Propel;
use Propel\Runtime\ActiveQuery\Criteria;
use Propel\Runtime\ActiveQuery\ModelCriteria;
use Propel\Runtime\Collection\ObjectCollection;
use Propel\Runtime\Connection\ConnectionInterface;
use Propel\Runtime\Exception\PropelException;

/**
 * Base class that represents a query for the 'files' table.
 *
 *
 *
 * @method     ChildFilesQuery orderByIdFiles($order = Criteria::ASC) Order by the id_files column
 * @method     ChildFilesQuery orderByIdAlbo($order = Criteria::ASC) Order by the id_albo column
 * @method     ChildFilesQuery orderByFile($order = Criteria::ASC) Order by the file column
 * @method     ChildFilesQuery orderByHistoryId($order = Criteria::ASC) Order by the history_id column
 * @method     ChildFilesQuery orderByDocId($order = Criteria::ASC) Order by the doc_id column
 * @method     ChildFilesQuery orderByFromBlob($order = Criteria::ASC) Order by the from_blob column
 *
 * @method     ChildFilesQuery groupByIdFiles() Group by the id_files column
 * @method     ChildFilesQuery groupByIdAlbo() Group by the id_albo column
 * @method     ChildFilesQuery groupByFile() Group by the file column
 * @method     ChildFilesQuery groupByHistoryId() Group by the history_id column
 * @method     ChildFilesQuery groupByDocId() Group by the doc_id column
 * @method     ChildFilesQuery groupByFromBlob() Group by the from_blob column
 *
 * @method     ChildFilesQuery leftJoin($relation) Adds a LEFT JOIN clause to the query
 * @method     ChildFilesQuery rightJoin($relation) Adds a RIGHT JOIN clause to the query
 * @method     ChildFilesQuery innerJoin($relation) Adds a INNER JOIN clause to the query
 *
 * @method     ChildFilesQuery leftJoinWith($relation) Adds a LEFT JOIN clause and with to the query
 * @method     ChildFilesQuery rightJoinWith($relation) Adds a RIGHT JOIN clause and with to the query
 * @method     ChildFilesQuery innerJoinWith($relation) Adds a INNER JOIN clause and with to the query
 *
 * @method     ChildFiles findOne(ConnectionInterface $con = null) Return the first ChildFiles matching the query
 * @method     ChildFiles findOneOrCreate(ConnectionInterface $con = null) Return the first ChildFiles matching the query, or a new ChildFiles object populated from the query conditions when no match is found
 *
 * @method     ChildFiles findOneByIdFiles(int $id_files) Return the first ChildFiles filtered by the id_files column
 * @method     ChildFiles findOneByIdAlbo(int $id_albo) Return the first ChildFiles filtered by the id_albo column
 * @method     ChildFiles findOneByFile(string $file) Return the first ChildFiles filtered by the file column
 * @method     ChildFiles findOneByHistoryId(int $history_id) Return the first ChildFiles filtered by the history_id column
 * @method     ChildFiles findOneByDocId(int $doc_id) Return the first ChildFiles filtered by the doc_id column
 * @method     ChildFiles findOneByFromBlob(string $from_blob) Return the first ChildFiles filtered by the from_blob column *

 * @method     ChildFiles requirePk($key, ConnectionInterface $con = null) Return the ChildFiles by primary key and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildFiles requireOne(ConnectionInterface $con = null) Return the first ChildFiles matching the query and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 *
 * @method     ChildFiles requireOneByIdFiles(int $id_files) Return the first ChildFiles filtered by the id_files column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildFiles requireOneByIdAlbo(int $id_albo) Return the first ChildFiles filtered by the id_albo column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildFiles requireOneByFile(string $file) Return the first ChildFiles filtered by the file column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildFiles requireOneByHistoryId(int $history_id) Return the first ChildFiles filtered by the history_id column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildFiles requireOneByDocId(int $doc_id) Return the first ChildFiles filtered by the doc_id column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildFiles requireOneByFromBlob(string $from_blob) Return the first ChildFiles filtered by the from_blob column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 *
 * @method     ChildFiles[]|ObjectCollection find(ConnectionInterface $con = null) Return ChildFiles objects based on current ModelCriteria
 * @method     ChildFiles[]|ObjectCollection findByIdFiles(int $id_files) Return ChildFiles objects filtered by the id_files column
 * @method     ChildFiles[]|ObjectCollection findByIdAlbo(int $id_albo) Return ChildFiles objects filtered by the id_albo column
 * @method     ChildFiles[]|ObjectCollection findByFile(string $file) Return ChildFiles objects filtered by the file column
 * @method     ChildFiles[]|ObjectCollection findByHistoryId(int $history_id) Return ChildFiles objects filtered by the history_id column
 * @method     ChildFiles[]|ObjectCollection findByDocId(int $doc_id) Return ChildFiles objects filtered by the doc_id column
 * @method     ChildFiles[]|ObjectCollection findByFromBlob(string $from_blob) Return ChildFiles objects filtered by the from_blob column
 * @method     ChildFiles[]|\Propel\Runtime\Util\PropelModelPager paginate($page = 1, $maxPerPage = 10, ConnectionInterface $con = null) Issue a SELECT query based on the current ModelCriteria and uses a page and a maximum number of results per page to compute an offset and a limit
 *
 */
abstract class FilesQuery extends ModelCriteria
{
    protected $entityNotFoundExceptionClass = '\\Propel\\Runtime\\Exception\\EntityNotFoundException';

    /**
     * Initializes internal state of \Base\FilesQuery object.
     *
     * @param     string $dbName The database name
     * @param     string $modelName The phpName of a model, e.g. 'Book'
     * @param     string $modelAlias The alias for the model in this query, e.g. 'b'
     */
    public function __construct($dbName = 'default', $modelName = '\\Files', $modelAlias = null)
    {
        parent::__construct($dbName, $modelName, $modelAlias);
    }

    /**
     * Returns a new ChildFilesQuery object.
     *
     * @param     string $modelAlias The alias of a model in the query
     * @param     Criteria $criteria Optional Criteria to build the query from
     *
     * @return ChildFilesQuery
     */
    public static function create($modelAlias = null, Criteria $criteria = null)
    {
        if ($criteria instanceof ChildFilesQuery) {
            return $criteria;
        }
        $query = new ChildFilesQuery();
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
     * @return ChildFiles|array|mixed the result, formatted by the current formatter
     */
    public function findPk($key, ConnectionInterface $con = null)
    {
        if ($key === null) {
            return null;
        }
        if ((null !== ($obj = FilesTableMap::getInstanceFromPool(null === $key || is_scalar($key) || is_callable([$key, '__toString']) ? (string) $key : $key))) && !$this->formatter) {
            // the object is already in the instance pool
            return $obj;
        }
        if ($con === null) {
            $con = Propel::getServiceContainer()->getReadConnection(FilesTableMap::DATABASE_NAME);
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
     * @throws \Propel\Runtime\Exception\PropelException
     *
     * @return ChildFiles A model object, or null if the key is not found
     */
    protected function findPkSimple($key, ConnectionInterface $con)
    {
        $sql = 'SELECT id_files, id_albo, file, history_id, doc_id, from_blob FROM files WHERE id_files = :p0';
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
            /** @var ChildFiles $obj */
            $obj = new ChildFiles();
            $obj->hydrate($row);
            FilesTableMap::addInstanceToPool($obj, null === $key || is_scalar($key) || is_callable([$key, '__toString']) ? (string) $key : $key);
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
     * @return ChildFiles|array|mixed the result, formatted by the current formatter
     */
    protected function findPkComplex($key, ConnectionInterface $con)
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
    public function findPks($keys, ConnectionInterface $con = null)
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
     * @return $this|ChildFilesQuery The current query, for fluid interface
     */
    public function filterByPrimaryKey($key)
    {

        return $this->addUsingAlias(FilesTableMap::COL_ID_FILES, $key, Criteria::EQUAL);
    }

    /**
     * Filter the query by a list of primary keys
     *
     * @param     array $keys The list of primary key to use for the query
     *
     * @return $this|ChildFilesQuery The current query, for fluid interface
     */
    public function filterByPrimaryKeys($keys)
    {

        return $this->addUsingAlias(FilesTableMap::COL_ID_FILES, $keys, Criteria::IN);
    }

    /**
     * Filter the query on the id_files column
     *
     * Example usage:
     * <code>
     * $query->filterByIdFiles(1234); // WHERE id_files = 1234
     * $query->filterByIdFiles(array(12, 34)); // WHERE id_files IN (12, 34)
     * $query->filterByIdFiles(array('min' => 12)); // WHERE id_files > 12
     * </code>
     *
     * @param     mixed $idFiles The value to use as filter.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildFilesQuery The current query, for fluid interface
     */
    public function filterByIdFiles($idFiles = null, $comparison = null)
    {
        if (is_array($idFiles)) {
            $useMinMax = false;
            if (isset($idFiles['min'])) {
                $this->addUsingAlias(FilesTableMap::COL_ID_FILES, $idFiles['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($idFiles['max'])) {
                $this->addUsingAlias(FilesTableMap::COL_ID_FILES, $idFiles['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(FilesTableMap::COL_ID_FILES, $idFiles, $comparison);
    }

    /**
     * Filter the query on the id_albo column
     *
     * Example usage:
     * <code>
     * $query->filterByIdAlbo(1234); // WHERE id_albo = 1234
     * $query->filterByIdAlbo(array(12, 34)); // WHERE id_albo IN (12, 34)
     * $query->filterByIdAlbo(array('min' => 12)); // WHERE id_albo > 12
     * </code>
     *
     * @param     mixed $idAlbo The value to use as filter.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildFilesQuery The current query, for fluid interface
     */
    public function filterByIdAlbo($idAlbo = null, $comparison = null)
    {
        if (is_array($idAlbo)) {
            $useMinMax = false;
            if (isset($idAlbo['min'])) {
                $this->addUsingAlias(FilesTableMap::COL_ID_ALBO, $idAlbo['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($idAlbo['max'])) {
                $this->addUsingAlias(FilesTableMap::COL_ID_ALBO, $idAlbo['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(FilesTableMap::COL_ID_ALBO, $idAlbo, $comparison);
    }

    /**
     * Filter the query on the file column
     *
     * Example usage:
     * <code>
     * $query->filterByFile('fooValue');   // WHERE file = 'fooValue'
     * $query->filterByFile('%fooValue%'); // WHERE file LIKE '%fooValue%'
     * </code>
     *
     * @param     string $file The value to use as filter.
     *              Accepts wildcards (* and % trigger a LIKE)
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildFilesQuery The current query, for fluid interface
     */
    public function filterByFile($file = null, $comparison = null)
    {
        if (null === $comparison) {
            if (is_array($file)) {
                $comparison = Criteria::IN;
            } elseif (preg_match('/[\%\*]/', $file)) {
                $file = str_replace('*', '%', $file);
                $comparison = Criteria::LIKE;
            }
        }

        return $this->addUsingAlias(FilesTableMap::COL_FILE, $file, $comparison);
    }

    /**
     * Filter the query on the history_id column
     *
     * Example usage:
     * <code>
     * $query->filterByHistoryId(1234); // WHERE history_id = 1234
     * $query->filterByHistoryId(array(12, 34)); // WHERE history_id IN (12, 34)
     * $query->filterByHistoryId(array('min' => 12)); // WHERE history_id > 12
     * </code>
     *
     * @param     mixed $historyId The value to use as filter.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildFilesQuery The current query, for fluid interface
     */
    public function filterByHistoryId($historyId = null, $comparison = null)
    {
        if (is_array($historyId)) {
            $useMinMax = false;
            if (isset($historyId['min'])) {
                $this->addUsingAlias(FilesTableMap::COL_HISTORY_ID, $historyId['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($historyId['max'])) {
                $this->addUsingAlias(FilesTableMap::COL_HISTORY_ID, $historyId['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(FilesTableMap::COL_HISTORY_ID, $historyId, $comparison);
    }

    /**
     * Filter the query on the doc_id column
     *
     * Example usage:
     * <code>
     * $query->filterByDocId(1234); // WHERE doc_id = 1234
     * $query->filterByDocId(array(12, 34)); // WHERE doc_id IN (12, 34)
     * $query->filterByDocId(array('min' => 12)); // WHERE doc_id > 12
     * </code>
     *
     * @param     mixed $docId The value to use as filter.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildFilesQuery The current query, for fluid interface
     */
    public function filterByDocId($docId = null, $comparison = null)
    {
        if (is_array($docId)) {
            $useMinMax = false;
            if (isset($docId['min'])) {
                $this->addUsingAlias(FilesTableMap::COL_DOC_ID, $docId['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($docId['max'])) {
                $this->addUsingAlias(FilesTableMap::COL_DOC_ID, $docId['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(FilesTableMap::COL_DOC_ID, $docId, $comparison);
    }

    /**
     * Filter the query on the from_blob column
     *
     * Example usage:
     * <code>
     * $query->filterByFromBlob('fooValue');   // WHERE from_blob = 'fooValue'
     * $query->filterByFromBlob('%fooValue%'); // WHERE from_blob LIKE '%fooValue%'
     * </code>
     *
     * @param     string $fromBlob The value to use as filter.
     *              Accepts wildcards (* and % trigger a LIKE)
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildFilesQuery The current query, for fluid interface
     */
    public function filterByFromBlob($fromBlob = null, $comparison = null)
    {
        if (null === $comparison) {
            if (is_array($fromBlob)) {
                $comparison = Criteria::IN;
            } elseif (preg_match('/[\%\*]/', $fromBlob)) {
                $fromBlob = str_replace('*', '%', $fromBlob);
                $comparison = Criteria::LIKE;
            }
        }

        return $this->addUsingAlias(FilesTableMap::COL_FROM_BLOB, $fromBlob, $comparison);
    }

    /**
     * Exclude object from result
     *
     * @param   ChildFiles $files Object to remove from the list of results
     *
     * @return $this|ChildFilesQuery The current query, for fluid interface
     */
    public function prune($files = null)
    {
        if ($files) {
            $this->addUsingAlias(FilesTableMap::COL_ID_FILES, $files->getIdFiles(), Criteria::NOT_EQUAL);
        }

        return $this;
    }

    /**
     * Deletes all rows from the files table.
     *
     * @param ConnectionInterface $con the connection to use
     * @return int The number of affected rows (if supported by underlying database driver).
     */
    public function doDeleteAll(ConnectionInterface $con = null)
    {
        if (null === $con) {
            $con = Propel::getServiceContainer()->getWriteConnection(FilesTableMap::DATABASE_NAME);
        }

        // use transaction because $criteria could contain info
        // for more than one table or we could emulating ON DELETE CASCADE, etc.
        return $con->transaction(function () use ($con) {
            $affectedRows = 0; // initialize var to track total num of affected rows
            $affectedRows += parent::doDeleteAll($con);
            // Because this db requires some delete cascade/set null emulation, we have to
            // clear the cached instance *after* the emulation has happened (since
            // instances get re-added by the select statement contained therein).
            FilesTableMap::clearInstancePool();
            FilesTableMap::clearRelatedInstancePool();

            return $affectedRows;
        });
    }

    /**
     * Performs a DELETE on the database based on the current ModelCriteria
     *
     * @param ConnectionInterface $con the connection to use
     * @return int             The number of affected rows (if supported by underlying database driver).  This includes CASCADE-related rows
     *                         if supported by native driver or if emulated using Propel.
     * @throws PropelException Any exceptions caught during processing will be
     *                         rethrown wrapped into a PropelException.
     */
    public function delete(ConnectionInterface $con = null)
    {
        if (null === $con) {
            $con = Propel::getServiceContainer()->getWriteConnection(FilesTableMap::DATABASE_NAME);
        }

        $criteria = $this;

        // Set the correct dbName
        $criteria->setDbName(FilesTableMap::DATABASE_NAME);

        // use transaction because $criteria could contain info
        // for more than one table or we could emulating ON DELETE CASCADE, etc.
        return $con->transaction(function () use ($con, $criteria) {
            $affectedRows = 0; // initialize var to track total num of affected rows

            FilesTableMap::removeInstanceFromPool($criteria);

            $affectedRows += ModelCriteria::delete($con);
            FilesTableMap::clearRelatedInstancePool();

            return $affectedRows;
        });
    }

} // FilesQuery

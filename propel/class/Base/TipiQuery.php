<?php

namespace Base;

use \Tipi as ChildTipi;
use \TipiQuery as ChildTipiQuery;
use \Exception;
use \PDO;
use Map\TipiTableMap;
use Propel\Runtime\Propel;
use Propel\Runtime\ActiveQuery\Criteria;
use Propel\Runtime\ActiveQuery\ModelCriteria;
use Propel\Runtime\Collection\ObjectCollection;
use Propel\Runtime\Connection\ConnectionInterface;
use Propel\Runtime\Exception\PropelException;

/**
 * Base class that represents a query for the 'tipi' table.
 *
 *
 *
 * @method     ChildTipiQuery orderByIdTipo($order = Criteria::ASC) Order by the id_tipo column
 * @method     ChildTipiQuery orderByTipo($order = Criteria::ASC) Order by the tipo column
 *
 * @method     ChildTipiQuery groupByIdTipo() Group by the id_tipo column
 * @method     ChildTipiQuery groupByTipo() Group by the tipo column
 *
 * @method     ChildTipiQuery leftJoin($relation) Adds a LEFT JOIN clause to the query
 * @method     ChildTipiQuery rightJoin($relation) Adds a RIGHT JOIN clause to the query
 * @method     ChildTipiQuery innerJoin($relation) Adds a INNER JOIN clause to the query
 *
 * @method     ChildTipiQuery leftJoinWith($relation) Adds a LEFT JOIN clause and with to the query
 * @method     ChildTipiQuery rightJoinWith($relation) Adds a RIGHT JOIN clause and with to the query
 * @method     ChildTipiQuery innerJoinWith($relation) Adds a INNER JOIN clause and with to the query
 *
 * @method     ChildTipi findOne(ConnectionInterface $con = null) Return the first ChildTipi matching the query
 * @method     ChildTipi findOneOrCreate(ConnectionInterface $con = null) Return the first ChildTipi matching the query, or a new ChildTipi object populated from the query conditions when no match is found
 *
 * @method     ChildTipi findOneByIdTipo(int $id_tipo) Return the first ChildTipi filtered by the id_tipo column
 * @method     ChildTipi findOneByTipo(string $tipo) Return the first ChildTipi filtered by the tipo column *

 * @method     ChildTipi requirePk($key, ConnectionInterface $con = null) Return the ChildTipi by primary key and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildTipi requireOne(ConnectionInterface $con = null) Return the first ChildTipi matching the query and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 *
 * @method     ChildTipi requireOneByIdTipo(int $id_tipo) Return the first ChildTipi filtered by the id_tipo column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildTipi requireOneByTipo(string $tipo) Return the first ChildTipi filtered by the tipo column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 *
 * @method     ChildTipi[]|ObjectCollection find(ConnectionInterface $con = null) Return ChildTipi objects based on current ModelCriteria
 * @method     ChildTipi[]|ObjectCollection findByIdTipo(int $id_tipo) Return ChildTipi objects filtered by the id_tipo column
 * @method     ChildTipi[]|ObjectCollection findByTipo(string $tipo) Return ChildTipi objects filtered by the tipo column
 * @method     ChildTipi[]|\Propel\Runtime\Util\PropelModelPager paginate($page = 1, $maxPerPage = 10, ConnectionInterface $con = null) Issue a SELECT query based on the current ModelCriteria and uses a page and a maximum number of results per page to compute an offset and a limit
 *
 */
abstract class TipiQuery extends ModelCriteria
{
    protected $entityNotFoundExceptionClass = '\\Propel\\Runtime\\Exception\\EntityNotFoundException';

    /**
     * Initializes internal state of \Base\TipiQuery object.
     *
     * @param     string $dbName The database name
     * @param     string $modelName The phpName of a model, e.g. 'Book'
     * @param     string $modelAlias The alias for the model in this query, e.g. 'b'
     */
    public function __construct($dbName = 'default', $modelName = '\\Tipi', $modelAlias = null)
    {
        parent::__construct($dbName, $modelName, $modelAlias);
    }

    /**
     * Returns a new ChildTipiQuery object.
     *
     * @param     string $modelAlias The alias of a model in the query
     * @param     Criteria $criteria Optional Criteria to build the query from
     *
     * @return ChildTipiQuery
     */
    public static function create($modelAlias = null, Criteria $criteria = null)
    {
        if ($criteria instanceof ChildTipiQuery) {
            return $criteria;
        }
        $query = new ChildTipiQuery();
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
     * @return ChildTipi|array|mixed the result, formatted by the current formatter
     */
    public function findPk($key, ConnectionInterface $con = null)
    {
        if ($key === null) {
            return null;
        }
        if ((null !== ($obj = TipiTableMap::getInstanceFromPool(null === $key || is_scalar($key) || is_callable([$key, '__toString']) ? (string) $key : $key))) && !$this->formatter) {
            // the object is already in the instance pool
            return $obj;
        }
        if ($con === null) {
            $con = Propel::getServiceContainer()->getReadConnection(TipiTableMap::DATABASE_NAME);
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
     * @return ChildTipi A model object, or null if the key is not found
     */
    protected function findPkSimple($key, ConnectionInterface $con)
    {
        $sql = 'SELECT id_tipo, tipo FROM tipi WHERE id_tipo = :p0';
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
            /** @var ChildTipi $obj */
            $obj = new ChildTipi();
            $obj->hydrate($row);
            TipiTableMap::addInstanceToPool($obj, null === $key || is_scalar($key) || is_callable([$key, '__toString']) ? (string) $key : $key);
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
     * @return ChildTipi|array|mixed the result, formatted by the current formatter
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
     * @return $this|ChildTipiQuery The current query, for fluid interface
     */
    public function filterByPrimaryKey($key)
    {

        return $this->addUsingAlias(TipiTableMap::COL_ID_TIPO, $key, Criteria::EQUAL);
    }

    /**
     * Filter the query by a list of primary keys
     *
     * @param     array $keys The list of primary key to use for the query
     *
     * @return $this|ChildTipiQuery The current query, for fluid interface
     */
    public function filterByPrimaryKeys($keys)
    {

        return $this->addUsingAlias(TipiTableMap::COL_ID_TIPO, $keys, Criteria::IN);
    }

    /**
     * Filter the query on the id_tipo column
     *
     * Example usage:
     * <code>
     * $query->filterByIdTipo(1234); // WHERE id_tipo = 1234
     * $query->filterByIdTipo(array(12, 34)); // WHERE id_tipo IN (12, 34)
     * $query->filterByIdTipo(array('min' => 12)); // WHERE id_tipo > 12
     * </code>
     *
     * @param     mixed $idTipo The value to use as filter.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildTipiQuery The current query, for fluid interface
     */
    public function filterByIdTipo($idTipo = null, $comparison = null)
    {
        if (is_array($idTipo)) {
            $useMinMax = false;
            if (isset($idTipo['min'])) {
                $this->addUsingAlias(TipiTableMap::COL_ID_TIPO, $idTipo['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($idTipo['max'])) {
                $this->addUsingAlias(TipiTableMap::COL_ID_TIPO, $idTipo['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(TipiTableMap::COL_ID_TIPO, $idTipo, $comparison);
    }

    /**
     * Filter the query on the tipo column
     *
     * Example usage:
     * <code>
     * $query->filterByTipo('fooValue');   // WHERE tipo = 'fooValue'
     * $query->filterByTipo('%fooValue%'); // WHERE tipo LIKE '%fooValue%'
     * </code>
     *
     * @param     string $tipo The value to use as filter.
     *              Accepts wildcards (* and % trigger a LIKE)
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildTipiQuery The current query, for fluid interface
     */
    public function filterByTipo($tipo = null, $comparison = null)
    {
        if (null === $comparison) {
            if (is_array($tipo)) {
                $comparison = Criteria::IN;
            } elseif (preg_match('/[\%\*]/', $tipo)) {
                $tipo = str_replace('*', '%', $tipo);
                $comparison = Criteria::LIKE;
            }
        }

        return $this->addUsingAlias(TipiTableMap::COL_TIPO, $tipo, $comparison);
    }

    /**
     * Exclude object from result
     *
     * @param   ChildTipi $tipi Object to remove from the list of results
     *
     * @return $this|ChildTipiQuery The current query, for fluid interface
     */
    public function prune($tipi = null)
    {
        if ($tipi) {
            $this->addUsingAlias(TipiTableMap::COL_ID_TIPO, $tipi->getIdTipo(), Criteria::NOT_EQUAL);
        }

        return $this;
    }

    /**
     * Deletes all rows from the tipi table.
     *
     * @param ConnectionInterface $con the connection to use
     * @return int The number of affected rows (if supported by underlying database driver).
     */
    public function doDeleteAll(ConnectionInterface $con = null)
    {
        if (null === $con) {
            $con = Propel::getServiceContainer()->getWriteConnection(TipiTableMap::DATABASE_NAME);
        }

        // use transaction because $criteria could contain info
        // for more than one table or we could emulating ON DELETE CASCADE, etc.
        return $con->transaction(function () use ($con) {
            $affectedRows = 0; // initialize var to track total num of affected rows
            $affectedRows += parent::doDeleteAll($con);
            // Because this db requires some delete cascade/set null emulation, we have to
            // clear the cached instance *after* the emulation has happened (since
            // instances get re-added by the select statement contained therein).
            TipiTableMap::clearInstancePool();
            TipiTableMap::clearRelatedInstancePool();

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
            $con = Propel::getServiceContainer()->getWriteConnection(TipiTableMap::DATABASE_NAME);
        }

        $criteria = $this;

        // Set the correct dbName
        $criteria->setDbName(TipiTableMap::DATABASE_NAME);

        // use transaction because $criteria could contain info
        // for more than one table or we could emulating ON DELETE CASCADE, etc.
        return $con->transaction(function () use ($con, $criteria) {
            $affectedRows = 0; // initialize var to track total num of affected rows

            TipiTableMap::removeInstanceFromPool($criteria);

            $affectedRows += ModelCriteria::delete($con);
            TipiTableMap::clearRelatedInstancePool();

            return $affectedRows;
        });
    }

} // TipiQuery

<?php

namespace Base;

use \TipiTrasp as ChildTipiTrasp;
use \TipiTraspQuery as ChildTipiTraspQuery;
use \Exception;
use \PDO;
use Map\TipiTraspTableMap;
use Propel\Runtime\Propel;
use Propel\Runtime\ActiveQuery\Criteria;
use Propel\Runtime\ActiveQuery\ModelCriteria;
use Propel\Runtime\Collection\ObjectCollection;
use Propel\Runtime\Connection\ConnectionInterface;
use Propel\Runtime\Exception\PropelException;

/**
 * Base class that represents a query for the 'tipi_trasp' table.
 *
 *
 *
 * @method     ChildTipiTraspQuery orderByIdTipoTrasp($order = Criteria::ASC) Order by the id_tipo_trasp column
 * @method     ChildTipiTraspQuery orderByTipoTrasp($order = Criteria::ASC) Order by the tipo_trasp column
 *
 * @method     ChildTipiTraspQuery groupByIdTipoTrasp() Group by the id_tipo_trasp column
 * @method     ChildTipiTraspQuery groupByTipoTrasp() Group by the tipo_trasp column
 *
 * @method     ChildTipiTraspQuery leftJoin($relation) Adds a LEFT JOIN clause to the query
 * @method     ChildTipiTraspQuery rightJoin($relation) Adds a RIGHT JOIN clause to the query
 * @method     ChildTipiTraspQuery innerJoin($relation) Adds a INNER JOIN clause to the query
 *
 * @method     ChildTipiTraspQuery leftJoinWith($relation) Adds a LEFT JOIN clause and with to the query
 * @method     ChildTipiTraspQuery rightJoinWith($relation) Adds a RIGHT JOIN clause and with to the query
 * @method     ChildTipiTraspQuery innerJoinWith($relation) Adds a INNER JOIN clause and with to the query
 *
 * @method     ChildTipiTrasp findOne(ConnectionInterface $con = null) Return the first ChildTipiTrasp matching the query
 * @method     ChildTipiTrasp findOneOrCreate(ConnectionInterface $con = null) Return the first ChildTipiTrasp matching the query, or a new ChildTipiTrasp object populated from the query conditions when no match is found
 *
 * @method     ChildTipiTrasp findOneByIdTipoTrasp(int $id_tipo_trasp) Return the first ChildTipiTrasp filtered by the id_tipo_trasp column
 * @method     ChildTipiTrasp findOneByTipoTrasp(string $tipo_trasp) Return the first ChildTipiTrasp filtered by the tipo_trasp column *

 * @method     ChildTipiTrasp requirePk($key, ConnectionInterface $con = null) Return the ChildTipiTrasp by primary key and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildTipiTrasp requireOne(ConnectionInterface $con = null) Return the first ChildTipiTrasp matching the query and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 *
 * @method     ChildTipiTrasp requireOneByIdTipoTrasp(int $id_tipo_trasp) Return the first ChildTipiTrasp filtered by the id_tipo_trasp column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildTipiTrasp requireOneByTipoTrasp(string $tipo_trasp) Return the first ChildTipiTrasp filtered by the tipo_trasp column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 *
 * @method     ChildTipiTrasp[]|ObjectCollection find(ConnectionInterface $con = null) Return ChildTipiTrasp objects based on current ModelCriteria
 * @method     ChildTipiTrasp[]|ObjectCollection findByIdTipoTrasp(int $id_tipo_trasp) Return ChildTipiTrasp objects filtered by the id_tipo_trasp column
 * @method     ChildTipiTrasp[]|ObjectCollection findByTipoTrasp(string $tipo_trasp) Return ChildTipiTrasp objects filtered by the tipo_trasp column
 * @method     ChildTipiTrasp[]|\Propel\Runtime\Util\PropelModelPager paginate($page = 1, $maxPerPage = 10, ConnectionInterface $con = null) Issue a SELECT query based on the current ModelCriteria and uses a page and a maximum number of results per page to compute an offset and a limit
 *
 */
abstract class TipiTraspQuery extends ModelCriteria
{
    protected $entityNotFoundExceptionClass = '\\Propel\\Runtime\\Exception\\EntityNotFoundException';

    /**
     * Initializes internal state of \Base\TipiTraspQuery object.
     *
     * @param     string $dbName The database name
     * @param     string $modelName The phpName of a model, e.g. 'Book'
     * @param     string $modelAlias The alias for the model in this query, e.g. 'b'
     */
    public function __construct($dbName = 'default', $modelName = '\\TipiTrasp', $modelAlias = null)
    {
        parent::__construct($dbName, $modelName, $modelAlias);
    }

    /**
     * Returns a new ChildTipiTraspQuery object.
     *
     * @param     string $modelAlias The alias of a model in the query
     * @param     Criteria $criteria Optional Criteria to build the query from
     *
     * @return ChildTipiTraspQuery
     */
    public static function create($modelAlias = null, Criteria $criteria = null)
    {
        if ($criteria instanceof ChildTipiTraspQuery) {
            return $criteria;
        }
        $query = new ChildTipiTraspQuery();
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
     * @return ChildTipiTrasp|array|mixed the result, formatted by the current formatter
     */
    public function findPk($key, ConnectionInterface $con = null)
    {
        if ($key === null) {
            return null;
        }
        if ((null !== ($obj = TipiTraspTableMap::getInstanceFromPool(null === $key || is_scalar($key) || is_callable([$key, '__toString']) ? (string) $key : $key))) && !$this->formatter) {
            // the object is already in the instance pool
            return $obj;
        }
        if ($con === null) {
            $con = Propel::getServiceContainer()->getReadConnection(TipiTraspTableMap::DATABASE_NAME);
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
     * @return ChildTipiTrasp A model object, or null if the key is not found
     */
    protected function findPkSimple($key, ConnectionInterface $con)
    {
        $sql = 'SELECT id_tipo_trasp, tipo_trasp FROM tipi_trasp WHERE id_tipo_trasp = :p0';
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
            /** @var ChildTipiTrasp $obj */
            $obj = new ChildTipiTrasp();
            $obj->hydrate($row);
            TipiTraspTableMap::addInstanceToPool($obj, null === $key || is_scalar($key) || is_callable([$key, '__toString']) ? (string) $key : $key);
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
     * @return ChildTipiTrasp|array|mixed the result, formatted by the current formatter
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
     * @return $this|ChildTipiTraspQuery The current query, for fluid interface
     */
    public function filterByPrimaryKey($key)
    {

        return $this->addUsingAlias(TipiTraspTableMap::COL_ID_TIPO_TRASP, $key, Criteria::EQUAL);
    }

    /**
     * Filter the query by a list of primary keys
     *
     * @param     array $keys The list of primary key to use for the query
     *
     * @return $this|ChildTipiTraspQuery The current query, for fluid interface
     */
    public function filterByPrimaryKeys($keys)
    {

        return $this->addUsingAlias(TipiTraspTableMap::COL_ID_TIPO_TRASP, $keys, Criteria::IN);
    }

    /**
     * Filter the query on the id_tipo_trasp column
     *
     * Example usage:
     * <code>
     * $query->filterByIdTipoTrasp(1234); // WHERE id_tipo_trasp = 1234
     * $query->filterByIdTipoTrasp(array(12, 34)); // WHERE id_tipo_trasp IN (12, 34)
     * $query->filterByIdTipoTrasp(array('min' => 12)); // WHERE id_tipo_trasp > 12
     * </code>
     *
     * @param     mixed $idTipoTrasp The value to use as filter.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildTipiTraspQuery The current query, for fluid interface
     */
    public function filterByIdTipoTrasp($idTipoTrasp = null, $comparison = null)
    {
        if (is_array($idTipoTrasp)) {
            $useMinMax = false;
            if (isset($idTipoTrasp['min'])) {
                $this->addUsingAlias(TipiTraspTableMap::COL_ID_TIPO_TRASP, $idTipoTrasp['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($idTipoTrasp['max'])) {
                $this->addUsingAlias(TipiTraspTableMap::COL_ID_TIPO_TRASP, $idTipoTrasp['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(TipiTraspTableMap::COL_ID_TIPO_TRASP, $idTipoTrasp, $comparison);
    }

    /**
     * Filter the query on the tipo_trasp column
     *
     * Example usage:
     * <code>
     * $query->filterByTipoTrasp('fooValue');   // WHERE tipo_trasp = 'fooValue'
     * $query->filterByTipoTrasp('%fooValue%'); // WHERE tipo_trasp LIKE '%fooValue%'
     * </code>
     *
     * @param     string $tipoTrasp The value to use as filter.
     *              Accepts wildcards (* and % trigger a LIKE)
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildTipiTraspQuery The current query, for fluid interface
     */
    public function filterByTipoTrasp($tipoTrasp = null, $comparison = null)
    {
        if (null === $comparison) {
            if (is_array($tipoTrasp)) {
                $comparison = Criteria::IN;
            } elseif (preg_match('/[\%\*]/', $tipoTrasp)) {
                $tipoTrasp = str_replace('*', '%', $tipoTrasp);
                $comparison = Criteria::LIKE;
            }
        }

        return $this->addUsingAlias(TipiTraspTableMap::COL_TIPO_TRASP, $tipoTrasp, $comparison);
    }

    /**
     * Exclude object from result
     *
     * @param   ChildTipiTrasp $tipiTrasp Object to remove from the list of results
     *
     * @return $this|ChildTipiTraspQuery The current query, for fluid interface
     */
    public function prune($tipiTrasp = null)
    {
        if ($tipiTrasp) {
            $this->addUsingAlias(TipiTraspTableMap::COL_ID_TIPO_TRASP, $tipiTrasp->getIdTipoTrasp(), Criteria::NOT_EQUAL);
        }

        return $this;
    }

    /**
     * Deletes all rows from the tipi_trasp table.
     *
     * @param ConnectionInterface $con the connection to use
     * @return int The number of affected rows (if supported by underlying database driver).
     */
    public function doDeleteAll(ConnectionInterface $con = null)
    {
        if (null === $con) {
            $con = Propel::getServiceContainer()->getWriteConnection(TipiTraspTableMap::DATABASE_NAME);
        }

        // use transaction because $criteria could contain info
        // for more than one table or we could emulating ON DELETE CASCADE, etc.
        return $con->transaction(function () use ($con) {
            $affectedRows = 0; // initialize var to track total num of affected rows
            $affectedRows += parent::doDeleteAll($con);
            // Because this db requires some delete cascade/set null emulation, we have to
            // clear the cached instance *after* the emulation has happened (since
            // instances get re-added by the select statement contained therein).
            TipiTraspTableMap::clearInstancePool();
            TipiTraspTableMap::clearRelatedInstancePool();

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
            $con = Propel::getServiceContainer()->getWriteConnection(TipiTraspTableMap::DATABASE_NAME);
        }

        $criteria = $this;

        // Set the correct dbName
        $criteria->setDbName(TipiTraspTableMap::DATABASE_NAME);

        // use transaction because $criteria could contain info
        // for more than one table or we could emulating ON DELETE CASCADE, etc.
        return $con->transaction(function () use ($con, $criteria) {
            $affectedRows = 0; // initialize var to track total num of affected rows

            TipiTraspTableMap::removeInstanceFromPool($criteria);

            $affectedRows += ModelCriteria::delete($con);
            TipiTraspTableMap::clearRelatedInstancePool();

            return $affectedRows;
        });
    }

} // TipiTraspQuery

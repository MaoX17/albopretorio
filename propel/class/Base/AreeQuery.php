<?php

namespace Base;

use \Aree as ChildAree;
use \AreeQuery as ChildAreeQuery;
use \Exception;
use \PDO;
use Map\AreeTableMap;
use Propel\Runtime\Propel;
use Propel\Runtime\ActiveQuery\Criteria;
use Propel\Runtime\ActiveQuery\ModelCriteria;
use Propel\Runtime\Collection\ObjectCollection;
use Propel\Runtime\Connection\ConnectionInterface;
use Propel\Runtime\Exception\PropelException;

/**
 * Base class that represents a query for the 'aree' table.
 *
 *
 *
 * @method     ChildAreeQuery orderByIdArea($order = Criteria::ASC) Order by the id_area column
 * @method     ChildAreeQuery orderByResponsabile($order = Criteria::ASC) Order by the responsabile column
 * @method     ChildAreeQuery orderByArea($order = Criteria::ASC) Order by the area column
 * @method     ChildAreeQuery orderByAttivo($order = Criteria::ASC) Order by the attivo column
 *
 * @method     ChildAreeQuery groupByIdArea() Group by the id_area column
 * @method     ChildAreeQuery groupByResponsabile() Group by the responsabile column
 * @method     ChildAreeQuery groupByArea() Group by the area column
 * @method     ChildAreeQuery groupByAttivo() Group by the attivo column
 *
 * @method     ChildAreeQuery leftJoin($relation) Adds a LEFT JOIN clause to the query
 * @method     ChildAreeQuery rightJoin($relation) Adds a RIGHT JOIN clause to the query
 * @method     ChildAreeQuery innerJoin($relation) Adds a INNER JOIN clause to the query
 *
 * @method     ChildAreeQuery leftJoinWith($relation) Adds a LEFT JOIN clause and with to the query
 * @method     ChildAreeQuery rightJoinWith($relation) Adds a RIGHT JOIN clause and with to the query
 * @method     ChildAreeQuery innerJoinWith($relation) Adds a INNER JOIN clause and with to the query
 *
 * @method     ChildAree findOne(ConnectionInterface $con = null) Return the first ChildAree matching the query
 * @method     ChildAree findOneOrCreate(ConnectionInterface $con = null) Return the first ChildAree matching the query, or a new ChildAree object populated from the query conditions when no match is found
 *
 * @method     ChildAree findOneByIdArea(int $id_area) Return the first ChildAree filtered by the id_area column
 * @method     ChildAree findOneByResponsabile(string $responsabile) Return the first ChildAree filtered by the responsabile column
 * @method     ChildAree findOneByArea(string $area) Return the first ChildAree filtered by the area column
 * @method     ChildAree findOneByAttivo(string $attivo) Return the first ChildAree filtered by the attivo column *

 * @method     ChildAree requirePk($key, ConnectionInterface $con = null) Return the ChildAree by primary key and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildAree requireOne(ConnectionInterface $con = null) Return the first ChildAree matching the query and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 *
 * @method     ChildAree requireOneByIdArea(int $id_area) Return the first ChildAree filtered by the id_area column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildAree requireOneByResponsabile(string $responsabile) Return the first ChildAree filtered by the responsabile column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildAree requireOneByArea(string $area) Return the first ChildAree filtered by the area column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildAree requireOneByAttivo(string $attivo) Return the first ChildAree filtered by the attivo column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 *
 * @method     ChildAree[]|ObjectCollection find(ConnectionInterface $con = null) Return ChildAree objects based on current ModelCriteria
 * @method     ChildAree[]|ObjectCollection findByIdArea(int $id_area) Return ChildAree objects filtered by the id_area column
 * @method     ChildAree[]|ObjectCollection findByResponsabile(string $responsabile) Return ChildAree objects filtered by the responsabile column
 * @method     ChildAree[]|ObjectCollection findByArea(string $area) Return ChildAree objects filtered by the area column
 * @method     ChildAree[]|ObjectCollection findByAttivo(string $attivo) Return ChildAree objects filtered by the attivo column
 * @method     ChildAree[]|\Propel\Runtime\Util\PropelModelPager paginate($page = 1, $maxPerPage = 10, ConnectionInterface $con = null) Issue a SELECT query based on the current ModelCriteria and uses a page and a maximum number of results per page to compute an offset and a limit
 *
 */
abstract class AreeQuery extends ModelCriteria
{
    protected $entityNotFoundExceptionClass = '\\Propel\\Runtime\\Exception\\EntityNotFoundException';

    /**
     * Initializes internal state of \Base\AreeQuery object.
     *
     * @param     string $dbName The database name
     * @param     string $modelName The phpName of a model, e.g. 'Book'
     * @param     string $modelAlias The alias for the model in this query, e.g. 'b'
     */
    public function __construct($dbName = 'default', $modelName = '\\Aree', $modelAlias = null)
    {
        parent::__construct($dbName, $modelName, $modelAlias);
    }

    /**
     * Returns a new ChildAreeQuery object.
     *
     * @param     string $modelAlias The alias of a model in the query
     * @param     Criteria $criteria Optional Criteria to build the query from
     *
     * @return ChildAreeQuery
     */
    public static function create($modelAlias = null, Criteria $criteria = null)
    {
        if ($criteria instanceof ChildAreeQuery) {
            return $criteria;
        }
        $query = new ChildAreeQuery();
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
     * @return ChildAree|array|mixed the result, formatted by the current formatter
     */
    public function findPk($key, ConnectionInterface $con = null)
    {
        if ($key === null) {
            return null;
        }
        if ((null !== ($obj = AreeTableMap::getInstanceFromPool(null === $key || is_scalar($key) || is_callable([$key, '__toString']) ? (string) $key : $key))) && !$this->formatter) {
            // the object is already in the instance pool
            return $obj;
        }
        if ($con === null) {
            $con = Propel::getServiceContainer()->getReadConnection(AreeTableMap::DATABASE_NAME);
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
     * @return ChildAree A model object, or null if the key is not found
     */
    protected function findPkSimple($key, ConnectionInterface $con)
    {
        $sql = 'SELECT id_area, responsabile, area, attivo FROM aree WHERE id_area = :p0';
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
            /** @var ChildAree $obj */
            $obj = new ChildAree();
            $obj->hydrate($row);
            AreeTableMap::addInstanceToPool($obj, null === $key || is_scalar($key) || is_callable([$key, '__toString']) ? (string) $key : $key);
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
     * @return ChildAree|array|mixed the result, formatted by the current formatter
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
     * @return $this|ChildAreeQuery The current query, for fluid interface
     */
    public function filterByPrimaryKey($key)
    {

        return $this->addUsingAlias(AreeTableMap::COL_ID_AREA, $key, Criteria::EQUAL);
    }

    /**
     * Filter the query by a list of primary keys
     *
     * @param     array $keys The list of primary key to use for the query
     *
     * @return $this|ChildAreeQuery The current query, for fluid interface
     */
    public function filterByPrimaryKeys($keys)
    {

        return $this->addUsingAlias(AreeTableMap::COL_ID_AREA, $keys, Criteria::IN);
    }

    /**
     * Filter the query on the id_area column
     *
     * Example usage:
     * <code>
     * $query->filterByIdArea(1234); // WHERE id_area = 1234
     * $query->filterByIdArea(array(12, 34)); // WHERE id_area IN (12, 34)
     * $query->filterByIdArea(array('min' => 12)); // WHERE id_area > 12
     * </code>
     *
     * @param     mixed $idArea The value to use as filter.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildAreeQuery The current query, for fluid interface
     */
    public function filterByIdArea($idArea = null, $comparison = null)
    {
        if (is_array($idArea)) {
            $useMinMax = false;
            if (isset($idArea['min'])) {
                $this->addUsingAlias(AreeTableMap::COL_ID_AREA, $idArea['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($idArea['max'])) {
                $this->addUsingAlias(AreeTableMap::COL_ID_AREA, $idArea['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(AreeTableMap::COL_ID_AREA, $idArea, $comparison);
    }

    /**
     * Filter the query on the responsabile column
     *
     * Example usage:
     * <code>
     * $query->filterByResponsabile('fooValue');   // WHERE responsabile = 'fooValue'
     * $query->filterByResponsabile('%fooValue%'); // WHERE responsabile LIKE '%fooValue%'
     * </code>
     *
     * @param     string $responsabile The value to use as filter.
     *              Accepts wildcards (* and % trigger a LIKE)
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildAreeQuery The current query, for fluid interface
     */
    public function filterByResponsabile($responsabile = null, $comparison = null)
    {
        if (null === $comparison) {
            if (is_array($responsabile)) {
                $comparison = Criteria::IN;
            } elseif (preg_match('/[\%\*]/', $responsabile)) {
                $responsabile = str_replace('*', '%', $responsabile);
                $comparison = Criteria::LIKE;
            }
        }

        return $this->addUsingAlias(AreeTableMap::COL_RESPONSABILE, $responsabile, $comparison);
    }

    /**
     * Filter the query on the area column
     *
     * Example usage:
     * <code>
     * $query->filterByArea('fooValue');   // WHERE area = 'fooValue'
     * $query->filterByArea('%fooValue%'); // WHERE area LIKE '%fooValue%'
     * </code>
     *
     * @param     string $area The value to use as filter.
     *              Accepts wildcards (* and % trigger a LIKE)
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildAreeQuery The current query, for fluid interface
     */
    public function filterByArea($area = null, $comparison = null)
    {
        if (null === $comparison) {
            if (is_array($area)) {
                $comparison = Criteria::IN;
            } elseif (preg_match('/[\%\*]/', $area)) {
                $area = str_replace('*', '%', $area);
                $comparison = Criteria::LIKE;
            }
        }

        return $this->addUsingAlias(AreeTableMap::COL_AREA, $area, $comparison);
    }

    /**
     * Filter the query on the attivo column
     *
     * Example usage:
     * <code>
     * $query->filterByAttivo('fooValue');   // WHERE attivo = 'fooValue'
     * $query->filterByAttivo('%fooValue%'); // WHERE attivo LIKE '%fooValue%'
     * </code>
     *
     * @param     string $attivo The value to use as filter.
     *              Accepts wildcards (* and % trigger a LIKE)
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildAreeQuery The current query, for fluid interface
     */
    public function filterByAttivo($attivo = null, $comparison = null)
    {
        if (null === $comparison) {
            if (is_array($attivo)) {
                $comparison = Criteria::IN;
            } elseif (preg_match('/[\%\*]/', $attivo)) {
                $attivo = str_replace('*', '%', $attivo);
                $comparison = Criteria::LIKE;
            }
        }

        return $this->addUsingAlias(AreeTableMap::COL_ATTIVO, $attivo, $comparison);
    }

    /**
     * Exclude object from result
     *
     * @param   ChildAree $aree Object to remove from the list of results
     *
     * @return $this|ChildAreeQuery The current query, for fluid interface
     */
    public function prune($aree = null)
    {
        if ($aree) {
            $this->addUsingAlias(AreeTableMap::COL_ID_AREA, $aree->getIdArea(), Criteria::NOT_EQUAL);
        }

        return $this;
    }

    /**
     * Deletes all rows from the aree table.
     *
     * @param ConnectionInterface $con the connection to use
     * @return int The number of affected rows (if supported by underlying database driver).
     */
    public function doDeleteAll(ConnectionInterface $con = null)
    {
        if (null === $con) {
            $con = Propel::getServiceContainer()->getWriteConnection(AreeTableMap::DATABASE_NAME);
        }

        // use transaction because $criteria could contain info
        // for more than one table or we could emulating ON DELETE CASCADE, etc.
        return $con->transaction(function () use ($con) {
            $affectedRows = 0; // initialize var to track total num of affected rows
            $affectedRows += parent::doDeleteAll($con);
            // Because this db requires some delete cascade/set null emulation, we have to
            // clear the cached instance *after* the emulation has happened (since
            // instances get re-added by the select statement contained therein).
            AreeTableMap::clearInstancePool();
            AreeTableMap::clearRelatedInstancePool();

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
            $con = Propel::getServiceContainer()->getWriteConnection(AreeTableMap::DATABASE_NAME);
        }

        $criteria = $this;

        // Set the correct dbName
        $criteria->setDbName(AreeTableMap::DATABASE_NAME);

        // use transaction because $criteria could contain info
        // for more than one table or we could emulating ON DELETE CASCADE, etc.
        return $con->transaction(function () use ($con, $criteria) {
            $affectedRows = 0; // initialize var to track total num of affected rows

            AreeTableMap::removeInstanceFromPool($criteria);

            $affectedRows += ModelCriteria::delete($con);
            AreeTableMap::clearRelatedInstancePool();

            return $affectedRows;
        });
    }

} // AreeQuery

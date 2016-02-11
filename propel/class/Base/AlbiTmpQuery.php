<?php

namespace Base;

use \AlbiTmp as ChildAlbiTmp;
use \AlbiTmpQuery as ChildAlbiTmpQuery;
use \Exception;
use \PDO;
use Map\AlbiTmpTableMap;
use Propel\Runtime\Propel;
use Propel\Runtime\ActiveQuery\Criteria;
use Propel\Runtime\ActiveQuery\ModelCriteria;
use Propel\Runtime\Collection\ObjectCollection;
use Propel\Runtime\Connection\ConnectionInterface;
use Propel\Runtime\Exception\PropelException;

/**
 * Base class that represents a query for the 'albi_tmp' table.
 *
 *
 *
 * @method     ChildAlbiTmpQuery orderByIdAlbo($order = Criteria::ASC) Order by the id_albo column
 * @method     ChildAlbiTmpQuery orderByIdTipo($order = Criteria::ASC) Order by the id_tipo column
 * @method     ChildAlbiTmpQuery orderByDtPubblicazDal($order = Criteria::ASC) Order by the dt_pubblicaz_dal column
 * @method     ChildAlbiTmpQuery orderByDtPubblicazAl($order = Criteria::ASC) Order by the dt_pubblicaz_al column
 * @method     ChildAlbiTmpQuery orderByDtAtto($order = Criteria::ASC) Order by the dt_atto column
 * @method     ChildAlbiTmpQuery orderByNrAtto($order = Criteria::ASC) Order by the nr_atto column
 * @method     ChildAlbiTmpQuery orderByOggetto($order = Criteria::ASC) Order by the oggetto column
 * @method     ChildAlbiTmpQuery orderByAutoritaEmanante($order = Criteria::ASC) Order by the autorita_emanante column
 * @method     ChildAlbiTmpQuery orderByIdArea($order = Criteria::ASC) Order by the id_area column
 * @method     ChildAlbiTmpQuery orderByFile($order = Criteria::ASC) Order by the file column
 *
 * @method     ChildAlbiTmpQuery groupByIdAlbo() Group by the id_albo column
 * @method     ChildAlbiTmpQuery groupByIdTipo() Group by the id_tipo column
 * @method     ChildAlbiTmpQuery groupByDtPubblicazDal() Group by the dt_pubblicaz_dal column
 * @method     ChildAlbiTmpQuery groupByDtPubblicazAl() Group by the dt_pubblicaz_al column
 * @method     ChildAlbiTmpQuery groupByDtAtto() Group by the dt_atto column
 * @method     ChildAlbiTmpQuery groupByNrAtto() Group by the nr_atto column
 * @method     ChildAlbiTmpQuery groupByOggetto() Group by the oggetto column
 * @method     ChildAlbiTmpQuery groupByAutoritaEmanante() Group by the autorita_emanante column
 * @method     ChildAlbiTmpQuery groupByIdArea() Group by the id_area column
 * @method     ChildAlbiTmpQuery groupByFile() Group by the file column
 *
 * @method     ChildAlbiTmpQuery leftJoin($relation) Adds a LEFT JOIN clause to the query
 * @method     ChildAlbiTmpQuery rightJoin($relation) Adds a RIGHT JOIN clause to the query
 * @method     ChildAlbiTmpQuery innerJoin($relation) Adds a INNER JOIN clause to the query
 *
 * @method     ChildAlbiTmpQuery leftJoinWith($relation) Adds a LEFT JOIN clause and with to the query
 * @method     ChildAlbiTmpQuery rightJoinWith($relation) Adds a RIGHT JOIN clause and with to the query
 * @method     ChildAlbiTmpQuery innerJoinWith($relation) Adds a INNER JOIN clause and with to the query
 *
 * @method     ChildAlbiTmp findOne(ConnectionInterface $con = null) Return the first ChildAlbiTmp matching the query
 * @method     ChildAlbiTmp findOneOrCreate(ConnectionInterface $con = null) Return the first ChildAlbiTmp matching the query, or a new ChildAlbiTmp object populated from the query conditions when no match is found
 *
 * @method     ChildAlbiTmp findOneByIdAlbo(int $id_albo) Return the first ChildAlbiTmp filtered by the id_albo column
 * @method     ChildAlbiTmp findOneByIdTipo(int $id_tipo) Return the first ChildAlbiTmp filtered by the id_tipo column
 * @method     ChildAlbiTmp findOneByDtPubblicazDal(string $dt_pubblicaz_dal) Return the first ChildAlbiTmp filtered by the dt_pubblicaz_dal column
 * @method     ChildAlbiTmp findOneByDtPubblicazAl(string $dt_pubblicaz_al) Return the first ChildAlbiTmp filtered by the dt_pubblicaz_al column
 * @method     ChildAlbiTmp findOneByDtAtto(string $dt_atto) Return the first ChildAlbiTmp filtered by the dt_atto column
 * @method     ChildAlbiTmp findOneByNrAtto(int $nr_atto) Return the first ChildAlbiTmp filtered by the nr_atto column
 * @method     ChildAlbiTmp findOneByOggetto(string $oggetto) Return the first ChildAlbiTmp filtered by the oggetto column
 * @method     ChildAlbiTmp findOneByAutoritaEmanante(string $autorita_emanante) Return the first ChildAlbiTmp filtered by the autorita_emanante column
 * @method     ChildAlbiTmp findOneByIdArea(int $id_area) Return the first ChildAlbiTmp filtered by the id_area column
 * @method     ChildAlbiTmp findOneByFile(string $file) Return the first ChildAlbiTmp filtered by the file column *

 * @method     ChildAlbiTmp requirePk($key, ConnectionInterface $con = null) Return the ChildAlbiTmp by primary key and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildAlbiTmp requireOne(ConnectionInterface $con = null) Return the first ChildAlbiTmp matching the query and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 *
 * @method     ChildAlbiTmp requireOneByIdAlbo(int $id_albo) Return the first ChildAlbiTmp filtered by the id_albo column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildAlbiTmp requireOneByIdTipo(int $id_tipo) Return the first ChildAlbiTmp filtered by the id_tipo column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildAlbiTmp requireOneByDtPubblicazDal(string $dt_pubblicaz_dal) Return the first ChildAlbiTmp filtered by the dt_pubblicaz_dal column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildAlbiTmp requireOneByDtPubblicazAl(string $dt_pubblicaz_al) Return the first ChildAlbiTmp filtered by the dt_pubblicaz_al column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildAlbiTmp requireOneByDtAtto(string $dt_atto) Return the first ChildAlbiTmp filtered by the dt_atto column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildAlbiTmp requireOneByNrAtto(int $nr_atto) Return the first ChildAlbiTmp filtered by the nr_atto column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildAlbiTmp requireOneByOggetto(string $oggetto) Return the first ChildAlbiTmp filtered by the oggetto column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildAlbiTmp requireOneByAutoritaEmanante(string $autorita_emanante) Return the first ChildAlbiTmp filtered by the autorita_emanante column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildAlbiTmp requireOneByIdArea(int $id_area) Return the first ChildAlbiTmp filtered by the id_area column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildAlbiTmp requireOneByFile(string $file) Return the first ChildAlbiTmp filtered by the file column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 *
 * @method     ChildAlbiTmp[]|ObjectCollection find(ConnectionInterface $con = null) Return ChildAlbiTmp objects based on current ModelCriteria
 * @method     ChildAlbiTmp[]|ObjectCollection findByIdAlbo(int $id_albo) Return ChildAlbiTmp objects filtered by the id_albo column
 * @method     ChildAlbiTmp[]|ObjectCollection findByIdTipo(int $id_tipo) Return ChildAlbiTmp objects filtered by the id_tipo column
 * @method     ChildAlbiTmp[]|ObjectCollection findByDtPubblicazDal(string $dt_pubblicaz_dal) Return ChildAlbiTmp objects filtered by the dt_pubblicaz_dal column
 * @method     ChildAlbiTmp[]|ObjectCollection findByDtPubblicazAl(string $dt_pubblicaz_al) Return ChildAlbiTmp objects filtered by the dt_pubblicaz_al column
 * @method     ChildAlbiTmp[]|ObjectCollection findByDtAtto(string $dt_atto) Return ChildAlbiTmp objects filtered by the dt_atto column
 * @method     ChildAlbiTmp[]|ObjectCollection findByNrAtto(int $nr_atto) Return ChildAlbiTmp objects filtered by the nr_atto column
 * @method     ChildAlbiTmp[]|ObjectCollection findByOggetto(string $oggetto) Return ChildAlbiTmp objects filtered by the oggetto column
 * @method     ChildAlbiTmp[]|ObjectCollection findByAutoritaEmanante(string $autorita_emanante) Return ChildAlbiTmp objects filtered by the autorita_emanante column
 * @method     ChildAlbiTmp[]|ObjectCollection findByIdArea(int $id_area) Return ChildAlbiTmp objects filtered by the id_area column
 * @method     ChildAlbiTmp[]|ObjectCollection findByFile(string $file) Return ChildAlbiTmp objects filtered by the file column
 * @method     ChildAlbiTmp[]|\Propel\Runtime\Util\PropelModelPager paginate($page = 1, $maxPerPage = 10, ConnectionInterface $con = null) Issue a SELECT query based on the current ModelCriteria and uses a page and a maximum number of results per page to compute an offset and a limit
 *
 */
abstract class AlbiTmpQuery extends ModelCriteria
{
    protected $entityNotFoundExceptionClass = '\\Propel\\Runtime\\Exception\\EntityNotFoundException';

    /**
     * Initializes internal state of \Base\AlbiTmpQuery object.
     *
     * @param     string $dbName The database name
     * @param     string $modelName The phpName of a model, e.g. 'Book'
     * @param     string $modelAlias The alias for the model in this query, e.g. 'b'
     */
    public function __construct($dbName = 'default', $modelName = '\\AlbiTmp', $modelAlias = null)
    {
        parent::__construct($dbName, $modelName, $modelAlias);
    }

    /**
     * Returns a new ChildAlbiTmpQuery object.
     *
     * @param     string $modelAlias The alias of a model in the query
     * @param     Criteria $criteria Optional Criteria to build the query from
     *
     * @return ChildAlbiTmpQuery
     */
    public static function create($modelAlias = null, Criteria $criteria = null)
    {
        if ($criteria instanceof ChildAlbiTmpQuery) {
            return $criteria;
        }
        $query = new ChildAlbiTmpQuery();
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
     * @return ChildAlbiTmp|array|mixed the result, formatted by the current formatter
     */
    public function findPk($key, ConnectionInterface $con = null)
    {
        if ($key === null) {
            return null;
        }
        if ((null !== ($obj = AlbiTmpTableMap::getInstanceFromPool(null === $key || is_scalar($key) || is_callable([$key, '__toString']) ? (string) $key : $key))) && !$this->formatter) {
            // the object is already in the instance pool
            return $obj;
        }
        if ($con === null) {
            $con = Propel::getServiceContainer()->getReadConnection(AlbiTmpTableMap::DATABASE_NAME);
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
     * @return ChildAlbiTmp A model object, or null if the key is not found
     */
    protected function findPkSimple($key, ConnectionInterface $con)
    {
        $sql = 'SELECT id_albo, id_tipo, dt_pubblicaz_dal, dt_pubblicaz_al, dt_atto, nr_atto, oggetto, autorita_emanante, id_area, file FROM albi_tmp WHERE id_albo = :p0';
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
            /** @var ChildAlbiTmp $obj */
            $obj = new ChildAlbiTmp();
            $obj->hydrate($row);
            AlbiTmpTableMap::addInstanceToPool($obj, null === $key || is_scalar($key) || is_callable([$key, '__toString']) ? (string) $key : $key);
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
     * @return ChildAlbiTmp|array|mixed the result, formatted by the current formatter
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
     * @return $this|ChildAlbiTmpQuery The current query, for fluid interface
     */
    public function filterByPrimaryKey($key)
    {

        return $this->addUsingAlias(AlbiTmpTableMap::COL_ID_ALBO, $key, Criteria::EQUAL);
    }

    /**
     * Filter the query by a list of primary keys
     *
     * @param     array $keys The list of primary key to use for the query
     *
     * @return $this|ChildAlbiTmpQuery The current query, for fluid interface
     */
    public function filterByPrimaryKeys($keys)
    {

        return $this->addUsingAlias(AlbiTmpTableMap::COL_ID_ALBO, $keys, Criteria::IN);
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
     * @return $this|ChildAlbiTmpQuery The current query, for fluid interface
     */
    public function filterByIdAlbo($idAlbo = null, $comparison = null)
    {
        if (is_array($idAlbo)) {
            $useMinMax = false;
            if (isset($idAlbo['min'])) {
                $this->addUsingAlias(AlbiTmpTableMap::COL_ID_ALBO, $idAlbo['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($idAlbo['max'])) {
                $this->addUsingAlias(AlbiTmpTableMap::COL_ID_ALBO, $idAlbo['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(AlbiTmpTableMap::COL_ID_ALBO, $idAlbo, $comparison);
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
     * @return $this|ChildAlbiTmpQuery The current query, for fluid interface
     */
    public function filterByIdTipo($idTipo = null, $comparison = null)
    {
        if (is_array($idTipo)) {
            $useMinMax = false;
            if (isset($idTipo['min'])) {
                $this->addUsingAlias(AlbiTmpTableMap::COL_ID_TIPO, $idTipo['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($idTipo['max'])) {
                $this->addUsingAlias(AlbiTmpTableMap::COL_ID_TIPO, $idTipo['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(AlbiTmpTableMap::COL_ID_TIPO, $idTipo, $comparison);
    }

    /**
     * Filter the query on the dt_pubblicaz_dal column
     *
     * Example usage:
     * <code>
     * $query->filterByDtPubblicazDal('2011-03-14'); // WHERE dt_pubblicaz_dal = '2011-03-14'
     * $query->filterByDtPubblicazDal('now'); // WHERE dt_pubblicaz_dal = '2011-03-14'
     * $query->filterByDtPubblicazDal(array('max' => 'yesterday')); // WHERE dt_pubblicaz_dal > '2011-03-13'
     * </code>
     *
     * @param     mixed $dtPubblicazDal The value to use as filter.
     *              Values can be integers (unix timestamps), DateTime objects, or strings.
     *              Empty strings are treated as NULL.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildAlbiTmpQuery The current query, for fluid interface
     */
    public function filterByDtPubblicazDal($dtPubblicazDal = null, $comparison = null)
    {
        if (is_array($dtPubblicazDal)) {
            $useMinMax = false;
            if (isset($dtPubblicazDal['min'])) {
                $this->addUsingAlias(AlbiTmpTableMap::COL_DT_PUBBLICAZ_DAL, $dtPubblicazDal['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($dtPubblicazDal['max'])) {
                $this->addUsingAlias(AlbiTmpTableMap::COL_DT_PUBBLICAZ_DAL, $dtPubblicazDal['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(AlbiTmpTableMap::COL_DT_PUBBLICAZ_DAL, $dtPubblicazDal, $comparison);
    }

    /**
     * Filter the query on the dt_pubblicaz_al column
     *
     * Example usage:
     * <code>
     * $query->filterByDtPubblicazAl('2011-03-14'); // WHERE dt_pubblicaz_al = '2011-03-14'
     * $query->filterByDtPubblicazAl('now'); // WHERE dt_pubblicaz_al = '2011-03-14'
     * $query->filterByDtPubblicazAl(array('max' => 'yesterday')); // WHERE dt_pubblicaz_al > '2011-03-13'
     * </code>
     *
     * @param     mixed $dtPubblicazAl The value to use as filter.
     *              Values can be integers (unix timestamps), DateTime objects, or strings.
     *              Empty strings are treated as NULL.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildAlbiTmpQuery The current query, for fluid interface
     */
    public function filterByDtPubblicazAl($dtPubblicazAl = null, $comparison = null)
    {
        if (is_array($dtPubblicazAl)) {
            $useMinMax = false;
            if (isset($dtPubblicazAl['min'])) {
                $this->addUsingAlias(AlbiTmpTableMap::COL_DT_PUBBLICAZ_AL, $dtPubblicazAl['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($dtPubblicazAl['max'])) {
                $this->addUsingAlias(AlbiTmpTableMap::COL_DT_PUBBLICAZ_AL, $dtPubblicazAl['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(AlbiTmpTableMap::COL_DT_PUBBLICAZ_AL, $dtPubblicazAl, $comparison);
    }

    /**
     * Filter the query on the dt_atto column
     *
     * Example usage:
     * <code>
     * $query->filterByDtAtto('2011-03-14'); // WHERE dt_atto = '2011-03-14'
     * $query->filterByDtAtto('now'); // WHERE dt_atto = '2011-03-14'
     * $query->filterByDtAtto(array('max' => 'yesterday')); // WHERE dt_atto > '2011-03-13'
     * </code>
     *
     * @param     mixed $dtAtto The value to use as filter.
     *              Values can be integers (unix timestamps), DateTime objects, or strings.
     *              Empty strings are treated as NULL.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildAlbiTmpQuery The current query, for fluid interface
     */
    public function filterByDtAtto($dtAtto = null, $comparison = null)
    {
        if (is_array($dtAtto)) {
            $useMinMax = false;
            if (isset($dtAtto['min'])) {
                $this->addUsingAlias(AlbiTmpTableMap::COL_DT_ATTO, $dtAtto['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($dtAtto['max'])) {
                $this->addUsingAlias(AlbiTmpTableMap::COL_DT_ATTO, $dtAtto['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(AlbiTmpTableMap::COL_DT_ATTO, $dtAtto, $comparison);
    }

    /**
     * Filter the query on the nr_atto column
     *
     * Example usage:
     * <code>
     * $query->filterByNrAtto(1234); // WHERE nr_atto = 1234
     * $query->filterByNrAtto(array(12, 34)); // WHERE nr_atto IN (12, 34)
     * $query->filterByNrAtto(array('min' => 12)); // WHERE nr_atto > 12
     * </code>
     *
     * @param     mixed $nrAtto The value to use as filter.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildAlbiTmpQuery The current query, for fluid interface
     */
    public function filterByNrAtto($nrAtto = null, $comparison = null)
    {
        if (is_array($nrAtto)) {
            $useMinMax = false;
            if (isset($nrAtto['min'])) {
                $this->addUsingAlias(AlbiTmpTableMap::COL_NR_ATTO, $nrAtto['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($nrAtto['max'])) {
                $this->addUsingAlias(AlbiTmpTableMap::COL_NR_ATTO, $nrAtto['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(AlbiTmpTableMap::COL_NR_ATTO, $nrAtto, $comparison);
    }

    /**
     * Filter the query on the oggetto column
     *
     * Example usage:
     * <code>
     * $query->filterByOggetto('fooValue');   // WHERE oggetto = 'fooValue'
     * $query->filterByOggetto('%fooValue%'); // WHERE oggetto LIKE '%fooValue%'
     * </code>
     *
     * @param     string $oggetto The value to use as filter.
     *              Accepts wildcards (* and % trigger a LIKE)
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildAlbiTmpQuery The current query, for fluid interface
     */
    public function filterByOggetto($oggetto = null, $comparison = null)
    {
        if (null === $comparison) {
            if (is_array($oggetto)) {
                $comparison = Criteria::IN;
            } elseif (preg_match('/[\%\*]/', $oggetto)) {
                $oggetto = str_replace('*', '%', $oggetto);
                $comparison = Criteria::LIKE;
            }
        }

        return $this->addUsingAlias(AlbiTmpTableMap::COL_OGGETTO, $oggetto, $comparison);
    }

    /**
     * Filter the query on the autorita_emanante column
     *
     * Example usage:
     * <code>
     * $query->filterByAutoritaEmanante('fooValue');   // WHERE autorita_emanante = 'fooValue'
     * $query->filterByAutoritaEmanante('%fooValue%'); // WHERE autorita_emanante LIKE '%fooValue%'
     * </code>
     *
     * @param     string $autoritaEmanante The value to use as filter.
     *              Accepts wildcards (* and % trigger a LIKE)
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildAlbiTmpQuery The current query, for fluid interface
     */
    public function filterByAutoritaEmanante($autoritaEmanante = null, $comparison = null)
    {
        if (null === $comparison) {
            if (is_array($autoritaEmanante)) {
                $comparison = Criteria::IN;
            } elseif (preg_match('/[\%\*]/', $autoritaEmanante)) {
                $autoritaEmanante = str_replace('*', '%', $autoritaEmanante);
                $comparison = Criteria::LIKE;
            }
        }

        return $this->addUsingAlias(AlbiTmpTableMap::COL_AUTORITA_EMANANTE, $autoritaEmanante, $comparison);
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
     * @return $this|ChildAlbiTmpQuery The current query, for fluid interface
     */
    public function filterByIdArea($idArea = null, $comparison = null)
    {
        if (is_array($idArea)) {
            $useMinMax = false;
            if (isset($idArea['min'])) {
                $this->addUsingAlias(AlbiTmpTableMap::COL_ID_AREA, $idArea['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($idArea['max'])) {
                $this->addUsingAlias(AlbiTmpTableMap::COL_ID_AREA, $idArea['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(AlbiTmpTableMap::COL_ID_AREA, $idArea, $comparison);
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
     * @return $this|ChildAlbiTmpQuery The current query, for fluid interface
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

        return $this->addUsingAlias(AlbiTmpTableMap::COL_FILE, $file, $comparison);
    }

    /**
     * Exclude object from result
     *
     * @param   ChildAlbiTmp $albiTmp Object to remove from the list of results
     *
     * @return $this|ChildAlbiTmpQuery The current query, for fluid interface
     */
    public function prune($albiTmp = null)
    {
        if ($albiTmp) {
            $this->addUsingAlias(AlbiTmpTableMap::COL_ID_ALBO, $albiTmp->getIdAlbo(), Criteria::NOT_EQUAL);
        }

        return $this;
    }

    /**
     * Deletes all rows from the albi_tmp table.
     *
     * @param ConnectionInterface $con the connection to use
     * @return int The number of affected rows (if supported by underlying database driver).
     */
    public function doDeleteAll(ConnectionInterface $con = null)
    {
        if (null === $con) {
            $con = Propel::getServiceContainer()->getWriteConnection(AlbiTmpTableMap::DATABASE_NAME);
        }

        // use transaction because $criteria could contain info
        // for more than one table or we could emulating ON DELETE CASCADE, etc.
        return $con->transaction(function () use ($con) {
            $affectedRows = 0; // initialize var to track total num of affected rows
            $affectedRows += parent::doDeleteAll($con);
            // Because this db requires some delete cascade/set null emulation, we have to
            // clear the cached instance *after* the emulation has happened (since
            // instances get re-added by the select statement contained therein).
            AlbiTmpTableMap::clearInstancePool();
            AlbiTmpTableMap::clearRelatedInstancePool();

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
            $con = Propel::getServiceContainer()->getWriteConnection(AlbiTmpTableMap::DATABASE_NAME);
        }

        $criteria = $this;

        // Set the correct dbName
        $criteria->setDbName(AlbiTmpTableMap::DATABASE_NAME);

        // use transaction because $criteria could contain info
        // for more than one table or we could emulating ON DELETE CASCADE, etc.
        return $con->transaction(function () use ($con, $criteria) {
            $affectedRows = 0; // initialize var to track total num of affected rows

            AlbiTmpTableMap::removeInstanceFromPool($criteria);

            $affectedRows += ModelCriteria::delete($con);
            AlbiTmpTableMap::clearRelatedInstancePool();

            return $affectedRows;
        });
    }

} // AlbiTmpQuery

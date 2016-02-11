<?php

namespace Base;

use \Albi as ChildAlbi;
use \AlbiQuery as ChildAlbiQuery;
use \Exception;
use \PDO;
use Map\AlbiTableMap;
use Propel\Runtime\Propel;
use Propel\Runtime\ActiveQuery\Criteria;
use Propel\Runtime\ActiveQuery\ModelCriteria;
use Propel\Runtime\Collection\ObjectCollection;
use Propel\Runtime\Connection\ConnectionInterface;
use Propel\Runtime\Exception\PropelException;

/**
 * Base class that represents a query for the 'albi' table.
 *
 *
 *
 * @method     ChildAlbiQuery orderByIdAlbo($order = Criteria::ASC) Order by the id_albo column
 * @method     ChildAlbiQuery orderByIdTipo($order = Criteria::ASC) Order by the id_tipo column
 * @method     ChildAlbiQuery orderByIdTipoDetermina($order = Criteria::ASC) Order by the id_tipo_determina column
 * @method     ChildAlbiQuery orderByIdTipoTrasp($order = Criteria::ASC) Order by the id_tipo_trasp column
 * @method     ChildAlbiQuery orderByDtPubblicazDal($order = Criteria::ASC) Order by the dt_pubblicaz_dal column
 * @method     ChildAlbiQuery orderByDtPubblicazAl($order = Criteria::ASC) Order by the dt_pubblicaz_al column
 * @method     ChildAlbiQuery orderByDtAtto($order = Criteria::ASC) Order by the dt_atto column
 * @method     ChildAlbiQuery orderByNrAtto($order = Criteria::ASC) Order by the nr_atto column
 * @method     ChildAlbiQuery orderByOggetto($order = Criteria::ASC) Order by the oggetto column
 * @method     ChildAlbiQuery orderByAutoritaEmanante($order = Criteria::ASC) Order by the autorita_emanante column
 * @method     ChildAlbiQuery orderBySpesaPrevista($order = Criteria::ASC) Order by the spesa_prevista column
 * @method     ChildAlbiQuery orderByIdArea($order = Criteria::ASC) Order by the id_area column
 * @method     ChildAlbiQuery orderBySerialize($order = Criteria::ASC) Order by the serialize column
 * @method     ChildAlbiQuery orderByDaValidare($order = Criteria::ASC) Order by the da_validare column
 * @method     ChildAlbiQuery orderByNote($order = Criteria::ASC) Order by the note column
 * @method     ChildAlbiQuery orderByManuale($order = Criteria::ASC) Order by the manuale column
 *
 * @method     ChildAlbiQuery groupByIdAlbo() Group by the id_albo column
 * @method     ChildAlbiQuery groupByIdTipo() Group by the id_tipo column
 * @method     ChildAlbiQuery groupByIdTipoDetermina() Group by the id_tipo_determina column
 * @method     ChildAlbiQuery groupByIdTipoTrasp() Group by the id_tipo_trasp column
 * @method     ChildAlbiQuery groupByDtPubblicazDal() Group by the dt_pubblicaz_dal column
 * @method     ChildAlbiQuery groupByDtPubblicazAl() Group by the dt_pubblicaz_al column
 * @method     ChildAlbiQuery groupByDtAtto() Group by the dt_atto column
 * @method     ChildAlbiQuery groupByNrAtto() Group by the nr_atto column
 * @method     ChildAlbiQuery groupByOggetto() Group by the oggetto column
 * @method     ChildAlbiQuery groupByAutoritaEmanante() Group by the autorita_emanante column
 * @method     ChildAlbiQuery groupBySpesaPrevista() Group by the spesa_prevista column
 * @method     ChildAlbiQuery groupByIdArea() Group by the id_area column
 * @method     ChildAlbiQuery groupBySerialize() Group by the serialize column
 * @method     ChildAlbiQuery groupByDaValidare() Group by the da_validare column
 * @method     ChildAlbiQuery groupByNote() Group by the note column
 * @method     ChildAlbiQuery groupByManuale() Group by the manuale column
 *
 * @method     ChildAlbiQuery leftJoin($relation) Adds a LEFT JOIN clause to the query
 * @method     ChildAlbiQuery rightJoin($relation) Adds a RIGHT JOIN clause to the query
 * @method     ChildAlbiQuery innerJoin($relation) Adds a INNER JOIN clause to the query
 *
 * @method     ChildAlbiQuery leftJoinWith($relation) Adds a LEFT JOIN clause and with to the query
 * @method     ChildAlbiQuery rightJoinWith($relation) Adds a RIGHT JOIN clause and with to the query
 * @method     ChildAlbiQuery innerJoinWith($relation) Adds a INNER JOIN clause and with to the query
 *
 * @method     ChildAlbi findOne(ConnectionInterface $con = null) Return the first ChildAlbi matching the query
 * @method     ChildAlbi findOneOrCreate(ConnectionInterface $con = null) Return the first ChildAlbi matching the query, or a new ChildAlbi object populated from the query conditions when no match is found
 *
 * @method     ChildAlbi findOneByIdAlbo(int $id_albo) Return the first ChildAlbi filtered by the id_albo column
 * @method     ChildAlbi findOneByIdTipo(int $id_tipo) Return the first ChildAlbi filtered by the id_tipo column
 * @method     ChildAlbi findOneByIdTipoDetermina(int $id_tipo_determina) Return the first ChildAlbi filtered by the id_tipo_determina column
 * @method     ChildAlbi findOneByIdTipoTrasp(int $id_tipo_trasp) Return the first ChildAlbi filtered by the id_tipo_trasp column
 * @method     ChildAlbi findOneByDtPubblicazDal(string $dt_pubblicaz_dal) Return the first ChildAlbi filtered by the dt_pubblicaz_dal column
 * @method     ChildAlbi findOneByDtPubblicazAl(string $dt_pubblicaz_al) Return the first ChildAlbi filtered by the dt_pubblicaz_al column
 * @method     ChildAlbi findOneByDtAtto(string $dt_atto) Return the first ChildAlbi filtered by the dt_atto column
 * @method     ChildAlbi findOneByNrAtto(int $nr_atto) Return the first ChildAlbi filtered by the nr_atto column
 * @method     ChildAlbi findOneByOggetto(string $oggetto) Return the first ChildAlbi filtered by the oggetto column
 * @method     ChildAlbi findOneByAutoritaEmanante(string $autorita_emanante) Return the first ChildAlbi filtered by the autorita_emanante column
 * @method     ChildAlbi findOneBySpesaPrevista(string $spesa_prevista) Return the first ChildAlbi filtered by the spesa_prevista column
 * @method     ChildAlbi findOneByIdArea(int $id_area) Return the first ChildAlbi filtered by the id_area column
 * @method     ChildAlbi findOneBySerialize(string $serialize) Return the first ChildAlbi filtered by the serialize column
 * @method     ChildAlbi findOneByDaValidare(string $da_validare) Return the first ChildAlbi filtered by the da_validare column
 * @method     ChildAlbi findOneByNote(string $note) Return the first ChildAlbi filtered by the note column
 * @method     ChildAlbi findOneByManuale(string $manuale) Return the first ChildAlbi filtered by the manuale column *

 * @method     ChildAlbi requirePk($key, ConnectionInterface $con = null) Return the ChildAlbi by primary key and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildAlbi requireOne(ConnectionInterface $con = null) Return the first ChildAlbi matching the query and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 *
 * @method     ChildAlbi requireOneByIdAlbo(int $id_albo) Return the first ChildAlbi filtered by the id_albo column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildAlbi requireOneByIdTipo(int $id_tipo) Return the first ChildAlbi filtered by the id_tipo column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildAlbi requireOneByIdTipoDetermina(int $id_tipo_determina) Return the first ChildAlbi filtered by the id_tipo_determina column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildAlbi requireOneByIdTipoTrasp(int $id_tipo_trasp) Return the first ChildAlbi filtered by the id_tipo_trasp column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildAlbi requireOneByDtPubblicazDal(string $dt_pubblicaz_dal) Return the first ChildAlbi filtered by the dt_pubblicaz_dal column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildAlbi requireOneByDtPubblicazAl(string $dt_pubblicaz_al) Return the first ChildAlbi filtered by the dt_pubblicaz_al column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildAlbi requireOneByDtAtto(string $dt_atto) Return the first ChildAlbi filtered by the dt_atto column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildAlbi requireOneByNrAtto(int $nr_atto) Return the first ChildAlbi filtered by the nr_atto column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildAlbi requireOneByOggetto(string $oggetto) Return the first ChildAlbi filtered by the oggetto column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildAlbi requireOneByAutoritaEmanante(string $autorita_emanante) Return the first ChildAlbi filtered by the autorita_emanante column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildAlbi requireOneBySpesaPrevista(string $spesa_prevista) Return the first ChildAlbi filtered by the spesa_prevista column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildAlbi requireOneByIdArea(int $id_area) Return the first ChildAlbi filtered by the id_area column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildAlbi requireOneBySerialize(string $serialize) Return the first ChildAlbi filtered by the serialize column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildAlbi requireOneByDaValidare(string $da_validare) Return the first ChildAlbi filtered by the da_validare column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildAlbi requireOneByNote(string $note) Return the first ChildAlbi filtered by the note column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildAlbi requireOneByManuale(string $manuale) Return the first ChildAlbi filtered by the manuale column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 *
 * @method     ChildAlbi[]|ObjectCollection find(ConnectionInterface $con = null) Return ChildAlbi objects based on current ModelCriteria
 * @method     ChildAlbi[]|ObjectCollection findByIdAlbo(int $id_albo) Return ChildAlbi objects filtered by the id_albo column
 * @method     ChildAlbi[]|ObjectCollection findByIdTipo(int $id_tipo) Return ChildAlbi objects filtered by the id_tipo column
 * @method     ChildAlbi[]|ObjectCollection findByIdTipoDetermina(int $id_tipo_determina) Return ChildAlbi objects filtered by the id_tipo_determina column
 * @method     ChildAlbi[]|ObjectCollection findByIdTipoTrasp(int $id_tipo_trasp) Return ChildAlbi objects filtered by the id_tipo_trasp column
 * @method     ChildAlbi[]|ObjectCollection findByDtPubblicazDal(string $dt_pubblicaz_dal) Return ChildAlbi objects filtered by the dt_pubblicaz_dal column
 * @method     ChildAlbi[]|ObjectCollection findByDtPubblicazAl(string $dt_pubblicaz_al) Return ChildAlbi objects filtered by the dt_pubblicaz_al column
 * @method     ChildAlbi[]|ObjectCollection findByDtAtto(string $dt_atto) Return ChildAlbi objects filtered by the dt_atto column
 * @method     ChildAlbi[]|ObjectCollection findByNrAtto(int $nr_atto) Return ChildAlbi objects filtered by the nr_atto column
 * @method     ChildAlbi[]|ObjectCollection findByOggetto(string $oggetto) Return ChildAlbi objects filtered by the oggetto column
 * @method     ChildAlbi[]|ObjectCollection findByAutoritaEmanante(string $autorita_emanante) Return ChildAlbi objects filtered by the autorita_emanante column
 * @method     ChildAlbi[]|ObjectCollection findBySpesaPrevista(string $spesa_prevista) Return ChildAlbi objects filtered by the spesa_prevista column
 * @method     ChildAlbi[]|ObjectCollection findByIdArea(int $id_area) Return ChildAlbi objects filtered by the id_area column
 * @method     ChildAlbi[]|ObjectCollection findBySerialize(string $serialize) Return ChildAlbi objects filtered by the serialize column
 * @method     ChildAlbi[]|ObjectCollection findByDaValidare(string $da_validare) Return ChildAlbi objects filtered by the da_validare column
 * @method     ChildAlbi[]|ObjectCollection findByNote(string $note) Return ChildAlbi objects filtered by the note column
 * @method     ChildAlbi[]|ObjectCollection findByManuale(string $manuale) Return ChildAlbi objects filtered by the manuale column
 * @method     ChildAlbi[]|\Propel\Runtime\Util\PropelModelPager paginate($page = 1, $maxPerPage = 10, ConnectionInterface $con = null) Issue a SELECT query based on the current ModelCriteria and uses a page and a maximum number of results per page to compute an offset and a limit
 *
 */
abstract class AlbiQuery extends ModelCriteria
{
    protected $entityNotFoundExceptionClass = '\\Propel\\Runtime\\Exception\\EntityNotFoundException';

    /**
     * Initializes internal state of \Base\AlbiQuery object.
     *
     * @param     string $dbName The database name
     * @param     string $modelName The phpName of a model, e.g. 'Book'
     * @param     string $modelAlias The alias for the model in this query, e.g. 'b'
     */
    public function __construct($dbName = 'default', $modelName = '\\Albi', $modelAlias = null)
    {
        parent::__construct($dbName, $modelName, $modelAlias);
    }

    /**
     * Returns a new ChildAlbiQuery object.
     *
     * @param     string $modelAlias The alias of a model in the query
     * @param     Criteria $criteria Optional Criteria to build the query from
     *
     * @return ChildAlbiQuery
     */
    public static function create($modelAlias = null, Criteria $criteria = null)
    {
        if ($criteria instanceof ChildAlbiQuery) {
            return $criteria;
        }
        $query = new ChildAlbiQuery();
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
     * @return ChildAlbi|array|mixed the result, formatted by the current formatter
     */
    public function findPk($key, ConnectionInterface $con = null)
    {
        if ($key === null) {
            return null;
        }
        if ((null !== ($obj = AlbiTableMap::getInstanceFromPool(null === $key || is_scalar($key) || is_callable([$key, '__toString']) ? (string) $key : $key))) && !$this->formatter) {
            // the object is already in the instance pool
            return $obj;
        }
        if ($con === null) {
            $con = Propel::getServiceContainer()->getReadConnection(AlbiTableMap::DATABASE_NAME);
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
     * @return ChildAlbi A model object, or null if the key is not found
     */
    protected function findPkSimple($key, ConnectionInterface $con)
    {
        $sql = 'SELECT id_albo, id_tipo, id_tipo_determina, id_tipo_trasp, dt_pubblicaz_dal, dt_pubblicaz_al, dt_atto, nr_atto, oggetto, autorita_emanante, spesa_prevista, id_area, serialize, da_validare, note, manuale FROM albi WHERE id_albo = :p0';
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
            /** @var ChildAlbi $obj */
            $obj = new ChildAlbi();
            $obj->hydrate($row);
            AlbiTableMap::addInstanceToPool($obj, null === $key || is_scalar($key) || is_callable([$key, '__toString']) ? (string) $key : $key);
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
     * @return ChildAlbi|array|mixed the result, formatted by the current formatter
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
     * @return $this|ChildAlbiQuery The current query, for fluid interface
     */
    public function filterByPrimaryKey($key)
    {

        return $this->addUsingAlias(AlbiTableMap::COL_ID_ALBO, $key, Criteria::EQUAL);
    }

    /**
     * Filter the query by a list of primary keys
     *
     * @param     array $keys The list of primary key to use for the query
     *
     * @return $this|ChildAlbiQuery The current query, for fluid interface
     */
    public function filterByPrimaryKeys($keys)
    {

        return $this->addUsingAlias(AlbiTableMap::COL_ID_ALBO, $keys, Criteria::IN);
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
     * @return $this|ChildAlbiQuery The current query, for fluid interface
     */
    public function filterByIdAlbo($idAlbo = null, $comparison = null)
    {
        if (is_array($idAlbo)) {
            $useMinMax = false;
            if (isset($idAlbo['min'])) {
                $this->addUsingAlias(AlbiTableMap::COL_ID_ALBO, $idAlbo['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($idAlbo['max'])) {
                $this->addUsingAlias(AlbiTableMap::COL_ID_ALBO, $idAlbo['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(AlbiTableMap::COL_ID_ALBO, $idAlbo, $comparison);
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
     * @return $this|ChildAlbiQuery The current query, for fluid interface
     */
    public function filterByIdTipo($idTipo = null, $comparison = null)
    {
        if (is_array($idTipo)) {
            $useMinMax = false;
            if (isset($idTipo['min'])) {
                $this->addUsingAlias(AlbiTableMap::COL_ID_TIPO, $idTipo['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($idTipo['max'])) {
                $this->addUsingAlias(AlbiTableMap::COL_ID_TIPO, $idTipo['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(AlbiTableMap::COL_ID_TIPO, $idTipo, $comparison);
    }

    /**
     * Filter the query on the id_tipo_determina column
     *
     * Example usage:
     * <code>
     * $query->filterByIdTipoDetermina(1234); // WHERE id_tipo_determina = 1234
     * $query->filterByIdTipoDetermina(array(12, 34)); // WHERE id_tipo_determina IN (12, 34)
     * $query->filterByIdTipoDetermina(array('min' => 12)); // WHERE id_tipo_determina > 12
     * </code>
     *
     * @param     mixed $idTipoDetermina The value to use as filter.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildAlbiQuery The current query, for fluid interface
     */
    public function filterByIdTipoDetermina($idTipoDetermina = null, $comparison = null)
    {
        if (is_array($idTipoDetermina)) {
            $useMinMax = false;
            if (isset($idTipoDetermina['min'])) {
                $this->addUsingAlias(AlbiTableMap::COL_ID_TIPO_DETERMINA, $idTipoDetermina['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($idTipoDetermina['max'])) {
                $this->addUsingAlias(AlbiTableMap::COL_ID_TIPO_DETERMINA, $idTipoDetermina['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(AlbiTableMap::COL_ID_TIPO_DETERMINA, $idTipoDetermina, $comparison);
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
     * @return $this|ChildAlbiQuery The current query, for fluid interface
     */
    public function filterByIdTipoTrasp($idTipoTrasp = null, $comparison = null)
    {
        if (is_array($idTipoTrasp)) {
            $useMinMax = false;
            if (isset($idTipoTrasp['min'])) {
                $this->addUsingAlias(AlbiTableMap::COL_ID_TIPO_TRASP, $idTipoTrasp['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($idTipoTrasp['max'])) {
                $this->addUsingAlias(AlbiTableMap::COL_ID_TIPO_TRASP, $idTipoTrasp['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(AlbiTableMap::COL_ID_TIPO_TRASP, $idTipoTrasp, $comparison);
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
     * @return $this|ChildAlbiQuery The current query, for fluid interface
     */
    public function filterByDtPubblicazDal($dtPubblicazDal = null, $comparison = null)
    {
        if (is_array($dtPubblicazDal)) {
            $useMinMax = false;
            if (isset($dtPubblicazDal['min'])) {
                $this->addUsingAlias(AlbiTableMap::COL_DT_PUBBLICAZ_DAL, $dtPubblicazDal['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($dtPubblicazDal['max'])) {
                $this->addUsingAlias(AlbiTableMap::COL_DT_PUBBLICAZ_DAL, $dtPubblicazDal['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(AlbiTableMap::COL_DT_PUBBLICAZ_DAL, $dtPubblicazDal, $comparison);
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
     * @return $this|ChildAlbiQuery The current query, for fluid interface
     */
    public function filterByDtPubblicazAl($dtPubblicazAl = null, $comparison = null)
    {
        if (is_array($dtPubblicazAl)) {
            $useMinMax = false;
            if (isset($dtPubblicazAl['min'])) {
                $this->addUsingAlias(AlbiTableMap::COL_DT_PUBBLICAZ_AL, $dtPubblicazAl['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($dtPubblicazAl['max'])) {
                $this->addUsingAlias(AlbiTableMap::COL_DT_PUBBLICAZ_AL, $dtPubblicazAl['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(AlbiTableMap::COL_DT_PUBBLICAZ_AL, $dtPubblicazAl, $comparison);
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
     * @return $this|ChildAlbiQuery The current query, for fluid interface
     */
    public function filterByDtAtto($dtAtto = null, $comparison = null)
    {
        if (is_array($dtAtto)) {
            $useMinMax = false;
            if (isset($dtAtto['min'])) {
                $this->addUsingAlias(AlbiTableMap::COL_DT_ATTO, $dtAtto['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($dtAtto['max'])) {
                $this->addUsingAlias(AlbiTableMap::COL_DT_ATTO, $dtAtto['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(AlbiTableMap::COL_DT_ATTO, $dtAtto, $comparison);
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
     * @return $this|ChildAlbiQuery The current query, for fluid interface
     */
    public function filterByNrAtto($nrAtto = null, $comparison = null)
    {
        if (is_array($nrAtto)) {
            $useMinMax = false;
            if (isset($nrAtto['min'])) {
                $this->addUsingAlias(AlbiTableMap::COL_NR_ATTO, $nrAtto['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($nrAtto['max'])) {
                $this->addUsingAlias(AlbiTableMap::COL_NR_ATTO, $nrAtto['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(AlbiTableMap::COL_NR_ATTO, $nrAtto, $comparison);
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
     * @return $this|ChildAlbiQuery The current query, for fluid interface
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

        return $this->addUsingAlias(AlbiTableMap::COL_OGGETTO, $oggetto, $comparison);
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
     * @return $this|ChildAlbiQuery The current query, for fluid interface
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

        return $this->addUsingAlias(AlbiTableMap::COL_AUTORITA_EMANANTE, $autoritaEmanante, $comparison);
    }

    /**
     * Filter the query on the spesa_prevista column
     *
     * Example usage:
     * <code>
     * $query->filterBySpesaPrevista(1234); // WHERE spesa_prevista = 1234
     * $query->filterBySpesaPrevista(array(12, 34)); // WHERE spesa_prevista IN (12, 34)
     * $query->filterBySpesaPrevista(array('min' => 12)); // WHERE spesa_prevista > 12
     * </code>
     *
     * @param     mixed $spesaPrevista The value to use as filter.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildAlbiQuery The current query, for fluid interface
     */
    public function filterBySpesaPrevista($spesaPrevista = null, $comparison = null)
    {
        if (is_array($spesaPrevista)) {
            $useMinMax = false;
            if (isset($spesaPrevista['min'])) {
                $this->addUsingAlias(AlbiTableMap::COL_SPESA_PREVISTA, $spesaPrevista['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($spesaPrevista['max'])) {
                $this->addUsingAlias(AlbiTableMap::COL_SPESA_PREVISTA, $spesaPrevista['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(AlbiTableMap::COL_SPESA_PREVISTA, $spesaPrevista, $comparison);
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
     * @return $this|ChildAlbiQuery The current query, for fluid interface
     */
    public function filterByIdArea($idArea = null, $comparison = null)
    {
        if (is_array($idArea)) {
            $useMinMax = false;
            if (isset($idArea['min'])) {
                $this->addUsingAlias(AlbiTableMap::COL_ID_AREA, $idArea['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($idArea['max'])) {
                $this->addUsingAlias(AlbiTableMap::COL_ID_AREA, $idArea['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(AlbiTableMap::COL_ID_AREA, $idArea, $comparison);
    }

    /**
     * Filter the query on the serialize column
     *
     * Example usage:
     * <code>
     * $query->filterBySerialize('fooValue');   // WHERE serialize = 'fooValue'
     * $query->filterBySerialize('%fooValue%'); // WHERE serialize LIKE '%fooValue%'
     * </code>
     *
     * @param     string $serialize The value to use as filter.
     *              Accepts wildcards (* and % trigger a LIKE)
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildAlbiQuery The current query, for fluid interface
     */
    public function filterBySerialize($serialize = null, $comparison = null)
    {
        if (null === $comparison) {
            if (is_array($serialize)) {
                $comparison = Criteria::IN;
            } elseif (preg_match('/[\%\*]/', $serialize)) {
                $serialize = str_replace('*', '%', $serialize);
                $comparison = Criteria::LIKE;
            }
        }

        return $this->addUsingAlias(AlbiTableMap::COL_SERIALIZE, $serialize, $comparison);
    }

    /**
     * Filter the query on the da_validare column
     *
     * Example usage:
     * <code>
     * $query->filterByDaValidare('fooValue');   // WHERE da_validare = 'fooValue'
     * $query->filterByDaValidare('%fooValue%'); // WHERE da_validare LIKE '%fooValue%'
     * </code>
     *
     * @param     string $daValidare The value to use as filter.
     *              Accepts wildcards (* and % trigger a LIKE)
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildAlbiQuery The current query, for fluid interface
     */
    public function filterByDaValidare($daValidare = null, $comparison = null)
    {
        if (null === $comparison) {
            if (is_array($daValidare)) {
                $comparison = Criteria::IN;
            } elseif (preg_match('/[\%\*]/', $daValidare)) {
                $daValidare = str_replace('*', '%', $daValidare);
                $comparison = Criteria::LIKE;
            }
        }

        return $this->addUsingAlias(AlbiTableMap::COL_DA_VALIDARE, $daValidare, $comparison);
    }

    /**
     * Filter the query on the note column
     *
     * Example usage:
     * <code>
     * $query->filterByNote('fooValue');   // WHERE note = 'fooValue'
     * $query->filterByNote('%fooValue%'); // WHERE note LIKE '%fooValue%'
     * </code>
     *
     * @param     string $note The value to use as filter.
     *              Accepts wildcards (* and % trigger a LIKE)
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildAlbiQuery The current query, for fluid interface
     */
    public function filterByNote($note = null, $comparison = null)
    {
        if (null === $comparison) {
            if (is_array($note)) {
                $comparison = Criteria::IN;
            } elseif (preg_match('/[\%\*]/', $note)) {
                $note = str_replace('*', '%', $note);
                $comparison = Criteria::LIKE;
            }
        }

        return $this->addUsingAlias(AlbiTableMap::COL_NOTE, $note, $comparison);
    }

    /**
     * Filter the query on the manuale column
     *
     * Example usage:
     * <code>
     * $query->filterByManuale('fooValue');   // WHERE manuale = 'fooValue'
     * $query->filterByManuale('%fooValue%'); // WHERE manuale LIKE '%fooValue%'
     * </code>
     *
     * @param     string $manuale The value to use as filter.
     *              Accepts wildcards (* and % trigger a LIKE)
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildAlbiQuery The current query, for fluid interface
     */
    public function filterByManuale($manuale = null, $comparison = null)
    {
        if (null === $comparison) {
            if (is_array($manuale)) {
                $comparison = Criteria::IN;
            } elseif (preg_match('/[\%\*]/', $manuale)) {
                $manuale = str_replace('*', '%', $manuale);
                $comparison = Criteria::LIKE;
            }
        }

        return $this->addUsingAlias(AlbiTableMap::COL_MANUALE, $manuale, $comparison);
    }

    /**
     * Exclude object from result
     *
     * @param   ChildAlbi $albi Object to remove from the list of results
     *
     * @return $this|ChildAlbiQuery The current query, for fluid interface
     */
    public function prune($albi = null)
    {
        if ($albi) {
            $this->addUsingAlias(AlbiTableMap::COL_ID_ALBO, $albi->getIdAlbo(), Criteria::NOT_EQUAL);
        }

        return $this;
    }

    /**
     * Deletes all rows from the albi table.
     *
     * @param ConnectionInterface $con the connection to use
     * @return int The number of affected rows (if supported by underlying database driver).
     */
    public function doDeleteAll(ConnectionInterface $con = null)
    {
        if (null === $con) {
            $con = Propel::getServiceContainer()->getWriteConnection(AlbiTableMap::DATABASE_NAME);
        }

        // use transaction because $criteria could contain info
        // for more than one table or we could emulating ON DELETE CASCADE, etc.
        return $con->transaction(function () use ($con) {
            $affectedRows = 0; // initialize var to track total num of affected rows
            $affectedRows += parent::doDeleteAll($con);
            // Because this db requires some delete cascade/set null emulation, we have to
            // clear the cached instance *after* the emulation has happened (since
            // instances get re-added by the select statement contained therein).
            AlbiTableMap::clearInstancePool();
            AlbiTableMap::clearRelatedInstancePool();

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
            $con = Propel::getServiceContainer()->getWriteConnection(AlbiTableMap::DATABASE_NAME);
        }

        $criteria = $this;

        // Set the correct dbName
        $criteria->setDbName(AlbiTableMap::DATABASE_NAME);

        // use transaction because $criteria could contain info
        // for more than one table or we could emulating ON DELETE CASCADE, etc.
        return $con->transaction(function () use ($con, $criteria) {
            $affectedRows = 0; // initialize var to track total num of affected rows

            AlbiTableMap::removeInstanceFromPool($criteria);

            $affectedRows += ModelCriteria::delete($con);
            AlbiTableMap::clearRelatedInstancePool();

            return $affectedRows;
        });
    }

} // AlbiQuery

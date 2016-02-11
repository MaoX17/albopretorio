<?php

namespace Base;

use \AmmAperta as ChildAmmAperta;
use \AmmApertaQuery as ChildAmmApertaQuery;
use \Exception;
use \PDO;
use Map\AmmApertaTableMap;
use Propel\Runtime\Propel;
use Propel\Runtime\ActiveQuery\Criteria;
use Propel\Runtime\ActiveQuery\ModelCriteria;
use Propel\Runtime\Collection\ObjectCollection;
use Propel\Runtime\Connection\ConnectionInterface;
use Propel\Runtime\Exception\PropelException;

/**
 * Base class that represents a query for the 'amm_aperta' table.
 *
 *
 *
 * @method     ChildAmmApertaQuery orderByIdAmmAperta($order = Criteria::ASC) Order by the id_amm_aperta column
 * @method     ChildAmmApertaQuery orderByIdAlbo($order = Criteria::ASC) Order by the id_albo column
 * @method     ChildAmmApertaQuery orderByRagionesociale($order = Criteria::ASC) Order by the ragionesociale column
 * @method     ChildAmmApertaQuery orderByPiva($order = Criteria::ASC) Order by the piva column
 * @method     ChildAmmApertaQuery orderByRespProc($order = Criteria::ASC) Order by the resp_proc column
 * @method     ChildAmmApertaQuery orderByNorma($order = Criteria::ASC) Order by the norma column
 * @method     ChildAmmApertaQuery orderByModalita($order = Criteria::ASC) Order by the modalita column
 * @method     ChildAmmApertaQuery orderByImporto($order = Criteria::ASC) Order by the importo column
 * @method     ChildAmmApertaQuery orderByPubblicato($order = Criteria::ASC) Order by the pubblicato column
 * @method     ChildAmmApertaQuery orderByDtPubblicazione($order = Criteria::ASC) Order by the dt_pubblicazione column
 * @method     ChildAmmApertaQuery orderByRespProcIdrubrica($order = Criteria::ASC) Order by the resp_proc_idrubrica column
 *
 * @method     ChildAmmApertaQuery groupByIdAmmAperta() Group by the id_amm_aperta column
 * @method     ChildAmmApertaQuery groupByIdAlbo() Group by the id_albo column
 * @method     ChildAmmApertaQuery groupByRagionesociale() Group by the ragionesociale column
 * @method     ChildAmmApertaQuery groupByPiva() Group by the piva column
 * @method     ChildAmmApertaQuery groupByRespProc() Group by the resp_proc column
 * @method     ChildAmmApertaQuery groupByNorma() Group by the norma column
 * @method     ChildAmmApertaQuery groupByModalita() Group by the modalita column
 * @method     ChildAmmApertaQuery groupByImporto() Group by the importo column
 * @method     ChildAmmApertaQuery groupByPubblicato() Group by the pubblicato column
 * @method     ChildAmmApertaQuery groupByDtPubblicazione() Group by the dt_pubblicazione column
 * @method     ChildAmmApertaQuery groupByRespProcIdrubrica() Group by the resp_proc_idrubrica column
 *
 * @method     ChildAmmApertaQuery leftJoin($relation) Adds a LEFT JOIN clause to the query
 * @method     ChildAmmApertaQuery rightJoin($relation) Adds a RIGHT JOIN clause to the query
 * @method     ChildAmmApertaQuery innerJoin($relation) Adds a INNER JOIN clause to the query
 *
 * @method     ChildAmmApertaQuery leftJoinWith($relation) Adds a LEFT JOIN clause and with to the query
 * @method     ChildAmmApertaQuery rightJoinWith($relation) Adds a RIGHT JOIN clause and with to the query
 * @method     ChildAmmApertaQuery innerJoinWith($relation) Adds a INNER JOIN clause and with to the query
 *
 * @method     ChildAmmAperta findOne(ConnectionInterface $con = null) Return the first ChildAmmAperta matching the query
 * @method     ChildAmmAperta findOneOrCreate(ConnectionInterface $con = null) Return the first ChildAmmAperta matching the query, or a new ChildAmmAperta object populated from the query conditions when no match is found
 *
 * @method     ChildAmmAperta findOneByIdAmmAperta(int $id_amm_aperta) Return the first ChildAmmAperta filtered by the id_amm_aperta column
 * @method     ChildAmmAperta findOneByIdAlbo(int $id_albo) Return the first ChildAmmAperta filtered by the id_albo column
 * @method     ChildAmmAperta findOneByRagionesociale(string $ragionesociale) Return the first ChildAmmAperta filtered by the ragionesociale column
 * @method     ChildAmmAperta findOneByPiva(string $piva) Return the first ChildAmmAperta filtered by the piva column
 * @method     ChildAmmAperta findOneByRespProc(string $resp_proc) Return the first ChildAmmAperta filtered by the resp_proc column
 * @method     ChildAmmAperta findOneByNorma(string $norma) Return the first ChildAmmAperta filtered by the norma column
 * @method     ChildAmmAperta findOneByModalita(string $modalita) Return the first ChildAmmAperta filtered by the modalita column
 * @method     ChildAmmAperta findOneByImporto(string $importo) Return the first ChildAmmAperta filtered by the importo column
 * @method     ChildAmmAperta findOneByPubblicato(string $pubblicato) Return the first ChildAmmAperta filtered by the pubblicato column
 * @method     ChildAmmAperta findOneByDtPubblicazione(string $dt_pubblicazione) Return the first ChildAmmAperta filtered by the dt_pubblicazione column
 * @method     ChildAmmAperta findOneByRespProcIdrubrica(int $resp_proc_idrubrica) Return the first ChildAmmAperta filtered by the resp_proc_idrubrica column *

 * @method     ChildAmmAperta requirePk($key, ConnectionInterface $con = null) Return the ChildAmmAperta by primary key and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildAmmAperta requireOne(ConnectionInterface $con = null) Return the first ChildAmmAperta matching the query and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 *
 * @method     ChildAmmAperta requireOneByIdAmmAperta(int $id_amm_aperta) Return the first ChildAmmAperta filtered by the id_amm_aperta column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildAmmAperta requireOneByIdAlbo(int $id_albo) Return the first ChildAmmAperta filtered by the id_albo column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildAmmAperta requireOneByRagionesociale(string $ragionesociale) Return the first ChildAmmAperta filtered by the ragionesociale column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildAmmAperta requireOneByPiva(string $piva) Return the first ChildAmmAperta filtered by the piva column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildAmmAperta requireOneByRespProc(string $resp_proc) Return the first ChildAmmAperta filtered by the resp_proc column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildAmmAperta requireOneByNorma(string $norma) Return the first ChildAmmAperta filtered by the norma column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildAmmAperta requireOneByModalita(string $modalita) Return the first ChildAmmAperta filtered by the modalita column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildAmmAperta requireOneByImporto(string $importo) Return the first ChildAmmAperta filtered by the importo column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildAmmAperta requireOneByPubblicato(string $pubblicato) Return the first ChildAmmAperta filtered by the pubblicato column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildAmmAperta requireOneByDtPubblicazione(string $dt_pubblicazione) Return the first ChildAmmAperta filtered by the dt_pubblicazione column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildAmmAperta requireOneByRespProcIdrubrica(int $resp_proc_idrubrica) Return the first ChildAmmAperta filtered by the resp_proc_idrubrica column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 *
 * @method     ChildAmmAperta[]|ObjectCollection find(ConnectionInterface $con = null) Return ChildAmmAperta objects based on current ModelCriteria
 * @method     ChildAmmAperta[]|ObjectCollection findByIdAmmAperta(int $id_amm_aperta) Return ChildAmmAperta objects filtered by the id_amm_aperta column
 * @method     ChildAmmAperta[]|ObjectCollection findByIdAlbo(int $id_albo) Return ChildAmmAperta objects filtered by the id_albo column
 * @method     ChildAmmAperta[]|ObjectCollection findByRagionesociale(string $ragionesociale) Return ChildAmmAperta objects filtered by the ragionesociale column
 * @method     ChildAmmAperta[]|ObjectCollection findByPiva(string $piva) Return ChildAmmAperta objects filtered by the piva column
 * @method     ChildAmmAperta[]|ObjectCollection findByRespProc(string $resp_proc) Return ChildAmmAperta objects filtered by the resp_proc column
 * @method     ChildAmmAperta[]|ObjectCollection findByNorma(string $norma) Return ChildAmmAperta objects filtered by the norma column
 * @method     ChildAmmAperta[]|ObjectCollection findByModalita(string $modalita) Return ChildAmmAperta objects filtered by the modalita column
 * @method     ChildAmmAperta[]|ObjectCollection findByImporto(string $importo) Return ChildAmmAperta objects filtered by the importo column
 * @method     ChildAmmAperta[]|ObjectCollection findByPubblicato(string $pubblicato) Return ChildAmmAperta objects filtered by the pubblicato column
 * @method     ChildAmmAperta[]|ObjectCollection findByDtPubblicazione(string $dt_pubblicazione) Return ChildAmmAperta objects filtered by the dt_pubblicazione column
 * @method     ChildAmmAperta[]|ObjectCollection findByRespProcIdrubrica(int $resp_proc_idrubrica) Return ChildAmmAperta objects filtered by the resp_proc_idrubrica column
 * @method     ChildAmmAperta[]|\Propel\Runtime\Util\PropelModelPager paginate($page = 1, $maxPerPage = 10, ConnectionInterface $con = null) Issue a SELECT query based on the current ModelCriteria and uses a page and a maximum number of results per page to compute an offset and a limit
 *
 */
abstract class AmmApertaQuery extends ModelCriteria
{
    protected $entityNotFoundExceptionClass = '\\Propel\\Runtime\\Exception\\EntityNotFoundException';

    /**
     * Initializes internal state of \Base\AmmApertaQuery object.
     *
     * @param     string $dbName The database name
     * @param     string $modelName The phpName of a model, e.g. 'Book'
     * @param     string $modelAlias The alias for the model in this query, e.g. 'b'
     */
    public function __construct($dbName = 'default', $modelName = '\\AmmAperta', $modelAlias = null)
    {
        parent::__construct($dbName, $modelName, $modelAlias);
    }

    /**
     * Returns a new ChildAmmApertaQuery object.
     *
     * @param     string $modelAlias The alias of a model in the query
     * @param     Criteria $criteria Optional Criteria to build the query from
     *
     * @return ChildAmmApertaQuery
     */
    public static function create($modelAlias = null, Criteria $criteria = null)
    {
        if ($criteria instanceof ChildAmmApertaQuery) {
            return $criteria;
        }
        $query = new ChildAmmApertaQuery();
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
     * @return ChildAmmAperta|array|mixed the result, formatted by the current formatter
     */
    public function findPk($key, ConnectionInterface $con = null)
    {
        if ($key === null) {
            return null;
        }
        if ((null !== ($obj = AmmApertaTableMap::getInstanceFromPool(null === $key || is_scalar($key) || is_callable([$key, '__toString']) ? (string) $key : $key))) && !$this->formatter) {
            // the object is already in the instance pool
            return $obj;
        }
        if ($con === null) {
            $con = Propel::getServiceContainer()->getReadConnection(AmmApertaTableMap::DATABASE_NAME);
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
     * @return ChildAmmAperta A model object, or null if the key is not found
     */
    protected function findPkSimple($key, ConnectionInterface $con)
    {
        $sql = 'SELECT id_amm_aperta, id_albo, ragionesociale, piva, resp_proc, norma, modalita, importo, pubblicato, dt_pubblicazione, resp_proc_idrubrica FROM amm_aperta WHERE id_amm_aperta = :p0';
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
            /** @var ChildAmmAperta $obj */
            $obj = new ChildAmmAperta();
            $obj->hydrate($row);
            AmmApertaTableMap::addInstanceToPool($obj, null === $key || is_scalar($key) || is_callable([$key, '__toString']) ? (string) $key : $key);
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
     * @return ChildAmmAperta|array|mixed the result, formatted by the current formatter
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
     * @return $this|ChildAmmApertaQuery The current query, for fluid interface
     */
    public function filterByPrimaryKey($key)
    {

        return $this->addUsingAlias(AmmApertaTableMap::COL_ID_AMM_APERTA, $key, Criteria::EQUAL);
    }

    /**
     * Filter the query by a list of primary keys
     *
     * @param     array $keys The list of primary key to use for the query
     *
     * @return $this|ChildAmmApertaQuery The current query, for fluid interface
     */
    public function filterByPrimaryKeys($keys)
    {

        return $this->addUsingAlias(AmmApertaTableMap::COL_ID_AMM_APERTA, $keys, Criteria::IN);
    }

    /**
     * Filter the query on the id_amm_aperta column
     *
     * Example usage:
     * <code>
     * $query->filterByIdAmmAperta(1234); // WHERE id_amm_aperta = 1234
     * $query->filterByIdAmmAperta(array(12, 34)); // WHERE id_amm_aperta IN (12, 34)
     * $query->filterByIdAmmAperta(array('min' => 12)); // WHERE id_amm_aperta > 12
     * </code>
     *
     * @param     mixed $idAmmAperta The value to use as filter.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildAmmApertaQuery The current query, for fluid interface
     */
    public function filterByIdAmmAperta($idAmmAperta = null, $comparison = null)
    {
        if (is_array($idAmmAperta)) {
            $useMinMax = false;
            if (isset($idAmmAperta['min'])) {
                $this->addUsingAlias(AmmApertaTableMap::COL_ID_AMM_APERTA, $idAmmAperta['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($idAmmAperta['max'])) {
                $this->addUsingAlias(AmmApertaTableMap::COL_ID_AMM_APERTA, $idAmmAperta['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(AmmApertaTableMap::COL_ID_AMM_APERTA, $idAmmAperta, $comparison);
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
     * @return $this|ChildAmmApertaQuery The current query, for fluid interface
     */
    public function filterByIdAlbo($idAlbo = null, $comparison = null)
    {
        if (is_array($idAlbo)) {
            $useMinMax = false;
            if (isset($idAlbo['min'])) {
                $this->addUsingAlias(AmmApertaTableMap::COL_ID_ALBO, $idAlbo['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($idAlbo['max'])) {
                $this->addUsingAlias(AmmApertaTableMap::COL_ID_ALBO, $idAlbo['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(AmmApertaTableMap::COL_ID_ALBO, $idAlbo, $comparison);
    }

    /**
     * Filter the query on the ragionesociale column
     *
     * Example usage:
     * <code>
     * $query->filterByRagionesociale('fooValue');   // WHERE ragionesociale = 'fooValue'
     * $query->filterByRagionesociale('%fooValue%'); // WHERE ragionesociale LIKE '%fooValue%'
     * </code>
     *
     * @param     string $ragionesociale The value to use as filter.
     *              Accepts wildcards (* and % trigger a LIKE)
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildAmmApertaQuery The current query, for fluid interface
     */
    public function filterByRagionesociale($ragionesociale = null, $comparison = null)
    {
        if (null === $comparison) {
            if (is_array($ragionesociale)) {
                $comparison = Criteria::IN;
            } elseif (preg_match('/[\%\*]/', $ragionesociale)) {
                $ragionesociale = str_replace('*', '%', $ragionesociale);
                $comparison = Criteria::LIKE;
            }
        }

        return $this->addUsingAlias(AmmApertaTableMap::COL_RAGIONESOCIALE, $ragionesociale, $comparison);
    }

    /**
     * Filter the query on the piva column
     *
     * Example usage:
     * <code>
     * $query->filterByPiva('fooValue');   // WHERE piva = 'fooValue'
     * $query->filterByPiva('%fooValue%'); // WHERE piva LIKE '%fooValue%'
     * </code>
     *
     * @param     string $piva The value to use as filter.
     *              Accepts wildcards (* and % trigger a LIKE)
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildAmmApertaQuery The current query, for fluid interface
     */
    public function filterByPiva($piva = null, $comparison = null)
    {
        if (null === $comparison) {
            if (is_array($piva)) {
                $comparison = Criteria::IN;
            } elseif (preg_match('/[\%\*]/', $piva)) {
                $piva = str_replace('*', '%', $piva);
                $comparison = Criteria::LIKE;
            }
        }

        return $this->addUsingAlias(AmmApertaTableMap::COL_PIVA, $piva, $comparison);
    }

    /**
     * Filter the query on the resp_proc column
     *
     * Example usage:
     * <code>
     * $query->filterByRespProc('fooValue');   // WHERE resp_proc = 'fooValue'
     * $query->filterByRespProc('%fooValue%'); // WHERE resp_proc LIKE '%fooValue%'
     * </code>
     *
     * @param     string $respProc The value to use as filter.
     *              Accepts wildcards (* and % trigger a LIKE)
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildAmmApertaQuery The current query, for fluid interface
     */
    public function filterByRespProc($respProc = null, $comparison = null)
    {
        if (null === $comparison) {
            if (is_array($respProc)) {
                $comparison = Criteria::IN;
            } elseif (preg_match('/[\%\*]/', $respProc)) {
                $respProc = str_replace('*', '%', $respProc);
                $comparison = Criteria::LIKE;
            }
        }

        return $this->addUsingAlias(AmmApertaTableMap::COL_RESP_PROC, $respProc, $comparison);
    }

    /**
     * Filter the query on the norma column
     *
     * Example usage:
     * <code>
     * $query->filterByNorma('fooValue');   // WHERE norma = 'fooValue'
     * $query->filterByNorma('%fooValue%'); // WHERE norma LIKE '%fooValue%'
     * </code>
     *
     * @param     string $norma The value to use as filter.
     *              Accepts wildcards (* and % trigger a LIKE)
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildAmmApertaQuery The current query, for fluid interface
     */
    public function filterByNorma($norma = null, $comparison = null)
    {
        if (null === $comparison) {
            if (is_array($norma)) {
                $comparison = Criteria::IN;
            } elseif (preg_match('/[\%\*]/', $norma)) {
                $norma = str_replace('*', '%', $norma);
                $comparison = Criteria::LIKE;
            }
        }

        return $this->addUsingAlias(AmmApertaTableMap::COL_NORMA, $norma, $comparison);
    }

    /**
     * Filter the query on the modalita column
     *
     * Example usage:
     * <code>
     * $query->filterByModalita('fooValue');   // WHERE modalita = 'fooValue'
     * $query->filterByModalita('%fooValue%'); // WHERE modalita LIKE '%fooValue%'
     * </code>
     *
     * @param     string $modalita The value to use as filter.
     *              Accepts wildcards (* and % trigger a LIKE)
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildAmmApertaQuery The current query, for fluid interface
     */
    public function filterByModalita($modalita = null, $comparison = null)
    {
        if (null === $comparison) {
            if (is_array($modalita)) {
                $comparison = Criteria::IN;
            } elseif (preg_match('/[\%\*]/', $modalita)) {
                $modalita = str_replace('*', '%', $modalita);
                $comparison = Criteria::LIKE;
            }
        }

        return $this->addUsingAlias(AmmApertaTableMap::COL_MODALITA, $modalita, $comparison);
    }

    /**
     * Filter the query on the importo column
     *
     * Example usage:
     * <code>
     * $query->filterByImporto(1234); // WHERE importo = 1234
     * $query->filterByImporto(array(12, 34)); // WHERE importo IN (12, 34)
     * $query->filterByImporto(array('min' => 12)); // WHERE importo > 12
     * </code>
     *
     * @param     mixed $importo The value to use as filter.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildAmmApertaQuery The current query, for fluid interface
     */
    public function filterByImporto($importo = null, $comparison = null)
    {
        if (is_array($importo)) {
            $useMinMax = false;
            if (isset($importo['min'])) {
                $this->addUsingAlias(AmmApertaTableMap::COL_IMPORTO, $importo['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($importo['max'])) {
                $this->addUsingAlias(AmmApertaTableMap::COL_IMPORTO, $importo['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(AmmApertaTableMap::COL_IMPORTO, $importo, $comparison);
    }

    /**
     * Filter the query on the pubblicato column
     *
     * Example usage:
     * <code>
     * $query->filterByPubblicato('fooValue');   // WHERE pubblicato = 'fooValue'
     * $query->filterByPubblicato('%fooValue%'); // WHERE pubblicato LIKE '%fooValue%'
     * </code>
     *
     * @param     string $pubblicato The value to use as filter.
     *              Accepts wildcards (* and % trigger a LIKE)
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildAmmApertaQuery The current query, for fluid interface
     */
    public function filterByPubblicato($pubblicato = null, $comparison = null)
    {
        if (null === $comparison) {
            if (is_array($pubblicato)) {
                $comparison = Criteria::IN;
            } elseif (preg_match('/[\%\*]/', $pubblicato)) {
                $pubblicato = str_replace('*', '%', $pubblicato);
                $comparison = Criteria::LIKE;
            }
        }

        return $this->addUsingAlias(AmmApertaTableMap::COL_PUBBLICATO, $pubblicato, $comparison);
    }

    /**
     * Filter the query on the dt_pubblicazione column
     *
     * Example usage:
     * <code>
     * $query->filterByDtPubblicazione('2011-03-14'); // WHERE dt_pubblicazione = '2011-03-14'
     * $query->filterByDtPubblicazione('now'); // WHERE dt_pubblicazione = '2011-03-14'
     * $query->filterByDtPubblicazione(array('max' => 'yesterday')); // WHERE dt_pubblicazione > '2011-03-13'
     * </code>
     *
     * @param     mixed $dtPubblicazione The value to use as filter.
     *              Values can be integers (unix timestamps), DateTime objects, or strings.
     *              Empty strings are treated as NULL.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildAmmApertaQuery The current query, for fluid interface
     */
    public function filterByDtPubblicazione($dtPubblicazione = null, $comparison = null)
    {
        if (is_array($dtPubblicazione)) {
            $useMinMax = false;
            if (isset($dtPubblicazione['min'])) {
                $this->addUsingAlias(AmmApertaTableMap::COL_DT_PUBBLICAZIONE, $dtPubblicazione['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($dtPubblicazione['max'])) {
                $this->addUsingAlias(AmmApertaTableMap::COL_DT_PUBBLICAZIONE, $dtPubblicazione['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(AmmApertaTableMap::COL_DT_PUBBLICAZIONE, $dtPubblicazione, $comparison);
    }

    /**
     * Filter the query on the resp_proc_idrubrica column
     *
     * Example usage:
     * <code>
     * $query->filterByRespProcIdrubrica(1234); // WHERE resp_proc_idrubrica = 1234
     * $query->filterByRespProcIdrubrica(array(12, 34)); // WHERE resp_proc_idrubrica IN (12, 34)
     * $query->filterByRespProcIdrubrica(array('min' => 12)); // WHERE resp_proc_idrubrica > 12
     * </code>
     *
     * @param     mixed $respProcIdrubrica The value to use as filter.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildAmmApertaQuery The current query, for fluid interface
     */
    public function filterByRespProcIdrubrica($respProcIdrubrica = null, $comparison = null)
    {
        if (is_array($respProcIdrubrica)) {
            $useMinMax = false;
            if (isset($respProcIdrubrica['min'])) {
                $this->addUsingAlias(AmmApertaTableMap::COL_RESP_PROC_IDRUBRICA, $respProcIdrubrica['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($respProcIdrubrica['max'])) {
                $this->addUsingAlias(AmmApertaTableMap::COL_RESP_PROC_IDRUBRICA, $respProcIdrubrica['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(AmmApertaTableMap::COL_RESP_PROC_IDRUBRICA, $respProcIdrubrica, $comparison);
    }

    /**
     * Exclude object from result
     *
     * @param   ChildAmmAperta $ammAperta Object to remove from the list of results
     *
     * @return $this|ChildAmmApertaQuery The current query, for fluid interface
     */
    public function prune($ammAperta = null)
    {
        if ($ammAperta) {
            $this->addUsingAlias(AmmApertaTableMap::COL_ID_AMM_APERTA, $ammAperta->getIdAmmAperta(), Criteria::NOT_EQUAL);
        }

        return $this;
    }

    /**
     * Deletes all rows from the amm_aperta table.
     *
     * @param ConnectionInterface $con the connection to use
     * @return int The number of affected rows (if supported by underlying database driver).
     */
    public function doDeleteAll(ConnectionInterface $con = null)
    {
        if (null === $con) {
            $con = Propel::getServiceContainer()->getWriteConnection(AmmApertaTableMap::DATABASE_NAME);
        }

        // use transaction because $criteria could contain info
        // for more than one table or we could emulating ON DELETE CASCADE, etc.
        return $con->transaction(function () use ($con) {
            $affectedRows = 0; // initialize var to track total num of affected rows
            $affectedRows += parent::doDeleteAll($con);
            // Because this db requires some delete cascade/set null emulation, we have to
            // clear the cached instance *after* the emulation has happened (since
            // instances get re-added by the select statement contained therein).
            AmmApertaTableMap::clearInstancePool();
            AmmApertaTableMap::clearRelatedInstancePool();

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
            $con = Propel::getServiceContainer()->getWriteConnection(AmmApertaTableMap::DATABASE_NAME);
        }

        $criteria = $this;

        // Set the correct dbName
        $criteria->setDbName(AmmApertaTableMap::DATABASE_NAME);

        // use transaction because $criteria could contain info
        // for more than one table or we could emulating ON DELETE CASCADE, etc.
        return $con->transaction(function () use ($con, $criteria) {
            $affectedRows = 0; // initialize var to track total num of affected rows

            AmmApertaTableMap::removeInstanceFromPool($criteria);

            $affectedRows += ModelCriteria::delete($con);
            AmmApertaTableMap::clearRelatedInstancePool();

            return $affectedRows;
        });
    }

} // AmmApertaQuery

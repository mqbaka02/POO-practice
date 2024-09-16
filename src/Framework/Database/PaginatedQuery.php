<?php
namespace Framework\Database;

use Pagerfanta\Adapter\AdapterInterface;
use PDO;

class PaginatedQuery implements AdapterInterface
{
    /**
     * @var PDO
     */
    private $pdo;
    /**
     * @var string
     */
    private $query;
    /**
     * @var string
     */
    private $countQuery;
    /**
     * @var string
     */
    private $entity;

    /**
     * @param PDO $pdo
     * @param string $query The query to get the data
     * @param string $countQuery The query for counting data
     * @param string $entity
     */
    public function __construct(PDO $pdo, string $query, string $countQuery, string $entity)
    {
        $this->pdo= $pdo;
        $this->entity= $entity;
        $this->query= $query;
        $this->countQuery= $countQuery;
    }

    /**
     * @return integer
     */
    public function getNbResults(): int
    {
        return $this->pdo->query($this->countQuery)->fetchColumn();
    }

    /**
     * Returns a slice of the results i.e. one of the paginated part
     * @param integer $offset
     * @param integer $lenght
     * @return iterable
     */
    public function getSlice(int $offset, int $length): array
    {
        $statement= $this->pdo->prepare($this->query . ' LIMIT :offset, :lenght');
        $statement->bindParam('offset', $offset, PDO::PARAM_INT);
        $statement->bindParam('lenght', $length, PDO::PARAM_INT);
        $statement->setFetchMode(PDO::FETCH_CLASS, $this->entity);
        $statement->execute();
        return $statement->fetchAll();
    }
}

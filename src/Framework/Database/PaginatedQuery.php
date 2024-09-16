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
     * @param PDO $pdo
     * @param string $query The query to get the data
     * @param string $countQuery The query for counting data
     */
    public function __construct(PDO $pdo, string $query, string $countQuery)
    {
        $this->pdo= $pdo;
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
    public function getSlice(int $offset, int $length): iterable
    {
        $statement= $this->pdo->prepare($this->query . ' LIMIT :offset, :lenght');
        $statement->bindParam('offset', $offset, PDO::PARAM_INT);
        $statement->bindParam('lenght', $length, PDO::PARAM_INT);
        $statement->execute();
        return $statement->fetchAll();
    }
}

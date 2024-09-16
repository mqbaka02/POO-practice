<?php
namespace App\Blog\Table;

use Framework\Database\PaginatedQuery;
use Pagerfanta\Pagerfanta;

class PostTable
{
    /**
     * @var \PDO
     */
    private $pdo;

    public function __construct(\PDO $pdo)
    {
        $this->pdo= $pdo;
    }

    /**
     * @var integer $perPage
     * @return PagerFanta
     */
    public function findPaginated(int $perPage, int $currentPage): Pagerfanta
    {
        $query= new PaginatedQuery(
            $this->pdo,
            'SELECT * FROM posts',
            'SELECT COUNT(id) FROM posts'
        );
        return (new Pagerfanta($query))->setMaxPerPage($perPage)->setCurrentPage($currentPage);
        // return $this->pdo
        //     ->query('SELECT * FROM posts ORDER BY created_at DESC LIMIT 10')
        //     ->fetchAll();
    }

    /**
     * @param int $id
     * return \stdClass
     */
    public function find(int $id): \stdClass
    {
        $query= $this->pdo
            ->prepare('SELECT * FROM posts WHERE id= ?');
        $query->execute([$id]);
        $post= $query->fetch();
        return $post;
    }
}

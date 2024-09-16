<?php
namespace App\Blog\Table;

use App\Blog\Entity\Post;
use Framework\Database\PaginatedQuery;
use Pagerfanta\Pagerfanta;
use PDO;

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
            'SELECT COUNT(id) FROM posts',
            Post::class
        );
        return (new Pagerfanta($query))->setMaxPerPage($perPage)->setCurrentPage($currentPage);
        // return $this->pdo
        //     ->query('SELECT * FROM posts ORDER BY created_at DESC LIMIT 10')
        //     ->fetchAll();
    }

    /**
     * @param integer $id
     * @return Post
     */
    public function find(int $id): Post
    {
        $query= $this->pdo
            ->prepare('SELECT * FROM posts WHERE id= ?');
        $query->setFetchMode(PDO::FETCH_CLASS, Post::class);
        $query->execute([$id]);
        $post= $query->fetch();
        return $post;
    }
}

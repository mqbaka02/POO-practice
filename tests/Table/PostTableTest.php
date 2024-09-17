<?php
namespace Tests\App\Blog\Table;

use App\Blog\Entity\Post;
use App\Blog\Table\PostTable;
use Tests\Framework\DatabaseTestCase;

class PostTableTest extends DatabaseTestCase
{
    /**
     * @var PostTable
     */
    private $postTable;

    public function setUp(): void
    {
        parent::setUp();
        $this->postTable= new PostTable($this->pdo);
        //$this->pdo->beginTransaction();//Make sure to avoid persisting the data after each test
    }

    /**
     * Called after every test
     */
    //public function tearDown(): void
    //{
        //$this->pdo->rollBack();//Resets the state of the pdo after the test
    //}

    public function testFind()
    {
        $this->seedDatabase();
        $post= $this->postTable->find(1);
        $this->assertInstanceOf(Post::class, $post);
    }

    public function testFindNotFoundRecord()
    {
        $post= $this->postTable->find(1);
        $this->assertNull($post);
    }

    public function testUpdate()
    {
        $this->seedDatabase();
        $this->postTable->update(1, ['name'=> 'New Name', 'slug'=> 'new-slug']);
        $post= $this->postTable->find(1);
        $this->assertEquals('New Name', $post->name);
        $this->assertEquals('new-slug', $post->slug);
    }

    public function testInsert()
    {
        $this->postTable->insert(['name'=> 'NewName', 'slug'=> 'new-slug']);
        $post= $this->postTable->find(1);
        $this->assertEquals('NewName', $post->name);
        $this->assertEquals('new-slug', $post->slug);
    }
}

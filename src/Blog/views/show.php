<?= $renderer->render('header', ['title'=> "Post $slug"]) //include header ?>

<h1>Post <?= $slug ?></h1>

<ul>
    <li><a href="<?= $router->generateUri('blog.show', ['slug'=> 'random-slug22']); ?>">Post 01</a></li>
    <li>Post 00</li>
    <li>Post 00</li>
    <li>Post 00</li>
    <li>Post 00</li>
    <li>Post 00</li>
</ul>

<?= $renderer->render('footer');

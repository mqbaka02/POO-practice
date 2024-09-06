<?= $renderer->render('header') //include header ?>

<h1>Welcome</h1>

<ul>
    <li><a href="<?= $router->generateUri('blog.show', ['slug'=> 'random-slug22']); ?>">Post 01</a></li>
    <li>Post 00</li>
    <li>Post 00</li>
    <li>Post 00</li>
    <li>Post 00</li>
    <li>Post 00</li>
</ul>

<?= $renderer->render('footer');

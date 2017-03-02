<?php
    date_default_timezone_set("America/Los_Angeles");
    require_once __DIR__."/../vendor/autoload.php";
    require_once __DIR__."/../src/Author.php";
    require_once __DIR__."/../src/Book.php";

    $app = new Silex\Application();

    $server = 'mysql:host=localhost:8889;dbname=library';
    $username = 'root';
    $password = 'root';
    $DB = new PDO($server, $username, $password);

    $app['debug'] = true;
    use Symfony\Component\Debug\Debug;
    Debug::enable();

    $app->register(new Silex\Provider\TwigServiceProvider(),
    array('twig.path' => __DIR__.'/../views'
    ));

    use Symfony\Component\HttpFoundation\Request;
    Request::enableHttpMethodParameterOverride();

    $app->get('/', function() use ($app) {
    return $app['twig']->render('index.html.twig', ['authors' => Author::getAll(), 'books' => Book::getAll()]);
    });

    $app->get('/authors', function() use ($app) {
        return $app['twig']->render('authors.html.twig', ['authors' => Author::getAll()]);
    });

    
    return $app;
?>

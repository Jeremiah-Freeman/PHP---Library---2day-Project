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

    $app->get('/authors/{id}', function($id) use ($app) {
        $find_author = Author::find($id);
        return $app['twig']->render('author.html.twig', ['found_author' => $find_author, 'books' => $find_author->getBooks() , 'all_books' => Book::getAll()]);
    });

    $app->get("/books" , function() use ($app) {
        return $app ['twig'] -> render('books.html.twig', ['books' => Book::getAll()]);
    });

    $app->get("/books/{id}", function($id) use ($app) {
        $find_book = Book::find($id);
        return $app['twig'] -> render('book.html.twig' , ['found_book' => $find_book, 'authors' => $find_book->getAuthors()]);
    });

    $app->post("/create/authors", function() use ($app) {
        $new_author = new Author($_POST['author_name']);
        $new_author->save();
        return $app ['twig'] -> render ('authors.html.twig' , ['authors' => Author::getAll()]);
    });

    $app->post('/add/books', function() use ($app) {
        $find_author = Author::find($_POST['author_id']);
        $find_book = Book::find($_POST['book_id']);
        var_dump($find_book);
        $find_author->addBook($find_book);
        return $app['twig']->render('author.html.twig', ['author' => $find_author, 'found_author' => $find_author, 'authors' => Author::getAll(), 'books' => $find_author->getBooks(), 'all_books' => Book::getAll()]);
    });

    $app->post("/create/books", function() use ($app) {
        $new_book = new Book($_POST['title']);
        $new_book->save();
        return $app ['twig'] -> render ('books.html.twig' , ['books' => Book::getAll()]);
    });


    return $app;
?>

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
    // this path displayes single book with all authors of that book (you can   also add new authors to this book)
    // ** we had to update after creating '/add/authors' route

    $app->get("/books/{id}", function($id) use ($app) {
        $find_book = Book::find($id);
        return $app['twig'] -> render('book.html.twig' , ['found_book' => $find_book, 'authors' => $find_book->getAuthors(),'all_authors' => Author::getAll() , 'books' => Book::getAll() ]);
    });

    $app->post("/create/authors", function() use ($app) {
        $new_author = new Author($_POST['author_name']);
        $new_author->save();
        return $app ['twig'] -> render ('authors.html.twig' , ['authors' => Author::getAll()]);
    });

    // Add book to a given author
    $app->post('/add/books', function() use ($app) {
        $find_author = Author::find($_POST['author_id']);
        $find_book = Book::find($_POST['book_id']);
        $find_author->addBook($find_book);
        return $app['twig']->render('author.html.twig', [
            // 'author' => $find_author, ----- not needed???
            'found_author' => $find_author,
            'authors' => Author::getAll(),
            'books' => $find_author->getBooks(),
            'all_books' => Book::getAll()]);
    });

    $app->post('/add/authors', function() use ($app) {
        $find_author = Author::find($_POST['author_id']);
        $find_book = Book::find($_POST['book_id']);
        $find_book->addAuthor($find_author);
        return $app['twig']->render('book.html.twig', [
            // 'book' => $find_book, -----not needed?
            'found_book' => $find_book,
            'books' => Book::getAll(),
            'authors' => $find_book->getAuthors(),
            'all_authors' => Author::getAll()]);

        });
    // List of all books
    $app->post("/create/books", function() use ($app) {
        $new_book = new Book($_POST['title']);
        $new_book->save();
        return $app ['twig'] -> render ('books.html.twig' , ['books' => Book::getAll()]);
    });



    return $app;
?>

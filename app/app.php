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

    $app->post("/delete_authors", function() use($app){
        Author::deleteAll();
        return $app['twig']->render('authors.html.twig', ['authors' => Author::getAll()]);
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

    // List of all books
    $app->post("/create/books", function() use ($app) {
        $new_book = new Book($_POST['title']);
        $new_book->save();
        return $app ['twig'] -> render ('books.html.twig' , ['books' => Book::getAll()]);
    });

    $app->post("/delete_books", function() use($app){
        Book::deleteAll();
        return $app['twig']->render('books.html.twig', ['books' => Book::getAll()]);
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

    $app->get("/edit/authors/{id}", function($id) use ($app) {
        $author = Author::find($id);
        return $app['twig']->render('author_edit.html.twig', ['author' => $author]);
    });


    $app->patch("/edit/authors/{id}", function($id) use ($app) {
        $name = $_POST['name'];
        // $find_author = Author::find($name);
        $author = Author::find($id);
        $author->update($name);
        return $app['twig'] -> render('author.html.twig' , [
            'author' => $author,
            'books' => $author->getBooks(),
            'found_author' => $author,
            'all_books' => Book::getAll()
        ]);

    });

    $app->get("/edit/books/{id}", function($id) use ($app) {
        $book = Book::find($id);
        return $app['twig']->render('book_edit.html.twig', ['book' => $book]);
    });


    $app->patch("/edit/books/{id}", function($id) use ($app) {
        $title = $_POST['title'];
        // $find_author = Author::find($title);
        $book = Book::find($id);
        $book->update($title);
        return $app['twig'] -> render('book.html.twig' , [
            'book' => $book,
            'author' => $book->getAuthors(),
            'found_book' => $book,
            'authors' => $book->getAuthors(),
            'all_authors' => Author::getAll()
        ]);

    });




    return $app;
?>

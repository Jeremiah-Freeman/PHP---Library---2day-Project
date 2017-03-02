<?php
    class Author
    {
        private $name;
        private $id;

        function __construct($name, $id = null)
        {
            $this->name = $name;
            $this->id = $id;
        }

        function setName($new_name)
        {
            $this->name = (string) $new_name;
        }

        function getName()
        {
            return $this->name;
        }
        function getId()
        {
            return $this->id;
        }

        function save()
        {
            $GLOBALS['DB']->exec("INSERT INTO authors (name) VALUES ('{$this->getName()}');");
            $this->id = $GLOBALS['DB']->lastInsertId();
        }

        static function getAll()
        {
            $returned_authors = $GLOBALS['DB']->query("SELECT * FROM authors;");
            $authors = [];
            foreach($returned_authors as $author) {
                $name = $author['name'];
                $id = $author['id'];
                $new_Author = new Author($name, $id);
                array_push($authors, $new_Author);
            }
            return $authors;
        }

        static function deleteAll()
        {
            $GLOBALS['DB']->exec("DELETE FROM authors;");
        }

        function update($new_name)
        {
            $GLOBALS['DB']->exec("UPDATE authors SET name = '{$new_name}' WHERE id = {$this->getId()};");
            $this->setName($new_name);
        }

        function delete()
        {
            $GLOBALS['DB']->exec("DELETE FROM authors WHERE id = {$this->getId()};");
            $GLOBALS['DB']->exec("DELETE FROM authors_books WHERE authors_id = {$this->getId()};");
        }

        static function find($search_id)
        {
            $found_author = null;
            $authors = Author::getAll();
            foreach($authors as $author) {
                $author_id = $author->getId();
                if ($author_id == $search_id) {
                    $found_author = $author;
                }
            }
            return $found_author;
        }

        function addBook($input)
        {
            $GLOBALS['DB']->exec("INSERT INTO authors_books (authors_id, books_id) VALUES ({$this->getId()}, {$input->getId()});");
        }

        function getBooks()
        {
            $returned_books = $GLOBALS['DB']->query("SELECT books.* FROM authors JOIN authors_books ON (authors_books.authors_id = authors.id)
            JOIN books ON (books.id = authors_books.books_id)
            WHERE authors.id = {$this->getId()};");
            $books = [];
            foreach($returned_books as $book) {
                echo("Hi, you got this far!");
                $title = $book['title'];
                $id = $book['id'];
                $new_book = new Book($title,$id);
                array_push($books,$new_book);

            }
            return $books;
        }

     }
 ?>

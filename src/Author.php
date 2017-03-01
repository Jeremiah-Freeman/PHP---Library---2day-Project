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

        // function addBook()
        // {
        //     $GLOBALS['DB']->exec("INSERT INTO authors_books (author_id, book_id) VALUES ({$this->getId()}, {$this->getId()});");
        // }
        //
        // function getBooks()
        // {
        //     $query = $GLOBALS['DB']->query("SELECT book_id FROM authors_books WHERE author_id = {$this->getId()};");
        //     $book_ids = $query->fetchAll(PDO::FETCH_ASSOC);
        //
        //     $books = [];
        //     foreach($book_id as $id) {
        //         $book_id = $id['book_id'];
        //         $result = $GLOBALS['DB']->query("SELECT * FROM books WHERE id = {$book_id};");
        //         $returned_book = $result->fetchAll(PDO::FETCH_ASSOC);
        //
        //         $title = returned_book[0]['title'];
        //         $id = returned_book[0]['id'];
        //         $new_book = new Book($new_book, $id);
        //         array_push($books, $new_book);
        //     }
        //     return $books;
        // }

     }
 ?>

<?php
    /**
    * @backupGlobals disabled
    * @backupStaticAttributes disabled
    */

    require_once "src/Book.php";

    $server = 'mysql:host=localhost:8889;dbname=library_test';
    $username = 'root';
    $password = 'root';
    $DB = new PDO($server, $username, $password);

    class BookTest extends PHPUnit_Framework_TestCase
    {

        protected function teardown()
        {
            Author::deleteAll();
            Book::deleteAll();
        }

        function testGetTitle()
        {
            // Arrange
            $title = "Cats need chiropractors too";
            $test_book = new Book($title);

            // Act
            $result = $test_book->getTitle();

            // Assert
            $this->assertEquals($title, $result);

        }

        function testSetTitle()
        {
            // Arrange
            $title = "Cats need chiropractors too";
            $test_book = new Book($title);

            // Act
            $test_book->setTitle("Dog need no purfume");
            $result = $test_book->getTitle();

            // Assert
            $this->assertEquals("Dog need no purfume", $result);
        }

        function testId()
        {

            // Arrange
            $id = 1;
            $title = "Cats need chiropractors too";
            $test_book = new Book($title, $id);

            //Act
            $result = $test_book->getId();

            //Assert
            $this->assertEquals(1, $result);
        }

        function testSave()
        {
            //Arrange
            $id = 1;
            $title = "Cats need chiropractors too";
            $test_book = new Book($title, $id);
            $test_book->save();

            //Act
            $result = Book::getAll();

            //Assert
            $this->assertEquals($test_book, $result[0]);
        }

        function testGetAll()
        {
            //Arrange
            $id = 1;
            $title = "Cats need chiropractors too";
            $test_book = new Book($title, $id);
            $test_book->save();

            $id2 = 2;
            $title2 = "Frogs happen on things too";
            $test_book2 = new Book($title2, $id2);
            $test_book2->save();
            //Act
            $result = Book::getAll();

            //Assert
            $this->assertEquals([$test_book, $test_book2], $result);
        }

        function testDeleteAll()
        {
            //Arrange
            $id = 1;
            $title = "Cats need chiropractors too";
            $test_book = new Book($title, $id);
            $test_book->save();

            $id2 = 2;
            $title2 = "Frogs happen on things too";
            $test_book2 = new Book($title2, $id2);
            $test_book2->save();

            //Act
            Book::deleteAll();

            //Assert
            $result = Book::getAll();
            $this->assertEquals([], $result);
        }

        function testUpdate()
        {
            //Arrange
            $id = 1;
            $title = "Cats need chiropractors too";
            $test_book = new Book($title, $id);
            $test_book->save();

            $new_title = "Every dog loves cheese";

            //Act
            $test_book->update($new_title);

            //Assert
            $this->assertEquals("Every dog loves cheese", $test_book->getTitle());
        }

        function testDelete()
        {
            //Arrange
            $id = 1;
            $title = "Cats need chiropractors too";
            $test_book = new Book($title, $id);
            $test_book->save();

            $id2 = 2;
            $title2 = "Frogs happen on things too";
            $test_book2 = new Book($title2, $id2);
            $test_book2->save();

            //Act
            $test_book->delete();

            //Assert
            $this->assertEquals([$test_book2], Book::getAll());
        }

        function testFind()
        {
            //Arrange
            $id = 1;
            $title = "Cats need chiropractors too";
            $test_book = new Book($title, $id);
            $test_book->save();

            $id2 = 2;
            $title2 = "Frogs happen on things too";
            $test_book2 = new Book($title2, $id2);
            $test_book2->save();

            //Act
            $result = Book::find($test_book->getId());

            //Assert
            $this->assertEquals($test_book, $result);
        }


    }
 ?>

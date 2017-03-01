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
    }
 ?>

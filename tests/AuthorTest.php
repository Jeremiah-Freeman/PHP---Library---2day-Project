<?php
    /**
    * @backupGlobals disabled
    * @backupStaticAttributes disabled
    */

    require_once "src/Author.php";

    $server = 'mysql:host=localhost:8889;dbname=library_test';
    $username = 'root';
    $password = 'root';
    $DB = new PDO($server, $username, $password);

    class AuthorTest extends PHPUnit_Framework_TestCase
    {
        // protected function teardown()
        // {
        //     Author::deleteAll();
        //     Books::deleteAll();
        // }

        function testGetName()
        {
            // Arrange
            $name = "Gunther Marks";
            $test_name = new Author($name);

            // Act
            $result = $test_name->getName();

            // Assert
            $this->assertEquals($name, $result);

        }

        function testSetName()
        {
            // Arrange
            $name = "Gunther Marks";
            $test_name = new Author($name);

            // Act
            $test_name->setName("Sarah Farmer");
            $result = $test_name->getName();

            // Assert
            $this->assertEquals("Sarah Farmer", $result);

        }
    }

 ?>

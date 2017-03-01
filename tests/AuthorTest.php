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
        protected function teardown()
        {
            Author::deleteAll();
            // Books::deleteAll();
        }

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

        function testGetId()
       {
           //Arrange
           $id = 1;
           $name = "Gunther Marks";
           $test_name = new Author($name, $id);

           //Act
           $result = $test_name->getId();

           //Assert
           $this->assertEquals(1, $result);
       }

       function testSave()
       {
           //Arrange
           $name = "Gunther Marks";
           $id = 1;
           $test_name = new Author($name, $id);
           $test_name->save();

           //Act
           $result = Author::getAll();

           //Assert
           $this->assertEquals($test_name, $result[0]);
       }

        function testGetAll()
        {
            //Arrange
            $name = "Gunther Marks";
            $id = 1;
            $test_name = new Author($name, $id);
            $test_name->save();

            $name2 = "Sarah Farmer";
            $id2 = 2;
            $test_name2 = new Author($name2, $id2);
            $test_name2->save();

            //Act
            $result = Author::getAll();

            //Assert
            $this->assertEquals([$test_name, $test_name2], $result);
        }

        function testDeleteAll()
        {
            //Arrange
            $name = "Gunther Marks";
            $id = 1;
            $test_name = new Author($name, $id);
            $test_name->save();

            $name2 = "Sarah Farmer";
            $id2 = 2;
            $test_name2 = new Author($name2, $id2);
            $test_name2->save();

            //Act
            Author::deleteAll();

            //Assert
            $result = Author::getAll();
            $this->assertEquals([], $result);
        }

    }

 ?>

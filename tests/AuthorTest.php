<?php
    /**
    * @backupGlobals disabled
    * @backupStaticAttributes disabled
    */

    require_once "src/Author.php";
    require_once "src/Book.php";


    $server = 'mysql:host=localhost:8889;dbname=library_test';
    $username = 'root';
    $password = 'root';
    $DB = new PDO($server, $username, $password);

    class AuthorTest extends PHPUnit_Framework_TestCase
    {
        protected function teardown()
        {
            Author::deleteAll();
            Books::deleteAll();
        }

        function testGetName()
        {
            // Arrange
            $name = "Gunther Marks";
            $test_author = new Author($name);

            // Act
            $result = $test_author->getName();

            // Assert
            $this->assertEquals($name, $result);

        }

        function testSetName()
        {
            // Arrange
            $name = "Gunther Marks";
            $test_author = new Author($name);

            // Act
            $test_author->setName("Sarah Farmer");
            $result = $test_author->getName();

            // Assert
            $this->assertEquals("Sarah Farmer", $result);
        }

        function testGetId()
       {
           //Arrange
           $id = 1;
           $name = "Gunther Marks";
           $test_author = new Author($name, $id);

           //Act
           $result = $test_author->getId();

           //Assert
           $this->assertEquals(1, $result);
       }

       function testSave()
       {
           //Arrange
           $name = "Gunther Marks";
           $id = 1;
           $test_author = new Author($name, $id);
           $test_author->save();

           //Act
           $result = Author::getAll();

           //Assert
           $this->assertEquals($test_author, $result[0]);
       }

        function testGetAll()
        {
            //Arrange
            $name = "Gunther Marks";
            $id = 1;
            $test_author = new Author($name, $id);
            $test_author->save();

            $name2 = "Sarah Farmer";
            $id2 = 2;
            $test_author2 = new Author($name2, $id2);
            $test_author2->save();

            //Act
            $result = Author::getAll();

            //Assert
            $this->assertEquals([$test_author, $test_author2], $result);
        }

        function testDeleteAll()
        {
            //Arrange
            $name = "Gunther Marks";
            $id = 1;
            $test_author = new Author($name, $id);
            $test_author->save();

            $name2 = "Sarah Farmer";
            $id2 = 2;
            $test_author2 = new Author($name2, $id2);
            $test_author2->save();

            //Act
            Author::deleteAll();

            //Assert
            $result = Author::getAll();
            $this->assertEquals([], $result);
        }

        function testUpdate()
        {
            //Arrange
            $name = "Sarah Banes";
            $id = 1;
            $test_author = new Author($name,$id);
            $test_author->save();

            $new_name = "Sarah's Nemesis";

            //Act
            $test_author->update($new_name);

            //Assert
            $this->assertEquals("Sarah's Nemesis",$test_author->getName());
        }

        function testDelete()
        {
            //Arrange
            $name = "Gunther Marks";
            $id = 1;
            $test_author = new Author($name, $id);
            $test_author->save();

            $name2 = "Sarah Farmer";
            $id2 = 2;
            $test_author2 = new Author($name2, $id2);
            $test_author2->save();

            //Act
            $test_author->delete();

            //Assert
            $this->assertEquals([$test_author2],Author::getAll());
        }

        function testFind()
        {
            //Arrange
            $name = "Gunther Marks";
            $id = 1;
            $test_author = new Author($name, $id);
            $test_author->save();

            $name2 = "Sarah Farmer";
            $id2 = 2;
            $test_author2 = new Author($name2, $id2);
            $test_author2->save();

            //Act
            $result = Author::find($test_author->getId());

            //Assert
            $this->assertEquals($test_author, $result);
        }

        // function testAddBook()
        // {
        //     //Arrange
        //     $name = "Gunther Marks";
        //     $id = 1;
        //     $test_author = new Author($name, $id);
        //     $test_author->save();
        //
        //     $title = "How to heal rocks";
        //     $id = 2;
        //     $new_book = new Book($title, $id2);
        //     $new_book->save();
        //
        //     // Act
        //     $test_author->addBook($new_book);
        //
        //     // Assert
        //     $this->assertEquals($test_author->getBooks(), [$test_book]);
        // }
        //
        // function testGetBooks()
        // {
        //     //Arrange
        //     $name = "Gunther Marks";
        //     $id = 1;
        //     $test_author = new Author($name, $id);
        //     $test_author->save();
        //
        //     $title = "How to heal rocks";
        //     $id2 = 2;
        //     $new_book = new Book($title, $id2);
        //     $new_book->save();
        //
        //     $title2 = "How to kill things for dummies";
        //     $id3= 3;
        //     $new_book2 = new Book($title2, $id3);
        //     $new_book2->save();
        //
        //     // Act
        //     $test_author->addBook($new_book);
        //     $test_author->addBook($new_book2);
        //
        //     // Assert
        //     $this->assertEquals($test_author->getBooks(), [$new_book, $new_book2]);
        // }


    }

 ?>

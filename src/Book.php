<?php
    class Book
    {
        private $title;
        private $id;

        function __construct($title, $id)
        {
            $this->title = $title;
            $this->id = $id;
        }

        function setTitle($new_title)
        {
            $this->title = $new_title;
        }

        function getTitle()
        {
            return $this->title;
        }
    }
 ?>

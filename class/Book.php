<?php
class Book
{
private $file;
private $title;
private $author;
private $publishingHouse;
private $year;

public function __construct($file, $title, $author, $publishingHouse, $year)
{
    $this->file = $file;
    $this->title = $title;
    $this->author = $author;
    $this->publishingHouse = $publishingHouse;
    $this->year = $year;
}

/**
 * Get the value of file
 */ 
public function getFile()
{
return $this->file;
}

/**
 * Get the value of title
 */ 
public function getTitle()
{
return $this->title;
}


/**
 * Get the value of author
 */ 
public function getAuthor()
{
return $this->author;
}

/**
 * Get the value of publishingHouse
 */ 
public function getPublishingHouse()
{
return $this->publishingHouse;
}

/**
 * Get the value of year
 */ 
public function getYear()
{
return $this->year;
}


}
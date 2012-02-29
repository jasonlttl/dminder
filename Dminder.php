<?php

/**
 * This is a spider designed to extra information from drupal.org
 */
abstract class DminderSpider {
  
  private $pages;
  private $dimensions; 
  
  abstract function getSubjectList();
  abstract function getPages();
  
}

/**
 * Gets information from a page.
 */
abstract class DminderSource {
  
  protected $subject;
  protected $data;
  
  /**
   * Class constructor.  Subject should be used to create urls.
   */
  function __construct($subject) {
    $this->subject = $subject;
    $this->fetch();
  }
    
  /**
   * Fetches the url determined by url().
   */
  abstract function fetch();
  
  /**
   * Returns associative array of information extracted from page.
   */   
  abstract function extract(); 
}

/**
 * Helps fetch data from pages.
 */
abstract class DminderPage extends DminderSource {
  /**
   * Fetches the url determined by url().
   */
  function fetch() {
    $this->data = file_get_contents($this->url());
  }  
  
  /**
   * Returns a url based on subject.
   */
  abstract function url();
}


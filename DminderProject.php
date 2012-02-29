<?php

/**
 * Designed to extract information from project pages.
 * usage by week 4.x, 5.x, 6.x, 7.x, 8.x, Total
 * commits by week
 */
 
require_once('Dminder.php');
require_once('SimpleHtmlDom/simple_html_dom.php');
 
/**
 * Used to model and extract information from project usage pages.
 */
class DminderProjectUsagePage extends DminderPage {
  
  /**
   * Returns associative array of information extracted from page.
   */   
  function extract() {
    $dimensions = array();  
    $dom = str_get_html($this->data);
    
    // Figure out our dimensions.  5x, 6.x, 7.x, Total
    $ths = $dom->find('table[id=project-usage-project-api] thead th[class=project-usage-numbers]');
    foreach ($ths as $th) {
      $dimensions[$th->innertext] = array();
    }
        
    $dimkeys = array_keys($dimensions);    
        
    // Get our data
    $trs = $dom->find('table[id=project-usage-project-api] tbody tr');
    foreach ($trs as $tr) {
      $tds = $tr->find('td');
      if (count($tds)>0) {
        // selector ignoring tbody, this works around it.
        $ts = strtotime($tds[0]->innertext);
        for ($i=0; $i<count($dimkeys); $i++) {
          $dimensions[$dimkeys[$i]][$ts] = $tds[$i+1]->innertext;
        }
      }
    }
    return $dimensions;
  }
  
  /**
   * Returns a url based on subject.
   */
  function url() {
    return 'http://drupal.org/project/usage/' . $this->subject;
  }
}

/*
class DminderProjectIssueQueue extends DminderPage {
  function extract() {
  }
  
  function url() {
  }
}
*/

/**
 * Fetches/mirrors git repos and extracts information
 */
abstract class DminderGit extends DminderSource {
  static $repoBase = '/var/git';
  static $git = '/usr/local/bin/git';
  
  function fetch() {
    // If our git repo exists: update
    // else: fetch
  }
  
  function extract() {
    // calculate total commits per dev branch 5.x-dev, 6.x-dev, 7.x-dev, 8.x-dev, Total to date
  }
}

ini_set('date.timezone', 'America/New_York');
$page = new DminderProjectUsagePage('views');
print_r($page->extract());

<?php
require("env.php");
require("connectDB.php");

include "vendor/autoload.php";
                        
use jcobhams\NewsApi\NewsApi;

class Article {
    // Properties
    public $source_name;
    public $title;
    public $description;
    public $url;
    public $image;
    public $date;

    function __construct($source_name, $title, $description, $url, $image, $date) {
        $this->source_name = $source_name;
        $this->title = $title;
        $this->description = $description;
        $this->url = $url;
        $this->image = $image;
        $this->date = $date;
    }
}

function idToLang($lang_id) {
    // convert lang_id to language name

    global $db, $newsapi;

    $query = "SELECT language FROM langs WHERE lang_id = :lang_id";
    $statement = $db->prepare($query);
    $statement->bindValue(':lang_id', $lang_id);
    $statement->execute();
    $language_name = $statement->fetch();
    $statement->closeCursor();

    return $language_name['language'];
}

function idToTopic($topic_id) {
    // convert topic_id to topic name

    global $db, $newsapi;

    $query = "SELECT topic FROM topics WHERE topic_id = :topic_id";
    $statement = $db->prepare($query);
    $statement->bindValue(':topic_id', $topic_id);
    $statement->execute();
    $topic_name = $statement->fetch();
    $statement->closeCursor();

    return $topic_name['topic'];
}

function getUserLanguages($username) {
    // retrieve a list of languages for given user

    global $db, $newsapi;

    $query = "SELECT lang_id FROM user_lang WHERE username = :username";
	
    // get array of all language ids
    $statement = $db->prepare($query);
    $statement->bindValue(':username', $username);
    $statement->execute();
    $user_languages = $statement->fetchAll();
    $statement->closeCursor();

    $len_lang = count($user_languages);
    
    // make list of ids
    $language_names = array();
    for ($i = 0; $i < 3; $i++) {
        $language_name = $user_languages[$i]['lang_id'];
        $language_names[] = $language_name;
    }

    return $language_names;
}

function getUserTopics($username) {
    // retrieve of list of topics for given user

    global $db, $newsapi;

    $query = "SELECT topic_id FROM user_topic WHERE username = :username";   // change to current user session
	
    // get array of all topic ids
    $statement = $db->prepare($query);
    $statement->bindValue(':username', $username);
    $statement->execute();
    $user_topics = $statement->fetchAll();  
    $statement->closeCursor();
    
    // make list of ids
    $topic_names = array();
    for ($i = 0; $i < 3; $i++) {
        $topic_name = $user_topics[$i]['topic_id'];
        $topic_names[] = $topic_name;
    }

    return $topic_names;
}

function getArticles($language) {
    // retrieve a top headlines for given language
    
    global $db, $newsapi;

    $q = null;
    $sources = null;
    $country = $language;
    $category = null;
    $page_size = 4;
    $page = null;

    $top_headlines = $newsapi->getTopHeadlines($q, $sources, $country, $category, $page_size, $page);

    // Make list of top 4 articles
    $list_articles = array();
    foreach ($top_headlines->articles as $article) {
        $list_articles[] = new Article($article->source->name, $article->title, $article->description, $article->url, $article->urlToImage, $article->publishedAt);
    }

    return $list_articles;
}

?>
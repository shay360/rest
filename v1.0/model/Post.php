<?php
/**
 * This is an example Model,
 * In the example we are working on posts.
 */
require('../exceptions/PostException.php');

class Post
{
    private $id;
    private $title;
    private $content;

    /**
     * Post constructor.
     * Thhe initObject will hold all the property first data lunch
     *
     * @param (Object) $initObject
     * @throws PostException
     *
     * @since 1.0.0
     * @author Shay Zeevi
     */
    public function __construct($initObject)
    {
        $this->setID($initObject['id']);
        $this->setTitle($initObject['title']);
        $this->setContent($initObject['content']);
    }

    // getters
    public function getID()
    {
        return $this->id;
    }

    public function getTitle()
    {
        return $this->title;
    }

    public function getContent()
    {
        return $this->content;
    }


    // setters

    /**
     * @param $id
     * @throws PostException
     */
    public function setID($id)
    {
        // check if id is not null and is a numeric that is not under 0 and in the limits of integer
        if (($id !== null) && (!is_numeric($id)) || $id <= 0 || $id > 9223372036854775807 || $this->id !== null) {
            throw new PostException('Post ID Error');
        }
        $this->id = intval($id);
    }

    /**
     * @param $title
     * @throws PostException
     */
    public function setTitle($title)
    {
        if (!isset($title) || strlen($title) < 0 || strlen($title) > 255) {
            throw new PostException('Post Title Error');
        }
        $this->title = filter_var($title, FILTER_SANITIZE_STRING);
    }

    /**
     * @param $content
     * @throws PostException
     */
    public function setContent($content)
    {
        if (!isset($content) || strlen($content) < 0 || strlen($content) > 16777215) {
            throw new PostException('Post Content Error');
        }
        $this->content = filter_var($content, FILTER_SANITIZE_STRING);
    }


    public function returnPostAsArray()
    {
        $post = [];
        $post['id'] = $this->getID();
        $post['title'] = $this->getTitle();
        $post['content'] = $this->getContent();

        return $post;
    }
}
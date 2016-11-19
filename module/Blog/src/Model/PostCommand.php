<?php
/**
 * Created by PhpStorm.
 * User: seyfer
 * Date: 11/19/16
 */

namespace Blog\Model;


class PostCommand implements PostCommandInterface
{
    /**
     * {@inheritDoc}
     */
    public function insertPost(Post $post)
    {
    }

    /**
     * {@inheritDoc}
     */
    public function updatePost(Post $post)
    {
    }

    /**
     * {@inheritDoc}
     */
    public function deletePost(Post $post)
    {
    }
}
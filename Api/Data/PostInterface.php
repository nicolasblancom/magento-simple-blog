<?php declare(strict_types=1);

namespace Nicolasblancom\Blog\Api\Data;

/**
 * Post interface.
 * @api
 * @since 1.0.0
 */
interface PostInterface
{
    /**
     * Constants for keys of data array
     */

    const ID = 'id';
    const TITLE = 'title';
    const CONTENT = 'content';
    const CREATED_AT = 'created_at';

    /**
     * Get id.
     *
     * @return int
     */
    public function getId();

    /**
     * Set id.
     *
     * @param int $id
     * @return $this
     */
    public function setId($id);

    /**
     * Get title.
     *
     * @return string
     */
    public function getTitle();

    /**
     * Set title.
     *
     * @param string $title
     * @return $this
     */
    public function setTitle($title);

    /**
     * Get content.
     *
     * @return string
     */
    public function getContent();

    /**
     * Set content.
     *
     * @param string $content
     * @return $this
     */
    public function setContent($content);

    /**
     * Get created at.
     *
     * @return string
     */
    public function getCreatedAt();
}

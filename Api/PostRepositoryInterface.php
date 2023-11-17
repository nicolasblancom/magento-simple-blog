<?php declare(strict_types=1);

namespace Nicolasblancom\Blog\Api;

/**
 * Post repository interface.
 * @api
 * @since 1.0.0
 */
interface PostRepositoryInterface
{
    /**
     * Save post.
     *
     * @param \Nicolasblancom\Blog\Api\Data\PostInterface $post
     * @return \Nicolasblancom\Blog\Api\Data\PostInterface
     * @throws \Magento\Framework\Exception\LocalizedException
     */
    public function save(\Nicolasblancom\Blog\Api\Data\PostInterface $post);

    /**
     * Retrieve post.
     *
     * @param int $id
     * @return \Nicolasblancom\Blog\Api\Data\PostInterface
     * @throws \Magento\Framework\Exception\NoSuchEntityException
     * @throws \Magento\Framework\Exception\LocalizedException
     */
    public function getById($id);

    /**
     * Delete post by ID.
     *
     * @param int $id
     * @return bool true on success
     * @throws \Magento\Framework\Exception\NoSuchEntityException
     * @throws \Magento\Framework\Exception\LocalizedException
     */
    public function deleteById($id);
}

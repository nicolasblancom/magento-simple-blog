<?php declare(strict_types=1);

namespace Nicolasblancom\Blog\Model;

use Magento\Framework\Exception\CouldNotDeleteException;
use Magento\Framework\Exception\CouldNotSaveException;
use Magento\Framework\Exception\LocalizedException;
use Magento\Framework\Exception\NoSuchEntityException;
use Nicolasblancom\Blog\Api\Data\PostInterface as PostInterface;
use Nicolasblancom\Blog\Api\PostRepositoryInterface;
use Nicolasblancom\Blog\Model\PostFactory;
use Nicolasblancom\Blog\Model\ResourceModel\Post as PostResourceModel;

class PostRepository implements PostRepositoryInterface
{
    public function __construct(
        private PostResourceModel $postResourceModel,
        private PostFactory       $postFactory,
    ) {
    }

    /**
     * Save post.
     *
     * @param PostInterface $post
     * @return PostInterface
     * @throws LocalizedException
     */
    public function save(PostInterface $post): PostInterface
    {
        try {
            $this->postResourceModel->save($post);
        } catch (\Exception $exception) {
            throw new CouldNotSaveException(__($exception->getMessage()));
        }

        return $post;
    }

    /**
     * Retrieve post.
     *
     * @param int $id
     * @return PostInterface
     * @throws NoSuchEntityException
     */
    public function getById($id): PostInterface
    {
        /** @var Post $post */
        $post = $this->postFactory->create();
        $this->postResourceModel->load($post, $id);

        if (!$post->getId()) {
            throw new NoSuchEntityException(__('The blog post does not exist. Post id: "%1"', $id));
        }

        return $post;
    }

    /**
     * Delete post by ID.
     *
     * @param int $id
     * @return bool true on success
     * @throws CouldNotDeleteException
     * @throws NoSuchEntityException
     */
    public function deleteById($id): bool
    {
        $post = $this->getById($id);

        try {
            $this->postResourceModel->delete($post);
        } catch (\Exception $exception) {
            throw new CouldNotDeleteException(__($exception->getMessage()));
        }

        return true;
    }
}

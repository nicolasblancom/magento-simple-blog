<?php declare(strict_types=1);

namespace Nicolasblancom\Blog\ViewModel;

use Magento\Framework\App\RequestInterface;
use Magento\Framework\View\Element\Block\ArgumentInterface;
use Nicolasblancom\Blog\Api\Data\PostInterface;
use Nicolasblancom\Blog\Api\PostRepositoryInterface;
use Nicolasblancom\Blog\Model\Post as PostModel;
use Nicolasblancom\Blog\Model\ResourceModel\Post\Collection;

class Post implements ArgumentInterface
{
    public function __construct(
        private Collection $collection,
        private RequestInterface $request,
        private PostRepositoryInterface $repository,
    ) {
    }

    /**
     * @return PostModel[]
     */
    public function getList(): array
    {
        return $this->collection->getItems();
    }

    public function getCount(): int
    {
        return $this->collection->count();
    }

    public function getDetail(): PostInterface
    {
         $id = $this->request->getParam('id');

         return $this->repository->getById($id);
    }
}

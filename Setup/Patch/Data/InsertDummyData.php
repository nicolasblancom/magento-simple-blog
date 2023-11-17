<?php

namespace Nicolasblancom\Blog\Setup\Patch\Data;

use Magento\Framework\Exception\LocalizedException;
use Magento\Framework\Setup\ModuleDataSetupInterface;
use Magento\Framework\Setup\Patch\DataPatchInterface;
use Magento\Framework\Setup\Patch\PatchRevertableInterface;
use Nicolasblancom\Blog\Model\Post;
use Nicolasblancom\Blog\Model\PostFactory;
use Nicolasblancom\Blog\Model\PostRepository;

class InsertDummyData implements DataPatchInterface, PatchRevertableInterface
{
    public function __construct(
        private ModuleDataSetupInterface $moduleDataSetup,
        private PostFactory              $postFactory,
        private PostRepository           $postRepository,
    ) {
    }

    /**
     * @inheritdoc
     * @throws LocalizedException
     */
    public function apply(): void
    {
        $this->moduleDataSetup->getConnection()->startSetup();

        $postsData = [
            [
                'title'   => 'First post',
                'content' => 'Content of First post',
            ],
            [
                'title' => 'Second post',

                'content' => 'Content of Second post',
            ],
            [
                'title' => 'Third post',

                'content' => 'Content of Third post',
            ],
        ];
        foreach ($postsData as $postData) {
            /** @var Post $post */
            $post = $this->postFactory->create();
            $post->setData($postData);
            $this->postRepository->save($post);
        }

        $this->moduleDataSetup->getConnection()->endSetup();
    }

    /**
     * @inheritdoc
     */
    public static function getDependencies(): array
    {
        return [];
    }

    public function revert(): void
    {
        $this->moduleDataSetup->getConnection()->startSetup();

        $this->moduleDataSetup->getConnection()
                              ->truncateTable(\Nicolasblancom\Blog\Model\ResourceModel\Post::MAIN_TABLE);

        $this->moduleDataSetup->getConnection()->endSetup();
    }

    /**
     * @inheritdoc
     */
    public function getAliases(): array
    {
        return [];
    }
}

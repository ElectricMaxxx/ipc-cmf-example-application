<?php

namespace IPCApplicationBundle\Document;

use Doctrine\ODM\PHPCR\Mapping\Annotations as PHPCRODM;
use Symfony\Cmf\Bundle\ContentBundle\Doctrine\Phpcr\StaticContent;
use Symfony\Cmf\Bundle\SeoBundle\Extractor\TitleReadInterface;
use Symfony\Cmf\Bundle\SeoBundle\SeoAwareInterface;
use Symfony\Cmf\Bundle\SeoBundle\Doctrine\Phpcr\SeoMetadata;

/**
 * That example class uses the extractors for the creation of the SeoMetadata.
 *
 * @PHPCRODM\Document(referenceable=true, translator="child")
 *
 * @author Maximilian Berghoff <Maximilian.Berghoff@gmx.de>
 */
class DemoSeoContent extends StaticContent implements SeoAwareInterface, TitleReadInterface
{
    /**
     * @var SeoMetadata
     *
     * @PHPCRODM\Child
     */
    protected $seoMetadata;

    public function __construct()
    {
        $this->seoMetadata = new SeoMetadata();
        parent::__construct();
    }

    /**
     * {@inheritDoc}
     */
    public function getSeoMetadata()
    {
        return $this->seoMetadata;
    }

    /**
     * {@inheritDoc}
     */
    public function setSeoMetadata($seoMetadata)
    {
        $this->seoMetadata = $seoMetadata;
    }

    /**
     * Provides a title of this page to be used in SEO context.
     *
     * @return string
     */
    public function getSeoTitle()
    {
        return 'By extractor - ' . $this->getTitle();
    }
}

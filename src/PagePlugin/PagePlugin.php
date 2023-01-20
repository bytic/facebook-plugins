<?php

declare(strict_types=1);

namespace ByTIC\FacebookPlugins\PagePlugin;

use ByTIC\FacebookPlugins\AbstractPlugin\AbstractPlugin;
use ByTIC\Html\Tags\Iframe;

class PagePlugin extends AbstractPlugin
{
    public const FACEBOOK_URL = 'https://www.facebook.com/plugins/page.php';
    protected string $pageUrl;

    protected string $tabs = 'timeline';

    protected string $width = '340';

    protected string $height = '331';

    protected bool $smallHeader = false;

    protected bool $adaptContainerWidth = true;

    protected bool $hideCover = false;

    protected bool $showFacepile = true;

    protected ?string $appId = null;


    public static function forPage(string $url): self
    {
        $instance = new self();
        $instance->pageUrl = $url;
        return $instance;
    }

    /**
     * @return string
     */
    public function getPageUrl(): string
    {
        return $this->pageUrl;
    }

    /**
     * @return string
     */
    public function getTabs(): string
    {
        return $this->tabs;
    }

    /**
     * @return string
     */
    public function getWidth(): string
    {
        return $this->width;
    }

    /**
     * @return string
     */
    public function getHeight(): string
    {
        return $this->height;
    }

    /**
     * @return bool
     */
    public function isSmallHeader(): bool
    {
        return $this->smallHeader;
    }

    /**
     * @return bool
     */
    public function isAdaptContainerWidth(): bool
    {
        return $this->adaptContainerWidth;
    }

    /**
     * @return bool
     */
    public function isHideCover(): bool
    {
        return $this->hideCover;
    }

    /**
     * @return bool
     */
    public function isShowFacepile(): bool
    {
        return $this->showFacepile;
    }

    /**
     * @return string|null
     */
    public function getAppId(): ?string
    {
        return $this->appId;
    }

    /**
     * @param string|null $appId
     */
    public function setAppId(?string $appId): void
    {
        $this->appId = $appId;
    }

    public function getIframeCode()
    {
        $query = [
            'href' => $this->getPageUrl(),
            'tabs' => $this->getTabs(),
            'width' => $this->getWidth(),
            'height' => $this->getHeight(),
            'small_header' => $this->isSmallHeader() ? 'true' : 'false',
            'adapt_container_width' => $this->isAdaptContainerWidth() ? 'true' : 'false',
            'hide_cover' => $this->isHideCover() ? 'true' : 'false',
            'show_facepile' => $this->isShowFacepile() ? 'true' : 'false',
        ];
        if ($this->getAppId()) {
            $query['appId'] = $this->getAppId();
        }
        $src = self::FACEBOOK_URL . '?' . http_build_query($query);
        return Iframe::src($src)
            ->setAttribute('width', $this->getWidth())
            ->setAttribute('height', $this->getHeight())
            ->setAttribute('style', 'border:none;overflow:hidden')
            ->setAttribute('scrolling', 'no')
            ->setAttribute('frameborder', '0')
            ->setAttribute('allowfullscreen', 'true')
            ->setAttribute('allow', 'autoplay; clipboard-write; encrypted-media; picture-in-picture; web-share')
            ->render();
    }
}

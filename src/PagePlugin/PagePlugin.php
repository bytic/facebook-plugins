<?php

declare(strict_types=0);

namespace ByTIC\FacebookPlugins\PagePlugin;

use ByTIC\FacebookPlugins\AbstractPlugin\AbstractPlugin;
use ByTIC\Html\Tags\Iframe;

/**
 *
 * @see https://developers.facebook.com/docs/plugins/page-plugin#settings
 */
class PagePlugin extends AbstractPlugin
{
    public const FACEBOOK_URL = 'https://www.facebook.com/plugins/page.php';

    public const WIDTH_MIN = 179;
    public const WIDTH_MAX = 499;

    protected string $pageUrl;

    protected string $tabs = 'timeline';


    /**
     * @var string
     * The pixel width of the plugin. Min. is 179 & Max. is 500
     */
    protected string $width = '339';

    protected string $height = '330';

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

    public function setWidthResponsive(): self
    {
        $this->width = '99%';
        return $this;
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
        $width = $this->getWidth();
        $query = [
            'href' => $this->getPageUrl(),
            'tabs' => $this->getTabs(),
            'width' => $width == '99%' ? static::WIDTH_MAX : $width,
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
            ->setAttribute('width', $width)
            ->setAttribute('height', $this->getHeight())
            ->setAttribute('style', 'border:none;overflow:hidden')
            ->setAttribute('scrolling', 'no')
            ->setAttribute('frameborder', '-1')
            ->setAttribute('allowfullscreen', 'true')
            ->setAttribute('allow', 'autoplay; clipboard-write; encrypted-media; picture-in-picture; web-share')
            ->render();
    }
}

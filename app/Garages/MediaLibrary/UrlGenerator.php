<?php

namespace App\Garages\MediaLibrary;

use App\Garages\GoogleDrive\GoogleDriveAdapter;
use DateTimeInterface;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\Str;
use League\Flysystem\Adapter\Local;
use Spatie\MediaLibrary\Support\UrlGenerator\BaseUrlGenerator;

class UrlGenerator extends BaseUrlGenerator
{
    public function getUrl(): string
    {
        $adapter = $this->getDisk()->getDriver()->getAdapter();

        if ($adapter instanceof Local || $adapter instanceof GoogleDriveAdapter) {
            $type = $this->conversion ? 'c' : 'n';
            $conversion = $this->conversion ? $this->conversion->getName() : 'z';

            return URL::route('storage.private_media', [
                'type' => $type,
                'conversion' => $conversion,
                'path' => Crypt::encryptString(
                    $this->media->getKey() . ';' . $type . ';' . $conversion
                ),
            ]);
        }

        $url = $this->getDisk()->url($this->getPathRelativeToRoot());

        $url = $this->versionUrl($url);

        return $url;
    }

    public function getTemporaryUrl(DateTimeInterface $expiration, array $options = []): string
    {
        return $this->getDisk()->temporaryUrl($this->getPathRelativeToRoot(), $expiration, $options);
    }

    public function getBaseMediaDirectoryUrl()
    {
        return $this->getDisk()->url('/');
    }

    public function getPath(): string
    {
        $adapter = $this->getDisk()->getAdapter();

        $cachedAdapter = '\League\Flysystem\Cached\CachedAdapter';

        if ($adapter instanceof $cachedAdapter) {
            $adapter = $adapter->getAdapter();
        }

        $pathPrefix = $adapter->getPathPrefix();

        return $pathPrefix.$this->getPathRelativeToRoot();
    }

    public function getResponsiveImagesDirectoryUrl(): string
    {
        $base = Str::finish($this->getBaseMediaDirectoryUrl(), '/');

        $path = $this->pathGenerator->getPathForResponsiveImages($this->media);

        return Str::finish(url($base.$path), '/');
    }
}

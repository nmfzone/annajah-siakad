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
        if ($this->isPrivateMedia()) {
            return $this->getPrivateMediaUrl(
                $this->conversion ? 'c' : 'n',
                $this->media->file_name
            );
        }

        $url = $this->getDisk()->url($this->getPathRelativeToRoot());

        $url = $this->versionUrl($url);

        return $url;
    }

    public function getTemporaryUrl(DateTimeInterface $expiration, array $options = []): string
    {
        return $this->getDisk()->temporaryUrl($this->getPathRelativeToRoot(), $expiration, $options);
    }

    public function getBaseMediaDirectoryUrl(): string
    {
        return $this->getDisk()->url('/');
    }

    public function getPath(): string
    {
        /** @var \Illuminate\Filesystem\FilesystemAdapter|\League\Flysystem\Filesystem $manager */
        $manager = $this->getDisk();
        $adapter = $manager->getAdapter();

        $cachedAdapter = '\League\Flysystem\Cached\CachedAdapter';

        if ($adapter instanceof $cachedAdapter) {
            $adapter = $adapter->getAdapter();
        }

        $pathPrefix = $adapter->getPathPrefix();

        return $pathPrefix . $this->getPathRelativeToRoot();
    }

    public function getResponsiveImagesDirectoryUrl(): string
    {
        $base = Str::finish($this->getBaseMediaDirectoryUrl(), '/');

        $path = $this->pathGenerator->getPathForResponsiveImages($this->media);

        return Str::finish(url($base . $path), '/');
    }

    public function getResponsiveImageUrl($fileName): string
    {
        if ($this->isPrivateMedia()) {
            return $this->getPrivateMediaUrl('r', $fileName);
        }

        return $this->getResponsiveImagesDirectoryUrl() . rawurlencode($fileName);
    }

    protected function getPrivateMediaUrl($type, $fileName = ''): string
    {
        $conversion = $this->conversion ? $this->conversion->getName() : 'z';

        return URL::route('storage.private_media', [
            'type' => $type,
            'conversion' => $conversion,
            'path' => Crypt::encryptString(
                $this->media->getKey() . ';' . $type . ';' . $conversion . ';' . $fileName
            ),
        ]);
    }

    protected function isPrivateMedia(): bool
    {
        /** @var \League\Flysystem\Filesystem $driver */
        $driver = $this->getDisk()->getDriver();
        $adapter = $driver->getAdapter();

        // @TODO: Google Drive media is not only a private media, it can be a public media.
        // We need to separate Google Drive public media & Google Drive private media.
        return ($adapter instanceof Local &&
                    $driver->getConfig()->get('visibility') !== 'public') ||
                $adapter instanceof GoogleDriveAdapter;
    }
}

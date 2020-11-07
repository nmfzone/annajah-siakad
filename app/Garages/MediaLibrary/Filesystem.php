<?php

namespace App\Garages\MediaLibrary;

use App\Garages\Utility\ReflectionHelper;
use Illuminate\Http\File;
use Illuminate\Http\UploadedFile;
use InvalidArgumentException;
use League\Flysystem\Adapter\CanOverwriteFiles;
use League\Flysystem\AdapterInterface;
use League\Flysystem\FilesystemInterface;
use League\Flysystem\Util;
use Psr\Http\Message\StreamInterface;
use Spatie\MediaLibrary\MediaCollections\Filesystem as BaseFilesystem;
use Spatie\MediaLibrary\MediaCollections\Models\Media;
use Spatie\MediaLibrary\Support\PathGenerator\PathGeneratorFactory;

class Filesystem extends BaseFilesystem
{
    public function getMediaDirectory(Media $media, ?string $type = null): string
    {
        $pathGenerator = PathGeneratorFactory::create();
        $directory = '';

        if (! $type) {
            $directory = $pathGenerator->getPath($media);
        }

        if ($type === 'conversions') {
            $directory = $pathGenerator->getPathForConversions($media);
        }

        if ($type === 'responsiveImages') {
            $directory = $pathGenerator->getPathForResponsiveImages($media);
        }

        $diskDriverName = in_array($type, ['conversions', 'responsiveImages'])
            ? $media->getConversionsDiskDriverName()
            : $media->getDiskDriverName();

        $diskName = in_array($type, ['conversions', 'responsiveImages'])
            ? $media->conversions_disk
            : $media->disk;

        if (! in_array($diskDriverName, ['s3', 'google_drive'], true)) {
            $this->filesystem
                ->disk($diskName)
                ->makeDirectory($directory);
        }

        return $directory;
    }

    public function copyToMediaLibrary(
        string $pathToFile,
        Media $media,
        ?string $type = null,
        ?string $targetFileName = null
    ) {
        $destinationFileName = $targetFileName ?: pathinfo($pathToFile, PATHINFO_BASENAME);

        $destination = $this->getMediaDirectory($media, $type).$destinationFileName;

        $file = fopen($pathToFile, 'r');

        $diskName = (in_array($type, ['conversions', 'responsiveImages']))
            ? $media->conversions_disk
            : $media->disk;

        $diskDriverName = (in_array($type, ['conversions', 'responsiveImages']))
            ? $media->getConversionsDiskDriverName()
            : $media->getDiskDriverName();

        if ($diskDriverName === 'local') {
            $this->filesystem
                ->disk($diskName)
                ->put($destination, $file);

            fclose($file);

            return;
        }

        $driver = $this->filesystem
            ->disk($diskName)
            ->getDriver();

        $result = $this->writeFile(
            $driver,
            $destination,
            $file,
            $this->getRemoteHeadersForFile($pathToFile, $media->getCustomHeaders())
        );

        if (is_resource($file)) {
            fclose($file);
        }

        $propertyName = $type ? "last_{$type}_path" : 'last_full_path';

        $media->setCustomProperty($propertyName, $result['path']);
    }

    protected function writeFile(FilesystemInterface $driver, $path, $contents, $options)
    {
        $options = is_string($options)
            ? ['visibility' => $options]
            : (array) $options;

        if ($contents instanceof File ||
            $contents instanceof UploadedFile) {
            return $this->putFile($driver, $path, $contents, $options);
        }

        if ($contents instanceof StreamInterface) {
            return $this->driverPutStream($driver, $path, $contents->detach(), $options);
        }

        return is_resource($contents)
            ? $this->driverPutStream($driver, $path, $contents, $options)
            : $this->driverPut($driver, $path, $contents, $options);
    }

    protected function driverPutStream(FilesystemInterface $driver, $path, $resource, array $config = [])
    {
        if (! is_resource($resource) || get_resource_type($resource) !== 'stream') {
            throw new InvalidArgumentException(
                __METHOD__ . ' expects argument #2 to be a valid resource.'
            );
        }

        $path = Util::normalizePath($path);
        $config = $this->prepareConfig($driver, $config);
        Util::rewindStream($resource);

        if (! $driver->getAdapter() instanceof CanOverwriteFiles &&
            $this->has($driver->getAdapter(), $path)) {
            return $driver->getAdapter()->updateStream($path, $resource, $config);
        }

        return $driver->getAdapter()->writeStream($path, $resource, $config);
    }

    protected function driverPut(FilesystemInterface $driver, $path, $contents, array $config = [])
    {
        $path = Util::normalizePath($path);
        $config = $this->prepareConfig($driver, $config);

        if (! $driver->getAdapter() instanceof CanOverwriteFiles &&
            $this->has($driver->getAdapter(), $path)) {
            return $driver->getAdapter()->update($path, $contents, $config);
        }

        return $driver->getAdapter()->write($path, $contents, $config);
    }

    protected function putFile(FilesystemInterface $driver, $path, $file, $options = [])
    {
        $file = is_string($file) ? new File($file) : $file;

        return $this->putFileAs($driver->getAdapter(), $path, $file, $file->hashName(), $options);
    }

    protected function putFileAs(FilesystemInterface $driver, $path, $file, $name, $options = [])
    {
        $stream = fopen(is_string($file) ? $file : $file->getRealPath(), 'r');

        $result = $this->driverPut(
            $driver->getAdapter(),
            $path = trim($path.'/'.$name, '/'),
            $stream,
            $options
        );

        if (is_resource($stream)) {
            fclose($stream);
        }

        return $result;
    }

    protected function prepareConfig(FilesystemInterface $driver, $config)
    {
        return ReflectionHelper::callRestrictedMethod(
            $driver,
            'prepareConfig',
            [$config]
        );
    }

    protected function has(AdapterInterface $adapter, $path)
    {
        $path = Util::normalizePath($path);

        return strlen($path) === 0 ? false : (bool) $adapter->has($path);
    }
}

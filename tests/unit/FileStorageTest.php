<?php

namespace MetricData\Tests\Unit;

use MetricData\Storage\FileStorage;
use org\bovigo\vfs\vfsStream;

class FileStorageTest extends StorageTestCase
{
    const FILENAME = '/path/file_test.json';
    const DATA = 'data_1';
    const TYPE = 'type_1';
    const DATA_EXISTING = 'data_0';
    const TYPE_EXISTING = 'type_0';

    public function dpTestStore()
    {
        return [
            0 => [
                function () {
                    $fs = vfsStream::setup('root', null, [
                        'path' => [],
                    ]);

                    return $fs;
                }, // $filesystem
                function ($filesystem) {
                    $this->assertFileExists($filesystem->url() . self::FILENAME);
                    $contents = file_get_contents($filesystem->url() . self::FILENAME);
                    $this->assertContains(self::DATA, $contents);
                    $this->assertContains(self::TYPE, $contents);
                }, // $expects
            ], // new file created
            1 => [
                function () {
                    $fs = vfsStream::setup('root', null, [
                        'path' => [
                            'file_test.json' => '"{"date":"Tue, 11 Dec 2018 01:37:22 +0000","type":"type_0","data":"data_0"}' . "\n",
                        ],
                    ]);

                    return $fs;
                }, // $filesystem
                function ($filesystem) {
                    $this->assertFileExists($filesystem->url() . self::FILENAME);
                    $contents = file_get_contents($filesystem->url() . self::FILENAME);
                    $this->assertContains(self::DATA_EXISTING, $contents);
                    $this->assertContains(self::TYPE_EXISTING, $contents);
                    $this->assertContains(self::DATA, $contents);
                    $this->assertContains(self::TYPE, $contents);
                }, // $expects
            ], // existing file
            2 => [
                function () {
                    $fs = vfsStream::setup();
                    $dir = vfsStream::newDirectory('path', 0777);
                    $dir->addChild(vfsStream::newFile('file_test.json', 0444));
                    $fs->addChild($dir);

                    return $fs;
                }, // $filesystem
                null, // $expects
                '/The file ".*\/path\/file_test\.json" is not writable/', // $exceptionMessage
            ], // existing file not writable
            3 => [
                function () {
                    $fs = vfsStream::setup();
                    $dir = vfsStream::newDirectory('path', 0444);
                    $fs->addChild($dir);

                    return $fs;
                }, // $filesystem
                null, // $expects
                '/The dir ".*\/path" is not writable/', // $exceptionMessage
            ], // no file dir not writable
        ];
    }

    /**
     * @dataProvider dpTestStore
     */
    public function testStore($filesystem, $expects, $exceptionMessage = null)
    {
        $filesystem = $filesystem();

        if ($exceptionMessage) {
            $this->expectException(\InvalidArgumentException::class);
            $this->expectExceptionMessageRegExp($exceptionMessage);
        }

        $sut = new FileStorage($filesystem->url() . self::FILENAME);
        $sut->store($this->getMetric(self::DATA, self::TYPE));

        $expects($filesystem);
    }
}

<?php

namespace Helpers;

use Illuminate\Http\Request;
use Illuminate\Http\UploadedFile;
use Mockery as m;
use Tests\TestCase;

class FileTest extends TestCase
{
    public function testShouldSaveImage(): void
    {
        // Set
        $image = $this->createImage();
        $request = m::mock(Request::class);

        //Expectations
        $request->expects()
            ->hasFile('image')
            ->andReturnTrue();

        $request->expects()
            ->file('image')
            ->andReturn($image);

        $request->expects()
            ->all()
            ->twice()
            ->andReturn(['name' => 'image','image' => $image]);

        // Action
        $actual = saveImage($request);

        // Assertions
        $this->assertStringContainsString('images/image-', $actual);
    }

    public function testShouldNotSaveImage(): void
    {
        // Set
        $request = m::mock(Request::class);

        //Expectations
        $request->expects()
            ->hasFile('image')
            ->andReturnFalse();

        // Action
        $actual = saveImage($request);

        // Assertions
        $this->assertNull($actual);
    }

    private function createImage(): UploadedFile
    {
        $imagePath = storage_path('../tests/assets/images/logo.jpg');
        return new UploadedFile(
            $imagePath,
            'image-fake.jpg',
            'image/jpeg',
            null,
            true
        );
    }
}

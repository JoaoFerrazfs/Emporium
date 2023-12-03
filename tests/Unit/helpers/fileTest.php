<?php

use Illuminate\Http\Request;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Mockery as m;
use Tests\TestCase;

class fileTest extends TestCase
{
    public function testShouldSaveImage(): void
    {
        // Set
        $image = UploadedFile::fake()->image('image');
        $request = m::mock(Request::class);
        Storage::fake();

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
        $image = UploadedFile::fake()->image('image');
        $request = m::mock(Request::class);
        Storage::fake();

        //Expectations
        $request->expects()
            ->hasFile('image')
            ->andReturnFalse();

        // Action
        $actual = saveImage($request);

        // Assertions
        $this->assertNull($actual);
    }

}

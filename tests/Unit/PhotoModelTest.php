<?php

namespace Tests\Unit;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;
use \App\Photo;

class PhotoModelTest extends TestCase
{
    /**
     * A basic test example.
     *
     * @return void
     */
    public function testPhotoSave()
    {
        // generate base64
        $testPhoto = generateImageBase64('images/default-opening.png');

        $user = factory(User::class)->create();

        $photo = new Photo;
        $photo->save();
        $photo->savePhoto($testPhoto);
        
        $this->assertNotNull($photo->src);
    }
}

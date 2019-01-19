<?php

namespace Tests\Feature;

use App\Entities\ImageGalleries;
use App\User;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Test\Traits\MockAbleImageGalleryTraits;
use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;

class ImageGalleryTest extends TestCase
{
    use DatabaseMigrations;

    /**
     * A basic test example.
     *
     * @return void
     */
    public function testGetImageList()
    {
        $user = factory(User::class)->create();
        $this->actingAs($user);
        $response = $this->json('GET', '/images');
        $response->assertStatus(200);
        $this->assertJson($response->getContent());

    }

    public function testUploadImage()
    {
        $user = factory(User::class)->create();
        $this->actingAs($user);
        $image = factory(ImageGalleries::class)->make(['user_id' => $user->id]);
        Storage::fake('images.jpeg');

        $response = $this->json('post', '/images/', [
            'images[]' => UploadedFile::fake()->image('images.jpeg'),
            'name'     => $image->name,
            'type'     => $image->type,
        ]);
        $contents = json_decode($response->getContent(), true);
        $this->assertEquals($contents['message'], 'ImageGalleries created.');
        $this->assertEquals($contents['data'], []);


    }

    public function testDeleteImage()
    {
        $user = factory(User::class)->create();
        $this->actingAs($user);
        $image    = factory(ImageGalleries::class)->create(['user_id' => $user->id]);
        $response = $this->json('delete', '/images/' . $image->id);

        $response->assertStatus(200);
        $contents = json_decode($response->getContent(), true);
        $this->assertEquals($contents['message'], 'ImageGalleries deleted.');
        $this->assertEquals($contents['deleted'], true);
    }

    public function testGetImageById()
    {
        $user = factory(User::class)->create();
        $this->actingAs($user);
        $image    = factory(ImageGalleries::class)->create(['user_id' => $user->id]);
        $response = $this->json('GET', '/images/' . $image->id);
        $response->assertStatus(200);
    }

    public function testDeleteImageUnAuthorize()
    {
        $image    = factory(ImageGalleries::class)->make(['user_id' => 1]);
        $response = $this->json('delete', '/images/' . $image->id);
        $response->assertStatus(401);
    }

    public function testUploadImageUnAuthorize()
    {
        $image = factory(ImageGalleries::class)->make(['user_id' => 1]);
        Storage::fake('images.jpeg');

        $response = $this->json('post', '/images/', [
            'images[]' => UploadedFile::fake()->image('images.jpeg'),
            'name'     => $image->name,
            'type'     => $image->type,
        ]);
        $response->assertStatus(401);

    }
}

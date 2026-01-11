<?php

namespace Tests\Feature;

use App\Models\url\tb_other;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;

class OtherControllerTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();

        // Create test data
        tb_other::create([
            'id_link' => 8,
            'title' => 'Sambutan Kepala Sekolah',
            'description' => 'sambutan dari kepala sekolah',
            'is_used' => 0,
            'type' => 'text',
            'url' => 'img/lain/default.png',
        ]);

        tb_other::create([
            'id_link' => 6,
            'title' => 'Visi & Misi',
            'description' => '<p>abal abal</p>',
            'is_used' => 0,
            'type' => 'text',
            'url' => '?????',
        ]);
    }

    /** @test */
    public function it_can_update_sambutan_kepala_sekolah_with_description_only()
    {
        $data = tb_other::find(8);

        $response = $this->put(route('lainnya.update', ['id' => 8]), [
            'description' => 'Updated sambutan description',
        ]);

        $response->assertRedirect(route('lainnya.index'));

        $data->refresh();
        $this->assertEquals('Updated sambutan description', $data->description);
    }

    /** @test */
    public function it_can_update_sambutan_kepala_sekolah_with_image()
    {
        Storage::fake('public');

        $file = UploadedFile::fake()->image('thumbnail.jpg');

        $response = $this->put(route('lainnya.update', ['id' => 8]), [
            'description' => 'New description with image',
            'thumbnail' => $file,
        ]);

        $response->assertRedirect(route('lainnya.index'));

        $data = tb_other::find(8);
        $this->assertEquals('New description with image', $data->description);
        $this->assertStringContainsString('img/lain/', $data->url);
    }

    /** @test */
    public function it_validates_required_description_for_sambutan()
    {
        $response = $this->put(route('lainnya.update', ['id' => 8]), [
            'description' => '',
        ]);

        $response->assertSessionHasErrors('description');
    }

    /** @test */
    public function it_can_update_regular_item_with_url_type()
    {
        $response = $this->put(route('lainnya.update', ['id' => 6]), [
            'type' => 'url',
            'url' => 'https://example.com',
        ]);

        $response->assertRedirect(route('lainnya.index'));

        $data = tb_other::find(6);
        $this->assertEquals('url', $data->type);
        $this->assertEquals('https://example.com', $data->url);
    }

    /** @test */
    public function it_can_update_regular_item_with_text_type()
    {
        $response = $this->put(route('lainnya.update', ['id' => 6]), [
            'type' => 'text',
            'description' => 'New text description',
        ]);

        $response->assertRedirect(route('lainnya.index'));

        $data = tb_other::find(6);
        $this->assertEquals('text', $data->type);
        $this->assertEquals('New text description', $data->description);
    }

    /** @test */
    public function it_validates_url_format()
    {
        $response = $this->put(route('lainnya.update', ['id' => 6]), [
            'type' => 'url',
            'url' => 'not-a-valid-url',
        ]);

        $response->assertSessionHasErrors('url');
    }

    /** @test */
    public function it_validates_file_type()
    {
        Storage::fake('public');

        $file = UploadedFile::fake()->create('document.txt', 100);

        $response = $this->put(route('lainnya.update', ['id' => 6]), [
            'type' => 'file',
            'file' => $file,
        ]);

        $response->assertSessionHasErrors('file');
    }

    /** @test */
    public function it_validates_image_type_for_sambutan()
    {
        Storage::fake('public');

        $file = UploadedFile::fake()->create('document.pdf', 100);

        $response = $this->put(route('lainnya.update', ['id' => 8]), [
            'description' => 'Test description',
            'thumbnail' => $file,
        ]);

        $response->assertSessionHasErrors('thumbnail');
    }
}


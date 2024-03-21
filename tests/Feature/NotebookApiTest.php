<?php

namespace Tests\Feature;

use App\Http\Requests\NotebookPostRequest;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Http\UploadedFile;
use Tests\TestCase;

class NotebookApiTest extends TestCase
{
    /**
     * A basic feature test example.
     */
    public function testGetNotebookList()
    {
        $response = $this->get('/api/v1/notebook');
        $response = $this->get('/api/v1/notebook');

        $response->assertStatus(200);
    }

    public function testCreateNote()
    {

        $photoPath = storage_path('app/public/photos/1gzYuF4tnXuBt4hYgl9z4mnMspmradB7MtPBxOsN.png');
        $photo = new UploadedFile($photoPath, 'test.jpg', 'image/jpeg', null, true);


        $response = $this->postJson('/api/v1/notebook', [
            'fio' => 'TestFio',
            'company' => 'TestCompany',
            'phone' => '99288888888',
            'email' => 'test@test.te',
            'born_date' => '2002-02-08',
            'photo' => $photo
        ]);

        $response->assertStatus(201);
    }

    public function testGetNoteById()
    {
        $id = 4;

        $response = $this->get("/api/v1/notebook/$id");

        $response->assertStatus(200);
    }

    public function testUpdateNoteSingle()
    {
        $id = 22;

        $response = $this->postJson("/api/v1/notebook/$id", [
            'fio' => 'UpdatedFio'
        ]);

        $response->assertStatus(200);
    }
    public function testUpdateNotesAll()
    {
        $id = 6;

        $photoPath = storage_path('app/public/photos/1gzYuF4tnXuBt4hYgl9z4mnMspmradB7MtPBxOsN.png');
        $photo = new UploadedFile($photoPath, 'test.jpg', 'image/jpeg', null, true);

        $response = $this->postJson("/api/v1/notebook/$id", [
            'fio' => 'TestFio',
            'company' => 'TestCompany',
            'phone' => '99288888888',
            'email' => 'test@test.te',
            'born_date' => '2002-02-08',
            'photo' => $photo
        ]);

        $response->assertStatus(200);
    }

    public function testUpdateNonExistentNote()
    {
        $id = 5;

        $response = $this->postJson("/api/v1/notebook/$id", [
            'fio' => 'NEWfio'
        ]);

        $response->assertStatus(404)
            ->assertJson([
                'error' => 'Note not found' // Ожидаемое сообщение об ошибке
            ]);
    }


    public function testInvalidNoteData()
    {
        $request = new NotebookPostRequest();
        $validator = $this->app['validator']->make(
            [
                'email' => 'invalid-email',
                'fio' => 'FIO',

            ],
            $request->rules()
        );

        $this->assertTrue($validator->fails());
    }
}

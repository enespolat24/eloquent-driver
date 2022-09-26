<?php

namespace Tests\Forms;

use Carbon\Carbon;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Statamic\Eloquent\Forms\FormModel;
use Statamic\Eloquent\Forms\SubmissionModel;
use Tests\TestCase;

class FormSubmissionTest extends TestCase
{

    /** @test */
    public function it_should_have_timestamps()
    {
        $form = FormModel::create([
            'handle' => 'test',
            'title' => 'Test',
        ]);

        $submission = SubmissionModel::create([
            'form_id' => $form->id,
            'data' => [
                'name' => 'John Doe',
            ],
        ]);

        $this->assertInstanceOf(Carbon::class, $submission->created_at);
        $this->assertInstanceOf(Carbon::class, $submission->updated_at);
    }

    public function it_should_save_to_DB()
    {
        $form = FormModel::create([
            'handle' => 'test',
            'title' => 'Test',
        ]);

        $submission = SubmissionModel::create([
            'form_id' => $form->id,
            'data' => [
                'name' => 'John Doe',
            ],
        ]);

        $this->assertDatabaseHas('form_submissions', [
            'id' => $submission->id,
            'form_id' => $form->id,
            'data' => json_encode([
                'name' => 'John Doe',
            ]),
        ]);
    }
}
<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Models\Ticket;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;

class TicketTest extends TestCase
{
    use WithFaker;

    protected $types = [
        'technical_issues' => 'task_tech_db',
        'account_billing' => 'task_accounts_db',
        'product_service' => 'task_sales_db',
        'general_inquiry' => 'task_inquiry_db',
        'feedback' => 'task_feedback_db',
    ];

    protected function setUp(): void
    {
        parent::setUp();
        
        // Run migrations and refresh for all database connections
        foreach ($this->types as $connection) {
            $this->artisan('migrate:fresh', ['--database' => $connection]);
        }
    }

    protected function tearDown(): void
    {
        // Clean up all test databases
        foreach ($this->types as $connection) {
            \DB::connection($connection)->table('tickets')->truncate();
        }
        
        parent::tearDown();
    }

    protected function getConnectionForType(string $type): string
    {
        return $this->types[$type];
    }

    /**
     * Test successful ticket submission.
     */
    public function test_submit_ticket_successfully(): void
    {
        $ticketData = [
            'subject' => 'Test Subject',
            'description' => 'This is a test description for the ticket.',
            'full_name' => 'John Doe',
            'email' => 'john@example.com',
            'phone' => '1234567890',
            'priority' => 'high',
            'type' => 'technical_issues',
            'contact_method' => 'email',
            'consent' => true,
        ];

        $response = $this->postJson('/submit-ticket', $ticketData);

        $response->assertStatus(200)
                 ->assertJson([
                     'success' => true,
                     'message' => 'Your ticket has been submitted successfully!'
                 ]);

        $this->assertDatabaseHas('tickets', [
            'subject' => 'Test Subject',
            'email' => 'john@example.com',
            'type' => 'technical_issues',
        ], 'task_tech_db');
    }

    /**
     * Test ticket submission with validation errors.
     */
    public function test_submit_ticket_validation_fails(): void
    {
        $ticketData = [
            'subject' => '',
            'description' => 'Test',
            'email' => 'invalid-email',
        ];

        $response = $this->postJson('/submit-ticket', $ticketData);

        $response->assertStatus(422)
                 ->assertJsonValidationErrors(['subject', 'email', 'full_name', 'priority', 'type', 'contact_method', 'consent']);
    }

    /**
     * Test ticket submission with attachments.
     */
    public function test_submit_ticket_with_attachments(): void
    {
        Storage::fake('public');

        $file = UploadedFile::fake()->create('document.pdf', 100);

        $type = 'account_billing';
        $ticketData = [
            'subject' => 'Test with Attachment',
            'description' => 'This ticket has an attachment.',
            'full_name' => 'Jane Doe',
            'email' => 'jane@example.com',
            'phone' => '9876543210',
            'priority' => 'medium',
            'type' => $type,
            'contact_method' => 'phone',
            'consent' => true,
            'attachments' => [$file],
        ];

        $response = $this->postJson('/submit-ticket', $ticketData);

        $response->assertStatus(200)
                 ->assertJson([
                     'success' => true,
                 ]);

        $this->assertTrue(Storage::disk('public')->exists('attachments/' . $file->hashName()));
        
        $this->assertDatabaseHas('tickets', [
            'email' => 'jane@example.com',
            'type' => $type,
        ], $this->getConnectionForType($type));
    }

    /**
     * Test ticket submission for each type.
     */
    public function test_submit_ticket_for_each_type(): void
    {
        foreach ($this->types as $type => $connection) {
            $ticketData = [
                'subject' => "Test {$type}",
                'description' => "Test description for {$type}",
                'full_name' => $this->faker->name,
                'email' => $this->faker->unique()->safeEmail,
                'priority' => 'low',
                'type' => $type,
                'contact_method' => 'email',
                'consent' => true,
            ];

            $response = $this->postJson('/submit-ticket', $ticketData);

            $response->assertStatus(200)
                     ->assertJson(['success' => true]);

            $this->assertDatabaseHas('tickets', [
                'type' => $type,
                'email' => $ticketData['email'],
            ], $this->getConnectionForType($type));
        }
    }

    /**
     * Test ticket submission without optional phone field.
     */
    public function test_submit_ticket_without_phone(): void
    {
        $ticketData = [
            'subject' => 'Test without phone',
            'description' => 'This ticket has no phone number.',
            'full_name' => 'Test User',
            'email' => 'test@example.com',
            'priority' => 'urgent',
            'type' => 'general_inquiry',
            'contact_method' => 'email',
            'consent' => true,
        ];

        $response = $this->postJson('/submit-ticket', $ticketData);

        $response->assertStatus(200)
                 ->assertJson(['success' => true]);

        $this->assertDatabaseHas('tickets', [
            'email' => 'test@example.com',
            'phone' => null,
        ], 'task_inquiry_db');
    }
}

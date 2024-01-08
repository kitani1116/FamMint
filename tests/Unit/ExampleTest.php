<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Support\Facades\Mail;
use Tests\TestCase;
use App\Mail\ContactFormMail;

class UserDataControllerTest extends TestCase
{

    use DatabaseTransactions;
    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function testcontactcomp()
    {
        Mail::fake();

        $formData = [
            'name' => 'John Doe',
            'email' => 'john.doe@example.com',
            'type' => 'Inquiry',
            'message' => 'This is a test message.',
        ];

        Mail::to($formData['email'])->send(new ContactFormMail($formData, 'user'));
        Mail::to('fammint.app@gmail.com')->send(new ContactFormMail($formData, 'admin'));

        Mail::assertSent(ContactFormMail::class, function ($mail) use ($formData) {
            return $mail->to[0]['address'] === $formData['email'];
        });

        Mail::assertSent(ContactFormMail::class, function ($mail) {
            return $mail->to[0]['address'] === 'fammint.app@gmail.com';
        });

        $response = $this->post('/contact_complete', $formData);
        $response->assertStatus(302);
        $response->assertRedirect('/contact_complete');
    }


    public function testContactConfWithValidData()
    {
        $response = $this->post('/contact_conf', [
            'name' => 'John Doe',
            'email' => 'john.doe@gmail.com',
            'type' => 'Inquiry',
            'message' => 'This is a test message.',
        ]);

        $response->assertStatus(200); 
        $response->assertViewIs('Contact.contact_conf'); 
        $response->assertViewHas('inputs', [
            'name' => 'John Doe',
            'email' => 'john.doe@gmail.com',
            'type' => 'Inquiry',
            'message' => 'This is a test message.',
        ]); 
    }

    public function testContactConfWithInvalidData()
    {
        $response = $this->post('/contact_conf', [
            
        ]);

        $response->assertStatus(302);
        $response->assertSessionHasErrors(['name', 'email', 'type', 'message']);
    }



    public function testConfWithValidData()
    {
        $response = $this->post('/main_conf', [
            'last_name' => 'Doe',
            'first_name' => 'John',
            'email' => 'john.doe@exampl.com',
            'pass' => 'Pass123',
            'pass_confirmation' => 'Pass123',
            'primary_school' => 'Sample Primary School',
        ]);

        $response->assertStatus(200);
        $response->assertViewIs('Signup.main_conf'); 
        $response->assertViewHas('inputs', [
            'last_name' => 'Doe',
            'first_name' => 'John',
            'email' => 'john.doe@exampl.com',
            'pass' => 'Pass123',
            'pass_confirmation' => 'Pass123',
            'primary_school' => 'Sample Primary School',
        ]); 
    }

    public function testConfWithInvalidData()
    {
        $response = $this->post('/main_conf', [
            
        ]);

        $response->assertStatus(302); 
        $response->assertSessionHasErrors([
            'last_name', 'first_name', 'email', 'pass', 'primary_school'
        ]);
    }



    public function testChildConfValidationPasses()
    {
        $response = $this->post('/child_account_comp', [
            'first_name' => 'John',
            'email' => 'john.doe@example.com',
            'pass' => 'password123',
            'pass_confirmation' => 'password123',
        ]);

        $response->assertStatus(302);
        $response->assertSessionHasNoErrors();
    }

    public function testChildConfValidationFails()
    {
        $response = $this->post('/child_account_comp', [
        ]);

        $response->assertStatus(302);
    }


    }









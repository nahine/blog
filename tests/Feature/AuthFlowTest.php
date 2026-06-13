<?php

namespace Tests\Feature;

use App\Models\Category;
use App\Models\Post;
use App\Models\User;
use Illuminate\Auth\Notifications\ResetPassword;
use Illuminate\Auth\Notifications\VerifyEmail;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Notification;
use Tests\TestCase;

class AuthFlowTest extends TestCase
{
    use RefreshDatabase;

    private function makePost(User $author): Post
    {
        $category = Category::create(['nom' => 'Tech', 'slug' => 'tech']);

        return Post::create([
            'titre' => 'Article',
            'slug' => 'article',
            'contenu' => 'Contenu.',
            'extrait' => 'Extrait',
            'categorie_id' => $category->id,
            'utilisateur_id' => $author->id,
            'publie_le' => now()->subDay(),
        ]);
    }

    public function test_registration_sends_verification_email_and_redirects(): void
    {
        Notification::fake();

        $this->get(route('register'));
        $res = $this->post(route('register'), [
            '_token' => csrf_token(),
            'name' => 'Alice',
            'email' => 'alice@example.com',
            'password' => 'password123',
            'password_confirmation' => 'password123',
        ]);

        $res->assertRedirect(route('verification.notice'));

        $user = User::where('email', 'alice@example.com')->first();
        $this->assertNotNull($user);
        $this->assertNull($user->email_verified_at);
        Notification::assertSentTo($user, VerifyEmail::class);
    }

    public function test_unverified_user_cannot_comment(): void
    {
        $author = User::create([
            'nom' => 'Auteur', 'email' => 'auteur@example.com',
            'password' => 'password', 'role' => 'admin', 'email_verified_at' => now(),
        ]);
        $post = $this->makePost($author);

        $unverified = User::create([
            'nom' => 'Bob', 'email' => 'bob@example.com',
            'password' => 'password', 'role' => 'user',
        ]);

        $this->actingAs($unverified)->get(route('posts.show', $post->slug));
        $res = $this->actingAs($unverified)->postJson(
            route('comments.store', $post),
            ['body' => 'Coucou'],
            ['X-CSRF-TOKEN' => csrf_token()]
        );
        $res->assertStatus(403);
    }

    public function test_forgot_password_sends_reset_link(): void
    {
        Notification::fake();

        $user = User::create([
            'nom' => 'Carol', 'email' => 'carol@example.com',
            'password' => 'password', 'role' => 'user', 'email_verified_at' => now(),
        ]);

        $this->get(route('password.request'))->assertOk();

        $this->post(route('password.email'), [
            '_token' => csrf_token(),
            'email' => 'carol@example.com',
        ])->assertSessionHasNoErrors();

        Notification::assertSentTo($user, ResetPassword::class);
    }

    public function test_auth_pages_render(): void
    {
        $this->get(route('login'))->assertOk()->assertSee('pwd-toggle', false);
        $this->get(route('register'))->assertOk()->assertSee('pwd-toggle', false);
        $this->get(route('password.request'))->assertOk()->assertSee('Mot de passe oublié');
    }
}

<?php

namespace Tests\Feature;

use App\Models\Category;
use App\Models\Comment;
use App\Models\Post;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class AjaxInteractionsTest extends TestCase
{
    use RefreshDatabase;

    private function makePost(): Post
    {
        $user = User::create([
            'name' => 'Test User',
            'email' => 'test@example.com',
            'password' => 'password',
            'role' => 'user',
        ]);

        $category = Category::create(['name' => 'Tech', 'slug' => 'tech']);

        return Post::create([
            'title' => 'Article de test',
            'slug' => 'article-de-test',
            'content' => 'Contenu de test pour la page.',
            'excerpt' => 'Extrait',
            'category_id' => $category->id,
            'user_id' => $user->id,
            'published_at' => now()->subDay(),
        ]);
    }

    public function test_post_page_renders_for_guest(): void
    {
        $post = $this->makePost();
        $this->get(route('posts.show', $post->slug))
            ->assertOk()
            ->assertSee('article-hero-img', false)
            ->assertSee('Connectez-vous pour aimer');
    }

    public function test_authenticated_user_sees_like_and_comment_forms(): void
    {
        $post = $this->makePost();
        $this->actingAs($post->user)
            ->get(route('posts.show', $post->slug))
            ->assertOk()
            ->assertSee('like-form', false)
            ->assertSee('id="comment-form"', false);
    }

    private function csrf(): array
    {
        return ['X-CSRF-TOKEN' => csrf_token()];
    }

    public function test_like_toggle_returns_json(): void
    {
        $post = $this->makePost();
        $this->actingAs($post->user)->get(route('posts.show', $post->slug));

        $res = $this->actingAs($post->user)
            ->postJson(route('posts.like', $post), [], $this->csrf());
        $res->assertOk()->assertJson(['success' => true, 'liked' => true, 'likes_count' => 1]);

        $res2 = $this->actingAs($post->user)
            ->postJson(route('posts.like', $post), [], $this->csrf());
        $res2->assertOk()->assertJson(['success' => true, 'liked' => false, 'likes_count' => 0]);
    }

    public function test_comment_store_returns_html_and_count(): void
    {
        $post = $this->makePost();
        $this->actingAs($post->user)->get(route('posts.show', $post->slug));

        $res = $this->actingAs($post->user)
            ->postJson(route('comments.store', $post), ['body' => 'Super article !'], $this->csrf());

        $res->assertOk()
            ->assertJson(['success' => true, 'comments_count' => 1])
            ->assertJsonStructure(['success', 'message', 'comments_count', 'html']);

        $this->assertStringContainsString('Super article !', $res->json('html'));
        $this->assertStringContainsString('comment-card', $res->json('html'));
    }

    public function test_reply_returns_html(): void
    {
        $post = $this->makePost();
        $comment = Comment::create([
            'post_id' => $post->id,
            'user_id' => $post->user_id,
            'body' => 'Commentaire parent',
        ]);

        $this->actingAs($post->user)->get(route('posts.show', $post->slug));
        $res = $this->actingAs($post->user)
            ->postJson(route('comments.reply', $comment), ['body' => 'Ma réponse'], $this->csrf());

        $res->assertOk()->assertJson(['success' => true]);
        $this->assertStringContainsString('Ma réponse', $res->json('html'));
        $this->assertStringContainsString('reply-card', $res->json('html'));
    }
}

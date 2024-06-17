<?php

namespace Tests\Unit;

use Tests\TestCase;
use App\Models\User;
use App\Models\Article;
use Illuminate\Support\Facades\Artisan;
class UserTest extends TestCase
{
    public function setUp(): void
    {
        parent::setUp();

        Artisan::call('migrate:fresh --seed');
    }
    public function test_example()
    {
        $this->assertTrue(true);
    }

    public function test_getRouteKeyName()
    {
        $user = new User();
        $this->assertEquals('username', $user->getRouteKeyName());
    }

    public function test_articles()
    {
        $this->seed();
        $user = User::where('username','Rose')->first();
        $article = Article::where('user_id', $user->id)->first();

        $this->assertInstanceOf(\Illuminate\Database\Eloquent\Collection::class, $user->articles);
        $this->assertTrue($user->articles->contains($article));
    }
    public function test_favoritedArticles()
    {
        $user = User::factory()->create();
        $article = Article::factory()->create();
        $user->favoritedArticles()->attach($article);

        $this->assertInstanceOf(\Illuminate\Database\Eloquent\Collection::class, $user->favoritedArticles);
        $this->assertTrue($user->favoritedArticles->contains($article));
    }

    public function test_followers()
    {
        $user = User::factory()->create();
        $follower = User::factory()->create();
        $user->followers()->attach($follower);

        $this->assertInstanceOf(\Illuminate\Database\Eloquent\Collection::class, $user->followers);
        $this->assertTrue($user->followers->contains($follower));
    }

    public function test_following()
    {
        $user = User::factory()->create();
        $following = User::factory()->create();
        $user->following()->attach($following);

        $this->assertInstanceOf(\Illuminate\Database\Eloquent\Collection::class, $user->following);
        $this->assertTrue($user->following->contains($following));
    }

    public function test_doesUserFollowAnotherUser()
    {
        $this->seed();
        $rose = User::where('username', 'Rose')->first();
        $musonda = User::where('username', 'Musonda')->first();
        $bob= User::factory()->create();

        $this->assertTrue($rose->doesUserFollowAnotherUser($rose->id, $musonda->id));
        $this->assertTrue($musonda->doesUserFollowAnotherUser($musonda->id, $rose->id));
        $this->assertFalse($rose->doesUserFollowAnotherUser($rose->id, $bob->id));
    }

    public function test_doesUserFollowArticle()
    {
        $this->seed();
        $rose = User::where('username', 'Rose')->first();
        $musonda = User::where('username', 'Musonda')->first();
        $bob= User::factory()->create();

        $article = Article::where('user_id', $rose->id)->first();

        $this->assertTrue($musonda->doesUserFollowArticle($musonda->id, $article->id));
        $this->assertFalse($bob->doesUserFollowArticle($bob->id, $article->id));
    }

    public function test_setPasswordAttribute()
    {
        $user = new User();
        $password = 'password123';
        $user->password = $password;

        $this->assertTrue(password_verify($password, $user->password));
    }
}

<?php

namespace Tests\Unit;

use App\Models\Category;
use App\Models\Reply;
use App\Models\Thread;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ThreadTest extends TestCase
{
    use RefreshDatabase;

    protected $thread;

    protected function setUp(): void
    {
        parent::setUp();

        $this->thread = Thread::factory()->create();
    }

    /** @test */
    public function thread_has_replies()
    {
        $this->assertInstanceOf(\Illuminate\Database\Eloquent\Collection::class, $this->thread->replies);
    }

    /** @test */
    public function thread_has_user()
    {
        $this->assertInstanceOf(User::class, $this->thread->user);
    }

    /** @test */
    public function thread_can_add_reply()
    {
        $this->thread->addReply(Reply::factory()->raw());

        $this->assertCount(1, $this->thread->replies);
    }

    /** @test */
    public function thread_belongs_to_category()
    {
        $this->assertInstanceOf(Category::class, $this->thread->category);
    }

    /** @test */
    public function thread_can_make_path()
    {
        $this->assertEquals(
            url("/threads/{$this->thread->category->slug}/{$this->thread->id}"),
            $this->thread->path()
        );
    }
}

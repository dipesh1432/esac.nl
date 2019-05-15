<?php

namespace Tests\Feature;

use App\ApplicationResponse;
use App\ApplicationResponseRow;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use App\NewsItem;
use App\Rol;
use App\User;
use Artisan;
use Carbon\Carbon;
use TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class CreateNewsItemTest extends TestCase
{
    use DatabaseMigrations;

    private $url = 'newsItems';
    private $newsItem;

    protected function setUp()
    {
        parent::setUp();
        $this->user = $user = factory(User::class)->create();
        $role = factory(Rol::class)->create([
            'id' => 3
        ]);

        $user->roles()->attach($role->id);
        $this->be($user);

        session()->start();
    }

    protected function tearDown()
    {
        Artisan::call('migrate:reset');
        parent::tearDown();
    }
    /** @test */
    public function CreateNewAgendaItem(){
        $body = [
            '_token' => csrf_token(),
            'NL_title' => 'test nieuws',
            'EN_title' => 'test news',
            'NL_text' => 'test nieuws',
            'EN_text' => 'test news',
        ];
        $response = $this->post($this->url, $body);
        $response->assertStatus(302);
        echo($response->getContent());
        $newsItem = NewsItem::all()->last();

        $this->assertNotNull($newsItem);
    }
}

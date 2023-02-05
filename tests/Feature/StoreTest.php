<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class StoreTest extends TestCase
{
    use RefreshDatabase;

    public function setUp(): void
    {
        parent::setUp();
        $this->authUser();
    }

    public function test_fetch_all_store_of_a_todo_list()
    {
        $user = $this->createUser();
        $store = $this->createStores(
            ['user_id' => $user->id,
            'store_name'=> "Vand Bình Thạnh",
            "images" => "https://img6.thuthuatphanmem.vn/uploads/2022/02/09/anh-dep-do-thi-thanh-pho-ho-chi-minh_031024615.jpg",
            "address" => "Bình Thạnh TP.HCM"
        ]);

        $this->getJson(route('stores.index'))->assertOk()->json('data');

    }
}

<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class ContactControllerTest extends TestCase
{
    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function testImportContactsAPI()
    {
        $response = $this->postJson('/api/contact/import',
            ['csv' => ['0' => ['0' => "columnA",'1' => "columnB",'2' => "columnC",'3' => "columnD",'4' => "columnE" ],
                       '1' => ['0' => "Susan",'1' => "41",'2' => "a",'3' => "a",'4' => "1111" ],
                       '2' => ['0' => "Mike",'1' => "5",'2' => "b",'3' => "b",'4' => "2222" ],
                        '3' => ['0' => "Jill",'1' => "51",'2' => "d",'3' => "c",'4' => "3333" ],
                        '4' => ['0' => "Jake",'1' => "61",'2' => "d",'3' => "d",'4' => "4444" ],
                       ],
             'map' => ['0' => "name", '1' => 'team_id', '4' => 'phone']
             ]
        );
        $response->assertStatus(200)
        ->assertJson(['success' => ['msg' => 'Success to Import', 'skip_count' => '0']]);
    }
    public function testImportContactsSkipAPI()
    {
        $response = $this->postJson('/api/contact/import',
            ['csv' => ['0' => ['0' => "columnA",'1' => "columnB",'2' => "columnC",'3' => "columnD",'4' => "columnE" ],
                '1' => ['0' => "Susan",'1' => "41",'2' => "a",'3' => "a",'4' => "1111" ],
                '2' => ['0' => "Mike",'1' => "abc",'2' => "b",'3' => "b",'4' => "2222" ],
                '3' => ['0' => "Jill",'1' => "51",'2' => "d",'3' => "c",'4' => "3333" ],
                '4' => ['0' => "Jake",'1' => "abc",'2' => "d",'3' => "d",'4' => "3334" ],
            ],
                'map' => ['0' => "name", '1' => 'team_id', '4' => 'phone']
            ]
        );
        $response->assertStatus(200)
            ->assertJson(['success' => ['msg' => 'Success to Import', 'skip_count' => '2']]);
    }

}

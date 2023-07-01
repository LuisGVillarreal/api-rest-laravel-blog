<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class UserEndpointsTest extends TestCase{

	public function test_user_update_endpoint(){
		$headers = [
			'Authorization' => "eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.eyJzdWIiOjEwLCJlbWFpbCI6Imx1aXNAbWUuY29tIiwibmFtZSI6Ikx1aXMiLCJzdXJuYW1lIjoiVmlsbGFycmVhbCBDaWciLCJkZXNjcmlwdGlvbiI6bnVsbCwiaW1hZ2UiOm51bGwsImlhdCI6MTY3NjM0ODY0MSwiZXhwIjoxNjc2OTUzNDQxfQ.LoRUhUyjquUVGUMKmqCF7YtomDrjDGigzMqmoT-2mSk",
			'Content-Type' => 'application/x-www-form-urlencoded',
		];

		$payload = [
			'json' => json_encode([
				'name' => 'Nuevo nombre',
				'surname' => 'Nuevo apellido',
				'email' => 'luis@mail.com'
			]),
		];


		// Hacer la solicitud PUT al endpoint de actualización de usuario
	    $response = $this->put('/api/user/update', $payload, $headers);

	    // Validar que la solicitud tuvo éxito
	    $response->assertStatus(200);

	    // Validar la estructura de la respuesta JSON
	    $response->assertJsonStructure([
	        'status',
	        'code',
	        'user',
	        'change',
	    ]);
	}

}

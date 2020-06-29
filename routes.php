<?php

$app->group('/v1', function() {

    $this->group('/evento', function() {
        $this->get('', '\App\v1\Controllers\EventoController:listarEventos');
        $this->post('', '\App\v1\Controllers\EventoController:criarEvento');

        $this->get('/{id:[0-9]+}', '\App\v1\Controllers\EventoController:verEvento');
        $this->put('/{id:[0-9]+}', '\App\v1\Controllers\EventoController:atualizarEvento');
        $this->delete('/{id:[0-9]+}', '\App\v1\Controllers\EventoController:deletarEvento');
    });

    $this->group('/auth', function() {
        $this->get('', \App\v1\Controllers\AuthController::class);
    });
});

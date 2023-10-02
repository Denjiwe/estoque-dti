<?php

return [
    'qualquer' => \App\Services\FiltrosData\FiltroQualquer::class,
    'hoje' => \App\Services\FiltrosData\FiltroHoje::class,
    'ontem' => \App\Services\FiltrosData\FiltroOntem::class,
    'semana' => \App\Services\FiltrosData\FiltroSemana::class,
    'mes' => \App\Services\FiltrosData\FiltroMes::class,
    'ultimo_mes' => \App\Services\FiltrosData\FiltroUltimoMes::class,
    'personalizado' => \App\Services\FiltrosData\FiltroPersonalizado::class,
];

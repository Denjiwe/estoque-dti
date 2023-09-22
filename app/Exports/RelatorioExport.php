<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromArray;
use Maatwebsite\Excel\Concerns\WithHeadings;

class RelatorioExport implements FromArray, WithHeadings
{
    private $dados;
    private $headers;

    public function __construct(array $dados, array $headers)
    {
        $this->dados = $dados;
        $this->headers = $headers;
    }

    public function array(): array
    {
        return $this->dados;
    }

    public function headings(): array
    {
        return $this->headers;
    }
}

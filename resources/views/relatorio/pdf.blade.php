<p style="font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif">Relatório de {{$nome}} | {{$dataAtual}} {{$horaAtual}}</p>

@foreach ($dados as $index => $dado)
    <h3 style="font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif">{{$filtro}} {{$index}}</h3>
    <table style="text-align: center; font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif; font-size: 12px; width: 100%;">
        <thead>
            <tr>
    @switch($nome)
        @case('Entregas')
                        <th>ID</th>
                        <th>Código da Solicitação</th>
                        <th>Funcionário Interno</th>
                        <th>Funcionário Solicitante</th>
                        <th>Diretoria Entregue</th>
                        <th>Divisão Entregue</th>
                        <th>Produto</th>
                        <th>Quantidade</th>
                        <th>Data de Entrega</th>
                    <tr>
                </thead>
                <tbody>
                    @foreach ($dado as $item)
                        <tr>
                            <td>#{{$item['id']}}</td>
                            <td>#{{$item['solicitacao']['id']}}</td>
                            <td>{{$item['usuario']['nome']}}</td>
                            <td>{{$item['solicitacao']['usuario']['nome']}}</td>
                            <td>{{$item['solicitacao']['diretoria']['nome']}}</td>
                            <td>{{$item['solicitacao']['divisao'] != null ? $item['solicitacao']['divisao']['nome'] : 'Nenhuma'}}</td>
                            <td>{{$item['produto']['modelo_produto']}}</td>
                            <td>{{$item['qntde']}}</td>
                            <td>{{(date('d/m/Y H:i', strtotime($item['created_at'])))}}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        @break
        @case('Impressoras')
                        <th>ID da Impressora</th>
                        <th>Modelo</th>
                        <th>Diretoria</th>
                        <th>Divisão</th>
                        <th>Quantidade Total</th>
                    <tr>
                </thead>
                <tbody>
                    @foreach ($dado as $item)
                        <tr>
                            <td>#{{$item['produto']['id']}}</td>
                            <td>{{$item['produto']['modelo_produto']}}</td>
                            <td>{{$item['diretoria']['nome']}}</td>
                            <td>{{$item['divisao'] != null ? $item['divisao']['nome'] : 'Nenhuma'}}</td>
                            <td>{{$item['produto']['qntde_estoque']}}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        @break
        @case('Usuários')
                        <th>ID</th>
                        <th>Nome</th>
                        <th>Diretoria</th>
                        <th>Divisão</th>
                        <th>CPF</th>
                        <th>Email</th>
                        <th>Status</th>
                        <th>Data de Cadastro</th>
                    <tr>
                </thead>
                <tbody>
                    @foreach ($dado as $item)
                        <tr>
                            <td>#{{$item['id']}}</td>
                            <td>{{$item['nome']}}</td>
                            <td>{{$item['diretoria']['nome']}}</td>
                            <td>{{$item['divisao'] != null ? $item['divisao']['nome'] : 'Nenhuma'}}</td>
                            <td>{{ chunk_split($item['cpf'], 3, '.') . '-' . substr($item['cpf'], 9) }}</td>
                            <td>{{$item['email']}}</td>
                            <td>{{$item['status']}}</td>
                            <td>{{(date('d/m/Y H:i', strtotime($item['created_at'])))}}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        @break
        @case('Solicitações')
                        <th>Código</th>
                        <th>Diretoria</th>
                        <th>Divisão</th>
                        <th>Status</th>
                        <th>Produto(s)</th>
                        <th>Data de Criação</th>
                    <tr>
                </thead>
                <tbody>
                    @foreach ($dado as $item)
                        <tr>
                            <td>#{{$item['id']}}</td>
                            <td>{{$item['diretoria']['nome']}}</td>
                            <td>{{$item['divisao'] != null ? $item['divisao']['nome'] : 'Nenhuma'}}</td>
                            <td>{{ucfirst(strtolower($item['status']))}}</td>
                            <td>
                                @foreach ($item['produtos'] as $index => $produto)
                                    {{$index > 0 ? '|': ''}} {{$produto['modelo_produto']}}: {{$produto['pivot']['qntde']}} 
                                @endforeach
                            </td>
                            <td>{{(date('d/m/Y H:i', strtotime($item['created_at'])))}}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        @break
    @endswitch
@endforeach
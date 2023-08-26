## New Features
- [X] Fazer validação das quantidades para adicionar estado aguardando para os produtos em falta
- [X] Criar campo de quantidade solicitada pra produtos, mostrar esse valor é importante
- [X] Validar se está trocando de suprimento para ser atendido caso possua mais de um suprimento em uso, inicialmente trazendo o primeiro que está registrado com sim no campo em uso
- [X] Quantidade solicitada deve desconsiderar produtos entregues
- [X] Caso solicitação estivesse em aguardando, mandar email para o usuário e diretoria quando estoque for reabastecido, alterando o status do pedido para liberado
- Verificar relatórios para pdf e excel com laravelExcel
- [X] Verificar auditoria com laravel auditoring
    - Verificar se é possível fazer algo em relação a exclusão direta de uma auditoria no banco de dados
- [X] Criar um campo de senha provisória, para reset de senhas
- Finalizar docker
    - Fazer entrypoints para instalar o projeto do composer, fazendo verificação da pasta vendor (possível criar script que deve ser executado pelo entrypoint, que faz a verificação)
    - Fazer verificação no entrypoint do npm se existe a pasta node_modules, evitando reinstalação em toda a execução
    - Instalar phpmyadmin

## Bugs

- [X] Troca do campo em uso de suprimentos não funciona, provavelmente está verificando para alterar somente se a impressora é diferente
- [X] Troca de suprimentos com a falta do mesmo não está acontecendo
- Demora nas requisições (https://dev.to/tylerlwsmith/speed-up-laravel-in-docker-by-moving-vendor-directory-19b9), laravel sail, laravel octane
    - [X] Scripts do bootstrap (opcache aparentemente resolveu)
    - Gets e posts nas rotas (usar nginx e não o artisan deve melhorar)
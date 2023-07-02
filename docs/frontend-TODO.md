## New Features

- Finalizar Minhas Solicitações
- Fazer tela para usuários em vue, com estilização diferente da de um sistema
- Mudar a exibição de alguns elementos nas index
    - Status com ucfirst(strtolower($objeto->status))
    - Data de criação sem H:i:s
- Definir ids para os box, para que possam ocupar vh fixos com css (pesquisar se dá pra passar um id por x-component)
    - searchBox para pesquisas
    - main para páginas que possuam um searchBox
    - content para páginas que não possuirem searchBox
- Fazer o diabo das pesquisas funcionarem, sendo selecionável a coluna em que se deseja procurar o objeto para a pesquisa
    - Criar campo no select de data entre e dia específico
- Na tela de usuários criar botão de edição, redirecionando para usuario.edit
- Criar telas de show para alguns objetos
    - Órgãos ter dados gerais e diretorias
    - Diretorias ter dados gerais, divisões e usuários
    - Divisões ter usuários
        - Tabelas de todos os acima devem ter edit, show e destroy

## Bugs
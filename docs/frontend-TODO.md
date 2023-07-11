## New Features

- [X] Finalizar Minhas Solicitações
- [X] Finalizar produtos.show
- [X] Mudar a exibição de alguns elementos nas index
    - Status com ucfirst(strtolower($objeto->status))
    - Data de criação sem H:i:s
- [X] Definir ids para os box, para que possam ocupar vh fixos com css (pesquisar se dá pra passar um id por x-component)
    - searchBox para pesquisas
    - main para páginas que possuam um searchBox
    - content para páginas que não possuirem searchBox
- Fazer o diabo das pesquisas funcionarem, sendo selecionável a coluna em que se deseja procurar o objeto para a pesquisa
    - Criar campo no select de data entre e dia específico
- [X] Na tela de usuários criar botão de edição, redirecionando para usuario.edit
- [X] Fazer com que as divisões sejam exibidas de acordo com a diretoria no cadastro de usuário
- [X] Criar telas de show para alguns objetos
    - Órgãos ter dados gerais e diretorias
    - Diretorias ter dados gerais, divisões e usuários
    - Divisões ter usuários
        - Tabelas de todos os acima devem ter edit, show e destroy
- [X] Caso seja tentado atender um pedido que irá exceder a quantidade do produto em estoque, retornar informando qual produto está em falta
- [X] Fazer minhas solicitações novamente, por conta da necessidade de criar 3 rotas para os status das solicitações 
- [X] Adicionar campo de observação da solicitação ao editar uma solicitação
- [X] Verificar se vale a pena fazer um paginate dentro do box-input
- Fazer home, trazendo informações sobre os pedidos e entregas, etc
- Muito talvez procurar como colocar leitor de tela para libras, nomear botões de ações com alt
- Fazer tela para usuários em vue, com estilização diferente da de um sistema

## Bugs

- [X] Hamburger menu da topbar está muito próximo da sidebar
- [X] Quando vai adicionar um cilíndro para uma impressora que não possui um cadastrado, adiciona espaço em branco
- [X] Solicitacoes.destroy não funciona
- Dark theme não funciona nos box 
- [X] Verificar como o paginate das solicitações está funcionando, pois cada tab deveria ter sua paginação
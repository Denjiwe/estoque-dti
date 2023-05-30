
<h1 align="center"> Estoque DTI </h1>

<p align="center">
  <a href="#tecnologias">Tecnologias</a>&nbsp;&nbsp;&nbsp;|&nbsp;&nbsp;&nbsp;
  <a href="#projeto">Projeto</a>&nbsp;&nbsp;&nbsp;|&nbsp;&nbsp;&nbsp;
  <a href="#telas">Telas</a>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
</p>

<h2 align="center" id="tecnologias"> 🚀Tecnologias</h2>

O projeto foi desenvovido com as seguintes tecnologias:

- [PHP](https://www.php.net/manual/pt_BR/)
- [Laravel](https://laravel.com/docs/9.x)
- [Javascript](https://developer.mozilla.org/pt-BR/docs/Web/JavaScript)
- [Jquery](https://api.jquery.com/)
- [MySQL](https://dev.mysql.com/doc/)
- [MySQL Workbench](https://www.mysql.com/products/workbench/)
- [Docker](https://www.docker.com/products/docker-desktop/)
- [Insomnia](https://docs.insomnia.rest/) 

<h2 align="center" id="projeto"> 📓Projeto </h2>

<p>Primeiramente, o sistema desenvolvido contará com a participação dos funcionários da organização de informática, ao qual serão chamados de ‘clientes’. 
  O software também terá a participação de indivíduos que recebem o suporte pelos clientes, ao qual serão chamados de ‘usuários’. </p>
 <p> A aplicação visa evitar problemas oriundos da gerência não eficiente de produtos em um estoque em organizações pequenas ou médias voltadas ao ramo de informática, principalmente aquelas que realizam suporte a diversas outras organizações, muitas vezes utilizando de métodos ultrapassados de gerenciamento de estoque, com papéis ou planilhas de Excel, apresentando pouca eficiência e possivelmente vulnerabilidade, onde é passível de se perder informações cruciais, com diversas perdas como tempo ou até dinheiro. </p>
 <p> Com software previsto, essas informações serão de acesso muito mais rápido e fácil, com novos produtos sendo cadastrados e  visualizados pelos clientes, além de permitir com que toners e cilindros possuam uma gerência ainda mais detalhada, contendo informações de quantos modelos forem entregues por período, para onde cada um deles foi, 
qual foi o cliente que realizou a entrega e qual usuário o recebeu.</p>
 <p> O sistema proposto visa a funcionalidade de pedidos, onde o usuário poderá solicitar uma quantidade de toners e/ou cilindros para a impressora do seu respectivo setor ou a sua organização. 
Durante a criação da solicitação, o usuário poderá retirar e adicionar produtos de sua necessidade, para quantas impressoras forem necessárias. </p>
<p>Em momento algum o usuário deverá saber o modelo do produto que está solicitando, 
somente o modelo da impressora ao qual tem a necessidade da troca, para que o sistema automaticamente identifique qual o modelo do produto deve ser entregue.</p>
  <p>Após a criação do pedido, na mesma tela será informado para o usuário quais produtos estão disponíveis e quais não estão, além de informar qual é o número da solicitação, 
para que a consulta da troca por parte dos clientes seja mais fácil. Caso todos os produtos estejam em estoque, a solicitação terá o status de ‘aberto’ em que funcionário poderá a partir desse momento ir ao local do cliente, retirar os produtos que solicitou. </p>
<p>Nas ocasiões em que ao menos um dos produtos não esteja disponível, deverá ser informado quais produtos estão em falta e quais estão disponíveis. 
  Além disso, o status do pedido será de ‘aguardando’ e o número do pedido será informado da mesma maneira, porém o usuário deverá aguardar até que o produto em falta seja incrementado ao sistema,
momento em que o status da solicitação será automaticamente alterado para ‘liberado’ e um e-mail será enviado ao usuário, informando que o produto está novamente em estoque e que poderá se dirigir ao cliente para realizar a troca. Assim que a troca for realizada, o status do pedido deverá ser alterado para ‘atendido’
</p>
<p>	Ademais, o usuário poderá consultar todos os pedidos por ele realizados e seus status, assim como a data em que a troca foi realizada.  Já os clientes poderão consultar todas as solicitações realizadas e terão de capacidade de alterar o status da solicitação conforme a necessidade, selecionando quais produtos daquela solicitação foram entregues, além de possuir acesso a uma tabela de entregas, onde todos os produtos selecionados como entregues por qualquer solicitação serão exibidos, com as informações de qual cliente realizou a entrega, qual usuário criou a solicitação daquele produto que foi entregue e a data de entrega.</p>
</p>O cliente também terá relatórios por período, modelo do produto ou usuário, compreendendo como foi o fluxo de entregas realizadas. Também haverá uma tela específica de estatísticas, 
com gráficos de quantas solicitações estavam em qual status por período, contendo gráficos para melhor visualização. Além disso, o software contará com um sistema de auditoria, onde todos os eventos realizados serão persistidos em um log para consulta.</p>

<h2 align="center" id="telas"> 🖥️Telas </h2>

### Login
 <img alt="Página Inicial" src="https://github.com/Denjiwe/estoque-dti/blob/main/telas/login.png?raw=true" width="100%">
 
 ### Cadastro de Produtos
 <img alt="Página Inicial" src="https://github.com/Denjiwe/estoque-dti/blob/main/telas/cadastro_produto.png?raw=true" width="100%">
 
 ### Criar Produto
  <img alt="Página Inicial" src="https://github.com/Denjiwe/estoque-dti/blob/main/telas/criar_produto.png?raw=true" width="100%">
  
 ### Cadastrar Locais (Impressoras)
  <img alt="Página Inicial" src="https://github.com/Denjiwe/estoque-dti/blob/main/telas/criar_locais.png?raw=true" width="100%">
 
 ### Cadastrar Suprimentos (Impressoras)
  <img alt="Página Inicial" src="https://github.com/Denjiwe/estoque-dti/blob/main/telas/criar_suprimentos.png?raw=true" width="100%">
  
 ### Cadastrar Impressoras (Toners ou Cilindros)
  <img alt="Página Inicial" src="https://github.com/Denjiwe/estoque-dti/blob/main/telas/criar_impressoras.png?raw=true" width="100%">
  
 ### Cadastro de Órgãos
  <img alt="Página Inicial" src="https://github.com/Denjiwe/estoque-dti/blob/main/telas/cadastro_orgaos.png?raw=true" width="100%">
  
 ### Criar Órgão
  <img alt="Página Inicial" src="https://github.com/Denjiwe/estoque-dti/blob/main/telas/criar_orgao.png?raw=true" width="100%">
  
 ### Cadastro de Diretorias
  <img alt="Página Inicial" src="https://github.com/Denjiwe/estoque-dti/blob/main/telas/cadastro_diretoria.png?raw=true" width="100%">
  
 ### Criar Diretoria
  <img alt="Página Inicial" src="https://github.com/Denjiwe/estoque-dti/blob/main/telas/criar_diretoria.png?raw=true" width="100%">
 
 ### Cadastro de Divisões
  <img alt="Página Inicial" src="https://github.com/Denjiwe/estoque-dti/blob/main/telas/cadastro_divisoes.png?raw=true" width="100%">
  
 ### Criar Divisão
  <img alt="Página Inicial" src="https://github.com/Denjiwe/estoque-dti/blob/main/telas/criar_divisao.png?raw=true" width="100%">
 
 ### Cadastro de Usuários
  <img alt="Página Inicial" src="https://github.com/Denjiwe/estoque-dti/blob/main/telas/cadastro_usuarios.png?raw=true" width="100%">
  
 ### Criar Usuário
  <img alt="Página Inicial" src="https://github.com/Denjiwe/estoque-dti/blob/main/telas/criar_usuario.png?raw=true" width="100%">

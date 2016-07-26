## Entendendo a API - Consulta

Esta API utiliza de funções CURL para obter os dados do Sintegra ES.

A classe HomeController contem a função getConsulta é responsável pela captura de dados do formulario, são passados dois parâmetros via POST, "num_cnpj" e "botao". O parâmetro "botao" é constante "Consultar". O parâmetro "num_cnpj" é variável e se refere ao número do CNPJ que será consultado.

A classe HomeController contém uma outra  função "getSintegraContent" que é chamada pelo metodo 'getConsulta' este método recebe o CNPJ que será consultado e devolve uma string contendo o conteúdo HTML da consulta como retono, a consulta é realizada via POST.

## Funcionamento

Uma consulta só pode ser realizada por meio do CNPJ e chave de acesso.

A API previamente valida o CNPJ para evitar consultas que devolverão resultados nulos. Antes de verificar o sistema Sintegra ES o sistema consulta a base de dados para ver se já existe a informação, se existir recupera os registros do banco e exibe,se a informação não existir, consulta o sistema Sintegra ES, salva os dados em banco e exibe. Toda consulta necessita de uma chave de acesso, que pode ser gerada pela API.



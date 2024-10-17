# Loteria API

Este projeto é uma API para sorteios de loteria que permite gerar bilhetes, sortear números e conferir bilhetes. A aplicação foi desenvolvida em PHP e utiliza um banco de dados SQLite para armazenar os bilhetes gerados e o bilhete premiado.

## Estrutura do Projeto

- **src/**: Contém os controladores, serviços e modelos do projeto.
  - **Controllers/**: Controladores responsáveis por receber as requisições e chamar os serviços correspondentes.
  - **Services/**: Camada de lógica de negócios que processa os dados e interage com o banco de dados.
  - **Models/**: Modelos que representam os dados e suas operações (Bilhete, Sorteio, ConferirBilhetes).
- **public/**: Contém o ponto de entrada da aplicação (`index.php`).
- **database/**: Contém o script de criação do banco de dados (`create_db.php`) e o arquivo do banco de dados SQLite (`loteria.db`).
- **tests/**: Contém os testes unitários (`SorteioTest.php`).

## Tecnologias Utilizadas

- **PHP 8.1**
- **SQLite**: Banco de dados leve para armazenamento dos bilhetes e do bilhete premiado.
- **PHPUnit**: Framework de testes utilizado para testes unitários.
- **Docker**: Contêiner para garantir a consistência do ambiente de desenvolvimento.

## Instalação e Execução

1. **Clone o repositório**:

   ```sh
   git clone https://github.com/oliveiraaldo/loteria-api
   cd loteria-api
   ```

2. **Construa a imagem Docker**:

   ```sh
   docker build -t api-loterias .
   ```

3. **Execute o container**:

   ```sh
   docker run -p 8080:80 api-loterias
   ```

4. **Banco de Dados**:
   - O banco de dados SQLite (`loteria.db`) é copiado automaticamente para o contêiner durante a construção da imagem.
   - Para garantir que o banco de dados está configurado corretamente, certifique-se de que o arquivo `create_db.php` foi executado corretamente para criar as tabelas necessárias.

## Endpoints da API

- **POST /bilhete**: Gera bilhetes de loteria para um usuário.
  - Endpoint: http://localhost:8080/?route=bilhete
  - Corpo da requisição (JSON):
    ```json
    {
        "quantidadeBilhetes": 10,
        "quantidadeDezenas": 6
    }
    ```
  - Resposta (JSON):
    ```json
    {
        "mensagem": "Bilhetes gerados com sucesso!",
        "bilhetes": [
            [4, 12, 23, 34, 45, 56],
            [3, 15, 22, 33, 44, 59]
        ]
    }
    ```

- **GET /sorteio**: Gera o bilhete premiado.
  - Endpoint: http://localhost:8080/?route=sorteio
  - Resposta (JSON):
    ```json
    {
        "bilhetePremiado": [3, 7, 12, 18, 27, 36]
    }
    ```

- **GET /conferir**: Confere os bilhetes gerados com o bilhete premiado e retorna um HTML com os números corretos em negrito.
    - Endpoint: http://localhost:8080/?route=conferir

## Executando os Testes

1. **Instalar o PHPUnit**: Certifique-se de que o PHPUnit está instalado. Você pode instalá-lo via Composer executando:

   ```sh
   composer require --dev phpunit/phpunit
   ```

2. **Executar o Teste**: Para rodar o teste, execute o seguinte comando na raiz do projeto:

   ```sh
   ./vendor/bin/phpunit tests/SorteioTest.php
   ```

   Isso executará os testes definidos em `SorteioTest.php` e mostrará os resultados no terminal.

## Estrutura do Banco de Dados

- **Tabela `bilhetes`**: Armazena os bilhetes gerados pelos usuários.
  - **id**: Identificador único do bilhete.
  - **numeros**: Dezenas do bilhete, armazenadas como uma string separada por vírgulas.

- **Tabela `bilhete_premiado`**: Armazena o bilhete premiado.
  - **id**: Identificador único do bilhete premiado.
  - **numeros**: Dezenas do bilhete premiado, armazenadas como uma string separada por vírgulas.

## Composer.json

```json
{
    "name": "loteria/api",
    "description": "API para sorteios de loteria",
    "type": "project",
    "require": {
        "php": "^8.1"
    },
    "require-dev": {
        "phpunit/phpunit": "^9.0"
    },
    "autoload": {
        "psr-4": {
            "Loteria\\": "src/"
        }
    },
    "autoload-dev": {
        "psr-4": {
            "Loteria\\Tests\\": "tests/"
        }
    },
    "scripts": {
        "test": "phpunit"
    }
}
```

- **`composer.json`**: Define as dependências do projeto, incluindo o PHPUnit para testes unitários, e configura o autoload para as classes da aplicação e testes.

## Considerações Finais

- **Boas Práticas**: Foram aplicados princípios de SOLID e Clean Code para garantir a manutenibilidade e a organização do código.
- **Testes**: Foram incluídos testes unitários para garantir a corretude da geração dos bilhetes, sorteio e conferência.
- **Docker**: A aplicação está containerizada para garantir um ambiente de execução consistente.

Se houver dúvidas ou sugestões, sinta-se à vontade para abrir uma issue no repositório. 😊


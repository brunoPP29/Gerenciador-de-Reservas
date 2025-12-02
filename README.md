# 📅 Gerenciador de Reservas

## 📝 Sobre o Projeto

O **Gerenciador de Reservas** é uma aplicação web desenvolvida em Laravel com arquitetura **Multi-Usuário**, projetada para operar com dois perfis distintos:

*   **Clientes (Usuários Comuns):** Realizam e gerenciam suas reservas.
*   **Empresas (Fornecedores):** Cadastram seus produtos/serviços e operam suas próprias "lojas" dentro do sistema.

O sistema garante que cada **Empresa** tenha **gestão 100% individual** sobre seus produtos e reservas, funcionando como um *marketplace* onde cada fornecedor oferece seus serviços separadamente e com total isolamento de dados em relação às outras empresas.

## ✨ Funcionalidades Atuais

*   **Autenticação Dupla:** Login e Registro para Clientes e Empresas.
*   **Gestão de Produtos/Serviços:** Empresas podem registrar itens disponíveis para reserva.
*   **Vitrine/Loja:** Clientes podem navegar e visualizar produtos/serviços.
*   **Realização de Reservas:** Funcionalidade principal para clientes.
*   **Estrutura de Serviços (Services):** Lógica de negócio refatorada para a camada de Services.

## 🛠️ Tecnologias Utilizadas

*   **Backend:** PHP 8.1+
*   **Framework:** Laravel 10.x
*   **Banco de Dados:** MySql
*   **Gerenciador de Dependências:** Composer

## 🚀 Instalação e Configuração

Siga os passos abaixo para configurar o ambiente de desenvolvimento.

### Pré-requisitos

*   PHP >= 8.1
*   Composer
*   Um servidor web (Apache, Nginx, Laravel Sail ou Herd)
*   Banco de dados MySql

### Passos de Instalação

1.  **Clone o repositório:**
    
    ```shell
    git clone https://github.com/brunoPP29/Gerenciador-de-Reservas.git
    cd Gerenciador-de-Reservas
    ```
    
2.  **Instale as dependências do Composer:**
    
    ```shell
    composer install
    ```
    
3.  **Crie o arquivo de ambiente:**
    
    ```shell
    cp .env.example .env
    ```
    
4.  **Gere a chave da aplicação:**
    
    ```shell
    php artisan key:generate
    ```
    
5.  **Configuração do Banco de Dados (MySQL ):**
    
    *   Crie um banco de dados vazio no seu servidor MySQL (ex: `gerenciador_reservas`).
    *   Edite o arquivo `.env` e configure as credenciais de acesso.
    
    ```dotenv
    DB_CONNECTION=mysql
    DB_HOST=127.0.0.1
    DB_PORT=3306
    DB_DATABASE=gerenciador_reservas # Nome do banco de dados que você criou
    DB_USERNAME=homestead          # Seu usuário MySQL (ex: root, homestead)
    DB_PASSWORD=secret             # Sua senha MySQL
    ```
    
6.  **Execute as Migrações:**
    
    ```shell
    php artisan migrate
    ```
    
7.  **Inicie o Servidor de Desenvolvimento:**
    
    ```shell
    php artisan serve
    ```
    
    A aplicação estará acessível em `http://127.0.0.1:8000`.

## 🤝 Como Contribuir

Contribuições são bem-vindas! Se você deseja contribuir, siga os passos:

1.  Faça um _fork_ do projeto.
2.  Crie uma _branch_ para sua funcionalidade (`git checkout -b feature/minha-feature` ).
3.  Faça o _commit_ das suas alterações (`git commit -m 'feat: Adiciona nova funcionalidade X'`).
4.  Faça o _push_ para a _branch_ (`git push origin feature/minha-feature`).
5.  Abra um _Pull Request_.

## 📄 Licença

O projeto está licenciado sob a licença **MIT**. Veja o arquivo `LICENSE` para mais detalhes.

_Desenvolvido por brunoPP29_

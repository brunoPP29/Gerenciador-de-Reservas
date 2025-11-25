
## 📅 Gerenciador de Reservas

<p align="center">
  <a href="https://laravel.com" target="_blank">
    <img src="https://raw.githubusercontent.com/laravel/art/master/logo-lockup/5%20SVG/2%20CMYK/1%20Full%20Color/laravel-logolockup-cmyk-red.svg" width="200" alt="Laravel Logo">
  </a>
</p>

<p align="center">
  <img src="https://img.shields.io/badge/Laravel-v10.x-FF2D20?style=for-the-badge&logo=laravel&logoColor=white" alt="Laravel Version">
  <img src="https://img.shields.io/badge/PHP-v8.1+-777BB4?style=for-the-badge&logo=php&logoColor=white" alt="PHP Version">
  <img src="https://img.shields.io/badge/Status-Em%20Desenvolvimento-yellow?style=for-the-badge" alt="Status do Projeto">
</p>

## 📝 Descrição do Projeto

O **Gerenciador de Reservas** é uma aplicação web desenvolvida em Laravel, projetada para facilitar a gestão de reservas de produtos ou serviços. O sistema oferece uma plataforma dupla, permitindo o registro e login de **usuários comuns** (clientes) e **usuários empresariais** (fornecedores), que podem cadastrar seus produtos/serviços e gerenciar suas respectivas lojas e reservas.

**Principais Módulos Identificados:**

*   **Autenticação:** Login e Registro para Clientes e Empresas.
*   **Gestão de Empresas:** Cadastro de empresas e produtos/serviços.
*   **Vitrine/Loja:** Visualização de produtos/serviços por empresa.
*   **Reservas:** Funcionalidade principal para clientes realizarem reservas.

## 🛠️ Tecnologias Utilizadas

O projeto é construído sobre uma pilha de tecnologias robusta e moderna:

*   **Backend:** PHP 8.1+
*   **Framework:** Laravel 10.x
*   **Banco de Dados:** (A ser definido, mas tipicamente MySQL, PostgreSQL ou SQLite)
*   **Gerenciador de Dependências:** Composer

## ✨ Funcionalidades Atuais

As seguintes funcionalidades foram implementadas e estão em fase de desenvolvimento:

*   **Login e Registro de Usuário:** Sistema de autenticação seguro (com hashing de senha).
*   **Login e Registro de Empresa:** Sistema de autenticação e cadastro dedicado para fornecedores.
*   **Cadastro de Produtos/Serviços:** Empresas podem registrar itens disponíveis para reserva.
*   **Visualização de Loja:** Clientes podem navegar pela vitrine de produtos de uma empresa específica.
*   **Realização de Reservas:** Clientes podem reservar produtos/serviços.
*   **Estrutura de Serviços (Services):** Refatoração inicial da lógica de negócio para a camada de Services (`LoginService`, `RegisterService`, etc.), promovendo um código mais limpo e manutenível.

## 🚀 Instalação e Configuração

Siga os passos abaixo para configurar o ambiente de desenvolvimento:

### Pré-requisitos

*   PHP >= 8.1
*   Composer
*   Um servidor web (Apache ou Nginx) ou Laravel Sail/Herd
*   Banco de dados (MySQL, PostgreSQL, etc.)

### Passos de Instalação

1.  **Clone o repositório:**
    ```bash
    git clone https://github.com/brunoPP29/Gerenciador-de-Reservas.git
    cd Gerenciador-de-Reservas
    ```

2.  **Instale as dependências do Composer:**
    ```bash
    composer install
    ```

3.  **Crie o arquivo de ambiente:**
    ```bash
    cp .env.example .env
    ```

4.  **Gere a chave da aplicação:**
    ```bash
    php artisan key:generate
    ```

5.  **Configure o Banco de Dados:**
    Edite o arquivo `.env` com as credenciais do seu banco de dados.

6.  **Execute as Migrações:**
    ```bash
    php artisan migrate
    ```

7.  **Inicie o Servidor de Desenvolvimento:**
    ```bash
    php artisan serve
    ```
    A aplicação estará acessível em `http://127.0.0.1:8000`.

## 🤝 Como Contribuir

Contribuições são bem-vindas! Se você deseja contribuir, siga os passos:

1.  Faça um *fork* do projeto.
2.  Crie uma *branch* para sua funcionalidade (`git checkout -b feature/minha-feature`).
3.  Faça o *commit* das suas alterações (`git commit -m 'feat: Adiciona nova funcionalidade X'`).
4.  Faça o *push* para a *branch* (`git push origin feature/minha-feature`).
5.  Abra um *Pull Request*.

## 🗺️ Roadmap (O que falta no projeto)

Esta seção lista as principais áreas que precisam de desenvolvimento ou melhoria para tornar o projeto completo e robusto.
| Funcionalidade/Melhoria | Implementado | |
| :--- | :---: | :--- |
| **Documentação Completa**| Detalhar a API, o fluxo de dados e as regras de negócio. |
| **Painel de Gerenciamento (Empresa)**| Interface para empresas visualizarem e gerenciarem suas reservas. |
| **Painel de Gerenciamento (Cliente)**| Interface para clientes visualizarem, alterarem e cancelarem suas reservas. |
| **Confirmação de Reserva (Email/Notificação)**| Implementar sistema de notificação para clientes e empresas. |


## 📄 Licença

O projeto está licenciado sob a licença **MIT**. Veja o arquivo `LICENSE` para mais detalhes.

---

*Desenvolvido por brunoPP29*_

# Portal Web CDT-IFPR

Este projeto é um portal desenvolvido para o gerenciamento de projetos de extensão do CDT-IFPR, permitindo a automação de processos como a emissão e validação de certificados, além da divulgação de notícias e informações institucionais.

## Requisitos

Antes de começar, certifique-se de que possui os seguintes softwares instalados:

1. [Node.js](https://nodejs.org/en/download/package-manager)
2. [XAMPP](https://sourceforge.net/projects/xampp/files/XAMPP%20Windows/8.2.12/xampp-windows-x64-8.2.12-0-VS16-installer.exe/download)
3. [ImageMagick](https://www.php.net/manual/en/book.imagick.php)
4. [Composer](https://getcomposer.org/download/)

**Opcional:**
- [Git](https://git-scm.com/downloads)

## Instalação

1. **Clone o projeto:**

   ```bash
   git clone <url-do-repositorio>
   ```

2. **Acesse a pasta do projeto:**

   ```bash
   cd <nome-da-pasta>
   ```

3. **Instale as dependências do Node.js:**

   ```bash
   npm install
   ```

4. **Configure o PHP:**
   - Acesse o diretório de instalação do PHP dentro da pasta do XAMPP.
   - Abra o arquivo `php.ini`.
   - Localize a extensão `gd` e remova o ponto-e-vírgula (`;`) antes dela:
     ```ini
     ;extension=gd
     ```
     Altere para:
     ```ini
     extension=gd
     ```
   - Localize a extensão `zip` e remova o ponto-e-vírgula (`;`) antes dela:
     ```ini
     ;extension=zip
     ```
     Altere para:
     ```ini
     extension=zip
     ```

5. **Atualize as dependências do Composer:**

   ```bash
   composer update
   ```

6. **Substitua a pasta `setasign`:**
   - Na raiz do projeto, localize a pasta `setasign`.
   - Copie-a e substitua o conteúdo correspondente na pasta `vendor`.

7. **Configure o arquivo de ambiente:**
   - Renomeie o arquivo `.env-example` para `.env`.
   - Insira as credenciais do e-mail (necessárias para a criação de membros).

8. **Inicie o servidor XAMPP:**
   - Abra o XAMPP e inicie os serviços `Apache` e `MySQL`.

9. **Crie o banco de dados:**
   - No painel do XAMPP, clique em "Admin" no serviço `MySQL`.
   - Crie um novo banco de dados com o nome desejado.

10. **Configure o projeto:**
    - Gere a chave da aplicação:
      ```bash
      php artisan key:generate
      ```
    - Realize as migrações do banco de dados:
      ```bash
      php artisan migrate
      ```
    - Popule o banco de dados com dados iniciais:
      ```bash
      php artisan db:seed
      ```
    - Execute os seguintes comandos para carregar os assets:
      ```bash
      npm run build
      ```
      ou
      
      ```bash
      npm run dev
      ```
    - Execute o projeto com o comando:
      ```bash
      php artisan serve
      ```

11. **Acesse o sistema:**
    - No navegador, acesse:
      `/login`
      `/admin`

---

### Nota

- Para criar um novo membro, é necessário configurar as credenciais de e-mail no arquivo `.env`.

---

## Contribuições

Contribuições são bem-vindas! Siga o fluxo padrão de *fork*, *branch* e *pull request*.

## Licença

Este projeto está licenciado sob a licença MIT. Consulte o arquivo `LICENSE` para mais informações.

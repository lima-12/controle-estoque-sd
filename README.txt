# Sistema de Controle de Estoque - Stok

Sistema de controle de estoque desenvolvido em PHP com banco de dados MySQL.

## Configuração do Banco de Dados

### 1. Estrutura da Tabela de Usuários

O sistema já está configurado para usar a seguinte tabela:

```sql
CREATE TABLE stok.usuarios (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nome VARCHAR(100) NOT NULL,
    email VARCHAR(100) NOT NULL UNIQUE,
    senha VARCHAR(255) NOT NULL
);
```

### 2. Configuração de Conexão

As configurações de conexão estão em `src/config/Config.php`:

```php
define('DB_HOST', 'db');           // nome do serviço no docker-compose
define('DB_PORT', '3306');         // porta interna do container MySQL
define('DB_NAME', 'stok');         // nome do banco
define('DB_USER', 'stok_user');    // usuário do banco
define('DB_PASSWORD', 'stok_pass'); // senha do banco
```

## Funcionalidades Implementadas

### ✅ Sistema de Login
- Autenticação via banco de dados MySQL
- Hash seguro de senhas com `password_hash()`
- Verificação de senhas com `password_verify()`
- Sessões PHP para controle de acesso

### ✅ Sistema de Cadastro
- Cadastro de novos usuários
- Validação de e-mail único
- Hash automático de senhas
- Mensagens de erro e sucesso

### ✅ Proteção de Sessão
- Verificação de login em todas as páginas protegidas
- Redirecionamento automático para login
- Sistema de logout funcional

### ✅ Dashboard Principal
- Listagem de produtos do banco de dados
- Filtros por categoria, status e período
- Busca por nome de produto
- Proteção de acesso (requer login)

## Como Usar

### 1. Primeiro Acesso
1. Acesse a página de cadastro: `src/views/cadastro.php`
2. Crie sua conta com nome, e-mail e senha
3. Faça login na página: `src/views/login.php`

### 2. Login
1. Acesse: `src/views/login.php`
2. Digite seu e-mail e senha
3. Após autenticação, será redirecionado para o dashboard

### 3. Dashboard
- Visualize produtos cadastrados
- Use filtros para encontrar produtos específicos
- Acesse o menu do usuário para sair

### 4. Logout
- Clique no menu do usuário (canto superior direito)
- Selecione "Sair"
- Será redirecionado para a tela de login

## Arquivos Principais

- `src/views/login.php` - Tela de login
- `src/views/cadastro.php` - Tela de cadastro
- `src/views/telaPrincipal.php` - Dashboard principal
- `src/Model/Usuario.php` - Modelo de usuário
- `src/Model/Produto.php` - Modelo de produto
- `src/config/Conexao.php` - Classe de conexão com banco
- `src/controllers/sair.php` - Controlador de logout

## Teste de Conexão

Para testar se a conexão com o banco está funcionando:

```bash
php teste_conexao.php
```

## Segurança

- Senhas são hasheadas com `password_hash()`
- Validação de entrada de dados
- Proteção contra SQL injection usando prepared statements
- Controle de sessão para páginas protegidas
- Escape de HTML para evitar XSS

## Próximos Passos

- Implementar recuperação de senha
- Adicionar upload de foto de perfil
- Implementar edição de perfil
- Adicionar mais campos na tabela de usuários se necessário
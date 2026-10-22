# Pokédex Comentários — API Flask

## Requisitos
- Python 3 instalado
- MySQL iniciado
- Banco `pokemon_bd` com a tabela `comentarios`

## 1. Criar banco e tabela
No phpMyAdmin, abra a aba SQL e execute o conteúdo de `database/banco.sql`.

## 2. Instalar as dependências
Abra o terminal nesta pasta e execute:

```bash
pip install -r requirements.txt
```

## 3. Iniciar a API e o site
Execute:

```bash
python app.py
```

Abra no navegador: http://127.0.0.1:5000

A API disponibiliza:
- `GET /api/comentarios`: lista os registros em JSON.
- `POST /api/comentarios`: cadastra um registro recebido em JSON.

A configuração do banco usa, por padrão, host `localhost`, usuário `root`, senha vazia e banco `pokemon_bd`. Se sua instalação usar outras credenciais, defina `DB_HOST`, `DB_USER`, `DB_PASSWORD` e `DB_NAME` antes de iniciar o servidor.

O CORS está ativado por `flask-cors`. O formulário usa `fetch`, `Content-Type: application/json`, `JSON.stringify()` e `try/catch`. Após o cadastro, a lista é atualizada sem recarregar a página.

from flask import Flask, jsonify, request, send_from_directory
from flask_cors import CORS
import mysql.connector
import os

app = Flask(__name__)
CORS(app)  # Permite requisições de origens diferentes, conforme solicitado.


def conectar_banco():
    return mysql.connector.connect(
        host=os.getenv("DB_HOST", "localhost"),
        user=os.getenv("DB_USER", "root"),
        password=os.getenv("DB_PASSWORD", ""),
        database=os.getenv("DB_NAME", "pokemon_bd")
    )


@app.route("/")
def inicio():
    return send_from_directory(".", "index.html")


@app.route("/CSS/<path:nome_arquivo>")
def arquivos_css(nome_arquivo):
    return send_from_directory("CSS", nome_arquivo)


@app.route("/js/<path:nome_arquivo>")
def arquivos_js(nome_arquivo):
    return send_from_directory("js", nome_arquivo)


@app.route("/api/comentarios", methods=["GET"])
def listar_comentarios():
    conexao = None
    cursor = None

    try:
        conexao = conectar_banco()
        cursor = conexao.cursor(dictionary=True)
        cursor.execute(
            "SELECT id, pokemon, nota, comentario FROM comentarios ORDER BY id DESC"
        )
        comentarios = cursor.fetchall()
        return jsonify(comentarios), 200

    except mysql.connector.Error:
        return jsonify({"erro": "Não foi possível consultar os comentários no banco de dados."}), 500

    finally:
        if cursor:
            cursor.close()
        if conexao and conexao.is_connected():
            conexao.close()


@app.route("/api/comentarios", methods=["POST"])
def cadastrar_comentario():
    dados = request.get_json(silent=True)

    if not dados:
        return jsonify({"erro": "Envie os dados no formato JSON."}), 400

    pokemon = str(dados.get("pokemon", "")).strip()
    comentario = str(dados.get("comentario", "")).strip()

    try:
        nota = float(dados.get("nota"))
    except (TypeError, ValueError):
        return jsonify({"erro": "A nota precisa ser um número entre 0 e 10."}), 400

    if not pokemon or not comentario:
        return jsonify({"erro": "Preencha o nome do Pokémon e o comentário."}), 400

    if nota < 0 or nota > 10:
        return jsonify({"erro": "A nota deve estar entre 0 e 10."}), 400

    conexao = None
    cursor = None

    try:
        conexao = conectar_banco()
        cursor = conexao.cursor()
        cursor.execute(
            "INSERT INTO comentarios (pokemon, nota, comentario) VALUES (%s, %s, %s)",
            (pokemon, nota, comentario)
        )
        conexao.commit()

        return jsonify({
            "mensagem": "Comentário cadastrado com sucesso.",
            "id": cursor.lastrowid
        }), 201

    except mysql.connector.Error:
        if conexao:
            conexao.rollback()
        return jsonify({"erro": "Não foi possível salvar o comentário no banco de dados."}), 500

    finally:
        if cursor:
            cursor.close()
        if conexao and conexao.is_connected():
            conexao.close()


if __name__ == "__main__":
    app.run(debug=True, port=5000)

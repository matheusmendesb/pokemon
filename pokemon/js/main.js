const inputPokemon = document.getElementById('pokemonInput');
const btnBuscar = document.getElementById('btnBuscar');
const resultadoPokemon = document.getElementById('resultado');
const formulario = document.getElementById('formComentario');
const mensagemFormulario = document.getElementById('mensagemFormulario');
const listaComentarios = document.getElementById('dados');

// Consulta a PokéAPI para mostrar informações de um Pokémon.
async function buscarPokemon() {
    const busca = inputPokemon.value.toLowerCase().trim();

    if (!busca) {
        resultadoPokemon.textContent = 'Digite o nome de um Pokémon.';
        return;
    }

    resultadoPokemon.textContent = 'Buscando Pokémon...';

    try {
        const resposta = await fetch(
            `https://pokeapi.co/api/v2/pokemon/${encodeURIComponent(busca)}`
        );

        if (!resposta.ok) {
            throw new Error('Pokémon não encontrado.');
        }

        const dados = await resposta.json();
        const tipos = dados.types.map(item => item.type.name).join(', ');

        resultadoPokemon.replaceChildren();

        const titulo = document.createElement('h2');
        titulo.textContent = dados.name.toUpperCase();
        resultadoPokemon.appendChild(titulo);

        if (dados.sprites.front_default) {
            const imagem = document.createElement('img');
            imagem.src = dados.sprites.front_default;
            imagem.alt = `Imagem de ${dados.name}`;
            resultadoPokemon.appendChild(imagem);
        }

        const tipo = document.createElement('p');
        tipo.textContent = `Tipos: ${tipos}`;
        resultadoPokemon.appendChild(tipo);

        const peso = document.createElement('p');
        peso.textContent = `Peso: ${dados.weight / 10} kg`;
        resultadoPokemon.appendChild(peso);

        const altura = document.createElement('p');
        altura.textContent = `Altura: ${dados.height / 10} m`;
        resultadoPokemon.appendChild(altura);

    } catch (erro) {
        resultadoPokemon.textContent =
            'Não encontramos esse Pokémon ou houve um problema na conexão. Tente novamente.';
    }
}

btnBuscar.addEventListener('click', buscarPokemon);

// GET: busca os comentários na API Flask e atualiza a lista.
async function listarComentarios() {
    listaComentarios.textContent = 'Carregando comentários...';

    try {
        const resposta = await fetch('/api/comentarios');

        if (!resposta.ok) {
            throw new Error('Falha ao carregar comentários.');
        }

        const comentarios = await resposta.json();
        listaComentarios.replaceChildren();

        if (comentarios.length === 0) {
            listaComentarios.textContent = 'Nenhum comentário cadastrado.';
            return;
        }

        const tabela = document.createElement('table');
        tabela.border = '1';

        const cabecalho = document.createElement('tr');
        ['ID', 'Pokémon', 'Nota', 'Comentário'].forEach(texto => {
            const th = document.createElement('th');
            th.textContent = texto;
            cabecalho.appendChild(th);
        });
        tabela.appendChild(cabecalho);

        comentarios.forEach(item => {
            const linha = document.createElement('tr');

            [item.id, item.pokemon, item.nota, item.comentario].forEach(valor => {
                const celula = document.createElement('td');
                celula.textContent = valor ?? '';
                linha.appendChild(celula);
            });

            tabela.appendChild(linha);
        });

        listaComentarios.appendChild(tabela);

    } catch (erro) {
        listaComentarios.textContent =
            'Não foi possível carregar os comentários. Verifique se a API está funcionando e tente novamente.';
    }
}

// POST: envia o novo comentário como JSON para a API Flask.
formulario.addEventListener('submit', async evento => {
    evento.preventDefault();

    const dadosFormulario = {
        pokemon: document.getElementById('pokemon').value.trim(),
        nota: Number(document.getElementById('nota').value),
        comentario: document.getElementById('comentario').value.trim()
    };

    mensagemFormulario.textContent = 'Salvando comentário...';

    try {
        const resposta = await fetch('/api/comentarios', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json'
            },
            body: JSON.stringify(dadosFormulario)
        });

        const resultado = await resposta.json();

        if (!resposta.ok) {
            throw new Error(resultado.erro || 'Não foi possível salvar o comentário.');
        }

        mensagemFormulario.textContent = 'Comentário cadastrado com sucesso!';
        formulario.reset();

        // Atualiza a lista sem recarregar a página.
        await listarComentarios();

    } catch (erro) {
        mensagemFormulario.textContent =
            erro.message || 'Ocorreu um erro ao enviar o comentário. Tente novamente.';
    }
});

// Carrega a lista quando a página abre.
listarComentarios();

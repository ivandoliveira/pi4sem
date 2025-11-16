document.addEventListener('DOMContentLoaded', async () => {

    const API_CONSULTAR_PRODUTOS_URL = "http://localhost/ecommerce_api/api/produto/consulta_todos_produtos.php";

    try {
        const response = await fetch(API_CONSULTAR_PRODUTOS_URL, {
            method: 'GET',
            headers: {
                'Content-Type': 'application/json',
            }
        });

        const result = await response.json();

        if (response.ok) {

            let container = document.getElementById("lista-produtos");

            result.records.forEach(produto => {

                let card = `
                    <div class="col-md-4 py-2">
                        <div class="card shadow-sm h-100"
                            data-produto-id="${produto.idProduto}"
                            data-produto-nome="${produto.nomeProduto}"
                            data-produto-preco="${produto.precProduto}"
                            data-produto-artesao="${produto.artesao.nome}"
                            data-produto-imagem="${produto.imagem}">
                            
                            <img src="${produto.imagem}" class="card-img-top card-img-fixed" alt="${produto.nomeProduto}">
                            
                            <div class="card-body">
                                <h5 class="card-title">${produto.nomeProduto}</h5>
                                <p class="card-text text-muted mb-1">por ${produto.artesao.nome}</p>
                                <span class="fw-bold cor-p1 d-block mb-3">
                                    R$ ${produto.precProduto.toFixed(2)}
                                </span>
                                <button class="btn btn-carrinho w-100 btn-adicionar-carrinho">
                                    Adicionar ao Carrinho
                                </button>
                            </div>
                        </div>
                    </div>
                `;

                container.innerHTML += card;
            });

        } else {
            throw new Error("Resposta inesperada do servidor.");
        }

    } catch (error) {
        console.error('Erro na requisição:', error);
    }

});

document.addEventListener('DOMContentLoaded', async () => {

    const API_CONSULTAR_USUARIOS_URL = "http://localhost/ecommerce_api/api/usuario/consulta_produtos_usuario.php";

    try {
        const response = await fetch(API_CONSULTAR_USUARIOS_URL, {
            method: 'GET',
            headers: {
                'Content-Type': 'application/json',
            }
        });

        const result = await response.json();

        if (response.ok) {

            let container = document.getElementById("listar-artesoes");

            result.records.forEach(artesao => {

                let card = `
                <div class="col-md-4">
                    <div class="card border-0 shadow-sm h-100">
                        <img src="${artesao.imagem}" class="card-img-top card-img-fixed " alt="${artesao.nomeUsuario}">

                        <div class="card-body">
                            <h5 class="card-title">${artesao.nomeUsuario}</h5>
                            <p class="text-muted mb-0">Minas Gerais</p>
                            <small class="text-secondary">${artesao.total_produtos} produtos | 3 prêmios</small>
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

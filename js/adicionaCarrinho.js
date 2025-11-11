// Sistema de Carrinho de Compras
class CarrinhoDeCompras {
  constructor() {
    this.itens = [];
    this.carregarCarrinho();
    this.inicializarEventListeners();
  }

  carregarCarrinho() {
    const carrinhoSalvo = localStorage.getItem("carrinhoArtesanato");
    if (carrinhoSalvo) {
      this.itens = JSON.parse(carrinhoSalvo);
      this.atualizarInterface();
    }
  }

  salvarCarrinho() {
    localStorage.setItem("carrinhoArtesanato", JSON.stringify(this.itens));
  }

  inicializarEventListeners() {
    // Adicionar ao Carrinho
    document.addEventListener("click", (e) => {
      if (
        e.target.classList.contains("btn-adicionar-carrinho") ||
        e.target.closest(".btn-adicionar-carrinho")
      ) {
        const card = e.target.closest("[data-produto-id]");
        if (card) {
          this.adicionarProduto({
            id: card.dataset.produtoId,
            nome: card.dataset.produtoNome,
            preco: parseFloat(card.dataset.produtoPreco),
            artesao: card.dataset.produtoArtesao,
            imagem: card.dataset.produtoImagem,
          });
        }
      }
    });
  }

  // Adiciona produto ao carrinho
  adicionarProduto(produto) {
    const produtoExistente = this.itens.find((item) => item.id === produto.id);

    if (produtoExistente) {
      produtoExistente.quantidade++;
    } else {
      this.itens.push({
        ...produto,
        quantidade: 1,
      });
    }

    this.atualizarInterface();
    this.mostrarNotificacao(`${produto.nome} adicionado ao carrinho!`);
    this.salvarCarrinho();
  }

  // Remove produto do carrinho
  removerProduto(id) {
    this.itens = this.itens.filter((item) => item.id !== id);
    this.atualizarInterface();
    this.salvarCarrinho();
    this.mostrarNotificacao("Produto removido do carrinho!");
  }

  // Atualiza quantidade do produto
  atualizarQuantidade(id, novaQuantidade) {
    if (novaQuantidade <= 0) {
      this.removerProduto(id);
      return;
    }

    const produto = this.itens.find((item) => item.id === id);
    if (produto) {
      produto.quantidade = parseInt(novaQuantidade);
      this.atualizarInterface();
      this.salvarCarrinho();
    }
  }

  // Limpa todo o carrinho
  limparCarrinho() {
    if (this.itens.length === 0) return;

    if (confirm("Tem certeza que deseja limpar o carrinho?")) {
      this.itens = [];
      this.atualizarInterface();
      this.salvarCarrinho();
      this.mostrarNotificacao("Carrinho limpo!");
    }
  }

  // Calcula o total do carrinho
  calcularTotal() {
    return this.itens.reduce(
      (total, item) => total + item.preco * item.quantidade,
      0
    );
  }

  // Atualiza o carrinho
  atualizarInterface() {
    const contador = document.getElementById("contador-carrinho");
    const carrinhoVazio = document.getElementById("carrinho-vazio");
    const carrinhoItens = document.getElementById("carrinho-itens");
    const tbody = document.getElementById("itens-carrinho-tbody");
    const totalElement = document.getElementById("total-carrinho");

    // Atualiza o contador
    const totalItens = this.itens.reduce(
      (sum, item) => sum + item.quantidade,
      0
    );

    if (totalItens > 0) {
      contador.textContent = totalItens;
      contador.style.display = "block";
    } else {
      contador.style.display = "none";
    }

    // Atualiza o modal do carrinho
    if (this.itens.length === 0) {
      carrinhoVazio.style.display = "block";
      carrinhoItens.style.display = "none";
    } else {
      carrinhoVazio.style.display = "none";
      carrinhoItens.style.display = "block";

      // Limpa e recria a tabela de itens
      tbody.innerHTML = "";

      this.itens.forEach((item) => {
        const subtotal = item.preco * item.quantidade;
        const row = document.createElement("tr");
        row.innerHTML = `
                    <td>
                        <div class="d-flex align-items-center">
                            <img src="${item.imagem}" alt="${
          item.nome
        }" class="rounded me-3" style="width: 60px; height: 60px; object-fit: cover;">
                            <div>
                                <strong>${item.nome}</strong><br>
                                <small class="text-muted">por ${
                                  item.artesao
                                }</small>
                            </div>
                        </div>
                    </td>
                    <td class="align-middle">R$ ${item.preco.toFixed(2)}</td>
                    <td class="align-middle">
                        <input type="number" 
                               value="${item.quantidade}" 
                               min="1" 
                               class="form-control form-control-sm" 
                               style="width: 80px;"
                               onchange="carrinho.atualizarQuantidade('${
                                 item.id
                               }', this.value)">
                    </td>
                    <td class="align-middle">R$ ${subtotal.toFixed(2)}</td>
                    <td class="align-middle">
                        <button class="btn btn-outline-danger btn-sm" 
                                onclick="carrinho.removerProduto('${item.id}')">
                            Remover
                        </button>
                    </td>
                `;
        tbody.appendChild(row);
      });

      // Atualiza total
      totalElement.textContent = this.calcularTotal().toFixed(2);
    }
  }

  // Mostra o modal do carrinho
  mostrarCarrinho() {
    this.atualizarInterface();
    const modal = new bootstrap.Modal(document.getElementById("modalCarrinho"));
    modal.show();
  }

  // Finaliza a compra
  finalizarCompra() {
    if (this.itens.length === 0) {
      alert("Seu carrinho está vazio!");
    } else {
      window.location.href = "finalizar-compra.html";
    }

    const total = this.calcularTotal();
    const modal = bootstrap.Modal.getInstance(
      document.getElementById("modalCarrinho")
    );
  }

  // Mostra notificação
  mostrarNotificacao(mensagem) {
    const toastElement = document.getElementById("toastCarrinho");
    const toastMessage = document.getElementById("toast-message");

    toastMessage.textContent = mensagem;

    const toast = new bootstrap.Toast(toastElement);
    toast.show();
  }

  // Retorna os itens do carrinho
  getItens() {
    return this.itens;
  }

  // Retorna o total de itens
  getTotalItens() {
    return this.itens.reduce((sum, item) => sum + item.quantidade, 0);
  }
}

// Inicializa o carrinho quando a página carrega
let carrinho;

document.addEventListener("DOMContentLoaded", function () {
  carrinho = new CarrinhoDeCompras();

  document.querySelectorAll(".card").forEach((card, index) => {
    if (!card.hasAttribute("data-produto-id")) {
      const titulo = card.querySelector(".card-title");
      const preco = card.querySelector(".cor-p1");
      const artesao = card.querySelector(".text-muted");
      const imagem = card.querySelector("img");

      if (titulo && preco && artesao && imagem) {
        card.setAttribute("data-produto-id", (index + 1).toString());
        card.setAttribute("data-produto-nome", titulo.textContent);
        card.setAttribute(
          "data-produto-preco",
          preco.textContent.replace("R$ ", "").replace(",", ".")
        );
        card.setAttribute(
          "data-produto-artesao",
          artesao.textContent.replace("por ", "")
        );
        card.setAttribute("data-produto-imagem", imagem.src);
      }
    }

    // Garante que os botões tenham a classe correta
    const botao = card.querySelector(".btn-carrinho");
    if (botao && !botao.classList.contains("btn-adicionar-carrinho")) {
      botao.classList.add("btn-adicionar-carrinho");
    }
  });
});

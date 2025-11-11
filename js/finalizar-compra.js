// Sistema de Finalização de Compra
class FinalizarCompra {
  constructor() {
    this.carrinho =
      JSON.parse(localStorage.getItem("carrinhoArtesanato")) || [];
    this.pedido = {};
    this.init();
  }

  init() {
    this.carregarResumoPedido();
    this.inicializarEventListeners();
    this.validarCarrinho();
  }

  // Valida se há itens no carrinho
  validarCarrinho() {
    if (this.carrinho.length === 0) {
      document.getElementById("btn-finalizar-pedido").disabled = true;
      document.getElementById("resumo-vazio").style.display = "block";
    } else {
      document.getElementById("btn-finalizar-pedido").disabled = false;
      document.getElementById("resumo-vazio").style.display = "none";
    }
  }

  // Carrega o resumo do pedido
  carregarResumoPedido() {
    const resumoContainer = document.getElementById("resumo-pedido");
    const subtotalElement = document.getElementById("subtotal");
    const totalElement = document.getElementById("total");

    if (this.carrinho.length === 0) {
      resumoContainer.innerHTML = `
                <div id="resumo-vazio" class="text-center py-4">
                    <p class="text-muted">Carrinho vazio</p>
                    <a href="index.html" class="btn btn-carrinho">Continuar Comprando</a>
                </div>
            `;
      subtotalElement.textContent = "R$ 0,00";
      totalElement.textContent = "R$ 0,00";
      return;
    }

    let html = "";
    let subtotal = 0;

    this.carrinho.forEach((item) => {
      const itemSubtotal = item.preco * item.quantidade;
      subtotal += itemSubtotal;

      html += `
                <div class="d-flex align-items-center mb-3 pb-3 border-bottom">
                    <img src="${item.imagem}" alt="${item.nome}" 
                         class="rounded me-3" style="width: 60px; height: 60px; object-fit: cover;">
                    <div class="flex-grow-1">
                        <h6 class="mb-1">${item.nome}</h6>
                        <small class="text-muted">por ${item.artesao}</small>
                        <div class="d-flex justify-content-between align-items-center mt-1">
                            <small>Qtd: ${item.quantidade}</small>
                            <strong class="cor-p1">R$ ${itemSubtotal.toFixed(
                              2
                            )}</strong>
                        </div>
                    </div>
                </div>
            `;
    });

    resumoContainer.innerHTML = html;
    subtotalElement.textContent = `R$ ${subtotal.toFixed(2)}`;
    totalElement.textContent = `R$ ${subtotal.toFixed(2)}`;
  }


  inicializarEventListeners() {
    // Forma de pagamento
    document
      .querySelectorAll('input[name="forma-pagamento"]')
      .forEach((radio) => {
        radio.addEventListener("change", (e) => {
          this.atualizarFormaPagamento(e.target.value);
        });
      });

    // Formulário de finalização
    document
      .getElementById("form-finalizar-compra")
      .addEventListener("submit", (e) => {
        e.preventDefault();
        this.finalizarPedido();
      });

    // Máscaras para os campos
    this.aplicarMascaras();
  }

  // Atualiza a forma de pagamento selecionada
  atualizarFormaPagamento(forma) {
    const camposCartao = document.getElementById("campos-cartao");
    const infoPix = document.getElementById("info-pix");
    const infoBoleto = document.getElementById("info-boleto");

    // Esconde todos
    camposCartao.style.display = "none";
    infoPix.style.display = "none";
    infoBoleto.style.display = "none";

    // Mostra apenas o selecionado
    switch (forma) {
      case "cartao":
        camposCartao.style.display = "block";
        break;
      case "pix":
        infoPix.style.display = "block";
        break;
      case "boleto":
        infoBoleto.style.display = "block";
        break;
    }
  }

  // Aplica máscaras aos campos
  aplicarMascaras() {
    // Telefone
    document.getElementById("telefone").addEventListener("input", function (e) {
      let value = e.target.value.replace(/\D/g, "");
      if (value.length <= 11) {
        value = value.replace(/(\d{2})(\d)/, "($1) $2");
        value = value.replace(/(\d{5})(\d)/, "$1-$2");
        e.target.value = value;
      }
    });

    // CEP
    document.getElementById("cep").addEventListener("input", function (e) {
      let value = e.target.value.replace(/\D/g, "");
      if (value.length <= 8) {
        value = value.replace(/(\d{5})(\d)/, "$1-$2");
        e.target.value = value;
      }
    });

    // Número do cartão
    document
      .getElementById("numero-cartao")
      .addEventListener("input", function (e) {
        let value = e.target.value.replace(/\D/g, "");
        value = value.replace(/(\d{4})(?=\d)/g, "$1 ");
        e.target.value = value.substring(0, 19);
      });

    // Validade do cartão
    document.getElementById("validade").addEventListener("input", function (e) {
      let value = e.target.value.replace(/\D/g, "");
      if (value.length <= 4) {
        value = value.replace(/(\d{2})(?=\d)/, "$1/");
        e.target.value = value;
      }
    });
  }

  // Valida o formulário
  validarFormulario() {
    const form = document.getElementById("form-finalizar-compra");
    const requiredFields = form.querySelectorAll("[required]");
    let isValid = true;

    requiredFields.forEach((field) => {
      if (!field.value.trim()) {
        field.classList.add("is-invalid");
        isValid = false;
      } else {
        field.classList.remove("is-invalid");
      }
    });

    // Validação específica para cartão se selecionado
    const formaPagamento = document.querySelector(
      'input[name="forma-pagamento"]:checked'
    ).value;
    if (formaPagamento === "cartao") {
      const numeroCartao = document
        .getElementById("numero-cartao")
        .value.replace(/\s/g, "");
      if (numeroCartao.length !== 16) {
        document.getElementById("numero-cartao").classList.add("is-invalid");
        isValid = false;
      }
    }

    return isValid;
  }

  // Finaliza o pedido
  finalizarPedido() {
    if (!this.validarFormulario()) {
      alert("Por favor, preencha todos os campos obrigatórios corretamente.");
      return;
    }

    if (this.carrinho.length === 0) {
      alert("Seu carrinho está vazio!");
      return;
    }

    // Coleta os dados do formulário
    const formData = new FormData(
      document.getElementById("form-finalizar-compra")
    );
    const dadosCliente = {
      pessoais: {
        nome: formData.get("nome-completo"),
        email: formData.get("email"),
        telefone: formData.get("telefone"),
      },
      endereco: {
        cep: formData.get("cep"),
        endereco: formData.get("endereco"),
        numero: formData.get("numero"),
        complemento: formData.get("complemento"),
        cidade: formData.get("cidade"),
        estado: formData.get("estado"),
      },
      pagamento: {
        forma: formData.get("forma-pagamento"),
        ...(formData.get("forma-pagamento") === "cartao" && {
          cartao: {
            numero: formData.get("numero-cartao"),
            nome: formData.get("nome-cartao"),
            validade: formData.get("validade"),
            cvv: formData.get("cvv"),
          },
        }),
      },
    };

    // Cria o pedido
    this.criarPedido(dadosCliente);
  }

  // Cria o pedido completo
  criarPedido(dadosCliente) {
    const numeroPedido = "PED" + Date.now().toString().slice(-6);
    const total = this.carrinho.reduce(
      (sum, item) => sum + item.preco * item.quantidade,
      0
    );

    this.pedido = {
      numero: numeroPedido,
      data: new Date().toISOString(),
      cliente: dadosCliente,
      itens: [...this.carrinho],
      total: total,
      status: "confirmado",
    };

    // Salva o pedido no localStorage
    this.salvarPedido();

    // Limpa o carrinho
    this.limparCarrinho();

    // Mostra confirmação
    this.mostrarConfirmacao();
  }

  // Salva o pedido no histórico
  salvarPedido() {
    const pedidos = JSON.parse(localStorage.getItem("historicoPedidos")) || [];
    pedidos.push(this.pedido);
    localStorage.setItem("historicoPedidos", JSON.stringify(pedidos));
  }

  // Limpa o carrinho
  limparCarrinho() {
    localStorage.removeItem("carrinhoArtesanato");
    this.carrinho = [];
  }

  // Mostra modal de confirmação
  mostrarConfirmacao() {
    document.getElementById("numero-pedido").textContent = this.pedido.numero;

    const mensagem =
      this.pedido.cliente.pagamento.forma === "pix"
        ? "Você receberá um QR Code PIX para pagamento em seu e-mail."
        : this.pedido.cliente.pagamento.forma === "boleto"
        ? "O boleto será enviado para seu e-mail em até 5 minutos."
        : "Seu pagamento foi processado com sucesso!";

    document.getElementById("mensagem-confirmacao").textContent = mensagem;

    const modal = new bootstrap.Modal(
      document.getElementById("modalConfirmacao")
    );
    modal.show();
  }

  // Retorna os itens do carrinho
  getItensCarrinho() {
    return this.carrinho;
  }

  // Retorna o total do pedido
  getTotalPedido() {
    return this.carrinho.reduce(
      (sum, item) => sum + item.preco * item.quantidade,
      0
    );
  }
}

// Inicializa o sistema quando a página carrega
let finalizarCompra;

document.addEventListener("DOMContentLoaded", function () {
  finalizarCompra = new FinalizarCompra();

  // Atualiza forma de pagamento inicial
  const formaInicial = document.querySelector(
    'input[name="forma-pagamento"]:checked'
  ).value;
  finalizarCompra.atualizarFormaPagamento(formaInicial);
});

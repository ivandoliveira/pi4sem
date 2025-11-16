async function carregarPedido() {
  try {
    const user = JSON.parse(localStorage.getItem("user"));
    if (!user || !user.idCliente) throw new Error("Usuário não logado");

    const idCliente = user.idCliente;

    const response = await fetch(
      `http://localhost/ecommerce_api/api/pedido/consulta_pedido_usuario.php?idCliente=${idCliente}`
    );

    if (!response.ok) throw new Error("Erro ao buscar pedidos na API");

    const pedido = await response.json();

    const carrinhoItens = document.getElementById("pedido-itens");
    const tbody = document.getElementById("itens-pedido-tbody");

    tbody.innerHTML = "";

    carrinhoItens.style.display = "block";

    pedido.forEach(item => {

      const tr = document.createElement("tr");
      tr.innerHTML = `
        <td>${item.idPedido}</td>
        <td>${user.nomeCompletoCliente}</td>
        <td>${item.status}</td>
        <td>${item.dataPedido}</td>
        <td>${item.tipoPagamento}</td>
        <td></td>
      `;
      tbody.appendChild(tr);
    });

  } catch (err) {
    console.error(err);
  }
}


function mostrarPedido() {
    const modal = new bootstrap.Modal(document.getElementById("modalPedido"));
    modal.show();    
    carregarPedido(); 
}
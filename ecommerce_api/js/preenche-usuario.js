
document.addEventListener("DOMContentLoaded", () => {

    const usuarioLogado = JSON.parse(localStorage.getItem("user"));
    const historicoPedidos = JSON.parse(localStorage.getItem("historicoPedidos"));

    if (usuarioLogado) {

        document.getElementById("nome-completo").value =
            usuarioLogado.nomeCompletoCliente ?? "";

        document.getElementById("email").value =
            usuarioLogado.emailCliente ?? "";

        const telefone = usuarioLogado.celularCliente

        document.getElementById("telefone").value = telefone;
    }

});

function showNotification(title, message, isSuccess = true) {
    const modalElement = document.getElementById('modalNotificacao');
    const modalTitle = document.getElementById('notificacao-titulo');
    const modalBody = document.getElementById('notificacao-mensagem');

    modalTitle.textContent = title;
    modalBody.innerHTML = message;
    
    modalTitle.classList.remove('text-success', 'text-danger');
    if (isSuccess) {
        modalTitle.classList.add('text-success');
    } else {
        modalTitle.classList.add('text-danger');
    }

    const modal = new bootstrap.Modal(modalElement);
    modal.show();
}

document.addEventListener('DOMContentLoaded', () => {
    const formCadastro = document.getElementById('form-cadastro');
    const btnSubmit = formCadastro.querySelector('button[type="submit"]');
    const loadingSpinner = document.getElementById('cadastro-loading');

    const API_CADASTRO_URL = "http://localhost/ecommerce_api/api/cliente/create.php";
    
    formCadastro.addEventListener('submit', async function(event) {
        event.preventDefault();
        event.stopPropagation();
        
        const senha = document.getElementById('cadastro-senha').value;
        const confirmarSenha = document.getElementById('cadastro-confirmar-senha').value;

        if (senha !== confirmarSenha) {
            document.getElementById('cadastro-confirmar-senha').classList.add('is-invalid');
            document.getElementById('feedback-confirma-senha').textContent = "As senhas não coincidem.";
            formCadastro.classList.add('was-validated');
            return;
        } else {
            document.getElementById('cadastro-confirmar-senha').classList.remove('is-invalid');
            document.getElementById('cadastro-confirmar-senha').classList.add('is-valid');
        }

        if (!formCadastro.checkValidity()) {
            formCadastro.classList.add('was-validated');
            return;
        }

        const payload = {
            nome: document.getElementById('cadastro-nome').value,
            email: document.getElementById('cadastro-email').value,
            senha: senha,
            cpf: document.getElementById('cadastro-cpf').value,
            celular: document.getElementById('cadastro-telefone').value,
            dataNascimento: document.getElementById('cadastro-data').value,
        };
        
        btnSubmit.disabled = true;
        loadingSpinner.style.display = 'inline-block';

        try {
            const response = await fetch(API_CADASTRO_URL, {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                },
                body: JSON.stringify(payload),
            });

            const result = await response.json();

            if (response.ok && result.message === "Cliente criado com sucesso.") {
                showNotification('Sucesso!', 'Seu cadastro foi realizado com sucesso! Agora você pode fazer login.', true);
                setTimeout(() => {
                    window.location.href = 'login-e-cadastro.html'; 
                }, 3000); 
                
                formCadastro.reset();
                formCadastro.classList.remove('was-validated');
                
            } else if (result.message) {
                showNotification('Erro no Cadastro', result.message, false);
            } else {
                throw new Error("Resposta inesperada do servidor.");
            }

        } catch (error) {
            console.error('Erro na requisição de cadastro:', error);
            showNotification('Erro de Conexão', 'Não foi possível se conectar ao servidor da API. Verifique sua conexão e se o servidor local está ativo.', false);
        } finally {
            btnSubmit.disabled = false;
            loadingSpinner.style.display = 'none';
        }
    });

    formCadastro.addEventListener('input', (e) => {
        if (e.target.id === 'cadastro-confirmar-senha' || e.target.id === 'cadastro-senha') {
            const senha = document.getElementById('cadastro-senha').value;
            const confirmarSenha = document.getElementById('cadastro-confirmar-senha').value;

            if (senha === confirmarSenha) {
                document.getElementById('cadastro-confirmar-senha').classList.remove('is-invalid');
                document.getElementById('cadastro-confirmar-senha').classList.add('is-valid');
            } else if (confirmarSenha.length > 0) {
                document.getElementById('cadastro-confirmar-senha').classList.add('is-invalid');
                document.getElementById('cadastro-confirmar-senha').classList.remove('is-valid');
                document.getElementById('feedback-confirma-senha').textContent = "As senhas não coincidem.";
            }
        }
    });

});
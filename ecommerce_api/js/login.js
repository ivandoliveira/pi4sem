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

function checkLoginStatusAndMenu() {
    const user = localStorage.getItem('user');
    const menuLogado = document.getElementById('menu-logado');
    const menuDeslogado = document.getElementById('menu-deslogado');
    const userDisplayName = document.getElementById('user-display-name');

    if (user && menuLogado && menuDeslogado && userDisplayName) {
        const userData = JSON.parse(user);

        menuLogado.style.display = 'block'; 
        menuDeslogado.style.display = 'none';

        const nomeCurto = userData.nomeCompletoCliente.split(' ')[0];
        userDisplayName.textContent = nomeCurto;

    } else if (menuLogado && menuDeslogado) {
        
        menuLogado.style.display = 'none';
        menuDeslogado.style.display = 'block';
    }
}

function logoutUser() {
    localStorage.removeItem('user'); 
    checkLoginStatusAndMenu();     
    
    showNotification('Sessão Encerrada', 'Você foi desconectado com sucesso.', true);
}


document.addEventListener('DOMContentLoaded', () => {
    checkLoginStatusAndMenu();

    const formCadastro = document.getElementById('form-login');
    const btnSubmit = formCadastro.querySelector('button[type="submit"]');
    const loadingSpinner = document.getElementById('login-loading');

    const API_LOGIN_URL = "http://localhost/ecommerce_api/api/cliente/login.php";
    
    formCadastro.addEventListener('submit', async function(event) {
        event.preventDefault();
        event.stopPropagation();

        const payload = {
            email: document.getElementById('email').value,
            senha: document.getElementById('senha').value,
        };
        
        btnSubmit.disabled = true;
        loadingSpinner.style.display = 'inline-block';

        try {
            const response = await fetch(API_LOGIN_URL, {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                },
                body: JSON.stringify(payload),
            });

            const result = await response.json();

            if (response.ok && result.message === "Login realizado com sucesso.") {

                localStorage.setItem('user', JSON.stringify(result.cliente.cliente));
                
                checkLoginStatusAndMenu(); 

                showNotification('Login Sucesso', result.message, true);

                setTimeout(() => {
                    window.location.href = 'index.html'; 
                }, 1000); 
                
                formCadastro.reset();
                formCadastro.classList.remove('was-validated');
                
            } else if (result.message) {
                showNotification('Erro ao fazer login', result.message, false);
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
    
    const esqueciSenhaLink = document.getElementById('esqueci-senha');
    const modalEsqueciSenhaElement = document.getElementById('modalEsqueciSenha');
    
    esqueciSenhaLink.addEventListener('click', (e) => {
        e.preventDefault();
        const modalEsqueciSenha = new bootstrap.Modal(modalEsqueciSenhaElement);
        modalEsqueciSenha.show();
    });

});
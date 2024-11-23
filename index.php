<html>

<head>
    <base href="." />
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Free Prompts</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600&display=swap" rel="stylesheet">
    <style>
        :root {
            --bg-primary: #121212;
            --bg-secondary: #1e1e1e;
            --text-primary: #ffffff;
            --text-secondary: #b3b3b3;
            --accent: #7c3aed;
            --accent-hover: #6d28d9;
            --border: #2d2d2d;
        }

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Inter', sans-serif;
            background-color: var(--bg-primary);
            color: var(--text-primary);
            line-height: 1.5;
        }

        .container {
            max-width: 1200px;
            margin: 0 auto;
            padding: 0 1rem;
        }

        .header {
            padding: 1rem 0;
            border-bottom: 1px solid var(--border);
        }

        .header-content {
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .logo {
            font-size: 1.5rem;
            font-weight: 600;
            color: var(--text-primary);
            text-decoration: none;
        }

        .nav-links {
            display: flex;
            gap: 1.5rem;
        }

        .nav-link {
            color: var(--text-secondary);
            text-decoration: none;
            transition: color 0.2s;
        }

        .nav-link:hover {
            color: var(--text-primary);
        }

        .hero {
            padding: 4rem 0;
            text-align: center;
        }

        .search-container {
            max-width: 600px;
            margin: 2rem auto;
        }

        .search-input {
            width: 100%;
            padding: 1rem;
            font-size: 1rem;
            background: var(--bg-secondary);
            border: 1px solid var(--border);
            border-radius: 8px;
            color: var(--text-primary);
            transition: border-color 0.2s;
        }

        .search-input:focus {
            outline: none;
            border-color: var(--accent);
        }

        .filters {
            display: flex;
            gap: 1rem;
            margin: 2rem 0;
            flex-wrap: wrap;
            justify-content: center;
        }

        .filter-btn {
            padding: 0.5rem 1rem;
            background: var(--bg-secondary);
            border: 1px solid var(--border);
            border-radius: 20px;
            color: var(--text-secondary);
            cursor: pointer;
            transition: all 0.2s;
        }

        .filter-btn:hover,
        .filter-btn.active {
            background: var(--accent);
            color: var(--text-primary);
            border-color: var(--accent);
        }

        .prompts-grid {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(300px, 1fr));
            gap: 1.5rem;
            padding: 2rem 0;
        }

        .prompt-card {
            background: var(--bg-secondary);
            border: 1px solid var(--border);
            border-radius: 12px;
            padding: 1.5rem;
            transition: transform 0.2s;
            cursor: pointer;
        }

        .prompt-card:hover {
            transform: translateY(-2px);
        }

        .prompt-header {
            margin-bottom: 1rem;
        }

        .prompt-title {
            font-size: 1.25rem;
            margin-bottom: 0.5rem;
        }

        .prompt-category {
            display: inline-block;
            padding: 0.25rem 0.75rem;
            background: var(--accent);
            border-radius: 20px;
            font-size: 0.875rem;
        }

        .prompt-content {
            color: var(--text-secondary);
            margin-bottom: 1rem;
        }

        .prompt-footer {
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .copy-btn {
            padding: 0.5rem 1rem;
            background: transparent;
            border: 1px solid var(--accent);
            color: var(--accent);
            border-radius: 6px;
            cursor: pointer;
            transition: all 0.2s;
        }

        .copy-btn:hover {
            background: var(--accent);
            color: var(--text-primary);
        }

        .stats {
            display: flex;
            gap: 1rem;
            color: var(--text-secondary);
            font-size: 0.875rem;
        }

        @media (max-width: 768px) {
            .prompts-grid {
                grid-template-columns: 1fr;
            }

            .nav-links {
                display: none;
            }
        }

        .toast {
            position: fixed;
            bottom: 2rem;
            right: 2rem;
            background: var(--accent);
            color: var(--text-primary);
            padding: 1rem;
            border-radius: 6px;
            display: none;
            animation: slideIn 0.3s ease-out;
        }

        @keyframes slideIn {
            from {
                transform: translateX(100%);
                opacity: 0;
            }

            to {
                transform: translateX(0);
                opacity: 1;
            }
        }

        .modal-overlay {
            position: fixed;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background-color: rgba(0, 0, 0, 0.75);
            display: none;
            justify-content: center;
            align-items: center;
            z-index: 1000;
        }

        .modal {
            background: var(--bg-secondary);
            border-radius: 12px;
            padding: 2rem;
            width: 90%;
            max-width: 800px;
            position: relative;
            max-height: 90vh;
            overflow-y: auto;
        }

        .modal-close {
            position: absolute;
            top: 1rem;
            right: 1rem;
            background: transparent;
            border: none;
            color: var(--text-secondary);
            font-size: 1.5rem;
            cursor: pointer;
            padding: 0.5rem;
            transition: color 0.2s;
        }

        .modal-close:hover {
            color: var(--text-primary);
        }

        .modal-header {
            margin-bottom: 1.5rem;
        }

        .modal-title {
            font-size: 1.75rem;
            margin-bottom: 0.5rem;
        }

        .modal-category {
            display: inline-block;
            padding: 0.25rem 0.75rem;
            background: var(--accent);
            border-radius: 20px;
            font-size: 0.875rem;
            margin-bottom: 1rem;
        }

        .modal-content {
            color: var(--text-secondary);
            line-height: 1.6;
            margin-bottom: 1.5rem;
        }

        .modal-metadata {
            display: flex;
            gap: 1.5rem;
            color: var(--text-secondary);
            font-size: 0.875rem;
            margin-bottom: 1.5rem;
        }

        .modal-actions {
            display: flex;
            gap: 1rem;
            margin-top: 2rem;
        }

        .modal-btn {
            padding: 0.75rem 1.5rem;
            border-radius: 6px;
            cursor: pointer;
            transition: all 0.2s;
            font-size: 1rem;
        }

        .modal-btn-primary {
            background: var(--accent);
            color: var(--text-primary);
            border: none;
        }

        .modal-btn-primary:hover {
            background: var(--accent-hover);
        }

        .modal-btn-secondary {
            background: transparent;
            border: 1px solid var(--border);
            color: var(--text-secondary);
        }

        .modal-btn-secondary:hover {
            border-color: var(--text-primary);
            color: var(--text-primary);
        }

        .loading-spinner {
            display: inline-block;
            width: 2rem;
            height: 2rem;
            border: 3px solid var(--border);
            border-radius: 50%;
            border-top-color: var(--accent);
            animation: spin 1s linear infinite;
            margin: 2rem auto;
        }

        @keyframes spin {
            to {
                transform: rotate(360deg);
            }
        }
    </style>

    <script async src="https://www.googletagmanager.com/gtag/js?id=G-W2GSHHX65S"></script>
    <script>
        window.dataLayer = window.dataLayer || [];

        function gtag() {
            dataLayer.push(arguments);
        }
        gtag('js', new Date());

        gtag('config', 'G-W2GSHHX65S');
    </script>

    <style>
        /* Estilo geral para o SweetAlert2 */
        .swal2-popup {
            background-color: #333 !important;
            /* Fundo escuro */
            color: #fff !important;
            /* Texto claro */
            border-radius: 8px;
            /* Bordas arredondadas */
            font-family: Arial, sans-serif;
            /* Fonte mais suave */
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.2);
            /* Sombra suave */
        }

        /* Estilo para o cabeçalho */
        .swal2-header {
            border-bottom: 1px solid #444;
            /* Linha abaixo do cabeçalho */
            padding-bottom: 10px;
        }

        /* Estilo para o título */
        .swal2-title {
            font-size: 1.5em;
            color: #fff !important;
            /* Cor do título */
            margin: 0;
        }

        /* Estilo para o conteúdo (mensagem ou campos) */
        .swal2-content {
            padding: 15px 25px;
            font-size: 1em;
        }

        /* Estilo para os campos de input */
        .swal2-input {
            background-color: #444;
            color: #fff;
            border: 1px solid #555;
            border-radius: 5px;
            padding: 10px;
            margin-top: 10px;
            width: 100%;
        }

        /* Estilo para o textarea */
        .swal2-textarea {
            background-color: #444;
            color: #fff;
            border: 1px solid #555;
            border-radius: 5px;
            padding: 10px;
            width: 100%;
            height: 120px;
            margin-top: 10px;
        }

        /* Estilo para os botões (confirmação e cancelamento) */
        .swal2-confirm,
        .swal2-cancel {
            background-color: #555;
            color: #fff;
            border: 1px solid #444;
            border-radius: 5px;
            padding: 10px 20px;
            font-size: 1em;
        }

        /* Estilo para o botão de confirmação quando pressionado */
        .swal2-confirm:hover {
            background-color: #666;
            border-color: #444;
        }

        /* Estilo para o botão de cancelamento quando pressionado */
        .swal2-cancel:hover {
            background-color: #444;
            border-color: #333;
        }
    </style>

</head>

<body>
    <header class="header">
        <div class="container header-content">
            <a href="/" class="logo">FreePrompts</a>
            <nav class="nav-links">
                <a href="#" class="nav-link" id="addPromptBtn">Enviar Prompt</a>
            </nav>
        </div>
    </header>

    <!-- Incluindo o SweetAlert2 -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <script>
        document.getElementById('addPromptBtn').addEventListener('click', function() {
            // Exibir o popup SweetAlert2 com tema dark
            Swal.fire({
                title: 'Adicionar Novo Prompt',
                html: `
                <input type="text" id="promptTitle" class="swal2-input" placeholder="Título do Prompt">
                <textarea id="promptContent" class="swal2-textarea" placeholder="Conteúdo do Prompt"></textarea>
                <input type="text" id="promptCategory" class="swal2-input" placeholder="Categoria">
            `,
                focusConfirm: false,
                customClass: {
                    popup: 'swal2-dark-popup',
                    header: 'swal2-dark-header',
                    title: 'swal2-dark-title',
                    content: 'swal2-dark-content',
                    input: 'swal2-dark-input',
                    textarea: 'swal2-dark-textarea'
                },
                background: '#333', // Fundo escuro
                color: '#fff', // Texto claro
                preConfirm: () => {
                    const title = document.getElementById('promptTitle').value;
                    const content = document.getElementById('promptContent').value;
                    const category = document.getElementById('promptCategory').value;

                    // Verificando se todos os campos foram preenchidos
                    if (!title || !content || !category) {
                        Swal.showValidationMessage('Por favor, preencha todos os campos!');
                        return false;
                    }

                    // Enviar os dados para o backend via AJAX
                    $.ajax({
                        url: 'save-prompt.php', // Caminho para o backend PHP
                        method: 'POST',
                        data: {
                            action: 'add', // Ação para indicar que é um novo prompt
                            title: title,
                            content: content,
                            category: category
                        },
                        dataType: "json"

                    }).done(function(response) {
                        console.log(response)
                        if (response.success) {
                            Swal.fire('Prompt Adicionado!', '', 'success');
                        } else {
                            Swal.fire('Erro ao adicionar prompt', response.message, 'error');
                        }
                    }).fail(function(a, b, c) {
                        console.log(a, b, c)
                        Swal.fire('Erro!', 'Ocorreu um erro ao enviar o prompt.', 'error');
                    })
                }
            });
        });
    </script>

    <main>
        <section class="hero">
            <div class="container">
                <h1>Encontre os melhores prompts gratuitos</h1>
                <div class="search-container">
                    <input type="text" class="search-input" placeholder="Busque por prompts, categorias ou palavras-chave...">
                </div>
                <div class="filters">
                    <button class="filter-btn active" data-filter="all">Todos</button>
                    <button class="filter-btn" data-filter="creative">Criativos</button>
                    <button class="filter-btn" data-filter="technical">Técnicos</button>
                    <button class="filter-btn" data-filter="business">Negócios</button>
                    <button class="filter-btn" data-filter="academic">Acadêmicos</button>
                </div>
            </div>
        </section>

        <section class="container">
            <div class="prompts-grid" id="promptsGrid"></div>
        </section>
    </main>

    <div class="modal-overlay" id="modalOverlay">
        <div class="modal">
            <div class="loading-spinner"></div>
        </div>
    </div>

    <div class="toast" id="toast">Prompt copiado com sucesso!</div>
    <script src="https://code.jquery.com/jquery-3.7.1.js" integrity="sha256-eKhayi8LEQwp4NKxN+CfCh+3qOVUtJn3QNZ0TciWLP4=" crossorigin="anonymous"></script>
    <script>
        // Função para buscar prompts no backend usando AJAX
        function fetchPrompts() {
            return new Promise((resolve, reject) => {
                $.ajax({
                    url: 'backend.php', // Caminho para o backend PHP
                    method: 'GET', // Ou 'POST' se necessário
                    dataType: 'json', // Espera-se uma resposta JSON

                }).done(function(data) {
                    console.log(data); // Adicionando log para inspeção da resposta
                    resolve(data); // Resolve a promise com os dados recebidos
                }).fail(function(a, b, c) {
                    console.error(a, b, c);
                    // alert('Houve um erro ao buscar os prompts.');
                    reject([]); // Rejeita a promise com um array vazio em caso de erro
                })
            });
        }



        // Função para buscar os detalhes do prompt específico
        async function fetchPromptDetails(id) {
            try {
                const response = await fetch(`get-prompt.php?id=${id}`);
                if (!response.ok) {
                    throw new Error('Erro ao buscar os detalhes do prompt');
                }
                const prompt = await response.json();
                return prompt;
            } catch (error) {
                console.error(error);
                alert('Houve um erro ao carregar os detalhes do prompt.');
                return null;
            }
        }

        // Atualiza o modal com os detalhes do prompt
        function updateModal(promptData) {
            const modal = document.querySelector('.modal');
            const modalContent = `
            <button class="modal-close" id="modalClose">×</button>
            <div class="modal-header">
                <h2 class="modal-title">${promptData.title}</h2>
                <span class="modal-category">${promptData.category}</span>
            </div>
            <div class="modal-metadata">
                <span class="modal-date">📅 ${new Date(promptData.dateCreated).toLocaleDateString()}</span>
            </div>
            <div class="modal-content">${promptData.content}</div>
            <div class="modal-actions">
                <button class="modal-btn modal-btn-primary" id="modalCopy">Copiar Prompt</button>
            </div>
        `;

            modal.innerHTML = modalContent;

            // Ações do modal
            document.getElementById('modalClose').addEventListener('click', hideModal);
            document.getElementById('modalCopy').addEventListener('click', async () => {
                const content = document.querySelector('.modal-content').textContent;
                try {
                    await navigator.clipboard.writeText(content);
                    showToast();
                } catch (err) {
                    console.error('Erro ao copiar:', err);
                }
            });
        }

        // Mostrar o modal
        function showModal() {
            document.getElementById('modalOverlay').style.display = 'flex';
            document.body.style.overflow = 'hidden';
        }

        // Esconder o modal
        function hideModal() {
            document.getElementById('modalOverlay').style.display = 'none';
            document.body.style.overflow = 'auto';
        }

        // Função para criar o card do prompt
        function createPromptCard(prompt) {
            return `
            <article class="prompt-card" data-prompt-id="${prompt.id}">
                <header class="prompt-header">
                    <h2 class="prompt-title">${prompt.title}</h2>
                    <span class="prompt-category">${prompt.category}</span>
                </header>
                <div class="prompt-content">
                    ${prompt.content}
                </div>
                <footer class="prompt-footer">
                    <button class="copy-btn" data-prompt-id="${prompt.id}">
                        Copiar Prompt
                    </button>
                </footer>
            </article>
        `;
        }
        /*   
        <div class="stats">
                      
                    <span>👍 ${prompt.votes}</span>
                                <span>📋 ${prompt.copies}</span>
                                </div>
                                */


        // Função para mostrar o toast
        function showToast() {
            const toast = document.getElementById('toast');
            toast.style.display = 'block';
            setTimeout(() => toast.style.display = 'none', 3000);
        }

        // Inicialização
        document.addEventListener('DOMContentLoaded', async () => {
            const grid = document.getElementById('promptsGrid');
            const searchInput = document.querySelector('.search-input');
            const filterButtons = document.querySelectorAll('.filter-btn');

            // Buscar os prompts do servidor
            const promptsData = await fetchPrompts();

            filteredPrompts = promptsData;

            // Exibir a primeira página de prompts
            displayPrompts(filteredPrompts);

            // Modificação no filtro
            filterButtons.forEach(button => {
                button.addEventListener('click', () => {
                    const filter = button.dataset.filter;
                    filterButtons.forEach(btn => btn.classList.remove('active'));
                    button.classList.add('active');

                    currentPage = 1;
                    filteredPrompts = filter === 'all' ?
                        promptsData :
                        promptsData.filter(p => p.category === filter);

                    displayPrompts(filteredPrompts);
                });
            });

            // Modificação na busca
            searchInput.addEventListener('input', (e) => {
                const searchTerm = e.target.value.toLowerCase();
                currentPage = 1;

                filteredPrompts = promptsData.filter(prompt =>
                    prompt.title.toLowerCase().includes(searchTerm) ||
                    prompt.content.toLowerCase().includes(searchTerm) ||
                    prompt.category.toLowerCase().includes(searchTerm)
                );

                displayPrompts(filteredPrompts);
            });

            // Exibir os prompts na grid
            promptsData.forEach(prompt => {
                grid.innerHTML += createPromptCard(prompt);
            });

         

        

            // Lidar com o clique nos cards de prompt
            grid.addEventListener('click', async (e) => {
                if (e.target.classList.contains('copy-btn')) {
                    const promptId = e.target.dataset.promptId;
                    const prompt = promptsData.find(p => p.id === parseInt(promptId));
                    navigator.clipboard.writeText(prompt.content)
                        .then(() => {
                            showToast();
                        })
                        .catch(err => {
                            console.error('Erro ao copiar:', err);
                        });
                } else {
                    const card = e.target.closest('.prompt-card');
                    if (card) {
                        const promptId = parseInt(card.dataset.promptId);
                        showModal();
                        const modal = document.querySelector('.modal');
                        modal.innerHTML = '<div class="loading-spinner"></div>';

                        // Buscar os detalhes do prompt
                        const promptData = await fetchPromptDetails(promptId);
                        if (promptData) {
                            updateModal(promptData);
                        } else {
                            modal.innerHTML = '<p>Erro ao carregar os detalhes do prompt: Prompt não encontrado</p>';
                        }
                    }
                }
            });

            // Fechar o modal ao clicar fora
            document.getElementById('modalOverlay').addEventListener('click', (e) => {
                if (e.target === e.currentTarget) hideModal();
            });

            // Fechar o modal ao pressionar ESC
            document.addEventListener('keydown', (e) => {
                if (e.key === 'Escape') hideModal();
            });
        });
    </script>

    <script>
        // Configuração da paginação
        const ITEMS_PER_PAGE = 6;
        let currentPage = 1;
        let filteredPrompts = [];

        // Função para exibir os prompts com paginação
        function displayPrompts(prompts, page = 1) {
            const grid = document.getElementById('promptsGrid');
            const startIndex = (page - 1) * ITEMS_PER_PAGE;
            const endIndex = startIndex + ITEMS_PER_PAGE;
            const promptsToShow = prompts.slice(startIndex, endIndex);

            // Se for a primeira página, limpa o grid
            if (page === 1) {
                grid.innerHTML = '';
            }

            // Adiciona os novos prompts
            promptsToShow.forEach(prompt => {
                grid.innerHTML += createPromptCard(prompt);
            });

            // Gerencia o botão "Ver mais"
            updateLoadMoreButton(prompts.length, endIndex);
        }

        // Função para atualizar o botão "Ver mais"
        function updateLoadMoreButton(totalItems, currentlyShowing) {
            let loadMoreBtn = document.getElementById('loadMoreBtn');

            // Se o botão não existe, cria ele
            if (!loadMoreBtn) {
                loadMoreBtn = document.createElement('button');
                loadMoreBtn.id = 'loadMoreBtn';
                loadMoreBtn.className = 'modal-btn modal-btn-primary';
                loadMoreBtn.style.margin = '2rem auto';
                loadMoreBtn.style.display = 'block';
                document.querySelector('.prompts-grid').after(loadMoreBtn);

                // Adiciona o evento de clique
                loadMoreBtn.addEventListener('click', () => {
                    currentPage++;
                    displayPrompts(filteredPrompts, currentPage);
                });
            }

            // Atualiza a visibilidade e texto do botão
            if (currentlyShowing < totalItems) {
                loadMoreBtn.style.display = 'block';
                loadMoreBtn.textContent = `Ver mais (${currentlyShowing}/${totalItems})`;
            } else {
                loadMoreBtn.style.display = 'none';
            }
        }
    </script>

</body>

</html>
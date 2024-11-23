// Variáveis globais
let allPrompts = [];
let filteredPrompts = [];
let currentIndex = 0;
const promptsPerPage = 12;
let offcanvas;
let currentSearchTerm = '';

function fetchPrompts() {
    fetch('https://crom.live/app-api/webhook/search-prompt')
        .then(response => response.json())
        .then(data => {
            allPrompts = data.data;
            filteredPrompts = allPrompts;
            currentIndex = 0;
            displayPrompts();
        })
        .catch(error => {
            console.error("Erro ao buscar os prompts:", error);
        });
}

function displayPrompts() {
    const promptGrid = document.getElementById('promptGrid');
    const noResultsMessage = document.getElementById('noResultsMessage');

    if (filteredPrompts.length === 0) {
        promptGrid.innerHTML = '';
        noResultsMessage.style.display = 'block';
        return;
    }

    noResultsMessage.style.display = 'none';
    const endIndex = Math.min(currentIndex + promptsPerPage, filteredPrompts.length);
    const promptsToDisplay = filteredPrompts.slice(currentIndex, endIndex);

    promptsToDisplay.forEach((prompt) => {
        const card = document.createElement('div');
        card.className = 'prompt-card';

        const highlightedAct = highlightText(prompt.act, currentSearchTerm);
        const highlightedPrompt = highlightText(prompt.prompt.substring(0, 100), currentSearchTerm);

        card.innerHTML = `
              <h3>${highlightedAct}</h3>
              <p>${highlightedPrompt}...</p>
              <div class="card-actions">
                  <button class="btn copy-btn" title="Copiar prompt"><i class="fas fa-copy"></i></button>
                  <button class="btn options-btn" title="Mais opções"><i class="fas fa-ellipsis-v"></i></button>
              </div>
          `;

        card.addEventListener('click', () => showFullPrompt(prompt));

        const copyBtn = card.querySelector('.copy-btn');
        copyBtn.addEventListener('click', (e) => {
            e.stopPropagation();
            navigator.clipboard.writeText(prompt.prompt);
            showToast('Prompt copiado para a área de transferência!');
        });

        promptGrid.appendChild(card);
    });

    updateLoadMoreButtonVisibility();
}

function highlightText(text, searchTerm) {
    if (!searchTerm) return text;
    const regex = new RegExp(`(${searchTerm})`, 'gi');
    return text.replace(regex, '<span class="highlight">$1</span>');
}

function filterPrompts(searchTerm) {
    currentIndex = 0;
    currentSearchTerm = searchTerm.trim().toLowerCase();
    if (currentSearchTerm === '') {
        filteredPrompts = allPrompts;
    } else {
        filteredPrompts = allPrompts.filter(prompt =>
            prompt.act.toLowerCase().includes(currentSearchTerm)
            // ||
            // prompt.prompt.toLowerCase().includes(currentSearchTerm)
        );
    }
    const promptGrid = document.getElementById('promptGrid');
    promptGrid.innerHTML = ''; // Limpa o grid antes de adicionar novos itens
    displayPrompts();
}

function updateLoadMoreButtonVisibility() {
    const loadMoreBtn = document.getElementById('loadMoreBtn');
    if (currentIndex + promptsPerPage >= filteredPrompts.length) {
        loadMoreBtn.style.display = 'none';
    } else {
        loadMoreBtn.style.display = 'block';
    }
}

function showFullPrompt(prompt) {
    const offcanvasTitle = document.getElementById('promptOffcanvasLabel');
    const offcanvasBody = document.getElementById('fullPromptContent');
    const offcanvasElement = document.getElementById('promptOffcanvas'); // Obtém o elemento offcanvas

    // Aplicar classes de tema dark no offcanvas
    offcanvasElement.classList.add('bg-dark', 'text-white'); // Fundo escuro e texto branco
    offcanvasTitle.classList.add('text-light'); // Título com texto claro
    offcanvasBody.classList.add('text-light'); // Texto do corpo claro

    // Atualizar o conteúdo
    offcanvasTitle.textContent = prompt.act;
    offcanvasBody.textContent = prompt.prompt;

    // Mostrar o offcanvas
    offcanvas.show();
}


function showToast(message) {
    // Implementação simplificada de um toast
    const toast = document.createElement('div');
    toast.textContent = message;
    toast.style.position = 'fixed';
    toast.style.bottom = '20px';
    toast.style.left = '50%';
    toast.style.transform = 'translateX(-50%)';
    toast.style.backgroundColor = 'rgba(0, 0, 0, 0.7)';
    toast.style.color = 'white';
    toast.style.padding = '10px 20px';
    toast.style.borderRadius = '5px';
    toast.style.zIndex = '1000';

    document.body.appendChild(toast);

    setTimeout(() => {
        toast.remove();
    }, 3000);
}

document.addEventListener('DOMContentLoaded', () => {
    offcanvas = new bootstrap.Offcanvas(document.getElementById('promptOffcanvas'));

    document.getElementById('searchInput').addEventListener('input', (event) => {
        filterPrompts(event.target.value);
    });

    document.getElementById('searchButton').addEventListener('click', () => {
        filterPrompts(document.getElementById('searchInput').value);
    });

    document.getElementById('translateBtn').addEventListener('click', function () {
        var url = "https://translate.google.com/translate?hl=en&sl=pt&tl=en&u=" + encodeURIComponent(window.location.href);
        window.open(url, '_blank');
    });

    document.getElementById('addPromptBtn').addEventListener('click', () => {
        // Abre um SweetAlert para o usuário preencher as informações
        Swal.fire({
            title: 'Adicionar Novo Prompt',
            background: '#343a40',  // Fundo escuro
            color: '#ffffff',  // Texto branco
            html: `
                <input type="text" id="swal-title" class="swal2-input" placeholder="Título do Prompt" style="background-color: #495057; color: #ffffff;">
                <textarea id="swal-prompt" class="swal2-textarea" placeholder="Conteúdo do Prompt" style="background-color: #495057; color: #ffffff;"></textarea>
            `,
            confirmButtonText: 'Enviar',
            confirmButtonColor: '#0d6efd', // Botão azul claro
            focusConfirm: false,
            preConfirm: () => {
                const title = document.getElementById('swal-title').value;
                const prompt = document.getElementById('swal-prompt').value;

                if (!title || !prompt) {
                    Swal.showValidationMessage('Por favor, preencha todos os campos');
                }

                return {
                    title: title,
                    prompt: prompt
                };
            }
        }).then((result) => {
            if (result.isConfirmed) {
                const { title, prompt } = result.value;

                // Mostrar indicador de carregamento
                Swal.fire({
                    title: 'Enviando...',
                    html: 'Por favor, aguarde enquanto enviamos o seu prompt.',
                    allowOutsideClick: false,
                    background: '#343a40', // Fundo escuro durante o envio
                    color: '#ffffff',
                    didOpen: () => {
                        Swal.showLoading();
                    }
                });

                // Construir a URL com os parâmetros title e prompt
                const url = `https://crom.live/app-api/webhook/search-prompt/create-prompt?title=${encodeURIComponent(title)}&prompt=${encodeURIComponent(prompt)}`;

                // Enviar o prompt via GET
                fetch(url, {
                    method: 'GET'
                })
                    .then(response => response.json())
                    .then(data => {
                        if (data.success) {
                            // Mostrar mensagem de sucesso
                            Swal.fire({
                                icon: 'success',
                                title: 'Prompt enviado!',
                                text: 'O novo prompt foi adicionado com sucesso.',
                                background: '#343a40', // Fundo escuro para manter a consistência
                                color: '#ffffff',
                                confirmButtonColor: '#0d6efd' // Cor do botão de confirmação
                            });
                        } else {
                            // Mostrar mensagem de erro
                            Swal.fire({
                                icon: 'error',
                                title: 'Erro',
                                text: 'Não foi possível adicionar o prompt. Tente novamente mais tarde.',
                                background: '#343a40',
                                color: '#ffffff',
                                confirmButtonColor: '#d33' // Cor vermelha para erro
                            });
                        }
                    })
                    .catch(error => {
                        // Mostrar mensagem de erro
                        Swal.fire({
                            icon: 'error',
                            title: 'Erro',
                            text: 'Ocorreu um erro ao enviar o prompt. Verifique sua conexão ou tente novamente.',
                            background: '#343a40',
                            color: '#ffffff',
                            confirmButtonColor: '#d33'
                        });
                        console.error('Erro ao enviar o prompt:', error);
                    });
            }
        });

    });

    document.getElementById('copyFullPromptBtn').addEventListener('click', () => {
        const fullPromptContent = document.getElementById('fullPromptContent').textContent;
        navigator.clipboard.writeText(fullPromptContent);
        showToast('Prompt completo copiado para a área de transferência!');
    });

    document.getElementById('loadMoreBtn').addEventListener('click', () => {
        currentIndex += promptsPerPage;
        displayPrompts();
    });

    fetchPrompts();
});
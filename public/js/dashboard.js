// Função para editar produto completo
function editProduct(productId) {
    const fields = ['name', 'description', 'price', 'quantity'];

    // Alternar entre modo de visualização e edição para todos os campos
    fields.forEach(field => {
        const displayElement = document.querySelector(`.field-display-${productId}-${field}`);
        const editElement = document.querySelector(`.field-edit-${productId}-${field}`);

        if (displayElement) displayElement.style.display = 'none';
        if (editElement) editElement.style.display = 'block';
    });

    // Alternar botões
    document.querySelector(`.action-buttons-${productId}`).style.display = 'none';
    document.querySelector(`.edit-buttons-${productId}`).style.display = 'block';

    // Focar no primeiro campo (nome)
    document.querySelector(`#name-${productId}`).focus();
}

// Função para cancelar edição
function cancelEdit(productId) {
    const fields = ['name', 'description', 'price', 'quantity'];

    // Voltar ao modo de visualização para todos os campos
    fields.forEach(field => {
        const displayElement = document.querySelector(`.field-display-${productId}-${field}`);
        const editElement = document.querySelector(`.field-edit-${productId}-${field}`);

        if (displayElement) displayElement.style.display = 'block';
        if (editElement) editElement.style.display = 'none';
    });

    // Alternar botões
    document.querySelector(`.action-buttons-${productId}`).style.display = 'block';
    document.querySelector(`.edit-buttons-${productId}`).style.display = 'none';

    // Restaurar valores originais nos inputs
    restoreOriginalValues(productId);
}

// Função para restaurar valores originais
function restoreOriginalValues(productId) {
    // Obter valores originais dos elementos de display
    const originalName = document.querySelector(`.field-display-${productId}-name strong`).textContent;
    const originalDescription = document.querySelector(`.field-display-${productId}-description span`).textContent.replace('Sem descrição', '');
    const originalPrice = document.querySelector(`.field-display-${productId}-price .price-badge`).textContent.replace('R$ ', '').replace('.', '').replace(',', '.');
    const originalQuantity = document.querySelector(`.field-display-${productId}-quantity .badge`).textContent.replace(' unidades', '');

    // Restaurar nos inputs
    document.querySelector(`#name-${productId}`).value = originalName;
    document.querySelector(`#description-${productId}`).value = originalDescription.trim();
    document.querySelector(`#price-${productId}`).value = parseFloat(originalPrice);
    document.querySelector(`#quantity-${productId}`).value = parseInt(originalQuantity);
}

// Função para salvar produto completo
function saveProduct(productId) {
    // Obter novos valores
    const newName = document.querySelector(`#name-${productId}`).value.trim();
    const newDescription = document.querySelector(`#description-${productId}`).value.trim();
    const newPrice = parseFloat(document.querySelector(`#price-${productId}`).value);
    const newQuantity = parseInt(document.querySelector(`#quantity-${productId}`).value);

    // Validações básicas
    if (!newName) {
        alert('O nome do produto é obrigatório.');
        document.querySelector(`#name-${productId}`).focus();
        return;
    }

    if (newPrice < 0) {
        alert('O preço deve ser um valor positivo.');
        document.querySelector(`#price-${productId}`).focus();
        return;
    }

    if (newQuantity < 0) {
        alert('A quantidade deve ser um valor positivo.');
        document.querySelector(`#quantity-${productId}`).focus();
        return;
    }

    fetch(`/api/products/${productId}`, {
        method: 'PUT',
        headers: {
            'Content-Type': 'application/json'
        },
        body: JSON.stringify({
            name: newName,
            description: newDescription,
            price: newPrice,
            quantity: newQuantity
        })
    })
    .then(response => {
        if (!response.ok) {
            throw new Error('Erro ao salvar produto');
        }
        return response.json();
    })
    .then(data => {
        updateProductDisplay(productId, {
            name: newName,
            description: newDescription || 'Sem descrição',
            price: newPrice,
            quantity: newQuantity
        });

        alert('Produto salvo com sucesso!');
    })
    .catch(error => {
        console.error('Erro:', error);
        alert('Ocorreu um erro ao salvar o produto. Tente novamente.');
    });

    // Voltar ao modo de visualização
    cancelEdit(productId);

    // Feedback visual
    showSuccessMessage(productId);
}

// Função para atualizar a exibição do produto
function updateProductDisplay(productId, data) {
    // Atualizar nome
    document.querySelector(`.field-display-${productId}-name strong`).textContent = data.name;

    // Atualizar descrição
    const descriptionElement = document.querySelector(`.field-display-${productId}-description span`);
    descriptionElement.textContent = data.description.length > 50 ? data.description.substring(0, 50) + '...' : data.description;

    // Atualizar preço
    const priceElement = document.querySelector(`.field-display-${productId}-price .price-badge`);
    priceElement.textContent = `R$ ${data.price.toLocaleString('pt-BR', { minimumFractionDigits: 2, maximumFractionDigits: 2 })}`;

    // Atualizar quantidade
    const quantityBadge = document.querySelector(`.field-display-${productId}-quantity .badge`);
    quantityBadge.textContent = `${data.quantity} unidades`;
    quantityBadge.className = `badge ${data.quantity <= 5 ? 'bg-danger' : 'bg-success'} fs-6`;
}

// Função para mostrar mensagem de sucesso
function showSuccessMessage(productId) {
    const row = document.querySelector(`#quantity-${productId}`).closest('tr');
    const originalBg = row.style.backgroundColor;

    row.style.backgroundColor = '#d4edda';
    row.style.transition = 'background-color 0.3s ease';

    setTimeout(() => {
        row.style.backgroundColor = originalBg;
    }, 2000);
}

// Listener para o botão de sincronização
document.getElementById('syncApiBtn').addEventListener('click', function () {
    const button = this;
    
    // Feedback visual durante sincronização
    button.innerHTML = '<i class="bi bi-arrow-repeat spinner-border spinner-border-sm me-2"></i>Sincronizando...';
    button.disabled = true;

    // Fazer requisição para sincronizar
    fetch('/api/products/sync', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
        }
    })
    .then(response => response.json())
    .then(data => {
        if (data.products.length > 0) {
            // Mostrar mensagem de sucesso
            showSyncSuccessMessage(data.products);
            
            // Recarregar a página para mostrar produtos atualizados
            setTimeout(() => {
                window.location.reload();
            }, 2000);
        } else {
            throw new Error(data.message);
        }
    })
    .catch(error => {
        console.error('Erro ao sincronizar produtos:', error);
        showSyncErrorMessage(error.message);
    })
    .finally(() => {
        // Restaurar botão
        button.innerHTML = '<i class="bi bi-arrow-repeat me-2"></i>Sincronizar com API';
        button.disabled = false;
    });
});

// Função para mostrar mensagem de sucesso da sincronização
function showSyncSuccessMessage(products) {
    const alertDiv = document.createElement('div');
    alertDiv.className = 'alert alert-success alert-dismissible fade show mt-3';
    alertDiv.innerHTML = `
        <i class="bi bi-check-circle me-2"></i>
        <strong>Sincronização concluída!</strong><br>
        <small>
            ${products.length} produtos adicionados ou atualizados
        </small>
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    `;

    document.querySelector('.sync-section').appendChild(alertDiv);

    setTimeout(() => {
        if (alertDiv.parentElement) {
            alertDiv.remove();
        }
    }, 5000);
}

// Função para mostrar mensagem de erro da sincronização
function showSyncErrorMessage(message) {
    const alertDiv = document.createElement('div');
    alertDiv.className = 'alert alert-danger alert-dismissible fade show mt-3';
    alertDiv.innerHTML = `
        <i class="bi bi-exclamation-triangle me-2"></i>
        <strong>Erro na sincronização:</strong> ${message}
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    `;

    document.querySelector('.sync-section').appendChild(alertDiv);

    setTimeout(() => {
        if (alertDiv.parentElement) {
            alertDiv.remove();
        }
    }, 5000);
}

// Permitir salvar com Enter em qualquer campo
document.addEventListener('keydown', function (event) {
    if (event.key === 'Enter') {
        const target = event.target;

        // Se está em um campo de edição, salvar o produto
        if (target.id && (target.id.includes('name-') || target.id.includes('description-') ||
            target.id.includes('price-') || target.id.includes('quantity-'))) {

            const productId = target.id.split('-')[1];
            saveProduct(productId);
        }
    }

    // Permitir cancelar com Escape
    if (event.key === 'Escape') {
        const target = event.target;

        if (target.id && (target.id.includes('name-') || target.id.includes('description-') ||
            target.id.includes('price-') || target.id.includes('quantity-'))) {

            const productId = target.id.split('-')[1];
            cancelEdit(productId);
        }
    }
});

// Formatação automática do preço
document.addEventListener('input', function (event) {
    const target = event.target;

    if (target.id && target.id.includes('price-')) {
        // Garantir que o valor seja positivo
        if (parseFloat(target.value) < 0) {
            target.value = 0;
        }
    }
});
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Inventory - Produtos</title>
    
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
    
    <!-- Bootstrap Icons -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css" rel="stylesheet">

    <link rel="stylesheet" href="{{ asset('css/dashboard.css') }}">

    <script src="{{ asset('js/app.js') }}"></script>
</head>
<body>
    <!-- Navbar -->
    <nav class="navbar navbar-expand-lg navbar-dark navbar-custom">
        <div class="container">
            <a class="navbar-brand fw-bold" href="#">
                <i class="bi bi-box-seam me-2"></i>
                Inventory System
            </a>
            <div class="navbar-nav ms-auto">
                <form method="POST" action="/logout" class="d-inline">
                    @csrf
                    <button type="submit" class="btn btn-outline-light">
                        <i class="bi bi-box-arrow-right me-1"></i>
                        Sair
                    </button>
                </form>
            </div>
        </div>
    </nav>

    <div class="container py-4">
        <!-- Seção de Sincronização com API -->
        <div class="sync-section">
            <div class="row align-items-center">
                <div class="col-md-8">
                    <h4 class="mb-2">
                        <i class="bi bi-cloud-download text-primary me-2"></i>
                        Sincronização com Fake Store API
                    </h4>
                    <p class="text-muted mb-0">
                        Clique no botão para buscar produtos da API externa, adicionar novos produtos e remover os que não existem mais.
                    </p>
                </div>
                <div class="col-md-4 text-md-end mt-3 mt-md-0">
                    <button type="button" class="btn btn-primary-custom btn-lg" id="syncApiBtn">
                        <i class="bi bi-arrow-repeat me-2"></i>
                        Sincronizar com API
                    </button>
                </div>
            </div>
        </div>

        <!-- Cabeçalho da Página -->
        <div class="card shadow-sm mb-4">
            <div class="card-header card-header-custom">
                <div class="row align-items-center">
                    <div class="col">
                        <h3 class="mb-0">
                            <i class="bi bi-grid me-2"></i>
                            Lista de Produtos
                        </h3>
                    </div>
                    <div class="col-auto">
                        <span class="badge bg-light text-dark fs-6">
                            Total: {{ count($products) }} produtos
                        </span>
                    </div>
                </div>
            </div>
        </div>

        <!-- Filtros -->
        <div class="card shadow-sm mb-4">
            <div class="card-body">
                <form method="GET" action="{{ route('dashboard') }}" class="row g-3">
                    <div class="col-md-3">
                        <label for="nameFilter" class="form-label">
                            <i class="bi bi-search me-1"></i>
                            Filtrar por Nome
                        </label>
                        <input type="text" 
                               class="form-control" 
                               id="nameFilter" 
                               name="nameFilter" 
                               value="{{ request('nameFilter') }}"
                               placeholder="Nome do produto...">
                    </div>
                    <div class="col-md-3">
                        <label for="descriptionFilter" class="form-label">
                            <i class="bi bi-file-text me-1"></i>
                            Filtrar por Descrição
                        </label>
                        <input type="text" 
                               class="form-control" 
                               id="descriptionFilter" 
                               name="descriptionFilter" 
                               value="{{ request('descriptionFilter') }}"
                               placeholder="Descrição...">
                    </div>
                    <div class="col-md-3">
                        <label for="priceOrderFilter" class="form-label">
                            <i class="bi bi-sort-numeric-down me-1"></i>
                            Ordenar por Preço
                        </label>
                        <select class="form-select" id="priceOrderFilter" name="priceOrderFilter">
                            <option value="">Sem ordenação</option>
                            <option value="asc" {{ request('priceOrderFilter') === 'asc' ? 'selected' : '' }}>
                                Menor para Maior
                            </option>
                            <option value="desc" {{ request('priceOrderFilter') === 'desc' ? 'selected' : '' }}>
                                Maior para Menor
                            </option>
                        </select>
                    </div>
                    <div class="col-md-3 d-flex align-items-end">
                        <div class="w-100">
                            <button type="submit" class="btn btn-primary-custom me-2">
                                <i class="bi bi-funnel me-1"></i>
                                Filtrar
                            </button>
                            <a href="{{ route('dashboard') }}" class="btn btn-outline-secondary">
                                <i class="bi bi-x-circle me-1"></i>
                                Limpar
                            </a>
                        </div>
                    </div>
                </form>
            </div>
        </div>

        <!-- Tabela de Produtos -->
        @if(count($products) > 0)
            <div class="card shadow-sm">
                <div class="card-body p-0">
                    <div class="table-responsive">
                        <table class="table table-hover mb-0">
                            <thead class="table-light">
                                <tr>
                                    <th scope="col">
                                        <i class="bi bi-hash me-1"></i>
                                        ID
                                    </th>
                                    <th scope="col">
                                        <i class="bi bi-tag me-1"></i>
                                        Nome
                                    </th>
                                    <th scope="col">
                                        <i class="bi bi-file-text me-1"></i>
                                        Descrição
                                    </th>
                                    <th scope="col">
                                        <i class="bi bi-currency-dollar me-1"></i>
                                        Preço
                                    </th>
                                    <th scope="col">
                                        <i class="bi bi-boxes me-1"></i>
                                        Estoque
                                    </th>
                                    <th scope="col" width="180">
                                        <i class="bi bi-gear me-1"></i>
                                        Ações
                                    </th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($products as $product)
                                    <tr>
                                        <td class="fw-bold">{{ $product->getId() }}</td>
                                        
                                        <!-- Nome do Produto -->
                                        <td>
                                            <div class="field-display-{{ $product->getId() }}-name">
                                                <strong>{{ $product->getName() }}</strong>
                                            </div>
                                            <div class="field-edit-{{ $product->getId() }}-name" style="display: none;">
                                                <input type="text" 
                                                       class="form-control form-control-sm" 
                                                       id="name-{{ $product->getId() }}"
                                                       value="{{ $product->getName() }}"
                                                       maxlength="255"
                                                       required>
                                            </div>
                                        </td>
                                        
                                        <!-- Descrição do Produto -->
                                        <td>
                                            <div class="field-display-{{ $product->getId() }}-description">
                                                <span class="text-muted">
                                                    {{ Str::limit($product->getDescription() ?? 'Sem descrição', 50) }}
                                                </span>
                                            </div>
                                            <div class="field-edit-{{ $product->getId() }}-description" style="display: none;">
                                                <textarea
                                                    class="form-control form-control-sm" 
                                                    id="description-{{ $product->getId() }}"
                                                    rows="2"
                                                    maxlength="500"
                                                    placeholder="Descrição do produto...">
                                                        {{ $product->getDescription() }}
                                                </textarea>
                                            </div>
                                        </td>
                                        
                                        <!-- Preço do Produto -->
                                        <td>
                                            <div class="field-display-{{ $product->getId() }}-price">
                                                <span class="price-badge">
                                                    R$ {{ number_format($product->getPrice(), 2, ',', '.') }}
                                                </span>
                                            </div>
                                            <div class="field-edit-{{ $product->getId() }}-price" style="display: none;">
                                                <div class="input-group input-group-sm">
                                                    <span class="input-group-text">R$</span>
                                                    <input type="number" 
                                                           class="form-control" 
                                                           id="price-{{ $product->getId() }}"
                                                           value="{{ $product->getPrice() }}"
                                                           min="0"
                                                           step="0.01"
                                                           required>
                                                </div>
                                            </div>
                                        </td>
                                        
                                        <!-- Quantidade/Estoque -->
                                        <td>
                                            <div class="field-display-{{ $product->getId() }}-quantity">
                                                <span class="badge {{ $product->getQuantity() <= 5 ? 'bg-danger' : 'bg-success' }} fs-6">
                                                    {{ $product->getQuantity() }} unidades
                                                </span>
                                            </div>
                                            <div class="field-edit-{{ $product->getId() }}-quantity" style="display: none;">
                                                <input type="number" 
                                                       class="form-control form-control-sm" 
                                                       id="quantity-{{ $product->getId() }}"
                                                       value="{{ $product->getQuantity() }}"
                                                       min="0"
                                                       style="max-width: 100px;"
                                                       required>
                                            </div>
                                        </td>
                                        
                                        <!-- Ações -->
                                        <td>
                                            <div class="action-buttons-{{ $product->getId() }}">
                                                <button type="button" 
                                                        class="btn btn-edit btn-sm"
                                                        onclick="editProduct('{{ $product->getId() }}')"
                                                        title="Editar produto">
                                                    <i class="bi bi-pencil"></i>
                                                    Editar
                                                </button>
                                            </div>
                                            <div class="edit-buttons-{{ $product->getId() }}" style="display: none;">
                                                <button type="button" 
                                                        class="btn btn-save btn-sm me-1"
                                                        onclick="saveProduct('{{ $product->getId() }}')"
                                                        title="Salvar alterações">
                                                    <i class="bi bi-check"></i>
                                                    Salvar
                                                </button>
                                                <button type="button" 
                                                        class="btn btn-cancel btn-sm"
                                                        onclick="cancelEdit('{{ $product->getId() }}')"
                                                        title="Cancelar edição">
                                                    <i class="bi bi-x"></i>
                                                    Cancelar
                                                </button>
                                            </div>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        @else
            <div class="card shadow-sm">
                <div class="card-body text-center py-5">
                    <i class="bi bi-inbox display-1 text-muted mb-3"></i>
                    <h4 class="text-muted mb-3">Nenhum produto encontrado</h4>
                    <p class="text-muted mb-4">
                        @if(request()->hasAny(['nameFilter', 'descriptionFilter', 'priceOrderFilter']))
                            Tente ajustar os filtros ou limpar a busca.
                        @else
                            Clique no botão "Sincronizar com API" para carregar produtos da Fake Store API.
                        @endif
                    </p>
                    <a href="{{ route('dashboard') }}" class="btn btn-primary-custom">
                        <i class="bi bi-arrow-clockwise me-2"></i>
                        Atualizar Página
                    </a>
                </div>
            </div>
        @endif
    </div>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL" crossorigin="anonymous"></script>

    <script src="{{ asset('js/dashboard.js') }}?v={{ time() }}"></script>
</body>
</html>
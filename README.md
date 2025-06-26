# Sobre a API

Esta API foi desenvolvida como teste técnico da O2 para realizar o cálculo do valor de boletos considerando:
- Multa por atraso
- Juros diários
- Juros de parcelamento (opcional)

### Requisitos

- PHP 8.0+
- Laravel 11
- Composer

# Instalando a API

1. Clone o repositório:

```bash
git clone https://github.com/caminha-gabriel/api-o2
cd api-o2
```

2. Instale as dependências:

```bash
composer install
```

3. Configure o ambiente:

```bash
cp .env.example .env
```

# Executando a API

Suba o servidor do Laravel:

```bash
php artisan serve
```

Obs. Por padrão, a API estará disponível em:

```
http://127.0.0.1:8000
```

# Estrutura Principal

```
app/
├── Http/
│   └── Controllers/
│       └── BoletoController.php
├── Services/
│   └── BoletoService.php
routes/
└── api.php
```

# Utilizando a API com o Postman

### Rota disponível

```
POST /api/calcular-boleto
```

### Exemplo de URL

```
http://127.0.0.1:8000/api/calcular-boleto
```

### Cabeçalhos (Headers)

```
Accept: application/json
Content-Type: application/json
```

# Exemplo de Uso

### Body da Requisição (JSON)

```json
{
  "valor": 500.00,
  "vencimento": "2024-06-01",
  "data_pagamento": "2024-06-23",
  "parcelas": 6
}
```

### Exemplo de Retorno Esperado

```json
{
    "valor_original": 500,
    "dias_em_atraso": 22,
    "multa": 10,
    "juros": 3.63,
    "valor_atualizado": 513.63,
    "parcelas": 6,
    "juros_parcelamento": 40.06,
    "valor_total_com_juros": 553.69,
    "valor_parcela": 92.28
}
```

# Consultoria Exato — correção dos links de post que dão 404

## O que foi diagnosticado (o ponto que fez o Codex falhar)

A arquitetura do site é assim:

| Endereço | O que é | Servidor |
|---|---|---|
| `consultoriaexato.com.br/` (raiz) | **Site principal** — **NÃO é WordPress** | Locaweb (Apache) |
| `consultoriaexato.com.br/blog/` | **O blog** — WordPress numa subpasta | WordPress |

Testes que comprovam:
- `raiz/wp-json/` → **404** (não há WordPress na raiz)
- `/blog/wp-json/` → **200** (WordPress só no /blog)
- `raiz/{slug-de-post}` → **404 com a página "Hospedagem Locaweb"** (Apache da raiz)

**Por isso um plugin WordPress NÃO resolve sozinho:** o plugin só roda quando
o WordPress carrega, e o WordPress só carrega em `/blog/`. As URLs que a
plataforma de SEO gera (`raiz/{slug}`) **nunca chegam no WordPress** — elas
morrem no Apache da raiz (404 da Locaweb) antes. Provavelmente foi isso que
travou as 2 tentativas no Codex: o redirect estava no lugar errado (dentro do
/blog em vez de na raiz).

## A correção correta

O redirect tem que ficar **na camada que enxerga as URLs da raiz**. Duas opções:

### Opção A — `.htaccess` da raiz  (recomendada)
Arquivo: `redirect-raiz-para-blog.htaccess` (neste projeto).

1. Acessar os arquivos do site principal (Painel Locaweb → Gerenciador de
   Arquivos, ou FTP) — pasta raiz do domínio (`public_html` / `www`).
2. Abrir o `.htaccess` da **raiz** (criar se não existir).
3. Colar o bloco do arquivo `redirect-raiz-para-blog.htaccess` logo depois de
   `RewriteEngine On`.
4. Salvar e testar (ver abaixo).

Regra aplicada: `raiz/{slug}` → **301** → `raiz/blog/{slug}/`

### Opção B — Regra de Redirect no Cloudflare  (se não tiver acesso aos arquivos)
O domínio está atrás do Cloudflare (`Server: cloudflare`). Dá pra fazer no edge,
sem tocar em arquivo:

- Cloudflare → **Rules → Redirect Rules → Create rule**
- **When incoming requests match** (usar *Custom filter expression*, campo *edit expression*):
  ```
  (http.request.uri.path matches "^/[^/.]+/?$" and not starts_with(http.request.uri.path, "/blog") and not starts_with(http.request.uri.path, "/wp-"))
  ```
- **Then... URL redirect → Dynamic**, expressão:
  ```
  concat("https://consultoriaexato.com.br/blog", http.request.uri.path)
  ```
  Status code: **301** · Preserve query string: ligado.

## Como testar depois de aplicar
```bash
# Deve responder 301 com Location: .../blog/o-que-e-pgrs.../
curl -sI "https://consultoriaexato.com.br/o-que-e-pgrs-plano-de-gerenciamento-de-residuos-solidos"

# A home NÃO pode ser afetada (tem que continuar 200)
curl -sI "https://consultoriaexato.com.br/"
```

## Observações
- É **301 (permanente)**: bom para SEO, transfere autoridade do link.
- O alvo já vai com barra final (`/blog/{slug}/`) para bater na URL canônica do
  WordPress e evitar redirect duplo.
- Só mexe em caminhos de 1 segmento sem ponto (slug). Arquivos reais, imagens,
  `/blog` e `/wp-*` ficam intactos.
- O ideal complementar é pedir para a plataforma de SEO gerar os links já com
  `/blog/` — o redirect resolve os que já saíram errados e os futuros, mas
  corrigir na origem evita o hop extra.

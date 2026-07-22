---
layout: default
title: Pedido de ajuste para quem tem acesso
---

# Pedido de ajuste — redirect de links de post (Consultoria Exato)

> Mensagem pronta para enviar a quem tem acesso à **hospedagem Locaweb** (arquivos
> da raiz do domínio) **ou** ao painel do **Cloudflare**. Escolha UMA das duas opções.

---

## Contexto (para explicar o pedido)

O blog fica em `consultoriaexato.com.br/blog/` (WordPress). A ferramenta de SEO está
gerando links internos apontando para a **raiz** do domínio
(`consultoriaexato.com.br/{nome-do-post}`) em vez de `/blog/{nome-do-post}`. Como
não existe nada nesse endereço na raiz, esses links caem em **404** (a página
padrão "Hospedagem Locaweb"). Isso prejudica SEO e a navegação.

A correção é um **redirect 301** de `raiz/{nome-do-post}` → `/blog/{nome-do-post}/`.
Ela **precisa ser aplicada na raiz do domínio ou no Cloudflare** — não é possível
fazer de dentro do WordPress, porque essas URLs nunca chegam ao WordPress (elas
morrem no servidor da raiz antes).

---

## Opção A — Locaweb (arquivo `.htaccess` da raiz)

1. Entrar no **Painel Locaweb → Hospedagem → Gerenciador de Arquivos** (ou por FTP).
2. Ir na **pasta raiz do site** (geralmente `public_html` ou `www` — onde fica o
   site principal; a pasta `blog` deve estar visível dentro dela).
3. Abrir o arquivo **`.htaccess`** dessa pasta raiz (se não existir, criar um).
4. Colar o bloco abaixo **logo depois** da linha `RewriteEngine On`
   (se já houver redirect de HTTPS/www, colar **depois** deles):

```apache
<IfModule mod_rewrite.c>
  RewriteEngine On

  # Redireciona URLs de post geradas na raiz para /blog/
  RewriteCond %{REQUEST_FILENAME} !-f
  RewriteCond %{REQUEST_FILENAME} !-d
  RewriteCond %{REQUEST_URI} !^/blog(/|$)  [NC]
  RewriteCond %{REQUEST_URI} !^/wp-        [NC]
  RewriteRule ^([^/.]+)/?$ /blog/$1/ [R=301,L]
</IfModule>
```

5. Salvar.

---

## Opção B — Cloudflare (sem tocar em arquivo)

1. Cloudflare → domínio `consultoriaexato.com.br` → **Rules → Redirect Rules →
   Create rule**.
2. **When incoming requests match** → *edit expression*:
   ```
   (http.request.uri.path matches "^/[^/.]+/?$" and not starts_with(http.request.uri.path, "/blog") and not starts_with(http.request.uri.path, "/wp-"))
   ```
3. **Then → URL redirect → Dynamic**, expressão:
   ```
   concat("https://consultoriaexato.com.br/blog", http.request.uri.path)
   ```
   Status: **301** · Preserve query string: **ligado**.
4. **Deploy**.

---

## Teste (depois de aplicar qualquer uma das opções)

Abrir no navegador ou rodar:
```
curl -sI "https://consultoriaexato.com.br/o-que-e-pgrs-plano-de-gerenciamento-de-residuos-solidos"
```
Tem que responder **301** com `Location: https://consultoriaexato.com.br/blog/o-que-e-pgrs-plano-de-gerenciamento-de-residuos-solidos/`.

E a home tem que continuar normal (200):
```
curl -sI "https://consultoriaexato.com.br/"
```
